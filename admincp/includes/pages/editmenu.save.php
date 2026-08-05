<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($locked && $name) {
    $data["name"] = $name;
    $data["languagevar"] = $languagevar;
    $data["display"] = $display;
    $data["icon"] = $icon;
    if ($afterloginshow) {
        $data["afterloginshow"] = 0;
    } else {
        $data["afterloginshow"] = 1;
    }
    if ($db->update("tbl_navigation", $data, "id=" . $id)) {
        echo "success:" . $LNG["datasavesuccessfully"];
    }
} else {
    if ($name && $link) {
        $data["name"] = $name;
        $data["languagevar"] = $languagevar;
        $data["external"] = $external;
        $data["newwindow"] = $openinnew;
        $data["icon"] = $icon;
        $sql = mysqli_fetch_assoc(dquery("SELECT `id`,`urlname` FROM tbl_cms_pages WHERE `id`='" . $url . "'"));
        if (stristr($link, "?")) {
            $data["link"] = $link;
        } else {
            $data["link"] = $link;
        }
        if ($afterloginshow) {
            $data["afterloginshow"] = 0;
        } else {
            $data["afterloginshow"] = 1;
        }
        $data["display"] = $display;
        $data["req_login"] = $req_login;
        if ($db->update("tbl_navigation", $data, "id=" . $id)) {
            echo "success:" . $LNG["datasavesuccessfully"];
        } else {
            echo "error:" . $LNG["datanotsave"];
        }
    } else {
        echo "error:" . $LNG["datanotsave"];
    }
}

?>