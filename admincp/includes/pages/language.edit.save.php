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
$filed = str_replace(".txt", "", $language);
if (is_file("../language/" . $filed . ".custom.txt")) {
    include "../language/" . $filed . ".custom.txt";
} else {
    include "../language/" . $language;
}
$languagevars = $LNG;
if (is_array($lang)) {
    foreach ($lang as $k => $v) {
        $languagevars[$k] = $v;
    }
}
$stringData = "<?\n";
if (is_array($languagevars)) {
    foreach ($languagevars as $k => $v) {
        $v = str_replace("'", "\\'", $v);
        $stringData .= "\$LNG['" . $k . "']='" . $v . "';" . "\n";
    }
}
$stringData .= "?>";
$filed = str_replace(".txt", "", $language);
$language = $filed . ".custom.txt";
$myFile = "../language/" . $language;
$fh = fopen($myFile, "w") or exit("can't open file");
fwrite($fh, $stringData);
fclose($fh);
echo "success:" . $LNG["datasavesuccessfully"];

?>