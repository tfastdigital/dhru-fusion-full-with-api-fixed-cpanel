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
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
$artical = (int) preg_replace("/[^0-9\\-a-zA-Z]/i", "", $artical);
$search = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $search);
$content = NULL;
$currentpage = "knowledgebase";
$pagetitle = $lng_languag["knowledgebase"];
$_nav = "<a href=\"" . _url("index") . "\">" . $lng_languag["home"] . "</a> / ";
$_nav .= "<a href=\"" . _url("knowledgebase") . "\">" . $lng_languag["knowledgebase"] . "</a>";
if ($id) {
    $catname = mysqli_fetch_assoc(dquery("SELECT category FROM\n     tbl_knowledgebasecat where id='" . $id . "'"));
    $pagetitle = $catname["category"];
    $_nav .= " / <a href=\"" . _url("knowledgebase/" . $id . "/" . preg_replace("/[^a-zA-Z0-9_]/", "-", $catname["category"])) . "\">" . $catname["category"] . "</a>";
}
if ($artical) {
    $_where = "id='" . $artical . "'";
    dquery("update tbl_knowledgebase set viewer=viewer+1 where id='" . $artical . "'");
    $alsoread = true;
    $_artical = mysqli_fetch_assoc(dquery("SELECT * FROM\n     tbl_knowledgebase where id='" . $artical . "'"));
    $catname = mysqli_fetch_assoc(dquery("SELECT category FROM\n     tbl_knowledgebasecat where id='" . $_artical["group_id"] . "'"));
    $pagetitle = $_artical["title"];
    $_nav .= " / <a href=\"" . _url("knowledgebase/" . $_artical[group_id] . "/" . preg_replace("/[^a-zA-Z0-9_]/", "-", $catname["category"])) . "\">" . $catname["category"] . "</a>";
    $_nav .= " / <a href=\"" . _url("knowledgebase/artical/" . $_artical["id"] . "/" . preg_replace("/[^a-zA-Z0-9_]/", "-", $_artical["title"])) . "\">" . $_artical["title"] . "</a>";
}
$fileverioncheck = "6.1.0";
$pageicon = "";
$templatefile = "knowledgebase";
installclient($pagetitle, $pageicon, $_nav);
global $cmslink;
if ($artical) {
    $smarty->assign("fullartical", "true");
}
if (!$config["faq"]) {
    $tempalte_ver["notification"]["error"] = $lng_languag["pagedisabled"];
    DisplayOutput("notallow");
    exit;
}
$smarty->assign("searchurl", _url("widget/getSearchknowledgebase"));
if (isset($_SESSION["uid"])) {
    $whereknow = " ";
} else {
    $whereknow = " and login=0";
}
if ($id) {
    $_where = "group_id='" . $id . "'";
}
$smarty->assign("cid", $id);
if ($btnsearch) {
    if ($search) {
        $_where = "title LIKE '%" . $search . "%' or content LIKE '%" . $search . "%'";
    } else {
        $_where = false;
    }
}
if ($id || $btnsearch || $artical) {
    if ($_where) {
        $result = dquery("select *,(select category from tbl_knowledgebasecat\n        where id=group_id limit 1) as groupname from tbl_knowledgebase\n         where " . $_where . " " . $whereknow . "\n        order by displayorder asc,viewer DESC,title asc");
        $i = 0;
        $groupname = "";
        $numrow = mysqli_num_rows(dquery("select * \n        from tbl_knowledgebase where " . $_where . " " . $whereknow . " order by title asc,date DESC"));
        if ($numrow != 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $content[$i]["id"] = $row["id"];
                $content[$i]["title"] = $row["title"];
                $content[$i]["groupname"] = $row["groupname"];
                $groupname = $row["groupname"];
                if ($cmslink["knowledgebase"][$row["id"]]) {
                    $content[$i]["content"] = html_entity_decode(nl2br($row["content"])) . "<span style='float: right;'><a target='_blank' \nhref='" . $cmslink["knowledgebase"][$row["id"]] . "'>Edit Page</a></span>";
                } else {
                    $content[$i]["content"] = html_entity_decode(nl2br($row["content"]));
                }
                $content[$i]["date"] = $row["date"];
                $content[$i]["viewer"] = $row["viewer"];
                $content[$i]["seo"] = _url("knowledgebase/artical/" . $row["id"] . "/" . preg_replace("/[^a-zA-Z0-9_]/", "-", $row["title"]));
                $i++;
            }
            if (count($content) == 1) {
            }
        } else {
            $smarty->assign("noartical", $lng_languag["noarticalfound"]);
        }
    } else {
        $smarty->assign("inputsearchvalue", $lng_languag["inputsearchvalue"]);
    }
    $smarty->assign("articalgroup", $groupname);
    $smarty->assign("artical", $content);
} else {
    $allpagesquery = "SELECT * FROM tbl_knowledgebasecat order by sort";
    $allpagesresult = dquery($allpagesquery);
    $i = 0;
    while ($allpagesrow = mysqli_fetch_assoc($allpagesresult)) {
        $allpages[$i]["id"] = $allpagesrow["id"];
        $allpages[$i]["groupname"] = $allpagesrow["category"];
        $allpages[$i]["info"] = $allpagesrow["info"];
        $allpages[$i]["image"] = $allpagesrow["image"];
        $allpages[$i]["seo"] = _url("knowledgebase/" . $allpagesrow["id"] . "/" . preg_replace("/[^a-zA-Z0-9_]/", "-", $allpagesrow["category"]));
        $res = dquery("select * from tbl_knowledgebase where\n        group_id='" . $allpagesrow["id"] . "' " . $whereknow . " \n        order by displayorder asc,viewer desc limit 5");
        $total = mysqli_num_rows(dquery("select * from \n        tbl_knowledgebase where\n        group_id='" . $allpagesrow["id"] . "' " . $whereknow . " \n        order by displayorder ASC ,title asc,date DESC"));
        if ($total) {
            $allpages[$i]["artical"] = $total;
            while ($row = mysqli_fetch_assoc($res)) {
            }
            $i++;
        } else {
            $allpages[$i]["artical"] = "0";
        }
        $allpages[$i]["articald"][$row["id"]]["id"] = $row["id"];
        $allpages[$i]["articald"][$row["id"]]["title"] = $row["title"];
        $allpages[$i]["articald"][$row["id"]]["seo"] = _url("knowledgebase/artical/" . $row["id"] . "/" . preg_replace("/[^a-zA-Z0-9_]/", "-", $row["title"]));
    }
}
$smarty->assign("views", $lng_languag["views"]);
$smarty->assign("category", $Rcategory);
$smarty->assign("allpages", $allpages);
$smarty->assign("search", $lng_languag["search"]);
$smarty->assign("pagetitle", $pagetitle);
if ($standalone) {
    $tempalte_ver["standalone"] = true;
    echo processSingleTemplate($templatefile);
    exit;
}
DisplayOutput($templatefile);
chkMd5sumsubpage();
class no
{
}

?>