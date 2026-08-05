<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
foreach ($_GET as $k => $v) {
    ${$k} = $v;
}
foreach ($_POST as $k => $v) {
    ${$k} = $v;
}
exit;
class no
{
}
function getTableStructure($table)
{
    $result1 = dquery("select * from " . $table);
    while ($row = mysqli_fetch_assoc($result1)) {
        $insert = "INSERT IGNORE INTO " . $table . " values (";
        foreach ($row as $value) {
            $value = str_replace("\"", "\\\"", $value);
            $value = str_replace("'", "''", $value);
            $insert .= "'" . $value . "',";
        }
        $insert .= ");\n";
        $insert = str_replace(",)", ")", $insert);
    }
    return $insert;
}

?>