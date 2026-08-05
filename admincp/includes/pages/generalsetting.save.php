<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($save_token != sha1(session_id() . $_SESSION["adminid"] . ":SaveMe123122sds2")) {
    exit("error:invalid token");
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
$_POST["otherhtmlcode"] = base64_encode($_POST["otherhtmlcode"]);
dquery("UPDATE tbl_navigation SET display=IF(id=1," . $blog . ",IF(id=2," . $testimonial . ",IF(id=3," . $faq . ",IF(id=4," . $contactus . ",1)))) WHERE id<5");
unset($_POST["otherhtmlcode"]);
if ($_POST["fundtax"]) {
    $_POST["AddFunds_taxenabled"] = 1;
} else {
    $_POST["AddFunds_taxenabled"] = 0;
}
if (!is_numeric($_POST["adminlistlimit"])) {
    $_POST["adminlistlimit"] = "";
} else {
    $_POST["adminlistlimit"] = round($_POST["adminlistlimit"]);
}
if ($_POST["addfund"]) {
    $_POST["addfund"] = 1;
} else {
    $_POST["addfund"] = 0;
}
if ($_POST["installapp"]) {
    $_POST["installapp"] = 0;
} else {
    $_POST["installapp"] = 1;
}
if ($_POST["cms_seofriendly"]) {
    $_POST["cms_seofriendly"] = "on";
} else {
    $_POST["cms_seofriendly"] = "off";
}
if ($_POST["gravatar"]) {
    $_POST["gravatar"] = 1;
} else {
    $_POST["gravatar"] = 0;
}
if ($_POST["faster_browsing_mode"]) {
    $_POST["faster_browsing_mode"] = 1;
} else {
    $_POST["faster_browsing_mode"] = 0;
}
if ($_POST["voucher"]) {
    $_POST["voucher"] = 1;
} else {
    $_POST["voucher"] = 0;
}
if ($_POST["testimonial"]) {
    $_POST["testimonial"] = 1;
    dquery("update tbl_navigation set display='1' where id=1002");
} else {
    $_POST["testimonial"] = 0;
    dquery("update tbl_navigation set display='0' where id=1002");
}
if ($_POST["trackorder"]) {
    $_POST["trackorder"] = 1;
    dquery("update tbl_navigation set display='1' where id=1013");
} else {
    $_POST["trackorder"] = 0;
    dquery("update tbl_navigation set display='0' where id=1013");
}
if ($_POST["downloads"]) {
    $_POST["downloads"] = 1;
    dquery("update tbl_navigation set display='1' where id=1014");
} else {
    $_POST["downloads"] = 0;
    dquery("update tbl_navigation set display='0' where id=1014");
}
if ($_POST["blog"]) {
    $_POST["blog"] = 1;
    dquery("update tbl_navigation set display='1' where id=1001");
} else {
    $_POST["blog"] = 0;
    dquery("update tbl_navigation set display='0' where id=1001");
}
if ($_POST["mail_history"]) {
    $_POST["mail_history"] = 1;
} else {
    $_POST["mail_history"] = 0;
}
if ($_POST["captchaoncontact"]) {
    $_POST["captchaoncontact"] = 1;
} else {
    $_POST["captchaoncontact"] = 0;
}
if ($_POST["config_recent_menu"]) {
    $_POST["config_recent_menu"] = 1;
} else {
    $_POST["config_recent_menu"] = 0;
}
if ($_POST["ccdetails"]) {
    $_POST["ccdetails"] = 0;
} else {
    $_POST["ccdetails"] = 1;
}
if ($_POST["quicknews"]) {
    $_POST["quicknews"] = 1;
} else {
    $_POST["quicknews"] = 0;
}
if ($_POST["faq"]) {
    $_POST["faq"] = 1;
    dquery("update tbl_navigation set display='1' where id=1003");
} else {
    $_POST["faq"] = 0;
    dquery("update tbl_navigation set display='0' where id=1003");
}
if ($_POST["supportticketservice"]) {
    $_POST["supportticketservice"] = 1;
} else {
    $_POST["supportticketservice"] = 0;
}
if ($_POST["eucookielaw"]) {
    $_POST["eucookielaw"] = 1;
} else {
    $_POST["eucookielaw"] = 0;
}
if ($_POST["displayprice"]) {
    $_POST["displayprice"] = 1;
} else {
    $_POST["displayprice"] = 0;
}
if ($_POST["facebooklike"]) {
    $_POST["facebooklike"] = 1;
} else {
    $_POST["facebooklike"] = 0;
}
if ($_POST["googlelike"]) {
    $_POST["googlelike"] = 1;
} else {
    $_POST["googlelike"] = 0;
}
if ($_POST["affiliate"]) {
    $_POST["affiliate"] = 1;
} else {
    $_POST["affiliate"] = 0;
}
if ($_POST["wikihelp"]) {
    $_POST["wikihelp"] = 1;
} else {
    $_POST["wikihelp"] = 0;
}
if ($_POST["litedashboard"]) {
    $_POST["litedashboard"] = 1;
} else {
    $_POST["litedashboard"] = 0;
}
if ($_POST["giftcerti"]) {
    $_POST["giftcerti"] = 1;
} else {
    $_POST["giftcerti"] = 0;
}
if ($_POST["giftvoucher_tax"]) {
    $_POST["giftvoucher_tax"] = 1;
} else {
    $_POST["giftvoucher_tax"] = 0;
}
if ($_POST["withdrawal_req"]) {
    $_POST["withdrawal_req"] = 1;
} else {
    $_POST["withdrawal_req"] = 0;
}
if ($_POST["AddFundsMinimum"] != "" && !is_numeric($_POST["AddFundsMinimum"])) {
    echo "error: Invalid value for Minimum Add Fund";
    exit;
}
if ($_POST["AddFundsMaximum"] != "" && !is_numeric($_POST["AddFundsMaximum"])) {
    echo "error: Invalid value for Maximum Add Fund";
    exit;
}
if ($_POST["AddFundsMaximumBalance"] != "" && !is_numeric($_POST["AddFundsMaximumBalance"])) {
    echo "error: Invalid value for Add Fund balance";
    exit;
}
foreach ($_POST as $key => $v) {
    saveSettings($key, $v);
}
echo "success:  " . $LNG["datasavesuccessfully"];

?>