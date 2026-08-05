<?php
/*
 *after.com
 * @ Release: 13/06/2023
 */

require_once PEAR_DIR . "PEAR.php";
define("DB_OK", 1);
define("DB_ERROR", -1);
define("DB_ERROR_SYNTAX", -2);
define("DB_ERROR_CONSTRAINT", -3);
define("DB_ERROR_NOT_FOUND", -4);
define("DB_ERROR_ALREADY_EXISTS", -5);
define("DB_ERROR_UNSUPPORTED", -6);
define("DB_ERROR_MISMATCH", -7);
define("DB_ERROR_INVALID", -8);
define("DB_ERROR_NOT_CAPABLE", -9);
define("DB_ERROR_TRUNCATED", -10);
define("DB_ERROR_INVALID_NUMBER", -11);
define("DB_ERROR_INVALID_DATE", -12);
define("DB_ERROR_DIVZERO", -13);
define("DB_ERROR_NODBSELECTED", -14);
define("DB_ERROR_CANNOT_CREATE", -15);
define("DB_ERROR_CANNOT_DELETE", -16);
define("DB_ERROR_CANNOT_DROP", -17);
define("DB_ERROR_NOSUCHTABLE", -18);
define("DB_ERROR_NOSUCHFIELD", -19);
define("DB_ERROR_NEED_MORE_DATA", -20);
define("DB_ERROR_NOT_LOCKED", -21);
define("DB_ERROR_VALUE_COUNT_ON_ROW", -22);
define("DB_ERROR_INVALID_DSN", -23);
define("DB_ERROR_CONNECT_FAILED", -24);
define("DB_ERROR_EXTENSION_NOT_FOUND", -25);
define("DB_ERROR_ACCESS_VIOLATION", -26);
define("DB_ERROR_NOSUCHDB", -27);
define("DB_ERROR_CONSTRAINT_NOT_NULL", -29);
define("DB_PARAM_SCALAR", 1);
define("DB_PARAM_OPAQUE", 2);
define("DB_PARAM_MISC", 3);
define("DB_BINMODE_PASSTHRU", 1);
define("DB_BINMODE_RETURN", 2);
define("DB_BINMODE_CONVERT", 3);
define("DB_FETCHMODE_DEFAULT", 0);
define("DB_FETCHMODE_ORDERED", 1);
define("DB_FETCHMODE_ASSOC", 2);
define("DB_FETCHMODE_OBJECT", 3);
define("DB_FETCHMODE_FLIPPED", 4);
define("DB_GETMODE_ORDERED", DB_FETCHMODE_ORDERED);
define("DB_GETMODE_ASSOC", DB_FETCHMODE_ASSOC);
define("DB_GETMODE_FLIPPED", DB_FETCHMODE_FLIPPED);
define("DB_TABLEINFO_ORDER", 1);
define("DB_TABLEINFO_ORDERTABLE", 2);
define("DB_TABLEINFO_FULL", 3);
define("DB_AUTOQUERY_INSERT", 1);
define("DB_AUTOQUERY_UPDATE", 2);
define("DB_PORTABILITY_NONE", 0);
define("DB_PORTABILITY_LOWERCASE", 1);
define("DB_PORTABILITY_RTRIM", 2);
define("DB_PORTABILITY_DELETE_COUNT", 4);
define("DB_PORTABILITY_NUMROWS", 8);
define("DB_PORTABILITY_ERRORS", 16);
define("DB_PORTABILITY_NULL_TO_EMPTY", 32);
define("DB_PORTABILITY_ALL", 63);
/**
 * DB_Error implements a class for reporting portable database error
 * messages.
 *
 * @package  DB
 * @author Stig Bakken <ssb@php.net>
 */
class DB_Error extends PEAR_Error
{
    public function DB_Error($code = DB_ERROR, $mode = PEAR_ERROR_RETURN, $level = E_USER_NOTICE, $debuginfo = NULL)
    {
        global $dbc;
        if (is_int($code)) {
            $this->PEAR_Error("DB Error: " . $dbc->errorMessage($code), $code, $mode, $level, $debuginfo);
        } else {
            $this->PEAR_Error("DB Error: " . $code, DB_ERROR, $mode, $level, $debuginfo);
        }
    }
}
/**
 * The main "DB" class is simply a container class with some static
 * methods for creating DB objects as well as some utility functions
 * common to all parts of DB.
 *
 * The object model of DB is as follows (indentation means inheritance):
 *
 * DB           The main DB class.  This is simply a utility class
 *              with some "static" methods for creating DB objects as
 *              well as common utility functions for other DB classes.
 *
 * DB_common    The base for each DB implementation.  Provides default
 * |            implementations (in OO lingo virtual methods) for
 * |            the actual DB implementations as well as a bunch of
 * |            query utility functions.
 * |
 * +-DB_mysql   The DB implementation for MySQL.  Inherits DB_common.
 *              When calling DB::factory or DB::connect for MySQL
 *              connections, the object returned is an instance of this
 *              class.
 *
 * @package  DB
 * @author   Stig Bakken <ssb@php.net>
 * @author   Tomas V.V.Cox <cox@idecnet.com>
 * @since    PHP 4.0
 * @version  $Id: DB.php,v 1.3 2005/07/22 05:10:13 max Exp $
 * @category Database
 */
