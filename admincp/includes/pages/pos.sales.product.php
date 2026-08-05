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
require_once "../../../comm.php";
require_once "../../../includes/fun.inc.php";
require_once "../../includes/fun.inc.php";
$search = $_POST["val"];
if ($getlast) {
    $u = mysqli_fetch_assoc(dquery("select id from tblUsers\n    order by id desc"));
    echo $u["id"];
    exit;
}
if ($groupselected) {
    $_SESSION["seleusers"] = $groupselected;
    unset($_SESSION["clgroup"]);
}
if ($multipleclient) {
    if ($multipleclient == "reset") {
        $result = dquery("select id,username,credit_left,email,(select code from tbl_currencies where \n    id=default_currency) as currency from tblUsers where (usertype=0 or usertype=1) ORDER BY username ASC");
        while ($row = mysqli_fetch_assoc($result)) {
        }
    } else {
        $result = dquery("select id,username,credit_left,email,(select code from tbl_currencies where \n    id=default_currency) as currency from tblUsers where (usertype=0 or usertype=1)\n    AND username LIKE '" . $multipleclient . "%' ORDER BY username ASC");
    }
    if (is_array($user) && in_array($row["id"], $user)) {
        echo "<option value=" . $row["id"] . " selected=selected> " . $row["username"] . " [" . $row["credit_left"] . " " . $row["currency"] . "] " . $row["email"] . " </option>";
    } else {
        echo "<option value=" . $row["id"] . "> " . $row["username"] . " [" . $row["credit_left"] . " " . $row["currency"] . "] " . $row["email"] . " </option>";
    }
}
if ($directorder && $directorder != "") {
    $result = dquery("select id,username,email\n        FROM tblUsers WHERE username LIKE '" . $directorder . "%'\n        ORDER BY username ASC");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li class='list' onclick='setValse(\"" . $row["email"] . "=" . $row["username"] . "=" . $row["id"] . "\");' \n            id='" . $row["email"] . "'>" . $row["username"] . "</li>";
    }
}
if ($clientgrp != "") {
    $result = dquery("select id,username,credit_left,email,(select code from tbl_currencies where \nid=default_currency) as currency from tblUsers where (usertype=0 or usertype=1)\nAND client_group='" . $clientgrp . "' ORDER BY username ASC");
    while ($row = mysqli_fetch_assoc($result)) {
        if (is_array($user) && in_array($row["id"], $user)) {
            echo "<option value=" . $row["id"] . " selected=selected> " . $row["username"] . " [" . $row["credit_left"] . " " . $row["currency"] . "] " . $row["email"] . " </option>";
        } else {
            echo "<option value=" . $row["id"] . "> " . $row["username"] . " [" . $row["credit_left"] . " " . $row["currency"] . "] " . $row["email"] . " </option>";
        }
    }
}
if ($search != "") {
    if ($client) {
        $sql = dquery("select id,username from tblUsers where \n        (username LIKE '" . $search . "%' or id='" . $search . "' or phonenumber LIKE '" . $search . "%')");
        while ($row = mysqli_fetch_assoc($sql)) {
            echo "<li><a style='text-decoration:none;' class='" . $row["id"] . "' onclick=setVLL1(" . $row["id"] . ")>" . $row["username"] . "</a></li>";
        }
    } else {
        $sql = dquery("select id,service_name\n             from tbl_products where service_name LIKE '" . $search . "%' and active='1' and bysupplier='0'");
        while ($row = mysqli_fetch_assoc($sql)) {
            echo "<li><a style='text-decoration:none;' class='" . $row["id"] . "' onclick='setVLL(" . $row["id"] . ")'>" . $row["service_name"] . "</a></li>";
        }
    }
}
$fileverioncheck = "6.1.0";

?>