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
require "./comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
$currentpage = "View Ticket";
$pagetitle = $lng_languag["viewticket"];
$_nav = "<a href=\"index.php\">" . $lng_languag["home"] . "</a> / ";
$_nav .= "<a href=\"#\">" . $lng_languag["viewticket"] . "</a>";
$templatefile = "viewticket";
$pageicon = "";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$tid = preg_replace("[^a-zA-Z0-9]", "", $tid);
$access = preg_replace("[^A-Za-z0-9]", "", $access);
$id = preg_replace("[^A-Za-z0-9]", "", $id);
if ($id && $close) {
    dquery("UPDATE tbl_support_tickets SET sid='2' WHERE tid='" . $id . "'");
}
if ($id && $reply) {
    require_once "includes/support.fun.php";
    $sql = dquery("select * from tbl_support_tickets where md5(tid)='" . $tid . "' AND MD5(CONCAT(id,tid))='" . $access . "'");
    $row = mysqli_fetch_assoc($sql);
    $ticket["message"] = nl2br($message);
    ticket($row["tid"], $row["uid"], "", $row["name"], "", $row["did"], $row["pid"], $ticket);
}
if ($tid && $access) {
    $sql = dquery("select * from tbl_support_tickets where md5(tid)='" . $tid . "' \n    AND MD5(CONCAT(id,tid))='" . $access . "'");
    if (mysqli_num_rows($sql)) {
        $row = mysqli_fetch_assoc($sql);
        $dep = mysqli_fetch_assoc(dquery("select login from tbl_support_department \n        where id='" . $row["did"] . "'"));
        if ($dep["login"] && isset($_SESSION["uid"]) || !$dep["login"]) {
            $_nav .= "/ <a href=\"viewticket.php?tid=" . $tid . "&access=" . $access . "\">" . $row["tid"] . "</a>";
            installclient($pagetitle, $pageicon, $breadcrumbnav);
            if ($row["uid"] != 0 && $row["uid"] != $_SESSION["uid"]) {
                $_SESSION["afterloginredirect"] = $_SERVER["REQUEST_URI"];
                include_once "includes/login.inc.php";
                installclient($pagetitle, $pageicon, $breadcrumbnav);
            }
            $smarty->assign("id", $row["tid"]);
            $smarty->assign("tid", $row["tid"]);
            if ($row["sid"] == 2) {
                $smarty->assign("close", true);
            }
            $smarty->assign("subject", $row["subject"]);
            $sid = mysqli_fetch_assoc(dquery("select status,color from tbl_support_status where id='" . $row["sid"] . "'"));
            $smarty->assign("status", "<span style='color:" . $sid["color"] . "'>" . $sid["status"] . "</span>");
            $pid = mysqli_fetch_assoc(dquery("select priority,color from tbl_support_priority where id='" . $row["pid"] . "'"));
            $smarty->assign("priority", "<span style='color:" . $pid["color"] . "'>" . $pid["priority"] . "</span>");
            $smarty->assign("date", formatDate($row["date"], "", false));
            $tarr = [];
            $d = dquery("select * from tbl_support_tickets \n            where md5(tid)='" . $tid . "' ORDER BY id asc");
            while ($t = mysqli_fetch_assoc($d)) {
                $t["message"] = html_entity_decode($t["message"]);
                $tarr[$t["id"]] = $t;
                if ($t["aid"]) {
                    $name = mysqli_fetch_assoc(dquery("select firstname,lastname from tbl_admin where id='" . $t["aid"] . "'"));
                    $tarr[$t["id"]]["reply"] = $name["firstname"] . " " . $name["lastname"];
                } else {
                    if ($t["uid"]) {
                        $name = mysqli_fetch_assoc(dquery("select first_name,last_name from tblUsers where id='" . $t["uid"] . "'"));
                        $tarr[$t["id"]]["reply"] = $name["first_name"] . " " . $name["last_name"];
                    } else {
                        $tarr[$t["id"]]["reply"] = $t["name"];
                    }
                }
            }
            $smarty->assign("tickets", $tarr);
        } else {
            $_SESSION["afterloginredirect"] = $_SERVER["REQUEST_URI"];
            include_once "includes/login.inc.php";
            installclient($pagetitle, $pageicon, $breadcrumbnav);
            $templatefile = "client_accessdenied";
            $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
        }
    } else {
        $templatefile = "client_accessdenied";
        $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
    }
} else {
    $templatefile = "client_accessdenied";
    $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
}
$tempalte_ver["token"] = generate_token("form");
chkMd5sumsubpage();
if ($standalone) {
    $tempalte_ver["standalone"] = true;
    echo processSingleTemplate($templatefile);
    exit;
}
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);
class no
{
}

?>