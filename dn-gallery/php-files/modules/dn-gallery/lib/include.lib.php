<?
/**
*	I N C L U D E S		*
**/

require_once('lib/session.lib.php');

require_once('classes/ext/adodb/adodb.inc.php');
require_once('classes/ext/adodb/pivottable.inc.php');

require_once('classes/ext/phpThumb/phpthumb.functions.php');
require_once('classes/ext/phpThumb/phpthumb.bmp.php');

require_once("classes/ext/PHPMailer/class.phpmailer.php");
require_once("classes/ext/PHPMailer/class.smtp.php");

require_once('classes/db/DBObj.class.php');
require_once('classes/db/DBConnection.class.php');

require_once('classes/http/Http.class.php');
require_once('classes/http/History.class.php');

require_once('classes/form/Form.class.php');
require_once('classes/form/SearchPanel.class.php');
require_once('classes/form/TextField.class.php');
require_once('classes/form/TextArea.class.php');
require_once('classes/form/ComboBox.class.php');
require_once('classes/form/PopupSelector.class.php');
require_once('classes/form/HiddenField.class.php');
require_once('classes/form/CheckBox.class.php');
require_once('classes/form/Password.class.php');
require_once('classes/form/FileUpload.class.php');

require_once('classes/ui/Actions.class.php');
require_once('classes/ui/Calendar.class.php');
require_once('classes/ui/ErrorPanel.class.php');
require_once('classes/ui/TabPanel.class.php');
require_once('classes/ui/BreadCrump.class.php');
require_once('classes/ui/PivotTable.class.php');
require_once('classes/ui/DataGrid.class.php');
require_once('classes/ui/MasterDetail.class.php');

require_once('classes/util/DateUtil.class.php');
require_once('classes/util/ImgUtil.class.php');
require_once('classes/util/Captcha.class.php');

require_once('lib/functions/string.lib.php');
require_once('lib/functions/dir.lib.php');
require_once('lib/functions/mail.lib.php');
require_once('lib/functions/import.lib.php');
require_once('lib/functions/num2str.lib.php');
require_once('lib/functions/unzip.lib.php');
require_once('lib/functions/image.lib.php');

//PEAR
//require_once("Mail.php"); 
import_all();
?>