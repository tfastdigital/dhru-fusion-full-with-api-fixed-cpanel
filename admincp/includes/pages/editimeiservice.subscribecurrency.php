<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "includes/fun.inc.php";
if (!$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($currency) {
    checkDemoMode(false);
    foreach ($currency as $key => $value) {
        $data["service_id"] = $id;
        $data["currency_id"] = $key;
        $data["credit_subscribe"] = $value;
        $numrows = mysqli_num_rows(dquery("select * from tbl_imei_credit where service_id='" . $id . "' and currency_id='" . $key . "'"));
        if ($numrows != "0" && 0 < $value) {
            $db->update("tbl_imei_credit", $data, "service_id=" . $id . " and currency_id=" . $key);
        } else {
            if (0 < $value) {
                $db->insert("tbl_imei_credit", $data);
            }
        }
    }
    echo "<div id=notification1 class=successbox>" . $LNG["datasavesuccessfully"] . " </div>";
}
include_once ROOTDIR . "/includes/imeiservices.fun.php";
$md5id = md5($id);
$imeiserviceDetails = getIMEIServices("", $md5id);
echo "<form id=\"frmnetwork\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n";
$default_currency = mysqli_fetch_assoc(dquery("SELECT code, id FROM tbl_currencies WHERE tbl_currencies.default = '1'"));
$result = dquery("SELECT code, id FROM tbl_currencies WHERE tbl_currencies.default <> '1'");
echo "<table id=\"main_tbl\" style=\"display: table;\">\n            <thead>\n              <tr>\n                <th width=\"100px\">";
echo $LNG["currency"];
echo "</th><th>";
echo $LNG["currency"];
echo " ";
echo $LNG["value"];
echo "</th><th></th>\n              </tr>\n            </thead>\n            <tbody>\n";
while ($row = mysqli_fetch_assoc($result)) {
    $credit = mysqli_fetch_assoc(dquery("select credit_subscribe from tbl_imei_credit where service_id=" . $id . " and currency_id=" . $row["id"]));
    $numrows = mysqli_num_rows(dquery("select credit_subscribe from tbl_imei_credit where service_id=" . $id . " and currency_id=" . $row["id"]));
    if ($numrows) {
        echo "<tr><td>" . $row["code"] . "</td><td><input type=text name=currency[" . $row["id"] . "] value=" . $credit["credit_subscribe"] . "></td><td></td></tr>";
    } else {
        $convertAmount = convertCurrency($imeiserviceDetails["subscribe_credit"], $default_currency["id"], $row["id"]);
        echo "<tr><td>" . $row["code"] . "</td><td><input type=text name=currency[" . $row["id"] . "] value=" . $convertAmount . "></td><td></td></tr>";
    }
}
echo "</tbody></table>\n<br />\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn save\" type=\"submit\" /></p>\n\n</form>";
$fileverioncheck = "6.1.0";

?>