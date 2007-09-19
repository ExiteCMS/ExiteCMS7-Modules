<?php
/*---------------------------------------------------+
| PLi-Fusion Content Management System               |
+----------------------------------------------------+
| Copyright 2007 WanWizard (wanwizard@gmail.com)     |
| http://www.pli-images.org/pli-fusion               |
+----------------------------------------------------+
| Some portions copyright ? 2002 - 2006 Nick Jones   |
| http://www.php-fusion.co.uk/                       |
| Released under the terms & conditions of v2 of the |
| GNU General Public License. For details refer to   |
| the included gpl.txt file or visit http://gnu.org  |
+----------------------------------------------------*/
require_once dirname(__FILE__)."/../../includes/core_functions.php";

// function to update the unread flags
function update_unread($forum_id, $thread_id, $post_id) {
        global $db_prefix, $userdata;

        // make sure we have all required info
        if ($forum_id == 0 || $thread_id == 0 || $post_id == 0) return false;

        // flag the post as unread for all users that have read access to this forum
        // get the access group number for this forum
        $result = dbquery("SELECT forum_access from ".$db_prefix."forums WHERE forum_id = ".$forum_id);
        $data = dbarray($result);
        $group_id = $data['forum_access'];
        // check for group inheritance
        global $groups; $groups = array();
        getgroupmembers($group_id);
        // select all users that are a member of this forum access group
        $result = dbquery("SELECT user_id, user_name, user_groups, user_level from ".$db_prefix."users");
        if (dbrows($result)) {
                while ($data = dbarray($result)) {
                        $insert = false;
                        // if the group is public, or it is a builtin group and user has higher-or-equal system rights, insert an unread record
                        if ($group_id == 0 or ($group_id > 100 and $data['user_level'] >= $group_id)) {
                                $insert = true;
                        } else {
                                // otherwise, check for group membership for this user
                                foreach ($groups as $group) {
                                        if (preg_match("(^\.{$group}|\.{$group}\.|\.{$group}$)", $data['user_groups'])) {
                                                $insert = true;
                                                break;
                                        }
                                }
                        }
                        // if the user has access to this post, flag it as unread for this user
                        if ($insert) {
                                $result2 = dbquery("INSERT IGNORE INTO ".$db_prefix."posts_unread (user_id, forum_id, thread_id, post_id, post_time) VALUES(".$data['user_id'].", ".$forum_id.", ".$thread_id.", ".$post_id.", ".time().")", false);
                        }

                }
        }
        return true;
}

