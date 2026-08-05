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
if (substr(sprintf("%o", fileperms(ROOTDIR . "/configs/config.php")), -4) != "0600") {
    if ($encrykey) {
        $fileee = ROOTDIR . "/configs/config.php";
        include ROOTDIR . "/configs/config.php";
        if (!$passencold || $passencold == "") {
            $oldvalue = "9486";
        } else {
            $oldvalue = $passenc;
        }
        $tempp = fopen($fileee, "r");
        $contentss = fread($tempp, filesize($fileee));
        fclose($tempp);
        $md5 = md5($encrykey);
        $contentss = str_replace(" = ", "=", $contentss);
        $contentss = str_replace("= ", "=", $contentss);
        $contentss = str_replace(" =", "=", $contentss);
        if (deregi("\\\$passenc", $contentss)) {
            $contentss = preg_replace("/\\\$passenc=\\\"(.*?)\\\";/", "\$passenc=\"" . $md5 . "\";", $contentss);
            $contentss = preg_replace("/\\\$passenc='(.*?)';/", "\$passenc=\"" . $md5 . "\";", $contentss);
            $contentss = preg_replace("/\\\$passencold=\\\"(.*?)\\\";/", "\$passencold=\"" . $oldvalue . "\";", $contentss);
            $contentss = preg_replace("/\\\$passencold='(.*?)';/", "\$passencold=\"" . $oldvalue . "\";", $contentss);
        } else {
            $contentss = preg_replace("/\\?>/", "\$passenc=\"" . $md5 . "\";" . "\n" . "\$passencold=\"" . $oldvalue . "\";" . "\n" . "?>", $contentss);
        }
        $tempp = fopen($fileee, "w");
        fwrite($tempp, $contentss);
        fclose($tempp);
        dquery("update tblUsers set lastpassreset='1111111111'");
        echo "success:" . $LNG["datasavesuccessfully"];
    } else {
        echo "error: Encryption key should not blank";
    }
} else {
    echo "error: Config File is not writable";
}

?>