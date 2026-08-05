<?php
/*
 *after.com
 * @ Release: 13/06/2023
 */

require_once PEAR_DIR . "DB/common.php";
/**
 * The methods PEAR DB uses to interact with PHP's mysql extension
 * for interacting with MySQL databases
 *
 * These methods overload the ones declared in DB_common.
 *
 * @category   Database
 * @package    DB
 * @author     Stig Bakken <ssb@php.net>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1997-2007 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.7.14RC1
 * @link       http://pear.php.net/package/DB
 */
class DB_mysql extends DB_common
{
    /**
     * The DB driver type (mysql, oci8, odbc, etc.)
     * @var string
     */
    public $phptype = "mysql";
    /**
     * The database syntax variant to be used (db2, access, etc.), if any
     * @var string
     */
    public $dbsyntax = "mysql";
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
    public $features = ["limit" => "alter", "new_link" => "4.2.0", "numrows" => true, "pconnect" => true, "prepare" => false, "ssl" => false, "transactions" => true];
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
    public $_db = "";
    public function DB_mysql()
    {
        $this->DB_common();
    }
    public function connect($dsn, $persistent = false)
    {
        if (!PEAR::loadExtension("mysql")) {
            return $this->raiseError(DB_ERROR_EXTENSION_NOT_FOUND);
        }
        $this->dsn = $dsn;
        if ($dsn["dbsyntax"]) {
            $this->dbsyntax = $dsn["dbsyntax"];
        }
        $params = [];
        if ($dsn["protocol"] && $dsn["protocol"] == "unix") {
            $params[0] = ":" . $dsn["socket"];
        } else {
            $params[0] = $dsn["hostspec"] ? $dsn["hostspec"] : "localhost";
            if ($dsn["port"]) {
                $params[0] .= ":" . $dsn["port"];
            }
        }
        $params[] = $dsn["username"] ? $dsn["username"] : NULL;
        $params[] = $dsn["password"] ? $dsn["password"] : NULL;
        if (!$persistent) {
            if (isset($dsn["new_link"]) && ($dsn["new_link"] == "true" || $dsn["new_link"] === true)) {
                $params[] = true;
            } else {
                $params[] = false;
            }
        }
        if (version_compare(phpversion(), "4.3.0", ">=")) {
            $params[] = isset($dsn["client_flags"]) ? $dsn["client_flags"] : NULL;
        }
        $connect_function = $persistent ? "mysql_pconnect" : "mysql_connect";
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
            if (($err = @mysqli_error()) != "") {
                return $this->raiseError(DB_ERROR_CONNECT_FAILED, NULL, NULL, NULL, $err);
            }
            return $this->raiseError(DB_ERROR_CONNECT_FAILED, NULL, NULL, NULL, $php_errormsg);
        }
        if ($dsn["database"]) {
            if (!@mysql_select_db($dsn["database"], $this->connection)) {
                return $this->mysqlRaiseError();
            }
            $this->_db = $dsn["database"];
        }
        return DB_OK;
    }
    public function disconnect()
    {
        $ret = @mysql_close($this->connection);
        $this->connection = NULL;
        return $ret;
    }
    public function simpleQuery($query)
    {
        $ismanip = $this->_checkManip($query);
        $this->last_query = $query;
        $query = $this->modifyQuery($query);
        if ($this->_db && !@mysql_select_db($this->_db, $this->connection)) {
            return $this->mysqlRaiseError(DB_ERROR_NODBSELECTED);
        }
        if (!$this->autocommit && $ismanip) {
            if ($this->transaction_opcount == 0) {
                $result = @dquery("SET AUTOCOMMIT=0", $this->connection);
                $result = @dquery("BEGIN", $this->connection);
                if (!$result) {
                    return $this->mysqlRaiseError();
                }
            }
            $this->transaction_opcount++;
        }
        if (!$this->options["result_buffering"]) {
            $result = @mysql_unbuffered_query($query, $this->connection);
        } else {
            $result = @dquery($query, $this->connection);
        }
        if (!$result) {
            return $this->mysqlRaiseError();
        }
        if (is_resource($result)) {
            return $result;
        }
        return DB_OK;
    }
    public function nextResult($result)
    {
        return false;
    }
    public function fetchInto($result, &$arr, $fetchmode, $rownum = NULL)
    {
        if ($rownum !== NULL && !@mysql_data_seek($result, $rownum)) {
            return NULL;
        }
        if ($fetchmode & DB_FETCHMODE_ASSOC) {
            $arr = @mysqli_fetch_assoc($result);
            if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE && $arr) {
                $arr = array_change_key_case($arr, CASE_LOWER);
            }
        } else {
            $arr = @mysqli_fetch_row($result);
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
        return is_resource($result) ? mysql_free_result($result) : false;
    }
    public function numCols($result)
    {
        $cols = @mysql_num_fields($result);
        if (!$cols) {
            return $this->mysqlRaiseError();
        }
        return $cols;
    }
    public function numRows($result)
    {
        $rows = @mysqli_num_rows($result);
        if ($rows === NULL) {
            return $this->mysqlRaiseError();
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
            if ($this->_db && !@mysql_select_db($this->_db, $this->connection)) {
                return $this->mysqlRaiseError(DB_ERROR_NODBSELECTED);
            }
            $result = @dquery("COMMIT", $this->connection);
            $result = @dquery("SET AUTOCOMMIT=1", $this->connection);
            $this->transaction_opcount = 0;
            if (!$result) {
                return $this->mysqlRaiseError();
            }
        }
        return DB_OK;
    }
    public function rollback()
    {
        if (0 < $this->transaction_opcount) {
            if ($this->_db && !@mysql_select_db($this->_db, $this->connection)) {
                return $this->mysqlRaiseError(DB_ERROR_NODBSELECTED);
            }
            $result = @dquery("ROLLBACK", $this->connection);
            $result = @dquery("SET AUTOCOMMIT=1", $this->connection);
            $this->transaction_opcount = 0;
            if (!$result) {
                return $this->mysqlRaiseError();
            }
        }
        return DB_OK;
    }
    public function affectedRows()
    {
        if ($this->_last_query_manip) {
            return @mysqli_affected_rows($this->connection);
        }
        return 0;
    }
    public function nextId($seq_name, $ondemand = true)
    {
        $seqname = $this->getSequenceName($seq_name);
        $repeat = 0;
        $this->pushErrorHandling(PEAR_ERROR_RETURN);
        $result = $this->query("UPDATE " . $seqname . " " . "SET id=LAST_INSERT_ID(id+1)");
        $this->popErrorHandling();
        if ($result === DB_OK) {
            $id = @mysqli_insert_id($this->connection);
            if ($id != 0) {
                return $id;
            }
            $result = $this->getOne("SELECT GET_LOCK('" . $seqname . "_lock',10)");
            if (DB::isError($result)) {
                return $this->raiseError($result);
            }
            if ($result == 0) {
                return $this->mysqlRaiseError(DB_ERROR_NOT_LOCKED);
            }
            $result = $this->query("REPLACE INTO " . $seqname . " (id) VALUES (0)");
            if (DB::isError($result)) {
                return $this->raiseError($result);
            }
            $result = $this->getOne("SELECT RELEASE_LOCK(" . "'" . $seqname . "_lock')");
            if (DB::isError($result)) {
                return $this->raiseError($result);
            }
            return 1;
        }
        if ($ondemand && DB::isError($result) && $result->getCode() == DB_ERROR_NOSUCHTABLE) {
            $result = $this->createSequence($seq_name);
            if (DB::isError($result)) {
                return $this->raiseError($result);
            }
            $repeat = 1;
        } else {
            if (DB::isError($result) && $result->getCode() == DB_ERROR_ALREADY_EXISTS) {
                $result = $this->_BCsequence($seqname);
                if (DB::isError($result)) {
                    return $this->raiseError($result);
                }
                $repeat = 1;
            }
        }
        if ($repeat) {
            return $this->raiseError($result);
        }
    }
    public function createSequence($seq_name)
    {
        $seqname = $this->getSequenceName($seq_name);
        $res = $this->query("CREATE TABLE " . $seqname . " (id INTEGER UNSIGNED AUTO_INCREMENT NOT NULL," . " PRIMARY KEY(id))");
        if (DB::isError($res)) {
            return $res;
        }
        $res = $this->query("INSERT INTO " . $seqname . " (id) VALUES (0)");
        if (DB::isError($res)) {
            return $res;
        }
        return $this->query("UPDATE " . $seqname . " SET id = 0");
    }
    public function dropSequence($seq_name)
    {
        return $this->query("DROP TABLE " . $this->getSequenceName($seq_name));
    }
    public function _BCsequence($seqname)
    {
        $result = $this->getOne("SELECT GET_LOCK('" . $seqname . "_lock',10)");
        if (DB::isError($result)) {
            return $result;
        }
        if ($result == 0) {
            return $this->mysqlRaiseError(DB_ERROR_NOT_LOCKED);
        }
        $highest_id = $this->getOne("SELECT MAX(id) FROM " . $seqname);
        if (DB::isError($highest_id)) {
            return $highest_id;
        }
        $result = $this->query("DELETE FROM " . $seqname . " WHERE id <> " . $highest_id);
        if (DB::isError($result)) {
            return $result;
        }
        $result = $this->getOne("SELECT RELEASE_LOCK('" . $seqname . "_lock')");
        if (DB::isError($result)) {
            return $result;
        }
        return true;
    }
    public function quoteIdentifier($str)
    {
        return "`" . str_replace("`", "``", $str) . "`";
    }
    public function quote($str)
    {
        return $this->quoteSmart($str);
    }
    public function escapeSimple($str)
    {
        if (function_exists("descape")) {
            return @descape($str, $this->connection);
        }
        return @mysql_escape_string($str);
    }
    public function modifyQuery($query)
    {
        if ($this->options["portability"] & DB_PORTABILITY_DELETE_COUNT && preg_match("/^\\s*DELETE\\s+FROM\\s+(\\S+)\\s*\$/i", $query)) {
            $query = preg_replace("/^\\s*DELETE\\s+FROM\\s+(\\S+)\\s*\$/", "DELETE FROM \\1 WHERE 1=1", $query);
        }
        return $query;
    }
    public function modifyLimitQuery($query, $from, $count, $params = [])
    {
        if (DB::isManip($query) || $this->_next_query_manip) {
            return $query . " LIMIT " . $count;
        }
        return $query . " LIMIT " . $from . ", " . $count;
    }
    public function mysqlRaiseError($errno = NULL)
    {
        if ($errno === NULL) {
            if ($this->options["portability"] & DB_PORTABILITY_ERRORS) {
                $this->errorcode_map[1022] = DB_ERROR_CONSTRAINT;
                $this->errorcode_map[1048] = DB_ERROR_CONSTRAINT_NOT_NULL;
                $this->errorcode_map[1062] = DB_ERROR_CONSTRAINT;
            } else {
                $this->errorcode_map[1022] = DB_ERROR_ALREADY_EXISTS;
                $this->errorcode_map[1048] = DB_ERROR_CONSTRAINT;
                $this->errorcode_map[1062] = DB_ERROR_ALREADY_EXISTS;
            }
            $errno = $this->errorCode(mysql_errno($this->connection));
        }
        return $this->raiseError($errno, NULL, NULL, NULL, @mysql_errno($this->connection) . " ** " . @mysqli_error($this->connection));
    }
    public function errorNative()
    {
        return @mysql_errno($this->connection);
    }
    public function tableInfo($result, $mode = NULL)
    {
        if (is_string($result)) {
            if ($this->_db && !@mysql_select_db($this->_db, $this->connection)) {
                return $this->mysqlRaiseError(DB_ERROR_NODBSELECTED);
            }
            $id = @dquery("SELECT * FROM " . $result . " LIMIT 0", $this->connection);
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
            return $this->mysqlRaiseError(DB_ERROR_NEED_MORE_DATA);
        }
        if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE) {
            $case_func = "strtolower";
        } else {
            $case_func = "strval";
        }
        $count = @mysql_num_fields($id);
        $res = [];
        if ($mode) {
            $res["num_fields"] = $count;
        }
        for ($i = 0; $i < $count; $i++) {
            $res[$i] = ["table" => $case_func(@mysql_field_table($id, $i)), "name" => $case_func(@mysql_field_name($id, $i)), "type" => @mysql_field_type($id, $i), "len" => @mysql_field_len($id, $i), "flags" => @mysql_field_flags($id, $i)];
            if ($mode & DB_TABLEINFO_ORDER) {
                $res["order"][$res[$i]["name"]] = $i;
            }
            if ($mode & DB_TABLEINFO_ORDERTABLE) {
                $res["ordertable"][$res[$i]["table"]][$res[$i]["name"]] = $i;
            }
        }
        if ($got_string) {
            @mysql_free_result($id);
        }
        return $res;
    }
    public function getSpecialQuery($type)
    {
        switch ($type) {
            case "tables":
                return "SHOW TABLES";
                break;
            case "users":
                return "SELECT DISTINCT User FROM mysql.user";
                break;
            case "databases":
                return "SHOW DATABASES";
                break;
        }
    }
}

?>