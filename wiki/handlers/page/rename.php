<div class="page">
<?php
/**
 * Rename the current page.
 *
 * Usage: append /rename to the URL of the page you want to rename
 * 
 * This handler checks the existence of the source page, the user's read-access 
 * and write-access to the page.
 * If the edit option is selected, the user is redirected to the target page for
 * edition immediately after its creation.
 *
 * @package         Handlers
 * @subpackage        
 * @name              rename
 *
 * @author            ExiteCMS - WanWizard
 * @version           0.1
 * @since             Wikka 1.1.6.3 - ExiteCMS edition
 *                      
 * @input             string  $note  optional: the note to be added to the page when renamed
 *                            default is "Renamed from " followed by the original name of the page
 * 
 * @input             boolean $editoption optional: if true, the page will be opened for edition after rename
 *                            default is false
 *
 * @todo              Use central library for valid pagenames.
 *        
 * @uses Config::$table_prefix
 * @uses Wakka::ClearLinkTable()
 * @uses Wakka::ExistsPage()
 * @uses Wakka::Footer()
 * @uses Wakka::Format()
 * @uses Wakka::FormClose()
 * @uses Wakka::FormOpen()
 * @uses Wakka::GetUser()
 * @uses Wakka::GetUserName()
 * @uses Wakka::HasAccess()
 * @uses Wakka::Header()
 * @uses Wakka::Href()
 * @uses Wakka::htmlspecialchars_ent()
 * @uses Wakka::hsc_secure()
 * @uses Wakka::LoadSingle()
 * @uses Wakka::Redirect()
 * @uses Wakka::SavePage()
 * @uses Wakka::StartLinkTracking()
 * @uses Wakka::StopLinkTracking()
 * @uses Wakka::WriteLinkTable()
 */
// defaults
if(!defined('VALID_PAGENAME_PATTERN')) define ('VALID_PAGENAME_PATTERN', '/^[A-Za-zÄÖÜßäöü]+[A-Za-z0-9ÄÖÜßäöü]*$/s');

// i18n
define('RENAME_HEADER', '==== Rename current page ====');
define('RENAME_SUCCESSFUL', '%s was succesfully renamed!');
define('RENAME_X_TO', 'Renamed %s to:');
define('RENAMED_FROM', 'Renamed from %s');
define('EDIT_NOTE', 'Edit note:');
define('ERROR_ACL_READ', 'You are not allowed to read the source of this page.');
define('ERROR_ACL_WRITE', 'Sorry! You don\'t have write-access to %s');
define('ERROR_INVALID_PAGENAME', 'This page name is invalid. Valid page names must start with a letter and contain only letters and numbers.');
define('ERROR_PAGE_ALREADY_EXIST', 'Sorry, the destination page already exists');
define('ERROR_PAGE_NOT_EXIST', ' Sorry, page %s does not exist.');
define('LABEL_RENAME', 'Rename');
define('LABEL_EDIT_OPTION', ' Edit after rename ');
define('PLEASE_FILL_VALID_TARGET', 'Please fill in a valid target ""PageName"".');

// initialization
$from = $this->tag;
$to = $this->tag;
$note = sprintf(RENAMED_FROM, $from);
$editoption = ''; 
$box = PLEASE_FILL_VALID_TARGET;

// print header
echo $this->Format(RENAME_HEADER);

