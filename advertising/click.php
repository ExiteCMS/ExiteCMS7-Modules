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

// get the requested ad from the database
$result = dbquery("SELECT * FROM ".$db_prefix."advertising where adverts_id = '".$id."'");
if(dbrows($result)) {
	$row = dbarray($result);
	// update the hit (don't count the clients own hits!)
	if (!isset($userdata['user_id']) || $userdata['user_id'] != $row['adverts_userid']) {
		dbquery("UPDATE ".$db_prefix."advertising SET adverts_clicks=adverts_clicks+1 where adverts_id='".$id."'");
	}
}
// click recorded, redirect back to the previous page
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "") {
	header("Location:".$_SERVER['HTTP_REFERER']);
} else {
	header("Location:".BASEDIR."index.php");
}
exit;
?>
