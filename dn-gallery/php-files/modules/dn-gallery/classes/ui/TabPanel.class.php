<?php
/*
 * ErrorPanel.class.php
 *
 * Created on April 19, 2007, 2:42 AM
 *
 */

/**
 *
 * @author Adam
 */

class TabPanel 

{
	var $tabsName = array("");
	var $tabsModule = array("");
	var $tabsAction = array("");
	var $queryString = array("");
	var $width = array("");

    function TabPanel($tabsName = array(),$tabsModule = array(),$tabsAction = array(),$queryString = array(),$width = array()) 
	{
		$this->tabsName = $tabsName;
		$this->tabsModule = $tabsModule;
		$this->tabsAction = $tabsAction;
		$this->queryString = $queryString;
		$this->width = $width;
    }

	function render() 
	{
		global $mod;
		global $act;
		global $do;
		$tabsName = $this->tabsName;
		$tabsModule = $this->tabsModule;
		$tabsAction = $this->tabsAction;
		$queryString = $this->queryString;
		$width = $this->width;
		echo '
				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr>
					  <td width="10">&nbsp;</td>
                      <td width="1" height="28"><img src="images/tab/separator.png" width="1" height="28"></td>
			';
			while (list($key,$val) = each($this->tabsName)) {
					if ($width[$key] == "") {
						$width[$key] = "185";
					}
					$width2[$key] = $width[$key] - 10;
					if ($tabsModule[$key] == $mod && $tabsAction[$key] == $act) {
						echo '
                      <td width="'.$width[$key].'"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="9" height="28"><img src="images/tab/tabx_01.png" width="9" height="28"></td>
                          <td nowrap background="images/tab/tabx_02.png" valign="middle"  onclick="location.href=\'index.php?mod='.$tabsModule[$key].'&act='.$tabsAction[$key].'&do='.$do.'&'.$queryString[$key].'\';" style="cursor:pointer;"  title="'.$val.'"><div align="center" class="style3">&nbsp;<B>'.$val.'</B>&nbsp;</div></td>
                          <td width="9"><img src="images/tab/tabx_03.png" width="9" height="28"></td>
                        </tr>
                      </table></td>
						';
					}
					else {
						echo '
                      <td nowrap width="'.$width2[$key].'" valign="middle" background="images/tab/off.png" onclick="location.href=\'index.php?mod='.$tabsModule[$key].'&act='.$tabsAction[$key].'&do='.$do.'&'.$queryString[$key].'\';" style="cursor:pointer;" title="'.$val.'"><div align="center"><span class="style3">&nbsp;<B>'.$val.'</B>&nbsp;</span></div></td>
						 ';
					}
                    echo '
						<td width="1" height="28"><img src="images/tab/separator.png" width="1" height="28"></td>
						';
			}
		echo '
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
		<tr>
           <td width="100%" height="2"><img src="images/tab/separator.png" width="100%" height="2"></td>
		</tr>
      </table> 
			';
	}
}
?>
