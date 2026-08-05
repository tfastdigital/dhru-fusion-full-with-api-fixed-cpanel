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
if ($language) {
    $flag = true;
    $myDirectory = opendir("../../" . $languagedirectorypath . "/");
    while ($dir = readdir($myDirectory)) {
        if ($dir == $language . ".txt") {
            $flag = false;
        }
    }
    closedir($myDirectory);
    if ($flag) {
        copy("../../" . $languagedirectorypath . "/English.txt", "../../" . $languagedirectorypath . "//" . $language . ".txt");
        echo "success:" . $LNG["datasavesuccessfully"];
    } else {
        echo "error:" . $LNG["language"] . " " . $LNG["already"] . " " . $LNG["exists"];
    }
} else {
    echo "error:" . $LNG["field"] . " " . $LNG["required"];
}

?>