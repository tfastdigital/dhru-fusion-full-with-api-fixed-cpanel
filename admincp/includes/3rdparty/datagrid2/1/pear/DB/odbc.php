<?php
/*
 *after.com
 * @ Release: 13/06/2023
 */

require_once PEAR_DIR . "DB/common.php";
/**
 * The methods PEAR DB uses to interact with PHP's odbc extension
 * for interacting with databases via ODBC connections
 *
 * These methods overload the ones declared in DB_common.
 *
 * More info on ODBC errors could be found here:
 * http://msdn.microsoft.com/library/default.asp?url=/library/en-us/trblsql/tr_err_odbc_5stz.asp
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
class DB_odbc extends DB_common
{
    /**
     * The DB driver type (mysql, oci8, odbc, etc.)
     * @var string
     */
    public $phptype = "odbc";
    /**
     * The database syntax variant to be used (db2, access, etc.), if any
     * @var string
     */
    public $dbsyntax = "sql92";
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
     * NOTE: The feature set of the following drivers are different than
     * the default:
     *   + solid: 'transactions' = true
     *   + navision: 'limit' = false
     *
     * @var array
     */
    public $features = ["limit" => "emulate", "new_link" => false, "numrows" => true, "pconnect" => true, "prepare" => false, "ssl" => false, "transactions" => false];
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
     * The number of rows affected by a data manipulation query
     * @var integer
     * @access private
     */
    public $affected = 0;
    public function DB_odbc()
    {
        $this->DB_common();
    }
    public function connect($dsn, $persistent = false)
    {
        if (!PEAR::loadExtension("odbc")) {
            return $this->raiseError(DB_ERROR_EXTENSION_NOT_FOUND);
        }
        $this->dsn = $dsn;
        if ($dsn["dbsyntax"]) {
            $this->dbsyntax = $dsn["dbsyntax"];
        }
        switch ($this->dbsyntax) {
            case "access":
            case "db2":
            case "solid":
                $this->features["transactions"] = true;
                break;
            case "navision":
                $this->features["limit"] = false;
                break;
            default:
                if ($dsn["database"]) {
                    $odbcdsn = $dsn["database"];
                } else {
                    if ($dsn["hostspec"]) {
                        $odbcdsn = $dsn["hostspec"];
                    } else {
                        $odbcdsn = "localhost";
                    }
                }
                $connect_function = $persistent ? "odbc_pconnect" : "odbc_connect";
                if (empty($dsn["cursor"])) {
                    $this->connection = @$connect_function($odbcdsn, $dsn["username"], $dsn["password"]);
                } else {
                    $this->connection = @$connect_function($odbcdsn, $dsn["username"], $dsn["password"], $dsn["cursor"]);
                }
                if (!is_resource($this->connection)) {
                    return $this->raiseError(DB_ERROR_CONNECT_FAILED, NULL, NULL, NULL, $this->errorNative());
                }
                return DB_OK;
        }
    }
    public function disconnect()
    {
        $err = @odbc_close($this->connection);
        $this->connection = NULL;
        return $err;
    }
    public function simpleQuery($query)
    {
        $this->last_query = $query;
        $query = $this->modifyQuery($query);
        $result = @odbc_exec($this->connection, $query);
        if (!$result) {
            return $this->odbcRaiseError();
        }
        if ($this->_checkManip($query)) {
            $this->affected = $result;
            return DB_OK;
        }
        $this->affected = 0;
        return $result;
    }
    public function nextResult($result)
    {
        return @odbc_next_result($result);
    }
    public function fetchInto($result, &$arr, $fetchmode, $rownum = NULL)
    {
        $arr = [];
        if ($rownum !== NULL) {
            $rownum++;
            if (version_compare(phpversion(), "4.2.0", "ge")) {
                $cols = @odbc_fetch_into($result, $arr, $rownum);
            } else {
                $cols = @odbc_fetch_into($result, $rownum, $arr);
            }
        } else {
            $cols = @odbc_fetch_into($result, $arr);
        }
        if (!$cols) {
            return NULL;
        }
        if ($fetchmode !== DB_FETCHMODE_ORDERED) {
            for ($i = 0; $i < count($arr); $i++) {
                $colName = @odbc_field_name($result, $i + 1);
                $a[$colName] = $arr[$i];
            }
            if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE) {
                $a = array_change_key_case($a, CASE_LOWER);
            }
            $arr = $a;
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
        return is_resource($result) ? odbc_free_result($result) : false;
    }
    public function numCols($result)
    {
        $cols = @odbc_num_fields($result);
        if (!$cols) {
            return $this->odbcRaiseError();
        }
        return $cols;
    }
    public function affectedRows()
    {
        if (empty($this->affected)) {
            return 0;
        }
        $nrows = @odbc_num_rows($this->affected);
        if ($nrows == -1) {
            return $this->odbcRaiseError();
        }
        return $nrows;
    }
    public function numRows($result)
    {
        $nrows = @odbc_num_rows($result);
        if ($nrows == -1) {
            return $this->odbcRaiseError(DB_ERROR_UNSUPPORTED);
        }
        if ($nrows === false) {
            return $this->odbcRaiseError();
        }
        return $nrows;
    }
    public function quoteIdentifier($str)
    {
        switch ($this->dsn["dbsyntax"]) {
            case "access":
                return "[" . $str . "]";
                break;
            case "mssql":
            case "sybase":
                return "[" . str_replace("]", "]]", $str) . "]";
                break;
            case "mysql":
            case "mysqli":
                return "`" . $str . "`";
                break;
            default:
                return "\"" . str_replace("\"", "\"\"", $str) . "\"";
        }
    }
    public function quote($str)
    {
        return $this->quoteSmart($str);
    }
    public function nextId($seq_name, $ondemand = true)
    {
        $seqname = $this->getSequenceName($seq_name);
        do {
            $repeat = 0;
            $this->pushErrorHandling(PEAR_ERROR_RETURN);
            $result = $this->query("update " . $seqname . " set id = id + 1");
            $this->popErrorHandling();
            if ($ondemand && DB::isError($result) && $result->getCode() == DB_ERROR_NOSUCHTABLE) {
                $repeat = 1;
                $this->pushErrorHandling(PEAR_ERROR_RETURN);
                $result = $this->createSequence($seq_name);
                $this->popErrorHandling();
                if (DB::isError($result)) {
                    return $this->raiseError($result);
                }
                $result = $this->query("insert into " . $seqname . " (id) values(0)");
            } else {
                $repeat = 0;
            }
        } while (!$repeat);
        if (DB::isError($result)) {
            return $this->raiseError($result);
        }
        $result = $this->query("select id from " . $seqname);
        if (DB::isError($result)) {
            return $result;
        }
        $row = $result->fetchRow(DB_FETCHMODE_ORDERED);
        if (DB::isError($row || !$row)) {
            return $row;
        }
        return $row[0];
    }
    public function createSequence($seq_name)
    {
        return $this->query("CREATE TABLE " . $this->getSequenceName($seq_name) . " (id integer NOT NULL," . " PRIMARY KEY(id))");
    }
    public function dropSequence($seq_name)
    {
        return $this->query("DROP TABLE " . $this->getSequenceName($seq_name));
    }
    public function autoCommit($onoff = false)
    {
        if (!@odbc_autocommit($this->connection, $onoff)) {
            return $this->odbcRaiseError();
        }
        return DB_OK;
    }
    public function commit()
    {
        if (!@odbc_commit($this->connection)) {
            return $this->odbcRaiseError();
        }
        return DB_OK;
    }
    public function rollback()
    {
        if (!@odbc_rollback($this->connection)) {
            return $this->odbcRaiseError();
        }
        return DB_OK;
    }
    public function odbcRaiseError($errno = NULL)
    {
        if ($errno === NULL) {
            switch ($this->dbsyntax) {
                case "access":
                    if ($this->options["portability"] & DB_PORTABILITY_ERRORS) {
                        $this->errorcode_map["07001"] = DB_ERROR_NOSUCHFIELD;
                    } else {
                        $this->errorcode_map["07001"] = DB_ERROR_MISMATCH;
                    }
                    $native_code = odbc_error($this->connection);
                    if ($native_code == "S1000") {
                        $errormsg = odbc_errormsg($this->connection);
                        if (!isset($error_regexps)) {
                            $error_regexps = ["/includes related records.\$/i" => DB_ERROR_CONSTRAINT, "/cannot contain a Null value/i" => DB_ERROR_CONSTRAINT_NOT_NULL];
                        }
                        foreach ($error_regexps as $regexp => $code) {
                            if (preg_match($regexp, $errormsg)) {
                                return $this->raiseError($code, NULL, NULL, NULL, $native_code . " " . $errormsg);
                            }
                        }
                        $errno = DB_ERROR;
                    } else {
                        $errno = $this->errorCode($native_code);
                    }
                    break;
                default:
                    $errno = $this->errorCode(odbc_error($this->connection));
            }
        }
        return $this->raiseError($errno, NULL, NULL, NULL, $this->errorNative());
    }
    public function errorNative()
    {
        if (!is_resource($this->connection)) {
            return @odbc_error() . " " . @odbc_errormsg();
        }
        return @odbc_error($this->connection) . " " . @odbc_errormsg($this->connection);
    }
    public function tableInfo($result, $mode = NULL)
    {
        if (is_string($result)) {
            $id = @odbc_exec($this->connection, "SELECT * FROM " . $result);
            if (!$id) {
                return $this->odbcRaiseError();
            }
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
            return $this->odbcRaiseError(DB_ERROR_NEED_MORE_DATA);
        }
        if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE) {
            $case_func = "strtolower";
        } else {
            $case_func = "strval";
        }
        $count = @odbc_num_fields($id);
        $res = [];
        if ($mode) {
            $res["num_fields"] = $count;
        }
        for ($i = 0; $i < $count; $i++) {
            $col = $i + 1;
            $res[$i] = ["table" => $got_string ? $case_func($result) : "", "name" => $case_func(@odbc_field_name($id, $col)), "type" => @odbc_field_type($id, $col), "len" => @odbc_field_len($id, $col), "flags" => ""];
            if ($mode & DB_TABLEINFO_ORDER) {
                $res["order"][$res[$i]["name"]] = $i;
            }
            if ($mode & DB_TABLEINFO_ORDERTABLE) {
                $res["ordertable"][$res[$i]["table"]][$res[$i]["name"]] = $i;
            }
        }
        if ($got_string) {
            @odbc_free_result($id);
        }
        return $res;
    }
    public function getSpecialQuery($type)
    {
        switch ($type) {
            case "databases":
                if (!function_exists("odbc_data_source")) {
                    return NULL;
                }
                $res = @odbc_data_source($this->connection, SQL_FETCH_FIRST);
                if (is_array($res)) {
                    $out = [$res["server"]];
                    while ($res = @odbc_data_source($this->connection, SQL_FETCH_NEXT)) {
                        $out[] = $res["server"];
                    }
                    return $out;
                }
                return $this->odbcRaiseError();
                break;
            case "tables":
            case "schema.tables":
                $keep = "TABLE";
                break;
            case "views":
                $keep = "VIEW";
                $res = @odbc_tables($this->connection);
                if (!$res) {
                    return $this->odbcRaiseError();
                }
                $out = [];
                while ($row = odbc_fetch_array($res)) {
                    if ($row["TABLE_TYPE"] == $keep) {
                        if ($type == "schema.tables") {
                            $out[] = $row["TABLE_SCHEM"] . "." . $row["TABLE_NAME"];
                        } else {
                            $out[] = $row["TABLE_NAME"];
                        }
                    }
                }
                return $out;
                break;
        }
    }
}

?>