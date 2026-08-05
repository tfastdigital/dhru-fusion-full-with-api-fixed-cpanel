<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 81;
checkPagePermission($pageid);
if (isset($_POST["sendmail"])) {
    require_once "../includes/mail.fun.php";
    $file = date("d-m-Y") . "_" . date("H:i:s");
    if ($_POST["email"] != "") {
        $mailarr[]["to"] = $_POST["email"];
        sendMail(80, "", "", "", false, $file . ".txt", $_POST["data"], "", $mailarr);
    } else {
        sendMail(80, "", "", "", true, $file . ".txt", $_POST["data"], $customer);
    }
    echo "    <div id=\"notification1\" class=\"successbox\">";
    echo $LNG["email"];
    echo " ";
    echo $LNG["sent"];
    echo "</div>\r\n";
}
$imeis = "";
if ($service) {
    echo "<div id='tabcontent'>";
    $servicearr = explode(",", $service);
    foreach ($servicearr as $sid) {
        $so = mysqli_fetch_assoc(dquery("select service_name from tbl_services_imei\r\nwhere id='" . $sid . "'"));
        $imeis .= $so["service_name"] . " \n";
    }
}
echo "<form method='post'>";
$select = "<select name='customer'>";
$select .= "<option value=''>Select</option>";
$sup = dquery("select `username`,`id`,email from tblUsers");
while ($rows = mysqli_fetch_assoc($sup)) {
    $select .= "<option value='" . $rows["id"] . "'>" . $rows["username"] . "</option>";
}
$select .= "</select>";
echo "<table class='form' border='0' cellpadding='3' cellspacing='2' width='100%'>\r\n    <tr>\r\n    <td class='fieldarea'><textarea id='data' name='data' rows='20' cols='140'>" . $imeis . "</textarea></td>\r\n    </tr>\r\n</table>";
echo "\r\n<table class='form' border='0' cellpadding='3' cellspacing='2' width='100%'>\r\n<tr>\r\n<td class='fieldarea'>\r\nSend this Service List to : " . $select . " or \r\n<input type='email' name='email' />\r\n<input type='submit' name='sendmail' value='" . $LNG["send"] . " " . $LNG["email"] . "' /></td>\r\n</tr>\r\n</table>\r\n</form>\r\n";
echo "</div>";
$fileverioncheck = "6.1.0";

?>