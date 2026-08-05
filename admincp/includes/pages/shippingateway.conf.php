<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
$pageid = 429;
checkPagePermission($pageid);
echo "<script language=\"JavaScript\">\nfunction newWindow(file,window)\n {msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n    if (msgWindow.opener == null) msgWindow.opener = self;\n }\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<p class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddemailtemplate\" class=\"btn save\" type=\"button\"\n    onclick=\"SubmitForm ('#btnaddemailtemplate','shippingateway.conf','#frmshipping','#notification','true','#main_loader');\"/>\n</p>\n\n";
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
echo "<form method=\"post\" name=\"\" id=\"frmshipping\">\n ";
$req = dquery("SELECT distinct gateway FROM `tbl_shipping_services`");
while ($data = mysqli_fetch_assoc($req)) {
    if ($data["gateway"] == "ups") {
        echo " <div  class=\"groupstabes\" >\n <h2>\n    <span class=\"groupstabesheadertext\">";
        echo $LNG["gateway"];
        echo " : ";
        echo $data["gateway"];
        echo "</span>\n </h2>\n<div class=\"groupstabescontant\">\n\n\n\n    ";
        echo generate_token("form");
        echo "    <table  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\" class=\"form\">\n    <tbody>\n\n    <tr><td  class=\"fieldlabel\">";
        echo $LNG["access"];
        echo "</td><td class=\"fieldarea\">\n    <input type=\"text\"  class=\"txt medium\" name=\"ups_access\"  size=\"100\" value=\"";
        echo $config["ups_access"];
        echo "\" /></td></tr>\n\n    <tr><td class=\"fieldlabel\">";
        echo $LNG["user"];
        echo "</td>\n    <td class=\"fieldarea\"> <input type=\"text\"  class=\"txt medium\"  name=\"ups_user\"  value=\"";
        echo $config["ups_user"];
        echo "\"  size=\"100\"/> </td></tr>\n\n    <tr><td class=\"fieldlabel\">";
        echo $LNG["password"];
        echo "</td>\n    <td class=\"fieldarea\"> <input type=\"text\"  class=\"txt medium\"  name=\"ups_pass\"  value=\"";
        echo $config["ups_pass"];
        echo "\"  size=\"100\"/> </td></tr>\n\n    <tr><td class=\"fieldlabel\">";
        echo $LNG["account"];
        echo "</td>\n    <td class=\"fieldarea\"> <input type=\"text\"  class=\"txt medium\"  name=\"ups_account\"  value=\"";
        echo $config["ups_account"];
        echo "\"  size=\"100\"/> </td></tr>\n\n\n\n    </tbody>\n    </table>\n\n\n\n\n</div></div>\n";
    } else {
        if ($data["gateway"] == "usps") {
            echo "\n\n    <div  class=\"groupstabes\" >\n          <h2>\n            <span class=\"groupstabesheadertext\">";
            echo $LNG["gateway"];
            echo " : ";
            echo $data["gateway"];
            echo "</span>\n          </h2>\n          <div class=\"groupstabescontant\">\n\n\n\n    ";
            echo generate_token("form");
            echo "    <table border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\" class=\"form\">\n    <tbody>\n\n    <tr><td   class=\"fieldlabel\">";
            echo $LNG["user"];
            echo "</td><td class=\"fieldarea\">\n    <input type=\"text\"  class=\"txt medium\" name=\"usps_user\"  size=\"100\" value=\"";
            echo $config["usps_user"];
            echo "\" /></td></tr>\n\n\n\n    </tbody>\n    </table>\n\n\n\n\n</div></div>\n";
        } else {
            if ($data["gateway"] == "fedex") {
                echo "\n\n    <div  class=\"groupstabes\" >\n          <h2>\n            <span class=\"groupstabesheadertext\">";
                echo $LNG["gateway"];
                echo " : ";
                echo $data["gateway"];
                echo "</span>\n          </h2>\n          <div class=\"groupstabescontant\">\n\n\n    ";
                echo generate_token("form");
                echo "    <table border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\" class=\"form\">\n    <tbody>\n\n\n    <tr><td class=\"fieldlabel\">";
                echo $LNG["account"];
                echo "</td>\n    <td class=\"fieldarea\"> <input type=\"text\"  class=\"txt medium\"  name=\"fedex_account\"  value=\"";
                echo $config["fedex_account"];
                echo "\"/> </td></tr>\n\n\n    <tr><td class=\"fieldlabel\">";
                echo $LNG["meter"];
                echo "</td>\n    <td class=\"fieldarea\"> <input type=\"text\"  class=\"txt medium\"  name=\"fedex_meter\"  value=\"";
                echo $config["fedex_meter"];
                echo "\"/> </td></tr>\n\n\n\n    </tbody>\n    </table>\n\n\n\n\n</div></div>\n";
            }
        }
    }
}
echo "</form>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>