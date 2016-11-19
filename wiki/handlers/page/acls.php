<?php
/**
 * Display a form to manage ACL for the current page.
 *
 * @package		Handlers
 * @name		ACL
 *
 * @author		{@link http://wikkawiki.org/MinusF MinusF} (preliminary code cleanup, css selectors)
 * @author		{@link http://wikkawiki.org/DarTar Dario Taraborelli} (further cleanup)
 * @author		{@link http://wikkawiki.org/NilsLindenberg Nils Lindenberg} (i18n)
 * @since		Wikka 1.1.6.2
 *
 * @todo		- move main <div> to templating class
 */
global $db_prefix, $locale, $settings, $userdata;

//i18n
if (!defined('ACLS_UPDATED')) define('ACLS_UPDATED', 'Access control lists updated.');
if (!defined('NO_PAGE_OWNER')) define('NO_PAGE_OWNER', '(Nobody)');
if (!defined('NOT_PAGE_OWNER')) define('NOT_PAGE_OWNER', 'You are not the owner of this page.');
if (!defined('PAGE_OWNERSHIP_CHANGED')) define('PAGE_OWNERSHIP_CHANGED', 'Ownership changed to %s'); // %s - name of new owner
if (!defined('ACL_HEADING')) define('ACL_HEADING', '====Access Control Lists for %s===='); // %s - name of current page
if (!defined('READ_ACL_LABEL')) define('READ_ACL_LABEL', 'Read ACL for this page');
if (!defined('WRITE_ACL_LABEL')) define('WRITE_ACL_LABEL', 'Write ACL for this page');
if (!defined('COMMENT_ACL_LABEL')) define('COMMENT_ACL_LABEL', 'Comment ACL for this page');
if (!defined('SET_OWNER_LABEL')) define('SET_OWNER_LABEL', 'Set Page Owner:');
if (!defined('SET_OWNER_CURRENT_LABEL')) define('SET_OWNER_CURRENT_LABEL', '(Current Owner)');
if (!defined('SET_OWNER_PUBLIC_LABEL')) define('SET_OWNER_PUBLIC_LABEL','(Public)');
if (!defined('SET_NO_OWNER_LABEL')) define('SET_NO_OWNER_LABEL', '(Nobody - Set free)');
if (!defined('USERS_LABEL')) define('USERS_LABEL', 'Users:');
if (!defined('SELECTED_LABEL')) define('SELECTED_LABEL', 'Give access to:');
if (!defined('GROUPS_LABEL')) define('GROUPS_LABEL', 'Usergroups:');
if (!defined('INSTRUCTION_LABEL')) define('INSTRUCTION_LABEL', 'Click on the user or groupname to move it in or out of the selected box');

echo '<div class="page">'."\n"; //TODO: move to templating class

