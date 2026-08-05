<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n<script>\nfunction loopSelected()\n{\n  var txtSelectedValuesObj = document.getElementById('selcategory');\n  var selectedArray = new Array();\n  var selObj = document.getElementById('category');\n  var i;\n  var count = 0;\n  for (i=0; i<selObj.options.length; i++) {\n    if (selObj.options[i].selected) {\n      selectedArray[count] = selObj.options[i].value;\n      count++;\n    }\n  }\n  txtSelectedValuesObj.value = selectedArray;\n}\n</script>\n";
$pageid = 180;
checkPagePermission($pageid);
require ROOTDIR . "/includes/clients.fun.inc.php";
include "includes/3rdparty/editor/editor.php";
if ($title && $postdata && $selcategory) {
    if ($DEMOMODE) {
        echo "<div id=notification1 class=errorbox>This function not enabled in demo mode .</div>";
        exit;
    }
    $data["author"] = $_SESSION["adminname"];
    $data["title"] = $title;
    $data["post"] = html_entity_decode($postdata);
    $data["date"] = $date;
    $data["status"] = $status;
    $data["comments"] = $comments;
    $data["type"] = "post";
    $data["cat"] = $selcategory;
    if ($id = $db->insert("tbl_blogposts", $data)) {
        if ($autopost) {
            require_once "includes/twitter.fun.php";
            twitter_post($title . " " . $config["site_address"] . "/blog.php?postid=" . $id);
        }
        if ($facebook) {
            $links = base64_encode($config["site_address"] . "/blog.php?postid=" . $id);
            echo "           <script>\nwindow.open('";
            echo $config["site_address"];
            echo $admindirpath;
            echo "/includes/facebook.php?title=";
            echo $title;
            echo "&link=";
            echo $links;
            echo "&comment=";
            echo $comments;
            echo "','mywindow','width=500,height=300');\n           </script>\n            ";
        }
        echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
} else {
    if ($save) {
        echo "<div id=notification1 class=errorbox> " . $LNG["fieldblank"] . " </div>";
    }
}
$index = mysqli_fetch_assoc(dquery("SELECT  `content` FROM `tbl_custom_page` WHERE `type`='index' "));
echo "\n\n<script>\nfunction showpage(val)\n{\n    if(val=='page')\n    {\n        document.getElementById('pagelink').style.display='';\n    }else{\n        document.getElementById('pagelink').style.display='none';\n    }\n}\n</script>\n<div id=\"content\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">New Post</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["author"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    ";
echo $_SESSION["adminname"];
echo "    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["title"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\" name=\"title\" value=\"\" />\n    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["category"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n  <select name=\"category\" id=\"category\"  multiple\n  onchange=\"loopSelected();\" onblur=\"loopSelected();\"\n   style=\"height:200px\">\n    ";
$flag = true;
$selcat = "";
$sql = dquery("select id,name from tbl_blogcats");
while ($row = mysqli_fetch_assoc($sql)) {
    if (!$selcat) {
        $selcat = $row["id"];
    }
    echo "<option value=\"";
    echo $row["id"];
    echo "\" ";
    if ($flag) {
        echo "selected";
    }
    echo " >";
    echo $row["name"];
    echo "</option> ";
    $flag = false;
}
echo "</select> &nbsp;\n     <input type=\"hidden\" id=\"selcategory\" name=\"selcategory\" value=\"";
echo $selcat;
echo "\" />\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["post"];
echo "</td>\n    <td class=\"fieldarea\">\n   <textarea name=\"postdata\"  id=\"message\" ></textarea>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\" width=\"v\">";
echo $LNG["date"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\" name=\"date\" class=\"datepicker\"  placeholder=\"yyyy-mm-dd\" id=\"to\" value=\"";
echo date("Y-m-d h:i:s");
echo "\" />\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"radio\" value=\"published\" checked=\"checked\" name=\"status\"  id=\"publi\" /> <label for=\"publi\">";
echo $LNG["published"];
echo "</label>\n    <input type=\"radio\" value=\"unpublished\" name=\"status\" id=\"unpubli\" /> <label for=\"unpubli\">";
echo $LNG["unpublished"];
echo "</label>\n    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n  <input type=\"checkbox\" name=\"comments\" checked=\"checked\" id=\"comm\" />   <label for=\"comm\">";
echo $LNG["comments"];
echo "</label> &nbsp;&nbsp;&nbsp;\n\n";
if ($config["consumer_key"] && $config["consumer_secret"] && $config["access_token"] && $config["token_secret"]) {
    echo "  <input type=\"checkbox\" name=\"autopost\" checked=\"checked\" id=\"auto\" />   <label for=\"auto\">";
    echo $LNG["autopost"];
    echo " ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["twitter"];
    echo "</label>&nbsp;&nbsp;&nbsp;\n\n";
} else {
    echo "  <input type=\"checkbox\" name=\"autopost\" disabled=\"disabled\"  id=\"auto\" /> <label for=\"auto\">";
    echo $LNG["autopost"];
    echo " ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["twitter"];
    echo "</label>&nbsp;&nbsp;&nbsp;\n  <small>To enable setup : Settings ->Others->Twitter Application Access</small>";
}
echo "\n\n";
if ($config["appid"] && $config["app_secret"]) {
    echo "  <input type=\"checkbox\" name=\"facebook\"  id=\"autof\" /> <label for=\"autof\">";
    echo $LNG["autopost"];
    echo " ";
    echo $LNG["to"];
    echo " Facebook</label> ";
}
echo "  </td>\n\n</tr>\n\n\n</tbody>\n</table>\n</div></div>\n<p align=\"center\" class=\"fixedbtn\">\n<input type=\"hidden\" name=\"pages\" value=\"newblog.php\" />\n<input value=\"";
echo $LNG["add"];
echo "\" id=\"btnpost\" name=\"save\" class=\"btn\" type=\"submit\"  /></p>\n</form>\n\n</div>\n";
$fileverioncheck = "6.1.0";

?>