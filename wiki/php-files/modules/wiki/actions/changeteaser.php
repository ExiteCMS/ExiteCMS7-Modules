<?php

/**
* Display a simplified 'Recent Changes' listing.
*
* This action is intended for inclusion (for example) on the Home page to show a very simple listing of recently changed pages,
* with the facility to exclude some pages from being listed - SandBox is already excluded and others can be added.
*
* Based on RecentChangesPlus by FernandoBorcel
*
* @package    Actions
* @name    changesteaser.php
*
* @usage   {{changesteaser}} or specify number of pages to show {{changesteaser max="5"}}
*
* @author    {@link http://www.davepreston.me.uk : DavePreston}
*
* @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License
*
*/

$exclude = array("SandBox");  // add any other pages to be excluded from listing like thus - array("SandBox", "OtherPage"); etc.

if ($pages = $this->LoadRecentlyChanged())
{
        $max = is_numeric($vars['max']) ? $vars['max'] : false;

    $curday = "";

    foreach ($pages as $i => $page)
    {
        if (($i < $max) || !$max)
        {
            // day header
            list($day, $time) = explode(" ", $page["time"]);
            if ($day != $curday)
            {
                $dateformatted = date("D, d M Y", strtotime($day));

                if ($curday) print("</span><br />\n");
                print("<strong>$dateformatted:</strong><br />\n<span class=\"recentchanges\">");
                $curday = $day;
            }

            $timeformatted = date("H:i T", strtotime($page["time"]));
            $page_edited_by = $page["user"];   
            if (!$this->LoadUser($page_edited_by)) $page_edited_by .= " (unregistered user)";

            // print entry
            if ($page["note"]) $note=" <span class=\"pagenote\">[".$page["note"]."]</span>"; else $note ="";
            $pagetag = $page["tag"];
            if ( !in_array($pagetag, $exclude)) {
                if ($this->HasAccess("read", $pagetag)) {
                        print("&nbsp;&nbsp;&nbsp;&nbsp;".$this->Link($pagetag, "", "", 0)." &rArr; $page_edited_by ".$note."<br />");
                } else {
                        print("&nbsp;&nbsp;&nbsp;&nbsp;".$page["tag"]." &rArr; $page_edited_by ".$note."<br />");
                }
            } else {
                $max++;
            }
        }
    }
    print "</span>\n";
}
?>
