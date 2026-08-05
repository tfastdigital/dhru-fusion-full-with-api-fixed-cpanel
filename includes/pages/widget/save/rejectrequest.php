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
require_once "../../comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/mail.fun.php";
if ($action == 4 && $other == "") {
    echo "error: " . $lng_languag["fieldblank"];
    exit;
}
if (!isset($_SESSION["uid"])) {
    echo "error: Something Wrong #99821";
    exit;
}
$user = mysqli_fetch_assoc(dquery("select email,id,username from tblUsers where id='" . $_SESSION["uid"] . "'"));
$reasons = $reason == 1 ? "Wrong item ordered" : $reason == 2 ? "Wrong description online" : $reason == 3 ? "Do not like the product" : $reason == 4 ? "Can't get it to work" : $reason == 5 ? "Manufacturer defect or DOA" : $reason == 6 ? "Damaged during shipping" : "Wrong item sent";
$actions = $action == 1 ? "Send replacement if within warranty" : $action == 2 ? "Repair and ship back" : $action == 3 ? "Give me a credit for future purchase" : "Other";
$message = "Reason : " . $reasons . " <br />\n        Action : " . $actions . " <br />";
if ($action == 4) {
    $other = nl2br($other);
    $message .= "<br />Other : " . $other . " <br />";
}
if ($comment) {
    $comment = nl2br($comment);
    $message .= "Comment : " . $comment . " <br />";
}
$message .= "<br />Order Details <br />--------------------";
$order = mysqli_fetch_assoc(dquery("select order_id,service_id,invoiceid,requestsend, \n    ( select service_name from tbl_products \n    where id=service_id) as services  FROM tbl_order_product where md5(order_id)='" . $ids . "'"));
if ($order["requestsend"]) {
    echo "error: " . $lng_languag["request"] . " " . $lng_languag["sended"];
    exit;
}
$reason = preg_replace("/[^a-zA-Z0-9-,.\\s]/", "", $reason);
$action = preg_replace("/[^a-zA-Z0-9-,.\\s]/", "", $action);
$other = preg_replace("/[^a-zA-Z0-9-,.\\s]/", "", $other);
$comment = preg_replace("/[^a-zA-Z0-9-,.\\s]/", "", $comment);
$data["sendbyuid"] = $_SESSION["uid"];
$data["oid"] = $order["order_id"];
$data["date"] = date("Y-m-d");
$uni = rand(1, 250) . $order["order_id"] . rand(1, 250);
$data["uid"] = $uni;
$data["reason"] = $reason;
$data["action"] = $action;
$data["comment"] = $other . "<br />" . $comment;
$db->insert("tbl_return_request", $data);
$data = NULL;
$here = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("editreturn.request&id=" . $uni) . "&title=" . base64_encode("Return Request") . "'>here</a>";
$servicelink = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("editproduct&id=" . $order["service_id"]) . "&title=" . base64_encode("Edit Proudct") . "'>" . $order["services"] . "</a>";
$invoicelink = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("edituser.editinvoice&id=" . $order["invoiceid"]) . "&title=" . base64_encode("Edit Invoice - " . $order["invoiceid"]) . "'>" . $order["invoiceid"] . "</a>";
$userlink = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("edituser&id=" . $user["id"]) . "&title=" . base64_encode("Edit User") . "'>" . $user["username"] . "</a>";
$message .= " <br /> \n    Invoice ID : " . $invoicelink . "<br /> \n    Order ID : " . $order["order_id"] . " <br / > \n    Product : " . $servicelink . "<br /> \n    User : " . $userlink . " <br /><br />\n    Click " . $here . " to view return request";
sendNotification("system", "Return Request", $message, "", "", "", "", $user["email"]);
dquery("update tbl_order_product set requestsend='1' where order_id='" . $order["order_id"] . "'");
echo "success: " . $lng_languag["request"] . " " . $lng_languag["send"] . " " . $lng_languag["successfully"];

?>