class DB
{
    public function &factory($type, $options = false)
    {
        global $dbc;
        if (!is_array($options)) {
            $options = ["persistent" => $options];
        }
        if (isset($options["debug"]) && 2 <= $options["debug"]) {
            include_once PEAR_DIR . "DB/" . $type . ".php";
        } else {
            include_once PEAR_DIR . "DB/" . $type . ".php";
        }
        $classname = "DB_" . $type;
        if (!class_exists($classname)) {
            $tmp = PEAR::raiseError(NULL, DB_ERROR_NOT_FOUND, NULL, NULL, "Unable to include the DB/" . $type . ".php file", "DB_Error", true);
            return $tmp;
        }
        $obj = new $classname();
        foreach ($options as $option => $value) {
            $test = $obj->setOption($option, $value);
            if ($dbc->isError($test)) {
                return $test;
            }
        }
        return $obj;
    }
    public function &connect($dsn, $options = [])
    {
        global $dbc;
        $dsninfo = $dbc->parseDSN($dsn);
        $type = $dsninfo["phptype"];
        if (!is_array($options)) {
            $options = ["persistent" => $options];
        }
        if (isset($options["debug"]) && 2 <= $options["debug"]) {
            include_once PEAR_DIR . "DB/" . $type . ".php";
        } else {
            include_once PEAR_DIR . "DB/" . $type . ".php";
        }
        $classname = "DB_" . $type;
        if (!class_exists($classname)) {
            $tmp = PEAR::raiseError(NULL, DB_ERROR_NOT_FOUND, NULL, NULL, "Unable to include the DB/" . $type . ".php file for `" . $dsn . "'", "DB_Error", true);
            return $tmp;
        }
        $obj = new $classname();
        foreach ($options as $option => $value) {
            $test = $obj->setOption($option, $value);
            if ($dbc->isError($test)) {
                return $test;
            }
        }
        $err = $obj->connect($dsninfo, $obj->getOption("persistent"));
        if ($dbc->isError($err)) {
            $err->addUserInfo($dsn);
            return $err;
        }
        return $obj;
    }
    public function apiVersion()
    {
        return 2;
    }
    public function isError($value)
    {
        return is_a($value, "DB_Error");
    }
    public function isConnection($value)
    {
        return is_object($value) && is_subclass_of($value, "db_common") && method_exists($value, "simpleQuery");
    }
    public function isManip($query)
    {
        $manips = "INSERT|UPDATE|DELETE|LOAD DATA|REPLACE|CREATE|DROP|ALTER|GRANT|REVOKE|LOCK|UNLOCK";
        if (preg_match("/^\\s*\"?(" . $manips . ")\\s+/i", $query)) {
            return true;
        }
        return false;
    }
    public function errorMessage($value)
    {
        global $dbc;
        static $errorMessages = NULL;
        if (!isset($errorMessages)) {
            $errorMessages = [DB_ERROR => "unknown error", DB_ERROR_ALREADY_EXISTS => "already exists", DB_ERROR_CANNOT_CREATE => "can not create", DB_ERROR_CANNOT_DELETE => "can not delete", DB_ERROR_CANNOT_DROP => "can not drop", DB_ERROR_CONSTRAINT => "constraint violation", DB_ERROR_CONSTRAINT_NOT_NULL => "null value violates not-null constraint", DB_ERROR_DIVZERO => "division by zero", DB_ERROR_INVALID => "invalid", DB_ERROR_INVALID_DATE => "invalid date or time", DB_ERROR_INVALID_NUMBER => "invalid number", DB_ERROR_MISMATCH => "mismatch", DB_ERROR_NODBSELECTED => "no database selected", DB_ERROR_NOSUCHFIELD => "no such field", DB_ERROR_NOSUCHTABLE => "no such table", DB_ERROR_NOT_CAPABLE => "DB backend not capable", DB_ERROR_NOT_FOUND => "not found", DB_ERROR_NOT_LOCKED => "not locked", DB_ERROR_SYNTAX => "syntax error", DB_ERROR_UNSUPPORTED => "not supported", DB_ERROR_VALUE_COUNT_ON_ROW => "value count on row", DB_ERROR_INVALID_DSN => "invalid DSN", DB_ERROR_CONNECT_FAILED => "connect failed", DB_OK => "no error", DB_ERROR_NEED_MORE_DATA => "insufficient data supplied", DB_ERROR_EXTENSION_NOT_FOUND => "extension not found", DB_ERROR_NOSUCHDB => "no such database", DB_ERROR_ACCESS_VIOLATION => "insufficient permissions", DB_ERROR_TRUNCATED => "truncated"];
        }
        if ($dbc->isError($value)) {
            $value = $value->getCode();
        }
        return isset($errorMessages[$value]) ? $errorMessages[$value] : $errorMessages[DB_ERROR];
    }
    public function parseDSN($dsn)
    {
        $parsed = ["phptype" => false, "dbsyntax" => false, "username" => false, "password" => false, "protocol" => false, "hostspec" => false, "port" => false, "socket" => false, "database" => false];
        if (is_array($dsn)) {
            $dsn = array_merge($parsed, $dsn);
            if (!$dsn["dbsyntax"]) {
                $dsn["dbsyntax"] = $dsn["phptype"];
            }
            return $dsn;
        }
        if (($pos = strpos($dsn, "://")) !== false) {
            $str = substr($dsn, 0, $pos);
            $dsn = substr($dsn, $pos + 3);
        } else {
            $str = $dsn;
            $dsn = NULL;
        }
        if (preg_match("|^(.+?)\\((.*?)\\)\$|", $str, $arr)) {
            $parsed["phptype"] = $arr[1];
            $parsed["dbsyntax"] = !$arr[2] ? $arr[1] : $arr[2];
        } else {
            $parsed["phptype"] = $str;
            $parsed["dbsyntax"] = $str;
        }
        if (!count($dsn)) {
            return $parsed;
        }
        if (($at = strrpos($dsn, "@")) !== false) {
            $str = substr($dsn, 0, $at);
            $dsn = substr($dsn, $at + 1);
            if (($pos = strpos($str, ":")) !== false) {
                $parsed["username"] = rawurldecode(substr($str, 0, $pos));
                $parsed["password"] = rawurldecode(substr($str, $pos + 1));
            } else {
                $parsed["username"] = rawurldecode($str);
            }
        }
        if (preg_match("|^([^(]+)\\((.*?)\\)/?(.*?)\$|", $dsn, $match)) {
            $proto = $match[1];
            $proto_opts = $match[2] ? $match[2] : false;
            $dsn = $match[3];
        } else {
            if (strpos($dsn, "+") !== false) {
                list($proto, $dsn) = explode("+", $dsn, 2);
            }
            if (strpos($dsn, "/") !== false) {
                list($proto_opts, $dsn) = explode("/", $dsn, 2);
            } else {
                $proto_opts = $dsn;
                $dsn = NULL;
            }
        }
        $parsed["protocol"] = !empty($proto) ? $proto : "tcp";
        $proto_opts = rawurldecode($proto_opts);
        if ($parsed["protocol"] == "tcp") {
            if (strpos($proto_opts, ":") !== false) {
                list($parsed["hostspec"], $parsed["port"]) = explode(":", $proto_opts);
            } else {
                $parsed["hostspec"] = $proto_opts;
            }
        } else {
            if ($parsed["protocol"] == "unix") {
                $parsed["socket"] = $proto_opts;
            }
        }
        if ($dsn) {
            if (($pos = strpos($dsn, "?")) === false) {
                $parsed["database"] = $dsn;
            } else {
                $parsed["database"] = substr($dsn, 0, $pos);
                $dsn = substr($dsn, $pos + 1);
                if (strpos($dsn, "&") !== false) {
                    $opts = explode("&", $dsn);
                } else {
                    $opts = [$dsn];
                }
                foreach ($opts as $opt) {
                    list($key, $value) = explode("=", $opt);
                    if (!isset($parsed[$key])) {
                        $parsed[$key] = rawurldecode($value);
                    }
                }
            }
        }
        return $parsed;
    }
    public function assertExtension($name)
    {
        if (!extension_loaded($name)) {
            $dlext = OS_WINDOWS ? ".dll" : ".so";
            $dlprefix = OS_WINDOWS ? "php_" : "";
            dl($dlprefix . $name . $dlext);
            return extension_loaded($name);
        }
        return true;
    }
}
/**
 * This class implements a wrapper for a DB result set.
 * A new instance of this class will be returned by the DB implementation
 * after processing a query that returns data.
 *
 * @package  DB
 * @author Stig Bakken <ssb@php.net>
 */
