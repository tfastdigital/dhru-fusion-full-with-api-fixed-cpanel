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
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if (isset($_POST["easymm"])) {
    $easymm = $_POST["easymm"];
    $_SESSION["cnts"] = 0;
    $_SESSION["final"] = 0;
    update_position(0, $easymm);
}
echo "Menu position changed successfully";
function update_position($parent, $children)
{
    global $db;
    $i = 1;
    foreach ($children as $k => $v) {
        $id = (int) $children[$k]["id"];
        $_SESSION["cnts"] = $id;
        if ($parent != 0 && $id <= 1012) {
            $_SESSION["final"] = $id;
        } else {
            $data["groupid"] = $parent;
            $data["order"] = $i;
            $db->update("tbl_navigation", $data, "id ='" . $id . "' ");
            if (isset($children[$k]["children"][0])) {
                update_position($id, $children[$k]["children"]);
            }
        }
        $i++;
    }
}

?>