<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require_once "../comm.php";
$id = preg_replace("/[^0-9a-zA-Z]/i", "", $id);
$buff = [];
if ($id) {
    $sql = mysqli_fetch_assoc(dquery("select * from tbl_livehelp_conversation WHERE view='0' and status='10' and md5(id)='" . $id . "'"));
    if ($sql) {
        $buff[] = ["message" => "The chat conversation has ended.", "type" => "notification"];
        $sql = dquery("UPDATE tbl_livehelp_conversation set view=1 where id=" . $sql["id"] . " and status='10'");
    }
    $sql = mysqli_fetch_assoc(dquery("select * from tbl_livehelp_conversation WHERE view='0' and status='0' and md5(id)='" . $id . "'"));
    if ($sql) {
        $buff[] = ["message" => "Please wait an operator will be with you shortly....", "type" => "notification"];
        $sql = dquery("UPDATE tbl_livehelp_conversation set view=1 where id=" . $sql["id"] . " and status='0'");
    }
    $time = time();
    $sql = mysqli_fetch_assoc(dquery("select * from tbl_livehelp_conversation WHERE '" . $time . "'>(time+60)  and status='0' and md5(id)='" . $id . "'"));
    if ($sql) {
        $buff[] = ["message" => "<div class=\"text-muted mb-1\">Your request is important to us. Please wait an operator will be with you shortly....</div>", "type" => "notification"];
        $sql = dquery("UPDATE tbl_livehelp_conversation set time='" . $time . "' where id=" . $sql["id"] . " and status='0'");
    }
    $sql = mysqli_fetch_assoc(dquery("select *,(select firstname from tbl_admin where id=adminid) as firstname,\n                        (select lastname from tbl_admin where id=adminid) as lastname,\n                        (select department from tbl_support_department where id=tbl_livehelp_conversation.department) as departments\n                         from tbl_livehelp_conversation WHERE view='0' and status='1' and md5(id)='" . $id . "'"));
    if ($sql) {
        $buff[] = ["message" => "Welcome, <strong>" . $sql["firstname"] . " " . $sql["lastname"] . "</strong> is here from <strong>" . $sql["departments"] . "</strong> deparetment... <br/> How can i help you?", "type" => "notification"];
        $sql = dquery("UPDATE tbl_livehelp_conversation set view=1 where id=" . $sql["id"] . " and status='1'");
    }
    $sql = dquery("select *,\n    IF(adminid=0,name,(SELECT firstname from tbl_admin where id=adminid)) as firstname,\n    IF(adminid=0,'',(SELECT lastname from tbl_admin where id=adminid)) as lastname\n     from tbl_livehelp_conversation where md5(chatid)='" . $id . "' and status='2' and view='0'");
    while ($row = mysqli_fetch_assoc($sql)) {
        $buff[] = ["message" => $row["message"], "type" => "Conversation", "name" => $row["firstname"] . " " . $row["lastname"], "from" => $row["adminid"] != 0 ? "staff" : "client", "time" => date("h:i", $row["time"])];
        dquery("UPDATE tbl_livehelp_conversation set view=1 where id=" . $row["id"]);
    }
    foreach ($buff as $v) {
        if ($v["type"] == "notification") {
            echo "                <div class=\"msgwrapper staff\">  \n                    <table class=\"w-100\"><tr> \n                        <td class=\"w-100 text-left\">                                         \n                        <div class=\"message\">";
            echo nl2br($v["message"]);
            echo "</div>\n                        </td></tr>\n                    </table>\n                </div>                   \n            ";
        }
        if ($v["type"] == "Conversation") {
            if ($v["from"] == "staff") {
                echo "                <div class=\"msgwrapper ";
                echo $v["from"];
                echo "\">  \n                    <table class=\"w-100\"><tr><td style=\"vertical-align: bottom;\">\n                        <div class=\"t-icon\">";
                echo substr($v["name"], 0, 1);
                echo "</div>\n                    </td> <td class=\"pl-2 w-100 text-left\">                                         \n                        <div class=\"message\">  ";
                echo nl2br($v["message"]);
                echo "</div>\n                    </td></tr></table>\n                </div>                   \n            ";
            } else {
                echo "                <div class=\"msgwrapper ";
                echo $v["from"];
                echo "\">  \n                    <table class=\"w-100\"><tr>\n                    <td class=\"pr-1 w-100 text-right\">                                        \n                        <div class=\"message\">  ";
                echo nl2br($v["message"]);
                echo "</div>\n                    </td>\n                    </tr></table>\n                </div>                   \n            ";
            }
        }
    }
}

?>