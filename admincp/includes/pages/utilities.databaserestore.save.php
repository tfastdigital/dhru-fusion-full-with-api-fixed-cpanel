<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($save_token != sha1(session_id() . $_SESSION["adminid"] . ":SaveMe123122sds2")) {
    exit("error:invalid token");
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
$time = date("Y-M-d-h-i-s", time());
$myFile = "../includes/backup/" . $time . "_Current_Backup_Before_Restore.sql";
$fh = fopen($myFile, "w+") or exit("can't open file");
$database = mysqli_fetch_assoc(dquery("SELECT database() as db"));
$result = dquery("SHOW TABLE STATUS FROM " . $database["db"]);
while ($tablename = mysqli_fetch_assoc($result)) {
    $result1 = dquery("select * from " . $tablename["Name"]);
    while ($row = mysqli_fetch_assoc($result1)) {
        $insert = "insert into " . $tablename["Name"] . " values (";
        foreach ($row as $value) {
            $value = str_replace("\"", "\\\"", $value);
            $value = str_replace("'", "''", $value);
            $insert .= "'" . $value . "',";
        }
        $insert .= ");\n";
        $insert = str_replace(",)", ")", $insert);
        fwrite($fh, $insert);
    }
}
fclose($fh);
$result_t = dquery("SHOW TABLES");
while ($row = mysqli_fetch_assoc($result_t)) {
    dquery("TRUNCATE " . $row[0]);
}
$myFile = "../includes/backup/" . $Item;
$file = fopen($myFile, "r") or exit("can't open file");
$flag = false;
$query = "";
while (!feof($file)) {
    $insert = fgets($file);
    if (!preg_match("/^insert.*'\\);\$/", $insert, $match)) {
        $query .= $insert;
        if (preg_match("/.*'\\);\$/", $insert, $match)) {
            dquery($query);
            $query = "";
        }
    } else {
        dquery($insert);
    }
}
fclose($file);
echo "success:" . $LNG["data"] . " " . $LNG["restore"] . " " . $LNG["successfully"];

?>