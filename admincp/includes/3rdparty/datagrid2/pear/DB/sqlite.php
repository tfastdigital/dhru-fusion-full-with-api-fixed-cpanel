<?php
/*
 *after.com
 * @ Release: 13/06/2023
 */

require_once PEAR_DIR . "DB/common.php";
/**
 * The methods PEAR DB uses to interact with PHP's sqlite extension
 * for interacting with SQLite databases
 *
 * These methods overload the ones declared in DB_common.
 *
 * NOTICE:  This driver needs PHP's track_errors ini setting to be on.
 * It is automatically turned on when connecting to the database.
 * Make sure your scripts don't turn it off.
 *
 * @category   Database
 * @package    DB
 * @author     Urs Gehrig <urs@circle.ch>
 * @author     Mika Tuupola <tuupola@appelsiini.net>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1997-2007 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0 3.0
 * @version    Release: 1.7.14RC1
 * @link       http://pear.php.net/package/DB
 */
class DB_sqlite extends DB_common
{
    /**
     * The DB driver type (mysql, oci8, odbc, etc.)
     * @var string
     */
    public $phptype = "sqlite";
    /**
     * The database syntax variant to be used (db2, access, etc.), if any
     * @var string
     */
    public $dbsyntax = "sqlite";
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
    public $features = ["limit" => "alter", "new_link" => false, "numrows" => true, "pconnect" => true, "prepare" => false, "ssl" => false, "transactions" => false];
    /**
     * A mapping of native error codes to DB error codes
     *
     * {@internal  Error codes according to sqlite_exec.  See the online
     * manual at http://sqlite.org/c_interface.html for info.
     * This error handling based on sqlite_exec is not yet implemented.}}
     *
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
     * SQLite data types
     *
     * @link http://www.sqlite.org/datatypes.html
     *
     * @var array
     */
    public $keywords = ["BLOB" => "", "BOOLEAN" => "", "CHARACTER" => "", "CLOB" => "", "FLOAT" => "", "INTEGER" => "", "KEY" => "", "NATIONAL" => "", "NUMERIC" => "", "NVARCHAR" => "", "PRIMARY" => "", "TEXT" => "", "TIMESTAMP" => "", "UNIQUE" => "", "VARCHAR" => "", "VARYING" => ""];
    /**
     * The most recent error message from $php_errormsg
     * @var string
     * @access private
     */
    public $_lasterror = "";
    public function DB_sqlite()
    {
        $this->DB_common();
    }
    public function connect($dsn, $persistent = false)
    {
        if (!PEAR::loadExtension("sqlite")) {
            return $this->raiseError(DB_ERROR_EXTENSION_NOT_FOUND);
        }
        $this->dsn = $dsn;
        if ($dsn["dbsyntax"]) {
            $this->dbsyntax = $dsn["dbsyntax"];
        }
        if (!$dsn["database"]) {
            return $this->sqliteRaiseError(DB_ERROR_ACCESS_VIOLATION);
        }
        if ($dsn["database"] !== ":memory:") {
            if (!file_exists($dsn["database"])) {
                if (!touch($dsn["database"])) {
                    return $this->sqliteRaiseError(DB_ERROR_NOT_FOUND);
                }
                if (!isset($dsn["mode"]) || !is_numeric($dsn["mode"])) {
                    $mode = 420;
                } else {
                    $mode = octdec($dsn["mode"]);
                }
                if (!chmod($dsn["database"], $mode)) {
                    return $this->sqliteRaiseError(DB_ERROR_NOT_FOUND);
                }
                if (!file_exists($dsn["database"])) {
                    return $this->sqliteRaiseError(DB_ERROR_NOT_FOUND);
                }
            }
            if (!is_file($dsn["database"])) {
                return $this->sqliteRaiseError(DB_ERROR_INVALID);
            }
            if (!is_readable($dsn["database"])) {
                return $this->sqliteRaiseError(DB_ERROR_ACCESS_VIOLATION);
            }
        }
        $connect_function = $persistent ? "sqlite_popen" : "sqlite_open";
        ini_set("track_errors", 1);
        $php_errormsg = "";
        if (!($this->connection = $connect_function($dsn["database"]))) {
            return $this->raiseError(DB_ERROR_NODBSELECTED, NULL, NULL, NULL, $php_errormsg);
        }
        return DB_OK;
    }
    public function disconnect()
    {
        $ret = sqlite_close($this->connection);
        $this->connection = NULL;
        return $ret;
    }
    public function simpleQuery($query)
    {
        $ismanip = $this->_checkManip($query);
        $this->last_query = $query;
        $query = $this->modifyQuery($query);
        $php_errormsg = "";
        $result = sqlite_query($query, $this->connection);
        $this->_lasterror = $php_errormsg ? $php_errormsg : "";
        $this->result = $result;
        if (!$this->result) {
            return $this->sqliteRaiseError(NULL);
        }
        if (!$ismanip) {
            $numRows = $this->numRows($result);
            if (is_object($numRows)) {
                return $numRows;
            }
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
        if ($rownum !== NULL && !sqlite_seek($this->result, $rownum)) {
            return NULL;
        }
        if ($fetchmode & DB_FETCHMODE_ASSOC) {
            $arr = sqlite_fetch_array($result, SQLITE_ASSOC);
            if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE && $arr) {
                $arr = array_change_key_case($arr, CASE_LOWER);
            }
            if (is_array($arr) && 0 < count($arr)) {
                $strippedArr = [];
                foreach ($arr as $field => $value) {
                    $strippedArr[trim($field, "\"")] = $value;
                }
                $arr = $strippedArr;
            }
        } else {
            $arr = sqlite_fetch_array($result, SQLITE_NUM);
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
    public function freeResult(&$result)
    {
        if (!is_resource($result)) {
            return false;
        }
        $result = NULL;
        return true;
    }
    public function numCols($result)
    {
        $cols = sqlite_num_fields($result);
        if (!$cols) {
            return $this->sqliteRaiseError();
        }
        return $cols;
    }
    public function numRows($result)
    {
        $rows = sqlite_num_rows($result);
        if ($rows === NULL) {
            return $this->sqliteRaiseError();
        }
        return $rows;
    }
    public function affectedRows()
    {
        return sqlite_changes($this->connection);
    }
    public function dropSequence($seq_name)
    {
        return $this->query("DROP TABLE " . $this->getSequenceName($seq_name));
    }
    public function createSequence($seq_name)
    {
        $seqname = $this->getSequenceName($seq_name);
        $query = "CREATE TABLE " . $seqname . " (id INTEGER UNSIGNED PRIMARY KEY) ";
        $result = $this->query($query);
        if (DB::isError($result)) {
            return $result;
        }
        $query = "CREATE TRIGGER " . $seqname . "_cleanup AFTER INSERT ON " . $seqname . "\n                    BEGIN\n                        DELETE FROM " . $seqname . " WHERE id<LAST_INSERT_ROWID();\n                    END ";
        $result = $this->query($query);
        if (DB::isError($result)) {
            return $result;
        }
    }
    public function nextId($seq_name, $ondemand = true)
    {
        do {
            $seqname = $this->getSequenceName($seq_name);
            $repeat = 0;
            $this->pushErrorHandling(PEAR_ERROR_RETURN);
            $result = $this->query("INSERT INTO " . $seqname . " (id) VALUES (NULL)");
            $this->popErrorHandling();
            if ($result === DB_OK) {
                $id = sqlite_last_insert_rowid($this->connection);
                if ($id != 0) {
                    return $id;
                }
            } else {
                if ($ondemand && DB::isError($result) && $result->getCode() == DB_ERROR_NOSUCHTABLE) {
                    $result = $this->createSequence($seq_name);
                    if (DB::isError($result)) {
                        return $this->raiseError($result);
                    }
                    $repeat = 1;
                }
            }
        } while (!$repeat);
        return $this->raiseError($result);
    }
    public function getDbFileStats($arg = "")
    {
        $stats = stat($this->dsn["database"]);
        if (!$stats) {
            return false;
        }
        if (is_array($stats)) {
            if (is_numeric($arg)) {
                if ((int) $arg <= 12 & 0 <= (int) $arg) {
                    return false;
                }
                return $stats[$arg];
            }
            if (array_key_exists(trim($arg), $stats)) {
                return $stats[$arg];
            }
        }
        return $stats;
    }
    public function escapeSimple($str)
    {
        return sqlite_escape_string($str);
    }
    public function modifyLimitQuery($query, $from, $count, $params = [])
    {
        return $query . " LIMIT " . $count . " OFFSET " . $from;
    }
    public function modifyQuery($query)
    {
        if ($this->options["portability"] & DB_PORTABILITY_DELETE_COUNT && preg_match("/^\\s*DELETE\\s+FROM\\s+(\\S+)\\s*\$/i", $query)) {
            $query = preg_replace("/^\\s*DELETE\\s+FROM\\s+(\\S+)\\s*\$/", "DELETE FROM \\1 WHERE 1=1", $query);
        }
        return $query;
    }
    public function sqliteRaiseError($errno = NULL)
    {
        $native = $this->errorNative();
        if ($errno === NULL) {
            $errno = $this->errorCode($native);
        }
        $errorcode = sqlite_last_error($this->connection);
        $userinfo = $errorcode . " ** " . $this->last_query;
        return $this->raiseError($errno, NULL, NULL, $userinfo, $native);
    }
    public function errorNative()
    {
        return $this->_lasterror;
    }
    public function errorCode($errormsg)
    {
        static $error_regexps = NULL;
        $errormsg = preg_replace("/^sqlite[a-z_]+\\(\\): /", "", $errormsg);
        if (!isset($error_regexps)) {
            $error_regexps = ["/^no such table:/" => DB_ERROR_NOSUCHTABLE, "/^no such index:/" => DB_ERROR_NOT_FOUND, "/^(table|index) .* already exists\$/" => DB_ERROR_ALREADY_EXISTS, "/PRIMARY KEY must be unique/i" => DB_ERROR_CONSTRAINT, "/is not unique/" => DB_ERROR_CONSTRAINT, "/columns .* are not unique/i" => DB_ERROR_CONSTRAINT, "/uniqueness constraint failed/" => DB_ERROR_CONSTRAINT, "/may not be NULL/" => DB_ERROR_CONSTRAINT_NOT_NULL, "/^no such column:/" => DB_ERROR_NOSUCHFIELD, "/no column named/" => DB_ERROR_NOSUCHFIELD, "/column not present in both tables/i" => DB_ERROR_NOSUCHFIELD, "/^near \".*\": syntax error\$/" => DB_ERROR_SYNTAX, "/[0-9]+ values for [0-9]+ columns/i" => DB_ERROR_VALUE_COUNT_ON_ROW];
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
            $id = sqlite_array_query($this->connection, "PRAGMA table_info('" . $result . "');", SQLITE_ASSOC);
            $got_string = true;
            if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE) {
                $case_func = "strtolower";
            } else {
                $case_func = "strval";
            }
            $count = count($id);
            $res = [];
            if ($mode) {
                $res["num_fields"] = $count;
            }
            for ($i = 0; $i < $count; $i++) {
                if (strpos($id[$i]["type"], "(") !== false) {
                    $bits = explode("(", $id[$i]["type"]);
                    $type = $bits[0];
                    $len = rtrim($bits[1], ")");
                } else {
                    $type = $id[$i]["type"];
                    $len = 0;
                }
                $flags = "";
                if ($id[$i]["pk"]) {
                    $flags .= "primary_key ";
                }
                if ($id[$i]["notnull"]) {
                    $flags .= "not_null ";
                }
                if ($id[$i]["dflt_value"] !== NULL) {
                    $flags .= "default_" . rawurlencode($id[$i]["dflt_value"]);
                }
                $flags = trim($flags);
                $res[$i] = ["table" => $case_func($result), "name" => $case_func($id[$i]["name"]), "type" => $type, "len" => $len, "flags" => $flags];
                if ($mode & DB_TABLEINFO_ORDER) {
                    $res["order"][$res[$i]["name"]] = $i;
                }
                if ($mode & DB_TABLEINFO_ORDERTABLE) {
                    $res["ordertable"][$res[$i]["table"]][$res[$i]["name"]] = $i;
                }
            }
            return $res;
        }
        $this->last_query = "";
        return $this->raiseError(DB_ERROR_NOT_CAPABLE, NULL, NULL, NULL, "This DBMS can not obtain tableInfo from result sets");
    }
    public function getSpecialQuery($type, $args = [])
    {
        while (!is_array($args)) {
            switch ($type) {
                case "master":
                    return "SELECT * FROM sqlite_master;";
                    break;
                case "tables":
                    return "SELECT name FROM sqlite_master WHERE type='table' UNION ALL SELECT name FROM sqlite_temp_master WHERE type='table' ORDER BY name;";
                    break;
                case "schema":
                    return "SELECT sql FROM (SELECT * FROM sqlite_master UNION ALL SELECT * FROM sqlite_temp_master) WHERE type!='meta' ORDER BY tbl_name, type DESC, name;";
                    break;
                case "schemax":
                case "schema_x":
                    return "SELECT sql FROM (SELECT * FROM sqlite_master UNION ALL SELECT * FROM sqlite_temp_master) " . "WHERE tbl_name LIKE '" . $args["table"] . "' " . "AND type!='meta' " . "ORDER BY type DESC, name;";
                    break;
                case "alter":
                    $rows = strtr($args["rows"], $this->keywords);
                    $q = ["BEGIN TRANSACTION", "CREATE TEMPORARY TABLE " . $args["table"] . "_backup (" . $args["rows"] . ")", "INSERT INTO " . $args["table"] . "_backup SELECT " . $args["save"] . " FROM " . $args["table"], "DROP TABLE " . $args["table"], "CREATE TABLE " . $args["table"] . " (" . $args["rows"] . ")", "INSERT INTO " . $args["table"] . " SELECT " . $rows . " FROM " . $args["table"] . "_backup", "DROP TABLE " . $args["table"] . "_backup", "COMMIT"];
                    foreach ($q as $query) {
                        $this->query($query);
                    }
                    return "SELECT * FROM " . $args["table"] . ";";
                    break;
                default:
                    return NULL;
            }
        }
        return $this->raiseError("no key specified", NULL, NULL, NULL, "Argument has to be an array.");
    }
}

?>