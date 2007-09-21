<?php /* $Id: navIcons.php 12232 2005-12-08 23:32:42Z jenst $ */ ?>
<?php

if ($gallery->direction == "ltr") {
    $fpImgUrl= getImagePath('icons/nav_first.gif');
    $ppImgUrl= getImagePath('icons/nav_prev.gif');
    $npImgUrl= getImagePath('icons/nav_next.gif');
    $lpImgUrl= getImagePath('icons/nav_last.gif');
} else {
    $fpImgUrl= getImagePath('icons/nav_last.gif');
    $ppImgUrl= getImagePath('icons/nav_next.gif');
    $npImgUrl= getImagePath('icons/nav_prev.gif');
    $lpImgUrl= getImagePath('icons/nav_first.gif');
}
?>