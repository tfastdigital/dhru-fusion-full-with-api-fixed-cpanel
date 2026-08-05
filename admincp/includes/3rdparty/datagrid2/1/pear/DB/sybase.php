<?php
/*
 *after.com
 * @ Release: 13/06/2023
 */

require_once PEAR_DIR . "DB/common.php";
/**
 * The methods PEAR DB uses to interact with PHP's sybase extension
 * for interacting with Sybase databases
 *
 * These methods overload the ones declared in DB_common.
 *
 * WARNING:  This driver may fail with multiple connections under the
 * same user/pass/host and different databases.
 *
 * @category   Database
 * @package    DB
 * @author     Sterling Hughes <sterling@php.net>
 * @author     Ant�nio Carlos Ven�ncio J�nior <floripa@php.net>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1997-2007 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.7.14RC1
 * @link       http://pear.php.net/package/DB
 */
class DB_sybase extends DB_common
{
    /**
     * The DB driver type (mysql, oci8, odbc, etc.)
     * @var string
     */
    public $phptype = "sybase";
    /**
     * The database syntax variant to be used (db2, access, etc.), if any
     * @var string
     */
    public $dbsyntax = "sybase";
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
    public $errorcode_map = [];
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
    public $_db = "";
    public function DB_sybase()
    {
        $this->DB_common();
    }
    public function connect($dsn, $persistent = false)
    {
        if (!PEAR::loadExtension("sybase") && !PEAR::loadExtension("sybase_ct")) {
            return $this->raiseError(DB_ERROR_EXTENSION_NOT_FOUND);
        }
        $this->dsn = $dsn;
        if ($dsn["dbsyntax"]) {
            $this->dbsyntax = $dsn["dbsyntax"];
        }
        $dsn["hostspec"] = $dsn["hostspec"] ? $dsn["hostspec"] : "localhost";
        $dsn["password"] = !empty($dsn["password"]) ? $dsn["password"] : false;
        $dsn["charset"] = isset($dsn["charset"]) ? $dsn["charset"] : false;
        $dsn["appname"] = isset($dsn["appname"]) ? $dsn["appname"] : false;
        $connect_function = $persistent ? "sybase_pconnect" : "sybase_connect";
        if ($dsn["username"]) {
            $this->connection = @$connect_function($dsn["hostspec"], $dsn["username"], $dsn["password"], $dsn["charset"], $dsn["appname"]);
            if (!$this->connection) {
                return $this->raiseError(DB_ERROR_CONNECT_FAILED, NULL, NULL, NULL, @sybase_get_last_message());
            }
            if ($dsn["database"]) {
                if (!@sybase_select_db($dsn["database"], $this->connection)) {
                    return $this->raiseError(DB_ERROR_NODBSELECTED, NULL, NULL, NULL, @sybase_get_last_message());
                }
                $this->_db = $dsn["database"];
            }
            return DB_OK;
        }
        return $this->raiseError(DB_ERROR_CONNECT_FAILED, NULL, NULL, NULL, "The DSN did not contain a username.");
    }
    public function disconnect()
    {
        $ret = @sybase_close($this->connection);
        $this->connection = NULL;
        return $ret;
    }
    public function simpleQuery($query)
    {
        $ismanip = $this->_checkManip($query);
        $this->last_query = $query;
        if ($this->_db && !@sybase_select_db($this->_db, $this->connection)) {
            return $this->sybaseRaiseError(DB_ERROR_NODBSELECTED);
        }
        $query = $this->modifyQuery($query);
        if (!$this->autocommit && $ismanip) {
            if ($this->transaction_opcount == 0) {
                $result = @sybase_query("BEGIN TRANSACTION", $this->connection);
                if (!$result) {
                    return $this->sybaseRaiseError();
                }
            }
            $this->transaction_opcount++;
        }
        $result = @sybase_query($query, $this->connection);
        if (!$result) {
            return $this->sybaseRaiseError();
        }
        if (is_resource($result)) {
            return $result;
        }
        return $ismanip ? DB_OK : $result;
    }
    public function nextResult($result)
    {
        return false;
    }
    public function fetchInto($result, &$arr, $fetchmode, $rownum = NULL)
    {
        if ($rownum !== NULL && !@sybase_data_seek($result, $rownum)) {
            return NULL;
        }
        if ($fetchmode & DB_FETCHMODE_ASSOC) {
            if (function_exists("sybase_fetch_assoc")) {
                $arr = @sybase_fetch_assoc($result);
            } else {
                if ($arr = @sybase_fetch_array($result)) {
                    foreach ($arr as $key => $value) {
                        if (is_int($key)) {
                            unset($arr[$key]);
                        }
                    }
                }
            }
            if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE && $arr) {
                $arr = array_change_key_case($arr, CASE_LOWER);
            }
        } else {
            $arr = @sybase_fetch_row($result);
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
        return is_resource($result) ? sybase_free_result($result) : false;
    }
    public function numCols($result)
    {
        $cols = @sybase_num_fields($result);
        if (!$cols) {
            return $this->sybaseRaiseError();
        }
        return $cols;
    }
    public function numRows($result)
    {
        $rows = @sybase_num_rows($result);
        if ($rows === false) {
            return $this->sybaseRaiseError();
        }
        return $rows;
    }
    public function affectedRows()
    {
        if ($this->_last_query_manip) {
            $result = @sybase_affected_rows($this->connection);
        } else {
            $result = 0;
        }
        return $result;
    }
    public function nextId($seq_name, $ondemand = true)
    {
        $seqname = $this->getSequenceName($seq_name);
        if ($this->_db && !@sybase_select_db($this->_db, $this->connection)) {
            return $this->sybaseRaiseError(DB_ERROR_NODBSELECTED);
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
                    $result = $this->query("SELECT @@IDENTITY FROM " . $seqname);
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
        return $this->query("CREATE TABLE " . $this->getSequenceName($seq_name) . " (id numeric(10, 0) IDENTITY NOT NULL," . " vapor int NULL)");
    }
    public function dropSequence($seq_name)
    {
        return $this->query("DROP TABLE " . $this->getSequenceName($seq_name));
    }
    public function quoteFloat($float)
    {
        return $this->escapeSimple(str_replace(",", ".", strval(floatval($float))));
    }
    public function autoCommit($onoff = false)
    {
        $this->autocommit = $onoff ? true : false;
        return DB_OK;
    }
    public function commit()
    {
        if (0 < $this->transaction_opcount) {
            if ($this->_db && !@sybase_select_db($this->_db, $this->connection)) {
                return $this->sybaseRaiseError(DB_ERROR_NODBSELECTED);
            }
            $result = @sybase_query("COMMIT", $this->connection);
            $this->transaction_opcount = 0;
            if (!$result) {
                return $this->sybaseRaiseError();
            }
        }
        return DB_OK;
    }
    public function rollback()
    {
        if (0 < $this->transaction_opcount) {
            if ($this->_db && !@sybase_select_db($this->_db, $this->connection)) {
                return $this->sybaseRaiseError(DB_ERROR_NODBSELECTED);
            }
            $result = @sybase_query("ROLLBACK", $this->connection);
            $this->transaction_opcount = 0;
            if (!$result) {
                return $this->sybaseRaiseError();
            }
        }
        return DB_OK;
    }
    public function sybaseRaiseError($errno = NULL)
    {
        $native = $this->errorNative();
        if ($errno === NULL) {
            $errno = $this->errorCode($native);
        }
        return $this->raiseError($errno, NULL, NULL, NULL, $native);
    }
    public function errorNative()
    {
        return @sybase_get_last_message();
    }
    public function errorCode($errormsg)
    {
        $errormsg = preg_replace("/^sybase[a-z_]+\\(\\): /", "", $errormsg);
        if (!isset($error_regexps)) {
            $error_regexps = ["/Incorrect syntax near/" => DB_ERROR_SYNTAX, "/^Unclosed quote before the character string [\\\"'].*[\\\"']\\./" => DB_ERROR_SYNTAX, "/Implicit conversion (from datatype|of NUMERIC value)/i" => DB_ERROR_INVALID_NUMBER, "/Cannot drop the table [\\\"'].+[\\\"'], because it doesn't exist in the system catalogs\\./" => DB_ERROR_NOSUCHTABLE, "/Only the owner of object [\\\"'].+[\\\"'] or a user with System Administrator \\(SA\\) role can run this command\\./" => DB_ERROR_ACCESS_VIOLATION, "/^.+ permission denied on object .+, database .+, owner .+/" => DB_ERROR_ACCESS_VIOLATION, "/^.* permission denied, database .+, owner .+/" => DB_ERROR_ACCESS_VIOLATION, "/[^.*] not found\\./" => DB_ERROR_NOSUCHTABLE, "/There is already an object named/" => DB_ERROR_ALREADY_EXISTS, "/Invalid column name/" => DB_ERROR_NOSUCHFIELD, "/does not allow null values/" => DB_ERROR_CONSTRAINT_NOT_NULL, "/Command has been aborted/" => DB_ERROR_CONSTRAINT, "/^Cannot drop the index .* because it doesn't exist/i" => DB_ERROR_NOT_FOUND, "/^There is already an index/i" => DB_ERROR_ALREADY_EXISTS, "/^There are fewer columns in the INSERT statement than values specified/i" => DB_ERROR_VALUE_COUNT_ON_ROW, "/Divide by zero/i" => DB_ERROR_DIVZERO];
        }
        foreach ($error_regexps as $regexp => $code) {
            if (preg_match($regexp, $errormsg)) {
                return $code;
            }
        }
        return DB_ERROR;
    }
    public function tableInfo($result, $mode = NULL)
    {
        if (is_string($result)) {
            if ($this->_db && !@sybase_select_db($this->_db, $this->connection)) {
                return $this->sybaseRaiseError(DB_ERROR_NODBSELECTED);
            }
            $id = @sybase_query("SELECT * FROM " . $result . " WHERE 1=0", $this->connection);
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
            return $this->sybaseRaiseError(DB_ERROR_NEED_MORE_DATA);
        }
        if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE) {
            $case_func = "strtolower";
        } else {
            $case_func = "strval";
        }
        $count = @sybase_num_fields($id);
        $res = [];
        if ($mode) {
            $res["num_fields"] = $count;
        }
        for ($i = 0; $i < $count; $i++) {
            $f = @sybase_fetch_field($id, $i);
            $res[$i] = ["table" => $got_string ? $case_func($result) : $case_func($f->column_source), "name" => $case_func($f->name), "type" => $f->type, "len" => $f->max_length, "flags" => ""];
            if ($res[$i]["table"]) {
                $res[$i]["flags"] = $this->_sybase_field_flags($res[$i]["table"], $res[$i]["name"]);
            }
            if ($mode & DB_TABLEINFO_ORDER) {
                $res["order"][$res[$i]["name"]] = $i;
            }
            if ($mode & DB_TABLEINFO_ORDERTABLE) {
                $res["ordertable"][$res[$i]["table"]][$res[$i]["name"]] = $i;
            }
        }
        if ($got_string) {
            @sybase_free_result($id);
        }
        return $res;
    }
    public function _sybase_field_flags($table, $column)
    {
        if ($table != $tableName) {
            $flags = [];
            $tableName = $table;
            $res = @sybase_query("sp_helpindex " . $table, $this->connection);
            if ($res === false || $res === true) {
                return "";
            }
            while (($val = sybase_fetch_assoc($res)) !== false) {
                if (isset($val["index_keys"])) {
                    $keys = explode(", ", trim($val["index_keys"]));
                    if (1 < sizeof($keys)) {
                        foreach ($keys as $key) {
                            $this->_add_flag($flags[$key], "multiple_key");
                        }
                    }
                    if (strpos($val["index_description"], "unique")) {
                        foreach ($keys as $key) {
                            $this->_add_flag($flags[$key], "unique_key");
                        }
                    }
                }
            }
            sybase_free_result($res);
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