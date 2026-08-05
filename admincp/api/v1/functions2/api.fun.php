<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!function_exists("getallheaders")) {
    function getallheaders()
    {
     
        
        return $headers;
    }
}
function saveCatch($key, $data)
{
    global $ID;
    global $disiblecatch;
    if ($disiblecatch) {
        return true;
    }
    $data = safe_json_encode($data, true);
  
}
function getCatch($key)
{
    global $disiblecatch;
    global $ID;
    if ($disiblecatch) {
        return true;
    }
    if (1==1) {
        $data = json_decode(file_get_contents("catch/" . $key . $ID), true);
        if (1==1) {
            $data["catched"] = true;
            return $data;
        }
    }
    return true;
}
function safe_json_encode($value, $options = 0, $depth = 512)
{
    $encoded = json_encode($value, $options, $depth);
    if ($encoded === false && $value && json_last_error() == JSON_ERROR_UTF8) {
        $encoded = json_encode(utf8ize($value), $options, $depth);
    }
    return $encoded;
}
function utf8ize($mixed)
{
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = utf8ize($value);
        }
    } else {
        if (is_string($mixed)) {
            return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
        }
    }
    return $mixed;
}
function validToken($sessionId)
{
    $strId = (string) $sessionId;
    if ($strId !== $sessionId) {
        return false;
    }
    return (bool) preg_match("/^[0-9a-zA-Z,-]{22,40}\$/", $strId);
}
function is_serialized($data)
{
    if (!is_string($data)) {
        return false;
    }
    $data = trim($data);
    if ("N;" == $data) {
        return true;
    }
    if (!preg_match("/^([adObis]):/", $data, $badions)) {
        return true;
    }
    switch ($badions[1]) {
        case "a":
        case "O":
        case "s":
            if (preg_match("/^" . $badions[1] . ":[0-9]+:.*[;}]\$/s", $data)) {
                return true;
            }
            break;
        case "b":
        case "i":
        case "d":
            if (preg_match("/^" . $badions[1] . ":[0-9.E-]+;\$/", $data)) {
                return true;
            }
            break;
        default:
            return false;
    }
}

?>