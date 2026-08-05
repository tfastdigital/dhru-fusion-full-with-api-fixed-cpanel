<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 392;
checkPagePermission($pageid);
if (isset($_POST["sendmail"])) {
    require_once ROOTDIR . "/includes/mail.fun.php";
    $file = date("d-m-Y") . "_" . date("H:i:s");
    $emailfield["orderlist"] = $_POST["data"];
    if ($_POST["email"] != "") {
        $mailarr[]["to"] = $_POST["email"];
        sendMail(15, "", "", $emailfield, false, $file . ".txt", $_POST["data"], "", $mailarr);
    } else {
        sendMail(15, "", "", $emailfield, false, $file . ".txt", $_POST["data"], $supplier);
    }
}
if ($order) {
    require_once "../includes/customfield.fun.inc.php";
    $_SESSION["once_accepted"] = true;
    if (isset($_POST["show"]) && $_POST["datetime"] || !isset($_POST["show"])) {
        $date = "&#10;Date: " . date("d-m-Y") . " " . date("H:i:s");
        $serv = mysqli_fetch_assoc(dquery("SELECT `service_name` from \n              `tbl_services_imei` where `id`='" . $id . "'"));
        $append .= "  Service : " . $serv["service_name"] . "&#10;";
    }
    $query = "SELECT *,(SELECT service_name FROM tbl_services_imei WHERE \n    id=tbl_order_imei.service_id) as service\n    FROM `tbl_order_imei` WHERE `order_id` IN (" . $order . ") AND     (`user_can_c`='1' OR `user_can_c`='0') ORDER BY service_id";
    $result = dquery($query);
    $copytoclip = "";
    while ($row = mysqli_fetch_assoc($result)) {
        $final = "";
        if (isset($_POST["show"]) && $_POST["fields"] || !isset($_POST["show"])) {
            if ($row["model_id"] != 0) {
                $MID = $row["model_id"];
                $q1 = "SELECT * FROM `tbl_mobile` where `ID`='" . $MID . "'";
                $r1 = dquery($q1);
                $r1 = mysqli_fetch_assoc($r1);
                $BID = $r1["B_ID"];
                $q2 = "SELECT `Name` FROM `tbl_model_brand` where `ID`='" . $BID . "'";
                $r2 = dquery($q2);
                $r2 = mysqli_fetch_assoc($r2);
                $final = " " . $final . $r2["Name"] . "/" . $r1["Name"] . " ";
            }
            if ($row["provider_id"] != 0) {
                $MID = $row["provider_id"];
                $q1 = "SELECT * FROM `tbl_provider` where `ID`='" . $MID . "'";
                $r1 = dquery($q1);
                $r1 = mysqli_fetch_assoc($r1);
                $BID = $r1["C_ID"];
                $q2 = "SELECT `Name` FROM `tbl_provider_country` WHERE `ID`='" . $BID . "'";
                $r2 = dquery($q2);
                $r2 = mysqli_fetch_assoc($r2);
                $final = $final . " " . $r2["Name"] . "/" . $r1["Name"] . " ";
            }
            if ($row["network_id"] != 0) {
                $MID = $row["network_id"];
                $q1 = "SELECT `Name` FROM `tbl_network` where `ID`='" . $MID . "'";
                $r1 = dquery($q1);
                $r1 = mysqli_fetch_assoc($r1);
                $final = $final . " " . $r1["Name"] . " ";
            }
            if ($row["mep"] != 0) {
                $MID = $row["mep"];
                $q1 = "SELECT `mep` FROM `tbl_mep` where `id`='" . $MID . "'";
                $r1 = dquery($q1);
                $r1 = mysqli_fetch_assoc($r1);
                $final = $final . " MEP:" . $r1["mep"] . " ";
            }
            if ($row["KBH"] != NULL) {
                $final = $final . " KBH:" . $row["KBH"] . " ";
            }
            if ($row["PIN"] != NULL) {
                $final = $final . " PIN:" . $row["PIN"] . " ";
            }
            if ($row["PRD"] != NULL) {
                $final = $final . " PRD:" . $row["PRD"] . " ";
            }
            if ($row["Type"] != NULL) {
                $final = $final . " Type:" . $row["Type"] . " ";
            }
            if ($row["custom"] != NULL) {
                $final = $final . " Custom:" . $row["custom"] . " ";
            }
            if ($row["SecRO"] != NULL) {
                $final = $final . " SecRO:" . $row["SecRO"] . " ";
            }
            if ($row["SN"] != NULL) {
                $final = $final . " SN:" . $row["SN"] . " ";
            }
            $cst = getCustomFields("serviceimei", $row["service_id"], $row["order_id"], "on");
            foreach ($cst as $c) {
                $final = $final . " " . $c["name"] . ": " . $c["value"];
            }
            if ($row["note"] != NULL) {
                $final = $final . " Note:" . $row["note"] . " ";
            }
            if ($row["comments"] != NULL) {
                $final = $final . " Comments:" . $row["comments"] . " ";
            }
        }
        if (isset($_POST["show"]) && $_POST["orderid"]) {
            $imeis = "&#10; #" . $row["order_id"] . " " . $row["imei"] . " [" . $final . "]";
        } else {
            if ($final) {
                $imeis = $row["imei"] . "" . $final . "&#10;";
            } else {
                $imeis = $row["imei"] . "&#10;";
            }
        }
        $copytoclip .= $row["imei"] . "&#10;";
        if ($new != $row["service"]) {
            $imeis2 .= "&#10;===========================================================================&#10;" . $date . " Service: " . $row["service"] . ($row["server"] ? " Qnt: " . $row["qnt"] . " " : "") . "&#10;....................................................&#10;";
        }
        $imeis2 .= $imeis;
        if ($stype != "server") {
            if ($new && $new != $row["service"]) {
                $new = $row["service"];
            } else {
                if (!$new) {
                    $new = $row["service"];
                }
            }
        }
    }
}
echo "<script>\nfunction copytoClipboard()\n{\n    var copyText = document.getElementById(\"copyfield\");\n    var el = document.createElement('textarea');\n    el.value = copyText.value;\n    el.setAttribute('readonly', '');\n    el.style = {position: 'absolute', left: '-9999px'};\n    document.body.appendChild(el);\n    el.select();\n    document.execCommand('copy');\n    document.body.removeChild(el);\n    alert(\"Copied the text: \" + copyText.value);\n}\n</script>\n";
$select = "<select name='supplier'>";
$sup = dquery("select `username`,`id` from tbl_supplier");
while ($rows = mysqli_fetch_assoc($sup)) {
    $select .= "<option value='" . $rows["id"] . "'>" . $rows["username"] . "</option>";
}
$select .= "</select>";
echo "\n<table class='form' border='0' cellpadding='3' cellspacing='2' width='100%'>\n<tbody>\n<tr>\n<td  class='fieldlabel' textalign='center'> <h2>" . $serv["service_name"] . "</h2></td>\n</tr>\n<tr >\n<td class='fieldarea'><textarea id='data' name='data' style='height:400px' rows='15' cols='140'>" . $imeis2 . "</textarea></td>\n</tr></table>";
echo "<form method='post' action='includes/pages/dl.php'>\n<table class='form' border='0' cellpadding='3' cellspacing='2' width='100%'>\n\n<tr><td class='fieldarea'><br/>\n<input type=\"hidden\" name=\"copyfield\" id=\"copyfield\" value=\"";
echo $copytoclip;
echo "\" />\n<input type='submit' name='download' value='";
echo $LNG["downloadtofile"];
echo "'>\n        \n        ";
if ($stype != "server") {
    echo "            <input type=\"button\" onclick=\"copytoClipboard();\" name=\"Copy to Clipboard\" value=\"Copy to Clipboard\"/>\n            ";
}
echo "<input type='hidden' name='service' value='";
echo $serv["service_name"];
echo "'>\n<input type='hidden' name='data' value='";
echo $imeis2;
echo "'><br/><br/><br/><br/></td></tr></table></form>\n\n<form method='post'>\n<table class='form' border='0' cellpadding='3' cellspacing='2' width='100%'>\n\n<tr>\n    <td  class='fieldarea'>\n<input type='checkbox' value='1' name='orderid' ";
if (isset($_POST["orderid"])) {
    echo "checked";
}
echo "/><label>";
echo $LNG["orderid"];
echo "</label>\n<input type='checkbox' value='1' name='fields'  ";
if (isset($_POST["fields"]) || !isset($_POST["show"])) {
    echo "checked";
}
echo "/><label>";
echo $LNG["allfields"];
echo "</label>\n<input type='checkbox' value='1' name='datetime' ";
if (isset($_POST["datetime"]) || !isset($_POST["show"])) {
    echo "checked";
}
echo "/><label>";
echo $LNG["datetimeservice"];
echo "</label>\n<input type='hidden' name='order' value='";
echo $order;
echo "' />\n<input type='submit' name='show' value='";
echo $LNG["generateorderlist"];
echo "' />\n    </td>\n    </tr>\n</table>\n</form>\n";
if (!$supplieraccess) {
    echo "<form method='post'>\n    <table class='form' border='0' cellpadding='3' cellspacing='2' width='100%'>\n    <tr>\n    <td class='fieldarea'><br/><br/>" . $LNG["sendorderlist"] . " " . $select . " or <input type='text' style='background:#f4f4f4' name='email'> <input type='submit' name='sendmail' value='" . $LNG["sendmail"] . "'><input type='hidden' name='data' value='" . $imeis2 . "'>\n    <br><small>All details shown in textarea will send to selected supplier or email</small> \n    </td></tr></table></form>";
}
echo "</div>";
$fileverioncheck = "6.1.0";

?>