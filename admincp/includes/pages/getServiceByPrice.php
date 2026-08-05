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
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($imei) {
    $imeiprice = mysqli_fetch_assoc(dquery("select credit \n    from tbl_services_imei where id='" . $imei . "'"));
    $result = dquery("select code,id from tbl_currencies");
    while ($imeicredit = mysqli_fetch_assoc($result)) {
        $priceset = mysqli_fetch_assoc(dquerymailsettings . basic("select credit \n        from tbl_imei_credit where service_id='" . $imei . "' and \n        currency_id='" . $imeicredit["id"] . "'"));
        if ($priceset["credit"]) {
            echo "    \n       <li class=\"li_code\"><span>";
            echo $imeicredit["code"];
            echo "<input type=\"hidden\" name=\"imei_hidden_dis[";
            echo $imeicredit["id"];
            echo "]\" value=\"";
            echo $priceset["credit"];
            echo "\"/></span><span>";
            echo $priceset["credit"];
            echo "</span><span><input type=\"text\" style=\"width: 50px;\" name=\"imei_discount[";
            echo $imeicredit["id"];
            echo "]\"/></span></li>\n        ";
        } else {
            echo "    \n        <li class=\"li_code\"><span>";
            echo $imeicredit["code"];
            echo "<input type=\"hidden\" name=\"imei_hidden_dis[";
            echo $imeicredit["id"];
            echo "]\" value=\"";
            echo convertCurrency($imeiprice["credit"], $default_currency["id"], $imeicredit["id"]);
            echo "\"/></span><span>";
            echo convertCurrency($imeiprice["credit"], $default_currency["id"], $imeicredit["id"]);
            echo "</span><span><input type=\"text\" style=\"width: 50px;\" name=\"imei_discount[";
            echo $imeicredit["id"];
            echo "]\"/></span></li>\n    ";
        }
    }
}
if ($file) {
    $fileprice = mysqli_fetch_assoc(dquery("select credit from \n    tbl_services_file where id='" . $file . "'"));
    $result = dquery("select code,id from tbl_currencies");
    while ($filecredit = mysqli_fetch_assoc($result)) {
        $priceset = mysqli_fetch_assoc(dquery("select credit from tbl_file_credit where service_id='" . $file . "' and currency_id='" . $filecredit["id"] . "'"));
        if ($priceset["credit"]) {
            echo "    \n            <li class=\"li_code\"><span>";
            echo $filecredit["code"];
            echo "<input type=\"hidden\" name=\"file_hidden_dis[";
            echo $filecredit["id"];
            echo "]\" value=\"";
            echo $priceset["credit"];
            echo "\"/></span><span>";
            echo $priceset["credit"];
            echo "</span><span><input type=\"text\" style=\"width: 50px;\" name=\"file_discount[";
            echo $filecredit["id"];
            echo "]\"/></span></li>\n        ";
        } else {
            echo "    \n        <li class=\"li_code\"><span>";
            echo $filecredit["code"];
            echo "<input type=\"hidden\" name=\"file_hidden_dis[";
            echo $filecredit["id"];
            echo "]\" value=\"";
            echo convertCurrency($fileprice["credit"], $default_currency["id"], $filecredit["id"]);
            echo "\"/></span><span>";
            echo convertCurrency($fileprice["credit"], $default_currency["id"], $filecredit["id"]);
            echo "</span><span><input type=\"text\" style=\"width: 50px;\" name=\"file_discount[";
            echo $filecredit["id"];
            echo "]\"/></span></li>\n    ";
        }
    }
}
if ($server) {
    $result = dquery("select credit from tbl_server_log\n     where id='" . $server . "'");
    $numberrows = mysqli_num_rows($result);
    if ($numberrows) {
        $serverprice = mysqli_fetch_assoc($result);
    }
    $result = dquery("select code,id from tbl_currencies");
    while ($servercredit = mysqli_fetch_assoc($result)) {
        $priceset = mysqli_fetch_assoc(dquery("select credit from \n        tbl_server_credit where service_id='" . $server . "'\n         and currency_id='" . $servercredit["id"] . "'"));
        if ($priceset["credit"]) {
            echo "    \n            <li class=\"li_code\"><span>";
            echo $servercredit["code"];
            echo "<input type=\"hidden\" name=\"server_hidden_dis[";
            echo $servercredit["id"];
            echo "]\" value=\"";
            echo $priceset["credit"];
            echo "\"/></span><span>";
            echo $priceset["credit"];
            echo "</span><span><input type=\"text\" style=\"width: 50px;\" name=\"server_discount[";
            echo $servercredit["id"];
            echo "]\"/></span></li>\n        ";
        } else {
            echo "    \n        <li class=\"li_code\"><span>";
            echo $servercredit["code"];
            echo "<input type=\"hidden\" name=\"server_hidden_dis[";
            echo $servercredit["id"];
            echo "]\" value=\"";
            echo convertCurrency($serverprice["credit"], $default_currency["id"], $servercredit["id"]);
            echo "\"/></span><span>";
            echo convertCurrency($serverprice["credit"], $default_currency["id"], $servercredit["id"]);
            echo "</span><span><input type=\"text\" style=\"width: 50px;\" name=\"server_discount[";
            echo $servercredit["id"];
            echo "]\"/></span></li>\n    ";
        }
    }
}
$fileverioncheck = "6.1.0";

?>