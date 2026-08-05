<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include "google.class.php";
$association_handle = GoogleOpenID::getAssociationHandle();
$googleLogin = GoogleOpenID::createRequest("ver5x/includes/loginoption.return.google.php", $association_handle, true);
$googleLogin->redirect();

?>