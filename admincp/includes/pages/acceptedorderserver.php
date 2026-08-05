<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 210;
checkPagePermission($pageid);
if (isset($_POST["sendmail"])) {
    require_once "../includes/mail.fun.php";
    $file = date("d-m-Y") . "_" . date("H:i:s");
    if ($_POST["email"] != "") {
        $mailarr[]["to"] = $_POST["email"];
        sendMail(15, "", "", "", false, $file . ".txt", $_POST["data"], "", $mailarr);
    } else {
        sendMail(15, "", "", "", false, $file . ".txt", $_POST["data"], $supplier);
    }
}
if ($order) {
    require_once "../includes/customfield.fun.inc.php";
    echo "<div id='tabcontent'>";
    if (isset($_POST["show"]) && $_POST["datetime"] || !isset($_POST["show"])) {
        $append = "Date: " . date("d-m-Y") . " " . date("H:i:s");
        $serv = mysqli_fetch_assoc(dquery("SELECT `service_name` from `tbl_server_log` where `id`='" . $id . "'"));
        $append .= "  Service : " . $serv["service_name"] . "&#10;";
    }
    $query = "SELECT * FROM `tbl_order_server` WHERE `order_id` IN (" . $order . ") AND ( `user_can_c`='1' OR `user_can_c`='0')";
    $result = dquery($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $final = "";
        if (isset($_POST["show"]) && $_POST["fields"] || !isset($_POST["show"])) {
            $cst = getCustomFields("serviceserver", $row["service_id"], $row["order_id"], "on");
            foreach ($cst as $c) {
                $final = $final . " " . $c["name"] . ":" . $c["value"];
            }
            if ($row["custom"] != NULL) {
                $final = $final . " Custom:" . $row["custom"];
            }
            if ($row["note"] != NULL) {
                $final = $final . " Note:" . $row["note"] . "";
            }
        }
        $final = $final . "&#10;";
        if (isset($_POST["show"]) && $_POST["orderid"]) {
            $imeis .= "#" . $row["order_id"] . " " . "";
        }
        $imeis .= $final;
    }
    $imeis = $append . "================================================================================== &#10;" . $imeis . "================================================================================== &#10;";
}
$select = "<select name='supplier'>";
$sup = dquery("select `username`,`id` from tbl_supplier");
while ($rows = mysqli_fetch_assoc($sup)) {
    $select .= "<option value='" . $rows["id"] . "'>" . $rows["username"] . "</option>";
}
$select .= "</select>";
echo "\n<table class='form' border='0' cellpadding='3' cellspacing='2' width='100%'>\n<tbody>\n<tr>\n<td  class='fieldlabel' textalign='center'> <h2>" . $serv["service_name"] . "</h2></td>\n</tr>\n<tr >\n<td class='fieldarea'><textarea id='data' name='data' rows='5' cols='140'>" . $imeis . "</textarea></td>\n</tr>";
echo "<form method='post' action='includes/pages/dl.php'>\n<tr><td class='fieldarea'>\n    <input type='submit' name='download' value='" . $LNG["downloadtofile"] . "'>\n    <input type='hidden' name='service' value='" . $serv["service_name"] . "'>\n    <input type='hidden' name='data' value='" . $imeis . "'></td></tr></form>";
echo "<form method='post'>\n<tr>\n<td  class='fieldarea'><input id='orderid' type='checkbox' name='orderid'";
if (isset($_POST["orderid"])) {
    echo "checked";
}
echo "/><label for='orderid'>" . $LNG["orderid"] . "</label></td>\n</tr>\n<tr>\n<td  class='fieldarea'><input id='fields'  type='checkbox' name='fields' ";
if (isset($_POST["fields"]) || !isset($_POST["show"])) {
    echo "checked";
}
echo "/><label for='fields'>" . $LNG["allfields"] . "</label></td>\n</tr>\n<tr>\n<td  class='fieldarea'><input id='datetime'  type='checkbox' name='datetime' ";
if (isset($_POST["datetime"]) || !isset($_POST["show"])) {
    echo "checked";
}
echo "/><label for='datetime'>" . $LNG["datetimeservice"] . "</label></td>\n</tr>\n<tr>\n<td class='fieldarea'><input type='submit' name='show' value='" . $LNG["generateorderlist"] . "' /></td>\n</tr>\n</form>\n";
echo "<form method='post'><tr>\n<td class='fieldarea'>" . $LNG["sendorderlist"] . " " . $select . " Or <input type='text' name='email'> <input type='submit' name='sendmail' value='Send'><input type='hidden' name='data' value='" . $imeis . "'></td>\n</tr></form>";
echo "</tbody>\n</table></div><script>\nfunction copyto()\n{\n    if (window.clipboardData)\n    {  \n        window.clipboardData.setData(\"Text\", document.getElementById('data').value);\n    }\n    else\n    {  \n        unsafeWindow.netscape.security.PrivilegeManager.enablePrivilege(\"UniversalXPConnect\");  \n        const clipboardHelper = Components.classes[\"@mozilla.org/widget/clipboardhelper;1\"].getService(Components.interfaces.nsIClipboardHelper);  \n        clipboardHelper.copyString(document.getElementById('data').value);\n        alert(document.getElementById('data').value);\n    }\n\n}\n</script>\n";
$fileverioncheck = "6.1.0";

?>