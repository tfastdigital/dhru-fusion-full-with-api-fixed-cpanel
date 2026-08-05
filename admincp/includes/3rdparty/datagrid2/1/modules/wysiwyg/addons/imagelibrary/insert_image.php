<?php
/*
 *after.com
 * @ Release: 13/06/2023
 */

require "config.inc.php";
exit;
function GetPort()
{
    $port = "";
    if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") {
        $port = ":" . $_SERVER["SERVER_PORT"];
    }
    return $port;
}
function GetProtocol()
{
    $protocol = "http://";
    if (isset($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) != "off" || strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == "https") {
        $protocol = "https://";
    }
    return $protocol;
}
function GetServerName()
{
    $server = isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : "";
    $colon = strpos($server, ":");
    if (0 < $colon && $colon < strlen($server)) {
        $server = substr($server, 0, $colon);
    }
    return $server;
}

?>