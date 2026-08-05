<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once PEAR_DIR . "DB/common.php";
/**
 * The methods PEAR DB uses to interact with PHP's msql extension
 * for interacting with Mini SQL databases
 *
 * These methods overload the ones declared in DB_common.
 *
 * PHP's mSQL extension did weird things with NULL values prior to PHP
 * 4.3.11 and 5.0.4.  Make sure your version of PHP meets or exceeds
 * those versions.
 *
 * @category   Database
 * @package    DB
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1997-2007 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.7.14RC1
 * @link       http://pear.php.net/package/DB
 * @since      Class not functional until Release 1.7.0
 */
class DB_msql extends DB_common
{
    /**
     * The DB driver type (mysql, oci8, odbc, etc.)
     * @var string
     */
    public $phptype = "msql";
    /**
     * The database syntax variant to be used (db2, access, etc.), if any
     * @var string
     */
    public $dbsyntax = "msql";
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
    public $features = ["limit" => "emulate", "new_link" => false, "numrows" => true, "pconnect" => true, "prepare" => false, "ssl" => false, "transactions" => false];
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
     * The query result resource created by PHP
     *
     * Used to make affectedRows() work.  Only contains the result for
     * data manipulation queries.  Contains false for other queries.
     *
     * @var resource
     * @access private
     */
    public $_result = NULL;
    public function DB_msql()
    {
        $this->DB_common();
    }
    public function connect($dsn, $persistent = false)
    {
        if (!PEAR::loadExtension("msql")) {
            return $this->raiseError(DB_ERROR_EXTENSION_NOT_FOUND);
        }
        $this->dsn = $dsn;
        if ($dsn["dbsyntax"]) {
            $this->dbsyntax = $dsn["dbsyntax"];
        }
        $params = [];
        if ($dsn["hostspec"]) {
            $params[] = $dsn["port"] ? $dsn["hostspec"] . "," . $dsn["port"] : $dsn["hostspec"];
        }
        $connect_function = $persistent ? "msql_pconnect" : "msql_connect";
        $ini = ini_get("track_errors");
        $php_errormsg = "";
        if ($ini) {
            $this->connection = @call_user_func_array($connect_function, $params);
        } else {
            @ini_set("track_errors", 1);
            $this->connection = @call_user_func_array($connect_function, $params);
            @ini_set("track_errors", $ini);
        }
        if (!$this->connection) {
            if (($err = @msql_error()) != "") {
                return $this->raiseError(DB_ERROR_CONNECT_FAILED, NULL, NULL, NULL, $err);
            }
            return $this->raiseError(DB_ERROR_CONNECT_FAILED, NULL, NULL, NULL, $php_errormsg);
        }
        if (!@msql_select_db($dsn["database"], $this->connection)) {
            return $this->msqlRaiseError();
        }
        return DB_OK;
    }
    public function disconnect()
    {
        $ret = @msql_close($this->connection);
        $this->connection = NULL;
        return $ret;
    }
    public function simpleQuery($query)
    {
        $this->last_query = $query;
        $query = $this->modifyQuery($query);
        $result = @msql_query($query, $this->connection);
        if (!$result) {
            return $this->msqlRaiseError();
        }
        if ($this->_checkManip($query)) {
            $this->_result = $result;
            return DB_OK;
        }
        $this->_result = false;
        return $result;
    }
    public function nextResult($result)
    {
        return false;
    }
    public function fetchInto($result, &$arr, $fetchmode, $rownum = NULL)
    {
        if ($rownum !== NULL && !@msql_data_seek($result, $rownum)) {
            return NULL;
        }
        if ($fetchmode & DB_FETCHMODE_ASSOC) {
            $arr = @msql_fetch_array($result, MSQL_ASSOC);
            if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE && $arr) {
                $arr = array_change_key_case($arr, CASE_LOWER);
            }
        } else {
            $arr = @msql_fetch_row($result);
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
        return is_resource($result) ? msql_free_result($result) : false;
    }
    public function numCols($result)
    {
        $cols = @msql_num_fields($result);
        if (!$cols) {
            return $this->msqlRaiseError();
        }
        return $cols;
    }
    public function numRows($result)
    {
        $rows = @msql_num_rows($result);
        if ($rows === false) {
            return $this->msqlRaiseError();
        }
        return $rows;
    }
    public function affectedRows()
    {
        if (!$this->_result) {
            return 0;
        }
        return msql_affected_rows($this->_result);
    }
    public function nextId($seq_name, $ondemand = true)
    {
        $seqname = $this->getSequenceName($seq_name);
        do {
            $repeat = false;
            $this->pushErrorHandling(PEAR_ERROR_RETURN);
            $result = $this->query("SELECT _seq FROM " . $seqname);
            $this->popErrorHandling();
            if ($ondemand && DB::isError($result) && $result->getCode() == DB_ERROR_NOSUCHTABLE) {
                $repeat = true;
                $this->pushErrorHandling(PEAR_ERROR_RETURN);
                $result = $this->createSequence($seq_name);
                $this->popErrorHandling();
                if (DB::isError($result)) {
                    return $this->raiseError($result);
                }
            } else {
                $repeat = false;
            }
        } while (!$repeat);
        if (DB::isError($result)) {
            return $this->raiseError($result);
        }
        $arr = $result->fetchRow(DB_FETCHMODE_ORDERED);
        $result->free();
        return $arr[0];
    }
    public function createSequence($seq_name)
    {
        $seqname = $this->getSequenceName($seq_name);
        $res = $this->query("CREATE TABLE " . $seqname . " (id INTEGER NOT NULL)");
        if (DB::isError($res)) {
            return $res;
        }
        $res = $this->query("CREATE SEQUENCE ON " . $seqname);
        return $res;
    }
    public function dropSequence($seq_name)
    {
        return $this->query("DROP TABLE " . $this->getSequenceName($seq_name));
    }
    public function quoteIdentifier($str)
    {
        return $this->raiseError(DB_ERROR_UNSUPPORTED);
    }
    public function quoteFloat($float)
    {
        return $this->escapeSimple(str_replace(",", ".", strval(floatval($float))));
    }
    public function escapeSimple($str)
    {
        return addslashes($str);
    }
    public function msqlRaiseError($errno = NULL)
    {
        $native = $this->errorNative();
        if ($errno === NULL) {
            $errno = $this->errorCode($native);
        }
        return $this->raiseError($errno, NULL, NULL, NULL, $native);
    }
    public function errorNative()
    {
        return @msql_error();
    }
    public function errorCode($errormsg)
    {
        $errormsg = preg_replace("/^msql[a-z_]+\\(\\): /", "", $errormsg);
        if (!isset($error_regexps)) {
            $error_regexps = ["/^Access to database denied/i" => DB_ERROR_ACCESS_VIOLATION, "/^Bad index name/i" => DB_ERROR_ALREADY_EXISTS, "/^Bad order field/i" => DB_ERROR_SYNTAX, "/^Bad type for comparison/i" => DB_ERROR_SYNTAX, "/^Can't perform LIKE on/i" => DB_ERROR_SYNTAX, "/^Can't use TEXT fields in LIKE comparison/i" => DB_ERROR_SYNTAX, "/^Couldn't create temporary table/i" => DB_ERROR_CANNOT_CREATE, "/^Error creating table file/i" => DB_ERROR_CANNOT_CREATE, "/^Field .* cannot be null\$/i" => DB_ERROR_CONSTRAINT_NOT_NULL, "/^Index (field|condition) .* cannot be null\$/i" => DB_ERROR_SYNTAX, "/^Invalid date format/i" => DB_ERROR_INVALID_DATE, "/^Invalid time format/i" => DB_ERROR_INVALID, "/^Literal value for .* is wrong type\$/i" => DB_ERROR_INVALID_NUMBER, "/^No Database Selected/i" => DB_ERROR_NODBSELECTED, "/^No value specified for field/i" => DB_ERROR_VALUE_COUNT_ON_ROW, "/^Non unique value for unique index/i" => DB_ERROR_CONSTRAINT, "/^Out of memory for temporary table/i" => DB_ERROR_CANNOT_CREATE, "/^Permission denied/i" => DB_ERROR_ACCESS_VIOLATION, "/^Reference to un-selected table/i" => DB_ERROR_SYNTAX, "/^syntax error/i" => DB_ERROR_SYNTAX, "/^Table .* exists\$/i" => DB_ERROR_ALREADY_EXISTS, "/^Unknown database/i" => DB_ERROR_NOSUCHDB, "/^Unknown field/i" => DB_ERROR_NOSUCHFIELD, "/^Unknown (index|system variable)/i" => DB_ERROR_NOT_FOUND, "/^Unknown table/i" => DB_ERROR_NOSUCHTABLE, "/^Unqualified field/i" => DB_ERROR_SYNTAX];
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
            $id = @msql_query("SELECT * FROM " . $result, $this->connection);
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
            return $this->raiseError(DB_ERROR_NEED_MORE_DATA);
        }
        if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE) {
            $case_func = "strtolower";
        } else {
            $case_func = "strval";
        }
        $count = @msql_num_fields($id);
        $res = [];
        if ($mode) {
            $res["num_fields"] = $count;
        }
        for ($i = 0; $i < $count; $i++) {
            $tmp = @msql_fetch_field($id);
            $flags = "";
            if ($tmp->not_null) {
                $flags .= "not_null ";
            }
            if ($tmp->unique) {
                $flags .= "unique_key ";
            }
            $flags = trim($flags);
            $res[$i] = ["table" => $case_func($tmp->table), "name" => $case_func($tmp->name), "type" => $tmp->type, "len" => msql_field_len($id, $i), "flags" => $flags];
            if ($mode & DB_TABLEINFO_ORDER) {
                $res["order"][$res[$i]["name"]] = $i;
            }
            if ($mode & DB_TABLEINFO_ORDERTABLE) {
                $res["ordertable"][$res[$i]["table"]][$res[$i]["name"]] = $i;
            }
        }
        if ($got_string) {
            @msql_free_result($id);
        }
        return $res;
    }
    public function getSpecialQuery($type)
    {
        switch ($type) {
            case "databases":
                $id = @msql_list_dbs($this->connection);
                break;
            case "tables":
                $id = @msql_list_tables($this->dsn["database"], $this->connection);
                if (!$id) {
                    return $this->msqlRaiseError();
                }
                $out = [];
                while ($row = @msql_fetch_row($id)) {
                    $out[] = $row[0];
                }
                return $out;
                break;
        }
    }
}

?>