// function to process the payment or the refund
function process_payment($payer_name, $comment, $subject) {
	global $logmsg, $locale, $db_prefix, $settings;

	// if the payment is completed, write to the database
	$result = dbquery("INSERT INTO ".$db_prefix."donations (donate_name, donate_amount, donate_currency, donate_country, donate_comment, donate_timestamp) 
		VALUES ('".$payer_name."', '".$_POST['mc_gross']."', '".$_POST['mc_currency']."', '".$_POST['residence_country']."', '".$comment."', '".strtotime($_POST['payment_date'])."')");

	// if notification is requested, post a notify message
	if ($settings['donate_forum_id']) {

		// check if the paypal thread exists. If not, create it
		$result = dbquery("SELECT * FROM ".$db_prefix."threads WHERE forum_id = '".$settings['donate_forum_id']."' AND thread_subject = '".$locale['don453']."'");
		if (dbrows($result)) {
			$data = dbarray($result);
			$thread_id = $data['thread_id'];
		} else {
			// add if there wasn't any previous thread
			$result = dbquery("INSERT INTO ".$db_prefix."threads (forum_id, thread_subject, thread_author, thread_sticky, thread_locked, thread_lastpost, thread_lastuser)
								VALUES ('".$settings['donate_forum_id']."', '".$locale['don453']."', '0', '1', '1', '".time()."', '0')");
			$thread_id = mysql_insert_id();
		}
		// compose the paypal post
		$message = "[b]".$locale['don212']."[/b] : ".trim($_POST['first_name'])." ".trim($_POST['last_name'])."\n";
		$message .= "[b]".$locale['don219']."[/b] : ".$_POST['residence_country']."\n";
		$message .= "[b]".$locale['don211']."[/b] : ".$_POST['payment_date']."\n";
		$message .= "[b]".$locale['don213']."[/b] : ".$_POST['mc_currency']." ".$_POST['mc_gross']."\n";
		$message .= "[b]".$locale['don220']."[/b] : ".$_POST['payer_email']."\n";
		$message .= "[b]".$locale['don214']."[/b] : ".$comment."\n";
		if ($payer_name == "") {
			$message .= "\n[b]".$locale['don464']."[/b]";
		}
		$result = dbquery("INSERT INTO ".$db_prefix."posts (forum_id, thread_id, post_subject, post_message, post_author, post_datestamp, post_ip)
							VALUES ('".$settings['donate_forum_id']."', '".$thread_id."', '".$subject."', '".$message."', '0', '".time()."', '0.0.0.0')");
		$post_id = mysql_insert_id();
		update_unread($settings['donate_forum_id'], $thread_id, $post_id);
	}

	$logmsg .= "\n\n~~~~ PROCESSED: PAYMENT STATUS = ".strtoupper($_POST['payment_status'])." ~~~~";
}

// *** main ***

if (file_exists(PATH_MODULES."donations/locale/".$settings['locale'].".php")) {
	include PATH_MODULES."donations/locale/".$settings['locale'].".php";
} else {
	include PATH_MODULES."donations/locale/English.php";
}

// donation log file
$log = PATH_MODULES.'donations/paypal_payments.log';
// activate the logging
$logthis = true;

// check if we're running in development. If so, switch to Paypal sandbox
if ($_SERVER['HTTP_HOST'] != "www.pli-images.org") {
	$danbox = true;
	$verify_url = 'www.sandbox.paypal.com';
} else {
	$sandbox = false;
	$verify_url = 'www.paypal.com';
}

// read the message from PayPal, and add the notify 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

// Send it back to PayPal for validation
$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ($verify_url, 80, $errno, $errstr, 30);

$logmsg = "/------------------------------------------------------------------- \n";
$logmsg .= "/--- Payment logged: ".date('l, d M Y @ H:i:s')." \n";
$logmsg .= "/------------------------------------------------------------------- \n";

// Process the verification 

$errcnt = 0;
while ($errcnt++ < 5) {
	// loop trough the notify process, in case it fails a few times...
	if (!$fp) {
		// HTTP-error
		$logmsg .= "\n\n**** HTTP ERROR when trying to connect to PayPal for verification ***";
		sleep (2);
	} else {
		fputs ($fp, $header . $req);
		while (!feof($fp)) {
			$res = fgets ($fp, 1024);
			$logmsg .= $res;
			if (strcmp ($res, "VERIFIED") == 0) {
				// get a name
				if ($_POST['option_selection1']=='Mention my name') {
					if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
						$payer_name = trim($_POST['first_name'])." ".trim($_POST['last_name']);
					} else {
						if (isset($_POST['address_name'])) {
							$payer_name = $_POST['address_name'];
						} else {
							$payer_name = ""; // no name fields present in the SOAP post
						} 
					}
				} else {
					$payer_name = "";	// anonymous
				}
				// process the notification, depending on the payment status
				switch ($_POST['payment_status']) {
					case "Completed":
						if (isset($_POST['option_selection2']) && $_POST['option_selection2'] != "")
							$comment = $_POST['option_selection2'];
						else
							$comment = $locale['don216'];
						process_payment($payer_name, phpentities($comment), $locale['don426']);
						break;
					case "Refunded":
						// if the payment is refunded, record the refund
						$refund_reason = isset($_POST['memo']) ? $_POST['memo'] : $locale['don480'];
						process_payment($payer_name, phpentities($refund_reason), $locale['don428']);
						break;
					default:
						$logmsg .= "\n\n**** NOT PROCESSED: PAYMENT STATUS = ".strtoupper($_POST['payment_status'])." ****";
				}
				
				if ($_POST['payment_status']=='Completed') {
				} else {
				}
			} else {
				if (strcmp ($res, "INVALID") == 0) {
					$logthis = true;
				}
			}
		}
		fclose ($fp);
		break;
	}
}
$logmsg .= "\n\n/------------------------------------------------------------------- \n";
$logmsg .= print_r($_POST, true);
$logmsg .= "/=================================================================== \n\n";
if ($logthis) {
	$handle = fopen($log, 'a');
	fwrite($handle, $logmsg);
	fclose($handle);
}
?>