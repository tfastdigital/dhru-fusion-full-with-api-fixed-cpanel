<?php
/*
 *after.com
 * @ Release: 13/06/2023
 */

require_once PEAR_DIR . "DB/common.php";
/**
 * The methods PEAR DB uses to interact with PHP's pgsql extension
 * for interacting with PostgreSQL databases
 *
 * These methods overload the ones declared in DB_common.
 *
 * @category   Database
 * @package    DB
 * @author     Rui Hirokawa <hirokawa@php.net>
 * @author     Stig Bakken <ssb@php.net>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1997-2007 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.7.14RC1
 * @link       http://pear.php.net/package/DB
 */
class DB_pgsql extends DB_common
{
    /**
     * The DB driver type (mysql, oci8, odbc, etc.)
     * @var string
     */
    public $phptype = "pgsql";
    /**
     * The database syntax variant to be used (db2, access, etc.), if any
     * @var string
     */
    public $dbsyntax = "pgsql";
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
    public $features = ["limit" => "alter", "new_link" => "4.3.0", "numrows" => true, "pconnect" => true, "prepare" => false, "ssl" => true, "transactions" => true];
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
     * The number of rows affected by a data manipulation query
     * @var integer
     */
    public $affected = 0;
    /**
     * The current row being looked at in fetchInto()
     * @var array
     * @access private
     */
    public $row = [];
    /**
     * The number of rows in a given result set
     * @var array
     * @access private
     */
    public $_num_rows = [];
    public function DB_pgsql()
    {
        $this->DB_common();
    }
    public function connect($dsn, $persistent = false)
    {
        if (!PEAR::loadExtension("pgsql")) {
            return $this->raiseError(DB_ERROR_EXTENSION_NOT_FOUND);
        }
        $this->dsn = $dsn;
        if ($dsn["dbsyntax"]) {
            $this->dbsyntax = $dsn["dbsyntax"];
        }
        $protocol = $dsn["protocol"] ? $dsn["protocol"] : "tcp";
        $params = [""];
        if ($protocol == "tcp") {
            if ($dsn["hostspec"]) {
                $params[0] .= "host=" . $dsn["hostspec"];
            }
            if ($dsn["port"]) {
                $params[0] .= " port=" . $dsn["port"];
            }
        } else {
            if ($protocol == "unix") {
                if ($dsn["socket"]) {
                    $params[0] .= "host=" . $dsn["socket"];
                }
                if ($dsn["port"]) {
                    $params[0] .= " port=" . $dsn["port"];
                }
            }
        }
        if ($dsn["database"]) {
            $params[0] .= " dbname='" . addslashes($dsn["database"]) . "'";
        }
        if ($dsn["username"]) {
            $params[0] .= " user='" . addslashes($dsn["username"]) . "'";
        }
        if ($dsn["password"]) {
            $params[0] .= " password='" . addslashes($dsn["password"]) . "'";
        }
        if (!empty($dsn["options"])) {
            $params[0] .= " options=" . $dsn["options"];
        }
        if (!empty($dsn["tty"])) {
            $params[0] .= " tty=" . $dsn["tty"];
        }
        if (!empty($dsn["connect_timeout"])) {
            $params[0] .= " connect_timeout=" . $dsn["connect_timeout"];
        }
        if (!empty($dsn["sslmode"])) {
            $params[0] .= " sslmode=" . $dsn["sslmode"];
        }
        if (!empty($dsn["service"])) {
            $params[0] .= " service=" . $dsn["service"];
        }
        if (isset($dsn["new_link"]) && ($dsn["new_link"] == "true" || $dsn["new_link"] === true) && version_compare(phpversion(), "4.3.0", ">=")) {
            $params[] = PGSQL_CONNECT_FORCE_NEW;
        }
        $connect_function = $persistent ? "pg_pconnect" : "pg_connect";
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
        return DB_OK;
    }
    public function disconnect()
    {
        $ret = pg_close($this->connection);
        $this->connection = NULL;
        return $ret;
    }
    public function simpleQuery($query)
    {
        $ismanip = $this->_checkManip($query);
        $this->last_query = $query;
        $query = $this->modifyQuery($query);
        if (!$this->autocommit && $ismanip) {
            if ($this->transaction_opcount == 0) {
                $result = pg_exec($this->connection, "begin;");
                if (!$result) {
                    return $this->pgsqlRaiseError();
                }
            }
            $this->transaction_opcount++;
        }
        $result = pg_exec($this->connection, $query);
        if (!$result) {
            return $this->pgsqlRaiseError();
        }
        if ($ismanip) {
            $this->affected = pg_affected_rows($result);
            return DB_OK;
        }
        if (preg_match("/^\\s*\\(*\\s*(SELECT|EXPLAIN|FETCH|SHOW)\\s/si", $query)) {
            $this->row[(int) $result] = 0;
            $numrows = $this->numRows($result);
            if (is_object($numrows)) {
                return $numrows;
            }
            $this->_num_rows[(int) $result] = $numrows;
            $this->affected = 0;
            return $result;
        }
        $this->affected = 0;
        return DB_OK;
    }
    public function nextResult($result)
    {
        return false;
    }
    public function fetchInto($result, &$arr, $fetchmode, $rownum = NULL)
    {
        $result_int = (int) $result;
        $rownum = $rownum !== NULL ? $rownum : $this->row[$result_int];
        if ($this->_num_rows[$result_int] <= $rownum) {
            return NULL;
        }
        if ($fetchmode & DB_FETCHMODE_ASSOC) {
            $arr = pg_fetch_array($result, $rownum, PGSQL_ASSOC);
            if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE && $arr) {
                $arr = array_change_key_case($arr, CASE_LOWER);
            }
        } else {
            $arr = pg_fetch_row($result, $rownum);
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
        $this->row[$result_int] = ++$rownum;
        return DB_OK;
    }
    public function freeResult($result)
    {
        if (is_resource($result)) {
            unset($this->row[(int) $result]);
            unset($this->_num_rows[(int) $result]);
            $this->affected = 0;
            return pg_freeresult($result);
        }
        return false;
    }
    public function quote($str)
    {
        return $this->quoteSmart($str);
    }
    public function quoteBoolean($boolean)
    {
        return $boolean ? "TRUE" : "FALSE";
    }
    public function escapeSimple($str)
    {
        if (function_exists("pg_escape_string")) {
            if (version_compare(PHP_VERSION, "5.2.0", ">=")) {
                return pg_escape_string($this->connection, $str);
            }
            return pg_escape_string($str);
        }
        return str_replace("'", "''", str_replace("\\", "\\\\", $str));
    }
    public function numCols($result)
    {
        $cols = pg_numfields($result);
        if (!$cols) {
            return $this->pgsqlRaiseError();
        }
        return $cols;
    }
    public function numRows($result)
    {
        $rows = pg_numrows($result);
        if ($rows === NULL) {
            return $this->pgsqlRaiseError();
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
            $result = pg_exec($this->connection, "end;");
            $this->transaction_opcount = 0;
            if (!$result) {
                return $this->pgsqlRaiseError();
            }
        }
        return DB_OK;
    }
    public function rollback()
    {
        if (0 < $this->transaction_opcount) {
            $result = pg_exec($this->connection, "abort;");
            $this->transaction_opcount = 0;
            if (!$result) {
                return $this->pgsqlRaiseError();
            }
        }
        return DB_OK;
    }
    public function affectedRows()
    {
        return $this->affected;
    }
    public function nextId($seq_name, $ondemand = true)
    {
        $seqname = $this->getSequenceName($seq_name);
        do {
            $repeat = false;
            $this->pushErrorHandling(PEAR_ERROR_RETURN);
            $result = $this->query("SELECT NEXTVAL('" . $seqname . "')");
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
        $result = $this->query("CREATE SEQUENCE " . $seqname);
        return $result;
    }
    public function dropSequence($seq_name)
    {
        return $this->query("DROP SEQUENCE " . $this->getSequenceName($seq_name));
    }
    public function modifyLimitQuery($query, $from, $count, $params = [])
    {
        return $query . " LIMIT " . $count . " OFFSET " . $from;
    }
    public function pgsqlRaiseError($errno = NULL)
    {
        $native = $this->errorNative();
        if (!$native) {
            $native = "Database connection has been lost.";
            $errno = DB_ERROR_CONNECT_FAILED;
        }
        if ($errno === NULL) {
            $errno = $this->errorCode($native);
        }
        return $this->raiseError($errno, NULL, NULL, NULL, $native);
    }
    public function errorNative()
    {
        return pg_errormessage($this->connection);
    }
    public function errorCode($errormsg)
    {
        static $error_regexps = NULL;
        if (!isset($error_regexps)) {
            $error_regexps = ["/column .* (of relation .*)?does not exist/i" => DB_ERROR_NOSUCHFIELD, "/(relation|sequence|table).*does not exist|class .* not found/i" => DB_ERROR_NOSUCHTABLE, "/index .* does not exist/" => DB_ERROR_NOT_FOUND, "/relation .* already exists/i" => DB_ERROR_ALREADY_EXISTS, "/(divide|division) by zero\$/i" => DB_ERROR_DIVZERO, "/pg_atoi: error in .*: can't parse /i" => DB_ERROR_INVALID_NUMBER, "/invalid input syntax for( type)? (integer|numeric)/i" => DB_ERROR_INVALID_NUMBER, "/value .* is out of range for type \\w*int/i" => DB_ERROR_INVALID_NUMBER, "/integer out of range/i" => DB_ERROR_INVALID_NUMBER, "/value too long for type character/i" => DB_ERROR_INVALID, "/attribute .* not found|relation .* does not have attribute/i" => DB_ERROR_NOSUCHFIELD, "/column .* specified in USING clause does not exist in (left|right) table/i" => DB_ERROR_NOSUCHFIELD, "/parser: parse error at or near/i" => DB_ERROR_SYNTAX, "/syntax error at/" => DB_ERROR_SYNTAX, "/column reference .* is ambiguous/i" => DB_ERROR_SYNTAX, "/permission denied/" => DB_ERROR_ACCESS_VIOLATION, "/violates not-null constraint/" => DB_ERROR_CONSTRAINT_NOT_NULL, "/violates [\\w ]+ constraint/" => DB_ERROR_CONSTRAINT, "/referential integrity violation/" => DB_ERROR_CONSTRAINT, "/more expressions than target columns/i" => DB_ERROR_VALUE_COUNT_ON_ROW];
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
            $id = pg_exec($this->connection, "SELECT * FROM " . $result . " LIMIT 0");
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
            return $this->pgsqlRaiseError(DB_ERROR_NEED_MORE_DATA);
        }
        if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE) {
            $case_func = "strtolower";
        } else {
            $case_func = "strval";
        }
        $count = pg_numfields($id);
        $res = [];
        if ($mode) {
            $res["num_fields"] = $count;
        }
        for ($i = 0; $i < $count; $i++) {
            $res[$i] = ["table" => $got_string ? $case_func($result) : "", "name" => $case_func(pg_fieldname($id, $i)), "type" => pg_fieldtype($id, $i), "len" => pg_fieldsize($id, $i), "flags" => $got_string ? $this->_pgFieldFlags($id, $i, $result) : ""];
            if ($mode & DB_TABLEINFO_ORDER) {
                $res["order"][$res[$i]["name"]] = $i;
            }
            if ($mode & DB_TABLEINFO_ORDERTABLE) {
                $res["ordertable"][$res[$i]["table"]][$res[$i]["name"]] = $i;
            }
        }
        if ($got_string) {
            pg_freeresult($id);
        }
        return $res;
    }
    public function _pgFieldFlags($resource, $num_field, $table_name)
    {
        $field_name = pg_fieldname($resource, $num_field);
        $from = "pg_attribute f, pg_class tab, pg_type typ";
        if (strpos($table_name, ".") !== false) {
            $from .= ", pg_namespace nsp";
            list($schema, $table) = explode(".", $table_name);
            $tableWhere = "tab.relname = '" . $table . "' AND tab.relnamespace = nsp.oid AND nsp.nspname = '" . $schema . "'";
        } else {
            $tableWhere = "tab.relname = '" . $table_name . "'";
        }
        $result = pg_exec($this->connection, "SELECT f.attnotnull, f.atthasdef\n                                FROM " . $from . "\n                                WHERE tab.relname = typ.typname\n                                AND typ.typrelid = f.attrelid\n                                AND f.attname = '" . $field_name . "'\n                                AND " . $tableWhere);
        if (0 < pg_numrows($result)) {
            $row = pg_fetch_row($result, 0);
            $flags = $row[0] == "t" ? "not_null " : "";
            if ($row[1] == "t") {
                $result = pg_exec($this->connection, "SELECT a.adsrc\n                                    FROM " . $from . ", pg_attrdef a\n                                    WHERE tab.relname = typ.typname AND typ.typrelid = f.attrelid\n                                    AND f.attrelid = a.adrelid AND f.attname = '" . $field_name . "'\n                                    AND " . $tableWhere . " AND f.attnum = a.adnum");
                $row = pg_fetch_row($result, 0);
                $num = preg_replace("/'(.*)'::\\w+/", "\\1", $row[0]);
                $flags .= "default_" . rawurlencode($num) . " ";
            }
        } else {
            $flags = "";
        }
        $result = pg_exec($this->connection, "SELECT i.indisunique, i.indisprimary, i.indkey\n                                FROM " . $from . ", pg_index i\n                                WHERE tab.relname = typ.typname\n                                AND typ.typrelid = f.attrelid\n                                AND f.attrelid = i.indrelid\n                                AND f.attname = '" . $field_name . "'\n                                AND " . $tableWhere);
        $count = pg_numrows($result);
        for ($i = 0; $i < $count; $i++) {
            $row = pg_fetch_row($result, $i);
            $keys = explode(" ", $row[2]);
            if (in_array($num_field + 1, $keys)) {
                $flags .= $row[0] == "t" && $row[1] == "f" ? "unique_key " : "";
                $flags .= $row[1] == "t" ? "primary_key " : "";
                if (1 < count($keys)) {
                    $flags .= "multiple_key ";
                }
            }
        }
        return trim($flags);
    }
    public function getSpecialQuery($type)
    {
        switch ($type) {
            case "tables":
                return "SELECT c.relname AS \"Name\" FROM pg_class c, pg_user u WHERE c.relowner = u.usesysid AND c.relkind = 'r' AND NOT EXISTS (SELECT 1 FROM pg_views  WHERE viewname = c.relname) AND c.relname !~ '^(pg_|sql_)' UNION SELECT c.relname AS \"Name\" FROM pg_class c WHERE c.relkind = 'r' AND NOT EXISTS (SELECT 1 FROM pg_views  WHERE viewname = c.relname) AND NOT EXISTS (SELECT 1 FROM pg_user  WHERE usesysid = c.relowner) AND c.relname !~ '^pg_'";
                break;
            case "schema.tables":
                return "SELECT schemaname || '.' || tablename AS \"Name\" FROM pg_catalog.pg_tables WHERE schemaname NOT IN ('pg_catalog', 'information_schema', 'pg_toast')";
                break;
            case "schema.views":
                return "SELECT schemaname || '.' || viewname from pg_views WHERE schemaname NOT IN ('information_schema', 'pg_catalog')";
                break;
            case "views":
                return "SELECT viewname from pg_views WHERE schemaname NOT IN ('information_schema', 'pg_catalog')";
                break;
            case "users":
                return "SELECT usename FROM pg_user";
                break;
            case "databases":
                return "SELECT datname FROM pg_database";
                break;
            case "functions":
            case "procedures":
                return "SELECT proname FROM pg_proc WHERE proowner <> 1";
                break;
        }
    }
    public function _checkManip($query)
    {
        return preg_match("/^\\s*(SAVEPOINT|RELEASE)\\s+/i", $query) || parent::_checkManip($query);
    }
}

?>