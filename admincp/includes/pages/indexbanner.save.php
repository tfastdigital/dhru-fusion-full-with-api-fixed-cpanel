<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($save_token != sha1(session_id() . $_SESSION["adminid"] . ":SaveMe123122sds2")) {
    exit("error:invalid token");
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($fullWidth != "1") {
    $fullWidth = 0;
}
dquery("UPDATE tbl_bannerslider SET `value`='" . $duration . "' WHERE `attribute`='duration'");
dquery("UPDATE tbl_bannerslider SET `value`='" . $auto . "' WHERE `attribute`='auto'");
dquery("UPDATE tbl_bannerslider SET `value`='" . $transition . "' WHERE `attribute`='transition'");
dquery("UPDATE tbl_bannerslider SET `value`='" . $easing . "' WHERE `attribute`='easing'");
dquery("UPDATE tbl_bannerslider SET `value`='" . $info_box_effect . "' WHERE `attribute`='info_box_effect'");
dquery("UPDATE tbl_bannerslider SET `value`='" . $navPosition . "' WHERE `attribute`='cp-pos'");
dquery("UPDATE tbl_bannerslider SET `value`='" . $cpalignments . "' WHERE `attribute`='cpalignments'");
dquery("UPDATE tbl_bannerslider SET `value`='" . $thumbnails . "' WHERE `attribute`='thumbnails'");
dquery("UPDATE tbl_bannerslider SET `value`='" . $timer . "' WHERE `attribute`='timer'");
dquery("UPDATE tbl_bannerslider SET `value`='" . $navbuttons . "' WHERE `attribute`='navbuttons'");
dquery("UPDATE tbl_bannerslider SET `value`='" . $nav_auto_hide . "' WHERE `attribute`='nav_auto_hide'");
dquery("UPDATE tbl_bannerslider SET `value`='" . $display_side_buttons . "' WHERE `attribute`='display_side_buttons'");
dquery("UPDATE tbl_bannerslider SET `value`='" . $mainWidth . "' WHERE `attribute`='mainWidth'");
dquery("UPDATE tbl_bannerslider SET `value`='" . $mainHeight . "' WHERE `attribute`='mainHeight'");
dquery("UPDATE tbl_bannerslider SET `value`='" . $fullWidth . "' WHERE `attribute`='fullWidth'");
echo "success:" . $LNG["datasavesuccessfully"];

?>