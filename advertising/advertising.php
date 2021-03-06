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
require_once PATH_ROOT."/includes/theme_functions.php";

// temp storage for template variables
$variables = array();

// load the locale for this panel
locale_load("modules.advertising");

// advertisement location and type. 
$ad_locations = array(0 => $locale['ads450'], 1 => $locale['ads451'], 2 => $locale['ads452'], 3 => $locale['ads453'], 4 => $locale['ads454'], 5 => $locale['ads455']);
asort($ad_locations);	// sort the locations alphabetically

// maximum dimensions for each advertisement location
$ad_dimensions = array(0 => "160x65", 1 => "468x60", 2 => "468x60", 3 => "468x60");

// contract information
$contract_types = array(0 => $locale['ads430'], 1 => $locale['ads431'], 2 => $locale['ads432']);

// initialize the flags used in the template
$is_client = false;
$is_updated = false;
$errormessage = "";

if (iMEMBER) {
	// check if this member is a client
	$result = dbquery("SELECT * FROM ".$db_prefix."users WHERE user_id = '".$userdata['user_id']."' AND user_sponsor = '1'");
	if (dbrows($result) != 0) {
		$is_client = true;
		$result = dbquery("SELECT * FROM ".$db_prefix."advertising WHERE adverts_userid = '".$userdata['user_id']."' LIMIT 1");
		if (dbrows($result) != 0) {
			// update advertisement URL
			if (isset($_POST['change'])) {
				$adverts_url = $_POST['adverts_url'];
				$result = dbquery("UPDATE ".$db_prefix."advertising SET adverts_url = '".$adverts_url."' WHERE adverts_id = '".$id."'");
				$is_updated = true;
			}
			// email statistics
			if (isset($_POST['email'])) {
				// initialize PHPmailer
				require_once PATH_INCLUDES."class.phpmailer.php";
				$mail = new PHPMailer();
				if (file_exists(PATH_INCLUDES."languages/phpmailer.lang-".$settings['PHPmailer_locale'].".php")) {
					$mail->SetLanguage($settings['PHPmailer_locale'], PATH_INCLUDES."language/");
				} else {
					$mail->SetLanguage("en", PATH_INCLUDES."language/");
				}
				if ($settings['smtp_host']=="") {
					$mail->IsMAIL();
				} else {
					$mail->IsSMTP();
					$mail->Host = $settings['smtp_host'];
					$mail->Username = $settings['smtp_username'];
					$mail->Password = $settings['smtp_password'];
					if ($settings['smtp_username'] != "" && $settings['smtp_password'] != "")
						$mail->SMTPAuth = true;
				}
				$mail->CharSet = $settings['charset'];
				$mail->From = $settings['siteemail'];
				$mail->FromName = $settings['siteusername'];
				$mail->AddAddress($userdata['user_email'], $userdata['user_name']);
				$mail->AddReplyTo($settings['siteemail'], $settings['siteusername']);
				$mail->IsHTML($userdata['user_newsletters'] != 2);

				// Build the message body
				if ($id == "all") {
					$result = dbquery("SELECT * FROM ".$db_prefix."advertising WHERE adverts_userid = '".$userdata['user_id']."' ORDER BY adverts_contract_start");
					$subject = $locale['ads510'];
				} else {
					$result = dbquery("SELECT * FROM ".$db_prefix."advertising WHERE adverts_userid = '".$userdata['user_id']."' AND adverts_id = '$id'");
					$subject = sprintf($locale['ads511'], $id);
				}
				// get the number of priority codes used.
				$result2 = dbquery("SELECT DISTINCT adverts_priority FROM ".$db_prefix."advertising");
				$prio_count = dbrows($result2);
				$html_body = "<font face='sans_serif'>".sprintf($locale['ads512'],showdate('longdate', time()))."<br><br>";
				$text_body = sprintf($locale['ads512'],showdate('longdate', time()))."\r\n";
				if (dbrows($result)) {
					while ($data = dbarray($result)) {
						// open table
						$html_body .= "<table width='500' cellspacing='0' cellpadding='0' border='0'>\r\n";
						$text_body .= str_repeat("-",80)."\r\n";
						// advert ID
						$html_body .= "<tr><td width='1%' style='white-space:nowrap'>".$locale['ads460']."</td><td>: ".$data['adverts_id']."</td></tr>\r\n";
						$text_body .= str_pad($locale['ads460'],25).": ".$data['adverts_id']."\r\n";
						// advert location
						$html_body .= "<tr><td width='1%' style='white-space:nowrap'>".$locale['ads462']."</td><td>: ".$ad_locations[$data['adverts_location']]."</td></tr>\r\n";
						$text_body .= str_pad($locale['ads462'],25).": ".$ad_locations[$data['adverts_location']]."\r\n";
						// only report priority if it's being used
						if ($prio_count > 1) {
							$html_body .= "<tr><td width='1%' style='white-space:nowrap'>".$locale['ads424']."</td><td>: ".$data['adverts_priority']."</td></tr>\r\n";
							$text_body .= str_pad($locale['ads424'],25).": ".$data['adverts_priority']."\r\n";
						}
						// contract type
						$html_body .= "<tr><td width='1%' style='white-space:nowrap'>".$locale['ads411']."</td><td>: ".$contract_types[$data['adverts_contract']]."</td></tr>\r\n";
						$text_body .= str_pad($locale['ads411'],25).": ".$contract_types[$data['adverts_contract']]."\r\n";
						switch ($data['adverts_contract']) {
							case 0:
								break;
							case 1:
								$html_body .= "<tr><td width='1%' style='white-space:nowrap'></td><td>: ".$locale['ads412'].": ".showdate('shortdate',$data['adverts_contract_start']);
								$text_body .= "&nbsp;- ".str_pad($locale['ads412'],23).": ".showdate('shortdate',$data['adverts_contract_start'])."\r\n";
								if ($data['adverts_contract_end']) {
									$html_body .= "<tr><td width='1%' style='white-space:nowrap'></td><td>: ".$locale['ads413'].": ".showdate('shortdate',$data['adverts_contract_end']);
									$text_body .= "&nbsp;- ".str_pad($locale['ads413'],23).": ".showdate('shortdate',$data['adverts_contract_end'])."\r\n";
								}
								break;
							case 2:
								$html_body .= "<tr><td width='1%' style='white-space:nowrap'></td><td>: ".$locale['ads414'].": ".$data['adverts_sold'];
								$text_body .= "- ".str_pad($locale['ads414'],23).": ".$data['adverts_sold']."\r\n";
								$html_body .= "<tr><td width='1%' style='white-space:nowrap'></td><td>: ".$locale['ads413'].": ".$data['adverts_sold']-$data['adverts_shown'];
								$text_body .= "- ".str_pad($locale['ads413'],23).": ".$data['adverts_sold']-$data['adverts_shown']."\r\n";
								break;
						}
						
						// number of advert display requests
						$html_body .= "<tr><td width='1%' style='white-space:nowrap'>".$locale['ads479']."</td><td>: ".$data['adverts_shown']."</td></tr>\r\n";
						$text_body .= str_pad($locale['ads479'],25).": ".$data['adverts_shown']."\r\n";
						// number of user clicks
						$html_body .= "<tr><td width='1%' style='white-space:nowrap'>".$locale['ads464']."</td><td>: ".$data['adverts_clicks']."</td></tr>\r\n";
						$text_body .= str_pad($locale['ads464'],25).": ".$data['adverts_clicks']."\r\n";
						// precentage clicks
						$percent = $data['adverts_shown'] == 0 ? 0 : substr(100 * $data['adverts_clicks'] / $data['adverts_shown'], 0, 5);
						$html_body .= "<tr><td width='1%' style='white-space:nowrap'>".$locale['ads465']."</td><td>: ".$percent." %</td></tr>\r\n";
						$text_body .= str_pad($locale['ads465'],25).": ".$percent." %\r\n";
						// advert image displayed
						$ad_image = substr($data['adverts_image'],0,strlen($userdata['user_name'])) == $userdata['user_name'] ? substr($data['adverts_image'],strlen($userdata['user_name'])+1) : $data['adverts_image'];
						$html_body .= "<tr><td width='1%' style='white-space:nowrap'>".$locale['ads417']."</td><td>: ".$ad_image."</td></tr>\r\n";
						$text_body .= str_pad($locale['ads417'],25).": ".$ad_image."\r\n";
						// advert URL link
						$html_body .= "<tr><td width='1%' style='white-space:nowrap'>".$locale['ads418']."</td><td>: ".$data['adverts_url']."</td></tr>\r\n";
						$text_body .= str_pad($locale['ads418'],25).": ".$data['adverts_url']."\r\n";
						// end of table
						$html_body .= "</table><br><hr><br>";
						$text_body .= str_repeat("-",80)."\r\n\r\n";
					}
					$mail->Subject = $subject;
					if ($userdata['user_newsletters'] == 2) {
					$mail->Body = $text_body;
					} else {
						$mail->Body = $html_body;
						$mail->AltBody = $text_body;
					}
					if(!$mail->Send()) {
						$error = $mail->ErrorInfo;
						$mail->ClearAllRecipients();
						$mail->ClearReplyTos();
					} else {
						$error = "";
						$mail->ClearAllRecipients(); 
						$mail->ClearReplyTos();
					}
					if ($error != "") {
						$errormessage = $error;
					} elseif ($id == "all") {
						$errormessage = $locale['ads953'];
					} else {
						$errormessage = sprintf($locale['ads952'], $id);
					}
				} else {
					opentable($locale['ads500']);
					echo "<div align='center'>\n<br /><b>".$locale['ads901']."</b><br /><br />\n</div>\n";
					closetable();
				}
			}
			// current ad statistics panel
			$ads1 = array();
			$result = dbquery("SELECT * FROM ".$db_prefix."advertising WHERE adverts_userid = '".$userdata['user_id']."' AND adverts_expired = '0' ORDER BY adverts_id DESC");
			while ($data = dbarray($result)) {
				$result2 = dbquery("SELECT user_name FROM ".$db_prefix."users WHERE user_id = '".$data['adverts_userid']."'");
				$data2 = dbarray($result2);
				$data['user_name'] = $data2['user_name'];
				if ($data['adverts_shown'] == 0)
					$percent = 0;
				else
					$percent = substr(100 * $data['adverts_clicks'] / $data['adverts_shown'], 0, 5);
				$data['percentage'] = $percent;
				$contract_type = $contract_types[$data['adverts_contract']];
				switch ($data['adverts_contract']) {
					case 0:
						break;
					case 1:
						if ($data['adverts_contract_start'] > time()) {
							$contract_type .= " (".$locale['ads472']." ".showdate("%d-%m-%Y", $data['adverts_contract_start']).")";
						} elseif ($data['adverts_contract_end'] != 0) {
							$contract_type .= " (".$locale['ads471']." ".showdate("%d-%m-%Y", $data['adverts_contract_end']).")";
						} else {
							$contract_type .= " (".$locale['ads478'].")";
						}
						break;
					case 2:
						$contract_type .= " (".($data['adverts_sold']-$data['adverts_shown'])." ".$locale['ads477'].")";
						break;
				}
				$data['contract_type'] = $contract_type;
				$adverts_url = $data['adverts_url'];
				if(strtolower(substr($adverts_url,0,7)) != "http://" && strtolower(substr($adverts_url,0,8)) != "https://") {
					// if not add it (assume http://)
					$adverts_url = "http://" . $adverts_url;
				} 
				$data['adverts_url'] = $adverts_url;
				$data['ad_location'] = $ad_locations[$data['adverts_location']];
				$ads1[] = $data;
			}
			$variables['ads1'] = $ads1;
			
			// expired ad statistics panel
			$ads2 = array();
			$result = dbquery("SELECT * FROM ".$db_prefix."advertising WHERE adverts_userid = '".$userdata['user_id']."' AND adverts_expired = '1' ORDER BY adverts_id DESC");
			while ($data = dbarray($result)) {
				$result2 = dbquery("SELECT user_name FROM ".$db_prefix."users WHERE user_id = '".$data['adverts_userid']."'");
				$data2 = dbarray($result2);
				if ($data['adverts_shown'] == 0)
					$percent = 0;
				else
					$percent = substr(100 * $data['adverts_clicks'] / $data['adverts_shown'], 0, 5);
				$data['percentage'] = $percent;
				$contract_type = $contract_types[$data['adverts_contract']];
				switch ($data['adverts_contract']) {
					case 0:
						break;
					case 1:
						if ($data['adverts_contract_start'] > time()) {
							$contract_type .= " (".$locale['ads472']." ".showdate("%d-%m-%Y", $data['adverts_contract_start']).")";
						} elseif ($data['adverts_contract_end'] != 0) {
							$contract_type .= " (".$locale['ads471']." ".showdate("%d-%m-%Y", $data['adverts_contract_end']).")";
						} else {
							$contract_type .= " (".$locale['ads478'].")";
						}
						break;
					case 2:
						$contract_type .= " (".($data['adverts_sold']-$data['adverts_shown'])." ".$locale['ads477'].")";
						break;
				}
				$data['contract_type'] = $contract_type;
				$adverts_url = $data['adverts_url'];
				if(strtolower(substr($adverts_url,0,7)) != "http://" && strtolower(substr($adverts_url,0,8)) != "https://") {
					// if not add it (assume http://)
					$adverts_url = "http://" . $adverts_url;
				} 
				$data['adverts_url'] = $adverts_url;
				$data['ad_location'] = $ad_locations[$data['adverts_location']];
				$ads2[] = $data;
			}
			$variables['ads2'] = $ads2;
		}
	}
}

// store the variables used for this template
$variables['is_client'] = $is_client;
$variables['is_updated'] = $is_updated;
$variables['errormessage'] = $errormessage;

// define the body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'modules.advertising', 'template' => 'modules.advertising.tpl', 'locale' => "modules.advertising");
$template_variables['modules.advertising'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
