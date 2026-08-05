<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 393;
checkPagePermission($pageid);
if (isset($_POST["sendmail"])) {
    require_once "../includes/mail.fun.php";
    $file = date("d-m-Y") . "_" . date("H:i:s");
    if ($_POST["email"] != "") {
        $mailarr[]["to"] = $_POST["email"];
        sendMail(15, "", "", "", false, $file . ".txt", $_POST["data"], "", $mailarr);
    }
    echo "<div id=notification1 class=successbox>" . $LNG["ordersendmail"] . "</div>";
}
if ($order) {
    include_once "productorder.head.php";
    echo "<div id='tabcontent'>";
    $_SESSION["once_accepted"] = true;
    if (isset($_POST["show"]) && $_POST["datetime"] || !isset($_POST["show"])) {
        $append = "Date: " . date("d-m-Y") . " " . date("H:i:s");
        $date = "Date: " . date("d-m-Y") . " " . date("H:i:s");
        $serv = mysqli_fetch_assoc(dquery("SELECT `service_name` from `tbl_products`"));
        $append .= "  Product : " . $serv["service_name"] . "&#10;";
    }
    $query = "SELECT *,(select bundle from tbl_products where id=service_id) as bun FROM \n`tbl_order_product` WHERE `invoiceid` IN (" . $order . ") AND ( `user_can_c`='1' OR `user_can_c`='0')\n group by invoiceid";
    $result = dquery($query);
    $final = "";
    if (!function_exists(getCustomFields)) {
        require_once "../includes/customfield.fun.inc.php";
        while ($row = mysqli_fetch_assoc($result)) {
        }
    }
    $final = "";
    $gift = "";
    $bun = "";
    if ($row["gift"]) {
        $gift = "[Gift Wrap] ";
    }
    if ($row["bun"]) {
        $bun = "[Bundle] ";
    }
    $final .= "Order ID: #" . $row["invoiceid"] . " " . $gift . " " . $bun . "&#10;";
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
    $final = $final . "&#10----------------------------------&#10;";
    $prod = dquery("SELECT order_id,service_id,\n    (SELECT service_name FROM tbl_products WHERE id=service_id) as service\n     from tbl_order_product where invoiceid='" . $row["invoiceid"] . "' and user_can_c='0'");
    while ($det = mysqli_fetch_assoc($prod)) {
        $cst = getCustomFields("product", $det["service_id"], $det["order_id"]);
        $customdetail = NULL;
        if ($cst) {
            foreach ($cst as $custom) {
                $customdetail = $customdetail . "" . $custom["name"] . ":" . $custom["value"] . "    ";
            }
        }
        $new = $det["service"];
        if ($customdetail) {
            $final = $final . $new . " [" . $customdetail . "] &#10;";
        } else {
            $final = $final . $new . "&#10;";
        }
    }
    $imeis2 .= $final . "&#10;=============================&#10;";
}
echo "\n<table class='form' border='0' cellpadding='3' cellspacing='2' width='100%'>\n<tbody>\n<tr>\n<td  class='fieldlabel' textalign='center'> </td>\n</tr>\n<tr >\n<td class='fieldarea'><textarea id='data' name='data' rows='10' cols='140'>" . $imeis2 . "</textarea></td>\n</tr>";
echo "<form method='post' action='includes/pages/dl.php'>\n<tr><td class='fieldarea'>\n    <input type='submit' name='download' value='" . $LNG["downloadtofile"] . "'>\n    <input type='hidden' name='service' value='Shopping'>\n    <input type='hidden' name='data' value='" . $imeis2 . "'>\n    <input type='hidden' name='order' value='" . $order . "' />\n    </td></tr></form>";
if (!$supplieraccess) {
    echo "<form method='post'><tr>\n<td class='fieldarea'>" . $LNG["sendorderlist"] . " <input type='hidden' name='order' value='" . $order . "' /> <input type='text' name='email'> <input type='submit' name='sendmail' value='" . $LNG["sendmail"] . "'><input type='hidden' name='data' value='" . $imeis2 . "'></td>\n</tr></form>";
}
echo "</tbody>\n</table></div>";
$fileverioncheck = "6.1.0";

?>