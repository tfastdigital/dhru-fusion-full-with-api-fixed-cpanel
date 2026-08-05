<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
echo "<div id=\"tabcontent\">\n";
require_once "includes/3rdparty/qrcode.php";
require_once "includes/3rdparty/googleauth.php";
if ($disabled) {
    dquery("update tbl_admin set google=0 where id='" . $admn . "'");
}
$row = mysqli_fetch_assoc(dquery("select * from tbl_admin\nwhere id='" . $admn . "'"));
if ($row["google"]) {
    echo "<div id=\"content\">\n<div id=\"content_padded\">\n<form method=\"post\" action=\"main2.php?page=editadmin&defaultpage=secondlogin.php\">\n    <input type=\"hidden\" name=\"admn\" value=\"";
    echo $admn;
    echo "\" />\n    <input type=\"submit\" name=\"disabled\" value=\"Disable OTP\"\n    class=\"btn\" />\n</form>\n\n</div>\n</div>\n";
} else {
    echo "\n<div id=\"content\">\n<div id=\"content_padded\">\n<div  class=\"groupstabes\" >\n          <h2>\n            <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n            <span class=\"groupstabesheadertext\">Second Authentication</span>&nbsp;\n          </h2>\n          <div class=\"groupstabescontant\">\n\n          <div id=\"notification\"></div>\n          <form  class=\"form-horizontal\"  id=\"frmsru\" method=\"post\" name=\"rateing\">\n\n<table class=\"form\" >\n    <tbody>\n\n      <tr>\n        <td class=\"fieldlabel\">Step 1 : Install App </td>\n           <td class=\"fieldarea\" >\n\n           <a href=\"https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en\" target=\"_blank\">\n           <img src=\"images/android-icon.png\" border=\"0\" /></a>\n           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n            <a href=\"https://itunes.apple.com/en/app/google-authenticator/id388497605?mt=8\" target=\"_blank\">\n           <img src=\"images/apple-icon.png\" border=\"0\" /></a>\n\n          </td>\n      </tr>\n\n        <tr>\n            <td class=\"fieldlabel\">Step 2 : Add Account </td>\n          <td class=\"fieldarea\" >\n\n          <img class=\"steps\" height=\"250\" src=\"images/auth1.png\" />\n          <img class=\"steps\" height=\"250\" src=\"images/auth2.png\" />\n          <img class=\"steps\" height=\"250\" src=\"images/auth3.png\" />\n\n          </td>\n       </tr>\n\n\n\n\n";
    $qrsize = "3.5";
    if (!isset($_SESSION["secretk"])) {
        $_SESSION["secretk"] = secret_key();
    }
    echo "\n\n<tr>\n    <td class=\"fieldlabel\">\n        Step 3 : Scan QR code and activate account\n\n        <input type=\"hidden\" name=\"admn\" value=\"";
    echo $admn;
    echo "\" />\n    </td>\n    <td class=\"fieldarea\">\n        <img src=\"https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=";
    echo "otpauth://totp/" . $config["site_address"] . "?secret=" . $_SESSION["secretk"];
    echo "&choe=UTF-8\" title=\"Link to Google.com\" />\n   </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">\n       Enter OTP :\n    </td>\n    <td class=\"fieldarea\">\n    <input type=\"text\" name=\"otp\" />\n   </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n    <input type=\"button\"   class=\"btn btn-success\"  id=\"btnlo\"\n    onclick=\"SubmitForm ('#btnlo','secondauth','#frmsru','#notification','true','#main_loader');\"\n    name=\"validateotp\" value=\"Activate Now\" />\n    </td>\n</tr>\n\n\n\n       </tbody>\n  </table></form>\n</div></div>\n</div>\n</div>\n</div>\n";
}
$fileverioncheck = "6.1.0";

?>