<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../../comm.php";
require_once "../../../includes/fun.inc.php";
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($save) {
    $_SESSION["pickeduser"] = $_POST["selected"];
    echo "<div id='notification1' class='successbox'>" . $LNG["user"] . " " . $LNG["selected"] . " " . $LNG["successfully"] . " </div>";
}
echo "\n<script>\n\nfunction loopSelected()\n\n{\n\n  var txtSelectedValuesObj = document.getElementById('selected');\n\n  var selectedArray = new Array();\n\n  var selObj = document.getElementById('imei');\n\n  var i;\n\n  var count = 0;\n\n  for (i=0; i<selObj.options.length; i++) {\n\n    if (selObj.options[i].selected) {\n\n      selectedArray[count] = selObj.options[i].value;\n\n      count++;\n\n    }\n\n  }\n\n  txtSelectedValuesObj.value = selectedArray;\n\n}\n\n</script>\n\n<script> \n\nfunction sendtoopener()   \n\n{ \n\n    opener.document.getElementById('imei').value=document.getElementById('selected').value; \n\n    opener.document.getElementById('server').value=\"\";\n\n    opener.document.getElementById('product').value=\"\";\n\n    self.close();    \n\n}\n\n</script>\n\n\n\n\n\n<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n\n<div id=\"notification\"></div>\n\n<div id=\"content\">\n\n<div id=\"content_padded\">\n\n<form id=\"frm\" name=\"\" method=\"post\">\n\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n\n<tbody>\n\n\n\n<tr>\n\n    <td class=\"fieldlabel\">";
echo $LNG["user"];
echo " ";
echo $LNG["list"];
echo "</td>\n\n    <td class=\"fieldarea\">\n\n<select name='imei' id='imei' multiple=\"multiple\"\n\n size=\"40\" onchange=\"loopSelected();\">\n\n";
$picuser = explode(",", $_SESSION["pickeduser"]);
$sql = dquery("select username ,id from tblUsers where gcmid!=''");
while ($row = mysqli_fetch_assoc($sql)) {
    if (in_array($row["id"], $picuser)) {
        $selected = "selected";
    } else {
        $selected = "";
    }
    echo "<option " . $selected . " value='" . $row["id"] . "'>" . $row["username"] . "</option>";
}
echo "\n</select>\n\n<input type='hidden' name='selected' id='selected' />\n\n</td>\n\n</tr>\n\n\n\n<tr> \n\n    <td class=\"fieldlabel\"> </td><td>\n\n   \n\n   <input type='submit' class=\"btn save\" name='save' value='Add User' />\n\n       </td>\n\n</tr>\n\n</tbody>\n\n</table>\n\n\n\n</form>\n\n\n\n\n\n</div></div>\n\n ";
$fileverioncheck = "6.1.0";

?>