<?php
/*---------------------------------------------------+
| ExiteCMS Content Management System                 |
+----------------------------------------------------+
| Copyright 2007 Harro "WanWizard" Verton, Exite BV  |
| for support, please visit http://exitecms.exite.eu |
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the |
| GNU General Public License. For details refer to   |
| the included gpl.txt file or visit http://gnu.org  |
+----------------------------------------------------*/
if (!checkrights("I") || !defined("iAUTH") || $aid != iAUTH || !defined('INIT_CMS_OK')) fallback(BASEDIR."index.php");

/*---------------------------------------------------+
| Module identification                              |
+----------------------------------------------------*/
$mod_title = "Download Statistics";
$mod_description = "Gather and display download statistics from download mirror logs. includes a Google Map with downloaders per country";
$mod_version = "1.1.2";
$mod_developer = "WanWizard";
$mod_email = "wanwizard@gmail.com";
$mod_weburl = "http://exitecms.exite.eu/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "download_statistics";
$mod_admin_image = "dlstats.gif";
$mod_admin_panel = "admin.php";
$mod_admin_rights = "wS";
$mod_admin_page = 4;

/*---------------------------------------------------+
| Version and revision control                       |
+----------------------------------------------------*/

// check for a minumum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) < 710) {
	$mod_errors .= sprintf($locale['mod001'], '7.10');
}
// check for a maximum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) > 720) {
	$mod_errors .= sprintf($locale['mod002'], '7.20');
}
// check for a specific revision number range that is supported
if ($settings['revision'] < 0 || $settings['revision'] > 999999) {
	$mod_errors .= sprintf($locale['mod003'], 0, 999999);
}

/*---------------------------------------------------+
| Menu entries for this module                       |
+----------------------------------------------------*/

$mod_site_links = array();
$mod_site_links[] = array('name' => 'GeoMap', 'url' => 'geomap.php', 'panel' => '', 'visibility' => 101);

/*---------------------------------------------------+
| Report entries for this module                     |
+----------------------------------------------------*/

$mod_report_links = array();
$mod_report_links[] = array('name' => "topfiles", 'title' => "dls800", 'version' => "1.0.0", 'visibility' => 102);

/*---------------------------------------------------+
| Search entries for this module                     |
+----------------------------------------------------*/

$mod_search_links = array();
$mod_search_links[] = array('name' => "files", 'title' => "dls850", 'version' => "1.0.0", 'visibility' => 102);

/*---------------------------------------------------+
| locale strings for this module                     |
+----------------------------------------------------*/

