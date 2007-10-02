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
if (!checkrights("I") || !defined("iAUTH") || $aid != iAUTH || !defined('ExiteCMS_INIT')) fallback(BASEDIR."index.php");

/*---------------------------------------------------+
| Locale definition for this installation module     |
+----------------------------------------------------*/

if (file_exists(PATH_MODULES."wiki/locale/".$settings['locale'].".php")) {
	include PATH_MODULES."wiki/locale/".$settings['locale'].".php";
} else {
	include PATH_MODULES."wiki/locale/English.php";
}

/*---------------------------------------------------+
| Module identification                              |
+----------------------------------------------------*/
$mod_title = $locale['wiki100'];						// title or name of this module
$mod_description = $locale['wiki101'];					// short description of it's purpose
$mod_version = $locale['wikiver'];						// module version number
$mod_developer = "WanWizard";							// author's name
$mod_email = "wanwizard@gmail.com";
$mod_weburl = "http://exitecms.exite.eu/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "wiki";									// sub-folder of the /modules folder
$mod_admin_image = "";									// icon to be used for the admin panel
$mod_admin_panel = "";									// name of the admin panel for this module
$mod_admin_rights = "wW";								// admin rights code. This HAS to be assigned by PLi-Fusion to avoid duplicates!
$mod_admin_page = 1;									// admin page this panel has to be placed on

/*---------------------------------------------------+
| Version and revision control                       |
+----------------------------------------------------*/

// check for a minumum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) < 700) {
	$mod_errors .= sprintf($locale['mod001'], '7.00');
}
// check for a maximum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) > 700) {
	$mod_errors .= sprintf($locale['mod002'], '7.00');
}
// check for a specific revision number range that is supported
if ($settings['revision'] < 0 || $settings['revision'] > 999999) {
	$mod_errors .= sprintf($locale['mod003'], 0, 999999);
}

/*---------------------------------------------------+
| Menu entries for this module                       |
+----------------------------------------------------*/

$mod_site_links = array();								// site_links definitions. Multiple can be defined
$mod_site_links[] = array('name' => $locale['wiki102'], 'url' => 'index.php', 'panel' => '', 'visibility' => 102);

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();							// commands to execute when installing this module

// wiki_acls
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##wiki_acls (
  page_tag varchar(75) NOT NULL default '',
  read_acl text NOT NULL,
  write_acl text NOT NULL,
  comment_acl text NOT NULL,
  PRIMARY KEY  (page_tag)
) ENGINE=MyISAM;");

$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_acls (page_tag, read_acl, write_acl, comment_acl) VALUES ('UserSettings', '*', '+', '+')");

// wiki_comments
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##wiki_comments (
  id int(10) unsigned NOT NULL auto_increment,
  page_tag varchar(75) NOT NULL default '',
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  `comment` text NOT NULL,
  `user` varchar(75) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY idx_page_tag (page_tag),
  KEY idx_time (`time`)
) ENGINE=MyISAM;");

// wiki_links
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##wiki_links (
  from_tag varchar(75) NOT NULL default '',
  to_tag varchar(75) NOT NULL default '',
  UNIQUE KEY from_tag (from_tag,to_tag),
  KEY idx_from (from_tag),
  KEY idx_to (to_tag)
) ENGINE=MyISAM;");

// wiki_pages
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##wiki_pages (
  id int(10) unsigned NOT NULL auto_increment,
  tag varchar(75) NOT NULL default '',
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  body mediumtext NOT NULL,
  owner varchar(75) NOT NULL default '',
  `user` varchar(75) NOT NULL default '',
  latest enum('Y','N') NOT NULL default 'N',
  hits int(11) NOT NULL default '0',
  note varchar(100) NOT NULL default '',
  `handler` varchar(30) NOT NULL default 'page',
  PRIMARY KEY  (id),
  KEY idx_tag (tag),
  KEY idx_time (`time`),
  KEY idx_latest (latest),
  FULLTEXT KEY body (body)
) ENGINE=MyISAM;");

