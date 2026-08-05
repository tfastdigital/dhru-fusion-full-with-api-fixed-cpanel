<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$query_count = 0;
function select_query($table, $fields, $where, $orderby = "", $orderbyorder = "", $limit = "", $innerjoin = "")
{
    global $query_count;
    global $mysqli_errors;
    global $db_conn2;
    if (!$fields) {
        $fields = "*";
    }
    $query = "SELECT " . $fields . " FROM " . $table;
    if ($innerjoin) {
        $query .= " INNER JOIN " . $innerjoin;
    }
    if ($where) {
        if (is_array($where)) {
            $query .= " WHERE";
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if ($value["sqltype"] == "LIKE") {
                        $query .= " " . $key . " LIKE '%" . descape($value["value"]) . "%' AND";
                    } else {
                        if ($value["sqltype"] == "NEQ") {
                            $query .= " " . $key . "!='" . descape($value["value"]) . "' AND";
                        } else {
                            if ($value["sqltype"] == ">") {
                                $query .= " " . $key . ">" . descape($value["value"]) . " AND";
                            } else {
                                if ($value["sqltype"] == "<") {
                                    $query .= " " . $key . "<" . descape($value["value"]) . " AND";
                                } else {
                                    if ($value["sqltype"] == "<=") {
                                        $query .= " " . $key . "<=" . descape($value["value"]) . " AND";
                                    } else {
                                        if ($value["sqltype"] == ">=") {
                                            $query .= " " . $key . ">=" . descape($value["value"]) . " AND";
                                        } else {
                                            if ($value["sqltype"] == "TABLEJOIN") {
                                                $query .= " " . $key . "=" . $value["value"] . " AND";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $query .= " " . $key . "='" . descape($value) . "' AND";
                }
            }
            $query = substr($query, 0, -4);
        } else {
            $query .= " WHERE " . $where;
        }
    }
    if ($orderby) {
        $query .= " ORDER BY `" . $orderby . "` " . $orderbyorder;
    }
    if ($limit) {
        $query .= " LIMIT " . $limit;
    }
    $result = dquery($query);
    if (!$result) {
        $message = "Invalid query: " . mysqli_error($db_conn2) . "<br>";
        $message .= "Whole query: " . $query;
        if ($mysqli_errors) {
            echo $message;
        }
    }
    $query_count++;
    return $result;
}
function descape($query)
{
    global $db_conn2;
    return mysqli_real_escape_string($db_conn2, $query);
}
function daffectedrow($conn = "")
{
    global $db_conn2;
    if ($conn) {
        $db_conn2 = $conn;
    }
    return mysqli_affected_rows($db_conn2);
}
function dquery($query, $conn = "", $priority = false)
{
    global $db_conn2;
    global $log;
    if ($conn) {
        $db_conn2 = $conn;
    }
    if ($log) {
        $log->QueryCnt++;
        if ($priority) {
            $log->Priority($query);
        } else {
            $log->Query($query);
        }
    }
    // mysqli_set_charset($db_conn2, "utf8");
    return mysqli_query($db_conn2, $query);
}
function updateFields($table, $data)
{
    global $db_conn2;
    $query_id = dquery("SHOW COLUMNS FROM " . $table, $db_conn2);
    $out = [];
    while ($row = mysqli_fetch_assoc($query_id)) {
        if (strpos($row["Type"], "int") !== false) {
            $flag = false;
            foreach ($data as $k => $v) {
                if ($k == $row["Field"] && ($v == NULL || $v == "")) {
                    $data[$k] = 0;
                }
                if ($k == $row["Field"]) {
                    $flag = true;
                }
            }
            if (!$flag) {
                $data[$row["Field"]] = 0;
            }
        } else {
            if (strpos($row["Type"], "decimal") !== false) {
                $flag = false;
                foreach ($data as $k => $v) {
                    if ($k == $row["Field"] && ($v == NULL || $v == "")) {
                        $data[$k] = 0;
                    }
                    if ($k == $row["Field"]) {
                        $flag = true;
                    }
                }
                if (!$flag) {
                    $data[$row["Field"]] = 0;
                }
            } else {
                $flag = false;
                foreach ($data as $k => $v) {
                    if ($k == $row["Field"]) {
                        $flag = true;
                    }
                }
                if (!$flag) {
                    $data[$row["Field"]] = "";
                }
            }
        }
    }
    return $data;
}
function updateFields2($table, $data)
{
    global $db_conn2;
    $query_id = dquery("SHOW COLUMNS FROM " . $table, $db_conn2);
    $out = [];
    while ($row = mysqli_fetch_assoc($query_id)) {
        if (strpos($row["Type"], "int") !== false) {
            $flag = false;
            foreach ($data as $k => $v) {
                if ($k == $row["Field"] && ($v == NULL || $v == "")) {
                    $data[$k] = 0;
                }
                if ($k == $row["Field"]) {
                    $flag = true;
                }
            }
        } else {
            if (strpos($row["Type"], "decimal") !== false) {
                $flag = false;
                foreach ($data as $k => $v) {
                    if ($k == $row["Field"] && ($v == NULL || $v == "")) {
                        $data[$k] = 0;
                    }
                    if ($k == $row["Field"]) {
                        $flag = true;
                    }
                }
            }
        }
    }
    return $data;
}
function update_query($table, $array, $where)
{
    global $query_count;
    global $mysqli_errors;
    global $db_conn2;
    global $MySqlStricktMode;
    if ($MySqlStricktMode) {
        $array = updatefields2($table, $array);
    }
    $query = "UPDATE " . $table . " SET ";
    foreach ($array as $key => $value) {
        $query .= "`" . $key . "`=";
        if ($value === "now()") {
            $query .= "'" . date("YmdHis") . "',";
        } else {
            if ($value === "+1") {
                $query .= "`" . $key . "`+1,";
            } else {
                if (substr($value, 0, 11) == "AES_ENCRYPT") {
                    $query .= "" . $value . ",";
                } else {
                    if ($value === "NULL") {
                        $query .= "NULL,";
                    } else {
                        $query .= "'" . descape($value) . "',";
                    }
                }
            }
        }
    }
    $query = substr($query, 0, -1);
    if (is_array($where)) {
        $query .= " WHERE";
        foreach ($where as $key => $value) {
            $query .= " " . $key . "='" . descape($value) . "' AND";
        }
        $query = substr($query, 0, -4);
    } else {
        if ($where) {
            $query .= " WHERE " . $where;
        }
    }
    $result = dquery($query, $db_conn2);
    if (!$result) {
        $message = "Invalid query: " . mysqli_error($db_conn2) . "<br>";
        $message .= "Whole query: " . $query;
        if ($mysqli_errors) {
            echo $message;
        }
    }
    $query_count++;
}
function insert_query($table, $array)
{
    global $query_count;
    global $mysqli_errors;
    global $db_conn2;
    global $MySqlStricktMode;
    if ($MySqlStricktMode) {
        $array = updatefields($table, $array);
    }
    $query = "INSERT INTO " . $table . " ";
    foreach ($array as $key => $value) {
        $fieldnamelist .= "`" . $key . "`,";
        if ($value === "now()") {
            $fieldvaluelist .= "'" . date("YmdHis") . "',";
        } else {
            if ($value === "NULL") {
                $fieldvaluelist .= "NULL,";
            } else {
                $fieldvaluelist .= "'" . descape($value) . "',";
            }
        }
    }
    $fieldnamelist = substr($fieldnamelist, 0, -1);
    $fieldvaluelist = substr($fieldvaluelist, 0, -1);
    $query .= "(" . $fieldnamelist . ") VALUES (" . $fieldvaluelist . ")";
    $result = dquery($query, $db_conn2);
    if (!$result) {
        $message = "Invalid query: " . mysqli_error($db_conn2) . "<br>";
        $message .= "Whole query: " . $query;
        if ($mysqli_errors) {
            echo $message;
        }
    }
    $query_count++;
    $id = mysqli_insert_id($db_conn2);
    return $id;
}
function delete_query($table, $where)
{
    global $query_count;
    global $mysqli_errors;
    global $db_conn2;
    $query = "DELETE FROM " . $table . " WHERE";
    if (is_array($where)) {
        foreach ($where as $key => $value) {
            $query .= " " . $key . "='" . descape($value) . "' AND";
        }
        $query = substr($query, 0, -4);
    } else {
        $query .= " " . $where;
    }
    $result = dquery($query, $db_conn2);
    if (!$result) {
        $message = "Invalid query: " . mysqli_error($db_conn2) . "<br>";
        $message .= "Whole query: " . $query;
        if ($mysqli_errors) {
            echo $message;
        }
    }
    $query_count++;
}
function full_query($query, $time = false, $orderby = "", $type = "single")
{
    global $query_count;
    global $mysqli_errors;
    global $debug;
    global $db_conn2;
    if ($time) {
        $query .= " (date between \n        '" . $_SESSION["startdate"] . "' and '" . $_SESSION["enddate"] . "')";
    }
    $query .= " " . $orderby;
    if ($debug) {
        echo $query;
        exit;
    }
    $result = dquery($query, $db_conn2);
    if (!$result) {
        $message = "Invalid query: " . mysqli_error($db_conn2) . "<br>";
        $message .= "Whole query: " . $query;
        if ($mysqli_errors) {
            echo "<div style='color:red'>" . $message . "</div>";
        }
    }
    $query_count++;
    if ($type == "single") {
        $result = mysqli_fetch_assoc($result);
        return $result == NULL ? false : $result;
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}
function db_escape_string($string)
{
    $string = descape($string);
    return $string;
}

?>