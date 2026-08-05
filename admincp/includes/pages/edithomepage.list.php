<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "includes/fun.inc.php";
include_once ROOTDIR . "/includes/products.fun.php";
if (!$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired.\n     <a style=\"color: #666;\" \n     href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
$group = getProductGroup();
$grp = buildProductGrou(getProductGroupArray(), "", "dropdown", "groupname", $grpid);
if (isset($_GET["grpid"])) {
    $groups = $_GET["grpid"];
} else {
    $sql = mysqli_fetch_assoc(dquery("select id from tbl_product_group"));
    $groups = $sql["id"];
}
$pagelimit = 10000;
if (isset($save)) {
    $sql = mysqli_fetch_assoc(dquery("select pid from tbl_homepagegroup where id='" . $id . "'"));
    $prod = explode(",", $sql["pid"]);
    foreach ($imei_check as $v) {
        foreach ($prod as $t) {
            if ($t == $v) {
                unset($imei_check[$v]);
            }
        }
    }
    $new = trim(trim(implode(",", $prod), ",") . "," . trim(implode(",", $imei_check), ","), ",");
    dquery("update tbl_homepagegroup set pid='" . $new . "' where id='" . $id . "'");
    echo "<div id='notification1' class='successbox'>Product added successfully</div>    <script>\nwindow.opener.location.reload(true);\n    </script>\n    ";
}
$proServiceDetails = getProducts($groups);
echo "<script>\n\$(function () {\n    SelectChildren = function (element) {\n       if(\$(\"#\"+element).is(':checked')){\n            \$(\".\"+element).attr('checked',true);\n       }else{\n            \$(\".\"+element).attr('checked',false);\n       }      \n    }\n});\n</script>\n    \n<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\">\n\n<table>\n<tr><td>\n";
echo str_replace("<select name='groupname'>", "<select name=\"groups\" onchange=\"javascript: reloadsubpageiframe('edithomepage.list&grpid='+this.value+'&defaultpage=edithomepage.list.php&id=" . $id . "','" . $id . "')\">", $grp);
echo "</td>\n<td>\n</td></tr>\n</table><br />\n\n\n<form id=\"frmedituser\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\n<input type=\"hidden\" value=\"";
echo $groups;
echo "\" name=\"groups\"/>\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "<table id=\"main_tbl\" style=\"display: ";
echo $display;
echo ";\"  class='sortable'>\n<thead>\n  <tr>                \n    <th class=\"singletd\" colspan=\"2\">";
echo $LNG["servicename"];
echo "</th><th></th> \n  </tr>\n  \n</thead>\n<tbody>            \n";
$proServiceDetailsKey = array_keys($proServiceDetails);
$i = 0;
foreach ($proServiceDetailsKey as $group) {
    $grps = explode("_", $group);
    $grps = $grps[0];
    $grps = htmlspecialchars($grps);
    if (!mysqli_num_rows(dquery("SELECT id FROM tbl_product_group WHERE group_name='" . $grps . "' and active='1'"))) {
        $selected = "";
    }
    echo "<tr class='nodrag'><td   colspan=" . $nocur . " align=left><input onclick='SelectChildren(this.id);' type='checkbox' id='g_" . $i . "' " . $selected . " name='grp[" . $grps . "]' value='" . $grps . "'> <label for=g_" . $i . " onclick='SelectChildren(g_" . $i . ")'></label> </td><td  class=singletd> <strong>" . $grps . "</strong></td><td></td></tr>";
    $e = 0;
    foreach ($proServiceDetails[$group] as $keys) {
        $e++;
        echo "            <tr>\n                <td><input  name=\"imei_check[";
        echo $keys["id"];
        echo "]\"\n                value=\"";
        echo $keys["id"];
        echo "\" type=\"checkbox\"\n                class=\"g_";
        echo $i;
        echo "\" id=\"i_";
        echo $e;
        echo "\" />\n                     <label for=\"i_";
        echo $e;
        echo "\"></label>\n                </td><td  class=\"singletd\">";
        echo $keys["service_name"];
        echo "</td>\n                <td></td>\n            </tr>\n            ";
    }
}
echo "</tbody>\n</table>\n<br />\n<input type=\"submit\" name=\"save\"\n class=\"btn save\" value=\"";
echo $LNG["add"];
echo "\" />\n</form></div></div> ";
$fileverioncheck = "6.1.0";

?>