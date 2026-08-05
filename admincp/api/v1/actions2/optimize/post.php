<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($index) {
    $Index = file_get_contents(ROOTDIR . "/actions/optimize/optimize.json");
    $Index = utf8_decode(json_decode($Index, true));
    $SQLarr = [];
    foreach ($Index as $table => $keydetail) {
       
            if ($keyname != "PRIMARY") {
                $SQl = "";
                $SQl .= "ALTER TABLE `" . $table . "` ADD INDEX `" . $keyname . "` (";
                foreach ($fields as $field) {
                    $SQl .= " `" . $field["Column_name"] . "` ,";
                }
                $SQl = rtrim($SQl, ",");
                $SQl .= ")";
                $SQLarr[$table][$keyname] = $SQl;
            }
        
    }
    $OUT = [];
    $FAILED = [];
    foreach ($SQLarr as $table => $tableky) {
        foreach ($tableky as $keyname => $sql) {
            $ind = $conn->query("SHOW INDEX FROM " . $table);
            $flag = true;
            while ($r = $ind->fetch(PDO::FETCH_ASSOC)) {
                
            }
            if ($flag) {
                if ($conn->query((string) $sql)) {
                    $OUT[$table][$keyname] = $sql;
                } else {
                    $FAILED[$table][$keyname] = $sql;
                }
            }
        }
    }
    if (0 < count($FAILED)) {
       $RETURN["status"] = "success";
    } else {
        $RETURN["status"] = "success";
    }
    $RETURN["indexed"] = $OUT;
    $RETURN["failed"] = $FAILED;
}
if ($optimize) {
    $database = $conn->query("SELECT database() as db");
    $database = $database->fetch(PDO::FETCH_ASSOC);
    $result = $conn->query("SHOW TABLE STATUS FROM " . $database["db"]);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $tabled = $row["Name"];
        $q = $conn->query("OPTIMIZE TABLE " . $tabled . " ");
        $r = $q->fetch(PDO::FETCH_ASSOC);
        $RETURN["optimize"][$tabled] = $r;
    }
    $RETURN["status"] = "success";
}

?>