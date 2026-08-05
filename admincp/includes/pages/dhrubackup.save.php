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
if (isset($_POST["dhrubackupoption"])) {
    $_POST["dhrubackupoption"] = 1;
} else {
    $_POST["dhrubackupoption"] = 0;
}
foreach ($_POST as $key => $v) {
    saveSettings($key, $v);
}
if ($dhrubackupkey) {
    $fileee = ROOTDIR . "/configs/config.php";
    include ROOTDIR . "/configs/config.php";
    $tempp = fopen($fileee, "r");
    $contentss = fread($tempp, filesize($fileee));
    fclose($tempp);
    $md5 = md5($encrykey);
    $contentss = str_replace(" = ", "=", $contentss);
    $contentss = str_replace("= ", "=", $contentss);
    $contentss = str_replace(" =", "=", $contentss);
    if (deregi("\\\$dhrubackupserviceaccesskey", $contentss)) {
        $contentss = preg_replace("/\\\$dhrubackupserviceaccesskey=\\\"(.*?)\\\";/", "\$dhrubackupserviceaccesskey=\"" . $dhrubackupkey . "\";", $contentss);
        $contentss = preg_replace("/\\\$dhrubackupserviceaccesskey='(.*?)';/", "\$dhrubackupserviceaccesskey=\"" . $dhrubackupkey . "\";", $contentss);
        $contentss = preg_replace("/\\\$donloaddirpath=\\\"(.*?)\\\";/", "\$donloaddirpath=\"" . $donloaddirpath . "\";", $contentss);
        $contentss = preg_replace("/\\\$donloaddirpath='(.*?)';/", "\$donloaddirpath=\"" . $donloaddirpath . "\";", $contentss);
    } else {
        $contentss = preg_replace("/\\?>/", "\$dhrubackupserviceaccesskey=\"" . $dhrubackupkey . "\";" . "\n" . "\$donloaddirpath=\"" . $donloaddirpath . "\";" . "\n" . "?>", $contentss);
    }
    $tempp = fopen($fileee, "w");
    fwrite($tempp, $contentss);
    fclose($tempp);
}
echo "success:" . $LNG["datasavesuccessfully"];

?>