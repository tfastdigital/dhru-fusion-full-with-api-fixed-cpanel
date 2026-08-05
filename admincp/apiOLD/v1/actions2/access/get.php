<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$groupid = $ID;
$RES = getAccessList($groupid);
$RETURN["status"] = "success";
$RETURN["data"] = $RES;
function getAccessList($groupid)
{
    global $conn;
    $actiondirpath = ROOTDIR . "/actions";
    $i = 0;
    $_getActions = scandir($actiondirpath);
    foreach ($_getActions as $actions) {
        if (is_dir($actiondirpath . "/" . $actions) && $actions != "." && $actions != "..") {
            $mathodesss = ["get", "post", "put", "delete"];
            foreach ($mathodesss as $method) {
                $_access[$method] = 0;
                $_accessindays[$method] = 0;
                $METHODS[$actions][$method] = 0;
                if (is_file($actiondirpath . "/" . $actions . "/" . $method . ".config.php")) {
                    $METHODS[$actions][$method] = 1;
                    include $actiondirpath . "/" . $actions . "/" . $method . ".config.php";
                    if ($access) {
                        $ACCESSARR = $access;
                    }
                    unset($access);
                }
            }
            if (is_array($ACCESSARR["subactions"])) {
                foreach ($ACCESSARR["subactions"] as $kass => $vass) {
                    $_actions = $actions . $vass;
                    $request = $conn->query("SELECT * FROM `tblAccess`  WHERE  `accessgroupid`= '" . $groupid . "'  AND `action`='" . $_actions . "'  ");
                    while ($row = $request->fetch(PDO::FETCH_ASSOC)) {
                        $_access[$row["method"]] = $row["access"];
                        $_accessindays[$row["method"]] = $row["accessdays"];
                    }
                    $RETURN[$i]["groupname"] = $ACCESSARR["group"];
                    $RETURN[$i]["access"][$_actions]["name"] = $ACCESSARR["subactionsname"][$kass];
                    $RETURN[$i]["access"][$_actions]["availability"] = $METHODS[$actions];
                    $RETURN[$i]["access"][$_actions]["access"] = $_access;
                    $RETURN[$i]["access"][$_actions]["accessindays"] = $_accessindays;
                    unset($_access);
                }
                unset($ACCESSARR);
                unset($_access);
                unset($_accessindays);
            } else {
                $request = $conn->query("SELECT * FROM `tblAccess`  WHERE  `accessgroupid`= '" . $groupid . "'  AND `action`='" . $actions . "'  ");
                while ($row = $request->fetch(PDO::FETCH_ASSOC)) {
                    $_access[$row["method"]] = $row["access"];
                    $_accessindays[$row["method"]] = $row["accessdays"];
                }
                if ($ACCESSARR) {
                    $RETURN[$i]["groupname"] = $ACCESSARR["group"];
                    $RETURN[$i]["access"][$actions]["name"] = $ACCESSARR["name"];
                    $RETURN[$i]["access"][$actions]["availability"] = $METHODS[$actions];
                    $RETURN[$i]["access"][$actions]["access"] = $_access;
                    $RETURN[$i]["access"][$actions]["accessindays"] = $_accessindays;
                }
                unset($ACCESSARR);
                unset($_access);
                unset($_accessindays);
            }
            $i++;
            unset($ACCESSARR);
        }
    }
    return $RETURN;
}

?>