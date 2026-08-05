<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

global $apiConfig;
$apiConfig = ["use_objects" => false, "application_name" => "", "oauth2_client_id" => "", "oauth2_client_secret" => "", "oauth2_redirect_uri" => "", "developer_key" => "", "site_name" => "www.example.org", "authClass" => "Google_OAuth2", "ioClass" => "Google_CurlIO", "cacheClass" => "Google_FileCache", "basePath" => "https://www.googleapis.com", "ioFileCache_directory" => function_exists("sys_get_temp_dir") ? sys_get_temp_dir() . "/Google_Client" : "/tmp/Google_Client", "services" => ["analytics" => ["scope" => "https://www.googleapis.com/auth/analytics.readonly"], "calendar" => ["scope" => ["https://www.googleapis.com/auth/calendar", "https://www.googleapis.com/auth/calendar.readonly"]], "books" => ["scope" => "https://www.googleapis.com/auth/books"], "latitude" => ["scope" => ["https://www.googleapis.com/auth/latitude.all.best", "https://www.googleapis.com/auth/latitude.all.city"]], "moderator" => ["scope" => "https://www.googleapis.com/auth/moderator"], "oauth2" => ["scope" => ["https://www.googleapis.com/auth/userinfo.profile", "https://www.googleapis.com/auth/userinfo.email"]], "plus" => ["scope" => "https://www.googleapis.com/auth/plus.me"], "siteVerification" => ["scope" => "https://www.googleapis.com/auth/siteverification"], "tasks" => ["scope" => "https://www.googleapis.com/auth/tasks"], "urlshortener" => ["scope" => "https://www.googleapis.com/auth/urlshortener"]]];

?>