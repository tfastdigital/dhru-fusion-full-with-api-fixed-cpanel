<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($save && $key != "") {
    checkDemoMode(false);
    $data["key"] = $key;
    $data["group_id"] = $group_id;
    $data["status"] = $status;
    $data["expiredon"] = $expiredon;
    $data["qnt"] = $qnt;
    $data["purchase"] = $purchase;
    if ($db->update("tbl_swkey", $data, "id='" . $id . "'")) {
        echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
$cntr = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_swkey WHERE id='" . $id . "'"));
echo "\n    <div id=\"notification\"></div>\n    <div  class=\"groupstabes\" >\n\n        <div class=\"groupstabescontant\">\n\n            <div id=\"content\">\n                <div id=\"content_padded\" style=\"padding: 30px;\">\n                    <h2>\n                        <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n                        <span class=\"groupstabesheadertext\">";
echo $cntr["key"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n                    </h2>\n                    <form id=\"frm\" name=\"\" method=\"post\">\n                        <input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n                        <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                            <tbody>\n\n                            <tr>\n                                <td  class=\"fieldlabel\">";
echo $LNG["key"];
echo " </td>\n                                <td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium \" name=\"key\" value=\"";
echo $cntr["key"];
echo "\" style=\"width: 400px;\" /></td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["key"];
echo " ";
echo $LNG["group"];
echo "</td>\n                                <td class=\"fieldarea\">\n                                    <select name=\"group_id\">\n                                        ";
$sql = dquery("select * from tbl_keygroup");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                                            <option value=\"";
    echo $row["id"];
    echo "\" ";
    if ($row["id"] == $cntr["group_id"]) {
        echo "selected";
    }
    echo ">";
    echo $row["group"];
    echo "</option>\n                                            ";
}
echo "                                    </select>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n                                <td class=\"fieldarea radio\">\n                                    <input type=\"radio\" name=\"status\" value=\"1\" id=\"s_yes\" ";
if ($cntr["status"]) {
    echo "checked";
}
echo " /><label for=\"s_yes\">";
echo $LNG["used"];
echo "</label>\n                                    &nbsp;<input type=\"radio\" name=\"status\" value=\"0\" ";
if (!$cntr["status"]) {
    echo "checked";
}
echo " id=\"y_no\"/><label for=\"y_no\">";
echo $LNG["unused"];
echo "</label></td>\n                            </tr>\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["expired"];
echo "</td>\n                                <td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium datepicker\"  autocomplete=\"off\" name=\"expiredon\" id=\"from\" value=\"";
echo $cntr["expiredon"];
echo "\" style=\"width: 100px;\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["stock"];
echo "</td>\n                                <td class=\"fieldarea\"><input type=\"text\"\n                                                             class=\"txt medium\" name=\"qnt\"  value=\"";
echo $cntr["qnt"] == 0 ? 1 : $cntr["qnt"];
echo "\" style=\"width: 100px;\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["purchase"];
echo "</td>\n                                <td class=\"fieldarea\"><input type=\"text\"\n                                                             class=\"txt medium\" name=\"purchase\"  value=\"";
echo $cntr["purchase"];
echo "\" style=\"width: 100px;\"/>\n                                </td>\n                            </tr>\n                            </tbody>\n                        </table>\n\n                        <div class=\"fixedbtn\">\n                            <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"submit\" name=\"save\"  />\n                        </div>\n\n                    </form>\n                    <br /><br />\n                    <table id=\"main_tbl\" >\n                        <thead>\n                        <tr>\n                            <th>";
echo $LNG["order"];
echo "</th>\n                            <th>";
echo $LNG["user"];
echo "</th>\n                            <th>";
echo $LNG["date"];
echo "</th>\n                            <th>";
echo $LNG["qnt"];
echo "</th>\n                        </tr>\n                        </thead>\n                        ";
$uq = dquery("select *,(select username from tblUsers where id=userid) as user from tbl_used_key where keyid='" . $id . "'");
while ($rq = mysqli_fetch_assoc($uq)) {
    echo "                            <tr>\n                                <td><a style=\"cursor: pointer;\" href=\"javascript:load_fromsubpage('edituser.editimeiorder&id=";
    echo $rq["orderid"];
    echo "','";
    echo $rq["type"] == "imei" ? "IMEI" : "SERVER";
    echo "#";
    echo $rq["orderid"];
    echo "')\">#";
    echo $rq["orderid"];
    echo "</a></td>\n                                <td>";
    echo $rq["user"];
    echo "</td>\n                                <td>";
    echo $rq["date"];
    echo "</td>\n                                <td>";
    echo $rq["qnt"];
    echo "</td>\n                            </tr>\n                            ";
}
echo "                    </table>\n                </div></div></div></div>\n\n";
$fileverioncheck = "6.1.0";

?>