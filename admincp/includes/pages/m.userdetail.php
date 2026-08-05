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
$id = $_GET["u"];
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
echo "\n";
if ($clientDetails["usertype"] == "0") {
    $type = $LNG["user"];
    $color = "gray";
} else {
    if ($clientDetails["usertype"] == "1") {
        $type = $LNG["advance"] . " " . $LNG["reseller"];
        $color = "black";
    } else {
        if ($clientDetails["usertype"] == "3") {
            $type = $LNG["resellersusers"];
            $color = "gray";
        }
    }
}
if ($clientDetails["userstatus"] == "0") {
    $status = $LNG["active"];
    $color1 = "#779500";
} else {
    if ($clientDetails["userstatus"] == "1") {
        $status = $LNG["blocked"];
        $color1 = "#c00";
    } else {
        if ($clientDetails["userstatus"] == "2") {
            $status = $LNG["inactive"];
            $color1 = "#c00";
        }
    }
}
$diff = time() - $clientDetails["credit"]["date"];
$days = round($diff / 86400);
if ($clientDetails["credit"]["validity"] != 0) {
    if ($days < $clientDetails["credit"]["validity"]) {
        $color = "#779500";
    } else {
        if ($clientDetails["credit"]["validity"] == $days) {
            $color = "#779500";
        } else {
            $color = "#c00";
        }
    }
}
echo "<script>\nfunction remacc(){\n    var answer = confirm('Are you sure want to remove Account');\n    if(answer)\n    {\n        SubmitForm ('#btnsave','edituser.closeaccount','#frmstatus','#safali','false','');\n    }\n}\n</script>\n<div id=\"notification\"></div>\n<div id=\"safali\"></div>\n    <div class=\"panel\">\n        <h2>User Detail</h2>        \n        <table class=\"grid\">\n            <tr>\n                <td colspan=\"2\" class=\"contactinfo\" align=\"right\">\n                    ";
echo $clientDetails["firstname"] . " " . $clientDetails["lastname"];
echo " [";
echo $clientDetails["currency"]["code"];
echo "]\n                    <br />";
echo $clientDetails["email"];
echo "<br />\n                    ";
echo $clientDetails["countryname"];
echo " <img align=\"absmiddle\" src=\"images/flags/";
echo strtolower($clientDetails["country"]);
echo ".png\" border=\"0\" />\n                </td>\n            </tr>            \n            <tr>\n                <td>";
echo $LNG["balance"];
echo "</td>\n                <td>";
echo formatCurrency($clientDetails["credit"]["credit"], $clientDetails["currency"]);
echo "</td>\n            </tr>        \n            <tr>\n                <td>";
echo $LNG["totalreceipt"];
echo "</td>\n                <td>";
echo formatCurrency($clientDetails["credit"]["credit"] + $clientDetails["credit"]["used"], $clientDetails["currency"]);
echo "</td>\n            </tr>   \n            <tr>\n                <td>";
echo $LNG["creditinprocess"];
echo "</td>\n                <td>";
echo formatCurrency($clientDetails["credit"]["in_process"], $clientDetails["currency"]);
echo "</td>\n            </tr> \n            <tr>\n                <td>";
echo $LNG["sellcreditlimit"];
echo "</td>\n                <td>";
echo formatCurrency($clientDetails["credit"]["selling_limit"], $clientDetails["currency"]);
echo "</td>\n            </tr>       \n            <tr>\n                <td>";
echo $LNG["credit"];
echo " ";
echo $LNG["expired"];
echo "</td>\n                <td>\n                 [<span class=\"fieldarea\" style=\"color: ";
echo $color;
echo ";\">\n                ";
if ($clientDetails["credit"]["validity"] == "0") {
    echo "<strong>" . $LNG["neverexpired"] . "</strong>";
} else {
    $validity = $clientDetails["credit"]["validity"];
    $validity = date("Y-m-d", strtotime(date("Y-m-d", $clientDetails["credit"]["date"]) . "+" . $validity . " day"));
    echo "<strong>" . formatDate($validity) . "</strong>";
}
echo "                </span> ]\n                </td>\n            </tr>  \n            \n            \n           \n            <tr>\n                <td valign=\"top\">";
echo $LNG["change"];
echo " ";
echo $LNG["status"];
echo "</td>\n                <td>\n                    <form method=\"post\" id=\"frmstatus\">  \n                        <input type=\"hidden\" name=\"tbl['SAFALO1']\" value=\"\" />\n                        <input type=\"hidden\" name=\"tbl['SAFALO2']\" value=\"\" />\n                        <input type=\"hidden\" name=\"mobile\" value=\"true\" />\n                        <input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n                      \t<ul>\n                              <li class=\"diff\">\n                                <span><input type=\"radio\" id=\"active\" name=\"status\" value=\"0\" ";
if ($clientDetails["userstatus"] == "0") {
    echo "checked";
}
echo "/><label for=\"active\">";
echo $LNG["active"];
echo "</label></span>\n                                <span><input type=\"radio\" name=\"status\" id=\"inactive\" value=\"2\" ";
if ($clientDetails["userstatus"] == "2") {
    echo "checked";
}
echo "/><label for=\"inactive\">";
echo $LNG["inactive"];
echo "</label></span>\n                                <span><input type=\"radio\" name=\"status\"  id=\"blocked\" value=\"1\" ";
if ($clientDetails["userstatus"] == "1") {
    echo "checked";
}
echo "/><label for=\"blocked\">";
echo $LNG["blocked"];
echo " </label></span>                                       \n                              </li>\n                              \n                          </ul>  \n                          <p>\n                            <input type=\"button\" name=\"save\" id=\"btnsave\" class=\"btn\" value=\"Save\" onclick=\"SubmitForm ('#btnsave','edituser.profile','#frmstatus','#notification','true','#main_loader');\" />\n                            </p>  \n                       </form>                     \n                </td>\n            </tr>                                                                                                        \n        </table>\n      \n     \n    </div>\n\n\n\n<hr />\n<div class=\"action2\">\n<div class=\"\">\n            <p><a href=\"main4.php?page=addcredit&u=";
echo $id;
echo "\" class=\"btn\">+Add Credit</a></p>\n            <p><a href=\"main4.php?page=rebatecredit&u=";
echo $id;
echo "\" class=\"btn\">-Rebate Credit</a></p>\n            <p><a href=\"main4.php?page=changepass&u=";
echo $id;
echo "\" class=\"btn\">Change Password</a></p>\n            <p><a  onclick=\"remacc();\"  class=\"btn\">Remove Account</a></p>\n            <p>\n            <form method=\"post\" id=\"frmreset\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<input type=\"hidden\" name=\"username\" value=\"";
echo $id;
echo "\" />\n";
echo generate_token("form");
echo "   \n        <a  class=\"btn\" id=\"btnresetpin\" onclick=\"SubmitForm ('#btnsave','edituser.resetpin','#frmreset','#notification','false','');\" >\n        Reset Pin\n        </a>\n    \n </form>\n            </p>\n            <p><a href=main4.php?page=unpaidinvoice&u=";
echo $id;
echo " class=\"btn\">Unpaid Invoices</a></p>\n            <p><a href=main4.php?page=orderhistory&u=";
echo $id;
echo " class=\"btn\">Order History</a></p>\n</div>\n</div>\n";

?>