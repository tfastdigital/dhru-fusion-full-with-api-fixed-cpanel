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
if ($config["zohokey"] && $config["zoholist"]) {
    if (!$_SESSION["chimplimit"]) {
        if ($syncgroup == "ALL") {
            $_SESSION["chimplimit"] = mysqli_num_rows(dquery("select email,first_name,news_letter,last_name,\n            address,city,state,zip from tblUsers where userstatus='0' \n            and usertype!=3"));
        } else {
            $_SESSION["chimplimit"] = mysqli_num_rows(dquery("select email,first_name,news_letter,last_name,\n            address,city,state,zip from tblUsers where userstatus='0' \n            and usertype!=3 and client_group='" . $syncgroup . "'"));
        }
    }
    if (!$start) {
        $start = 0;
    }
    $mail = NULL;
    if ($syncgroup == "ALL") {
        $sql = dquery("select email,first_name,news_letter,last_name,\n            address,city,state,zip from tblUsers where userstatus='0' \n            and usertype!=3 LIMIT " . $start . "," . $limit);
    } else {
        $sql = dquery("select email,first_name,news_letter,last_name,\n            address,city,state,zip from tblUsers where userstatus='0' \n            and usertype!=3 and client_group='" . $syncgroup . "'\n            LIMIT " . $start . "," . $limit);
    }
    echo "Batch : " . ($start / 100 + 1) . "/" . round($_SESSION["chimplimit"] / 100) . " <br/>";
    while ($r = mysqli_fetch_assoc($sql)) {
        if ($unscr && $news_letter == "0") {
            $mail[] = $r["email"];
        } else {
            $mail[] = $r["email"];
        }
    }
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, "https://campaigns.zoho.com/api/addlistsubscribersinbulk?authtoken=" . $config["zohokey"] . "&scope=CampaignsAPI&listkey=" . $config["zoholist"] . "&resfmt=JSON&emailids=" . implode(",", $mail));
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    $buffer = curl_exec($curl_handle);
    curl_close($curl_handle);
    if (!empty($buffer)) {
        $res = json_decode($buffer, true);
        if ($res["status"] == "error") {
            echo $res["Code"];
        }
        if (count($res["ignored_contacts"])) {
            echo "<strong>Ignored Contacts </strong><br />";
            print_r($res["ignored_contacts"]);
            echo "<br />";
        }
        if (count($res["existing_contacts"])) {
            echo "<strong>Existing Contacts</strong> <br />";
            print_r($res["existing_contacts"]);
            echo "<br />";
        }
    }
    if ($start < $_SESSION["chimplimit"] && 100 < $_SESSION["chimplimit"]) {
        echo "        <script>\n            location.href='../../includes/pages/zoho.sync.php?syncgroup=";
        echo $syncgroup;
        echo "&start=";
        echo $start + 100;
        echo "&newsletter=';\n        </script>\n        ";
        if ($newsletter) {
            $sql = dquery("select * from tbl_newsletter WHERE active='1'");
            while ($r = mysqli_fetch_assoc($sql)) {
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, "https://campaigns.zoho.com/api/addlistsubscribersinbulk?authtoken=" . $config["zohokey"] . "&scope=CampaignsAPI&listkey=" . $config["zoholist"] . "&resfmt=JSON&emailids=" . implode(",", $mail));
                curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                $buffer = curl_exec($curl_handle);
                curl_close($curl_handle);
                if (!empty($buffer)) {
                    $res = json_decode($buffer, true);
                    if (count($res["ignored_contacts"])) {
                        echo "<strong>Ignored Contacts </strong><br />";
                        print_r($res["ignored_contacts"]);
                        echo "<br />";
                    }
                    if (count($res["existing_contacts"])) {
                        echo "<strong>Existing Contacts</strong> <br />";
                        print_r($res["existing_contacts"]);
                        echo "<br />";
                    }
                }
            }
        }
    } else {
        echo "<br />Sync Completed";
        exit;
    }
} else {
    echo "Authentication Token and List Key Required";
}
$fileverioncheck = "6.1.0";

?>