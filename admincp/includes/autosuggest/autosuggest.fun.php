<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", 1);
define("DEFINE_DHRU_FILE", true);
include "../../../comm.php";
if (!$_SESSION["adminid"]) {
    exit;
}
function autoSuggestoutput($query)
{
    $input = strtolower($_GET["input"]);
    $len = strlen($input);
    $limit = isset($_GET["limit"]) ? (int) $_GET["limit"] : 5;
    $aResults = [];
    $count = 0;
    $i = 0;
    for ($result = dquery($query); $noticia = mysqli_fetch_assoc($result); $i++) {
        $count++;
        $aResults[] = ["id" => $i + 1, "value" => str_replace(" ", " ", $noticia["username"]), "info" => htmlspecialchars("search result")];
    }
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    if (isset($_REQUEST["json"])) {
        header("Content-Type: application/json");
        echo "{\"results\": [";
        $arr = [];
        for ($i = 0; $i < count($aResults); $i++) {
            $arr[] = "{\"id\": \"" . $aResults[$i]["id"] . "\", \"value\": \"" . $aResults[$i]["value"] . "\", \"info\": \"\"}";
        }
        echo implode(", ", $arr);
        echo "]}";
    } else {
        header("Content-Type: text/xml");
        echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
        for ($i = 0; $i < count($aResults); $i++) {
            echo "<rs id=\"" . $aResults[$i]["id"] . "\" info=\"" . $aResults[$i]["info"] . "\">" . $aResults[$i]["value"] . "</rs>";
        }
        echo "</results>";
    }
}

?>