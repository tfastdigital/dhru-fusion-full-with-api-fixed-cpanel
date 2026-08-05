<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($seoother && $gtin) {
    checkDemoMode(false);
    $data["gtin"] = $gtin;
    $db->update("tbl_products", $data, "id=" . $id);
    echo "<div id='notification1' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
}
if ($save && $seo_description) {
    checkDemoMode(false);
    $data["seo_title"] = $seo_title;
    $data["seo_description"] = $seo_description;
    $data["seo_keywords"] = $seo_keywords;
    $db->update("tbl_products", $data, "id=" . $id);
    echo "<div id='notification1' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
} else {
    if ($save) {
        echo "<div id='notification1' class='errorbox'>" . $LNG["description"] . " " . $LNG["fieldblank"] . "</div>";
    }
}
if ($savegtype) {
    checkDemoMode(false);
    $data["gtin"] = $gtin;
    $data["google_product_type"] = html_entity_decode($google_product_type);
    $data["mpn"] = $mpn;
    $db->update("tbl_products", $data, "id=" . $id);
    echo "<div id='notification1' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
}
if ($autopost) {
    checkDemoMode(false);
    require_once "includes/twitter.fun.php";
    $md5id = md5($id);
    twitter_post($title . " " . _url("product/" . str_replace(" ", "-", preg_replace("/[^a-zA-Z0-9 ]/", "", $title))) . "?pid=" . $id);
    echo "<div id='notification1' class='successbox'>" . $LNG["twitter"] . " " . $LNG["post"] . " " . $LNG["successfull"] . "</div>";
}
if ($autopostfacebook) {
    echo "<script>\nwindow.open('";
    echo $config["site_address"];
    echo $admindirpath;
    echo "/includes/facebook.php?autopost=true&id=";
    echo $id;
    echo "&service=";
    echo $service;
    echo "&link=";
    echo $link;
    echo "&grop_id=";
    echo $group_id;
    echo "','mywindow','width=500,height=300');\n</script> \n";
}
$sql = mysqli_fetch_assoc(dquery("select seo_title,mpn,seo_keywords,google_product_type,gtin,service_name,group_id,seo_description from tbl_products where id='" . $id . "'"));
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
echo "\n<script>\n\$(document).ready(function() {\n\$('#google_product_type').keyup(function() {\n    if(\$(this).val().length>=4){\n             \$.post(\"includes/pages/searchGoogleCat.php\", { val: \$(this).val()},\n                   function(data) {\n                    if(data){\n                            \$('#tresult').show();\n                            \$('#tresult').html(data);\n                    }else{\n                            \$('#tresult').hide();\n                    }\n           });\n   \n   }\n});\n});\n</script>\n<style>\n.listers{\n  cursor: pointer;\n  padding: 2px; \n  border : 0.5px solid #F2F2F2;\n}\n.listers:hover{\n  background-color: #EEEEEE;\n  color: black;\n}\n</style>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">Meta ";
echo $LNG["title"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt large\" name=\"seo_title\" value=\"";
echo $sql["seo_title"];
echo "\" /><br />\n    <small>";
echo $LNG["productseotitleinfo"];
echo "</small></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">Meta ";
echo $LNG["description"];
echo "</td>\n    <td class=\"fieldarea\">\n    <textarea name=\"seo_description\" class=\"large\">";
echo $sql["seo_description"];
echo "</textarea>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">Meta Keywords</td>\n    <td class=\"fieldarea\">\n    <textarea name=\"seo_keywords\" class=\"textarea large\">";
echo $sql["seo_keywords"];
echo "</textarea>\n    </td>\n</tr>\n<tr>\n    <td></td>\n    <td class=\"fieldarea\"><input type=\"submit\" class=\"btn save\" name=\"save\" value=\"";
echo $LNG["save"];
echo "\" /></td>\n</tr>\n</tbody>\n</table>\n</form>\n<br />\n<form id=\"frmff\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<input type=\"hidden\" name=\"group_id\" value=\"";
echo $sql["group_id"];
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["twitter"];
echo " ";
echo $LNG["autopost"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt large\" name=\"title\" value=\"New Product Added (";
echo $sql["service_name"];
echo ")\" />\n    </td>\n</tr>\n<tr>\n    <td></td>\n    <td class=\"fieldarea\"><input type=\"submit\" class=\"btn save\" name=\"autopost\" value=\"";
echo $LNG["post"];
echo "\" /></td>\n</tr>\n</tbody>\n</table>\n</form>\n<br />\n<form id=\"frm\" name=\"\" method=\"post\" >\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<input type=\"hidden\" name=\"service\" value=\"product\" />\n<input type=\"hidden\" name=\"group_id\" value=\"";
echo $sql["group_id"];
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">Facebook ";
echo $LNG["autopost"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt large\" name=\"title\" value=\"New Product Added (";
echo $sql["service_name"];
echo ")\" />\n    </td>\n</tr>\n<tr>\n    <td></td>\n    <td class=\"fieldarea\"><input type=\"submit\" class=\"btn save\" name=\"autopostfacebook\" value=\"";
echo $LNG["post"];
echo "\" /></td>\n</tr>\n</tbody>\n</table>\n</form>\n\n<br />\n<!-------------------------------------->\n<form id=\"frm\" name=\"\" method=\"post\" >\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["globaltridnum"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\" name=\"gtin\" value=\"";
echo $sql["gtin"];
echo "\" />\n\n</td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">Manufacturer Part Number (MPN)</td>\n<td class=\"fieldarea\">\n<input type=\"text\"  class=\"txt large\" name=\"mpn\" value=\"";
echo $sql["mpn"];
echo "\" id=\"mpn\"  />\n</td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["google"];
echo " ";
echo $LNG["product"];
echo " ";
echo $LNG["type"];
echo "</td>\n<td class=\"fieldarea\">\n    <input type=\"text\"  class=\"txt large\" name=\"google_product_type\" value=\"";
echo $sql["google_product_type"];
echo "\" id=\"google_product_type\"  />\n   \n</td>\n</tr>\n<tr>\n<td class=\"fieldlabel\"></td>\n<td class=\"fieldarea\">\n     <div id=\"tresult\" style=\"width: auto; display: none;\">\n    </div>\n</td>\n</tr>\n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input type=\"submit\" class=\"btn save\" name=\"savegtype\" value=\"";
echo $LNG["save"];
echo "\" />\n</div>\n \n</form>\n<!--------------------------------------->\n</div></div>\n   ";
$fileverioncheck = "6.1.0";

?>