$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (1, 'HomePage', now(), '{{image url=\"images/wikka_logo.jpg\" alt=\"wikka logo\" title=\"Welcome to this Wikka Wiki!\"}}\n\nThis site is running on version ##{{wikkaversion}}## (see WikkaReleaseNotes). \nYou need to double-click on any page or click on the \"Edit page\" link at the bottom to get started. \n\nFor more information, visit the [[Wikka:HomePage WikkaWiki website]]! \n\nUseful pages: FormattingRules, WikkaDocumentation, OrphanedPages, WantedPages, TextSearch.', '##WEBMASTER##', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (2, 'RecentChanges', now(), '{{RecentChanges}}{{nocomments}}\n\n\n----\nCategoryWiki', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (3, 'RecentlyCommented', now(), '{{RecentlyCommented}}{{nocomments}}\n\n\n----\nCategoryWiki', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (4, 'UserSettings', now(), '{{UserSettings}}{{nocomments}}\n\n\n----\nCategoryWiki', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (5, 'PageIndex', now(), '{{PageIndex}}{{nocomments}}\n\n\n----\nCategoryWiki', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (6, 'WikkaReleaseNotes', now(), '{{wikkachanges}}{{nocomments}}\n\n\n----\nCategoryWiki', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (7, 'WikkaDocumentation', now(), '=====Wikka Documentation=====\n\nComprehensive and up-to-date documentation on Wikka Wiki can be found on the [[http://wikkawiki.org/WikkaDocumentation main Wikka server]].', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (8, 'WantedPages', now(), '{{WantedPages}}{{nocomments}}\n\n\n----\nCategoryWiki', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (9, 'OrphanedPages', now(), '====Orphaned Pages====\n\nThe following list shows those pages held in the Wiki that are not linked to on any other pages.\n\n{{OrphanedPages}}{{nocomments}}\n\n\n----\nCategoryWiki', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (10, 'TextSearch', now(), '{{TextSearch}}{{nocomments}}\n\n\n----\nCategoryWiki', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (11, 'TextSearchExpanded', now(), '{{textsearchexpanded}}{{nocomments}}\n\n\n----\nCategoryWiki', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (12, 'MyPages', now(), '{{MyPages}}{{nocomments}}\n\n\n----\nCategoryWiki', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (13, 'MyChanges', now(), '{{MyChanges}}{{nocomments}}\n\n\n----\nCategoryWiki', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (14, 'InterWiki', now(), '{{interwikilist}}\n\n\n----\nCategoryWiki', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (15, 'PasswordForgotten', now(), '{{emailpassword}}\n\n\n----\nCategoryWiki', '(Public)', '##WEBMASTER##', 'N', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (16, 'WikiCategory', now(), '===This wiki is using a very flexible but simple categorizing system to keep everything properly organized.===\n\n{{Category page=\"/\"  col=\"10\"}}\n==Here''s how it works :==\n~- The master list of the categories is **Category Category** (//without the space//) which will automatically list all known maincategories, and should never be edited. This list is easily accessed from the Wiki''s top navigation bar. (Categories).\n~- Each category has a WikiName name of the form \"\"CategoryName\"\" for example CategoryWiki etc. (see list of maincategories above)\n~- Pages can belong to zero or more categories. Including a page in a category is done by simply mentioning the \"\"CategoryName\"\" on the page (by convention at the very end of the page).\n~- The system allows to build hierarchies of categories by referring to the parent category in the subcategory page. The parent category page will then automatically include the subcategory page in its list.\n~- A special kind of category is **\"\"Category Users\"\"** (//without the space//) to group the userpages, so your Wiki homepage should include it at the end to be included in the category-driven userlist.\n~- New categories can be created (think very hard before doing this though, we don''t need too much of them) by creating a \"\"CategoryName\"\" page, including \"\"{{Category}}\"\" in it and placing it in the **Category Category** (//without the space//) category (for a main category or another parent category in case you want to create a subcategory).\n\n**Please help to keep this place organized by including the relevant categories in new and existing pages !**\n\n**Notes:** \n~- The above bold items above //include spaces// to prevent this page from showing up in the mentioned categories. This page only belongs in CategoryWiki (which can be safely mentioned) after all !\n~- In order to avoid accidental miscategorization you should **avoid** mentioning a non-related \"\"CategoryName\"\" on a page. This is a side-effect of how the categorizing system works: it''s based on a textsearch and is not restricted to the footer convention.\n~- Don''t be put of by the name of this page (WikiCategory) which is a logical name (it''s about the Wiki and explains Category) but doesn''t have any special role in the Categorizing system.\n~- To end with this is the **standard convention** to include the categories (both the wiki code and the result):\n\n%%==Categories==\nCategoryWiki%%\n\n==Categories==\nCategoryWiki', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (17, 'CategoryWiki', now(), '===Wiki Related Category===\nThis Category will contain links to pages talking about Wikis and Wikis specific topics. When creating such pages, be sure to include CategoryWiki at the bottom of each page, so that page shows listed.\n\n\n----\n\n{{Category col=\"3\"}}\n\n\n----\n[[CategoryCategory List of all categories]]', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (18, 'CategoryCategory', now(), '===List of All Categories===\nBelow is the list of all Categories existing on this Wiki, granted that users did things right when they created their pages or new Categories. See WikiCategory for how the system works.\n\n----\n\n{{Category}}', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (19, 'FormattingRules', now(), '======Wikka Formatting Guide======\n\n<<**Note:** Anything between 2 sets of double-quotes is not formatted.<<::c::\nOnce you have read through this, test your formatting skills in the SandBox.\n----\n===1. Text Formatting===\n\n~##\"\"**I''m bold**\"\"##\n~**I''m bold **\n\n~##\"\"//I''m italic text!//\"\"##\n~//I''m italic text!//\n\n~##\"\"And I''m __underlined__!\"\"##\n~And I''m __underlined__!\n\n~##\"\"##monospace text##\"\"##\n~##monospace text##\n\n~##\"\"''''highlight text''''\"\"## (using 2 single-quotes)\n~''''highlight text''''\n\n~##\"\"++Strike through text++\"\"##\n~++Strike through text++\n\n~##\"\"Press #%ANY KEY#%\"\"##\n~Press #%ANY KEY#%\n\n~##\"\"@@Center text@@\"\"##\n~@@Center text@@\n\n===2. Headers===\n\nUse between five ##=## (for the biggest header) and two ##=## (for the smallest header) on both sides of a text to render it as a header.\n\n~##\"\"====== Really big header ======\"\"##\n~====== Really big header ======\n  \n~##\"\"===== Rather big header =====\"\"##\n~===== Rather big header =====\n\n~##\"\"==== Medium header ====\"\"##\n~==== Medium header ====\n\n~##\"\"=== Not-so-big header ===\"\"##\n~=== Not-so-big header ===\n\n~##\"\"== Smallish header ==\"\"##\n~== Smallish header ==\n\n===3. Horizontal separator===\n~##\"\"----\"\"##\n----\n\n===4. Forced line break===\n~##\"\"---\"\"##\n---\n\n===5. Lists and indents===\n\nYou can indent text using a **~**, a **tab** or **4 spaces** (which will auto-convert into a tab).\n\n##\"\"~This text is indented<br />~~This text is double-indented<br />&nbsp;&nbsp;&nbsp;&nbsp;This text is also indented\"\"##\n\n~This text is indented\n~~This text is double-indented\n   This text is also indented\n\nTo create bulleted/ordered lists, use the following markup (you can always use 4 spaces instead of a ##**~**##):\n\n**Bulleted lists**\n##\"\"~- Line one\"\"##\n##\"\"~- Line two\"\"##\n\n- Line one\n- Line two\n\n**Numbered lists**\n##\"\"~1) Line one\"\"##\n##\"\"~1) Line two\"\"##\n\n1) Line one\n1) Line two\n\n**Ordered lists using uppercase characters**\n##\"\"~A) Line one\"\"##\n##\"\"~A) Line two\"\"##\n\nA) Line one\nA) Line two\n\n**Ordered lists using lowercase characters**\n##\"\"~a) Line one\"\"##\n##\"\"~a) Line two\"\"##\n\na) Line one\na) Line two\n\n**Ordered lists using roman numerals**\n##\"\"~I) Line one\"\"##\n##\"\"~I) Line two\"\"##\n\n   I) Line one\nI) Line two\n\n**Ordered lists using lowercase roman numerals**\n##\"\"~i) Line one\"\"##\n##\"\"~i) Line two\"\"##\n\n i) Line one\ni) Line two\n\n===6. Inline comments===\n\nTo format some text as an inline comment, use an indent ( **~**, a **tab** or **4 spaces**) followed by a **\"\"&amp;\"\"**.\n\n**Example:**\n\n##\"\"~&amp; Comment\"\"##\n##\"\"~~&amp; Subcomment\"\"##\n##\"\"~~~&amp; Subsubcomment\"\"##\n\n~& Comment\n~~& Subcomment\n~~~& Subsubcomment\n\n===7. Images===\n\nTo place images on a Wiki page, you can use the ##image## action.\n\n**Example:**\n\n~##\"\"{{image class=\"center\" alt=\"DVD logo\" title=\"An Image Link\" url=\"images/dvdvideo.gif\" link=\"RecentChanges\"}}\"\"##\n~{{image class=\"center\" alt=\"dvd logo\" title=\"An Image Link\" url=\"images/dvdvideo.gif\" link=\"RecentChanges\"}}\n\nLinks can be external, or internal Wiki links. You don''t need to enter a link at all, and in that case just an image will be inserted. You can use the optional classes ##left## and ##right## to float images left and right. You don''t need to use all those attributes, only ##url## is required while ##alt## is recommended for accessibility.\n\n===8. Links===\n\nTo create a **link to a wiki page** you can use any of the following options: ---\n~1) type a ##\"\"WikiName\"\"##: --- --- ##\"\"FormattingRules\"\"## --- FormattingRules --- ---\n~1) add a forced link surrounding the page name by ##\"\"[[\"\"## and ##\"\"]]\"\"## (everything after the first space will be shown as description): --- --- ##\"\"[[SandBox Test your formatting skills]]\"\"## --- [[SandBox Test your formatting skills]] --- --- ##\"\"[[SandBox &#27801;&#31665;]]\"\"## --- [[SandBox &#27801;&#31665;]] --- ---\n~1) add an image with a link (see instructions above).\n\nTo **link to external pages**, you can do any of the following: ---\n~1) type a URL inside the page: --- --- ##\"\"http://www.example.com\"\"## --- http://www.example.com --- --- \n~1) add a forced link surrounding the URL by ##\"\"[[\"\"## and ##\"\"]]\"\"## (everything after the first space will be shown as description): --- --- ##\"\"[[http://example.com/jenna/ Jenna''s Home Page]]\"\"## --- [[http://example.com/jenna/ Jenna''s Home Page]] --- --- ##\"\"[[mail@example.com Write me!]]\"\"## --- [[mail@example.com Write me!]] --- ---\n~1) add an image with a link (see instructions above);\n~1) add an interwiki link (browse the [[InterWiki list of available interwiki tags]]): --- --- ##\"\"WikiPedia:WikkaWiki\"\"## --- WikiPedia:WikkaWiki --- --- ##\"\"Google:CSS\"\"## --- Google:CSS --- --- ##\"\"Thesaurus:Happy\"\"## --- Thesaurus:Happy --- ---\n\n===9. Tables===\n\nTo create a table, you can use the ##table## action.\n\n**Example:**\n\n~##\"\"{{table columns=\"3\" cellpadding=\"1\" cells=\"BIG;GREEN;FROGS;yes;yes;no;no;no;###\"}}\"\"##\n\n~{{table columns=\"3\" cellpadding=\"1\" cells=\"BIG;GREEN;FROGS;yes;yes;no;no;no;###\"}}\n\nNote that ##\"\"###\"\"## must be used to indicate an empty cell.\nComplex tables can also be created by embedding HTML code in a wiki page (see instructions below).\n\n===10. Colored Text===\n\nColored text can be created using the ##color## action:\n\n**Example:**\n\n~##\"\"{{color c=\"blue\" text=\"This is a test.\"}}\"\"##\n~{{color c=\"blue\" text=\"This is a test.\"}}\n\nYou can also use hex values:\n\n**Example:**\n\n~##\"\"{{color hex=\"#DD0000\" text=\"This is another test.\"}}\"\"##\n~{{color hex=\"#DD0000\" text=\"This is another test.\"}}\n\nAlternatively, you can specify a foreground and background color using the ##fg## and ##bg## parameters (they accept both named and hex values):\n\n**Examples:**\n\n~##\"\"{{color fg=\"#FF0000\" bg=\"#000000\" text=\"This is colored text on colored background\"}}\"\"##\n~{{color fg=\"#FF0000\" bg=\"#000000\" text=\"This is colored text on colored background\"}}\n\n~##\"\"{{color fg=\"lightgreen\" bg=\"black\" text=\"This is colored text on colored background\"}}\"\"##\n~{{color fg=\"lightgreen\" bg=\"black\" text=\"This is colored text on colored background\"}}\n\n\n===11. Floats===\n\nTo create a **left floated box**, use two ##<## characters before and after the block.\n\n**Example:**\n\n~##\"\"&lt;&lt;Some text in a left-floated box hanging around&lt;&lt; Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler.\"\"##\n\n<<Some text in a left-floated box hanging around<<Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler.\n\n::c::To create a **right floated box**, use two ##>## characters before and after the block.\n\n**Example:**\n\n~##\"\">>Some text in a right-floated box hanging around>> Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler.\"\"##\n\n   >>Some text in a right-floated box hanging around>>Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler. Some more text as a filler.\n\n::c:: Use ##\"\"::c::\"\"##  to clear floated blocks.\n\n===12. Code formatters===\n\nYou can easily embed code blocks in a wiki page using a simple markup. Anything within a code block is displayed literally. \nTo create a **generic code block** you can use the following markup:\n\n~##\"\"%% This is a code block %%\"\"##. \n\n%% This is a code block %%\n\nTo create a **code block with syntax highlighting**, you need to specify a //code formatter// (see below for a list of available code formatters). \n\n~##\"\"%%(\"\"{{color c=\"red\" text=\"php\"}}\"\")<br />&lt;?php<br />echo \"Hello, World!\";<br />?&gt;<br />%%\"\"##\n\n%%(php)\n<?php\necho \"Hello, World!\";\n?>\n%%\n\nYou can also specify an optional //starting line// number.\n\n~##\"\"%%(php;\"\"{{color c=\"red\" text=\"15\"}}\"\")<br />&lt;?php<br />echo \"Hello, World!\";<br />?&gt;<br />%%\"\"##\n\n%%(php;15)\n<?php\necho \"Hello, World!\";\n?>\n%%\n\nIf you specify a //filename//, this will be used for downloading the code.\n\n~##\"\"%%(php;15;\"\"{{color c=\"red\" text=\"test.php\"}}\"\")<br />&lt;?php<br />echo \"Hello, World!\";<br />?&gt;<br />%%\"\"##\n\n%%(php;15;test.php)\n<?php\necho \"Hello, World!\";\n?>\n%%\n\n**List of available code formatters:**\n{{table columns=\"6\" cellpadding=\"1\" cells=\"LANGUAGE;FORMATTER;LANGUAGE;FORMATTER;LANGUAGE;FORMATTER;Actionscript;actionscript;ADA;ada;Apache Log;apache;AppleScript; applescript;ASM;asm;ASP;asp;AutoIT;autoit;Bash;bash;BlitzBasic;blitzbasic;BNF;bnf;C;c;C for Macs;c_mac;c#;csharp;C++;cpp;C++ (QT extensions);cpp-qt;CAD DCL;caddcl;CadLisp;cadlisp;CFDG;cfdg;ColdFusion;cfm; CSS;css;D;d;Delphi;delphi;Diff-Output;diff;DIV; div;DOS;dos;Eiffel;eiffel;Fortran;fortran;FreeBasic;freebasic;GML;gml;Groovy;groovy;HTML;html4strict;INI;ini;IO;io;Inno Script;inno;Java 5;java5;Java;java;Javascript;javascript;LaTeX;latex;Lisp;lisp;Lua;lua;Matlab;matlab;Microchip Assembler;mpasm;Microsoft Registry;reg;mIRC;mirc;MySQL;mysql;NSIS;nsis;Objective C;objc;OpenOffice BASIC;oobas;Objective Caml;ocaml;Objective Caml (brief);ocaml-brief;Oracle 8;oracle8;Pascal;pascal;Perl;perl;PHP;php;PHP (brief);php-brief;PL/SQL;plsql;Python;phyton;Q(uick)BASIC;qbasic;robots.txt;robots;Ruby;ruby;SAS;sas;Scheme;scheme;sdlBasic;sdlbasic;SmallTalk;smalltalk;Smarty;smarty;SQL;sql;TCL/iTCL;tcl;T-SQL;tsql;Text;text;thinBasic;thinbasic;Unoidl;idl;VB.NET;vbnet;VHDL;vhdl;Visual BASIC;vb;Visual Fox Pro;visualfoxpro;WinBatch;winbatch;XML;xml;ZiLOG Z80;z80\"}}\n\n===13. Mindmaps===\n\nWikka has native support for [[Wikka:FreeMind mindmaps]]. There are two options for embedding a mindmap in a wiki page.\n\n**Option 1:** Upload a \"\"FreeMind\"\" file to a webserver, and then place a link to it on a wikka page:\n  ##\"\"http://yourdomain.com/freemind/freemind.mm\"\"##\nNo special formatting is necessary.\n\n**Option 2:** Paste the \"\"FreeMind\"\" data directly into a wikka page:\n~- Open a \"\"FreeMind\"\" file with a text editor.\n~- Select all, and copy the data.\n~- Browse to your Wikka site and paste the Freemind data into a page. \n\n===14. Embedded HTML===\n\nYou can easily paste HTML in a wiki page by wrapping it into two sets of doublequotes. \n\n~##&quot;&quot;[html code]&quot;&quot;##\n\n**Examples:**\n\n~##&quot;&quot;y = x<sup>n+1</sup>&quot;&quot;##\n~\"\"y = x<sup>n+1</sup>\"\"\n\n~##&quot;&quot;<acronym title=\"Cascade Style Sheet\">CSS</acronym>&quot;&quot;##\n~\"\"<acronym title=\"Cascade Style Sheet\">CSS</acronym>\"\"\n\nBy default, some HTML tags are removed by the \"\"SafeHTML\"\" parser to protect against potentially dangerous code.  The list of tags that are stripped can be found on the Wikka:SafeHTML page.\n\nIt is possible to allow //all// HTML tags to be used, see Wikka:UsingHTML for more information.\n\n----\nCategoryWiki', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (20, 'OwnedPages', now(), '{{ownedpages}}{{nocomments}}These numbers merely reflect how many pages you have created, not how much content you have contributed or the quality of your contributions. To see how you rank with other members, you may be interested in checking out the HighScores. \n\n\n----\nCategoryWiki', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (21, 'SandBox', now(), 'Test your formatting skills here.\n\n\n\n\n----\nCategoryWiki', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##wiki_pages (id, tag, time, body, owner, user, latest, note, handler) VALUES (22, 'SysInfo', now(), '===== System Information =====\n\n~-Wikka version: ##{{wikkaversion}}##\n~-PHP version: ##{{phpversion}}##\n~-\"\"MySQL\"\" version: ##{{mysqlversion}}##\n~-\"\"GeSHi\"\" version: ##{{geshiversion}}##\n~-Server:\n~~-Host: ##{{system show=\"host\"}}##\n~~-Operative System: ##{{system show=\"os\"}}##\n~~-Machine: ##{{system show=\"machine\"}}##\n\n----\nCategoryWiki', '(Public)', '##WEBMASTER##', 'Y', '', 'page')");

// wiki_referrer_blacklist
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##wiki_referrer_blacklist (
  spammer varchar(150) NOT NULL default '',
  KEY idx_spammer (spammer)
) ENGINE=MyISAM;");

// wiki_referrers
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##wiki_referrers (
  page_tag varchar(75) NOT NULL default '',
  referrer varchar(150) NOT NULL default '',
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  KEY idx_page_tag (page_tag),
  KEY idx_time (`time`)
) ENGINE=MyISAM;");

// wiki_users
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##wiki_users (
  name varchar(75) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  email varchar(50) NOT NULL default '',
  revisioncount int(10) unsigned NOT NULL default '20',
  changescount int(10) unsigned NOT NULL default '50',
  doubleclickedit enum('Y','N') NOT NULL default 'Y',
  signuptime datetime NOT NULL default '0000-00-00 00:00:00',
  show_comments enum('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (name),
  KEY idx_signuptime (signuptime)
) ENGINE=MyISAM;");

// add a user group for this module
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##user_groups (group_ident, group_name, group_description, group_forumname, group_visible) VALUES ('".$mod_admin_rights."01', 'Wiki Admins', 'Wiki Admins', 'Wiki Admin', '1')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##user_groups (group_ident, group_description, group_forumname, group_visible) VALUES ('".$mod_admin_rights."02', 'Wiki Editors', 'Wiki Editors', 'Wiki Editor', '1')");

$mod_install_cmds[] = array('type' => 'function', 'value' => "install_wiki");

/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();							// commands to execute when uninstalling this module

// delete the wiki tables
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##wiki_acls");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##wiki_comments");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##wiki_links");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##wiki_pages");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##wiki_referrers");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##wiki_referrer_blacklist");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##wiki_users");

// delete the user groups
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##user_groups WHERE group_ident = '".$mod_admin_rights."01'");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##user_groups WHERE group_ident = '".$mod_admin_rights."02'");

$mod_install_cmds[] = array('type' => 'function', 'value' => "uninstall_wiki");

/*---------------------------------------------------+
| function for special installations                 |
+----------------------------------------------------*/
if (!function_exists('install_wiki')) {
	function install_wiki() {
		
		global $db_prefix, $mod_admin_rights;

		// get the group_id of the Wiki Admins group
		$admins = dbarray(dbquery("SELECT group_id FROM ".$db_prefix."user_groups WHERE group_ident = '".$mod_admin_rights."01'"));
		
		// add all webmasters to the wiki user table
		$result = dbquery("SELECT * FROM ".$db_prefix."users WHERE user_level = '103'");
		while ($data = dbarray($result)) {
			$result2 = dbquery("INSERT INTO ".$db_prefix."wiki_users (name, email, revisioncount, changescount, doubleclickedit, signuptime, show_comments) VALUES ('".$data['user_name']."', '".$data['user_email']."', 20, 50, 'Y', now(), 'N')");
			// and update references to the webmaster
			if ($data['user_id'] == 1) {
				$result2 = dbquery("UPDATE ".$db_prefix."wiki_pages SET owner = '".$data['user_name']."' WHERE owner = '##WEBMASTER##'");
				$result2 = dbquery("UPDATE ".$db_prefix."wiki_pages SET user = '".$data['user_name']."' WHERE user = '##WEBMASTER##'");
			}
			// add them to the Wiki Admins group
			if (isset($admins['group_id'])) {
				$user_groups = $data['user_groups'].".".$admins['group_id'];
				$result2 = dbquery("UPDATE ".$db_prefix."users SET user_groups = '$user_groups' WHERE user_id = '".$data['user_id']."'");
			}
		}
	}
}
/*---------------------------------------------------+
| function for special de-installations              |
+----------------------------------------------------*/
if (!function_exists('uninstall_wiki')) {
	function uninstall_wiki() {
	}
}

/*---------------------------------------------------+
| function to upgrade from a previous revision       |
+----------------------------------------------------*/
if (!function_exists('module_upgrade')) {
	function module_upgrade($current_version) {
	}
}
?>