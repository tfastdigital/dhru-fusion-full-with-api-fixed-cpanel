<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$tr_txt = google_translate($_GET["text"], $_GET["lang_orig"], $_GET["lang_res"]);
if ($tr_txt) {
    echo htmlspecialchars($tr_txt);
} else {
    echo "err";
}
function google_translate($s_text, $s_lang, $d_lang)
{
    $url = "http://ajax.googleapis.com/ajax/services/language/translate?v=1.0";
    $post = "q=" . urlencode($s_text) . "&langpair=" . urlencode($s_lang . "|" . $d_lang) . "&key=notsupplied";
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_REFERER, $_SERVER["SERVER_NAME"]);
    curl_setopt($c, CURLOPT_POST, 1);
    curl_setopt($c, CURLOPT_POSTFIELDS, $post);
    $b = curl_exec($c);
    curl_close($c);
    $json = json_decode($b, true);
    if ($json["responseStatus"] != 200) {
        return false;
    }
    return $json["responseData"]["translatedText"];
}

?>