class DB_result
{
    public $dbh = NULL;
    public $result = NULL;
    public $row_counter = NULL;
    /**
     * for limit queries, the row to start fetching
     * @var integer
     */
    public $limit_from = NULL;
    /**
     * for limit queries, the number of rows to fetch
     * @var integer
     */
    public $limit_count = NULL;
    public function DB_result(&$dbh, $result, $options = [])
    {
        $this->dbh =& $dbh;
        $this->result = $result;
        foreach ($options as $key => $value) {
            $this->setOption($key, $value);
        }
        $this->limit_type = $dbh->features["limit"];
        $this->autofree = $dbh->options["autofree"];
        $this->fetchmode = $dbh->fetchmode;
        $this->fetchmode_object_class = $dbh->fetchmode_object_class;
    }
    public function setOption($key, $value = NULL)
    {
        switch ($key) {
            case "limit_from":
                $this->limit_from = $value;
                break;
            case "limit_count":
                $this->limit_count = $value;
                break;
        }
    }
    public function &fetchRow($fetchmode = DB_FETCHMODE_DEFAULT, $rownum = NULL)
    {
        if ($fetchmode === DB_FETCHMODE_DEFAULT) {
            $fetchmode = $this->fetchmode;
        }
        if ($fetchmode === DB_FETCHMODE_OBJECT) {
            $fetchmode = DB_FETCHMODE_ASSOC;
            $object_class = $this->fetchmode_object_class;
        }
        if ($this->limit_from !== NULL) {
            if ($this->row_counter === NULL) {
                $this->row_counter = $this->limit_from;
                if (!$this->limit_type) {
                    $i = 0;
                    while ($i++ < $this->limit_from) {
                        $this->dbh->fetchInto($this->result, $arr, $fetchmode);
                    }
                }
            }
            if ($this->limit_from + $this->limit_count <= $this->row_counter) {
                if ($this->autofree) {
                    $this->free();
                }
                $tmp = NULL;
                return $tmp;
            }
            if ($this->limit_type == "emulate") {
                $rownum = $this->row_counter;
            }
            $this->row_counter++;
        }
        $res = $this->dbh->fetchInto($this->result, $arr, $fetchmode, $rownum);
        if ($res === DB_OK) {
            if (isset($object_class)) {
                if ($object_class == "stdClass") {
                    $arr = (object) $arr;
                } else {
                    $arr = new $object_class($arr);
                }
            }
            return $arr;
        }
        if ($res == NULL && $this->autofree) {
            $this->free();
        }
        return $res;
    }
    public function fetchInto(&$arr, $fetchmode = DB_FETCHMODE_DEFAULT, $rownum = NULL)
    {
        if ($fetchmode === DB_FETCHMODE_DEFAULT) {
            $fetchmode = $this->fetchmode;
        }
        if ($fetchmode === DB_FETCHMODE_OBJECT) {
            $fetchmode = DB_FETCHMODE_ASSOC;
            $object_class = $this->fetchmode_object_class;
        }
        if ($this->limit_from !== NULL) {
            if ($this->row_counter === NULL) {
                $this->row_counter = $this->limit_from;
                if (!$this->limit_type) {
                    $i = 0;
                    while ($i++ < $this->limit_from) {
                        $this->dbh->fetchInto($this->result, $arr, $fetchmode);
                    }
                }
            }
            if ($this->limit_from + $this->limit_count <= $this->row_counter) {
                if ($this->autofree) {
                    $this->free();
                }
                return NULL;
            }
            if ($this->limit_type == "emulate") {
                $rownum = $this->row_counter;
            }
            $this->row_counter++;
        }
        $res = $this->dbh->fetchInto($this->result, $arr, $fetchmode, $rownum);
        if ($res === DB_OK) {
            if (isset($object_class)) {
                if ($object_class == "stdClass") {
                    $arr = (object) $arr;
                } else {
                    $arr = new $object_class($arr);
                }
            }
            return DB_OK;
        }
        if ($res == NULL && $this->autofree) {
            $this->free();
        }
        return $res;
    }
    public function numCols()
    {
        return $this->dbh->numCols($this->result);
    }
    public function numRows()
    {
        return $this->dbh->numRows($this->result);
    }
    public function nextResult()
    {
        return $this->dbh->nextResult($this->result);
    }
    public function free()
    {
        global $dbc;
        $err = $this->dbh->freeResult($this->result);
        if ($dbc->isError($err)) {
            return $err;
        }
        $this->result = false;
        return true;
    }
    public function tableInfo($mode = NULL)
    {
        if (is_string($mode)) {
            return $this->dbh->raiseError(DB_ERROR_NEED_MORE_DATA);
        }
        return $this->dbh->tableInfo($this, $mode);
    }
    public function getRowCounter()
    {
        return $this->row_counter;
    }
}
/**
 * Pear DB Row Object
 * @see DB_common::setFetchMode()
 */
class DB_row
{
    public function DB_row(&$arr)
    {
        foreach ($arr as $key => $value) {
            $this->{$key} =& $arr[$key];
        }
    }
}

?>