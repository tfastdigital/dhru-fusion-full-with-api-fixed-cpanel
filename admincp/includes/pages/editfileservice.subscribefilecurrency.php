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
require_once "includes/fun.inc.php";
if ($currency) {
    checkDemoMode(false);
    foreach ($currency as $key => $value) {
        $data["service_id"] = $id;
        $data["currency_id"] = $key;
        $data["credit_subscribe"] = $value;
        $numrows = mysqli_num_rows(dquery("select * from tbl_file_credit where service_id='" . $id . "' and currency_id='" . $key . "'"));
        if ($numrows != "0" && 0 < $value) {
            $db->update("tbl_file_credit", $data, "service_id=" . $id . " and currency_id=" . $key);
        } else {
            if (0 < $value) {
                $db->insert("tbl_file_credit", $data);
            }
        }
    }
    echo "<div id=notification1 class=successbox>" . $LNG["datasavesuccessfully"] . " </div>";
}
include_once ROOTDIR . "/includes/fileservices.fun.php";
$md5id = md5($id);
$fileserviceDetails = getfileServices("", $md5id);
echo "<div  class=\"groupstabes\" >\n\n<form id=\"frmnetwork\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n";
$default_currency = mysqli_fetch_assoc(dquery("SELECT code, id FROM tbl_currencies WHERE tbl_currencies.default = '1'"));
$result = dquery("SELECT code, id FROM tbl_currencies WHERE tbl_currencies.default <> '1'");
echo "<table  class=\"form\" >\n            <thead>\n              <tr>\n                <th class='fieldlabel'>";
echo $LNG["currency"];
echo "</th><td class='fieldarea'>";
echo $LNG["currency"];
echo " ";
echo $LNG["value"];
echo "</td><th></th>\n              </tr>\n            </thead>\n            <tbody>\n";
while ($row = mysqli_fetch_assoc($result)) {
    $credit = mysqli_fetch_assoc(dquery("select credit_subscribe from tbl_file_credit where service_id=" . $id . " and currency_id=" . $row["id"]));
    $numrows = mysqli_num_rows(dquery("select credit_subscribe from tbl_file_credit where service_id=" . $id . " and currency_id=" . $row["id"]));
    if ($numrows) {
        echo "<tr><td class='fieldlabel'>" . $row["code"] . "</td><td  class='fieldarea'><input type=text name=currency[" . $row["id"] . "] value=" . $credit["credit_subscribe"] . "></td><td></td></tr>";
    } else {
        $convertAmount = convertCurrency($fileserviceDetails["subscribe_credit"], $default_currency["id"], $row["id"]);
        echo "<tr><td  class='fieldlabel'>" . $row["code"] . "</td><td  class='fieldarea'><input type=text name=currency[" . $row["id"] . "] value=" . $convertAmount . "></td><td></td></tr>";
    }
}
echo "</tbody></table>\n\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn save\" type=\"submit\" /></p>\n\n</form></div>";
$fileverioncheck = "6.1.0";

?>