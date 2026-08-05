<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
define("AUTOREFRESH", true);
include "../../comm.php";
if (!$_SESSION["adminid"]) {
    exit;
}
if ($action == "chatrequest") {
    $sql = dquery("select * from tbl_livehelp_conversation WHERE status='0'");
    while ($row = mysqli_fetch_assoc($sql)) {
        $sql2 = dquery("select * from tbl_admin where (chatdepartment LIKE '%," . $row["department"] . ",%'\n                                                     or chatdepartment LIKE '" . $row["department"] . ",%'\n                                                     or chatdepartment LIKE '%," . $row["department"] . "'\n                                                     OR chatdepartment='" . $row["department"] . "'\n                                                     ) AND id='" . $_SESSION["adminid"] . "'");
        if (mysqli_num_rows($sql2)) {
            $buff[$row["id"]] = "<div class='bubble'> <i> Subject </i> :  " . $row["message"] . "   </div> <div> <i> From </i> : <strong>" . $row["name"] . "</strong> <i class='fa fa-envelope'> </i> " . $row["email"] . " </div>\n            <div class='btns'> <input type='button' class='btn btn-success' name='accept' value='Accept' onclick='acceptrequest(" . $row["id"] . ",\"" . $row["name"] . "\");' />&nbsp;\n            <input type='button' class='btn btn-danger' id='deny' name='deny[" . $row["id"] . "]' value='Reject' onclick='denyrequest(" . $row["id"] . ");'  /> </div>\n            ";
        }
    }
}
if ($action == "invite") {
    if ($msg == "null") {
        $msg = "";
    }
    $msg = nl2br($msg);
}
if ($action == "denyrequest") {
    dquery("update tbl_livehelp_conversation set status='10',view='0' where id='" . $id . "'");
}
if ($action == "acceptrequest") {
    dquery("update tbl_livehelp_conversation set status='1',view='0',adminid='" . $_SESSION["adminid"] . "',chatid=id where id='" . $id . "'");
}
if (is_array($buff)) {
    echo "<div class=\"chat-box\"><div class=\"chat-title\" onclick=\"\$('.chat-body').toggle();\">Chat Request</div><div class=\"chat-body\">";
    foreach ($buff as $k => $mess) {
        echo "<div id=\"alert_" . $k . "\">" . $mess . "</div>";
    }
    echo "</div></div>";
}
echo "\n ";

?>