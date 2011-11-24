<div class="page">
<?php
/**
 * current page alias maintenance
 *
 * Usage: create tag aliases for the current page, or delete defined aliases
 * 
 * This handler checks if the new alias is unique (not defined as an alias elsewhere
 * or the name of an existing page)
 *
 * @package         Handlers
 * @subpackage        
 * @name              aliases
 *
 * @author            {@link http://wikkawiki.org/WanWizard WanWizard} - original idea and code.
 * @version           0.1
 * @since             Wikka 1.1.6.3 - ExiteCMS Edition
 *                      
 * @input             string  $to  required: the alias to be created
 *                            must be a non existing page and current user must be authorized to create it
 *                            default is source page name 				
 * 
 * @input             string  $note  optional: the note to be added to the page when created
 *                            default is "Cloned from " followed by the name of the source page
 * 
 * @input             boolean $editoption optional: if true, the new page will be opened for edition on creation
 *                            default is false (to allow multiple cloning of the same source)
 *
 * @todo              Use central library for valid pagenames.
 *        
 */
// defaults
if(!defined('VALID_PAGENAME_PATTERN')) define ('VALID_PAGENAME_PATTERN', '/^[A-Za-zÄÖÜßäöü]+[A-Za-z0-9ÄÖÜßäöü]*$/s');

// i18n
define('ALIAS_HEADER', '==== Alias current page ====');
define('ALIAS_SUBHEADER', '==== Defined Aliases ====');
define('ALIAS_SUCCESSFUL', 'Alias %s was succesfully created!');
define('ALIAS_SUCCESSFUL_DELETED', 'Alias %s was succesfully deleted!');
define('ALIAS_CURRENT', 'current alias');
define('ALIAS_FOR', 'for');
define('ALIAS_X_TO', 'New alias for %s:');
define('ERROR_ACL_READ', 'You are not allowed to read the source of this page.');
define('ERROR_ACL_WRITE', 'Sorry! You don\'t have write-access to %s');
define('ERROR_INVALID_PAGENAME', 'This page name is invalid. Valid page names must start with a letter and contain only letters and numbers.');
define('ERROR_PAGE_ALREADY_EXIST', 'Sorry, the destination page already exists');
define('ERROR_PAGE_NOT_EXIST', ' Sorry, page %s does not exist.');
define('LABEL_ALIAS', 'Alias');
define('LABEL_ALIAS_DELETE', 'Delete');
define('PLEASE_FILL_VALID_TARGET', 'Please fill in a valid target ""PageName"".');

// initialization
$from = $this->tag;
$to = $this->tag;
$box = PLEASE_FILL_VALID_TARGET;

// print header
echo $this->Format(ALIAS_HEADER);

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
			$from = isset($_POST['from']) && $_POST['from'] ? $_POST['from'] : $from;
			$to = isset($_POST['to']) && $_POST['to'] ? $_POST['to'] : $to;
		
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
					// create an alias
					if (isset($_POST['create']) && $_POST['create'] == LABEL_ALIAS)
					{
						// 5. check target page existence
						if ($this->ExistsPage($to))
						{ 
							// page already exists!
							$box = '""<em class="error">'.ERROR_PAGE_ALREADY_EXIST.'</em>""';
						} else
						{
							// 6. Valid request - proceed to create the page alias
							if ($r = $this->Query("INSERT INTO ".$this->config["table_prefix"]."aliases (from_tag, to_tag) VALUES ('".mysql_escape_string($to)."', '".mysql_escape_string($from)."')"))
							{
								// show confirmation message
								$box = '""<em class="success">'.sprintf(ALIAS_SUCCESSFUL, $to).'</em>""';
							}
						}
					} else if (isset($_POST['delete']) && $_POST['delete'] == LABEL_ALIAS_DELETE)
					{
						if ($r = $this->Query("DELETE FROM ".$this->config["table_prefix"]."aliases WHERE from_tag = '".mysql_escape_string($from)."' AND to_tag = '".mysql_escape_string($to)."'"))
						{
							// show confirmation message
							$box = '""<em class="success">'.sprintf(ALIAS_SUCCESSFUL_DELETED, $from).'</em>""';
						}
						$from = $to;
					}
				}
			}
		} 
		// build form
		$form = $this->FormOpen('aliases');
		$form .= '<table class="alias">'."\n".
			'<tr>'."\n".
			'<td>'.sprintf(ALIAS_X_TO, $this->Link($this->GetPageTag())).'</td>'."\n".
			'<td><input type="text" name="to" value="'.$to.'" size="37" maxlength="75" /></td>'."\n".
			'<td>'."\n".
			'<input type="submit" class="button" name="create" value="'.LABEL_ALIAS.'" />'."\n".
			'</td>'."\n".
			'</tr>'."\n".
			'</table>'."\n";
		$form .= $this->FormClose();
		// check for existing aliases for this page
		$aliases = $this->LoadAll("SELECT * FROM ".$this->config['table_prefix']."aliases WHERE to_tag='".mysql_real_escape_string($from)."'");
		if (count($aliases)) {
			$form .= '<hr /><br />'."\n";
			$form .= $this->Format(ALIAS_SUBHEADER);
			$form .= '<br />'."\n";
			foreach($aliases as $alias) {
				$form .= $this->FormOpen('aliases');
				$form .= '<table class="alias">'."\n".
					'<tr>'."\n".
					'<td>'."\n".
					'<input type="submit" class="button" name="delete" value="'.LABEL_ALIAS_DELETE.'" />'."\n".
					'</td>'."\n".
					'<td>'.ALIAS_CURRENT.' '.$this->format('[['.$alias['from_tag'].']]').' '.ALIAS_FOR.' '.$this->format($alias['to_tag']).'</td>'."\n".
					'<td><input type="hidden" name="from" value="'.$alias['from_tag'].'" /><input type="hidden" name="to" value="'.$alias['to_tag'].'" /></td>'."\n".
					'</tr>'."\n".
					'</table>'."\n";
				$form .= $this->FormClose();
			}
		}
	}
}

// display messages
if (isset($box)) echo $this->Format(' --- '.$box.' --- --- ');
// print form
if (isset($form)) print $form;
?>
</div>
