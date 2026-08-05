<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$DATA["access"] = 0;
updateData("tblAccess", $DATA, "accessgroupid='" . $ID . "'");
unset($DATA);
if ($ID == 1) {
    $FIxAccess["action"] = "access";
    $FIxAccess["method"] = "put";
    $FIxAccess["value"] = "1";
    $FIxAccess["days"] = "0";
    $BODY["accessarray"][] = $FIxAccess;
    $FIxAccess["action"] = "access";
    $FIxAccess["method"] = "get";
    $FIxAccess["value"] = "1";
    $FIxAccess["days"] = "0";
    $BODY["accessarray"][] = $FIxAccess;
}
foreach ($BODY["accessarray"] as $key => $input) {
    $DATA["access"] = $input["value"];
    $DATA["accessdays"] = $input["days"];
    $RETURN[$key] = updateAccess($DATA, $ID, $input["action"], $input["method"]);
}
function updateAccess($DATA, $groupid, $action, $method)
{
    global $conn;
    global $operationId;
    $cols[] = "accessgroupid";
    $cols[] = "action";
    $cols[] = "method";
    $vals[] = $groupid;
    $vals[] = $action;
    $vals[] = $method;
    if (checkDuplicate("tblAccess", $cols, $vals)) {
        updateData("tblAccess", $DATA, "accessgroupid='" . $groupid . "' and action='" . $action . "' and method='" . $method . "'");
    } else {
        $DATA["accessgroupid"] = $groupid;
        $DATA["action"] = $action;
        $DATA["method"] = $method;
        insertData("tblAccess", $DATA);
    }
    systemActivity($operationId, "Access updated " . $groupid, $groupid);
    $RETURN["status"] = "success";
    $RETURN["id"] = $groupid;
    $RETURN["msg"] = "Access Updated successfully";
    return $RETURN;
}

?>