$localestrings = array();
$localestrings['en'] = array();
$localestrings['en']['dls110'] = "The Download Statistics module is not installed. You have to do this before starting the download statistics processor";
// Geo Mapping using Google Maps panel
$localestrings['en']['dls400'] = "Geographical dispersion of users";
// Admin panel
$localestrings['en']['dls500'] = "Download Statistics Configuration";
$localestrings['en']['dls501'] = "GeoMap filename match regex:";
$localestrings['en']['dls502'] = "IP addresses of downloaded files that match the regex will be added to the GeoMap. Blank matches ALL files!";
$localestrings['en']['dls503'] = "Location of the log files:";
$localestrings['en']['dls504'] = "Path is relative to the docroot. Start with a / to use an absolute path";
$localestrings['en']['dls505'] = "Save";
$localestrings['en']['dls506'] = "No";
$localestrings['en']['dls507'] = "Yes";
$localestrings['en']['dls508'] = "Update download counters:";
$localestrings['en']['dls509'] = "If No, only downloads from the download pages are counted. If Yes, the batch program 'get_statistics.php' will update the counters";
$localestrings['en']['dls510'] = "Access to download statistics for:";
$localestrings['en']['dls511'] = "Google Maps API key:";
$localestrings['en']['dls512'] = "Click <a href='http://code.google.com/apis/maps/signup.html' target='_blank'>here</a> to sign up for a key.";
$localestrings['en']['dls513'] = "Download Statistics Panel Title";
$localestrings['en']['dls514'] = "Used as title of the statistics panel. You can use %s as a placeholder for the total download count";
// Statistics counter panel
$localestrings['en']['dls600'] = "Download Statistics Panel";
$localestrings['en']['dls601'] = "Short Name";
$localestrings['en']['dls602'] = "Order";
$localestrings['en']['dls603'] = "Options";
$localestrings['en']['dls604'] = "There are no statistics counter entries defined at the moment";
$localestrings['en']['dls605'] = "Add";
$localestrings['en']['dls606'] = "Move this entry up";
$localestrings['en']['dls607'] = "Move this entry down";
$localestrings['en']['dls608'] = "Edit this statistics entry";
$localestrings['en']['dls609'] = "Delete this statistics entry";
$localestrings['en']['dls610'] = "Name:";
$localestrings['en']['dls611'] = "Description:";
$localestrings['en']['dls612'] = "Get the count from this download item:";
$localestrings['en']['dls613'] = "Use the counters from these download files:";
$localestrings['en']['dls614'] = "Save";
$localestrings['en']['dls615'] = "These are the files currently downloaded. Click on a filename to add it to the list:";
$localestrings['en']['dls616'] = "Download Statistics Counter";
// Messages: reports
$localestrings['en']['dls800'] = "Top files downloaded";
$localestrings['en']['dls801'] = "Filenames filter";
$localestrings['en']['dls802'] = "This filter is a regexp";
$localestrings['en']['dls803'] = "Show me";
$localestrings['en']['dls804'] = "the top";
$localestrings['en']['dls805'] = "All";
$localestrings['en']['dls806'] = "results in the report, and sort it";
$localestrings['en']['dls807'] = "Ascending";
$localestrings['en']['dls808'] = "Descending";
$localestrings['en']['dls809'] = "Error in regexp:";
$localestrings['en']['dls810'] = "Filename";
$localestrings['en']['dls811'] = "Download Count";
// Messages: searches
$localestrings['en']['dls850'] = "Downloaded files";
// Messages: geomap
$localestrings['en']['dls900'] = "<center>No valid Google Maps key found for the URL: %s!</center>";
$localestrings['en']['dls901'] = "A total of %u users could be mapped.";
$localestrings['en']['dls902'] = "To see more detailed information about a specific country, move your mouse over the marker";
$localestrings['en']['dls903'] = "Sorry, the Google Maps API is not compatible with this browser";
$localestrings['en']['dls904'] = "For %u user, no location could be determined";
$localestrings['en']['dls905'] = "For %u users, no location could be determined";
// Messages: admin
$localestrings['en']['dls910'] = "Group selection is invalid.";
$localestrings['en']['dls911'] = "Regular expression is invalid. Error is: ";
$localestrings['en']['dls912'] = "Specified log path does not exist.";
$localestrings['en']['dls913'] = "No write access to the specified log path.";
// Messages: Statistics counter panel
$localestrings['en']['dls920'] = "Statistics entry succesfully deleted.";
$localestrings['en']['dls921'] = "Statistics configuration is saved.";
$localestrings['en']['dls922'] = "The requested statistics ID does not exist.";
$localestrings['en']['dls923'] = "Result:";
$localestrings['en']['dls924'] = "Statistics counter entry succesfully added.";
$localestrings['en']['dls925'] = "Statistics counter entry succesfully updated.";
$localestrings['en']['dls926'] = "You have to supply a short name for this statistics counter";
$localestrings['en']['dls927'] = "You have to supply a description for this statistics counter";
$localestrings['en']['dls928'] = "You have to select either a download item or enter filename(s), or both";
$localestrings['en']['dls929'] = "Are you sure you want to delete this statistics counter?";
// Messages: Reports
$localestrings['en']['dls950'] = "The report could not be generated:";

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();							// commands to execute when installing this module

// add config entries for this module
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('dlstats_access', '103')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('dlstats_geomap_regex', '/software\.ver$/i')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('dlstats_logs', 'modules/download_statistics/batch/logs')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('dlstats_remote', '0')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('dlstats_google_api_key', '')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('dlstats_title', '')");

