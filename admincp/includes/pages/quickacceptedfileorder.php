<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 391;
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
            list($newf, $f) = $filo;
            $newf = $key . $newf;
            $fh = fopen("../" . $donloaddirpath . "/" . $f, "r");
            $theData = fread($fh, filesize("../" . $donloaddirpath . "/" . $f));
            rename("../" . $donloaddirpath . "/" . $f, "../" . $donloaddirpath . "/" . $newf);
            $ziper->addFile($theData, "../" . $donloaddirpath . "/" . $newf);
            fclose($fh);
        }
    }
    $ziper->output("../" . $donloaddirpath . "/" . $file . ".zip");
    foreach ($filesarr as $key => $f) {
        if ($f != "") {
            $filo = explode("-A-", $f);
            list($newf, $f) = $filo;
            $newf = $key . $newf;
            rename("../" . $donloaddirpath . "/" . $newf, "../" . $donloaddirpath . "/" . $f);
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
$onlyimei = "";
if ($order) {
    require_once "../includes/customfield.fun.inc.php";
    $_SESSION["file_accepted"] = true;
    if (isset($_POST["show"]) && $_POST["datetime"] || !isset($_POST["show"])) {
        $date = "Date: " . date("d-m-Y") . " " . date("H:i:s");
    }
    $query = "SELECT *,(SELECT service_name FROM tbl_services_file WHERE id=tbl_order_file.service_id)\n         as service FROM `tbl_order_file` WHERE `order_id` IN (" . $order . ") AND ( `user_can_c`='1' OR `user_can_c`='0') ORDER BY service_id";
    $result = dquery($query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($new && $new != $row["service"]) {
            $append = $date . "  Service : " . $row["service"] . "&#10;" . "-----------------------------------------------------&#10;";
        } else {
            if (!$new) {
                $append = $date . "  Service : " . $row["service"] . "&#10;" . "-----------------------------------------------------&#10;";
            }
        }
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
            $data = "#" . $row["order_id"] . " " . $row["file"] . $final;
        } else {
            $data = $row["file"] . $final;
        }
        $files .= "," . $row["file"] . "-A-" . $row["file_enc"];
        if ($new != $row["service"]) {
            $new = $row["service"];
            $imeis2 .= "&#10====================================================== &#10" . $append . $data;
        } else {
            $imeis2 .= "\r\n" . $data . "&#10";
        }
        $onlyimei .= $row["file"] . "&#10";
    }
}
echo "<script>\n    function copytoClipboard()\n    {\n        var copyText = document.getElementById(\"copyto\");\n        var el = document.createElement('textarea');\n        el.value = copyText.value;\n        el.setAttribute('readonly', '');\n        el.style = {position: 'absolute', left: '-9999px'};\n        document.body.appendChild(el);\n        el.select();\n        document.execCommand('copy');\n        document.body.removeChild(el);\n        alert(\"Copied the text: \" + copyText.value);\n    }\n</script>\n";
$select = "<select name='supplier'>";
$sup = dquery("select `id`,`username` from tbl_supplier");
while ($rows = mysqli_fetch_assoc($sup)) {
    $select .= "<option value='" . $rows["id"] . "'>" . $rows["username"] . "</option>";
}
$select .= "</select>";
echo "\n<table class='form' border='0' cellpadding='3' cellspacing='2' width='100%'>\n<tbody>\n<tr>\n<td  class='fieldlabel' textalign='center'> </td>\n</tr>\n<tr >\n<td class='fieldarea'><textarea id='data' name='data' rows='10' cols='140'>" . $imeis2 . "</textarea></td>\n</tr>";
echo "<form method='post' action='includes/pages/dl.php?service=file'>\n<tr><td class='fieldarea'>\n    <input type='hidden' name='copyto' id='copyto' value='" . $onlyimei . "' />\n    <input type='submit' name='download' value='" . $LNG["downloadtofile"] . "'>\n    <input type='button' name='copytoclipboard' value='Copy to Clipboard' onclick='copytoClipboard()' />\n    <input type='hidden' name='service' value='File'>\n    <input type='hidden' name='data' value='" . $files . "'></td></tr></form>";
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
echo "<form method='post'><tr>\n<td class='fieldarea'>" . $LNG["sendorderlist"] . " " . $select . " Or <input type='text' name='email'> <input type='submit' name='sendmail' value='" . $LNG["sendmail"] . "'>\n<input type='hidden' name='data' value='" . $files . "'><input type='hidden' name='content' value='" . $imeis2 . "'></td>\n</tr></form>";
echo "</tbody>\n</table></div><script>\nfunction copyto()\n{\n    if (window.clipboardData)\n    {  \n        window.clipboardData.setData(\"Text\", document.getElementById('data').value);\n    }\n    else\n    {  \n        unsafeWindow.netscape.security.PrivilegeManager.enablePrivilege(\"UniversalXPConnect\");  \n        const clipboardHelper = Components.classes[\"@mozilla.org/widget/clipboardhelper;1\"].getService(Components.interfaces.nsIClipboardHelper);  \n        clipboardHelper.copyString(document.getElementById('data').value);\n        alert(document.getElementById('data').value);\n    }\n\n}\n</script>";
$fileverioncheck = "6.1.0";

?>