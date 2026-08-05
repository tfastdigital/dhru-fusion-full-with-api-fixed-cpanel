<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

error_reporting(0);
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../../comm.php";
if (isset($_POST["easymm"])) {
    $easymm = $_POST["easymm"];
    update_position(0, $easymm);
}
echo "Group save successfully";
function update_position($parent, $children)
{
    global $db;
    $i = 1;
    if (is_array($children)) {
        foreach ($children as $k => $v) {
            $id = (int) $children[$k]["id"];
            $data["mid"] = $parent;
            $data["display_order"] = $i;
            $db->update("tbl_product_group", $data, "id ='" . $id . "' ");
            if (isset($children[$k]["children"][0])) {
                update_position($id, $children[$k]["children"]);
            }
            $i++;
        }
    }
}

?>