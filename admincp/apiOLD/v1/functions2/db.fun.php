<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function updateData($table, $params, $where)
{
    global $conn;
    $query = "UPDATE " . $table . " SET";
    $answer = [];
    foreach ($params as $pname => $pvalue) {
        $query .= " " . $pname . "=?,";
        $answer[] = $pvalue;
    }
    $query = rtrim($query, ",");
    $query .= " WHERE " . $where;
    $sql = $conn->prepare($query);
    $sql->execute($answer);
}
function insertData($table, $params)
{
    global $conn;
    $query = "INSERT INTO " . $table . " (";
    foreach ($params as $pname => $pvalue) {
        $query .= " " . $pname . ",";
    }
    $query = rtrim($query, ",");
    $query .= ") VALUES (";
    foreach ($params as $pname => $pvalue) {
        $query .= " :" . $pname . ",";
    }
    $query = rtrim($query, ",");
    $query .= ")";
    $sql = $conn->prepare($query);
    foreach ($params as $pname => $pvalue) {
        $params[":" . $pname] = isset($pvalue) ? $pvalue : "";
    }
    $sql->execute($params);
    $id = $conn->lastInsertId();
    return $id;
}
function checkDuplicate($table, $column, $value)
{
    global $conn;
    if (is_array($column) && is_array($value)) {
        foreach ($column as $cokey => $col) {
            if ($value[$cokey]) {
                $WHERE .= " `" . $col . "`='" . $value[$cokey] . "' and";
            }
        }
        $WHERE = trim($WHERE, "and");
    } else {
        $WHERE = " `" . $column . "`='" . $value . "'";
    }
    $sql = $conn->query("SELECT * FROM `" . $table . "` where " . $WHERE);
    if ($sql->rowCount()) {
        return true;
    }
    return false;
}
function deleteRow($table, $where, $hard = false)
{
    global $conn;
    if ($where) {
        if ($hard) {
            deletedData($table, $where);
            if ($conn->query("DELETE FROM  " . $table . " WHERE " . $where)) {
                return true;
            }
            return false;
        }
        if ($conn->query("UPDATE  " . $table . " SET `deleted`=1 WHERE " . $where)) {
            return true;
        }
        return false;
    }
    return false;
}
function checkDeleted($table, $where)
{
    global $conn;
    $sql = $conn->query("SELECT *  FROM `" . $table . "` WHERE " . $where . "\r\n    and deleted='1'");
    if ($sql->rowCount()) {
        return true;
    }
    return false;
}
function deletedData($table, $where)
{
    global $conn;
    $que = $conn->query("SELECT * FROM " . $table . " WHERE " . $where);
    $row = $que->fetch(PDO::FETCH_ASSOC);
    $DATA["deleteddata"] = json_encode($row);
    $DATA["deletedtable"] = $table;
    $DATA["deletedcondition"] = $where;
    $DATA["deletedtime"] = time();
    $DATA["deleteddate"] = date("Y-m-d");
    insertdata("tblDeleted", $DATA);
}
function getData($field = "*", $table, $where = "", $orderby = "")
{
    global $conn;
    global $devmode;
    global $debugquery;
    $sql = $conn->query("SHOW COLUMNS FROM `" . $table . "` LIKE 'deleted';");
    if ($sql->rowCount()) {
        if ($where) {
            $where .= " and deleted=0";
        } else {
            $where .= " deleted=0";
        }
    } else {
        if ($where) {
            $where .= " and 1=1";
        } else {
            $where .= " 1=1";
        }
    }
    if ($debugquery) {
        echo "SELECT " . $field . " FROM " . $table . " WHERE " . $where . " " . $orderby;
    }
    $que = $conn->query("SELECT " . $field . " FROM " . $table . " WHERE " . $where . " " . $orderby);
    while ($row = $que->fetch(PDO::FETCH_ASSOC)) {
        if (!$devmode) {
            unset($row["password"]);
            unset($row["deleted"]);
        }
        $Retruns[] = $row;
    }
    return $Retruns;
}

?>