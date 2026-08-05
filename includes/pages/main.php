<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "comm.php";
require "includes/fun.inc.php";
require "includes/client.area.inc.php";
$currentpage = "main";
$action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
$unsubpref = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $unsubpref);
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
if ($action == "viewgroups") {
    $templatefile = "client_viewgroup";
    $pageicon = "";
    installclient($pagetitle, $pageicon, $breadcrumbnav);
    $usr = mysqli_fetch_assoc(dquery("select group_start,group_end,client_group,\n  (select groupname from tbl_client_group where id=client_group) as groups\n  from tblUsers where id='" . $_SESSION["uid"] . "'"));
    $tempalte_ver["groups"] = $usr;
    $tempalte_ver["groups"]["price"] = getClientGroupPrice($_SESSION["uid"], $usr["client_group"]);
    echo processSingleTemplate($templatefile);
    exit;
}
if (isset($_SESSION["frominv"])) {
    $invs = $_SESSION["frominv"];
    unset($_SESSION["frominv"]);
    $_SESSION["template"] = "app";
    echo "    <script>\n        location.href='./viewinvoice.php?id=";
    echo $invs;
    echo "';\n    </script>\n    ";
}
if (isset($_SESSION["fromapp"])) {
    unset($_SESSION["fromapp"]);
    $_SESSION["template"] = "app";
    echo "    <script>\n        location.href='./addfunds.php?template=app';\n    </script>\n";
}
if ($_SESSION["uid"]) {
    $pagetitle = $lng_languag["clientarea"] . " " . $lng_languag["dashboard"];
    $_nav = "<a href=\"index.php\">" . $lng_languag["home"] . "</a> / " . "<a href=\"main.php\">" . $lng_languag["dashboard"] . "</a>";
    $templatefile = "client_home";
    $pageicon = "";
    if ($config["gravatar"] == 1 || $config["gravatar"] != 0) {
        $tempalte_ver["gravatar"] = true;
    }
    if ($action == "notes1") {
        $tempalte_ver["notification"]["info"] = "Sign Up Successful <br /> Your account login username is : <strong>" . $_SESSION["username"] . "</strong> and password sent to " . $_ClientsDetails["email"] . " <br /> You can change your password by <a href=\"settings.php?action=password\" > clicking here </a>";
    }
    installclient($pagetitle, $pageicon, $breadcrumbnav);
    $tempalte_ver["stopmessage"] = true;
    if ($_ClientsDetails["messagedate"] && $_ClientsDetails["messagedate"] < date("Y-m-d")) {
        $tempalte_ver["stopmessage"] = false;
    }
    $usr = mysqli_fetch_assoc(dquery("select group_start,client_group,pricechange from tblUsers where id='" . $_SESSION["uid"] . "'"));
    if ($usr["group_start"]) {
        $grp = mysqli_fetch_assoc(dquery("select groupname from tbl_client_group \n       where id='" . $usr["client_group"] . "'"));
        $tempalte_ver["clientgroup"] = $grp["groupname"];
    }
    if ($usr["pricechange"]) {
        $tempalte_ver["priceupdate"] = 1;
    }
} else {
    include "includes/login.inc.php";
    installclient($pagetitle, $pageicon, $breadcrumbnav);
    if (!$storeowner["id"]) {
        $sql = dquery("select * from tbl_add_management where `type`='login'");
        while ($row = mysqli_fetch_assoc($sql)) {
            if ($row["html_code"] != "") {
                $AdsArr[$row["p_id"]] = html_entity_decode($row["html_code"]);
            }
        }
        $smarty->assign("adds_login", $AdsArr);
        unset($AdsArr);
    }
}
$sql = dquery("select * from tbl_blogposts where status='published' ORDER BY id DESC limit 5");
while ($row = mysqli_fetch_assoc($sql)) {
    $arr[$row["id"]] = $row;
}
if ($config["paypalid"] || $config["coinbaseapikey"]) {
    $code1 = "";
    if ($config["paypalid"]) {
        $code1 .= "<h5>Paypal</h5>";
        $code1 .= "<form action=\"placeholder.php\" method=\"post\">\n                <div class=\"input-prepend\">\n                    <span class=\"add-on\">" . $_SESSION["currency"]["code"] . "</span>\n                    <input type=\"text\" name=\"amount\" id=\"storeamount\" value=\"\" class=\"span4\" style=\"margin-right:10px;\"><input type=\"hidden\" name=\"funds\" value=\"1\" />  &nbsp;&nbsp;&nbsp;&nbsp;\n                    <input type=\"submit\" class=\"btn btn-success\" value=\"" . $lng_languag["invoicespaynow"] . "\" alt=\"" . $lng_languag["invoicespaynow"] . "\">\n                </div>\n            </form>";
    }
    if ($config["coinbaseapikey"]) {
        $code1 .= " <br /><hr /><br />";
        $code1 .= "<h5>Coinbase</h5>";
        $code1 .= "<form action=\"placeholder.php\" method=\"post\">\n                <input type=\"hidden\" name=\"storecoinbase\" value=\"1\" />\n                <div class=\"input-prepend\">\n                    <span class=\"add-on\">" . $_SESSION["currency"]["code"] . "</span>\n                    <input type=\"text\" name=\"amount\" id=\"storeamount\" value=\"\" class=\"span4\" style=\"margin-right:10px;\"><input type=\"hidden\" name=\"funds\" value=\"1\" />  &nbsp;&nbsp;&nbsp;&nbsp;\n                    <input type=\"submit\" class=\"btn btn-success\" value=\"" . $lng_languag["invoicespaynow"] . "\" alt=\"" . $lng_languag["invoicespaynow"] . "\">\n                </div>\n            </form>";
    }
    $smarty->assign("storepayform", $code1);
}
$smarty->assign("news", $arr);
$smarty->assign("quicklink", $lng_languag["quicklink"]);
$smarty->assign("ordersummary", $lng_languag["ordersummary"]);
$smarty->assign("available", $lng_languag["available"]);
$smarty->assign("rejected", $lng_languag["rejected"]);
$smarty->assign("pending", $lng_languag["pending"]);
if ($_ClientsDetails["firstname"] == "" || $_ClientsDetails["lastname"] == "" || $_ClientsDetails["address1"] == "" || $_ClientsDetails["city"] == "" || $_ClientsDetails["state"] == "" || $_ClientsDetails["phonenumber"] == "" || $_ClientsDetails["zip"] == "") {
    $smarty->assign("incompleteprofile", $lng_languag["incompleteprofile"]);
}
if (isset($_SESSION["uid"]) && $config["popafenable"]) {
    $popus = mysqli_fetch_assoc(dquery("select value from tbl_settings\nwhere attribute='flashpopafter'"));
    $tempalte_ver["popupcontent"] = $popus["value"];
}
if ($unsubpref) {
    $User = mysqli_fetch_assoc(dquery("select id from tblUsers where md5(concat(id,email))='" . $unsubpref . "'"));
    if ($User["id"]) {
        dquery("update tblUsers set news_letter=1 where id='" . $User["id"] . "'");
        $tempalte_ver["notification1"] = "Newsletter unsubscribed ! Find below more email preference";
        $tempalte_ver["maillist"] = getMyMailTemplate($User["id"]);
        $tempalte_ver["maillist"]["newsletter"]["name"] = "Newsletter";
        $tempalte_ver["maillist"]["newsletter"]["flag"] = 0;
        $tempalte_ver["unique"] = $unsubpref;
        $templatefile = "client_unsubscribe";
    }
}
$tempalte_ver["token"] = generate_token("form");
chkMd5sumsubpage();
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);
class no
{
}

?>