<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$tag = "Login";
$summary = "Authentication";
$description = "Authentication to system to get token";
$operationId = "loginStaff";
$parameters[] = ["name" => "username", "description" => "Username", "in" => "query", "required" => 1, "type" => "string", "default" => "admin", "minLength" => 4, "maxLength" => 20];
$parameters[] = ["name" => "password", "format" => "password", "description" => "Password", "in" => "query", "required" => 1, "type" => "string", "default" => "admin", "minLength" => 4, "maxLength" => 20];
$parameters[] = ["name" => "appid", "description" => "App ID", "in" => "query", "type" => "string", "default" => "web", "minLength" => 3, "maxLength" => 20];

?>