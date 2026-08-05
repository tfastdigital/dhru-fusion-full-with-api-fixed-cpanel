<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 318;
checkPagePermission($pageid);
if (isset($_POST["sendmail"])) {
    require_once "../includes/mail.fun.php";
    require_once "../includes/phpzip.class.php";
    $file = date("d-m-Y") . "_" . date("H:i:s");
    $ziper = new zipfile();
    $ziper->addDir("../" . $donloaddirpath . "/");
    $filesarr = explode(",", $_POST["data"]);
    foreach ($filesarr as $key => $f) {
        if ($f != "") {
            $filo = explode("-A-", $f);
            list($new, $f) = $filo;
            $new = $key . $new;
            $fh = fopen("../" . $donloaddirpath . "/" . $f, "r");
            $theData = fread($fh, filesize("../" . $donloaddirpath . "/" . $f));
            rename("../" . $donloaddirpath . "/" . $f, "../" . $donloaddirpath . "/" . $new);
            $ziper->addFile($theData, "../" . $donloaddirpath . "/" . $new);
            fclose($fh);
        }
    }
    $ziper->output("../" . $donloaddirpath . "/" . $file . ".zip");
    foreach ($filesarr as $key => $f) {
        if ($f != "") {
            $filo = explode("-A-", $f);
            list($new, $f) = $filo;
            $new = $key . $new;
            rename("../" . $donloaddirpath . "/" . $new, "../" . $donloaddirpath . "/" . $f);
        }
    }
    $fh = fopen("../" . $donloaddirpath . "/" . $file . ".zip", "r");
    $theData = fread($fh, filesize("../" . $donloaddirpath . "/" . $file . ".zip"));
    if ($_POST["email"] != "") {
        $mailarr[]["to"] = $_POST["email"];
        sendMail(15, "", "", "", false, $file . ".gz", $theData, "", $mailarr);
    } else {
        sendMail(15, "", "", "", false, $file . ".gz", $theData, $supplier);
    }
    fclose($fh);
}
if ($order) {
    require_once "../includes/customfield.fun.inc.php";
    echo "<div id='tabcontent'>";
    $_SESSION["file_accepted"] = true;
    if (isset($_POST["show"]) && $_POST["datetime"] || !isset($_POST["show"])) {
        $append = "Date: c" . date("d-m-Y") . " " . date("H:i:s");
        $serv = mysqli_fetch_assoc(dquery("SELECT `service_name` from `tbl_services_file` where `id`='" . $id . "'"));
        $append .= "  Service : " . $serv["service_name"] . "&#10;";
    }
    $query = "SELECT * FROM `tbl_order_file` WHERE `order_id` IN (" . $order . ") AND ( `user_can_c`='1' OR `user_can_c`='0')";
    $result = dquery($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $final = "";
        if (isset($_POST["show"]) && $_POST["fields"] || !isset($_POST["show"])) {
            $cst = getCustomFields("servicefile", $row["service_id"], $row["order_id"], "on");
            foreach ($cst as $c) {
                $final = $final . " " . $c["name"] . ":" . $c["value"];
            }
            if ($row["custom"] != NULL) {
                $final = $final . " Custom:" . $row["custom"];
            }
            if ($row["note"] != NULL) {
                $final = $final . "&#10;&#10;Note:" . $row["note"];
            }
        }
        if (isset($_POST["show"]) && $_POST["orderid"]) {
            $imeis .= "#" . $row["order_id"] . " " . $row["file"] . $final . "&#10;";
        } else {
            $imeis .= $row["file"] . $final . "&#10;";
        }
        $files .= "," . $row["file"] . "-A-" . $row["file_enc"];
    }
    $imeis = $append . "================================================================================== &#10;" . $imeis . "================================================================================== &#10;";
}
$select = "<select name='supplier'>";
$sup = dquery("select `id`,`username` from tbl_supplier");
while ($rows = mysqli_fetch_assoc($sup)) {
    $select .= "<option value='" . $rows["id"] . "'>" . $rows["username"] . "</option>";
}
$select .= "</select>";
echo "\n<table class='form' border='0' cellpadding='3' cellspacing='2' width='100%'>\n<tbody>\n<tr>\n<td  class='fieldlabel' textalign='center'> <h2>" . $serv["service_name"] . "</h2></td>\n</tr>\n<tr >\n<td class='fieldarea'><textarea id='data' name='data' rows='5' cols='140'>" . $imeis . "</textarea></td>\n</tr>";
echo "<form method='post' action='includes/pages/dl.php?service=file'>\n<tr><td class='fieldarea'>\n    <input type='submit' name='download' value='" . $LNG["downloadtofile"] . "'>\n    <input type='hidden' name='service' value='" . $serv["service_name"] . "'>\n    <input type='hidden' name='data' value='" . $files . "'></td></tr></form>";
echo "<form method='post'>\n<tr>\n<td  class='fieldarea'><input id='orderid' type='checkbox' name='orderid'";
if (isset($_POST["orderid"])) {
    echo "checked";
}
echo "/><label for='orderid'>" . $LNG["orderid"] . "</label></td>\n</tr>\n<tr>\n<td  class='fieldarea'><input type='checkbox' name='fields' id='field' ";
if (isset($_POST["fields"]) || !isset($_POST["show"])) {
    echo "checked";
}
echo "/><label for='field'>" . $LNG["allfields"] . "</label></td>\n</tr>\n<tr>\n<td  class='fieldarea'><input id='datetime' type='checkbox' name='datetime' ";
if (isset($_POST["datetime"]) || !isset($_POST["show"])) {
    echo "checked";
}
echo "/><label for='datetime'>" . $LNG["datetimeservice"] . "</label></td>\n</tr>\n<tr>\n<td class='fieldarea'><input type='submit' name='show' value='" . $LNG["generateorderlist"] . "' /></td>\n</tr>\n</form>\n";
echo "<form method='post'><tr>\n<td class='fieldarea'>" . $LNG["sendorderlist"] . " " . $select . " Or <input type='text' name='email'> <input type='submit' name='sendmail' value='" . $LNG["sendmail"] . "'>\n<input type='hidden' name='data' value='" . $files . "'><input type='hidden' name='content' value='" . $imeis . "'></td>\n</tr></form>";
echo "</tbody>\n</table></div><script>\nfunction copyto()\n{\n    if (window.clipboardData)\n    {\n        window.clipboardData.setData(\"Text\", document.getElementById('data').value);\n    }\n    else\n    {  \n        unsafeWindow.netscape.security.PrivilegeManager.enablePrivilege(\"UniversalXPConnect\");  \n        clipboardHelper = Components.classes[\"@mozilla.org/widget/clipboardhelper;1\"].getService(Components.interfaces.nsIClipboardHelper);\n        clipboardHelper.copyString(document.getElementById('data').value);\n        alert(document.getElementById('data').value);\n    }\n\n}\n</script>\n";
$fileverioncheck = "6.1.0";

?>