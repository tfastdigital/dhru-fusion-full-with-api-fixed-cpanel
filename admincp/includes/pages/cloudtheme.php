<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 539;
checkPagePermission($pageid);
echo " \n<style>    \n    .banner-box {\n    border: 1px solid #cccccc;    \n    box-sizing: border-box;\n    float: left;\n    height: 210px;\n    margin: 17px;\n    padding: 0;\n    position: relative;\n    background: #eee;\n}\n    .dbanner{background-repeat: no-repeat;background-size: cover;}    \n    .tag-free {\n        bottom: 13px;\n        color: #008000;\n        font-size: 15px;\n        position: absolute;\n        right: 11px;\n        text-transform: uppercase;\n    }\n    .tag-install{background: black;color:white;padding:8px 10px;display:block}\n    .downloadb{background: black;color:white;padding:2px 10px;bottom:20px;left:40%;margin-top:5px}\n    \n \n    a.btn{margin-top:4px;}\n    .banner-box .in-button{display:none}\n    .banner-box:hover .in-button{display: block;}\n    \n.temp-tab {    \n    text-align: left;\n}\n.temp-tab li{display:inline-block;cursor: pointer;padding:5px;margin-right:10px;}\n.temp-tab li.active {\n    background: #ffffff none repeat scroll 0 0;\n    color: #d66061;\n    margin-bottom: -1px;\n    padding: 10px 15px;\n} \n    \n    \n</style>\n \n";
$domain = explode(",", $licinfo["validdomain"]);
$domain = $domain[0];
dquery("CREATE TABLE IF NOT EXISTS `tbl_theme` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `name` varchar(255) NOT NULL,  `cloud` int(11) NOT NULL,  PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
$post["action"] = "listtheme";
$post["version"] = $config["version"];
$post["license"] = $licinfo["_lickey"];
$data = initCurl("http://banners.dhru.org/index.php", $post);
$banner = json_decode($data, true);
foreach ($banner as $ban) {
    $paidunpaid[] = $ban["paidunpaid"];
}
$paidunpaid = array_unique($paidunpaid);
if ($banner["error"]) {
    echo $banner["error"];
    exit;
}
echo "    \n\n<div id=\"content\">\n<div  class=\"groupstabes\">\n     \n    <ul class=\"temp-tab\">          \n        ";
foreach ($paidunpaid as $temp) {
    echo "<li id='" . $temp . "' class='select-temp'>" . $temp . " Template</li>";
}
echo "        \n    </ul>\n    <div class=\"clear\"></div>    \n \n  \n  <div class=\"groupstabescontant\" style=\"text-align: center;\">  \n";
foreach ($banner as $ban) {
    echo "    \n \n    <div class=\"banner-box ";
    echo $ban["paidunpaid"];
    echo "\" style=\"position: relative;\">\n       \n    <input type=\"hidden\" name=\"id\" value=\"";
    echo $ban["id"];
    echo "\" />\n \n    <img class=\"dbanner\" src=\"http://banners.dhru.org/themes/";
    echo $ban["img_title"];
    echo ".jpg\" alt=\"";
    echo $ban["img_title"];
    echo "\" title=\"";
    echo $ban["img_title"];
    echo "\" style=\"border-radius:10px 10px 0 0\" />      \n  \n  <div style=\"position: absolute;bottom:10px;width:100%;text-align:center;\" class=\"in-button\"> \n   ";
    if (mysqli_num_rows(dquery("select id from tbl_theme where cloud=" . $ban["id"] . " order by id DESC"))) {
        echo "    <input type=\"button\" class=\"downloadb btn btn-primary\"  onclick=\"load_subpage('main2.php?page=cloudprocess&id=";
        echo $ban["id"];
        echo "&type=theme&update=true','Theme Update');\" name=\"install\" value=\"Update\" />     \n    ";
    } else {
        echo " <table><tr><td>   \n   <a class=\"btn btn-default\"  href=\"http://fusiondemo.dhru.com/?template=";
        echo $ban["img_title"];
        echo "\" target=\"_blank\">Preview</a>  \n  </td><td>\n \n";
        if ($ban["paidunpaid"] == "Paid" && !isset($ban["buy"])) {
            echo "  \n  <form action=\"https://cp.dhru.com/cart/\" method=\"post\" target=\"_blank\">\n    <input type=\"hidden\" value=\"29004\" name=\"pid\"/>\n    <input type=\"hidden\" value=\"";
            echo $ban["id"];
            echo "\" name=\"tmpid\"/>\n    <input type=\"hidden\" value=\"";
            echo base64_encode($licinfo["_lickey"]);
            echo "\" name=\"lkey\"/>\n    <input type=\"hidden\" value=\"";
            echo $domain;
            echo "\" name=\"domain\"/>\n    <input type=\"submit\" class=\"downloadb btn btn-primary\" name=\"Buy Now\" value=\"Buy Now\" /> \n  </form>\n";
        } else {
            echo "            <input type=\"button\" class=\"downloadb btn btn-primary\"  onclick=\"load_subpage('main2.php?page=cloudprocess&id=";
            echo $ban["id"];
            echo "&type=theme','Buy Theme');\" name=\"install\" value=\"Download\" />\n        ";
        }
        echo "  \n</td></tr>\n</table>       \n    ";
    }
    echo "   </div>  \n      \n    \n    </div>\n    \n    \n";
}
echo " \n <div class=\"clear\"></div>\n \n</div></div></div>\n\n<p align=\"center\" class=\"fixedbtn\"><input type=\"button\" onclick=\"load_subpage('main2.php?page=cloudprocess&type=theme&checkpurchase=1','Check for purchase');\" class=\"btn\" id=\"btnaddclient\" value=\"Check for purchase\" /></p>\n\n\n<script>\n    \$(document).ready(function(){             \n       \$('.select-temp').click(function(){\n            \$('.select-temp.active').removeClass('active');\n            \$(this).addClass('active');            \n            \$('.banner-box').hide();            \n            \$('.'+\$(this).attr('id')).show();           \n       });\n       \$('.select-temp:first-child').click(); \n    });\n</script>\n \n";
$fileverioncheck = "6.1.0";

?>