if ($this->UserIsOwner())
{
	if ($_POST)
	{
		if (isset($_POST['DeleteACL'])) {
			$this->DeleteACL($this->GetPageTag());
			// redirect back to page
			$this->Redirect($this->Href(), $message);
		} else {
			$default_read_acl	= $this->GetConfigValue('default_read_acl');
			$default_write_acl	= $this->GetConfigValue('default_write_acl');
			$default_comment_acl	= $this->GetConfigValue('default_comment_acl');
			$posted_read_acl = "";
			if (is_array($_POST['read_acl_selected'])) {
				foreach($_POST['read_acl_selected'] as $value) {
					$posted_read_acl .= $value."\n";
				}
			}
			$posted_write_acl = "";
			if (is_array($_POST['write_acl_selected'])) {
				foreach($_POST['write_acl_selected'] as $value) {
					$posted_write_acl .= $value."\n";
				}
			}
			$posted_comment_acl = "";
			if (is_array($_POST['comment_acl_selected'])) {
				foreach($_POST['comment_acl_selected'] as $value) {
					$posted_comment_acl .= $value."\n";
				}
			}
			$message = '';

			// store lists only if ACLs have previously been defined,
			// or if the posted values are different than the defaults

			$page = $this->LoadSingle('SELECT * FROM '.$this->config['table_prefix'].
			    "acls WHERE page_tag = '".mysqli_real_escape_string($this->dblink, $this->GetPageTag()).
			    "' LIMIT 1");

			if ($page ||
			    ($posted_read_acl	 != $default_read_acl	||
			     $posted_write_acl	 != $default_write_acl	||
			     $posted_comment_acl != $default_comment_acl))
			{
				$this->SaveACL($this->GetPageTag(), 'read', $this->TrimACLs($posted_read_acl));
				$this->SaveACL($this->GetPageTag(), 'write', $this->TrimACLs($posted_write_acl));
				$this->SaveACL($this->GetPageTag(), 'comment', $this->TrimACLs($posted_comment_acl));
				$message = ACLS_UPDATED;
			}

			// change owner?
			$newowner = $_POST['newowner'];

			if (($newowner != 'same') &&
			    ($this->GetPageOwner($this->GetPageTag()) != $newowner))
			{
				if ($newowner == '')
				{
					$newowner = NO_PAGE_OWNER;
				}

				$this->SetPageOwner($this->GetPageTag(), $newowner);
				$message .= sprintf(PAGE_OWNERSHIP_CHANGED, $newowner);
			}

			// redirect back to page
			$this->Redirect($this->Href(), $message);
		}
	}
	else	// show form
	{
		echo $this->Format(sprintf(ACL_HEADING, '[['.$this->tag.']]').' --- ');
		// get the list of groups
		$user_groups = getusergroups(false, false);
		// get the list of users
		$user_list = array();
		$result = dbquery("SELECT u.user_id, u.user_name FROM ".$db_prefix."users u WHERE user_status = 0 ORDER BY user_level DESC, user_name ASC");
		while ($data = dbarray($result)) {
			// no need to give yourself access. owners always have full access
			if (!iMEMBER || $data['user_id'] != $userdata['user_id']) {
				$user_list[] = $data;
			}
		}
		// populate the selected fields
		if ($this->ACLs['read_acl'] == "") {
			$selected_read_acl = array();
		} else {
			$selected_read_acl = explode("\n", $this->ACLs['read_acl']);
			foreach ($selected_read_acl as $key => $acl) {
				if ($acl{0} == "G") {
					$group = substr($acl,1);
					foreach ($user_groups as $user_group) {
						if ($user_group[0] == $group) {
							$selected_read_acl[$key] = array($acl, $user_group[1]);
							break;
						}
					}
					if (!is_array($selected_read_acl[$key])) $selected_read_acl[$key] = array($key, "?");
				} else {
					$result = dbquery("SELECT u.user_id, u.user_name FROM ".$db_prefix."users u WHERE user_status = 0 AND user_id = '$acl' LIMIT 1");
					if (dbrows($result)) {
						$data = dbarray($result);
						$selected_read_acl[$key] = array($acl, $data['user_name']);
					} else {
						unset($selected_read_acl[$key]);
					}
				}
			}
		}
		if ($this->ACLs['write_acl'] == "") {
			$selected_write_acl = array();
		} else {
			$selected_write_acl = explode("\n", $this->ACLs['write_acl']);
			foreach ($selected_write_acl as $key => $acl) {
				if ($acl{0} == "G") {
					$group = substr($acl,1);
					foreach ($user_groups as $user_group) {
						if ($user_group[0] == $group) {
							$selected_write_acl[$key] = array($acl, $user_group[1]);
							break;
						}
					}
					if (!is_array($selected_write_acl[$key])) $selected_write_acl[$key] = array($key, "?");
				} else {
					$result = dbquery("SELECT u.user_id, u.user_name FROM ".$db_prefix."users u WHERE user_status = 0 AND user_id = '$acl' LIMIT 1");
					if (dbrows($result)) {
						$data = dbarray($result);
						$selected_write_acl[$key] = array($acl, $data['user_name']);
					} else {
						unset($selected_write_acl[$key]);
					}
				}
			}
		}
		if ($this->ACLs['comment_acl'] == "") {
			$selected_comment_acl = array();
		} else {
			$selected_comment_acl = explode("\n", $this->ACLs['comment_acl']);
			foreach ($selected_comment_acl as $key => $acl) {
				if ($acl{0} == "G") {
					$group = substr($acl,1);
					foreach ($user_groups as $user_group) {
						if ($user_group[0] == $group) {
							$selected_comment_acl[$key] = array($acl, $user_group[1]);
							break;
						}
					}
					if (!is_array($selected_comment_acl[$key])) $selected_comment_acl[$key] = array($key, "?");
				} else {
					$result = dbquery("SELECT u.user_id, u.user_name FROM ".$db_prefix."users u WHERE user_status = 0 AND user_id = '$acl' LIMIT 1");
					if (dbrows($result)) {
						$data = dbarray($result);
						$selected_comment_acl[$key] = array($acl, $data['user_name']);
					} else {
						unset($selected_comment_acl[$key]);
					}
				}
			}
		}
?>
<?php echo $this->FormOpen('acls') ?>
<table class="acls" width="100%">
<tr>
	<td colspan='3' class='tbl2' align='center'>
		<strong><?php echo READ_ACL_LABEL; ?></strong>
	</td>
</tr>
<tr>
	<td width='33%' align='center'>
		<strong><?php echo USERS_LABEL; ?></strong>
	</td>
	<td width='33%' align='center'>
		<strong><?php echo SELECTED_LABEL; ?></strong>
	</td>
	<td width='33%' align='center'>
		<strong><?php echo GROUPS_LABEL; ?></strong>
	</td>
</tr>
<tr>
	<td width='33%' align='left'>
		<select multiple="multiple" size='5' id='read_acl_users' name='read_acl_users' class='textbox' style='width:175px;' onclick='return AddUser(this, "r");'>
			<?php
			foreach($user_list as $entry) {
				echo "<option value='".$entry['user_id']."'>".$entry['user_name']."</option>\n";
			}
			?>
		</select>
	</td>
	<td width='33%'>
		<select multiple="multiple" size='5' name='read_acl_selected[]' id='read_acl_selected' class='textbox' style='width:175px' onclick='return RemoveSelected(this);'>
			<?php
			foreach($selected_read_acl as $entry) {
				echo "<option value='".$entry[0]."'>".($entry[0]{0}=="G"?"@":"").$entry[1]."</option>\n";
			}
			?>
		</select>
	</td>
	<td width='33%' align='right'>
		<select multiple="multiple" size='5' id='read_acl_groups' name='read_acl_groups' class='textbox' style='width:175px;' onclick='return AddGroup(this, "r");'>
			<?php
			foreach($user_groups as $entry) {
				echo "<option value='G".$entry[0]."'>".$entry[1]."</option>\n";
			}
			?>
		</select>
	</td>
</tr>
<tr>
	<td colspan='3' align='center'>
		<br />
	</td>
</tr>
<tr>
	<td colspan='3' class='tbl2' align='center'>
		<strong><?php echo WRITE_ACL_LABEL; ?></strong>
	</td>
</tr>
<tr>
	<td width='33%' align='center'>
		<strong><?php echo USERS_LABEL; ?></strong>
	</td>
	<td width='33%' align='center'>
		<strong><?php echo SELECTED_LABEL; ?></strong>
	</td>
	<td width='33%' align='center'>
		<strong><?php echo GROUPS_LABEL; ?></strong>
	</td>
</tr>
<tr>
	<td width='33%' align='left'>
		<select multiple="multiple" size='5' id='write_acl_users' name='write_acl_users' class='textbox' style='width:175px;' onclick='return AddUser(this, "w");'>
			<?php
			foreach($user_list as $entry) {
				echo "<option value='".$entry['user_id']."'>".$entry['user_name']."</option>\n";
			}
			?>
		</select>
	</td>
	<td width='33%'>
		<select multiple="multiple" size='5' name='write_acl_selected[]' id='write_acl_selected' class='textbox' style='width:175px' onclick='return RemoveSelected(this);'>
			<?php
			foreach($selected_write_acl as $entry) {
				echo "<option value='".$entry[0]."'>".($entry[0]{0}=="G"?"@":"").$entry[1]."</option>\n";
			}
			?>
		</select>
	</td>
	<td width='33%' align='right'>
		<select multiple="multiple" size='5' id='write_acl_groups' name='write_acl_groups' class='textbox' style='width:175px;' onclick='return AddGroup(this, "w");'>
			<?php
			foreach($user_groups as $entry) {
				echo "<option value='G".$entry[0]."'>".$entry[1]."</option>\n";
			}
			?>
		</select>
	</td>
</tr>
<tr>
	<td colspan='3' align='center'>
		<br />
	</td>
</tr>
<tr>
	<td colspan='3' class='tbl2' align='center'>
		<strong><?php echo COMMENT_ACL_LABEL; ?></strong>
	</td>
</tr>
<tr>
	<td width='33%' align='center'>
		<strong><?php echo USERS_LABEL; ?></strong>
	</td>
	<td width='33%' align='center'>
		<strong><?php echo SELECTED_LABEL; ?></strong>
	</td>
	<td width='33%' align='center'>
		<strong><?php echo GROUPS_LABEL; ?></strong>
	</td>
</tr>
<tr>
	<td width='33%' align='left'>
		<select multiple="multiple" size='5' id='comment_acl_users' name='comment_acl_users' class='textbox' style='width:175px;' onclick='return AddUser(this, "c");'>
			<?php
			foreach($user_list as $entry) {
				echo "<option value='".$entry['user_id']."'>".$entry['user_name']."</option>\n";
			}
			?>
		</select>
	</td>
	<td width='33%'>
		<select multiple="multiple" size='5' name='comment_acl_selected[]' id='comment_acl_selected' class='textbox' style='width:175px' onclick='return RemoveSelected(this);'>
			<?php
			foreach($selected_comment_acl as $entry) {
				echo "<option value='".$entry[0]."'>".($entry[0]{0}=="G"?"@":"").$entry[1]."</option>\n";
			}
			?>
		</select>
	</td>
	<td width='33%' align='right'>
		<select multiple="multiple" size='5' id='comment_acl_groups' name='comment_acl_groups' class='textbox' style='width:175px;' onclick='return AddGroup(this, "c");'>
			<?php
			foreach($user_groups as $entry) {
				echo "<option value='G".$entry[0]."'>".$entry[1]."</option>\n";
			}
			?>
		</select>
	</td>
</tr>
<tr>
	<td colspan='3' align='center'>
		<br />
		<strong><?php echo INSTRUCTION_LABEL; ?></strong>
	</td>
</tr>
<tr>
	<td>
	<br />
	<input type="submit" name="storeACL" class="button" value="Store ACLs" onclick="PrepareSave();" />
	<?php
	if ($this->LoadACL($this->GetPageTag(), "read", false)) {
		?>
		<input type="submit" name="DeleteACL" class="button" value="Delete ACLs" onclick="return ConfirmDelete();" />
		<?php
	}
	?>
	<input type="button" class="button" value="Cancel" onclick="history.back();" />
	</td>

	<td colspan='2' align="right">
	<br />
	<strong><?php echo SET_OWNER_LABEL; ?></strong>&nbsp;
	<select name="newowner">
	<option value="same"><?php echo $this->GetPageOwner().' '.SET_OWNER_CURRENT_LABEL ?></option>
	<option value="(Public)"><?php echo SET_OWNER_PUBLIC_LABEL; ?></option>
	<option value=""><?php echo SET_NO_OWNER_LABEL; ?></option>
<?php
		if ($users = $this->LoadUsers())
		{
			foreach($users as $user)
			{
				echo "\t".'<option value="'.$this->htmlspecialchars_ent($user['name']).'">'.$user['name'].'</option>'."\n";
			}
		}
?>
	</select>
	</td>
</tr>
</table>
<script type='text/javascript'>
	function AddUser(fld, fldtype) {
		var i = 0;
		switch (fldtype) {
			case "c":
				var listLength = document.getElementById("comment_acl_selected").length;
				for (i=0; i < listLength; i++) {
					if (document.getElementById("comment_acl_selected").options[i].value == fld.options[fld.selectedIndex].value) return false;
				}
				document.getElementById("comment_acl_selected").options[listLength] = new Option(fld.options[fld.selectedIndex].text, fld.options[fld.selectedIndex].value);
				break;
			case "r":
				var listLength = document.getElementById("read_acl_selected").length;
				for (i=0; i < listLength; i++) {
					if (document.getElementById("read_acl_selected").options[i].value == fld.options[fld.selectedIndex].value) return false;
				}
				document.getElementById("read_acl_selected").options[listLength] = new Option(fld.options[fld.selectedIndex].text, fld.options[fld.selectedIndex].value);
				break;
			case "w":
				var listLength = document.getElementById("write_acl_selected").length;
				for (i=0; i < listLength; i++) {
					if (document.getElementById("write_acl_selected").options[i].value == fld.options[fld.selectedIndex].value) return false;
				}
				document.getElementById("write_acl_selected").options[listLength] = new Option(fld.options[fld.selectedIndex].text, fld.options[fld.selectedIndex].value);
				break;
		}
		return false;
	}

	function AddGroup(fld, fldtype) {
		var i = 0;
		switch (fldtype) {
			case "c":
				var listLength = document.getElementById("comment_acl_selected").length;
				document.getElementById("comment_acl_selected").options[listLength] = new Option("@"+fld.options[fld.selectedIndex].text, fld.options[fld.selectedIndex].value);
				for (i=0; i < listLength; i++) {
					if (document.getElementById("comment_acl_selected").options[i].value == fld.options[fld.selectedIndex].value) return false;
				}
				break;
			case "r":
				var listLength = document.getElementById("read_acl_selected").length;
				for (i=0; i < listLength; i++) {
					if (document.getElementById("read_acl_selected").options[i].value == fld.options[fld.selectedIndex].value) return false;
				}
				document.getElementById("read_acl_selected").options[listLength] = new Option("@"+fld.options[fld.selectedIndex].text, fld.options[fld.selectedIndex].value);
				break;
			case "w":
				var listLength = document.getElementById("write_acl_selected").length;
				for (i=0; i < listLength; i++) {
					if (document.getElementById("write_acl_selected").options[i].value == fld.options[fld.selectedIndex].value) return false;
				}
				document.getElementById("write_acl_selected").options[listLength] = new Option("@"+fld.options[fld.selectedIndex].text, fld.options[fld.selectedIndex].value);
				break;
		}
		return false;
	}

	function RemoveSelected(fld) {
		fld.options[fld.selectedIndex] = null;
		return false;
	}

	function PrepareSave() {
		var i = 0;
		var listlength = 0;
		listlength = document.getElementById("comment_acl_selected").options.length;
		for (var i = 0; i < listlength; i++) {
			document.getElementById("comment_acl_selected").options[i].selected = true;
		}
		listlength = document.getElementById("read_acl_selected").options.length;
		for (var i = 0; i < listlength; i++) {
			document.getElementById("read_acl_selected").options[i].selected = true;
		}
		listlength = document.getElementById("write_acl_selected").options.length;
		for (var i = 0; i < listlength; i++) {
			document.getElementById("write_acl_selected").options[i].selected = true;
		}
	}

	function ConfirmDelete() {
		return confirm("Are you sure you want to delete the ACL for this page?");
	}

</script>

<?php
		print($this->FormClose());
	}
}
else
{
	echo '<em>'.NOT_PAGE_OWNER.'</em>'."\n";
}
echo '</div>'."\n" //TODO: move to templating class
?>
