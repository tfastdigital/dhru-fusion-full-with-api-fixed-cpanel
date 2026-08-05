<?php
/*
 *after.com
 * @ Release: 13/06/2023
 */

require_once PEAR_DIR . "DB/common.php";
/**
 * The methods PEAR DB uses to interact with PHP's mssql extension
 * for interacting with Microsoft SQL Server databases
 *
 * These methods overload the ones declared in DB_common.
 *
 * DB's mssql driver is only for Microsfoft SQL Server databases.
 *
 * If you're connecting to a Sybase database, you MUST specify "sybase"
 * as the "phptype" in the DSN.
 *
 * This class only works correctly if you have compiled PHP using
 * --with-mssql=[dir_to_FreeTDS].
 *
 * @category   Database
 * @package    DB
 * @author     Sterling Hughes <sterling@php.net>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1997-2007 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.7.14RC1
 * @link       http://pear.php.net/package/DB
 */
class DB_mssql extends DB_common
{
    /**
     * The DB driver type (mysql, oci8, odbc, etc.)
     * @var string
     */
    public $phptype = "mssql";
    /**
     * The database syntax variant to be used (db2, access, etc.), if any
     * @var string
     */
    public $dbsyntax = "mssql";
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
    public $features = ["limit" => "emulate", "new_link" => false, "numrows" => true, "pconnect" => true, "prepare" => false, "ssl" => false, "transactions" => true];
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
    /**
     * Should data manipulation queries be committed automatically?
     * @var bool
     * @access private
     */
    public $autocommit = true;
    /**
     * The quantity of transactions begun
     *
     * {@internal  While this is private, it can't actually be designated
     * private in PHP 5 because it is directly accessed in the test suite.}}
     *
     * @var integer
     * @access private
     */
    public $transaction_opcount = 0;
    /**
     * The database specified in the DSN
     *
     * It's a fix to allow calls to different databases in the same script.
     *
     * @var string
     * @access private
     */
    public $_db = NULL;
    public function DB_mssql()
    {
        $this->DB_common();
    }
    public function connect($dsn, $persistent = false)
    {
        if (!PEAR::loadExtension("mssql") && !PEAR::loadExtension("sybase") && !PEAR::loadExtension("sybase_ct")) {
            return $this->raiseError(DB_ERROR_EXTENSION_NOT_FOUND);
        }
        $this->dsn = $dsn;
        if ($dsn["dbsyntax"]) {
            $this->dbsyntax = $dsn["dbsyntax"];
        }
        $params = [$dsn["hostspec"] ? $dsn["hostspec"] : "localhost", $dsn["username"] ? $dsn["username"] : NULL, $dsn["password"] ? $dsn["password"] : NULL];
        if ($dsn["port"]) {
            $params[0] .= (substr(PHP_OS, 0, 3) == "WIN" ? "," : ":") . $dsn["port"];
        }
        $connect_function = $persistent ? "mssql_pconnect" : "mssql_connect";
        $this->connection = @call_user_func_array($connect_function, $params);
        if (!$this->connection) {
            return $this->raiseError(DB_ERROR_CONNECT_FAILED, NULL, NULL, NULL, @mssql_get_last_message());
        }
        if ($dsn["database"]) {
            if (!@mssql_select_db($dsn["database"], $this->connection)) {
                return $this->raiseError(DB_ERROR_NODBSELECTED, NULL, NULL, NULL, @mssql_get_last_message());
            }
            $this->_db = $dsn["database"];
        }
        return DB_OK;
    }
    public function disconnect()
    {
        $ret = @mssql_close($this->connection);
        $this->connection = NULL;
        return $ret;
    }
    public function simpleQuery($query)
    {
        $ismanip = $this->_checkManip($query);
        $this->last_query = $query;
        if (!@mssql_select_db($this->_db, $this->connection)) {
            return $this->mssqlRaiseError(DB_ERROR_NODBSELECTED);
        }
        $query = $this->modifyQuery($query);
        if (!$this->autocommit && $ismanip) {
            if ($this->transaction_opcount == 0) {
                $result = @mssql_query("BEGIN TRAN", $this->connection);
                if (!$result) {
                    return $this->mssqlRaiseError();
                }
            }
            $this->transaction_opcount++;
        }
        $result = @mssql_query($query, $this->connection);
        if (!$result) {
            return $this->mssqlRaiseError();
        }
        return $ismanip ? DB_OK : $result;
    }
    public function nextResult($result)
    {
        return @mssql_next_result($result);
    }
    public function fetchInto($result, &$arr, $fetchmode, $rownum = NULL)
    {
        if ($rownum !== NULL && !@mssql_data_seek($result, $rownum)) {
            return NULL;
        }
        if ($fetchmode & DB_FETCHMODE_ASSOC) {
            $arr = @mssql_fetch_assoc($result);
            if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE && $arr) {
                $arr = array_change_key_case($arr, CASE_LOWER);
            }
        } else {
            $arr = @mssql_fetch_row($result);
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
        return is_resource($result) ? mssql_free_result($result) : false;
    }
    public function numCols($result)
    {
        $cols = @mssql_num_fields($result);
        if (!$cols) {
            return $this->mssqlRaiseError();
        }
        return $cols;
    }
    public function numRows($result)
    {
        $rows = @mssql_num_rows($result);
        if ($rows === false) {
            return $this->mssqlRaiseError();
        }
        return $rows;
    }
    public function autoCommit($onoff = false)
    {
        $this->autocommit = $onoff ? true : false;
        return DB_OK;
    }
    public function commit()
    {
        if (0 < $this->transaction_opcount) {
            if (!@mssql_select_db($this->_db, $this->connection)) {
                return $this->mssqlRaiseError(DB_ERROR_NODBSELECTED);
            }
            $result = @mssql_query("COMMIT TRAN", $this->connection);
            $this->transaction_opcount = 0;
            if (!$result) {
                return $this->mssqlRaiseError();
            }
        }
        return DB_OK;
    }
    public function rollback()
    {
        if (0 < $this->transaction_opcount) {
            if (!@mssql_select_db($this->_db, $this->connection)) {
                return $this->mssqlRaiseError(DB_ERROR_NODBSELECTED);
            }
            $result = @mssql_query("ROLLBACK TRAN", $this->connection);
            $this->transaction_opcount = 0;
            if (!$result) {
                return $this->mssqlRaiseError();
            }
        }
        return DB_OK;
    }
    public function affectedRows()
    {
        if ($this->_last_query_manip) {
            $res = @mssql_query("select @@rowcount", $this->connection);
            if (!$res) {
                return $this->mssqlRaiseError();
            }
            $ar = @mssql_fetch_row($res);
            if (!$ar) {
                $result = 0;
            } else {
                @mssql_free_result($res);
                $result = $ar[0];
            }
        } else {
            $result = 0;
        }
        return $result;
    }
    public function nextId($seq_name, $ondemand = true)
    {
        $seqname = $this->getSequenceName($seq_name);
        if (!@mssql_select_db($this->_db, $this->connection)) {
            return $this->mssqlRaiseError(DB_ERROR_NODBSELECTED);
        }
        do {
            $repeat = 0;
            $this->pushErrorHandling(PEAR_ERROR_RETURN);
            $result = $this->query("INSERT INTO " . $seqname . " (vapor) VALUES (0)");
            $this->popErrorHandling();
            if ($ondemand && DB::isError($result) && ($result->getCode() == DB_ERROR || $result->getCode() == DB_ERROR_NOSUCHTABLE)) {
                $repeat = 1;
                $result = $this->createSequence($seq_name);
                if (DB::isError($result)) {
                    return $this->raiseError($result);
                }
            } else {
                if (!DB::isError($result)) {
                    $result = $this->query("SELECT IDENT_CURRENT('" . $seqname . "')");
                    if (DB::isError($result)) {
                        $result = $this->query("SELECT @@IDENTITY FROM " . $seqname);
                    }
                    $repeat = 0;
                } else {
                    $repeat = false;
                }
            }
        } while (!$repeat);
        if (DB::isError($result)) {
            return $this->raiseError($result);
        }
        $result = $result->fetchRow(DB_FETCHMODE_ORDERED);
        return $result[0];
    }
    public function createSequence($seq_name)
    {
        return $this->query("CREATE TABLE " . $this->getSequenceName($seq_name) . " ([id] [int] IDENTITY (1, 1) NOT NULL," . " [vapor] [int] NULL)");
    }
    public function dropSequence($seq_name)
    {
        return $this->query("DROP TABLE " . $this->getSequenceName($seq_name));
    }
    public function quoteIdentifier($str)
    {
        return "[" . str_replace("]", "]]", $str) . "]";
    }
    public function mssqlRaiseError($code = NULL)
    {
        $message = @mssql_get_last_message();
        if (!$code) {
            $code = $this->errorNative();
        }
        return $this->raiseError($this->errorCode($code, $message), NULL, NULL, NULL, $code . " - " . $message);
    }
    public function errorNative()
    {
        $res = @mssql_query("select @@ERROR as ErrorCode", $this->connection);
        if (!$res) {
            return DB_ERROR;
        }
        $row = @mssql_fetch_row($res);
        return $row[0];
    }
    public function errorCode($nativecode = NULL, $msg = "")
    {
        if (!$nativecode) {
            $nativecode = $this->errorNative();
        }
        if (isset($this->errorcode_map[$nativecode])) {
            if ($nativecode == 3701 && preg_match("/Cannot drop the index/i", $msg)) {
                return DB_ERROR_NOT_FOUND;
            }
            return $this->errorcode_map[$nativecode];
        }
        return DB_ERROR;
    }
    public function tableInfo($result, $mode = NULL)
    {
        if (is_string($result)) {
            if (!@mssql_select_db($this->_db, $this->connection)) {
                return $this->mssqlRaiseError(DB_ERROR_NODBSELECTED);
            }
            $id = @mssql_query("SELECT * FROM " . $result . " WHERE 1=0", $this->connection);
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
            return $this->mssqlRaiseError(DB_ERROR_NEED_MORE_DATA);
        }
        if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE) {
            $case_func = "strtolower";
        } else {
            $case_func = "strval";
        }
        $count = @mssql_num_fields($id);
        $res = [];
        if ($mode) {
            $res["num_fields"] = $count;
        }
        for ($i = 0; $i < $count; $i++) {
            if ($got_string) {
                $flags = $this->_mssql_field_flags($result, @mssql_field_name($id, $i));
                if (DB::isError($flags)) {
                    return $flags;
                }
            } else {
                $flags = "";
            }
            $res[$i] = ["table" => $got_string ? $case_func($result) : "", "name" => $case_func(@mssql_field_name($id, $i)), "type" => @mssql_field_type($id, $i), "len" => @mssql_field_length($id, $i), "flags" => $flags];
            if ($mode & DB_TABLEINFO_ORDER) {
                $res["order"][$res[$i]["name"]] = $i;
            }
            if ($mode & DB_TABLEINFO_ORDERTABLE) {
                $res["ordertable"][$res[$i]["table"]][$res[$i]["name"]] = $i;
            }
        }
        if ($got_string) {
            @mssql_free_result($id);
        }
        return $res;
    }
    public function _mssql_field_flags($table, $column)
    {
        if ($table != $tableName) {
            $flags = [];
            $tableName = $table;
            $res = $this->getAll("EXEC SP_HELPINDEX " . $table, DB_FETCHMODE_ASSOC);
            if (DB::isError($res)) {
                return $res;
            }
            foreach ($res as $val) {
                $keys = explode(", ", $val["index_keys"]);
                if (1 < sizeof($keys)) {
                    foreach ($keys as $key) {
                        $this->_add_flag($flags[$key], "multiple_key");
                    }
                }
                if (strpos($val["index_description"], "primary key")) {
                    foreach ($keys as $key) {
                        $this->_add_flag($flags[$key], "primary_key");
                    }
                } else {
                    if (strpos($val["index_description"], "unique")) {
                        foreach ($keys as $key) {
                            $this->_add_flag($flags[$key], "unique_key");
                        }
                    }
                }
            }
            $res = $this->getAll("EXEC SP_COLUMNS " . $table, DB_FETCHMODE_ASSOC);
            if (DB::isError($res)) {
                return $res;
            }
            foreach ($res as $val) {
                $val = array_change_key_case($val, CASE_LOWER);
                if ($val["nullable"] == "0") {
                    $this->_add_flag($flags[$val["column_name"]], "not_null");
                }
                if (strpos($val["type_name"], "identity")) {
                    $this->_add_flag($flags[$val["column_name"]], "auto_increment");
                }
                if (strpos($val["type_name"], "timestamp")) {
                    $this->_add_flag($flags[$val["column_name"]], "timestamp");
                }
            }
        }
        if (array_key_exists($column, $flags)) {
            return implode(" ", $flags[$column]);
        }
        return "";
    }
    public function _add_flag(&$array, $value)
    {
        if (!is_array($array)) {
            $array = [$value];
        } else {
            if (!in_array($value, $array)) {
                array_push($array, $value);
            }
        }
    }
    public function getSpecialQuery($type)
    {
        switch ($type) {
            case "tables":
                return "SELECT name FROM sysobjects WHERE type = 'U' ORDER BY name";
                break;
            case "views":
                return "SELECT name FROM sysobjects WHERE type = 'V'";
                break;
        }
    }
}

?>