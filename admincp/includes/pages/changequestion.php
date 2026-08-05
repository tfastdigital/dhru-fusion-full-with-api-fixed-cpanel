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
define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
if ($save) {
    checkDemoMode(false);
    foreach ($ids as $i) {
        $data["question"] = ${"que_" . $i};
        $db->update("tbl_security_question", $data, "id='" . $i . "'");
        $data = NULL;
    }
    echo "<div id='notification1' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
}
if ($qid) {
    if (!mysqli_num_rows(dquery("select id from tblUsers where question_id='" . $qid . "'"))) {
        dquery("DELETE FROM tbl_security_question WHERE id='" . $qid . "'");
    } else {
        echo "<div id='notification1' class='errorbox'>This security questions in use cant remove</div>";
    }
}
$templatedetail = dquery("select * from tbl_security_question");
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form method=\"post\" name=\"\" id=\"frsb\">\n    ";
echo generate_token("form");
echo "    <input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table  id=\"main_tbl\"  >\n<tbody>\n\n<tr class=\"adddatarow\">\n    <td>";
echo $LNG["id"];
echo "</td>\n    <td><input type=\"text\" style=\"width: 400px;\" name=\"question\" value=\"\" /> </td>\n    <td><input value=\"+ ";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"\n               onclick=\"SubmitForm ('#btnaddgroup','securityquestion','#frsb','#notification','true','#main_loader','main2.php?page=settinginvoice');\"/></td>\n</tr>\n";
while ($row = mysqli_fetch_assoc($templatedetail)) {
    echo "   <tr><td>";
    echo $row["id"];
    echo " <input type=\"hidden\" name=\"ids[]\" value=\"";
    echo $row["id"];
    echo "\" /></td>\n   <td><input type=\"text\" style=\"width: 500px;\" name=\"que_";
    echo $row["id"];
    echo "\" value=\"";
    echo $row["question"];
    echo "\" /></td>\n   <td>\n   <a onclick=\"return confirm('Are you sure want to remove security question?');\"\n      href=\"javascript: reloadcurrent('changequestion','1&qid=";
    echo $row["id"];
    echo "')\"\n      class=\"deletedata\"></a></td>\n   </tr>\n";
}
echo "</tbody>\n</table>\n<p class=\"fixedbtn\"><input type='submit' name='save' value=\"";
echo $LNG["save"];
echo "\" /></p>\n</form>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>