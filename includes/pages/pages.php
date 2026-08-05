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
require ROOTDIR . "/includes/cms.fun.php";
define("APM_LANG_DEFAULT", $config["language"]);
if ($_SESSION["WLANG"]) {
    $_SESSION["apm_language"] = $_SESSION["WLANG"];
} else {
    $_SESSION["apm_language"] = APM_LANG_DEFAULT;
}
$page = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $page);
$pageid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $pageid);
$parentid = preg_replace("/[^0-9\\-a-zA-Z.]/i", "", $parentid);
$action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
if ($action) {
    $page = $action;
}
if ($storeowner["id"]) {
    $cmstable = "tbl_cms_pages_store";
    $wheres = "  l.store='REPLCACE' and p.store='" . $storeowner["id"] . "'";
} else {
    $cmstable = "tbl_cms_pages";
    $wheres = "";
}
if (!is_numeric($parentid)) {
    $nav = mysqli_fetch_assoc(dquery("select id from tbl_navigation \n    where link='" . $parentid . "' or link='" . $parentid . "?'"));
    $parentid = $nav["id"];
}
if ($pageid) {
    $page = $pageid;
}
$mrseo = $config["cms_seofriendly"];
if ($mrseo == "on") {
    if ($_SESSION["createdfile"] && $_SESSION["createdfile"] == $page) {
        $tmpo = $_SESSION["createdfile"];
        header("Location: " . $tmpo . ".html");
        unset($_SESSION[createdfile]);
        exit;
    }
} else {
    if ($_SESSION["createdfile"] && $_SESSION["createdfile"] == $page) {
        $tmpo = $_SESSION["createdfile"];
        header("Location: cms.php?page=" . $tmpo);
        unset($_SESSION[createdfile]);
        exit;
    }
}
$mr404 = $config["cms_error404"];
$id = !$page ? "index" : $page;
$_SESSION["apm_lastpage"] = $id;
$id = descape($id);
$uselang = escapeshellcmd(strtolower($_SESSION["apm_language"]));
$nopage = false;
$loginpage = false;
if ($pageid) {
    $result = dquery("SELECT id,login_req  FROM " . $cmstable . " WHERE  (urlname LIKE '" . $id . "'\n            OR id='" . $id . "') LIMIT 1");
} else {
    $result = dquery("SELECT id,login_req  FROM " . $cmstable . " WHERE  (urlname LIKE '" . $id . "'\n            OR id='" . $id . "') LIMIT 1");
}
if (mysqli_num_rows($result)) {
    $page_row = mysqli_fetch_assoc($result);
    if ($page_row["login_req"] && !isset($_SESSION["uid"])) {
        $loginpage = true;
    }
    $wheres = str_replace("REPLCACE", $page_row["id"], $wheres);
    if ($wheres) {
        if ($storeowner["id"]) {
            $sql = "SELECT l.*, p.id AS pageid, p.* FROM tbl_cms_page_language \n        AS l LEFT JOIN " . $cmstable . " AS p ON p.id = " . $page_row["id"] . " \n        WHERE  " . $wheres . " LIMIT 1";
        } else {
            $sql = "SELECT l.*, p.id AS pageid, p.* FROM tbl_cms_page_language \n        AS l LEFT JOIN " . $cmstable . " AS p ON p.id = " . $page_row["id"] . " \n        WHERE l.language = '" . $uselang . "' " . $wheres . " LIMIT 1";
        }
    } else {
        if ($storeowner["id"]) {
            $sql = "SELECT l.*, p.id AS pageid, p.* FROM tbl_cms_page_language \n        AS l LEFT JOIN " . $cmstable . " AS p ON p.id = " . $page_row["id"] . " \n        WHERE l.relid = " . $page_row["id"] . " AND " . $wheres . " LIMIT 1";
        } else {
            $sql = "SELECT l.*, p.id AS pageid, p.* FROM tbl_cms_page_language \n        AS l LEFT JOIN " . $cmstable . " AS p ON p.id = " . $page_row["id"] . " \n        WHERE l.relid = " . $page_row["id"] . " AND l.language = '" . $uselang . "' " . $wheres . " LIMIT 1";
        }
    }
    $result = dquery($sql);
    if (mysqli_num_rows($result) == 0) {
        if ($wheres) {
            $sql = "SELECT l.*, p.id AS pageid, p.* FROM tbl_cms_page_language AS l \n            LEFT JOIN " . $cmstable . " AS p ON p.id = " . $page_row["id"] . " WHERE\n             l.language = '" . APM_LANG_DEFAULT . "' \n             " . $wheres . "  LIMIT 1";
        } else {
            $sql = "SELECT l.*, p.id AS pageid, p.* FROM tbl_cms_page_language AS l \n            LEFT JOIN " . $cmstable . " AS p ON p.id = " . $page_row["id"] . " WHERE\n             l.relid = " . $page_row["id"] . " AND l.language = '" . APM_LANG_DEFAULT . "' \n             " . $wheres . "  LIMIT 1";
        }
        $result = dquery($sql);
        if (!$result) {
            $nopage = true;
        }
    }
} else {
    $nopage = true;
}
if ($loginpage) {
    $body = "<center><h4>" . $lng_languag["loginreq"] . "<br/></h4></center>";
} else {
    if ($nopage) {
        if ($mr404 == "on") {
            $sql = "SELECT l.*, p.id AS pageid, p.* FROM " . $cmstable . " AS p LEFT JOIN tbl_cms_page_language AS l ON l.relid = p.id AND l.language = '" . $uselang . "' WHERE p.urlname = 'error404' LIMIT 1";
            $result = dquery($sql);
            if (mysqli_affected_rows() == 0) {
                $sql = "SELECT l.*, p.id AS pageid, p.* FROM " . $cmstable . " AS p LEFT JOIN tbl_cms_page_language AS l ON l.relid = p.id AND l.language = '" . APM_LANG_DEFAULT . "' WHERE p.urlname = 'error404' LIMIT 1";
                $result = dquery($sql);
                if (0 < mysqli_affected_rows()) {
                    $data = mysqli_fetch_assoc($result);
                    $body = stripslashes($data["body"]);
                } else {
                    $body = "<center><h4>" . $lng_languag["cmspagenotfound"] . "<br/></h4></center>";
                }
            } else {
                $data = mysqli_fetch_assoc($result);
                $body = stripslashes($data["body"]);
                $prebody = true;
            }
        } else {
            $body = "<center><h4> " . $lng_languag["cmspagenotfound"] . "<br/></h4></center>";
        }
    } else {
        $data = mysqli_fetch_assoc($result);
        $pageid = $data["pageid"];
        $pagetitle = stripslashes($data["title"]);
        $urlname = $data["urlname"];
        $pageicon = stripslashes($data["icon"]);
        $breadcrumb = stripslashes($data["breadcrumb"]);
        $parenturlname = stripslashes($data["parenturlname"]);
        $parentbreadcrumb = stripslashes($data["parentbreadcrumb"]);
        $loggedincode = stripslashes($data["loggedincode"]);
        $smartvalues = stripslashes($data["smartvalues"]);
        $status = $data["status"];
        $view = $data["view"];
        $hits = $data["hits"];
        $body = $status == "published" ? stripslashes($data["body"]) : "<center><h4>" . $lng_languag["notyetpublished"] . "</h4></center>";
        $isiframe = $data["iframe"];
        $fullwidth = $data["fullwidth"];
        $extrameta["keywords"] = "," . $data["meta_keys"];
        $extrameta["description"] = " " . $data["meta_desc"];
    }
}
$_nav = "<a href=\"" . _url("index") . "\">" . $lng_languag["home"] . "</a> / ";
if ($pagetitle && $page) {
    $_nav .= "<a href=\"" . _url("pages/" . $page) . "\">" . $pagetitle . "</a> ";
}
if ($page) {
}
installclient($pagetitle, $pageicon, $_nav);
global $cmslink;
if ($view == "registered" && (!isset($_SESSION["uid"]) || isset($_SESSION["uid"]))) {
    $goto = "index";
    $_SESSION["createdfile"] = $id;
    include "login.php";
    exit;
}
if ($_SESSION["uid"]) {
    eval(htmlspecialchars_decode($loggedincode, ENT_QUOTES));
}
$query = "UPDATE `tbl_cms_page_language` SET `hits` = hits+1 WHERE `relid` = '" . $page_row["id"] . "' AND `language` = '" . $_SESSION["apm_language"] . "'";
$result = dquery($query);
if ($smartvalues) {
    eval(htmlspecialchars_decode($smartvalues, ENT_QUOTES));
}
if ($cmslink["cms"][$page_row["id"]]) {
    $tempalte_ver["body"] = html_entity_decode($body, ENT_QUOTES) . "\n<span style='float: right;'><a target='_blank' href=" . $cmslink["cms"][$page_row["id"]] . ">Edit Page</a></span>";
} else {
    $tempalte_ver["body"] = html_entity_decode($body, ENT_QUOTES);
}
$tempalte_ver["isiframe"] = $isiframe;
$tempalte_ver["fullwidth"] = $fullwidth;
$tempalte_ver["pageid"] = $pageid;
if ($data["meta_desc"]) {
    $smarty->assign("keywords", $data["meta_desc"]);
}
$smarty->assign("view", $view);
$smarty->assign("admin", $_SESSION["adminid"]);
$templatefile = "cms_index";
if ($action == "showiframe") {
    echo html_entity_decode($body, ENT_QUOTES);
    exit;
}
chkMd5sumsubpage();
$fileverioncheck = "6.1.0";
if ($standalone) {
    echo processSingleTemplate($templatefile);
} else {
    DisplayOutput($templatefile);
}
class no
{
}

?>