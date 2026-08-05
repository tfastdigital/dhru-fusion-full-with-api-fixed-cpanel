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
if (($name || $languagevar) && $link) {
    $data["name"] = $name;
    $data["master"] = $master;
    $data["languagevar"] = $languagevar;
    $data["groupid"] = $groupid;
    $data["icon"] = $icon;
    if ($external) {
        $data["external"] = 1;
    }
    if ($openinnew) {
        $data["newwindow"] = 1;
    }
    if ($groupid == 0) {
        $sql = mysqli_fetch_assoc(dquery("SELECT `order` FROM tbl_navigation WHERE `groupid`='0' ORDER BY `order` DESC"));
    } else {
        $sql = mysqli_fetch_assoc(dquery("SELECT `order` FROM tbl_navigation WHERE `groupid`='" . $groupid . "' ORDER BY `order` DESC"));
    }
    $data["order"] = $sql["order"] + 1;
    $sql = mysqli_fetch_assoc(dquery("SELECT `id`,`urlname` FROM tbl_cms_pages WHERE `id`='" . $url . "'"));
    if ($url != "") {
        $link = _url("pages/" . $link);
    }
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
    if ($db->insert("tbl_navigation", $data)) {
        echo "success:" . $LNG["datasavesuccessfully"];
    } else {
        echo "error:" . $LNG["datanotsave"];
    }
} else {
    echo "error: Page Name and Link Required";
}

?>