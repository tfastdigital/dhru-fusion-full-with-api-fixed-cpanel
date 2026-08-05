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
require_once "../../comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$art = preg_replace("/[^0-9\\-a-zA-Z ]/i", "", $art);
$search = explode(" ", $art);
arsort($search);
$result = [];
if ($art) {
    foreach ($search as $s) {
        if ($s && mysqli_num_rows(dquery("select * from tbl_knowledgebase\r\n            where title like '" . $s . " %' or title like '% " . $s . " %' or title like '% " . $s . "'"))) {
            $q = dquery("select * from tbl_knowledgebase where \r\n                title like '" . $s . " %' or title like '% " . $s . " %' or title like '% " . $s . "'");
            while ($r = mysqli_fetch_assoc($q)) {
                $result[$r["id"]] = $r["title"];
            }
        }
    }
    foreach ($result as $k => $v) {
        if (stripos($v, $art) !== false) {
            $newarr[$k] = $v;
            unset($result[$k]);
        }
    }
    foreach ($result as $k => $v) {
        $newarr[$k] = $v;
        unset($result[$k]);
    }
    foreach ($newarr as $k => $v) {
        echo "<li onclick=\"location.href='knowledgebase.php?currentpage=knowledgebase&artical=";
        echo $k;
        echo "'\" id=\"art_";
        echo $k;
        echo "\">";
        echo $v;
        echo "</li>\r\n";
    }
    foreach ($search as $s) {
        if ($s && mysqli_num_rows(dquery("select * from tbl_knowledgebasecat\r\n            where category like '%" . $s . "%'"))) {
            $q = dquery("select * from tbl_knowledgebasecat where \r\n                category like '%" . $s . "%'");
            while ($r = mysqli_fetch_assoc($q)) {
                $catres[$r["id"]] = $r["category"];
            }
        }
    }
    foreach ($catres as $k => $v) {
        echo "<li onclick=\"location.href='/knowledgebase/";
        echo $k;
        echo "/";
        echo str_replace(" ", "-", $v);
        echo "'\" id=\"cats_";
        echo $k;
        echo "\"> <strong>";
        echo $v;
        echo "</strong></li>\r\n";
    }
}

?>