// Geomap information table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##dlstats_ips (
  dlsi_id int(10) unsigned NOT NULL auto_increment,
  dlsi_ip char(15) NOT NULL default '0.0.0.0',
  dlsi_ccode char(2) NOT NULL default '',
  dlsi_onmap tinyint(1) unsigned NOT NULL default 0,
  dlsi_counter int(10) unsigned NOT NULL default 0,
  PRIMARY KEY  (dlsi_id),
  UNIQUE KEY dlsi_ip_cc(dlsi_ip, dlsi_ccode),
  KEY dlsi_onmap (dlsi_ccode, dlsi_onmap),
  KEY dlsi_ccode (dlsi_ccode)
) ENGINE=MyISAM");

// statistics per file table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##dlstats_files (
  dlsf_id int(10) unsigned NOT NULL auto_increment,
  dlsf_file varchar(255) NOT NULL default '',
  dlsf_success tinyint(1) unsigned NOT NULL default 0,
  dlsf_counter int(10) unsigned NOT NULL default 0,
  PRIMARY KEY  (dlsf_id),
  UNIQUE KEY dlsf_file (dlsf_file)
) ENGINE=MyISAM");

// statistics per ip per file table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##dlstats_file_ips (
  dlsf_id int(10) unsigned NOT NULL default 0,
  dlsi_id int(10) unsigned NOT NULL default 0,
  dlsfi_timestamp int(10) unsigned NOT NULL default 0,
  KEY dlsf_id (dlsf_id),
  KEY dlsi_id (dlsi_id)
) ENGINE=MyISAM");

// Statistics counters table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##dlstats_counters (
  dlsc_id SMALLINT(5) UNSIGNED NOT NULL auto_increment,
  dlsc_name VARCHAR(10) NOT NULL default '',
  dlsc_description VARCHAR(100) NOT NULL default '',
  dlsc_download_id SMALLINT(5) UNSIGNED NOT NULL default 0,
  dlsc_files MEDIUMTEXT NOT NULL,
  dlsc_order SMALLINT(5) UNSIGNED NOT NULL default 0,
  PRIMARY KEY (dlsc_id)
) ENGINE = MYISAM");

// statistics file cache table (to detect retries)
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##dlstats_fcache (
  dlsfc_ip char(15) NOT NULL default '0.0.0.0',
  dlsfc_file varchar(255) NOT NULL default '',
  dlsfc_timeout int(10) unsigned NOT NULL default 0,
  UNIQUE KEY dlsfc_file (dlsfc_ip, dlsfc_file)
) ENGINE=MyISAM");

$mod_install_cmds[] = array('type' => 'function', 'value' => "install_dlstats");

/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();							// commands to execute when uninstalling this module

// delete config entries
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'dlstats_access'");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'dlstats_geomap_where'");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'dlstats_logs'");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'dlstats_remote'");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'dlstats_google_api_key'");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'dlstats_title'");

// delete the tables
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##dlstats_ips");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##dlstats_files");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##dlstats_file_ips");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##dlstats_counters");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##dlstats_fcache");

$mod_uninstall_cmds[] = array('type' => 'function', 'value' => "uninstall_dlstats");

/*---------------------------------------------------+
| function for special installations                 |
+----------------------------------------------------*/
if (!function_exists('install_dlstats')) {
	function install_dlstats() {
	}
}
/*---------------------------------------------------+
| function for special de-installations              |
+----------------------------------------------------*/
if (!function_exists('uninstall_dlstats')) {
	function uninstall_dlstats() {
	}
}

/*---------------------------------------------------+
| function to upgrade from a previous revision       |
+----------------------------------------------------*/
if (!function_exists('module_upgrade')) {
	function module_upgrade($current_version) {
		global $db_prefix;
			
		switch ($current_version) {
			case "1.1.0":
				$result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('dlstats_title', '')");

			case "1.1.1":			// current release version

		}
	}
}
?>
