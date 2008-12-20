<?php
/*---------------------------------------------------------------------+
| ExiteCMS Content Management System                                   |
+----------------------------------------------------------------------+
| Copyright 2006-2008 Exite BV, The Netherlands                        |
| for support, please visit http://www.exitecms.org                    |
+----------------------------------------------------------------------+
| Some code derived from PHP-Fusion, copyright 2002 - 2006 Nick Jones  |
+----------------------------------------------------------------------+
| Released under the terms & conditions of v2 of the GNU General Public|
| License. For details refer to the included gpl.txt file or visit     |
| http://gnu.org                                                       |
+----------------------------------------------------------------------+
| $Id::                                                               $|
+----------------------------------------------------------------------+
| Last modified by $Author::                                          $|
| Revision number $Rev::                                              $|
+---------------------------------------------------------------------*/
require_once dirname(__FILE__)."/../../includes/core_functions.php";

// load the locale for this module
locale_load("modules.donations");

// function to process the payment or the refund
function process_payment($payer_name, $comment, $subject) {
	global $logmsg, $locale, $db_prefix, $settings;

	// if the payment is completed, write to the database
	$result = dbquery("INSERT INTO ".$db_prefix."donations (donate_name, donate_amount, donate_currency, donate_country, donate_comment, donate_timestamp) 
		VALUES ('".$payer_name."', '".$_POST['mc_gross']."', '".$_POST['mc_currency']."', '".$_POST['residence_country']."', '".$comment."', '".strtotime($_POST['payment_date'])."')");

	// if notification is requested, post a notify message
	if ($settings['donate_forum_id']) {

		// make sure we use the same timestamp for all updates
		$posttime = time();

		// check if the paypal thread exists. If not, create it
		$result = dbquery("SELECT * FROM ".$db_prefix."threads WHERE forum_id = '".$settings['donate_forum_id']."' AND thread_subject = '".$locale['don491']."'");
		if (dbrows($result)) {
			$data = dbarray($result);
			$thread_id = $data['thread_id'];
			// update the last post time of this thread
			$result = dbquery("UPDATE ".$db_prefix."threads SET thread_lastpost = '".$posttime."' WHERE thread_id = '".$thread_id."'");
		} else {
			// add if there wasn't any previous thread
			$result = dbquery("INSERT INTO ".$db_prefix."threads (forum_id, thread_subject, thread_author, thread_sticky, thread_locked, thread_lastpost, thread_lastuser)
								VALUES ('".$settings['donate_forum_id']."', '".$locale['don491']."', '0', '1', '1', '".$posttime."', '0')");
			$thread_id = mysql_insert_id();
		}
		// compose the paypal post
		$message = "[b]".$locale['don456']."[/b] : ".trim($_POST['first_name'])." ".trim($_POST['last_name'])."\n";
		$message .= "[b]".$locale['don463']."[/b] : ".$_POST['residence_country']."\n";
		$message .= "[b]".$locale['don455']."[/b] : ".$_POST['payment_date']."\n";
		$message .= "[b]".$locale['don457']."[/b] : ".$_POST['mc_currency']." ".$_POST['mc_gross']."\n";
		$message .= "[b]".$locale['don464']."[/b] : ".$_POST['payer_email']."\n";
		$message .= "[b]".$locale['don458']."[/b] : ".$comment."\n";
		if ($payer_name == "") {
			$message .= "\n[b]".$locale['don498']."[/b]";
		}
		$result = dbquery("INSERT INTO ".$db_prefix."posts (forum_id, thread_id, post_subject, post_message, post_author, post_datestamp, post_ip)
							VALUES ('".$settings['donate_forum_id']."', '".$thread_id."', '".$subject."', '".$message."', '0', '".$posttime."', '0.0.0.0')");
		$post_id = mysql_insert_id();
	}

	$logmsg .= "\n\n~~~~ PROCESSED: PAYMENT STATUS = ".strtoupper($_POST['payment_status'])." ~~~~";
}

// *** main ***

// donation log file
$log = PATH_MODULES.'donations/paypal_payments.log';
// activate the logging
$logthis = true;

// check if we're running in development. If so, switch to Paypal sandbox
if ($settings['donate_use_sandbox']) {
	$sandbox = true;
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
				if (isset($_POST['option_selection1']) && $_POST['option_selection1']=='Mention my name') {
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
							$comment = $locale['don460'];
						process_payment($payer_name, phpentities($comment), $locale['don480']);
						break;
					case "Refunded":
						// if the payment is refunded, record the refund
						$refund_reason = isset($_POST['memo']) ? $_POST['memo'] : $locale['donerr01'];
						process_payment($payer_name, phpentities($refund_reason), $locale['don482']);
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
