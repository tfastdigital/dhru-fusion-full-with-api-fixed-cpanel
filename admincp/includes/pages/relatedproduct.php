<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
$pro = $_POST["data"];
if (1) {
    $prod = mysqli_fetch_assoc(dquery("select relproduct,relaccess from tbl_products where id='" . $pro . "'"));
    $relpro = explode(",", $prod["relproduct"]);
    $relasc = explode(",", $prod["relaccess"]);
}
if ($id) {
    $buf .= "<table id=main_tbl><tr><th align='left' width='300px'>" . $LNG["product"] . "</th><th align='left'>" . $LNG["related"] . " " . $LNG["product"] . "</th><th align='left'>" . $LNG["related"] . " " . $LNG["accessories"] . "</th></tr>";
    $sql = dquery("select * from tbl_products where group_id='" . $id . "'");
    while ($row = mysqli_fetch_assoc($sql)) {
        if (in_array($row["id"], $relpro)) {
            $pselect = "checked='checked'";
        } else {
            $pselect = "";
        }
        if (in_array($row["id"], $relasc)) {
            $aselect = "checked='checked'";
        } else {
            $aselect = "";
        }
        $buf .= "<tr><td> " . $row["service_name"] . "</td><td><input type='checkbox' " . $pselect . " id='id_" . $row["id"] . "' name='pro[" . $row["id"] . "]'><label for='id_" . $row["id"] . "'></label></td>\n                <td><input type='checkbox' id='ace_" . $row["id"] . "' " . $aselect . " name='ace[" . $row["id"] . "]'><label for='ace_" . $row["id"] . "'></label>\n                \t<input type='hidden' name='hid[" . $row["id"] . "]' value='" . $row["id"] . "' /></td></tr>";
    }
    $buf .= "</table>";
    echo $buf;
}
$fileverioncheck = "6.1.0";

?>