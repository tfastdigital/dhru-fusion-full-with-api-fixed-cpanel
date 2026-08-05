<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 394;
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
    if (isset($_POST["show"]) && $_POST["datetime"] || !isset($_POST["show"])) {
        $append = "Date: " . date("d-m-Y") . " " . date("H:i:s");
        $serv = mysqli_fetch_assoc(dquery("SELECT `service_name` from `tbl_server_log`"));
        $date = "Date: " . date("d-m-Y") . " " . date("H:i:s");
    }
    $query = "SELECT *,(SELECT service_name FROM tbl_server_log WHERE id=tbl_order_server.service_id) as service  FROM `tbl_order_server` WHERE `order_id` IN (" . $order . ") AND ( `user_can_c`='1' OR `user_can_c`='0')\n    ORDER BY service_id";
    $result = dquery($query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row["qnt"] == 0) {
            $row["qnt"] = 1;
        }
        if ($new && $new != $row["service"]) {
            $append = $date . "  Service : " . $row["service"] . " Qnt : " . $row["qnt"] . "&#10;" . "-----------------------------------------------------&#10;";
        } else {
            if (!$new) {
                $append = $date . "  Service : " . $row["service"] . "  Qnt : " . $row["qnt"] . "&#10;" . "-----------------------------------------------------&#10;";
            }
        }
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
                $final = $final . "  Note:" . $row["note"];
            }
        }
        $data = NULL;
        if (isset($_POST["show"]) && $_POST["orderid"]) {
            $data = "#" . $row["order_id"];
        }
        $final = $data . $final;
        if ($new != $row["service"]) {
            $new = $row["service"];
            $imeis2 .= "&#10====================================================== &#10" . $append . $final . "&#10";
        } else {
            $imeis2 .= "" . $final . "&#10";
        }
    }
    $imeis = $append . "================================================================================== &#10;" . $imeis . "================================================================================== &#10;";
}
$select = "<select name='supplier'>";
$sup = dquery("select `username`,`id` from tbl_supplier");
while ($rows = mysqli_fetch_assoc($sup)) {
    $select .= "<option value='" . $rows["id"] . "'>" . $rows["username"] . "</option>";
}
$select .= "</select>";
echo "\n<table class='form' border='0' cellpadding='3' cellspacing='2' width='100%'>\n<tbody>\n<tr>\n<td  class='fieldlabel' textalign='center'> <h2></h2></td>\n</tr>\n<tr >\n<td class='fieldarea'><textarea id='data' name='data' rows='5' cols='140'>" . $imeis2 . "</textarea></td>\n</tr>";
echo "<form method='post' action='includes/pages/dl.php'>\n<tr><td class='fieldarea'>\n    <input type='submit' name='download' value='" . $LNG["downloadtofile"] . "'>\n    \n    <input type='hidden' name='service' value=''>\n    <input type='hidden' name='data' value='" . $imeis2 . "'></td></tr></form>";
echo "<form method='post'>\n<tr>\n<td  class='fieldarea'><input type='checkbox' name='orderid'";
if (isset($_POST["orderid"])) {
    echo "checked";
}
echo "/><label>" . $LNG["orderid"] . "</label></td>\n</tr>\n<tr>\n<td  class='fieldarea'><input type='checkbox' name='fields' ";
if (isset($_POST["fields"]) || !isset($_POST["show"])) {
    echo "checked";
}
echo "/><label>" . $LNG["allfields"] . "</label></td>\n</tr>\n<tr>\n<td  class='fieldarea'><input type='checkbox' name='datetime' ";
if (isset($_POST["datetime"]) || !isset($_POST["show"])) {
    echo "checked";
}
echo "/><label>" . $LNG["datetimeservice"] . "</label></td>\n</tr>\n<tr>\n<td class='fieldarea'><input type='submit' name='show' value='" . $LNG["generateorderlist"] . "' /></td>\n</tr>\n</form>\n";
echo "<form method='post'><tr>\n<td class='fieldarea'>" . $LNG["sendorderlist"] . " " . $select . " Or <input type='text' name='email'> <input type='submit' name='sendmail' value='Send'><input type='hidden' name='data' value='" . $imeis2 . "'></td>\n</tr></form>";
echo "</tbody>\n</table></div><script>\nfunction copyto()\n{\n    if (window.clipboardData)\n    {  \n        window.clipboardData.setData(\"Text\", document.getElementById('data').value);\n    }\n    else\n    {  \n        unsafeWindow.netscape.security.PrivilegeManager.enablePrivilege(\"UniversalXPConnect\");  \n        const clipboardHelper = Components.classes[\"@mozilla.org/widget/clipboardhelper;1\"].getService(Components.interfaces.nsIClipboardHelper);  \n        clipboardHelper.copyString(document.getElementById('data').value);\n        alert(document.getElementById('data').value);\n    }\n\n}\n</script>";
$fileverioncheck = "6.1.0";

?>