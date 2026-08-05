<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"tabcontent\">\r\n";
include "client.head.php";
echo "<div id=\"notification\"></div>\r\n    <div>\r\n            <div id=\"content\" class=\"mt-1\">\r\n                <div id=\"content_padded\">\r\n                    <div  class=\"groupstabes\" >\r\n\r\n                        <form style=\"float: left;\" method=\"post\" id=\"frmsparam2\"  action=\"main2.php?page=blockmultipleclient\">\r\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\r\n<tbody>\r\n    <tr>\r\n    <td class=\"fieldarea\">\r\nNot login from : <input type=\"text\" id=\"date\" name=\"lastlogin\" value=\"";
echo $lastlogin;
echo "\" placeholder=\"yyyy-mm-dd\"  size=\"12\" value=\"\" class=\"datepicker\" autocomplete=\"off\" />\r\nCredit Less than : <input type=\"text\" name=\"credit\" size=\"5\" value=\"";
echo $credit;
echo "\" />\r\n        <label><input type=\"checkbox\" name=\"neverfund\" value=\"1\" ";
if ($neverfund) {
    echo "checked";
}
echo " />No ";
echo $LNG["transaction"];
echo "</label>&nbsp;&nbsp;&nbsp;\r\n        <label><input type=\"checkbox\" name=\"unverified\" value=\"1\" ";
if ($unverified) {
    echo "checked";
}
echo " />";
echo $LNG["account"];
echo " ";
echo $LNG["unverified"];
echo "</label>&nbsp;&nbsp;&nbsp;\r\n    </td>\r\n    <td>\r\n        <input type=\"submit\" class=\"btn btn-primary\" name=\"search\" value=\"Search\" />\r\n    </td>\r\n    </tr>\r\n</tbody>\r\n</table>\r\n                        </form>\r\n\r\n<form method=\"post\" id=\"frmblocker\">\r\n    ";
echo generate_token("form");
echo "\r\n    ";
if ($search && ($lastlogin || $credit != "" || $unverified || $neverfund)) {
    echo "        <input type=\"hidden\" name=\"lastlogin\" value=\"";
    echo $lastlogin;
    echo "\" />\r\n        <input type=\"hidden\" name=\"credit\" value=\"";
    echo $credit;
    echo "\" />\r\n        <input type=\"hidden\" name=\"unverified\" value=\"";
    echo $unverified;
    echo "\" />\r\n        <input type=\"hidden\" name=\"neverfund\" value=\"";
    echo $neverfund;
    echo "\" />\r\n\r\n        ";
    $where = "userstatus!=1";
    $reason = "";
    if ($lastlogin) {
        $time = time() - 2592000;
        $reason .= "Not Login From " . $lastlogin . "\n";
        $lastlogin = strtotime($lastlogin);
        $where .= " and cast(last_login as signed)<" . $lastlogin . " and cast(ac_create_dt as signed)<" . $time;
    }
    if ($credit != "") {
        $reason .= "Credit less than " . $credit . "\n";
        $where .= " and credit_left<=" . $credit;
    }
    if ($unverified) {
        $reason .= "Account Unverified\n";
        $where .= " and userstatus='2'";
    }
    if ($neverfund) {
        $reason .= "Never added Fund\n";
        $where .= " and (select count(id) from tbl_statement_user where uid=tblUsers.id limit 1)=0";
    }
    echo "        <textarea style=\"width: 100%; height: 300px;\">";
    $q = dquery("select *,(select code from tbl_currencies where id=default_currency) as code from tblUsers where " . $where);
    for ($blocked = 0; $r = mysqli_fetch_assoc($q); $blocked++) {
        echo $r["email"] . " | " . $r["first_name"] . " | " . $r["last_name"] . " | " . $r["credit_left"] . $r["code"] . " \n";
    }
    echo "</textarea><br/>\r\n         <div style=\"font-size: 18px;\">Total User Found : <strong>";
    echo $blocked;
    echo "</strong> <br/>\r\n             <table class=\"form\">\r\n                 <tr>\r\n                     <td  class=\"fieldlabel\">";
    echo $LNG["reason"];
    echo " :</td>\r\n                     <td  class=\"fieldarea\"><textarea name=\"reason\" cols=\"40\" rows=\"4\" >";
    echo $reason;
    echo "</textarea></td>\r\n                 </tr>\r\n                 <tr>\r\n                     <td></td>\r\n                     <td class=\"fieldare\">\r\n                         <input type=\"button\" class=\"btn btn-primary\"\r\n                                onclick=\"SubmitForm ('#btn','blockmultiple','#frmblocker','#notification','true','#main_loader');\"\r\n                                name=\"save\" value=\"Confrim & Block\" />\r\n                     </td>\r\n                 </tr>\r\n             </table>\r\n         </div>\r\n            ";
}
echo "\r\n</form>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n\r\n    </div>\r\n\r\n</div>\r\n";

?>