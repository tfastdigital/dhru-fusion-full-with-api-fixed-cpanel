<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../../comm.php";
require_once "../../../includes/fun.inc.php";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
if ($currency) {
    checkDemoMode(false);
    foreach ($currency as $key => $value) {
        $data["service_id"] = $id;
        $data["currency_id"] = $key;
        $data["credit_subscribe"] = $value;
        $numrows = mysqli_num_rows(dquery("select * from tbl_product_credit where service_id='" . $id . "' and currency_id='" . $key . "'"));
        if ($numrows != "0" && 0 < $value) {
            $db->update("tbl_product_credit", $data, "service_id=" . $id . " and currency_id=" . $key);
        } else {
            if (0 < $value) {
                $db->insert("tbl_product_credit", $data);
            }
        }
    }
    echo "<div id=notification1 class=successbox>" . $LNG["datasavesuccessfully"] . " </div>";
}
include_once ROOTDIR . "/includes/products.fun.php";
$md5id = md5($id);
$productDetails = getProducts("", $md5id);
echo "<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n<script src=\"http://code.jquery.com/jquery-latest.min.js\"  type=\"text/javascript\"></script> <script src=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/js/x-main2.fun.js\" language=\"javascript\"></script>\n<div style=\"padding: 30px;\">\n<form id=\"frmnetwork\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n";
$default_currency = mysqli_fetch_assoc(dquery("SELECT code, id FROM tbl_currencies WHERE tbl_currencies.default = '1'"));
$result = dquery("SELECT code, id FROM tbl_currencies WHERE tbl_currencies.default <> '1'");
echo "<table id=\"main_tbl\" style=\"display: table;\">\n            <thead>\n              <tr>\n                <th>";
echo $LNG["currency"];
echo "</th><th>";
echo $LNG["currency"];
echo " ";
echo $LNG["value"];
echo "</th><th></th>\n              </tr>\n            </thead>\n            <tbody>\n";
while ($row = mysqli_fetch_assoc($result)) {
    $credit = mysqli_fetch_assoc(dquery("select credit_subscribe from tbl_product_credit where service_id=" . $id . " and currency_id=" . $row["id"]));
    $numrows = mysqli_num_rows(dquery("select credit_subscribe from tbl_product_credit where service_id=" . $id . " and currency_id=" . $row["id"]));
    if ($numrows) {
        echo "<tr><td>" . $row["code"] . "</td><td><input type=text name=currency[" . $row["id"] . "] value=" . $credit["credit_subscribe"] . "></td><td></td></tr>";
    } else {
        $convertAmount = convertCurrency($productDetails["subscribe_credit"], $default_currency["id"], $row["id"]);
        echo "<tr><td>" . $row["code"] . "</td><td><input type=text name=currency[" . $row["id"] . "] value=" . $convertAmount . "></td><td></td></tr>";
    }
}
echo "</tbody></table>\n<br />\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn save\" type=\"submit\" /></p>\n\n</form>\n</div>\n";
$fileverioncheck = "6.1.0";

?>