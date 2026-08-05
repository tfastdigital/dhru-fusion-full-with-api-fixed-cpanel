<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
if ($Name && $apiid) {
    checkDemoMode(false);
    $data["Name"] = $Name;
    $data["api"] = $api;
    $data["apiid"] = $apiid;
    if ($db->update("tbl_model_brand", $data, "id='" . $id . "'")) {
        echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
$cntr = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_model_brand WHERE ID='" . $id . "'"));
echo "<div id=\"notification\"></div>\n<div  class=\"groupstabes\" >\n  <h2>    \n    <span class=\"groupstabesheadertext\">";
echo $cntr["Name"];
echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["brand"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"Name\" value=\"";
echo $cntr["Name"];
echo "\" /></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["api"];
echo "  </td>\n    <td class=\"fieldarea\">\n<select name=\"api\">\n<option value=\"\">";
echo $LNG["none"];
echo "</option>\n";
$api = dquery("select distinct gateway,value from tbl_apiservers  where  tbl_apiservers.setting='name'");
while ($rowapi = mysqli_fetch_assoc($api)) {
    echo "<option value='";
    echo $rowapi["gateway"];
    echo "' ";
    if ($cntr["api"] == $rowapi["gateway"]) {
        echo "selected";
    }
    echo " >";
    echo $rowapi["value"];
    echo "</option>\n  ";
}
echo "    \n</select>   </td>\n</tr>\n\n<tr>\n    <td   class=\"fieldlabel\">";
echo $LNG["apiid"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"apiid\" value=\"";
echo $cntr["apiid"];
echo "\" /></td>\n</tr>\n </tbody>\n</table>\n\n<div class=\"fixedbtn\">  \n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn save\"\ntype=\"submit\"  onclick=\"SubmitForm ('#btnaddgroup','includes/page/editbrand','#frm','#notification','true','#main_loader');\"/>\n</div>\n\n</form>\n\n\n</div></div></div></div>\n ";
$fileverioncheck = "6.1.0";

?>