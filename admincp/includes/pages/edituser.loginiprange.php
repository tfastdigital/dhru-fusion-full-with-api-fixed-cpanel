<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 212;
checkPagePermission($pageid);
include ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
if ($clientDetails["userstatus"] != "0") {
    echo "<div id=\"notification1\" class=\"info\">";
    if ($clientDetails["userstatus"] == "1") {
        $status = $LNG["thisaccounthasbeen"] . " " . $LNG["blocked"];
    } else {
        if ($clientDetails["userstatus"] == "2") {
            $status = $LNG["thisaccounthasbeen"] . " " . $LNG["inactive"];
        }
    }
    echo "<span><strong>";
    echo $status;
    echo "</strong></span></div>";
}
echo "<div id=\"notification\"></div>\n\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<div  class=\"groupstabes\" >\n\n    <h2> <span class=\"groupstabesheadertext\">Bind Login </span>\n    </h2>\n\n<script>\nfunction removeCountry(country){\n    \$(\"#row_\"+country).hide();\n     \$.post( \"includes/pages/removelogincountry.php?country=\"+country+\"&userid=";
echo $id;
echo "\", function( data ) {\n\n    });\n}\n</script>\n<form id=\"frmedituserip\" name=\"frmedituserip\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\"/>\n    <input type=\"hidden\" name=\"laoddefaultpage\" value=\"edituser.loginiprange.php\" />\n<table class=\"form\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel border-0\">";
echo $LNG["iprange"];
echo "</td>\n    <td class=\"fieldarea  border-0\"><textarea name=\"ips\" rows=\"10\" style=\"height: 150px;\" cols=\"30\">";
echo $clientDetails["ip_range"];
echo "</textarea>\n        <small>";
echo $LNG["iploginsecurity"];
echo "</small>\n    </td>\n</tr>\n\n<tr>\n    <td></td>\n    <td>\n       <div>\n           <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituserip\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituserip','edituser.loginiprange','#frmedituserip','#notification','true','#main_loader','main2.php?page=edituser.loginiprange','";
echo $id;
echo "');\"/>\n       </div>\n    </td>\n</tr>\n\n</tbody>\n\n</table>\n\n\n\n    <hr/>\n\n    <h2><span>";
echo $LNG["allow"];
echo " ";
echo $LNG["country"];
echo "</span></h2>\n\n<table id=\"main_tbl\" class=\"mt-4\">\n\n    <tr>\n        <td class=\"fieldlabel\" width=\"15%\">\n            ";
echo getCountriesDropDown("", "allowcountry", true);
echo "        </td>\n        <td class=\"fieldarea\">\n\n\n            <div class=\"text-left\">\n\n                <input type=\"button\" name=\"addcountry\" id=\"btnaddc\"\n                       onclick=\"SubmitForm ('#btnaddc','edituser.loginiprange','#frmedituserip','#notification','true','#main_loader','main2.php?page=edituser.loginiprange&selected=loginiprange','";
echo $id;
echo "');\"\n                       value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["country"];
echo "\">\n\n            </div>\n\n        </td>\n    </tr>\n\n\n    ";
$country = json_decode($clientDetails["allowedcountry"], true);
foreach ($country as $c) {
    echo "        <tr id=\"row_";
    echo $c;
    echo "\">\n            <td>";
    echo $countries[$c];
    echo "</td>\n            <td><button class=\"btn btn-danger btn-sm\"\n                        onclick=\"removeCountry('";
    echo $c;
    echo "')\"\n                        type=\"button\" >Delete</button> </td>\n        </tr>\n        ";
}
echo "</table>\n\n</div>\n\n\n";
if ($clientDetails["sndlogin"]) {
    echo "<input type=\"button\" class=\"button_remove btn\" name=\"disableotp\"\nvalue=\"";
    echo $LNG["disable"];
    echo " OTP\" id=\"diotp\"\nonclick=\"SubmitForm ('#diotp','edituser.otp','#frmedituserip','#notification','true','#main_loader'); \$('#diotp').hide();\" />\n";
}
echo "\n\n</form>\n\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>