// 1. check source page existence
if (!$this->ExistsPage($from))
{
	// source page does not exist!
	$box = sprintf(ERROR_PAGE_NOT_EXIST, $from);
} else 
{
	// 2. page exists - now check user's read-access to the source page
	if (!$this->HasAccess('read', $from))
	{
		// user can't read source page!
		$box = ERROR_ACL_READ;
	} else
	{
		// page exists and user has read-access to the source - proceed
		if (isset($_POST) && $_POST)
		{
			// get parameters
			$to = isset($_POST['to']) && $_POST['to'] ? $_POST['to'] : $to;
			$note = isset($_POST['note']) && $_POST['note'] ? $_POST['note'] : $note;
			$editoption = (isset($_POST['editoption']))? 'checked="checked"' : '';
		
			// 3. check target pagename validity
			if (!preg_match(VALID_PAGENAME_PATTERN, $to))  //TODO use central regex library
			{
				// invalid pagename!
				$box = '""<em class="error">'.ERROR_INVALID_PAGENAME.'</em>""';
			} else
			{
				// 4. target page name is valid - now check user's write-access
				if (!$this->HasAccess('write', $to))  
				{
					$box = '""<em class="error">'.sprintf(ERROR_ACL_WRITE, $to).'</em>""';
				} else
				{
					// 5. check target page existence
					if ($this->ExistsPage($to))
					{ 
						// page already exists!
						$box = '""<em class="error">'.ERROR_PAGE_ALREADY_EXIST.'</em>""';
					} else
					{
						// 6. Valid request - proceed to rename the page
						
						// find all pages that have links to our page
						$pages = $this->LoadAll("select * from ".$this->config['table_prefix']."links where to_tag = '".mysql_real_escape_string($from)."'");
						// load them and rename the tags on those pages, and update the link table
						foreach($pages as $page) {
							// get the page record
							$body = $this->LoadPage($page['from_tag']);
							$this->tag = $page['from_tag'];
							// replace the links in the body
							$search[] = "/\b".$from."\b/i";
							$replace[] =  "\\1".$to."\\3";
							$body['body'] = preg_replace($search, $replace, $body['body']);
							// save the updated body as a new revision
							$this->SavePage($body['tag'], $body['body'], sprintf(RENAME_X_TO, $from).$to);
							// now we render it internally so we can write the updated link table.
							$this->ClearLinkTable();
							$this->StartLinkTracking();
							$dummy = $this->Header();
							$dummy .= $this->Format($body['body']);
							$dummy .= $this->Footer();
							$this->StopLinkTracking();
							$this->WriteLinkTable();
							$this->ClearLinkTable();
						}
						// rename the page, the comments link, the link table, the acl table and the referrer info
						$this->Query("update ".$this->config["table_prefix"]."pages set tag = '".$to."' where tag = '".mysql_real_escape_string($from)."'");
						$this->Query("update ".$this->config["table_prefix"]."comments set page_tag = '".$to."' where page_tag = '".mysql_real_escape_string($from)."'");
						$this->Query("update ".$this->config["table_prefix"]."links set to_tag = '".$to."' where to_tag = '".mysql_real_escape_string($from)."'");
						$this->Query("update ".$this->config["table_prefix"]."acls set page_tag = '".$to."' where page_tag = '".mysql_real_escape_string($from)."'");
						$this->Query("update ".$this->config["table_prefix"]."referrers set page_tag = '".$to."' where page_tag = '".mysql_real_escape_string($from)."'");
						// and redirect to the new page
						$this->Redirect($this->href(($editoption == 'checked="checked"')?'edit':'', $to));
					}
				}
			}
		} 
		// build form
		$form = $this->FormOpen('rename');
		$form .= '<table class="clone">'."\n".
			'<tr>'."\n".
			'<td>'.sprintf(RENAME_X_TO, $this->Link($this->GetPageTag())).'</td>'."\n".
			'<td><input type="text" name="to" value="'.$to.'" size="37" maxlength="75" /></td>'."\n".
			'</tr>'."\n".
			'<tr>'."\n".
			'<td></td>'."\n".
			'<td>'."\n".
			'<input type="submit" class="button" name="create" value="'.LABEL_RENAME.'" />'."\n".
			'<input type="checkbox" name="editoption" '.$editoption.' id="editoption" /><label for="editoption">'.LABEL_EDIT_OPTION.'</label>'."\n".
			'</td>'."\n".
			'</tr>'."\n".
			'</table>'."\n";
		$form .= $this->FormClose();
	}
}

// display messages
if (isset($box)) echo $this->Format(' --- '.$box.' --- --- ');
// print form
if (isset($form)) print $form;
?>
</div>