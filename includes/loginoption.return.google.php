<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include "google.class.php";
$googleLogin = GoogleOpenID::getResponse();
if ($googleLogin->success()) {
    $user_id = $googleLogin->identity();
    $user_email = $googleLogin->email();
    echo "Login Success : " . $user_email;
} else {
    echo "Login Faild";
}

?>