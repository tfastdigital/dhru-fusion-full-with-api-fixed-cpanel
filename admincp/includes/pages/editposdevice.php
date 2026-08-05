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
echo "<div class=\"outertabdiv\">\n\n\n            <div id=\"notification\"></div>\n            <div id=\"content\">\n                <div id=\"content_padded\" class=\"groupstabescontant\">\n                    ";
if ($edit) {
    checkDemoMode(false);
    $data["devicename"] = $devicename;
    $data["serialno"] = $serialno;
    $data["devicestatus"] = $devicestatus;
    $db->update("tbl_pos_terminal", $data, "posterminalid='" . $edit . "'");
    echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
}
if ($id) {
    $row = mysqli_fetch_assoc(dquery("select * from tbl_pos_terminal where posterminalid='" . $id . "'"));
    echo "\n                        <form id=\"frm\" name=\"\" method=\"post\">\n                            <input type=\"hidden\" name=\"edit\" value=\"";
    echo $id;
    echo "\" />\n                            ";
    echo generate_token("form");
    echo "                            <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\" style=\"width: 100%;\">\n                                <tbody>\n                                <tr>\n                                    <td class=\"fieldlabel\">";
    echo $LNG["device"];
    echo " ";
    echo $LNG["name"];
    echo " </td>\n                                    <td class=\"fieldarea\">\n\n                 <input name=\"devicename\"   value=\"";
    echo $row["devicename"];
    echo "\" type=\"text\"  class=\"txt medium\"/>\n\n                                    </td>\n                                </tr>\n                                <tr>\n                                    <td class=\"fieldlabel\">";
    echo $LNG["serialno"];
    echo " </td>\n                                    <td class=\"fieldarea\"><input name=\"serialno\"  value=\"";
    echo $row["serialno"];
    echo "\" type=\"text\"  class=\"txt medium\"/></td>\n                                </tr>\n                                <tr>\n                                    <td class=\"fieldlabel\">";
    echo $LNG["status"];
    echo " </td>\n                                    <td class=\"fieldarea\">\n                        <label><input type=\"radio\" name=\"devicestatus\" value=\"1\" ";
    echo $row["devicestatus"] ? "checked=\"checked\"" : "";
    echo " />Active </label>\n                                        &nbsp;&nbsp;&nbsp;&nbsp;\n                                        <label><input type=\"radio\" name=\"devicestatus\" value=\"0\" ";
    echo !$row["devicestatus"] ? "checked=\"checked\"" : "";
    echo " />In-Actvie </label>\n                                    </td>\n                                </tr>\n\n\n\n                                </tbody>\n                            </table>\n\n                            <div class=\"fixedbtn\">\n                                <input value=\"";
    echo $LNG["save"];
    echo "\" id=\"btnoverview\"\n                                       class=\"btn save\" type=\"submit\"   />\n                            </div>\n\n\n\n                        </form>\n                        ";
}
echo "                </div></div>\n        </div>\n";
$fileverioncheck = "6.1.0";

?>