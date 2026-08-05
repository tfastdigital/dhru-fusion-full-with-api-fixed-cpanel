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
require "includes/fun.inc.php";
require "includes/client.area.inc.php";
$category = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $category);
$artical = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $artical);
$search = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $search);
$content = NULL;
$currentpage = "knowledgebase";
$pagetitle = $lng_languag["download"] . " " . $lng_languag["file"];
$_nav = "<a href=\"" . _url("index") . "\">" . $lng_languag["home"] . "</a> / ";
$_nav .= "<a href=\"" . _url("downloads") . "\">" . $lng_languag["downloads"] . "</a>";
if ($flag) {
    $pagetitle = $lng_languag["downloads"];
}
if ($category) {
    $catname = mysqli_fetch_assoc(dquery("SELECT category FROM tbl_downloadcat\n     where id='" . $category . "'"));
    $_nav .= " / <a>" . $catname["category"] . "</a>";
}
$pageicon = "";
$templatefile = "downloadfile";
installclient($pagetitle, $pageicon, $_nav);
if ($artical) {
    $_where = "id='" . $artical . "'";
    $smarty->assign("fullartical", "true");
    dquery("update tbl_download set counter=counter+1 where id='" . $artical . "'");
    $alsoread = true;
}
if ($category) {
    $_where = "group_id='" . $category . "'";
}
$smarty->assign("cid", $category);
if ($btnsearch) {
    if ($search) {
        $_where = "filename LIKE '%" . $search . "%' or description LIKE '%" . $search . "%'";
    } else {
        $_where = "";
    }
}
if (!$_SESSION["uid"]) {
}
$date = date("Y-m-d");
if ($category || $btnsearch) {
    $q = dquery("select * from tbl_download where " . $_where . " And forproduct='0' \n    and donotshow='1' and IF(date!='',`date`>='" . $date . "', 1 )");
    while ($r = mysqli_fetch_assoc($q)) {
        $fext = substr($r["file"], strrpos($r["file"], "."));
        $finename = str_replace($fext, "", $r["file"]);
        $filename = md5($finename . time()) . $fext;
        $r["link"] = ROOTDIR . "/" . $donloaddirpath . "/" . $filename;
        $r["downloadlink"] = "./download/action/downloads/type/file/id/" . md5($r["id"]);
        $r["id"] = md5($r["id"]);
        $download[$r["id"]] = $r;
    }
    $allpagesquery = "SELECT * FROM tbl_downloadcat \n            where mid=" . $category;
    $allpagesresult = dquery($allpagesquery);
    $i = 0;
    for ($allpages = NULL; $allpagesrow = mysqli_fetch_assoc($allpagesresult); $i++) {
        $allpages[$i]["id"] = $allpagesrow["id"];
        $allpages[$i]["groupname"] = $allpagesrow["category"];
        $allpages[$i]["info"] = $allpagesrow["info"];
        $allpages[$i]["size"] = $allpagesrow["size"];
        $allpages[$i]["seo"] = _url("");
        $row = mysqli_fetch_assoc(dquery("select count(*) as total \nfrom tbl_download where group_id='" . $allpagesrow["id"] . "' \nAnd forproduct='0' and donotshow='1' and \nIF(date!='',`date`>='" . $date . "', 1 )"));
        if ($row) {
            $allpages[$i]["artical"] = $row["total"];
        } else {
            $allpages[$i]["artical"] = "0";
        }
    }
    $smarty->assign("downloads", $download);
    $smarty->assign("downloadscats", $allpages);
    $allpages = NULL;
} else {
    $allpagesquery = "SELECT * FROM tbl_downloadcat where mid=0";
    $allpagesresult = dquery($allpagesquery);
    for ($i = 0; $allpagesrow = mysqli_fetch_assoc($allpagesresult); $i++) {
        $allpages[$i]["id"] = $allpagesrow["id"];
        $allpages[$i]["groupname"] = $allpagesrow["category"];
        $allpages[$i]["seo"] = _url("downloads/category/" . $allpagesrow["id"] . "/" . preg_replace("/[^a-zA-Z0-9_]/", "-", $allpagesrow["category"]));
        $allpages[$i]["info"] = $allpagesrow["info"];
        $allpages[$i]["size"] = $allpagesrow["size"];
        $row = mysqli_fetch_assoc(dquery("select count(*) as total \n        from tbl_download where \n        (\n        group_id='" . $allpagesrow["id"] . "' or \n        group_id=(select id from tbl_downloadcat where mid='" . $allpagesrow["id"] . "')\n        ) " . $_where . "\n        And forproduct='0' and donotshow='1' and \n        IF(date!='',`date`>='" . $date . "', 1 )"));
        if ($row) {
            $allpages[$i]["artical"] = $row["total"];
        } else {
            $allpages[$i]["artical"] = "0";
        }
    }
}
$result = dquery("SELECT * FROM tbl_downloadcat where mid=0");
$i = 0;
while ($categorys = mysqli_fetch_assoc($result)) {
    $Rcategory[$i]["groupname"] = ($categorys["mid"] ? "&nbsp;&nbsp;" : "") . $categorys["category"];
    $Rcategory[$i]["groupid"] = $categorys["id"];
    $Rcategory[$i]["seo"] = _url("downloads/category/" . $categorys["id"]);
    $Rcategory[$i]["seo"] = _url("downloads/category/" . $categorys["id"] . "/" . preg_replace("/[^a-zA-Z0-9_]/", "-", $categorys["category"]));
    $i++;
    if (mysqli_num_rows(dquery("select id from tbl_downloadcat \n    where mid='" . $categorys["id"] . "'"))) {
        for ($qd = dquery("select * from tbl_downloadcat \n    where mid='" . $categorys["id"] . "'"); $rq = mysqli_fetch_assoc($qd); $i++) {
            $Rcategory[$i]["groupname"] = ($rq["mid"] ? "&nbsp;&nbsp;&nbsp;-&nbsp;" : "") . $rq["category"];
            $Rcategory[$i]["groupid"] = $rq["id"];
            $Rcategory[$i]["seo"] = _url("downloads/category/" . $rq["id"]);
            $Rcategory[$i]["seo"] = _url("downloads/category/" . $rq["id"] . "/" . preg_replace("/[^a-zA-Z0-9_]/", "-", $rq["category"]));
        }
    }
}
$smarty->assign("category", $Rcategory);
$smarty->assign("allpages", $allpages);
$smarty->assign("search", $lng_languag["search"]);
chkMd5sumsubpage();
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);
class no
{
}

?>