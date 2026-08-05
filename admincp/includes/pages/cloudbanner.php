<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 538;
checkPagePermission($pageid);
echo "<link rel=\"stylesheet\" media=\"screen\" type=\"text/css\" href=\"../includes/colorpicker/css/colorpicker.css\" />\n\n    \n<!--\n<script>\n    \$(document).ready(function() {        \n        \$(\"img.dbanner\").Lazy();       \n    });\n</script>\n--> \n<style>    \n.banner-box {\n    border: 1px solid #cccccc;\n    box-sizing: border-box;\n    display: none;\n    float: left;\n    height: 210px;\n    margin: 0 10px 10px 0;\n    padding: 10px;\n    position: relative;\n    width: 320px;\n}\n.banner-box.Other-Template{height:150px;}\n.dbanner{background-repeat: no-repeat;background-size: cover;max-width:300px;}    \n.tag-free {\n    bottom: 13px;\n    color: #008000;\n    font-size: 15px;\n    position: absolute;\n    right: 11px;\n    text-transform: uppercase;\n}\n.tag-install{background: black;color:white;padding:8px 10px;display:block}\n.downloadb{background: black;color:white;padding:2px 10px;bottom:10px;left:10px;margin-top:5px;position: absolute;}\n.temp-tab {    \n    text-align: left;\n}\n.temp-tab li{display:inline-block;cursor: pointer;padding:5px;margin-right:10px;}\n.temp-tab li.active {\n    background: #ffffff none repeat scroll 0 0;\n    color: #d66061;\n    margin-bottom: -1px;\n    padding: 10px 15px;\n}\n \n    \n</style>\n\n   \n";
dquery("ALTER TABLE `tbl_bannerslider_banners` ADD `other_html` TEXT NOT NULL");
dquery("ALTER TABLE `tbl_bannerslider_banners` ADD `cloud` int(1) NOT NULL");
$post["action"] = "listbanner";
$post["version"] = "2018";
$data = initCurl("http://banners.dhru.org/index.php", $post);
$banner = json_decode($data, true);
foreach ($banner as $ban) {
    $templates[] = $ban["fortemp"];
}
$templates = array_unique($templates);
echo "    \n\n<div id=\"content\">\n<div  class=\"groupstabes\">\n         \n    <ul class=\"temp-tab\">\n        Display For Template : \n        ";
foreach ($templates as $temp) {
    echo "<li id='" . $temp . "' class='select-temp'>" . $temp . "</li>";
}
echo "        \n    </ul>\n    <div class=\"clear\"></div>\n   \n  <div class=\"groupstabescontant\" style=\"text-align: center;\">  \n   \n   \n";
foreach ($banner as $ban) {
    echo "    \n \n    <div class=\"banner-box ";
    echo $ban["fortemp"];
    echo "\">\n        <form method=\"post\" >\n    <input type=\"hidden\" name=\"id\" value=\"";
    echo $ban["id"];
    echo "\" />\n \n     \n        <img class=\"dbanner\" src=\"templates/default/images/loading.gif\"  data-original=\"http://banners.dhru.org/thumb/";
    echo $ban["img_title"];
    echo ".jpg\" alt=\"";
    echo $ban["img_title"];
    echo "\" title=\"";
    echo $ban["img_title"];
    echo "\"  />      \n ";
    if (mysqli_num_rows(dquery("select id from tbl_bannerslider_banners\n    where cloud=" . $ban["id"] . " order by id DESC"))) {
        echo "    <span class=\"tag-install\">Installed</span>\n    ";
    } else {
        if (!$ban["isfree"]) {
            echo "            <span class=\"tag-free\">Free</span>";
        }
        if (!$DEMOMODE) {
            echo "\n     <input type=\"button\" class=\"downloadb btn btn-primary\" style=\"display: block;\"\n            onclick=\"load_subpage('main2.php?page=cloudprocess&id=";
            echo $ban["id"];
            echo "&type=banner','Banner Download');\"\n            name=\"install\" value=\"Download\"/>\n     ";
        }
    }
    echo "    </form>\n    </div>\n    \n    \n";
}
echo " \n <div class=\"clear\"></div>\n</div></div></div>\n\n<script type='text/javascript' src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/lazyload.js\" type=\"text/javascript\"></script>\n\n<script>\n\tnew LazyLoad();\n</script>\n\n<script>\n    \$(document).ready(function(){\n       \$('.select-temp').click(function(){\n            \$('.select-temp.active').removeClass('active');\n            \$(this).addClass('active');\n            \$('.banner-box').hide();\n            \$('.'+\$(this).attr('id')).show();\n       });\n       \$('.select-temp:first-child').click();\n    });\n</script>\n\n";
$fileverioncheck = "6.1.0";

?>