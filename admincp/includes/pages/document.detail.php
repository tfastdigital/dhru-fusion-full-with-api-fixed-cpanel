<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 186;
checkPagePermission($pageid);
echo "<div id=\"content\">\r\n    <div id=\"content_padded\">\r\n        <div>\r\n            <div  class=\"groupstabes\" >\r\n                <div class=\"groupstabescontant\">\r\n                    ";
require_once ROOTDIR . "/includes/mail.fun.php";
if ($approve) {
    dquery("update tbl_document set status=1,notes='" . $_POST["notes"] . "',reason='" . $_POST["reason"] . "' where id='" . $id . "'");
    dquery("update tblUsers set idverification=1 where id in (select uid from \r\n      tbl_document where id='" . $id . "')");
    $doc = mysqli_fetch_assoc(dquery("select *,(select username from tblUsers\r\nwhere id=uid) as user, (select email from tblUsers where id=uid) as email\r\nfrom tbl_document where id='" . $id . "'"));
    if ($sendmail) {
        $emailfield["status"] = "Approved";
        sendMail(81, $doc["uid"], "", $emailfield, true);
    }
    echo "                        <div id=\"notification1\" class=\"successbox\">\r\n                            Document approved\r\n                        </div>\r\n                        ";
}
if ($reject) {
    $notes = descape($_POST["notes"]);
    dquery("update tbl_document set status=2,notes='" . $notes . "',reason='" . $_POST["reason"] . "' where id='" . $id . "'");
    dquery("update tblUsers set idverification=0 where id in (select uid from \r\n      tbl_document where id='" . $id . "')");
    $doc = mysqli_fetch_assoc(dquery("select *,(select username from tblUsers\r\nwhere id=uid) as user, (select email from tblUsers where id=uid) as email\r\nfrom tbl_document where id='" . $id . "'"));
    if ($sendmail) {
        $emailfield["status"] = "Rejected";
        $emailfield["rejectreason"] = $reason;
        sendMail(81, $doc["uid"], "", $emailfield, true);
    }
    echo "                        <div id=\"notification1\" class=\"successbox\">\r\n                            Document rejected\r\n                        </div>\r\n                        ";
}
$doc = mysqli_fetch_assoc(dquery("select *,(select username from tblUsers\r\nwhere id=uid) as user, (select email from tblUsers where id=uid) as email\r\nfrom tbl_document where id='" . $id . "'"));
echo "\r\n                    <div class=\"floatleft\" style=\"width: auto !important;\">\r\n                        <div class=\"groupstabes\">\r\n                            <h2> <span class=\"groupstabesheadertext\"> ";
echo $LNG["user"];
echo " ";
echo $LNG["detail"];
echo "</span></h2>\r\n                        </div>\r\n\r\n                        <div class=\"responsive-table\">\r\n                            <table  class=\"form\" style=\"margin: 0 20px 0 0;\">\r\n\r\n                                <tbody>\r\n                                <tr><td class=\"fieldlabel\"  style=\"min-width: 80px;\">\r\n                                        ";
echo $LNG["username"];
echo "                                    </td>\r\n                                    <td class=\"fieldarea\">";
echo $doc["user"];
echo "</td>\r\n                                </tr>\r\n                                <tr><td class=\"fieldlabel\"  style=\"min-width: 80px;\">\r\n                                        ";
echo $LNG["email"];
echo "                                    </td>\r\n                                    <td class=\"fieldarea\">";
echo $doc["email"];
echo "</td>\r\n                                </tr>\r\n                                <tr><td class=\"fieldlabel\"  style=\"min-width: 80px;\">\r\n                                        ";
echo $LNG["city"];
echo "                                    </td>\r\n                                    <td class=\"fieldarea\">";
echo $doc["city"];
echo " - ";
echo $doc["pin"];
echo "</td>\r\n                                </tr>\r\n                                <tr><td class=\"fieldlabel\"  style=\"min-width: 80px;\">\r\n                                        ";
echo $LNG["state"];
echo "                                    </td>\r\n                                    <td class=\"fieldarea\">";
echo $doc["state"];
echo "</td>\r\n                                </tr>\r\n                                <tr><td class=\"fieldlabel\"  style=\"min-width: 80px;\">\r\n                                        ";
echo $LNG["country"];
echo "                                    </td>\r\n                                    <td class=\"fieldarea\">";
echo $doc["country"];
echo "</td>\r\n                                </tr>\r\n                                </tbody>\r\n                            </table>\r\n                        </div>\r\n                    </div>\r\n\r\n                    <div class=\"floatleft\" style=\"width: auto\">\r\n                        <div class=\"groupstabes\">\r\n                            <h2> <span class=\"groupstabesheadertext\">Document </span></h2>\r\n                        </div>\r\n                        <div class=\"responsive-table\">\r\n                            <form method=\"post\">\r\n                                <input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\r\n                                <table  class=\"form\" style=\"margin: 0 20px 0 0;\">\r\n\r\n                                    <tbody>\r\n                                    <tr>\r\n                                        <td class=\"fieldlabel\" >\r\n                                            View Document\r\n                                        </td>\r\n                                        <td class=\"fieldarea\">\r\n                                            <a style=\"border-bottom: #ccc solid 1px\"  href=\"includes/download.php?action=idverifacation&id=";
echo $doc["id"];
echo "\"><i class=\"fa fa-download\"></i> ";
echo $doc["doctype"];
echo "</a>\r\n                                        </td>\r\n                                    </tr>\r\n\r\n                                    <tr>\r\n                                        <td class=\"fieldlabel\" >\r\n                                            View Document\r\n                                        </td>\r\n                                        <td class=\"fieldarea\">\r\n                                            <a style=\"border-bottom: #ccc solid 1px\"  href=\"includes/download.php?action=idstatement&id=";
echo $doc["id"];
echo "\"><i class=\"fa fa-download\"></i> Statement</a>\r\n                                        </td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td class=\"fieldlabel\" >\r\n                                            Other Details\r\n                                        </td>\r\n                                        <td class=\"fieldarea\">\r\n                                            ";
echo $doc["other"];
echo "                                        </td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td class=\"fieldlabel\" >\r\n                                            User Notes\r\n                                        </td>\r\n                                        <td class=\"fieldarea\">\r\n                                            <textarea name=\"notes\">";
echo $doc["notes"];
echo "</textarea>\r\n                                        </td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td class=\"fieldlabel\" >\r\n                                            Reject Reason\r\n                                        </td>\r\n                                        <td class=\"fieldarea\">\r\n                                            <textarea name=\"reason\">";
echo $doc["reason"];
echo "</textarea>\r\n                                        </td>\r\n                                    </tr>\r\n                                    <tr>\r\n\r\n                                        <td>\r\n                                            <label><input type=\"checkbox\" name=\"sendmail\" value=\"1\" checked />Send Mail to User </label>\r\n                                        </td>\r\n                                        <td></td>\r\n                                    </tr>\r\n                                    ";
if ($doc["status"] == 0 || $doc["status"] == 2) {
    echo "                                        <tr>\r\n                                            <td colspan=\"2\" class=\"fieldarea\">\r\n                                                <button type=\"submit\" class=\"btn\" name=\"approve\"\r\n                                                        style=\"background: green\"      value=\"1\">Approve\r\n                                                </button>\r\n                                                <button type=\"submit\" class=\"btn\" name=\"reject\"\r\n                                                        value=\"";
    echo $LNG["reject"];
    echo "\">";
    echo $LNG["reject"];
    echo "                                                </button>\r\n                                            </td>\r\n                                        </tr>\r\n                                        ";
} else {
    echo "                                        <tr>\r\n                                            <td colspan=\"2\" class=\"fieldarea\">\r\n\r\n                                                <button type=\"submit\" class=\"btn btn-danger\" name=\"reject\"\r\n                                                        value=\"";
    echo $LNG["reject"];
    echo "\">";
    echo $LNG["reject"];
    echo "                                                </button>\r\n                                            </td>\r\n                                        </tr>\r\n                                        ";
}
echo "                                    </tbody>\r\n                                </table>\r\n\r\n                            </form>\r\n\r\n                        </div>\r\n                                            </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n    ";
$fileverioncheck = "6.1.0";

?>