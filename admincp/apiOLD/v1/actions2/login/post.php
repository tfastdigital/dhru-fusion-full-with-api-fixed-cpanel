<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$_include = "init,qntrange";
include_once "_autoload.php";
unset($_SESSION);
exit;
function loginAdmin($username, $password, $appid = "", $card = "")
{
    global $conn;
    global $operationId;
    global $devmode;
    global $remote_ip;
    
    $card = encryptPassword($card);
    $request = $conn->query("SELECT *    FROM `tbl_admin`  WHERE           (`username`='" . $username . "' and `password`='" . $password . "')");
    $user = $request->fetch(PDO::FETCH_ASSOC);
    if (!$user["id"]) {
        $_RETURN["status"] = "error";
        $_RETURN["msg"] = "invalid login credentials";
    } else {
        unset($user["password"]);
        $_SESSION["adminprofile"] = $user;
        $_SESSION["admin_language"] = $user["language"];
        $_SESSION["adminid"] = $user["id"];
        $_SESSION["accessgroupid"] = 1;
        $_RETURN = $user;
        $_RETURN["session"] = $_SESSION;
        $ADATA["username"] = $username;
        $ADATA["userid"] = $user["id"];
        $ADATA["ip"] = $remote_ip;
        $ADATA["time"] = time();
        insertData("tbl_loginlog_admin", $ADATA);
        $_RETURN["token"] = session_id();
        $_RETURN["init"] = init();
        $_RETURN["status"] = "success";
    }
    return $_RETURN;
}

?>