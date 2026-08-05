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
require_once "./comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require ROOTDIR . "/includes/customfield.fun.inc.php";
require ROOTDIR . "/includes/clients.fun.inc.php";
if ($editpage) {
    include ROOTDIR . "/includes/3rdparty/editor/editor.php";
}
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
if ($editpage) {
    if ($id) {
        $pag = mysqli_fetch_assoc(dquery("select * from tbl_cms_pages_store where md5(id)='" . $id . "'"));
        echo "    <form method=\"post\" enctype=\"multipart/form-data\">\n        <input type=\"hidden\" name=\"editpage\" value=\"";
        echo $id;
        echo "\" />\n        \n        <div class=\"form-group\">\n         <label> ";
        echo $lng_languag["page"];
        echo "</label>\n         <input type=\"text\" name=\"urlname\" class=\"form-control\" value=\"";
        echo $pag["urlname"];
        echo "\" /> \n        </div>\n        \n        <div class=\"form-group\">\n        <label> ";
        echo $lng_languag["title"];
        echo "</label>\n        <td><input type=\"text\" name=\"title\" class=\"form-control\" value=\"";
        echo $pag["title"];
        echo "\"  /></td>\n        </div>\n       \n         <div class=\"form-group\">\n        <label> ";
        echo $lng_languag["metakeyword"];
        echo "</label>\n        <td><input type=\"text\" name=\"meta_keys\" class=\"form-control\" value=\"";
        echo $pag["meta_keys"];
        echo "\" /></td>\n        </div>\n        \n        <div class=\"form-group\">\n        <label> ";
        echo $lng_languag["body"];
        echo " </label>\n         <textarea  class=\"form-control\" name=\"body\" >";
        echo $pag["body"];
        echo "</textarea> \n\t\t</div>\n      \n\t\t\t\n\t\t\t<div class=\"form-group\">\n\t\t\t<div  class=\"form-check\">\n\t\t\t  <input type=\"checkbox\" class=\"form-check-input\" name=\"fullwidth\" value=\"1\" id=\"fullwidth1\" ";
        if ($pag["fullwidth"]) {
            echo "checked";
        }
        echo " />\n\t\t\t  <label for=\"fullwidth1\"  class=\"form-check-label\"> ";
        echo $lng_languag["showfullwidth"];
        echo "</label>\n\t\t\t</div>\t\n\t\t\t<div  class=\"form-check\">\t\n\t\t\t  <input type=\"checkbox\" class=\"form-check-input\" name=\"login_req\" value=\"1\" id=\"login_req1\" ";
        if ($pag["login_req"]) {
            echo "checked";
        }
        echo "/>\n\t\t\t  <label for=\"login_req1\"  class=\"form-check-label\"> ";
        echo $lng_languag["loginrequired"];
        echo "</label>\n\t\t\t</div>\t\n\t\t\t<div  class=\"form-check\">\t\t\t\t\n\t\t\t  <input type=\"checkbox\" class=\"form-check-input\" name=\"navigation\" value=\"1\" id=\"navigation1\"  ";
        if ($pag["navigation"]) {
            echo "checked";
        }
        echo " />\n\t\t\t  <label for=\"navigation1\"  class=\"form-check-label\"> ";
        echo $lng_languag["shownavigation"];
        echo "</label>\n\t\t\t</div>\t\n\t\t\t<div  class=\"form-check\">\t\t\t\t\n\t\t\t  <input type=\"checkbox\" class=\"form-check-input\" name=\"publish\" value=\"1\" id=\"publish1\" ";
        if ($pag["status"] == "published") {
            echo "checked";
        }
        echo " />\n\t\t\t  <label for=\"publish1\"  class=\"form-check-label\"> ";
        echo $lng_languag["publish"];
        echo " </label>\n\t\t\t</div>\t\n\t\t</div>\t\n\t\t \n  \n              \n        <button type=\"submit\" name=\"save\" class=\"btn btn-primary waves-effect waves-light\" value=\"";
        echo $lng_languag["save"];
        echo "\" > ";
        echo $lng_languag["save"];
        echo " </button>\n    </form>\n    ";
    }
} else {
    if ($id) {
        $bann = mysqli_fetch_assoc(dquery("select * from tbl_bannerslider_banners where md5(id)='" . $id . "'"));
        echo "    <form method=\"post\" enctype=\"multipart/form-data\">\n        <input type=\"hidden\" name=\"editbanner\" value=\"";
        echo $id;
        echo "\" />\n         \n       <div class=\"form-group\">\n        <label>";
        echo $lng_languag["banner"];
        echo " ";
        echo $lng_languag["image"];
        echo "</label>\n         <input type=\"file\" name=\"bannerimage\"  class=\"form-control-file\" /> \n        </div>\n        \n        <div class=\"form-group\">\n        <label>";
        echo $lng_languag["title"];
        echo "</label>\n         <input type=\"text\" name=\"title\" class=\"form-control\" value=\"";
        echo $bann["img_title"];
        echo "\" /> \n        </div>\n        \n        \n       <div class=\"form-group\">\n        <label>";
        echo $lng_languag["header"];
        echo "</label>\n         <input type=\"text\" name=\"header\" class=\"form-control\" value=\"";
        echo $bann["info_header"];
        echo "\" /> \n        </div>\n        \n        \n       <div class=\"form-group\">\n        <label>";
        echo $lng_languag["information"];
        echo "</label>\n         <input type=\"text\" name=\"information\" class=\"form-control\" value=\"";
        echo $bann["info"];
        echo "\"  /> \n        </div>\n      \n\t\t<div class=\"form-row\">\n          <div class=\"form-group col-lg-4\"> \n\t\t \n        <label>";
        echo $lng_languag["information"];
        echo " ";
        echo $lng_languag["box"];
        echo " ";
        echo $lng_languag["width"];
        echo " </label>\n        <div class=\"input-group\"><input type=\"text\" name=\"boxwidth\" class=\"form-control\"  value=\"";
        echo $bann["infox_box_width"];
        echo "\" /> <div class=\"input-group-append\"><span class=\"input-group-text\">px</span></div>\n            </div>\n        </div>\n              \n       <div class=\"form-group col-lg-4\">\n        <label>";
        echo $lng_languag["information"];
        echo " ";
        echo $lng_languag["box"];
        echo " ";
        echo $lng_languag["from"];
        echo " ";
        echo $lng_languag["top"];
        echo "</label>\n        <div class=\"input-group\"><input type=\"text\" name=\"boxtop\" class=\"form-control\" value=\"";
        echo $bann["po_top"];
        echo "\" /> <div class=\"input-group-append\"><span class=\"input-group-text\">px</span></div>\n            </div>\n        </div>\n               \n        <div class=\"form-group col-lg-4\">\n        <label>";
        echo $lng_languag["information"];
        echo " ";
        echo $lng_languag["box"];
        echo " ";
        echo $lng_languag["from"];
        echo " ";
        echo $lng_languag["left"];
        echo "</label>\n        <div class=\"input-group\"><input type=\"text\" name=\"boxleft\" class=\"form-control\" value=\"";
        echo $bann["po_left"];
        echo "\" /> <div class=\"input-group-append\"><span class=\"input-group-text\">px</span></div>\n            </div>\n        </div>\n\t\t\t</div>       \n        <button type=\"submit\" name=\"save\" class=\"btn btn-primary\"  value=\"";
        echo $lng_languag["save"];
        echo "\" > ";
        echo $lng_languag["save"];
        echo " </button>\n      \n    </form>\n    ";
    }
}

?>