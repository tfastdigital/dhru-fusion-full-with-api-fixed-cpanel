<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
licince\chklite();
$pageid = 328;
checkPagePermission($pageid);
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
if ($btnsend) {
    include_once ROOTDIR . "/includes/mail.fun.php";
    $result = dquery("select * from tbl_license where id=1");
    $row = mysqli_fetch_assoc($result);
    $adminmessage = "Name: " . $name . " <br />\n Email: " . $email . " <br />\n Username : " . $username . " <br />\n Password : " . $password . " <br />\n System url : <a href='" . $config["site_address"] . "/" . $admindirpath . "'>" . $config["site_address"] . $config["admin_directory"] . "</a> <br />\n License Key :" . dec($row["license_key"]) . "<br />\n==========================<br />\n                   " . strip_tags($message);
    $send = ["support@dhru.com"];
    if ($name == "" || $email == "" || $message == "") {
        echo "<div id=notification1 class=errorbox>Field is Required</div><br />";
    } else {
        sendNotification("send", $name, $adminmessage, $send, $licinfo["email"]);
        echo "<div id=notification1 class=successbox>Your request has been sent</div><br />";
    }
}
echo "\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"name\" value=\"";
echo $licinfo["registeredname"];
echo "\"/>\n<input type=\"hidden\" name=\"email\" value=\"";
echo $licinfo["email"];
echo "\"/>\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\" >\n          <h2>\n            <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n            <span class=\"groupstabesheadertext\">";
echo $LNG["contact"];
echo " ";
echo $LNG["info"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n          </h2>\n          <div class=\"groupstabescontant\">\n<table border=\"0\"  class=\"form\" cellpadding=\"3\" cellspacing=\"2\">\n<tbody>\n<tr><td class=\"fieldlabel\">";
echo $LNG["name"];
echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"name\" value=\"";
echo $licinfo["registeredname"];
echo "\" disabled=\"\"/></td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["email"];
echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"email\" value=\"";
echo $licinfo["email"];
echo "\" disabled=\"\" /> <small> [Your registered email on dhru.com]</small><small>";
echo $LNG["makesure"];
echo "</small></td></tr>\n</tbody></table>\n</div></div>\n\n<div  class=\"groupstabes\" >\n          <h2>\n            <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n            <span class=\"groupstabesheadertext\">";
echo $LNG["admin"];
echo " ";
echo $LNG["login"];
echo " (";
echo $LNG["optional"];
echo ")</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n          </h2>\n          <div class=\"groupstabescontant\">\n<table border=\"0\" cellpadding=\"3\" cellspacing=\"2\"  class=\"form\" >\n<tbody>\n<tr><td class=\"fieldlabel\">";
echo $LNG["username"];
echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"username\" value=\"\"/></td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["password"];
echo "</td><td class=\"fieldarea\"><input type=\"password\" name=\"password\" value=\"\"/><br /><small>";
echo $LNG["thefollowing"];
echo "</small></td></tr>\n</tbody></table>\n</div></div>\n\n<div  class=\"groupstabes\" >\n          <h2>\n            <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n            <span class=\"groupstabesheadertext\">";
echo $LNG["your"];
echo " ";
echo $LNG["query"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n          </h2>\n          <div class=\"groupstabescontant\">\n<table border=\"0\" cellpadding=\"3\" cellspacing=\"2\"  class=\"form\" >\n<tbody>\n<tr><td class=\"fieldlabel\">";
echo $LNG["subject"];
echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"subject\" value=\"\"/></td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["message"];
echo "</td><td class=\"fieldarea\"><textarea name=\"message\" style=\"width: 90%;\" rows=\"10\"></textarea></td></tr>\n<tr><td></td><td class=\"fieldarea\"><input value=\"";
echo $LNG["send"];
echo "\" id=\"btnoverview\" name=\"btnsend\" class=\"btn save\" type=\"submit\"/> </td></tr>\n</tbody></table>\n</div></div>\n\n</form>\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>