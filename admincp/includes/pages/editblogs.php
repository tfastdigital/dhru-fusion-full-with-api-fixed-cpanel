<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n<script>\nfunction loopSelected()\n{\n  var txtSelectedValuesObj = document.getElementById('selcategory');\n  var selectedArray = new Array();\n  var selObj = document.getElementById('category');\n  var i;\n  var count = 0;\n  for (i=0; i<selObj.options.length; i++) {\n    if (selObj.options[i].selected) {\n      selectedArray[count] = selObj.options[i].value;\n      count++;\n    }\n  }\n  txtSelectedValuesObj.value = selectedArray;\n}\nfunction showBlog(ob){\n\n    if(ob.value==0){\n        \$(\"#startdate\").hide();\n        \$(\"#enddate\").hide();\n        \$(\"#daterange\").hide();\n    }\n\n    if(ob.value==2){\n        \$(\"#startdate\").show();\n        \$(\"#enddate\").hide();\n        \$(\"#daterange\").hide();\n    }\n\n    if(ob.value==3){\n        \$(\"#startdate\").hide();\n        \$(\"#enddate\").show();\n        \$(\"#daterange\").hide();\n    }\n\n    if(ob.value==4){\n        \$(\"#startdate\").hide();\n        \$(\"#enddate\").hide();\n        \$(\"#daterange\").show();\n    }\n}\n</script>\n";
$pageid = 187;
checkPagePermission($pageid);
require_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once "includes/3rdparty/editor/editor.php";
if ($title && $post && $selcategory) {
    checkDemoMode(false);
    $data["title"] = $title;
    $data["post"] = html_entity_decode($post);
    $data["date"] = $date;
    $data["status"] = $status;
    $data["comments"] = $comments;
    $data["cat"] = $selcategory;
    $data["showblog"] = $showblog;
    $data["startdate"] = $startdate ? $startdate : $startdat;
    $data["enddate"] = $enddate ? $enddate : $enddat;
    if ($db->update("tbl_blogposts", $data, "id=" . $id)) {
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
$blog = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_blogposts` WHERE `id`='" . $id . "'"));
echo "\n<script>\nfunction showpage(val)\n{\n    if(val=='page')\n    {\n        document.getElementById('pagelink').style.display='';\n    }else{\n        document.getElementById('pagelink').style.display='none';\n    }\n}\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["author"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    ";
echo $_SESSION["adminname"];
echo "    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["title"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt medium\" name=\"title\" value=\"";
echo $blog["title"];
echo "\" />\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["category"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <select name=\"category\"  id=\"category\"  multiple  onchange=\"loopSelected();\" onblur=\"loopSelected();\" style=\"width: 150px;height:200px\">\n    ";
$sql = dquery("select id,name from tbl_blogcats");
while ($row = mysqli_fetch_assoc($sql)) {
    $selected = "";
    $b = explode(",", $blog["cat"]);
    foreach ($b as $bl) {
        if ($bl == $row["id"]) {
            $selected = "selected=\"selected\"";
        }
    }
    echo "<option value=\"";
    echo $row["id"];
    echo "\" ";
    echo $selected;
    echo "  >";
    echo $row["name"];
    echo "</option> ";
}
echo "</select> &nbsp; <a href=\"#\" data-target=\"blogcategorylist\" data-target-header=\"";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["category"];
echo "\" onclick=\"AddnewInpopup(this);\">";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["category"];
echo "</a>\n     <input type=\"hidden\" id=\"selcategory\" name=\"selcategory\" value=\"";
echo $blog["cat"];
echo "\" />\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["post"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n   <textarea name=\"post\" id=\"message\">";
echo $blog["post"];
echo "</textarea>\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["date"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt medium datepicker\"  autocomplete=\"off\" name=\"date\" id=\"to\" value=\"";
echo $blog["date"];
echo "\" />\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"radio\" value=\"published\" name=\"status\" id=\"publ\" ";
if ($blog["status"] == "published") {
    echo "checked";
}
echo " /><label for=\"publ\">Published</label>\n    <input type=\"radio\" value=\"unpublished\" name=\"status\" id=\"unpubl\" ";
if ($blog["status"] == "unpublished") {
    echo "checked";
}
echo " /><label for=\"unpubl\">Unpublished</label>\n    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n  <input type=\"checkbox\" name=\"comments\" ";
if ($blog["comments"] == "on") {
    echo "checked";
}
echo " id=\"comm\" /> <label for=\"comm\">";
echo $LNG["comments"];
echo "</label> &nbsp;&nbsp;&nbsp;\n  ";
if ($config["consumer_key"] && $config["consumer_secret"] && $config["access_token"] && $config["token_secret"]) {
    echo "  <input type=\"checkbox\" name=\"autopost\" checked=\"checked\" id=\"auto\" />   <label for=\"auto\">";
    echo $LNG["autoupdate"];
    echo " ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["twitter"];
    echo "</label>&nbsp;&nbsp;&nbsp;\n    ";
} else {
    echo "  <input type=\"checkbox\" name=\"autopost\" disabled=\"disabled\"  id=\"auto\" /> <label for=\"auto\">";
    echo $LNG["autoupdate"];
    echo " ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["twitter"];
    echo "</label> &nbsp;&nbsp;&nbsp;\n\n      <small>To enable setup : Settings ->Others->Twitter Application Access</small>\n      ";
}
echo "\n    ";
if ($config["appid"] && $config["app_secret"]) {
    echo "    <input type=\"checkbox\" name=\"facebook\"  id=\"autof\" /> <label for=\"autof\">";
    echo $LNG["autopost"];
    echo " ";
    echo $LNG["to"];
    echo " Facebook</label>\n    ";
}
echo "  </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["display"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n<input type=\"radio\" value=\"0\" onclick=\"showBlog(this);\" name=\"showblog\" id=\"sa\" ";
if ($blog["showblog"] == 0) {
    echo "checked";
}
echo " /><label for=\"sa\">All time</label>\n<input type=\"radio\" value=\"2\" onclick=\"showBlog(this);\" name=\"showblog\" id=\"st\" ";
if ($blog["showblog"] == 2) {
    echo "checked";
}
echo " /><label for=\"st\">From Start Date</label>\n<input type=\"radio\" value=\"3\" onclick=\"showBlog(this);\" name=\"showblog\" id=\"se\" ";
if ($blog["showblog"] == 3) {
    echo "checked";
}
echo " /><label for=\"se\">End on Date</label>\n<input type=\"radio\" value=\"4\" onclick=\"showBlog(this);\" name=\"showblog\" id=\"sr\" ";
if ($blog["showblog"] == 4) {
    echo "checked";
}
echo " /><label for=\"sr\">Date Range</label>\n    </span></td>\n</tr>\n\n\n<tr id=\"startdate\" style=\"";
if ($blog["showblog"] != 2) {
    echo "display:none";
}
echo "\">\n    <td class=\"fieldlabel\">";
echo $LNG["start"];
echo " ";
echo $LNG["date"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt datepicker\"  autocomplete=\"off\" name=\"startdate\" id=\"start\" value=\"";
echo $blog["startdate"];
echo "\" />\n    </span></td>\n</tr>\n\n\n<tr id=\"enddate\" style=\"";
if ($blog["showblog"] != 3) {
    echo "display:none";
}
echo "\">\n    <td class=\"fieldlabel\">";
echo $LNG["end"];
echo " ";
echo $LNG["date"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt datepicker\"  autocomplete=\"off\" name=\"enddate\" id=\"end\" value=\"";
echo $blog["enddate"];
echo "\" />\n    </span></td>\n</tr>\n\n<tr id=\"daterange\" style=\"";
if ($blog["showblog"] != 4) {
    echo "display:none";
}
echo "\">\n    <td class=\"fieldlabel\">";
echo $LNG["date"];
echo " range</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt datepicker\"  autocomplete=\"off\" name=\"startdat\" id=\"starts\" value=\"";
echo $blog["startdate"];
echo "\" />\n    to\n    <input type=\"text\"  class=\"txt datepicker\"   autocomplete=\"off\" name=\"enddat\" id=\"ends\" value=\"";
echo $blog["enddate"];
echo "\" />\n    </span></td>\n</tr>\n\n\n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input name=\"save\" value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn save\" type=\"submit\"  />\n</div>\n\n</form>\n\n<table id=\"main_tbl\" style=\"display: ";
echo $display;
echo ";\">\n            <thead>\n              <tr>\n                <th>";
echo $LNG["author"];
echo "</th>\n                <th>";
echo $LNG["email"];
echo "</th>\n                <th>";
echo $LNG["authorurl"];
echo "</th>\n                <th>";
echo $LNG["ip"];
echo "</th>\n                 <th>";
echo $LNG["action"];
echo "</th>\n              </tr>\n            </thead>\n            <tbody>\n\n\n";
if ($approve) {
    $data["status"] = "approved";
    $db->update("tbl_blogcomments", $data, "id=" . $apprid);
}
if ($delete) {
    dquery("DELETE FROM `tbl_blogcomments` WHERE `id`='" . $delid . "'");
}
$comment = dquery("SELECT * FROM `tbl_blogcomments` WHERE `post`='" . $id . "'");
while ($row = mysqli_fetch_assoc($comment)) {
    echo "\n<tr>\n<td>";
    echo $row["author"];
    echo "</td>\n<td>";
    echo $row["email"];
    echo "</td>\n<td>";
    echo $row["authorurl"];
    echo "</td>\n<td><a target='_blank' href=\"";
    echo $config["ip_location"] . $row["ip"];
    echo "\">";
    echo $row["ip"];
    echo "</a></td>\n<td>\n<form method=\"post\" title=\"delete\" style=\"float: right;\"><input type=\"submit\" name=\"delete\" onclick=\"return confirm('Are you sure want to remove Comments ?');\" class=\"button deletedata\" value=\"";
    echo $LNG["delete"];
    echo "\" /><input type=\"hidden\" name=\"delid\" value=\"";
    echo $row["id"];
    echo "\" /> </form>\n<form method=\"post\" title=\"edit\" style=\"float: right;\"><input type=\"button\" class=\"button editdata\" onclick=\"javascript: load_subpage('main2.php?page=editblogauthor&id=";
    echo $row["id"];
    echo "', '";
    echo $LNG["edit"];
    echo " ";
    echo $LNG["blog"];
    echo "');\" value=\"";
    echo $LNG["edit"];
    echo "\" /></form>\n";
    if ($row["status"] == "pending") {
        echo "<form method=\"post\" title=\"approve\" style=\"float: right;\"><input type=\"submit\"  class=\"button approvedata\" name=\"approve\" value=\"";
        echo $LNG["approved"];
        echo "\" /><input type=\"hidden\" name=\"apprid\" value=\"";
        echo $row["id"];
        echo "\" /> </form>\n";
    }
    echo "\n</td>\n</tr>\n";
}
echo "\n</tbody></table>\n<br /><br /><br />\n</div>\n</div><br/>";
$fileverioncheck = "6.1.0";

?>