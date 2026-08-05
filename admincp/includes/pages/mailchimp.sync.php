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
$limit = 100;
if ($config["chimp_api_key"] && $config["chimp_list_id"]) {
    if (!$_SESSION["chimplimit"]) {
        if ($syncgroup == "ALL") {
            $_SESSION["chimplimit"] = mysqli_num_rows(dquery("select email,first_name,news_letter,last_name,\n        address,city,state,zip from tblUsers where userstatus='0' \n        and usertype!=3"));
        } else {
            $_SESSION["chimplimit"] = mysqli_num_rows(dquery("select email,first_name,news_letter,last_name,\n        address,city,state,zip from tblUsers where userstatus='0' \n        and usertype!=3 and client_group='" . $syncgroup . "'"));
        }
    }
    require_once "../../includes/3rdparty/mailchimp/MCAPI.class.php";
    if (!$start) {
        $start = 0;
    }
    if ($syncgroup == "ALL") {
        $sql = dquery("select email,first_name,news_letter,last_name,\n        address,city,state,zip from tblUsers where userstatus='0' \n        and usertype!=3 LIMIT " . $start . "," . $limit);
    } else {
        $sql = dquery("select email,first_name,news_letter,last_name,\n        address,city,state,zip from tblUsers where userstatus='0' \n        and usertype!=3 and client_group='" . $syncgroup . "'\n        LIMIT " . $start . "," . $limit);
    }
    echo "Batch : " . ($start / 100 + 1) . "/" . round($_SESSION["chimplimit"] / 100) . " <br/>";
    while ($r = mysqli_fetch_assoc($sql)) {
        if ($unscr && $news_letter == "0") {
            $result = storeAddress($config["chimp_api_key"], $config["chimp_list_id"], $r["email"], $r["first_name"], $r["last_name"], $r["address"], $r["city"], $r["state"], $r["zip"], true);
        } else {
            $result = storeAddress($config["chimp_api_key"], $config["chimp_list_id"], $r["email"], $r["first_name"], $r["last_name"], $r["address"], $r["city"], $r["state"], $r["zip"]);
        }
        if (trim($result) == "Error: Invalid MailChimp List ID:" || trim($result) == "Error: API Key can not be blank" || deregi("Invalid MailChimp List ID", $result) || deregi("Invalid Mailchimp API Key", $result)) {
            echo "Invalid API Key or List ID<br />";
            exit;
        }
        echo $result . "<br />";
    }
    if ($start < $_SESSION["chimplimit"]) {
        echo "<script>\nlocation.href='../../includes/pages/mailchimp.sync.php?syncgroup=";
        echo $syncgroup;
        echo "&start=";
        echo $start + 100;
        echo "&newsletter=';\n</script>\n";
    }
    if ($newsletter) {
        $sql = dquery("select * from tbl_newsletter WHERE active='1'");
        while ($r = mysqli_fetch_assoc($sql)) {
            $result = storeAddress($config["chimp_api_key"], $config["chimp_list_id"], $r["email"], $r["name"]);
            if (trim($result) == "Error: Invalid MailChimp List ID:" || trim($result) == "Error: API Key can not be blank" || deregi("Invalid MailChimp List ID", $result) || deregi("Invalid Mailchimp API Key", $result)) {
                echo "Invalid API Key or List ID<br />";
                exit;
            }
            echo $result . "<br />";
        }
    }
} else {
    echo "Key and List ID  Required";
}
$fileverioncheck = "6.1.0";

?>