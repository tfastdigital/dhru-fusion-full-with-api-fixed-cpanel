<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

foreach ($BODY["qntrangearraypost"] as $key => $input) {
    $RETURN = createRange($input);
}
function createRange($DATA)
{
    global $conn;
    global $remote_ip;
    $data["start"] = $DATA["start"];
    $data["end"] = $DATA["end"];
    $id = insertData("tbl_pricing_qnt", $data);
    $_RETURN["status"] = "success";
    $_RETURN["msg"] = "Range Created #" . $id;
    return $_RETURN;
}

?>