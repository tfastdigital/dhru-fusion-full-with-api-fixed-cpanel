<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">New Registered Users</a></li>\n</ul>\n";
$pageid = 330;
checkPagePermission($pageid);
if ($active) {
    checkDemoMode(false);
    include_once ROOTDIR . "/includes/mail.fun.php";
    foreach ($active as $key => $value) {
        $data["userstatus"] = "0";
        $data["is_registered"] = "1";
        $s = mysqli_fetch_assoc(dquery("select username from tblUsers where id='" . $key . "'"));
        $email_merge_fields["username"] = $s["username"];
        $email_merge_fields["password_uncrypt"] = "*HIDDEN*";
        $email_merge_fields["pin"] = "*HIDDEN*";
        sendMail(9, $key, "", $email_merge_fields, true);
        $db->update("tblUsers", $data, "id=" . $key);
    }
    $succcess = $LNG["user"] . " " . $LNG["active"] . " " . $LNG["successfully"];
}
if ($delete) {
    checkDemoMode(false);
    foreach ($delete as $key => $value) {
        dquery("delete from tblUsers where id=" . $key);
    }
    $succcess = $LNG["user"] . " " . $LNG["delete"] . " " . $LNG["successfully"];
}
if ($succcess) {
    echo "<div id=\"notification\" class=\"successbox\">";
    echo $succcess;
    echo "</div>\n";
}
echo " \n<div id=\"content\">\n<div id=\"content_padded\">\n<form action=\"\" method=\"post\">\n<table id=\"main_tbl\">\n       <thead><th>";
echo $LNG["id"];
echo "</th><th>";
echo $LNG["username"];
echo "</th><th>";
echo $LNG["email"];
echo "</th><th>";
echo $LNG["user"];
echo " ";
echo $LNG["type"];
echo "</th><th><div align=\"center\">";
echo $LNG["user"];
echo " ";
echo $LNG["status"];
echo "</div></th><th align=\"right\">Action</th></thead>            \n        ";
$result = dquery("SELECT * FROM `tblUsers` WHERE userstatus='2' and is_registered='0' ORDER BY `id`  DESC LIMIT 0 , 20");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row["userstatus"] == "0") {
            $status = "<span class=textgreen> " . $LNG["active"] . " </span>";
        } else {
            if ($row["userstatus"] == "1") {
                $status = "<span class=textred> " . $LNG["block"] . " </span>";
            } else {
                if ($row["userstatus"] == "2") {
                    $status = "<span class=textblue> " . $LNG["inactive"] . " </span>";
                }
            }
        }
        if ($row["usertype"] == "0" || $row["usertype"] == "2") {
            $type = $LNG["user"];
        } else {
            $type = "<span class=textblack> " . $LNG["reseller"] . " </span>";
        }
        echo "<tr><td>" . $row["id"] . "</td><td><a class=default_dg_a href=\"javascript:load_fromsubpage('edituser&id=" . $row["id"] . "','" . $row["username"] . "')\">" . $row["username"] . "</a></td><td>" . $row["email"] . "</td><td>" . $type . "</td><td align=center>" . $status . "</td><td align=right> \n<input type=submit name=active[" . $row["id"] . "]   class='btn btn-info' title='Active' value='Active' /><input type=submit class='button deletedata' title='Delete' name=delete[" . $row["id"] . "] value=" . $LNG["delete"] . " onclick='return confirm(\"Are you sure want to remove User ?\");' /></td></tr>";
    }
}
echo "       \n        </table>\n</form>        \n</div></div> ";
$fileverioncheck = "6.1.0";

?>