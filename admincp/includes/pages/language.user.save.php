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
    ob_start();
    $filed = str_replace(".txt", "", $language);
    if (is_file("../../" . $languagedirectorypath . "/" . $filed . ".custom.txt")) {
        include "../../" . $languagedirectorypath . "/" . $filed . ".custom.txt";
    } else {
        include "../../" . $languagedirectorypath . "/" . $language;
    }
    $lang_cont = ob_get_contents();
    ob_end_clean();
    eval($lang_cont);
    $languagevars = $lng_languag;
    if (is_array($lang)) {
        foreach ($lang as $k => $v) {
            $languagevars[$k] = $v;
        }
    }
    if (is_array($languagevars)) {
        foreach ($languagevars as $k => $v) {
            $v = str_replace("'", "\\'", $v);
            $stringData .= "\$lng_languag['" . $k . "']='" . $v . "';" . "\n";
        }
    }
    $filed = str_replace(".txt", "", $language);
    $language = $filed . ".custom.txt";
    $myFile = "../../" . $languagedirectorypath . "/" . $language;
    $fh = fopen($myFile, "w") or exit("can't open file");
    fwrite($fh, $stringData);
    fclose($fh);
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    echo "error: Something Wrong";
}

?>