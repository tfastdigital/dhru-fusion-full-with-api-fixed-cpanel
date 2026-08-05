<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 374;
checkPagePermission($pageid);
if (isset($_POST["sendmail"])) {
    require_once "../includes/mail.fun.php";
    $file = date("d-m-Y") . "_" . date("H:i:s");
    if ($_POST["email"] != "") {
        $mailarr[]["to"] = $_POST["email"];
        sendMail(15, "", "", "", false, $file . ".txt", $_POST["data"], "", $mailarr);
    }
}
if ($order) {
    include "productorder.head.php";
    echo "<div id='tabcontent'>";
    $_SESSION["once_accepted"] = true;
    if (isset($_POST["show"]) && $_POST["datetime"] || !isset($_POST["show"])) {
        $append = "Date: " . date("d-m-Y") . " " . date("H:i:s");
        $serv = mysqli_fetch_assoc(dquery("SELECT `service_name` from `tbl_products` where `id`='" . $id . "'"));
        $append .= " Product : " . $serv["service_name"] . "&#10;";
    }
    $query = "SELECT * FROM `tbl_order_product` WHERE `order_id` IN (" . $order . ") AND ( `user_can_c`='1' OR `user_can_c`='0')";
    $result = dquery($query);
    $final = "";
    while ($row = mysqli_fetch_assoc($result)) {
        if (isset($_POST["show"]) && $_POST["fields"] || !isset($_POST["show"])) {
            $final .= "Order ID: #" . $row["order_id"] . " " . "&#10;";
            $final .= "..................................&#10;";
            $final = $final . "Address         :" . $row["sh_firstname"] . " " . $row["sh_lastname"];
            $final = $final . "&#10" . "Address1        :" . $row["sh_address1"];
            $final = $final . "&#10" . "Address2        :" . $row["sh_address2"];
            $final = $final . "&#10" . "City            :" . $row["sh_city"];
            $final = $final . "&#10" . "Postal/Zip Code :" . $row["sh_zip"];
            $final = $final . "&#10" . "State           :" . $row["sh_state"];
            $final = $final . "&#10" . "Country         :" . $row["sh_country"];
            $final = $final . "&#10" . "Email           :" . $row["sh_email"];
            $final = $final . "&#10" . "Contact No.     :" . $row["sh_contact"];
            $final = $final . "&#10";
            if ($row["custom"] != NULL) {
                $final = $final . "&#10 Custom  :" . $row["custom"];
            }
            if ($row["note"] != NULL) {
                $final = $final . "&#10Note             :" . $row["note"] . "&#10";
            }
            $final .= "&#10===========================================================================&#10";
        }
    }
    $imeis = $append . "===========================================================================&#10;" . $final . "&#10;";
}
echo "\n<table class='form' border='0' cellpadding='3' cellspacing='2' width='100%'>\n<tbody>\n<tr>\n<td  class='fieldlabel' textalign='center'> <h2>" . $serv["service_name"] . "</h2></td>\n</tr>\n<tr >\n<td class='fieldarea'><textarea id='data' name='data' rows='5' cols='140'>" . $imeis . "</textarea></td>\n</tr>";
echo "<form method='post' action='includes/pages/dl.php'>\n<tr><td class='fieldarea'>\n    <input type='submit' name='download' value='" . $LNG["downloadtofile"] . "'>\n    <input type='hidden' name='service' value='" . $serv["service_name"] . "'>\n    <input type='hidden' name='data' value='" . $imeis . "'></td></tr></form>";
if (!$supplieraccess) {
    echo "<form method='post'><tr>\n<td class='fieldarea'>" . $LNG["sendorderlist"] . "  <input type='text' name='email'> <input type='submit' name='sendmail' value='" . $LNG["sendmail"] . "'><input type='hidden' name='data' value='" . $imeis . "'></td>\n</tr></form>";
}
echo "</tbody>\n</table></div>";
$fileverioncheck = "6.1.0";

?>