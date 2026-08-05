<?php
/*
 *after.com
 * @ Release: 13/06/2023
 */

require_once PEAR_DIR . "DB/common.php";
/**
 * The methods PEAR DB uses to interact with PHP's fbsql extension
 * for interacting with FrontBase databases
 *
 * These methods overload the ones declared in DB_common.
 *
 * @category   Database
 * @package    DB
 * @author     Frank M. Kromann <frank@frontbase.com>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1997-2007 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.7.14RC1
 * @link       http://pear.php.net/package/DB
 * @since      Class functional since Release 1.7.0
 */
class DB_fbsql extends DB_common
{
    /**
     * The DB driver type (mysql, oci8, odbc, etc.)
     * @var string
     */
    public $phptype = "fbsql";
    /**
     * The database syntax variant to be used (db2, access, etc.), if any
     * @var string
     */
    public $dbsyntax = "fbsql";
    /**
     * The capabilities of this DB implementation
     *
     * The 'new_link' element contains the PHP version that first provided
     * new_link support for this DBMS.  Contains false if it's unsupported.
     *
     * Meaning of the 'limit' element:
     *   + 'emulate' = emulate with fetch row by number
     *   + 'alter'   = alter the query
     *   + false     = skip rows
     *
     * @var array
     */
    public $features = ["limit" => "alter", "new_link" => false, "numrows" => true, "pconnect" => true, "prepare" => false, "ssl" => false, "transactions" => true];
    /**
     * A mapping of native error codes to DB error codes
     * @var array
     */
    public $errorcode_map = NULL;
    /**
     * The raw database connection created by PHP
     * @var resource
     */
    public $connection = NULL;
    /**
     * The DSN information for connecting to a database
     * @var array
     */
    public $dsn = [];
    public function DB_fbsql()
    {
        $this->DB_common();
    }
    public function connect($dsn, $persistent = false)
    {
        if (!PEAR::loadExtension("fbsql")) {
            return $this->raiseError(DB_ERROR_EXTENSION_NOT_FOUND);
        }
        $this->dsn = $dsn;
        if ($dsn["dbsyntax"]) {
            $this->dbsyntax = $dsn["dbsyntax"];
        }
        $params = [$dsn["hostspec"] ? $dsn["hostspec"] : "localhost", $dsn["username"] ? $dsn["username"] : NULL, $dsn["password"] ? $dsn["password"] : NULL];
        $connect_function = $persistent ? "fbsql_pconnect" : "fbsql_connect";
        $ini = ini_get("track_errors");
        $php_errormsg = "";
        if ($ini) {
            $this->connection = call_user_func_array($connect_function, $params);
        } else {
            ini_set("track_errors", 1);
            $this->connection = call_user_func_array($connect_function, $params);
            ini_set("track_errors", $ini);
        }
        if (!$this->connection) {
            return $this->raiseError(DB_ERROR_CONNECT_FAILED, NULL, NULL, NULL, $php_errormsg);
        }
        if ($dsn["database"] && !fbsql_select_db($dsn["database"], $this->connection)) {
            return $this->fbsqlRaiseError();
        }
        return DB_OK;
    }
    public function disconnect()
    {
        $ret = fbsql_close($this->connection);
        $this->connection = NULL;
        return $ret;
    }
    public function simpleQuery($query)
    {
        $this->last_query = $query;
        $query = $this->modifyQuery($query);
        $result = fbsql_query($query . ";", $this->connection);
        if (!$result) {
            return $this->fbsqlRaiseError();
        }
        if ($this->_checkManip($query)) {
            return DB_OK;
        }
        return $result;
    }
    public function nextResult($result)
    {
        return fbsql_next_result($result);
    }
    public function fetchInto($result, &$arr, $fetchmode, $rownum = NULL)
    {
        if ($rownum !== NULL && !fbsql_data_seek($result, $rownum)) {
            return NULL;
        }
        if ($fetchmode & DB_FETCHMODE_ASSOC) {
            $arr = fbsql_fetch_array($result, FBSQL_ASSOC);
            if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE && $arr) {
                $arr = array_change_key_case($arr, CASE_LOWER);
            }
        } else {
            $arr = fbsql_fetch_row($result);
        }
        if (!$arr) {
            return NULL;
        }
        if ($this->options["portability"] & DB_PORTABILITY_RTRIM) {
            $this->_rtrimArrayValues($arr);
        }
        if ($this->options["portability"] & DB_PORTABILITY_NULL_TO_EMPTY) {
            $this->_convertNullArrayValuesToEmpty($arr);
        }
        return DB_OK;
    }
    public function freeResult($result)
    {
        return is_resource($result) ? fbsql_free_result($result) : false;
    }
    public function autoCommit($onoff = false)
    {
        if ($onoff) {
            $this->query("SET COMMIT TRUE");
        } else {
            $this->query("SET COMMIT FALSE");
        }
    }
    public function commit()
    {
        fbsql_commit($this->connection);
    }
    public function rollback()
    {
        fbsql_rollback($this->connection);
    }
    public function numCols($result)
    {
        $cols = fbsql_num_fields($result);
        if (!$cols) {
            return $this->fbsqlRaiseError();
        }
        return $cols;
    }
    public function numRows($result)
    {
        $rows = fbsql_num_rows($result);
        if ($rows === NULL) {
            return $this->fbsqlRaiseError();
        }
        return $rows;
    }
    public function affectedRows()
    {
        if ($this->_last_query_manip) {
            $result = fbsql_affected_rows($this->connection);
        } else {
            $result = 0;
        }
        return $result;
    }
    public function nextId($seq_name, $ondemand = true)
    {
        do {
            $seqname = $this->getSequenceName($seq_name);
            $repeat = 0;
            $this->pushErrorHandling(PEAR_ERROR_RETURN);
            $result = $this->query("SELECT UNIQUE FROM " . $seqname);
            $this->popErrorHandling();
            if ($ondemand && DB::isError($result) && $result->getCode() == DB_ERROR_NOSUCHTABLE) {
                $repeat = 1;
                $result = $this->createSequence($seq_name);
                if (DB::isError($result)) {
                    return $result;
                }
            } else {
                $repeat = 0;
            }
        } while (!$repeat);
        if (DB::isError($result)) {
            return $this->fbsqlRaiseError();
        }
        $result->fetchInto($tmp, DB_FETCHMODE_ORDERED);
        return $tmp[0];
    }
    public function createSequence($seq_name)
    {
        $seqname = $this->getSequenceName($seq_name);
        $res = $this->query("CREATE TABLE " . $seqname . " (id INTEGER NOT NULL," . " PRIMARY KEY(id))");
        if ($res) {
            $res = $this->query("SET UNIQUE = 0 FOR " . $seqname);
        }
        return $res;
    }
    public function dropSequence($seq_name)
    {
        return $this->query("DROP TABLE " . $this->getSequenceName($seq_name) . " RESTRICT");
    }
    public function modifyLimitQuery($query, $from, $count, $params = [])
    {
        if (DB::isManip($query) || $this->_next_query_manip) {
            return preg_replace("/^([\\s(])*SELECT/i", "\\1SELECT TOP(" . $count . ")", $query);
        }
        return preg_replace("/([\\s(])*SELECT/i", "\\1SELECT TOP(" . $from . ", " . $count . ")", $query);
    }
    public function quoteBoolean($boolean)
    {
        return $boolean ? "TRUE" : "FALSE";
    }
    public function quoteFloat($float)
    {
        return $this->escapeSimple(str_replace(",", ".", strval(floatval($float))));
    }
    public function fbsqlRaiseError($errno = NULL)
    {
        if ($errno === NULL) {
            $errno = $this->errorCode(fbsql_errno($this->connection));
        }
        return $this->raiseError($errno, NULL, NULL, NULL, fbsql_error($this->connection));
    }
    public function errorNative()
    {
        return fbsql_errno($this->connection);
    }
    public function tableInfo($result, $mode = NULL)
    {
        if (is_string($result)) {
            $id = fbsql_list_fields($this->dsn["database"], $result, $this->connection);
            $got_string = true;
        } else {
            if (isset($result->result)) {
                $id = $result->result;
                $got_string = false;
            } else {
                $id = $result;
                $got_string = false;
            }
        }
        if (!is_resource($id)) {
            return $this->fbsqlRaiseError(DB_ERROR_NEED_MORE_DATA);
        }
        if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE) {
            $case_func = "strtolower";
        } else {
            $case_func = "strval";
        }
        $count = fbsql_num_fields($id);
        $res = [];
        if ($mode) {
            $res["num_fields"] = $count;
        }
        for ($i = 0; $i < $count; $i++) {
            $res[$i] = ["table" => $case_func(fbsql_field_table($id, $i)), "name" => $case_func(fbsql_field_name($id, $i)), "type" => fbsql_field_type($id, $i), "len" => fbsql_field_len($id, $i), "flags" => fbsql_field_flags($id, $i)];
            if ($mode & DB_TABLEINFO_ORDER) {
                $res["order"][$res[$i]["name"]] = $i;
            }
            if ($mode & DB_TABLEINFO_ORDERTABLE) {
                $res["ordertable"][$res[$i]["table"]][$res[$i]["name"]] = $i;
            }
        }
        if ($got_string) {
            fbsql_free_result($id);
        }
        return $res;
    }
    public function getSpecialQuery($type)
    {
        switch ($type) {
            case "tables":
                return "SELECT \"table_name\" FROM information_schema.tables t0, information_schema.schemata t1 WHERE t0.schema_pk=t1.schema_pk AND \"table_type\" = 'BASE TABLE' AND \"schema_name\" = current_schema";
                break;
            case "views":
                return "SELECT \"table_name\" FROM information_schema.tables t0, information_schema.schemata t1 WHERE t0.schema_pk=t1.schema_pk AND \"table_type\" = 'VIEW' AND \"schema_name\" = current_schema";
                break;
            case "users":
                return "SELECT \"user_name\" from information_schema.users";
                break;
            case "functions":
                return "SELECT \"routine_name\" FROM information_schema.psm_routines t0, information_schema.schemata t1 WHERE t0.schema_pk=t1.schema_pk AND \"routine_kind\"='FUNCTION' AND \"schema_name\" = current_schema";
                break;
            case "procedures":
                return "SELECT \"routine_name\" FROM information_schema.psm_routines t0, information_schema.schemata t1 WHERE t0.schema_pk=t1.schema_pk AND \"routine_kind\"='PROCEDURE' AND \"schema_name\" = current_schema";
                break;
        }
    }
}

?>