<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n    .form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 201;
checkPagePermission($pageid);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
echo "<script>\n    function ShowContact(val){\n        if(val==1){\n            \$(\".contactsupport\").show();\n            \$(\".contactemail\").hide();\n        }else{\n            \$(\".contactsupport\").hide();\n            \$(\".contactemail\").show();\n        }\n    }\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n    <div id=\"content_padded\">\n        <form id=\"frm\" name=\"\" method=\"post\">\n            ";
echo generate_token("form");
echo "\n            <div  class=\"groupstabes first\" >\n                <h2>\n                    <span class=\"groupstabesheadertext\">";
echo $LNG["contactus"];
echo " ";
echo $LNG["settings"];
echo "</span>\n                </h2>\n                <div class=\"groupstabescontant\">\n\n\n                    <table  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\" class=\"form\">\n                        <tbody>\n                        <tr>\n                            <td class=\"fieldlabel\">";
echo $LNG["contactus"];
echo " ";
echo $LNG["enable"];
echo " </td>\n                            <td class=\"fieldarea\">\n                                <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"contactus\" value=\"1\" id=\"cone\" ";
if ($config["contactus"]) {
    echo "checked";
}
echo "   /><label for=\"cone\"></label>\n                                <small><a class=\"\" href=\"javascript:load_subpage('main2.php?page=contactuscustom', 'ContactUs Custom Field');\">Click here </a> to Manage ";
echo $LNG["customfields"];
echo " for contact us </small>\n                            </td>\n                        </tr>\n\n\n                        <tr class=\"\">\n                            <td class=\"fieldlabel\">";
echo $LNG["contactus"];
echo " ";
echo $LNG["with"];
echo " </td>\n                            <td class=\"fieldarea\">\n                            <lable><input type=\"radio\" onclick=\"ShowContact(this.value);\" ";
if (!$config["contactby"]) {
    echo "checked='checked'";
}
echo " name=\"contactby\" value=\"0\" />Email</lable>\n                                &nbsp;&nbsp;&nbsp;\n                            <lable><input type=\"radio\" onclick=\"ShowContact(this.value);\" ";
if ($config["contactby"]) {
    echo "checked='checked'";
}
echo "  name=\"contactby\" value=\"1\" />Support Ticket</lable>\n                            </td>\n                        </tr>\n                        <tr ";
if ($config["contactby"]) {
    echo "style='display:none'";
}
echo " class=\"contactemail\">\n                            <td class=\"fieldlabel\"> </td>\n                            <td class=\"fieldarea\">\n                                <input type=\"text\" class=\"txt medium\" name=\"contactus_mail\" value=\"";
echo $config["contactus_mail"];
echo "\" />\n\n\n                            </td>\n                        </tr>\n                        <tr ";
if (!$config["contactby"]) {
    echo "style='display:none'";
}
echo " class=\"contactsupport\" >\n                            <td class=\"fieldlabel\"> </td>\n                            <td class=\"fieldarea\">\n                            <select name=\"support_email\">\n                                <option value=\"\">- ";
echo $LNG["select_"];
echo " ";
echo $LNG["support"];
echo " ";
echo $LNG["department"];
echo " -</option>\n                                ";
$sql = dquery("select * from tbl_support_department WHERE login='0'");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                                    <option value=\"";
    echo $row["id"];
    echo "\" ";
    if ($config["support_email"] == $row["id"]) {
        echo "selected";
    }
    echo ">";
    echo $row["department"];
    echo "</option>\n                                    ";
}
echo "\n                            </select> &nbsp; <a href=\"#\" data-target=\"support.settings\" data-target-header=\"";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["department"];
echo "\" onclick=\"AddnewInpopup(this);\">";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["department"];
echo "</a>\n                            </td>\n                        </tr>\n                        <tr>\n                            <td class=\"fieldlabel\">";
echo $LNG["display"];
echo " ";
echo $LNG["contactus"];
echo " ";
echo $LNG["email"];
echo "</td>\n                            <td class=\"fieldarea\">\n                                <input type=\"text\" class=\"txt medium\" name=\"contactusdisplayemail\" value=\"";
echo $config["contactusdisplayemail"];
echo "\" />\n                            </td>\n                        </tr>\n\n                        <tr>\n                            <td class=\"fieldlabel\">";
echo $LNG["display"];
echo " ";
echo $LNG["contactus"];
echo " ";
echo $LNG["phone"];
echo "</td>\n                            <td class=\"fieldarea\">\n                                <input type=\"text\" class=\"txt medium\" name=\"contactusphone\" value=\"";
echo $config["contactusphone"];
echo "\" />\n                            </td>\n                        </tr>\n\n\n                        <tr>\n                            <td class=\"fieldlabel\">";
echo $LNG["contactus"];
echo "  ";
echo $LNG["address"];
echo "</td>\n                            <td class=\"fieldarea\">\n    <textarea name=\"contactusaddress\" class=\"textarea large\"\n              style=\"height: 100px;\">";
echo $config["contactusaddress"];
echo "</textarea></td>\n                        </tr>\n\n                        <tr>\n                            <td class=\"fieldlabel\">";
echo $LNG["location"];
echo " ";
echo $LNG["latitude"];
echo "</td>\n                            <td class=\"fieldarea\">\n                                <input type=\"text\" class=\"txt medium\" name=\"locationlatitude\" value=\"";
echo $config["locationlatitude"];
echo "\" />\n                            </td>\n                        </tr>\n\n                        <tr>\n                            <td class=\"fieldlabel\">";
echo $LNG["location"];
echo " ";
echo $LNG["longitude"];
echo "</td>\n                            <td class=\"fieldarea\">\n                                <input type=\"text\" class=\"txt medium\" name=\"locationlongitude\" value=\"";
echo $config["locationlongitude"];
echo "\" />\n                            </td>\n                        </tr>\n\n\n                        </tbody>\n                    </table>\n                    <p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\"\n                                                              id=\"btnaddgroup\" class=\"btn\" type=\"button\"\nonclick=\"SubmitForm ('#btnaddgroup','contactussetting','#frm','#notification','true','#main_loader');\"/>\n\n                    </p>\n\n\n                </div>\n            </div>\n\n        </form>";
$fileverioncheck = "6.1.0";

?>