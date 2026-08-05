<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired.\n    <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($name) {
    checkDemoMode(false);
    $data["name"] = $name;
    $data["address"] = $address;
    $data["state"] = $state;
    $data["country"] = $country;
    $data["zip"] = $zip;
    if ($db->update("tbl_warehouse", $data, "id='" . $id . "'")) {
        echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
$cntr = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_warehouse WHERE id='" . $id . "'"));
echo "<div id=\"notification\"></div>\n<div  class=\"groupstabes\">\n\n  <h2>    \n    <span class=\"groupstabesheadertext\">";
echo $cntr["name"];
echo "</span> \n     \n  </h2>\n  \n  <div class=\"groupstabescontant\">\n  \n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["warehouse"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\" name=\"name\" value=\"";
echo $cntr["name"];
echo "\" /></td>\n</tr>\n \n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["address"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\" name=\"address\"  value=\"";
echo $cntr["address"];
echo "\"  /></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["country"];
echo " </td>\n    <td class=\"fieldarea\">";
echo getCountriesDropDown($cntr["country"]);
echo "</td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["state"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\" name=\"state\" value=\"";
echo $cntr["state"];
echo "\" /><br />\n    <small>";
echo $LNG["statenameincode"];
echo "</small></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["zip"] . "/" . $LNG["pin"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\" name=\"zip\" value=\"";
echo $cntr["zip"];
echo "\" /></td>\n</tr>\n<tr> \n    <td class=\"fieldlabel\"> </td><td class=\"fieldarea\">\n   <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"submit\"  onclick=\"SubmitForm ('#btnaddgroup','editwarehouse','#frm','#notification','true','#main_loader');\"/> \n\n    </td>\n</tr>\n</tbody>\n</table>\n</form>\n</div></div></div></div>\n ";
$fileverioncheck = "6.1.0";

?>