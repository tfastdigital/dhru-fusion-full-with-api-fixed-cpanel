<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "./comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
$search = preg_replace("/[^0-9\\-a-zA-Z ]/i", "", $search);
$templatefile = "client_search_knowledgebase";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$tempalte_ver["products"] = NULL;
if (4 <= strlen($search)) {
    $search = explode(" ", $search);
    arsort($search);
    foreach ($search as $s) {
        if ($s) {
            $result = dquery("select * from tbl_knowledgebase where\n                 content LIKE '%" . $s . "%' \n                or title like '" . $s . " %' or title like '% " . $s . " %' or title like '% " . $s . "' LIMIT 10");
            while ($row = mysqli_fetch_assoc($result)) {
                $row["seo"] = _url("knowledgebase/artical/" . $row["id"] . "/" . preg_replace("/[^a-zA-Z0-9_]/", "-", $row["title"]));
                $tempalte_ver["knowledgebase"][] = $row;
            }
        }
    }
}
echo processSingleTemplate($templatefile);
unset($tempalte_ver);

?>