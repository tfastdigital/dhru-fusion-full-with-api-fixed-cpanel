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
if ($ebaycode) {
    $data["ebay_code"] = $ebaycode;
}
$data["active"] = $status;
$data["pos"] = $pos;
$data["bundle"] = $bundle;
$data["service_name"] = $servicename;
$data["group_id"] = $groupname;
$data["customhtml"] = $customhtml;
$row = mysqli_fetch_assoc(dquery("select credit from tbl_products where id=" . $id));
$data["prev_price"] = $row["credit"];
$data["credit"] = formatCurrency2($credit);
$data["time"] = $time1 . " " . $timeref;
$data["availability_date"] = $availability_date;
$data["hot"] = $hot;
$data["taxed"] = $taxed;
$data["callforpricing"] = $callfrpricing;
$data["usercan_cancel"] = $cancel;
$data["viewer"] = $viewer;
$data["zeropriceaction"] = $zeropriceaction;
$data["outofstock"] = $outofstock;
$data["maxqnt"] = $maxqnt;
$data["minqnt"] = $minqnt;
$data["review"] = $review;
$data["draw"] = $draw;
$data["nav_icon"] = $nav_icon;
$data["return_days"] = $return_days;
$data["show_onhome"] = $showhomepage;
$data["daily_deal"] = $daily_deal;
$data["product_type"] = $product_type;
$data["affiliate_comission"] = $affiliate_comission;
if ($row["credit"] != $credit) {
    $success = $LNG["credit"] . " " . $LNG["changed"] . " " . $LNG["resetdiscount"];
    $success .= "<li>" . $LNG["please"] . "  " . $LNG["manage"] . " " . $LNG["other"] . " " . $LNG["currency"] . " </li>";
}
if ($download_check) {
    $data["download_link"] = $downloadlink;
} else {
    $data["download_link"] = "";
}
$data["faq_id"] = $faq;
$data["virtual"] = $virtual;
$data["freeship"] = $virtual;
$data["notification_mail"] = $notificationmail;
$data["template_id1"] = $template1;
$data["template_id2"] = $template2;
$data["sku"] = $sku;
$data["ean"] = $ean;
if ($db->update("tbl_products", $data, "id=" . $id)) {
    echo "success:<li>" . $LNG["datasavesuccessfully"] . "</li><li>" . $success . "</li>";
} else {
    echo "error:" . $LNG["datanotsave"];
}

?>