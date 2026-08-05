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
require "includes/blog.fun.php";
$fileverioncheck = "6.1.0";
if ($post && $action == "post") {
    $id = $post;
}
$category = (int) preg_replace("/[^0-9\\-a-zA-Z]/i", "", $category);
$cat = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $cat);
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
$page = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $page);
$action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
$name = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $name);
$email = preg_replace("/[^0-9\\-a-zA-Z@.]/i", "", $email);
$message = preg_replace("/[^0-9\\-a-zA-Z ]/i", "", $message);
$url = preg_replace("/[^0-9\\-a-zA-Z.\\/]/i", "", $url);
$currentpage = "blog";
$pagetitle = $lng_languag["blog"];
$_nav = "<a href=\"" . _url("index") . "\">" . $lng_languag["home"] . "</a> / ";
$_nav .= "<a href=\"" . _url("blog") . "\">" . $lng_languag["blog"] . "</a>";
$pageicon = "";
if ($category) {
    $catquery = "SELECT name FROM tbl_blogcats WHERE id='" . $category . "'";
    $catresult = dquery($catquery);
    $cattitle = mysqli_fetch_assoc($catresult);
    $_nav .= " / <a> " . $cattitle["name"] . "</a>";
    $pagetitle .= " - " . $cattitle["name"] . "";
}
if ($id) {
    $postsquery = "SELECT * FROM tbl_blogposts WHERE id='" . $id . "' AND\n     status != 'draft' AND type='post'";
    $postsresult = dquery($postsquery);
    $posts = mysqli_fetch_assoc($postsresult);
    $catquery = "SELECT name FROM tbl_blogcats WHERE id='" . $posts["cat"] . "'";
    $catresult = dquery($catquery);
    $category = mysqli_fetch_assoc($catresult);
    $cas = explode(",", $posts["cat"]);
    $_nav .= " / <a href=\"blog/category/" . $cas[0] . "\">" . $category["name"] . "</a>";
    $_nav .= " / <a> " . $posts["title"] . "</a>";
    $pagetitle .= " - " . $posts["title"] . "";
}
if ($permalink) {
    $templatefile = "blog_page";
    if (!$config["blog"]) {
        $tempalte_ver["notification"]["error"] = $lng_languag["pagedisabled"];
        DisplayOutput("notallow");
        exit;
    }
    $permalink = descape($permalink);
    $pagequery = "SELECT * FROM tbl_blogposts WHERE permalink='" . $permalink . "' AND status != 'draft' AND type='page'";
    $pageresult = dquery($pagequery);
    $pages = mysqli_fetch_assoc($pageresult);
    $pagetitle = $pages["title"];
    $_nav .= " / " . $pages["title"];
}
installclient($pagetitle, $pageicon, $_nav);
global $cmslink;
if ($id) {
    $templatefile = "blog";
    if (!$config["blog"]) {
        $tempalte_ver["notification"]["error"] = $lng_languag["pagedisabled"];
        DisplayOutput("notallow");
        exit;
    }
    $postsquery = "SELECT * FROM tbl_blogposts WHERE id='" . $id . "' AND status != 'Draft' AND type='post'";
    $postsresult = dquery($postsquery);
    $posts = mysqli_fetch_assoc($postsresult);
    $catquery = "SELECT * FROM tbl_blogcats WHERE id='" . $posts["cat"] . "'";
    $catresult = dquery($catquery);
    $category = mysqli_fetch_assoc($catresult);
    $post["id"] = $posts["id"];
    $post["category"] = $category["name"];
    $post["catid"] = $posts["cat"];
    $post["author"] = $posts["author"];
    $post["title"] = $posts["title"];
    if ($cmslink["blog"][$id]) {
        $post["content"] = html_entity_decode($posts["post"]) . "<span style='float: right;'><a target='_blank' href='" . $cmslink["blog"][$id] . "'>Edit Page</a></span>";
    } else {
        $post["content"] = html_entity_decode($posts["post"]);
    }
    $post["date"] = $posts["date"];
    $post["seocat"] = friendlyURL($category["name"]);
    $post["seourl"] = friendlyURL($posts["title"]);
    if ($posts["comments"] == "on" && !in_array($_SERVER["REMOTE_ADDR"], explode(",", $blog["blockedips"]))) {
        $smarty->assign("allowcomments", "true");
    }
    $smarty->assign("post", $post);
    if ($posts["comments"] == "on") {
        if (!$_SESSION["uid"]) {
            $NewsletterCaptcha = createVerification("res");
            $smarty->assign("captcha", "<span id='inputcaptcha_blog'><img src='data:image/jpg;base64," . $NewsletterCaptcha . "' alt='verification image, type it in the box' align='absbottom' /></span>\n            <input type='text' name='captcha'>");
        }
        if ($action == "postcomment") {
            if (empty($name) || empty($email) || !validEmail($email) || empty($message) || !$_SESSION["uid"] && md5($captcha) != $_SESSION["varify"]) {
                if (empty($name)) {
                    $missing["name"] = "true";
                }
                if (empty($email) || !validEmail($email)) {
                    $missing["email"] = "true";
                }
                if (empty($message)) {
                    $missing["message"] = "true";
                }
                if (!$_SESSION["uid"] && md5($captcha) != $_SESSION["varify"]) {
                    $missing["captcha"] = "true";
                }
                $smarty->assign("missing", $missing);
                $commenter["name"] = $name;
                $commenter["email"] = $email;
                $commenter["url"] = $url;
                $commenter["message"] = $message;
                $smarty->assign("commenter", $commenter);
            } else {
                if ($blog["approvecomments"] == "notloggedin" && $_SESSION["uid"] || $blog["approvecomments"] == "never") {
                    $smarty->assign("status", "approved");
                    $commentstatus = "approved";
                } else {
                    $smarty->assign("status", "pending");
                    $commentstatus = "pending";
                }
                dquery("INSERT INTO tbl_blogcomments \n                (post, author, email, authorurl, comment, date, status, ip, client) \n                VALUES('" . $posts["id"] . "', '" . $name . "', '" . descape($email) . "', '" . descape($url) . "', '" . descape($message) . "', '" . descape(date("Y-m-d h:i:s")) . "', '" . $commentstatus . "', '" . $_SERVER["REMOTE_ADDR"] . "', '" . $_SESSION["uid"] . "' ) ");
                exit(mysqli_error());
            }
        }
        $commentsquery = "SELECT * FROM tbl_blogcomments WHERE post='" . $posts["id"] . "' AND status='approved' ORDER BY date";
        $commentsresult = dquery($commentsquery);
        for ($i = 0; $comments = mysqli_fetch_assoc($commentsresult); $i++) {
            $comment[$i]["id"] = $comments["id"];
            $comment[$i]["author"] = $comments["author"];
            $comment[$i]["url"] = $comments["authorurl"];
            $comment[$i]["email"] = $comments["email"];
            $comment[$i]["content"] = html_entity_decode($comments["comment"]);
            $comment[$i]["date"] = $comments["date"];
        }
        $num_comments = mysqli_num_rows($commentsresult);
        $smarty->assign("totalcomments", $num_comments);
        $smarty->assign("comments", $comment);
    }
    if (isset($seofriendly)) {
        $smarty->assign("seofriendly", "true");
    }
    if ($blog["bookmarks"]) {
        $smarty->assign("bookmarks", "true");
    }
    $sidecatquery = "SELECT * FROM tbl_blogcats ORDER BY sort ASC";
    for ($sidecatresult = dquery($sidecatquery); $sidecategoryrow = mysqli_fetch_assoc($sidecatresult); $i++) {
        $sidecategory[$i]["id"] = $sidecategoryrow["id"];
        $sidecategory[$i]["name"] = $sidecategoryrow["name"];
        $sidecategory[$i]["seo"] = _url("blog/category/" . $sidecategoryrow["id"] . "/" . preg_replace("/[^a-zA-Z0-9_]/", "-", $sidecategoryrow["name"]));
    }
    $smarty->assign("sidecategories", $sidecategory);
    $smarty->assign("postid", true);
} else {
    if ($permalink) {
        $templatefile = "blog-page";
        if (!$config["blog"]) {
            $tempalte_ver["notification"]["error"] = $lng_languag["pagedisabled"];
            DisplayOutput("notallow");
            exit;
        }
        $permalink = descape($permalink);
        $pagequery = "SELECT * FROM tbl_blogposts WHERE permalink='" . $permalink . "' AND status != 'draft' AND type='page'";
        $pageresult = dquery($pagequery);
        $pages = mysqli_fetch_assoc($pageresult);
        $pagetitle = $pages["title"];
        $pageicon = "images/support/blog.gif";
        $_nav = "<a href=\"index.php\">" . $lng_languag["globalsystemname"] . "</a>";
        $_nav .= " > " . $pages["title"];
        $page["id"] = $pages["id"];
        $page["title"] = $pages["title"];
        $page["content"] = html_entity_decode($pages["post"]);
        $page["date"] = $pages["date"];
        $page["url"] = _url($pages["title"]);
        if ($pages["comments"] == "on" && !in_array($_SERVER["REMOTE_ADDR"], explode(",", $blog["blockedips"]))) {
            $smarty->assign("allowcomments", "true");
        }
        $smarty->assign("page", $page);
        if ($pages["comments"] == "on") {
            if ($blog["captcha"] == "on" || $blog["captcha"] == "offloggedin" && !$_SESSION["uid"]) {
                $smarty->assign("captcha", "true");
                $captcha = "on";
            }
            if ($action == "postcomment") {
                if (empty($name) || empty($email) || !validEmail($email) || empty($message) || !$_SESSION["uid"] && md5($captcha) != $_SESSION["varify"]) {
                    if (empty($name)) {
                        $missing["name"] = "true";
                    }
                    if (empty($email) || !validEmail($email)) {
                        $missing["email"] = "true";
                    }
                    if (empty($message)) {
                        $missing["message"] = "true";
                    }
                    if (md5($code) != $_SESSION["image_random_value"]) {
                        $missing["captcha"] = "true";
                    }
                    $smarty->assign("missing", $missing);
                    $commenter["name"] = $name;
                    $commenter["email"] = $email;
                    $commenter["url"] = $url;
                    $commenter["message"] = $message;
                    $smarty->assign("commenter", $commenter);
                } else {
                    if ($blog["approvecomments"] == "notloggedin" && $_SESSION["uid"] || $blog["approvecomments"] == "never") {
                        $smarty->assign("status", "approved");
                        $commentstatus = "approved";
                    } else {
                        $smarty->assign("status", "pending");
                        $commentstatus = "pending";
                    }
                    dquery("INSERT INTO tbl_blogcomments \n(post, author, email, authorurl, comment, date, status, ip, client) \nVALUES('" . $pages["id"] . "', '" . $name . "', '" . descape($email) . "', '" . descape($_POST["url"]) . "', '" . descape($_POST["message"]) . "', '" . descape(date("Y-m-d h:i:s")) . "', '" . $commentstatus . "', '" . $_SERVER["REMOTE_ADDR"] . "', '" . $_SESSION["uid"] . "' ) ");
                    exit(mysqli_error());
                }
            }
            $commentsquery = "SELECT * FROM tbl_blogcomments WHERE post='" . $pages["id"] . "' AND status='approved' ORDER BY date";
            for ($commentsresult = dquery($commentsquery); $comments = mysqli_fetch_assoc($commentsresult); $i++) {
                $comment[$i]["id"] = $comments["id"];
                $comment[$i]["author"] = $comments["author"];
                $comment[$i]["url"] = $comments["authorurl"];
                $comment[$i]["content"] = html_entity_decode($comments["comment"]);
                $comment[$i]["date"] = $comments["date"];
            }
            $smarty->assign("comments", $comment);
        }
        if (isset($seofriendly)) {
            $smarty->assign("seofriendly", "true");
        }
        if ($blog["bookmarks"]) {
            $smarty->assign("bookmarks", "true");
        }
    } else {
        $templatefile = "blog";
        if (!$config["blog"]) {
            $tempalte_ver["notification"]["error"] = $lng_languag["pagedisabled"];
            DisplayOutput("notallow");
            exit;
        }
        if ($category) {
            $cat = "AND ( cat LIKE '" . $category . "' OR cat LIKE '" . $category . ",%' OR cat LIKE '%," . $category . ",%' OR cat LIKE '%," . $category . "' )";
        } else {
            $cat = "";
        }
        if (!$page) {
            $page = "1";
        }
        $date = date("Y-m-d");
        $cat .= " and (startdate='' or startdate<='" . $date . "')\n    and (enddate='' or enddate>'" . $date . "')";
        $offset = ($page - 1) * $config["BlogPostsperpage"];
        $allpostsquery = "SELECT * FROM tbl_blogposts WHERE status='published' AND type='post' " . $cat . "\n     ORDER BY date DESC";
        $allpostsresult = dquery($allpostsquery);
        $countallposts = mysqli_num_rows($allpostsresult);
        $pages = $countallposts / $config["BlogPostsperpage"];
        $smarty->assign("next", $page + 1);
        $smarty->assign("prev", $page - 1);
        if (1 < $page) {
            $smarty->assign("newer", "true");
        }
        if ($page != ceil($pages)) {
            $smarty->assign("older", "true");
        }
        $postsquery = "SELECT * FROM tbl_blogposts WHERE status='published' AND type='post' " . $cat . " \n    ORDER BY date DESC LIMIT " . $offset . "," . $config["BlogPostsperpage"];
        $postsresult = dquery($postsquery);
        $i = 0;
        for ($post = []; $posts = mysqli_fetch_assoc($postsresult); $i++) {
            $catquery = "SELECT * FROM tbl_blogcats WHERE id='" . $posts["cat"] . "'";
            $catresult = dquery($catquery);
            $category = mysqli_fetch_assoc($catresult);
            $post[$i]["id"] = $posts["id"];
            $post[$i]["category"] = $category["name"];
            $post[$i]["catid"] = $posts["cat"];
            $post[$i]["author"] = $posts["author"];
            $post[$i]["title"] = $posts["title"];
            if ($blog["teaser"] == "on") {
                $post[$i]["content"] = html_entity_decode($posts["teaser"]);
            } else {
                $post[$i]["content"] = html_entity_decode($posts["post"]);
            }
            $post[$i]["date"] = $posts["date"];
            $commentsquery = "SELECT * FROM tbl_blogcomments WHERE post='" . $posts["id"] . "' AND status='approved' ORDER BY date";
            $commentsresult = dquery($commentsquery);
            $post[$i]["comments"] = mysqli_num_rows($commentsresult);
            $post[$i]["seocat"] = _url("blog/category/" . $posts["cat"] . "/" . preg_replace("/[^a-zA-Z0-9_]/", "-", $category["name"]));
            $post[$i]["seourl"] = _url("blog/post/" . $posts["id"] . "/" . preg_replace("/[^a-zA-Z0-9_]/", "-", $posts["title"]));
        }
        $smarty->assign("posts", $post);
        if (isset($seofriendly)) {
            $smarty->assign("seofriendly", "true");
        }
        if ($blog["showrss"] == "on") {
            $smarty->assign("showrss", "true");
        }
        $sidecatquery = "SELECT * FROM tbl_blogcats ORDER BY sort ASC";
        for ($sidecatresult = dquery($sidecatquery); $sidecategoryrow = mysqli_fetch_assoc($sidecatresult); $i++) {
            $sidecategory[$i]["id"] = $sidecategoryrow["id"];
            $sidecategory[$i]["name"] = $sidecategoryrow["name"];
            $sidecategory[$i]["seo"] = _url("blog/category/" . $sidecategoryrow["id"] . "/" . preg_replace("/[^a-zA-Z0-9_]/", "-", $sidecategoryrow["name"]));
        }
        $smarty->assign("sidecategories", $sidecategory);
        $smarty->assign("blog", true);
    }
}
$allpagesquery = "SELECT * FROM tbl_blogposts WHERE status='published' AND type='page' " . $cat . " ORDER BY sort";
for ($allpagesresult = dquery($allpagesquery); $allpagesrow = mysqli_fetch_assoc($allpagesresult); $i++) {
    $allpages[$i]["id"] = $allpagesrow["id"];
    $allpages[$i]["title"] = $allpagesrow["title"];
    $allpages[$i]["url"] = $allpagesrow["permalink"];
    if (!empty($allpagesrow["icon"])) {
        $allpages[$i]["icon"] = $allpagesrow["icon"];
    }
}
$smarty->assign("allpages", $allpages);
chkMd5sumsubpage();
DisplayOutput($templatefile);
class no
{
}

?>