<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
$id = $_GET["id"];
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../templates/defaultweb2/css/";
echo $id;
echo ".css\" />\n<body class=\"body\" style=\"background: none;\">\n<form method=\"post\" name=\"frmaddadmin\" id=\"frmaddadmin\">\n<div class=\"bodyBackground\">\n<div class=\"topNavigation\">\n    <div class=\"logo\"> <span style=\"color:#00aff0; font-size:24px; font-weight:bold; margin-left:10px;\">Fus!on</span> </div>\n\n    <div class=\"quicklink\">\n            <li style=\"list-style:none !important;\"><a href=\"#\" title=\"Login\">Login</a></li>\n         <li><a href=\"#\" title=\"Register\">Register</a></li>\n        <li><a href=\"#\">Contact</a> </li>\n        <li><a href=\"#\">Blog</a> </li>\n        <li><a href=\"#\">Knowledgebase</a> </li>\n\n    </div>\n\n</div>\n\n\n\n\n<div class=\"menuNavigation\">\n    <div class=\"menu\">\n          <ul>\n        <li  class=\"current\"><a href=\"#\"><img alt=\"\" src=\"../templates/defaultweb2/images/home_icon.png\"/><span>Home</span></a> </li>\n        <li  ><a href=\"#\"><img alt=\"\" src=\"../templates/defaultweb2/images/place_new_order.png\"/><span>Products & Services</span></a> </li>\n     </ul>\n\n\n    </div>\n\n    <div class=\"information\">\n<span  class=\"bold red\"  style=\"text-decoration: blink;\" > </span>&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"+Add Fund\" id=\"buynow\" />    </div>\n</div>\n\n<div class=\"mainDiv\">\n\n\n\n    <div class=\"container\">\n\t<div id=\"content_left\">\n    <div class=\"title_text\"><div class=\"breadcrumb\">You are here : <a href=\"#\">Home</a> / <a href=\"#\">Login</a></div>\n\n  <h1>Login</h1></div>\n    <div class=\"title_image\">\n\n    </div>\n    <div class=\"seperator\"></div>\n\n\n\n    <div id=\"tabcontent0\">\n\n\n  <div id=\"formstyle_1\">\n\n\n<fieldset>\n\n<legend>Login</legend>\nYou must login to access this page. These login details differ from your websites control panel username and password.\n<hr />\n<small class=\"required\">* indicate required field</small>\n <p><label>Username</label><span><input type=\"text\"  name=\"username\" size=\"40\" value=\"\" class=\"required\" /> <em>*</em></span></p>\n          <p><label>Password</label><span><input type=\"password\" name=\"password\" size=\"25\" value=\"\" /> <em>*</em> </span></p>\n          <p><label><input type=\"checkbox\" id=\"rememberme\" name=\"rememberme\" /></label><span><label for=\"rememberme\">Remember Me</label></span></p>\n\n\n         <p class=\"btn\"><label></label><span>\n            <input type=\"button\" id=\"loginbut\"  value=\"Login\" />\n          </span></p>\n\n\n<p class=\"btn\"><label></label><span><strong>Forgotten Your Password?</strong> <a href=\"#\">Request a Password Reset</a></span></p>\n</fieldset>\n\n </div>\n</div>\n\n</div>\n\n<div id=\"right_menu\">\n<p class=\"header\"> Quick SignUp Using </p>\n<ul>\n\n        <li><a href=\"#\">Contact Us</a></li>\n        <li><a href=\"#\">About Us</a></li>\n\n</ul>\n</div></div>\n</div>\n\n\n</div>\n</body>";
$fileverioncheck = "6.1.0";

?>