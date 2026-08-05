<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (isset($_POST["sendmail"])) {
    require_once "../includes/mail.fun.php";
    $file = date("d-m-Y") . "_" . date("H:i:s");
    sendMail(15, 1, "", "", false, $file . ".txt", $_POST["data"]);
}
if ($order) {
    require_once "imeiorder.head.php";
    echo "<div id='tabcontent'>";
    $_SESSION["once_accepted"] = true;
    if (isset($_POST["show"]) && $_POST["datetime"] || !isset($_POST["show"])) {
        $append = "Date: " . date("d-m-Y") . " " . date("H:i:s");
        $serv = mysqli_fetch_assoc(dquery("SELECT `service_name` from `tbl_services_imei` where `id`='" . $id . "'"));
        $append .= "  Service : " . $serv["service_name"] . "&#10;";
    }
    $query = "SELECT * FROM `tbl_order_imei` WHERE `order_id` IN (" . $order . ")";
    $result = dquery($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $final = "";
        if (isset($_POST["show"]) && $_POST["fields"] || !isset($_POST["show"])) {
            include_once ROOTDIR . "/includes/customfield.fun.inc.php";
            $custom = NULL;
            $custom = getCustomFields("serviceimei", $row["service_id"], $row["order_id"], "on");
            foreach ($custom as $c) {
                if ($c["value"]) {
                    $final = " " . $final . $c["name"] . ":" . $c["value"] . " ";
                }
            }
            if ($row["model_id"] != 0) {
                $MID = $row["model_id"];
                $q1 = "SELECT * FROM `tbl_mobile` where `ID`='" . $MID . "'";
                $r1 = dquery($q1);
                $r1 = mysqli_fetch_assoc($r1);
                $BID = $r1["B_ID"];
                $q2 = "SELECT `Name` FROM `tbl_model_brand` where `ID`='" . $BID . "'";
                $r2 = dquery($q2);
                $r2 = mysqli_fetch_assoc($r2);
                $final = " " . $final . $r2["Name"] . "/" . $r1["Name"];
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
                $final = $final . " " . $r2["Name"] . "/" . $r1["Name"];
            }
            if ($row["network_id"] != 0) {
                $MID = $row["network_id"];
                $q1 = "SELECT `Name` FROM `tbl_network` where `ID`='" . $MID . "'";
                $r1 = dquery($q1);
                $r1 = mysqli_fetch_assoc($r1);
                $final = $final . " " . $r1["Name"];
            }
            if ($row["mep"] != 0) {
                $MID = $row["mep"];
                $q1 = "SELECT `mep` FROM `tbl_mep` where `id`='" . $MID . "'";
                $r1 = dquery($q1);
                $r1 = mysqli_fetch_assoc($r1);
                $final = $final . " MEP:" . $r1["mep"];
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
            if ($row["note"] != NULL) {
                $final = $final . " Note:" . $row["note"];
            }
            $final .= "\n";
        }
        if (isset($_POST["show"]) && $_POST["orderid"]) {
            $imeis .= "#" . $row["order_id"] . " " . $row["imei"] . $final . " ";
        } else {
            $imeis .= $row["imei"] . $final . "&#10;";
        }
        foreach ($custom as $c) {
            if ($c["value"]) {
                $imeis .= " " . $c["name"] . ":" . $c["value"] . " &#10;";
            }
        }
    }
    $imeis = $append . "================================================================================== &#10;" . $imeis . "================================================================================== &#10;";
}
$select = "<select name='supplier'>";
$sup = dquery("select `username`,`email` from tbl_supplier");
while ($rows = mysqli_fetch_assoc($sup)) {
    $select .= "<option value='" . $rows["email"] . "'>" . $rows["username"] . "</option>";
}
$select .= "</select>";
echo "<table class='form' border='0' cellpadding='3' cellspacing='2' width='100%'>\n<tbody>\n<tr>\n<td  class='fieldlabel' textalign='center'> <h2>" . $serv["service_name"] . "</h2></td>\n</tr>\n<tr >\n<td class='fieldarea'><textarea id='data' name='data' rows='5' cols='140'>" . $imeis . "</textarea></td>\n</tr>";
echo "<form method='post' action='includes/pages/dl.php'>\n<tr><td class='fieldarea'>\n    <input type='submit' name='download' value='" . $LNG["downloadtofile"] . "'>\n    <input type='hidden' name='service' value='" . $serv["service_name"] . "'>\n    <input type='hidden' name='data' value='" . $imeis . "'></td></tr></form>";
echo "<form method='post'>\n<tr>\n<td class='fieldarea'><input type='checkbox' name='orderid'";
if (isset($_POST["orderid"])) {
    echo "checked";
}
echo "/><label>" . $LNG["orderid"] . "</label></td>\n</tr>\n<tr>\n<td class='fieldarea'><input type='checkbox' name='fields' ";
if (isset($_POST["fields"]) || !isset($_POST["show"])) {
    echo "checked";
}
echo "/><label>" . $LNG["allfields"] . "</label></td>\n</tr>\n<tr>\n<td  class='fieldarea'><input type='checkbox' name='datetime' ";
if (isset($_POST["datetime"]) || !isset($_POST["show"])) {
    echo "checked";
}
echo "/><label>" . $LNG["datetimeservice"] . "</label></td>\n</tr>\n<tr>\n<td class='fieldarea'>\n<input type='hidden' name='order' value='" . $order . "' />\n<input type='submit' name='show' value='" . $LNG["generateorderlist"] . "' /></td>\n</tr>\n</form>";
echo "</tbody>\n</table></div>";

?>