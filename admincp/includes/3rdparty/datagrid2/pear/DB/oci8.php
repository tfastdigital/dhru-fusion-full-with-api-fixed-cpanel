<?php
/*
 *after.com
 * @ Release: 13/06/2023
 */

require_once PEAR_DIR . "DB/common.php";
/**
 * The methods PEAR DB uses to interact with PHP's oci8 extension
 * for interacting with Oracle databases
 *
 * Definitely works with versions 8 and 9 of Oracle.
 *
 * These methods overload the ones declared in DB_common.
 *
 * Be aware...  OCIError() only appears to return anything when given a
 * statement, so functions return the generic DB_ERROR instead of more
 * useful errors that have to do with feedback from the database.
 *
 * @category   Database
 * @package    DB
 * @author     James L. Pine <jlp@valinux.com>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1997-2007 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.7.14RC1
 * @link       http://pear.php.net/package/DB
 */
class DB_oci8 extends DB_common
{
    /**
     * The DB driver type (mysql, oci8, odbc, etc.)
     * @var string
     */
    public $phptype = "oci8";
    /**
     * The database syntax variant to be used (db2, access, etc.), if any
     * @var string
     */
    public $dbsyntax = "oci8";
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
    public $features = ["limit" => "alter", "new_link" => "5.0.0", "numrows" => "subquery", "pconnect" => true, "prepare" => true, "ssl" => false, "transactions" => true];
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
     * Stores the $data passed to execute() in the oci8 driver
     *
     * Gets reset to array() when simpleQuery() is run.
     *
     * Needed in case user wants to call numRows() after prepare/execute
     * was used.
     *
     * @var array
     * @access private
     */
    public $_data = [];
    /**
     * The result or statement handle from the most recently executed query
     * @var resource
     */
    public $last_stmt = NULL;
    /**
     * Is the given prepared statement a data manipulation query?
     * @var array
     * @access private
     */
    public $manip_query = [];
    /**
     * Store of prepared SQL queries.
     * @var array
     * @access private
     */
    public $_prepared_queries = [];
    public function DB_oci8()
    {
        $this->DB_common();
    }
    public function connect($dsn, $persistent = false)
    {
        if (!PEAR::loadExtension("oci8")) {
            return $this->raiseError(DB_ERROR_EXTENSION_NOT_FOUND);
        }
        $this->dsn = $dsn;
        if ($dsn["dbsyntax"]) {
            $this->dbsyntax = $dsn["dbsyntax"];
        }
        if (empty($dsn["database"]) && !empty($dsn["hostspec"])) {
            $db = $dsn["hostspec"];
        } else {
            $db = $dsn["database"];
        }
        if (function_exists("oci_connect")) {
            if (isset($dsn["new_link"]) && ($dsn["new_link"] == "true" || $dsn["new_link"] === true)) {
                $connect_function = "oci_new_connect";
            } else {
                $connect_function = $persistent ? "oci_pconnect" : "oci_connect";
            }
            if (isset($this->dsn["port"]) && $this->dsn["port"]) {
                $db = "//" . $db . ":" . $this->dsn["port"];
            }
            $char = empty($dsn["charset"]) ? NULL : $dsn["charset"];
            $this->connection = $connect_function($dsn["username"], $dsn["password"], $db, $char);
            $error = OCIError();
            if (!empty($error) && $error["code"] == 12541) {
                $this->connection = $connect_function($dsn["username"], $dsn["password"], NULL, $char);
            }
        } else {
            $connect_function = $persistent ? "OCIPLogon" : "OCILogon";
            if ($db) {
                $this->connection = $connect_function($dsn["username"], $dsn["password"], $db);
            } else {
                if ($dsn["username"] || $dsn["password"]) {
                    $this->connection = $connect_function($dsn["username"], $dsn["password"]);
                }
            }
        }
        if (!$this->connection) {
            $error = OCIError();
            $error = is_array($error) ? $error["message"] : NULL;
            return $this->raiseError(DB_ERROR_CONNECT_FAILED, NULL, NULL, NULL, $error);
        }
        return DB_OK;
    }
    public function disconnect()
    {
        if (function_exists("oci_close")) {
            $ret = oci_close($this->connection);
        } else {
            $ret = OCILogOff($this->connection);
        }
        $this->connection = NULL;
        return $ret;
    }
    public function simpleQuery($query)
    {
        $this->_data = [];
        $this->last_parameters = [];
        $this->last_query = $query;
        $query = $this->modifyQuery($query);
        $query = trim($query, ";");
        $result = OCIParse($this->connection, $query);
        if (!$result) {
            return $this->oci8RaiseError();
        }
        if ($this->autocommit) {
            $success = OCIExecute($result, OCI_COMMIT_ON_SUCCESS);
        } else {
            $success = OCIExecute($result, OCI_DEFAULT);
        }
        if (!$success) {
            return $this->oci8RaiseError($result);
        }
        $this->last_stmt = $result;
        if ($this->_checkManip($query)) {
            return DB_OK;
        }
        ocisetprefetch($result, $this->options["result_buffering"]);
        return $result;
    }
    public function nextResult($result)
    {
        return false;
    }
    public function fetchInto($result, &$arr, $fetchmode, $rownum = NULL)
    {
        if ($rownum !== NULL) {
            return $this->raiseError(DB_ERROR_NOT_CAPABLE);
        }
        if ($fetchmode & DB_FETCHMODE_ASSOC) {
            $moredata = OCIFetchInto($result, $arr, OCI_ASSOC + OCI_RETURN_NULLS + OCI_RETURN_LOBS);
            if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE && $moredata) {
                $arr = array_change_key_case($arr, CASE_LOWER);
            }
        } else {
            $moredata = OCIFetchInto($result, $arr, OCI_RETURN_NULLS + OCI_RETURN_LOBS);
        }
        if (!$moredata) {
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
        return is_resource($result) ? OCIFreeStatement($result) : false;
    }
    public function freePrepared($stmt, $free_resource = true)
    {
        if (!is_resource($stmt)) {
            return false;
        }
        if ($free_resource) {
            ocifreestatement($stmt);
        }
        if (isset($this->prepare_types[(int) $stmt])) {
            unset($this->prepare_types[(int) $stmt]);
            unset($this->manip_query[(int) $stmt]);
            return true;
        }
        return false;
    }
    public function numRows($result)
    {
        if ($result === $this->last_stmt) {
            $countquery = "SELECT COUNT(*) FROM (" . $this->last_query . ")";
            $save_query = $this->last_query;
            $save_stmt = $this->last_stmt;
            $count = $this->query($countquery);
            $this->last_query = $save_query;
            $this->last_stmt = $save_stmt;
            if (DB::isError($count) || DB::isError($row = $count->fetchRow(DB_FETCHMODE_ORDERED))) {
                return $this->raiseError(DB_ERROR_NOT_CAPABLE);
            }
            return $row[0];
        }
        return $this->raiseError(DB_ERROR_NOT_CAPABLE);
    }
    public function numCols($result)
    {
        $cols = OCINumCols($result);
        if (!$cols) {
            return $this->oci8RaiseError($result);
        }
        return $cols;
    }
    public function prepare($query)
    {
        $tokens = preg_split("/((?<!\\\\)[&?!])/", $query, -1, PREG_SPLIT_DELIM_CAPTURE);
        $binds = count($tokens) - 1;
        $token = 0;
        $types = [];
        $newquery = "";
        foreach ($tokens as $key => $val) {
            switch ($val) {
                case "?":
                    $types[$token++] = DB_PARAM_SCALAR;
                    unset($tokens[$key]);
                    break;
                case "&":
                    $types[$token++] = DB_PARAM_OPAQUE;
                    unset($tokens[$key]);
                    break;
                case "!":
                    $types[$token++] = DB_PARAM_MISC;
                    unset($tokens[$key]);
                    break;
                default:
                    $tokens[$key] = preg_replace("/\\\\([&?!])/", "\\1", $val);
                    if ($key != $binds) {
                        $newquery .= $tokens[$key] . ":bind" . $token;
                    } else {
                        $newquery .= $tokens[$key];
                    }
            }
        }
        $this->last_query = $query;
        $newquery = $this->modifyQuery($newquery);
        if (!($stmt = OCIParse($this->connection, $newquery))) {
            return $this->oci8RaiseError();
        }
        $this->prepare_types[(int) $stmt] = $types;
        $this->manip_query[(int) $stmt] = DB::isManip($query);
        $this->_prepared_queries[(int) $stmt] = $newquery;
        return $stmt;
    }
    public function &execute($stmt, $data = [])
    {
        $data = (array) $data;
        $this->last_parameters = $data;
        $this->last_query = $this->_prepared_queries[(int) $stmt];
        $this->_data = $data;
        $types = $this->prepare_types[(int) $stmt];
        if (count($types) != count($data)) {
            $tmp = $this->raiseError(DB_ERROR_MISMATCH);
            return $tmp;
        }
        $i = 0;
        foreach ($data as $key => $value) {
            if ($types[$i] == DB_PARAM_MISC) {
                $data[$key] = preg_replace("/^'(.*)'\$/", "\\1", $data[$key]);
                $data[$key] = str_replace("''", "'", $data[$key]);
            } else {
                if ($types[$i] == DB_PARAM_OPAQUE) {
                    $fp = fopen($data[$key], "rb");
                    if (!$fp) {
                        $tmp = $this->raiseError(DB_ERROR_ACCESS_VIOLATION);
                        return $tmp;
                    }
                    $data[$key] = fread($fp, filesize($data[$key]));
                    fclose($fp);
                } else {
                    if ($types[$i] == DB_PARAM_SCALAR && is_float($data[$key])) {
                        $data[$key] = $this->quoteFloat($data[$key]);
                    }
                }
            }
            if (!OCIBindByName($stmt, ":bind" . $i, $data[$key], -1)) {
                $tmp = $this->oci8RaiseError($stmt);
                return $tmp;
            }
            $this->last_query = preg_replace("/:bind" . $i . "/", $this->quoteSmart($data[$key]), $this->last_query, 1);
            $i++;
        }
        if ($this->autocommit) {
            $success = OCIExecute($stmt, OCI_COMMIT_ON_SUCCESS);
        } else {
            $success = OCIExecute($stmt, OCI_DEFAULT);
        }
        if (!$success) {
            $tmp = $this->oci8RaiseError($stmt);
            return $tmp;
        }
        $this->last_stmt = $stmt;
        if ($this->manip_query[(int) $stmt] || $this->_next_query_manip) {
            $this->_last_query_manip = true;
            $this->_next_query_manip = false;
            $tmp = DB_OK;
        } else {
            $this->_last_query_manip = false;
            ocisetprefetch($stmt, $this->options["result_buffering"]);
            $tmp = new DB_result($this, $stmt);
        }
        return $tmp;
    }
    public function autoCommit($onoff = false)
    {
        $this->autocommit = (bool) $onoff;
        return DB_OK;
    }
    public function commit()
    {
        $result = OCICommit($this->connection);
        if (!$result) {
            return $this->oci8RaiseError();
        }
        return DB_OK;
    }
    public function rollback()
    {
        $result = OCIRollback($this->connection);
        if (!$result) {
            return $this->oci8RaiseError();
        }
        return DB_OK;
    }
    public function affectedRows()
    {
        if ($this->last_stmt === false) {
            return $this->oci8RaiseError();
        }
        $result = OCIRowCount($this->last_stmt);
        if ($result === false) {
            return $this->oci8RaiseError($this->last_stmt);
        }
        return $result;
    }
    public function modifyQuery($query)
    {
        if (preg_match("/^\\s*SELECT/i", $query) && !preg_match("/\\sFROM\\s/i", $query)) {
            $query .= " FROM dual";
        }
        return $query;
    }
    public function modifyLimitQuery($query, $from, $count, $params = [])
    {
        if (count($params)) {
            $result = $this->prepare("SELECT * FROM (" . $query . ") " . "WHERE NULL = NULL");
            $tmp = $this->execute($result, $params);
        } else {
            $q_fields = "SELECT * FROM (" . $query . ") WHERE NULL = NULL";
            if (!($result = OCIParse($this->connection, $q_fields))) {
                $this->last_query = $q_fields;
                return $this->oci8RaiseError();
            }
            if (!OCIExecute($result, OCI_DEFAULT)) {
                $this->last_query = $q_fields;
                return $this->oci8RaiseError($result);
            }
        }
        $ncols = OCINumCols($result);
        $cols = [];
        for ($i = 1; $i <= $ncols; $i++) {
            $cols[] = "\"" . OCIColumnName($result, $i) . "\"";
        }
        $fields = implode(", ", $cols);
        $query = "SELECT " . $fields . " FROM" . "  (SELECT rownum as linenum, " . $fields . " FROM" . "      (" . $query . ")" . "  WHERE rownum <= " . ($from + $count) . ") WHERE linenum >= " . ++$from;
        return $query;
    }
    public function nextId($seq_name, $ondemand = true)
    {
        $seqname = $this->getSequenceName($seq_name);
        do {
            $repeat = 0;
            $this->expectError(DB_ERROR_NOSUCHTABLE);
            $result = $this->query("SELECT " . $seqname . ".nextval FROM dual");
            $this->popExpect();
            if ($ondemand && DB::isError($result) && $result->getCode() == DB_ERROR_NOSUCHTABLE) {
                $repeat = 1;
                $result = $this->createSequence($seq_name);
                if (DB::isError($result)) {
                    return $this->raiseError($result);
                }
            } else {
                $repeat = 0;
            }
        } while (!$repeat);
        if (DB::isError($result)) {
            return $this->raiseError($result);
        }
        $arr = $result->fetchRow(DB_FETCHMODE_ORDERED);
        return $arr[0];
    }
    public function createSequence($seq_name)
    {
        return $this->query("CREATE SEQUENCE " . $this->getSequenceName($seq_name));
    }
    public function dropSequence($seq_name)
    {
        return $this->query("DROP SEQUENCE " . $this->getSequenceName($seq_name));
    }
    public function oci8RaiseError($errno = NULL)
    {
        if ($errno === NULL) {
            $error = OCIError($this->connection);
            return $this->raiseError($this->errorCode($error["code"]), NULL, NULL, NULL, $error["message"]);
        }
        if (is_resource($errno)) {
            $error = OCIError($errno);
            return $this->raiseError($this->errorCode($error["code"]), NULL, NULL, NULL, $error["message"]);
        }
        return $this->raiseError($this->errorCode($errno));
    }
    public function errorNative()
    {
        if (is_resource($this->last_stmt)) {
            $error = OCIError($this->last_stmt);
        } else {
            $error = OCIError($this->connection);
        }
        if (is_array($error)) {
            return $error["code"];
        }
        return false;
    }
    public function tableInfo($result, $mode = NULL)
    {
        if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE) {
            $case_func = "strtolower";
        } else {
            $case_func = "strval";
        }
        $res = [];
        if (is_string($result)) {
            $result = strtoupper($result);
            $q_fields = "SELECT column_name, data_type, data_length, nullable FROM user_tab_columns " . "WHERE table_name='" . $result . "' ORDER BY column_id";
            $this->last_query = $q_fields;
            if (!($stmt = OCIParse($this->connection, $q_fields))) {
                return $this->oci8RaiseError(DB_ERROR_NEED_MORE_DATA);
            }
            if (!OCIExecute($stmt, OCI_DEFAULT)) {
                return $this->oci8RaiseError($stmt);
            }
            for ($i = 0; OCIFetch($stmt); $i++) {
                $res[$i] = ["table" => $case_func($result), "name" => $case_func(OCIResult($stmt, 1)), "type" => OCIResult($stmt, 2), "len" => OCIResult($stmt, 3), "flags" => OCIResult($stmt, 4) == "N" ? "not_null" : ""];
                if ($mode & DB_TABLEINFO_ORDER) {
                    $res["order"][$res[$i]["name"]] = $i;
                }
                if ($mode & DB_TABLEINFO_ORDERTABLE) {
                    $res["ordertable"][$res[$i]["table"]][$res[$i]["name"]] = $i;
                }
            }
            if ($mode) {
                $res["num_fields"] = $i;
            }
            OCIFreeStatement($stmt);
        } else {
            if (isset($result->result)) {
                $result = $result->result;
            }
            $res = [];
            if ($result === $this->last_stmt) {
                $count = OCINumCols($result);
                if ($mode) {
                    $res["num_fields"] = $count;
                }
                for ($i = 0; $i < $count; $i++) {
                    $res[$i] = ["table" => "", "name" => $case_func(OCIColumnName($result, $i + 1)), "type" => OCIColumnType($result, $i + 1), "len" => OCIColumnSize($result, $i + 1), "flags" => ""];
                    if ($mode & DB_TABLEINFO_ORDER) {
                        $res["order"][$res[$i]["name"]] = $i;
                    }
                    if ($mode & DB_TABLEINFO_ORDERTABLE) {
                        $res["ordertable"][$res[$i]["table"]][$res[$i]["name"]] = $i;
                    }
                }
            } else {
                return $this->raiseError(DB_ERROR_NOT_CAPABLE);
            }
        }
        return $res;
    }
    public function getSpecialQuery($type)
    {
        switch ($type) {
            case "tables":
                return "SELECT table_name FROM user_tables";
                break;
            case "synonyms":
                return "SELECT synonym_name FROM user_synonyms";
                break;
            case "views":
                return "SELECT view_name FROM user_views";
                break;
        }
    }
    public function quoteFloat($float)
    {
        return $this->escapeSimple(str_replace(",", ".", strval(floatval($float))));
    }
}

?>