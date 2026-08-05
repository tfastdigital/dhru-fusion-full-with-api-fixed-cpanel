<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($_ACCESS) {
    $q = dquery("SELECT tblUsers.id,first_name,last_name,email,country,credit_left,credit_used,code FROM tblUsers,tbl_currencies WHERE (tblUsers.default_currency=tbl_currencies.id)");
    while ($e = mysqli_fetch_assoc($q)) {
        $output[$e["id"]]["fname"] = $e["first_name"];
        $output[$e["id"]]["lname"] = $e["last_name"];
        $output[$e["id"]]["mail"] = $e["email"];
        $output[$e["id"]]["phone"] = $e["contact"];
        $output[$e["id"]]["contry"] = $e["country"];
        $output[$e["id"]]["credit"] = $e["credit_left"] + $e["credit_used"];
        $output[$e["id"]]["cur"] = $e["code"];
    }
    $_OUTPUT["DATA"] = $output;
} else {
    defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
    $search = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["search"]);
    $q = dquery("SELECT id,username FROM tblUsers WHERE username LIKE '" . $search . "%' limit 10");
    while ($e = mysqli_fetch_assoc($q)) {
        $output[]["username"] = $e["username"];
    }
    if (count($output) == 0) {
        $reply["STATUS"] = "ERROR";
    } else {
        $reply["STATUS"] = "SUCCESS";
    }
    $reply["DATA"] = $output;
    $reply["VERSION"] = $api_version;
    echo json_encode($reply);
}

?>