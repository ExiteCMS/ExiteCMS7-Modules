<?php
/*
 * Created on 10 Okt 06
 *
 * Author Adam
 * FileName logout.php
 */
 
$_SESSION["uid"] = "";
$_SESSION["pwd"] = "";
$_SESSION["gid"] = "";
$_SESSION["pid"] = "";
$_SESSION["HTTP_HISTORY"] = "";
$_SESSION["POST_VARS"] = "";
unset($_SESSION);

echo "<script>location.href='index.php';</script>";
?>
