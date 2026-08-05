<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($savecomment) {
    checkDemoMode(false);
    $data["author"] = $author;
    $data["email"] = $email;
    $data["authorurl"] = $authorurl;
    $data["comment"] = $comment;
    $data["date"] = $date;
    $data["status"] = $status;
    if ($db->update("tbl_blogcomments", $data, "id=" . $id)) {
        echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
$blog = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_blogcomments` WHERE `id`='" . $id . "'"));
echo "<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n\n<script src=\"http://code.jquery.com/jquery-latest.min.js\"  type=\"text/javascript\"></script> <script src=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/js/x-main2.fun.js\" language=\"javascript\"></script>\n\n\n\n<div id=\"notification\"></div>\n\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["author"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"text\" name=\"author\" value=\"";
echo $blog["author"];
echo "\" />\n    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["email"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"text\" name=\"email\" value=\"";
echo $blog["email"];
echo "\" />\n    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["authorurl"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"text\" name=\"authorurl\" value=\"";
echo $blog["authorurl"];
echo "\" />\n    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["comments"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"text\" name=\"comment\" value=\"";
echo $blog["comment"];
echo "\" />\n    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["date"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"text\" class=\"datepicker\"  autocomplete=\"off\" name=\"date\" id=\"from\" value=\"";
echo $blog["date"];
echo "\" />\n    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea radio\">\n    <input type=\"radio\" name=\"status\" value=\"pending\" ";
if ($blog["status"] == "pending") {
    echo "checked";
}
echo " id=\"pe\"/><label for=\"pe\">";
echo $LNG["pending"];
echo "</label>\n    <input type=\"radio\" name=\"status\" value=\"approved\" ";
if ($blog["status"] == "approved") {
    echo "checked";
}
echo " id=\"ap\"/><label for=\"ap\">";
echo $LNG["approved"];
echo "</label>\n  </td>\n</tr>\n\n</tbody></table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" name=\"savecomment\" class=\"btn save\" type=\"submit\"  />\n</div>\n\n</form></div></div>";
$fileverioncheck = "6.1.0";

?>