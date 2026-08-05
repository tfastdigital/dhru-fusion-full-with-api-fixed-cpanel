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
if ($department && $email) {
    checkDemoMode(false);
    $sql = dquery("select email from tbl_support_department where email='" . $email . "' AND email!='" . $emailav . "'");
    if (!mysqli_num_rows($sql)) {
        $data["department"] = $department;
        $data["email"] = $email;
        $data["login"] = $login;
        $data["status"] = $status;
        $data["info"] = $info;
        $data["livehelp"] = $help;
        $data["pophost"] = $pophost;
        $data["popport"] = $popport;
        $data["popuser"] = $popuser;
        $data["poppass"] = $poppass;
        $data["iconlink"] = $iconlink;
        if ($db->update("tbl_support_department", $data, "id='" . $id . "'")) {
            echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
        } else {
            echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
        }
    } else {
        echo "<div id=notification1 class=errorbox>" . $LNG["email"] . " " . $LNG["already"] . " " . $LNG["exists"] . "</div>";
    }
}
$cntr = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_support_department \nWHERE id='" . $id . "'"));
echo "<script language=\"JavaScript\">\nfunction newWindow(file,window)\n{\n    msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n    if (msgWindow.opener == null) msgWindow.opener = self;\n} \n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"emailav\" value=\"";
echo $cntr["email"];
echo "\" />\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["department"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"department\"\n    value=\"";
echo $cntr["department"];
echo "\" /></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["email"];
echo "  </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"email\"\n    value=\"";
echo $cntr["email"];
echo "\" />  </td>\n</tr>\n<tr>\n<td class=\"fieldlabel\" >";
echo $LNG["iconlink"];
echo "</td>\n<td class=\"fieldarea\"> <input type=\"text\" class=\"txt large\" name=\"iconlink\" id=\"iconlink\" \nvalue=\"";
echo $cntr["iconlink"];
echo "\" /> <input type=\"button\" class=\"addFromgallery\" value=\"";
echo $LNG["addgallery"];
echo "\" name=\"upload\" onClick=\"newWindow('includes/gallery.php?id=iconlink', 'windowname1')\" />\n </td>\n</tr>    \n\n<tr> \n    <td class=\"fieldlabel\">";
echo $LNG["description"];
echo "  </td>\n    <td class=\"fieldarea\"><textarea name=\"info\">";
echo $cntr["info"];
echo "</textarea> </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">  </td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" name=\"help\" ";
if ($cntr["livehelp"]) {
    echo "checked";
}
echo "  value=\"1\" id=\"eh\" /> <label for=\"eh\">";
echo $LNG["livehelp"];
echo " </label> </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">  </td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" name=\"login\" value=\"1\" ";
if ($cntr["login"]) {
    echo "checked";
}
echo " id=\"el\" /> <label for=\"el\">";
echo $LNG["onlyregistred"];
echo "</label> </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">  </td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" name=\"status\" value=\"1\" ";
if ($cntr["status"]) {
    echo "checked";
}
echo " id=\"es\"  /><label for=\"es\">";
echo $LNG["show"];
echo " ";
echo $LNG["department"];
echo "</label> </td>\n</tr>\n \n</tbody>\n</table>\n<br />\n\n<h4 class=\"groupstabesheadertext\">";
echo $LNG["import"] . " " . $LNG["settings"];
echo "</h4>\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["pop"];
echo " ";
echo $LNG["host"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"pophost\" \n    value=\"";
echo $cntr["pophost"];
echo "\" />  </td>\n</tr>\n<tr> \n    <td class=\"fieldlabel\">";
echo $LNG["pop"];
echo " ";
echo $LNG["port"];
echo "  </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"popport\" \n    value=\"";
echo $cntr["popport"];
echo "\" /></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["pop"];
echo " ";
echo $LNG["username"];
echo "</td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"popuser\" \n    value=\"";
echo $cntr["popuser"];
echo "\" /></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["pop"];
echo " ";
echo $LNG["password"];
echo "  </td>\n    <td class=\"fieldarea\"><input type=\"password\" name=\"poppass\" \n    value=\"";
echo $cntr["poppass"];
echo "\" /></td>\n</tr>\n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"submit\" />\n</div>\n\n</form>\n\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>