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
echo "<div id=\"tabcontent\">\r\n    <div id=\"notification\"></div>\r\n    <div id=\"content\">\r\n        <div id=\"content_padded\">\r\n            ";
$row = mysqli_fetch_assoc(dquery("select * from tbl_keygroup where id='" . $edit . "'"));
echo "            <form method=\"post\" id=\"frm\">\r\n                <input type=\"hidden\" name=\"id\" value=\"";
echo $_GET["edit"];
echo "\" />\r\n                <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\">\r\n                    <tbody>\r\n\r\n                    <tr>\r\n                        <td class=\"fieldlabel\">Group</td>\r\n                        <td class=\"fieldarea\">\r\n                            <input type=\"text\" class=\"txt large\" name=\"group\" value=\"";
echo $row["group"];
echo "\" />\r\n                        </td>\r\n                    </tr>\r\n                    ";
if ($row["codetable"]) {
    echo "                        <tr>\r\n                            <td class=\"fieldlabel\">Database Table Name</td>\r\n                            <td class=\"fieldarea\"><span>\r\n    <input type=\"text\" class=\"txt large\" name=\"codetable\" value=\"";
    echo $row["codetable"];
    echo "\"/>\r\n    </span></td>\r\n                        </tr>\r\n\r\n                        <tr>\r\n                            <td class=\"fieldlabel\">Tabel IMEI Field</td>\r\n                            <td class=\"fieldarea\"><span>\r\n    <input type=\"text\" class=\"txt large\" name=\"codeimei\" value=\"";
    echo $row["codeimei"];
    echo "\"/>\r\n    </span></td>\r\n                        </tr>\r\n\r\n                        <tr>\r\n                            <td class=\"fieldlabel\">Tabel Reply/Code Field</td>\r\n                            <td class=\"fieldarea\"><span>\r\n    <input type=\"text\" class=\"txt large\" name=\"codereply\" value=\"";
    echo $row["codereply"];
    echo "\"/>\r\n                                Multiple field separate by comma (e.g. reply1,reply2)\r\n    </span></td>\r\n                        </tr>\r\n                        <tr class=\"codetable\">\r\n                            <td class=\"fieldlabel \">\r\n                                Exclude Starting Characters of IMEI\r\n                            </td>\r\n                            <td class=\"fieldarea\"><input type=\"text\" size=\"3\" value=\"";
    echo $row["exlcludestart"];
    echo "\"\r\n                                                         name=\"exlcludestart\"/>\r\n                                <small>If you dont want to compare some starting characters e.g. 2 or 3 .</small>\r\n                            </td>\r\n                        </tr>\r\n                        <tr class=\"codetable\">\r\n                            <td class=\"fieldlabel \">\r\n                                Exclude Ending Characters of IMEI\r\n                            </td>\r\n                            <td class=\"fieldarea\"><input type=\"text\" size=\"3\" value=\"";
    echo $row["exludeend"];
    echo "\"\r\n                                                         name=\"exludeend\"/>\r\n                                <small>If you dont want to compare some ending characters e.g. 1 or 4 .</small>\r\n                            </td>\r\n                        </tr>\r\n\r\n                        <tr class=\"codetable\">\r\n                            <td class=\"fieldlabel \">\r\n                                Modify/Split Reply with Pattern\r\n                            </td>\r\n                            <td class=\"fieldarea\"><input type=\"text\" value=\"";
    echo $row["replysprintf"];
    echo "\"\r\n                                                         name=\"replysprintf\"/>\r\n                                <small>Split reply/code of database (e.g.if reply is ABCDEFGH then REPLY 1 : **** REPLY\r\n                                    2: **** (REPLY 1: ABCD REPLY 2: EFGH) )\r\n                                </small>\r\n                            </td>\r\n                        </tr>\r\n\r\n                        <tr class=\"codetable\">\r\n                            <td class=\"fieldlabel \">\r\n                            </td>\r\n                            <td class=\"fieldarea\">\r\n                                <label><input type=\"checkbox\" ";
    echo $row["autoreject"] ? "checked" : "";
    echo "                                              name=\"autoreject\" value=\"1\"/>Auto Reject if Code not found</label>\r\n                            </td>\r\n                        </tr>\r\n                        ";
}
echo "                    </tbody>\r\n                </table>\r\n\r\n                <div class=\"fixedbtn\">\r\n                    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnoverview\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btnoverview','editautoreply','#frm','#notification','true','#main_loader');\"/>\r\n                </div>\r\n\r\n            </form>\r\n\r\n        </div></div>\r\n</div>";
$fileverioncheck = "6.1.0";

?>