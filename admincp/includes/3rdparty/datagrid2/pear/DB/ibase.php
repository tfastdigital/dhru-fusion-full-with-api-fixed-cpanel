<?php
/*
 *after.com
 * @ Release: 13/06/2023
 */

require_once PEAR_DIR . "DB/common.php";
/**
 * The methods PEAR DB uses to interact with PHP's interbase extension
 * for interacting with Interbase and Firebird databases
 *
 * These methods overload the ones declared in DB_common.
 *
 * While this class works with PHP 4, PHP's InterBase extension is
 * unstable in PHP 4.  Use PHP 5.
 *
 * NOTICE:  limitQuery() only works for Firebird.
 *
 * @category   Database
 * @package    DB
 * @author     Sterling Hughes <sterling@php.net>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1997-2007 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.7.14RC1
 * @link       http://pear.php.net/package/DB
 * @since      Class became stable in Release 1.7.0
 */
class DB_ibase extends DB_common
{
    /**
     * The DB driver type (mysql, oci8, odbc, etc.)
     * @var string
     */
    public $phptype = "ibase";
    /**
     * The database syntax variant to be used (db2, access, etc.), if any
     * @var string
     */
    public $dbsyntax = "ibase";
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
     * NOTE: only firebird supports limit.
     *
     * @var array
     */
    public $features = ["limit" => false, "new_link" => false, "numrows" => "emulate", "pconnect" => true, "prepare" => true, "ssl" => false, "transactions" => true];
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
    /**
     * Should data manipulation queries be committed automatically?
     * @var bool
     * @access private
     */
    public $autocommit = true;
    /**
     * The prepared statement handle from the most recently executed statement
     *
     * {@internal  Mainly here because the InterBase/Firebird API is only
     * able to retrieve data from result sets if the statemnt handle is
     * still in scope.}}
     *
     * @var resource
     */
    public $last_stmt = NULL;
    /**
     * Is the given prepared statement a data manipulation query?
     * @var array
     * @access private
     */
    public $manip_query = [];
    public function DB_ibase()
    {
        $this->DB_common();
    }
    public function connect($dsn, $persistent = false)
    {
        if (!PEAR::loadExtension("interbase")) {
            return $this->raiseError(DB_ERROR_EXTENSION_NOT_FOUND);
        }
        $this->dsn = $dsn;
        if ($dsn["dbsyntax"]) {
            $this->dbsyntax = $dsn["dbsyntax"];
        }
        if ($this->dbsyntax == "firebird") {
            $this->features["limit"] = "alter";
        }
        $params = [$dsn["hostspec"] ? $dsn["hostspec"] . ":" . $dsn["database"] : $dsn["database"], $dsn["username"] ? $dsn["username"] : NULL, $dsn["password"] ? $dsn["password"] : NULL, isset($dsn["charset"]) ? $dsn["charset"] : NULL, isset($dsn["buffers"]) ? $dsn["buffers"] : NULL, isset($dsn["dialect"]) ? $dsn["dialect"] : NULL, isset($dsn["role"]) ? $dsn["role"] : NULL];
        $connect_function = $persistent ? "ibase_pconnect" : "ibase_connect";
        $this->connection = call_user_func_array($connect_function, $params);
        if (!$this->connection) {
            return $this->ibaseRaiseError(DB_ERROR_CONNECT_FAILED);
        }
        return DB_OK;
    }
    public function disconnect()
    {
        $ret = ibase_close($this->connection);
        $this->connection = NULL;
        return $ret;
    }
    public function simpleQuery($query)
    {
        $ismanip = $this->_checkManip($query);
        $this->last_query = $query;
        $query = $this->modifyQuery($query);
        $result = ibase_query($this->connection, $query);
        if (!$result) {
            return $this->ibaseRaiseError();
        }
        if ($this->autocommit && $ismanip) {
            ibase_commit($this->connection);
        }
        if ($ismanip) {
            $this->affected = $result;
            return DB_OK;
        }
        $this->affected = 0;
        return $result;
    }
    public function modifyLimitQuery($query, $from, $count, $params = [])
    {
        if ($this->dsn["dbsyntax"] == "firebird") {
            $query = preg_replace("/^([\\s(])*SELECT/i", "SELECT FIRST " . $count . " SKIP " . $from, $query);
        }
        return $query;
    }
    public function nextResult($result)
    {
        return false;
    }
    public function fetchInto($result, &$arr, $fetchmode, $rownum = NULL)
    {
        if ($rownum !== NULL) {
            return $this->ibaseRaiseError(DB_ERROR_NOT_CAPABLE);
        }
        if ($fetchmode & DB_FETCHMODE_ASSOC) {
            if (function_exists("ibase_fetch_assoc")) {
                $arr = ibase_fetch_assoc($result);
            } else {
                $arr = get_object_vars(ibase_fetch_object($result));
            }
            if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE && $arr) {
                $arr = array_change_key_case($arr, CASE_LOWER);
            }
        } else {
            $arr = ibase_fetch_row($result);
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
        return is_resource($result) ? ibase_free_result($result) : false;
    }
    public function freeQuery($query)
    {
        return is_resource($query) ? ibase_free_query($query) : false;
    }
    public function affectedRows()
    {
        if (is_integer($this->affected)) {
            return $this->affected;
        }
        return $this->ibaseRaiseError(DB_ERROR_NOT_CAPABLE);
    }
    public function numCols($result)
    {
        $cols = ibase_num_fields($result);
        if (!$cols) {
            return $this->ibaseRaiseError();
        }
        return $cols;
    }
    public function prepare($query)
    {
        $tokens = preg_split("/((?<!\\\\)[&?!])/", $query, -1, PREG_SPLIT_DELIM_CAPTURE);
        $token = 0;
        $types = [];
        $newquery = "";
        foreach ($tokens as $key => $val) {
            switch ($val) {
                case "?":
                    $types[$token++] = DB_PARAM_SCALAR;
                    break;
                case "&":
                    $types[$token++] = DB_PARAM_OPAQUE;
                    break;
                case "!":
                    $types[$token++] = DB_PARAM_MISC;
                    break;
                default:
                    $tokens[$key] = preg_replace("/\\\\([&?!])/", "\\1", $val);
                    $newquery .= $tokens[$key] . "?";
            }
        }
        $newquery = substr($newquery, 0, -1);
        $this->last_query = $query;
        $newquery = $this->modifyQuery($newquery);
        $stmt = ibase_prepare($this->connection, $newquery);
        if ($stmt === false) {
            $stmt = $this->ibaseRaiseError();
        } else {
            $this->prepare_types[(int) $stmt] = $types;
            $this->manip_query[(int) $stmt] = DB::isManip($query);
        }
        return $stmt;
    }
    public function &execute($stmt, $data = [])
    {
        $data = (array) $data;
        $this->last_parameters = $data;
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
                }
            }
            $i++;
        }
        array_unshift($data, $stmt);
        $res = call_user_func_array("ibase_execute", $data);
        if (!$res) {
            $tmp = $this->ibaseRaiseError();
            return $tmp;
        }
        $this->last_stmt = $stmt;
        if ($this->manip_query[(int) $stmt] || $this->_next_query_manip) {
            $this->_last_query_manip = true;
            $this->_next_query_manip = false;
            $tmp = DB_OK;
        } else {
            $this->_last_query_manip = false;
            $tmp = new DB_result($this, $res);
        }
        return $tmp;
    }
    public function freePrepared($stmt, $free_resource = true)
    {
        if (!is_resource($stmt)) {
            return false;
        }
        if ($free_resource) {
            ibase_free_query($stmt);
        }
        unset($this->prepare_tokens[(int) $stmt]);
        unset($this->prepare_types[(int) $stmt]);
        unset($this->manip_query[(int) $stmt]);
        return true;
    }
    public function autoCommit($onoff = false)
    {
        $this->autocommit = $onoff ? 1 : 0;
        return DB_OK;
    }
    public function commit()
    {
        return ibase_commit($this->connection);
    }
    public function rollback()
    {
        return ibase_rollback($this->connection);
    }
    public function transactionInit($trans_args = 0)
    {
        return $trans_args ? ibase_trans($trans_args, $this->connection) : ibase_trans();
    }
    public function nextId($seq_name, $ondemand = true)
    {
        $sqn = strtoupper($this->getSequenceName($seq_name));
        do {
            $repeat = 0;
            $this->pushErrorHandling(PEAR_ERROR_RETURN);
            $result = $this->query("SELECT GEN_ID(" . $sqn . ", 1) " . "FROM RDB\$GENERATORS " . "WHERE RDB\$GENERATOR_NAME='" . $sqn . "'");
            $this->popErrorHandling();
            if ($ondemand && DB::isError($result)) {
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
            return $this->raiseError($result);
        }
        $arr = $result->fetchRow(DB_FETCHMODE_ORDERED);
        $result->free();
        return $arr[0];
    }
    public function createSequence($seq_name)
    {
        $sqn = strtoupper($this->getSequenceName($seq_name));
        $this->pushErrorHandling(PEAR_ERROR_RETURN);
        $result = $this->query("CREATE GENERATOR " . $sqn);
        $this->popErrorHandling();
        return $result;
    }
    public function dropSequence($seq_name)
    {
        return $this->query("DELETE FROM RDB\$GENERATORS WHERE RDB\$GENERATOR_NAME='" . strtoupper($this->getSequenceName($seq_name)) . "'");
    }
    public function _ibaseFieldFlags($field_name, $table_name)
    {
        $sql = "SELECT R.RDB\$CONSTRAINT_TYPE CTYPE FROM RDB\$INDEX_SEGMENTS I  JOIN RDB\$RELATION_CONSTRAINTS R ON I.RDB\$INDEX_NAME=R.RDB\$INDEX_NAME WHERE I.RDB\$FIELD_NAME='" . $field_name . "'" . "  AND UPPER(R.RDB\$RELATION_NAME)='" . strtoupper($table_name) . "'";
        $result = ibase_query($this->connection, $sql);
        if (!$result) {
            return $this->ibaseRaiseError();
        }
        $flags = "";
        if ($obj = ibase_fetch_object($result)) {
            ibase_free_result($result);
            if (isset($obj->CTYPE) && trim($obj->CTYPE) == "PRIMARY KEY") {
                $flags .= "primary_key ";
            }
            if (isset($obj->CTYPE) && trim($obj->CTYPE) == "UNIQUE") {
                $flags .= "unique_key ";
            }
        }
        $sql = "SELECT R.RDB\$NULL_FLAG AS NFLAG,  R.RDB\$DEFAULT_SOURCE AS DSOURCE,  F.RDB\$FIELD_TYPE AS FTYPE,  F.RDB\$COMPUTED_SOURCE AS CSOURCE FROM RDB\$RELATION_FIELDS R   JOIN RDB\$FIELDS F ON R.RDB\$FIELD_SOURCE=F.RDB\$FIELD_NAME WHERE UPPER(R.RDB\$RELATION_NAME)='" . strtoupper($table_name) . "'" . "  AND R.RDB\$FIELD_NAME='" . $field_name . "'";
        $result = ibase_query($this->connection, $sql);
        if (!$result) {
            return $this->ibaseRaiseError();
        }
        if ($obj = ibase_fetch_object($result)) {
            ibase_free_result($result);
            if (isset($obj->NFLAG)) {
                $flags .= "not_null ";
            }
            if (isset($obj->DSOURCE)) {
                $flags .= "default ";
            }
            if (isset($obj->CSOURCE)) {
                $flags .= "computed ";
            }
            if (isset($obj->FTYPE) && $obj->FTYPE == 261) {
                $flags .= "blob ";
            }
        }
        return trim($flags);
    }
    public function &ibaseRaiseError($errno = NULL)
    {
        if ($errno === NULL) {
            $errno = $this->errorCode($this->errorNative());
        }
        $tmp = $this->raiseError($errno, NULL, NULL, NULL, ibase_errmsg());
        return $tmp;
    }
    public function errorNative()
    {
        if (function_exists("ibase_errcode")) {
            return ibase_errcode();
        }
        if (preg_match("/^Dynamic SQL Error SQL error code = ([0-9-]+)/i", ibase_errmsg(), $m)) {
            return (int) $m[1];
        }
        return NULL;
    }
    public function errorCode($nativecode = NULL)
    {
        if (isset($this->errorcode_map[$nativecode])) {
            return $this->errorcode_map[$nativecode];
        }
        static $error_regexps = NULL;
        if (!isset($error_regexps)) {
            $error_regexps = ["/generator .* is not defined/" => DB_ERROR_SYNTAX, "/table.*(not exist|not found|unknown)/i" => DB_ERROR_NOSUCHTABLE, "/table .* already exists/i" => DB_ERROR_ALREADY_EXISTS, "/unsuccessful metadata update .* failed attempt to store duplicate value/i" => DB_ERROR_ALREADY_EXISTS, "/unsuccessful metadata update .* not found/i" => DB_ERROR_NOT_FOUND, "/validation error for column .* value \"\\*\\*\\* null/i" => DB_ERROR_CONSTRAINT_NOT_NULL, "/violation of [\\w ]+ constraint/i" => DB_ERROR_CONSTRAINT, "/conversion error from string/i" => DB_ERROR_INVALID_NUMBER, "/no permission for/i" => DB_ERROR_ACCESS_VIOLATION, "/arithmetic exception, numeric overflow, or string truncation/i" => DB_ERROR_INVALID, "/feature is not supported/i" => DB_ERROR_NOT_CAPABLE];
        }
        $errormsg = ibase_errmsg();
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
            $id = ibase_query($this->connection, "SELECT * FROM " . $result . " WHERE 1=0");
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
            return $this->ibaseRaiseError(DB_ERROR_NEED_MORE_DATA);
        }
        if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE) {
            $case_func = "strtolower";
        } else {
            $case_func = "strval";
        }
        $count = ibase_num_fields($id);
        $res = [];
        if ($mode) {
            $res["num_fields"] = $count;
        }
        for ($i = 0; $i < $count; $i++) {
            $info = ibase_field_info($id, $i);
            $res[$i] = ["table" => $got_string ? $case_func($result) : "", "name" => $case_func($info["name"]), "type" => $info["type"], "len" => $info["length"], "flags" => $got_string ? $this->_ibaseFieldFlags($info["name"], $result) : ""];
            if ($mode & DB_TABLEINFO_ORDER) {
                $res["order"][$res[$i]["name"]] = $i;
            }
            if ($mode & DB_TABLEINFO_ORDERTABLE) {
                $res["ordertable"][$res[$i]["table"]][$res[$i]["name"]] = $i;
            }
        }
        if ($got_string) {
            ibase_free_result($id);
        }
        return $res;
    }
    public function getSpecialQuery($type)
    {
        switch ($type) {
            case "tables":
                return "SELECT DISTINCT R.RDB\$RELATION_NAME FROM RDB\$RELATION_FIELDS R WHERE R.RDB\$SYSTEM_FLAG=0";
                break;
            case "views":
                return "SELECT DISTINCT RDB\$VIEW_NAME from RDB\$VIEW_RELATIONS";
                break;
            case "users":
                return "SELECT DISTINCT RDB\$USER FROM RDB\$USER_PRIVILEGES";
                break;
        }
    }
}

?>