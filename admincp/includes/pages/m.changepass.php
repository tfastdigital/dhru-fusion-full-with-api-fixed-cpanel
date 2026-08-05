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
$id = $_GET["u"];
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
echo "<script>\nfunction genpass(){\n    var answer = confirm('";
echo $LNG["areyousuretoresetpassword"];
echo "');\n    if(answer)\n    {\n        SubmitForm ('#btnedituserpass','edituser.sendpasswordmail','#frmpass','#notificationpas','false','');\n    }\n}\n</script>\n</div>\n\n  <div id=\"notificationpas\"></div>\n\n <div class=\"content\">\n        <div class=\"panel\">\n\n  <form method=\"post\" id=\"frmpass\">\n  <input type=\"hidden\" name=\"mobile\" value=\"true\" />\n  <input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n            <h2>Change Password</h2>\n            <ol>\n                <li class=\"field\">\n                    <label>";
echo $LNG["password"];
echo ":\n                        <input name=\"password\" id=\"password\" value=\"\" type=\"password\" />\n                    </label>\n                </li>\n                <li class=\"field\">\n                    <label>\n\n<a class=\"btn\" id=\"btnedituser\" onclick=\"SubmitForm ('#btnedituser','edituser.profile','#frmpass','#notificationpas','false','');\" >";
echo $LNG["save"];
echo "</a>\n\n<a class=\"btn\" id=\"btnedituserpass\" onclick=\"genpass();\" >";
echo $LNG["reset"];
echo "</a>\n                    </label>\n                </li>\n\n            </ol>\n   </form>\n        </div>\n</div>\n\n\n\n\n";

?>