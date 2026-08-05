<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
$pageid = 154;
checkPagePermission($pageid);
$Stat = mysqli_fetch_assoc(dquery("select * from tbl_statement_user where id='" . $id . "'"));
if ($Stat["data"]) {
    $SData = json_decode($Stat["data"], true);
}
$Wallet = mysqli_fetch_assoc(dquery("select *,(select `value` from tbl_paymentgateways\nwhere setting='name' and tbl_paymentgateways.gateway=tblWalletTransaction.gateway) as gat from tblWalletTransaction where transid='" . $Stat["relid"] . "'"));
$WD = json_decode($Wallet["data"], true);
$Trans = mysqli_fetch_assoc(dquery("select id from tbl_statement_user where relid='" . $Wallet["transid"] . "'\nand stype='Transfer' and uid='" . $Wallet["merchantid"] . "'"));
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n    <div id=\"content_padded\">\n        <form id=\"newpost\" name=\"newpost\" method=\"post\">\n            ";
echo generate_token("form");
echo "            <input type=\"hidden\" value=\"\" name=\"tinyvalue\" id=\"tinyvalue\"/>\n            <table><tr><td width=\"50%\" valign=\"top\">\n                        <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                            <tbody>\n\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["date"];
echo "</td>\n                                <td class=\"fieldarea\">\n\n                                    ";
echo $Stat["date"];
echo "                                </td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["time"];
echo "</td>\n                                <td class=\"fieldarea\">\n\n                                    ";
echo date("h:i A", $Stat["time"]);
echo "                                </td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["item"];
echo "</td>\n                                <td class=\"fieldarea\">\n\n                                    ";
echo $SData["item"];
echo "                                </td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["gateway"];
echo "</td>\n                                <td class=\"fieldarea\">\n\n                                    ";
echo $Wallet["gat"];
echo "                                </td>\n                            </tr>\n                            ";
if ($Wallet["status"] == "paid") {
    echo "                                <tr>\n                                    <td class=\"fieldlabel\">";
    echo $LNG["transaction"];
    echo " ";
    echo $LNG["id"];
    echo "</td>\n                                    <td class=\"fieldarea\">\n\n                                        ";
    echo md5($Trans["id"]);
    echo "                                    </td>\n                                </tr>\n                                ";
}
echo "                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["gateway"];
echo " ";
echo $LNG["transaction"];
echo " ";
echo $LNG["id"];
echo "</td>\n                                <td class=\"fieldarea\">\n\n                                    ";
echo $Wallet["transactionid"];
echo "                                </td>\n                            </tr>\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["gateway"];
echo " ";
echo $LNG["orderid"];
echo "</td>\n                                <td class=\"fieldarea\">\n\n                                    ";
echo "B_" . $Wallet["transid"];
echo "                                </td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["amount"];
echo "</td>\n                                <td class=\"fieldarea\">\n\n                                    ";
echo round($WD["merchantamount"] + $Wallet["fee"], 2);
echo "                                </td>\n                            </tr>\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["fee"];
echo "</td>\n                                <td class=\"fieldarea\">\n\n                                    ";
echo $Wallet["fee"];
echo "                                </td>\n                            </tr>\n                            </tbody>\n                        </table>\n                    </td></tr></table>\n        </form>\n    </div>\n</div>\n";
$fileverioncheck = "6.1.0";

?>