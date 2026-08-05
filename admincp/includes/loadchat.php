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
require_once "../../comm.php";
if (!$_SESSION["adminid"]) {
    exit;
}
$id = md5(preg_replace("/[^0-9a-zA-Z]/i", "", $id));
$buff = [];
if ($id) {
    if ($loadall == "true") {
        $query = "";
    } else {
        $query = " and adminview='0' ";
    }
    $sql = dquery("select *,\n    IF(adminid=0,name,(SELECT firstname from tbl_admin where id=adminid)) as firstname,\n    IF(adminid=0,'',(SELECT lastname from tbl_admin where id=adminid)) as lastname\n     from tbl_livehelp_conversation where md5(chatid)='" . $id . "' and status='2' " . $query . " ");
    while ($row = mysqli_fetch_assoc($sql)) {
        $buff[] = ["message" => $row["message"], "type" => "Conversation", "name" => $row["firstname"] . " " . $row["lastname"], "from" => $row["adminid"] != 0 ? "staff" : "client", "time" => date("h:i:s A", $row["time"])];
        dquery("UPDATE tbl_livehelp_conversation set adminview=1 where id=" . $row["id"]);
    }
    foreach ($buff as $v) {
        if ($v["type"] == "notification") {
            echo "<div>" . $v["message"] . "</div>";
        }
        if ($v["type"] == "Conversation") {
            if ($v["from"] == "client") {
                echo "                <div class=\"msgwrapper ";
                echo $v["from"];
                echo "\">  \n                    <table><tr><td>\n                        <div class=\"t-icon\">";
                echo substr($v["name"], 0, 1);
                echo "</div>\n                    </td> <td style=\"padding-left: 10px;width:100%\">               \n                        <div class=\"name\"><strong>";
                echo $v["name"];
                echo "</strong> <small style=\"font-size: 12px;\"> <i>";
                echo $v["time"];
                echo "</i></small> </div> \n                        <div class=\"message\">  ";
                echo nl2br($v["message"]);
                echo "</div>\n                    </td></tr></table>\n                </div>                   \n            ";
            } else {
                echo "                <div class=\"msgwrapper ";
                echo $v["from"];
                echo "\">  \n                    <table><tr><td style=\"padding-right: 10px;width:100%\">               \n                        <div class=\"name\"><strong>";
                echo $v["name"];
                echo "</strong> <small style=\"font-size: 12px;\"> <i>";
                echo $v["time"];
                echo "</i></small> </div> \n                        <div class=\"message\">  ";
                echo nl2br($v["message"]);
                echo "</div>\n                    </td>\n                    <td>\n                        <div class=\"t-icon\">";
                echo substr($v["name"], 0, 1);
                echo "</div>\n                    </td> </tr></table>\n                </div>                   \n            ";
            }
        }
    }
}

?>