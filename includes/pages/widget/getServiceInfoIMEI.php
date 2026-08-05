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
installclient($pagetitle, $pageicon, $breadcrumbnav);
$serviceid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $serviceid);
$serviceid = descape($serviceid);
if ($data = mysqli_fetch_assoc(dquery("SELECT `info`,acceptterms,knowledgebase,knowledgebaseas,faq_id \r\n    FROM `tbl_services_imei` WHERE md5(id)='" . $serviceid . "'"))) {
    if ($data["knowledgebase"]) {
        $buff = "";
        $qk = dquery("select title,content from tbl_knowledgebase where id in (" . $data["knowledgebase"] . ")");
        while ($rk = mysqli_fetch_assoc($qk)) {
            $buff .= $rk["title"] . " <hr />";
            $buff .= html_entity_decode($rk["content"]) . "<br />";
        }
    } else {
        if ($data["faq_id"]) {
            $article = mysqli_fetch_assoc(dquery("select title,content from tbl_knowledgebase\r\nwhere id='" . $data["faq_id"] . "'"));
            $buff = "";
            if (!$data["knowledgebaseas"]) {
                $buff .= "<a href='" . _url("knowledgebase/article/" . $data[faq_id] . "/" . str_replace(" ", "-", $article["title"])) . ".html' target='_blank'>" . $article["title"] . "</a>";
            } else {
                $buff .= $article["title"] . " <hr />";
                $buff .= html_entity_decode($article["content"]);
            }
        }
    }
    if ($data["info"] || $buff) {
        echo "<div class=\"service-information\">" . html_entity_decode(nl2br($data["info"])) . "" . $buff . "";
    }
    if ($data["acceptterms"]) {
        echo "          <label class=\"service-toc\"><input type=\"checkbox\" name=\"accept\"/>\r\n            ";
        echo $lng_languag["agreewithterms"];
        echo "</label>\r\n        ";
    }
}

?>