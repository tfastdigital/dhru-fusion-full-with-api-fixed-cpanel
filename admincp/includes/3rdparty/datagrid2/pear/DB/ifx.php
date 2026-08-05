<?php
/*
 *after.com
 * @ Release: 13/06/2023
 */

require_once PEAR_DIR . "DB/common.php";
/**
 * The methods PEAR DB uses to interact with PHP's ifx extension
 * for interacting with Informix databases
 *
 * These methods overload the ones declared in DB_common.
 *
 * More info on Informix errors can be found at:
 * http://www.informix.com/answers/english/ierrors.htm
 *
 * TODO:
 *   - set needed env Informix vars on connect
 *   - implement native prepare/execute
 *
 * @category   Database
 * @package    DB
 * @author     Tomas V.V.Cox <cox@idecnet.com>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1997-2007 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.7.14RC1
 * @link       http://pear.php.net/package/DB
 */
class DB_ifx extends DB_common
{
    /**
     * The DB driver type (mysql, oci8, odbc, etc.)
     * @var string
     */
    public $phptype = "ifx";
    /**
     * The database syntax variant to be used (db2, access, etc.), if any
     * @var string
     */
    public $dbsyntax = "ifx";
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
    public $features = ["limit" => "emulate", "new_link" => false, "numrows" => "emulate", "pconnect" => true, "prepare" => false, "ssl" => false, "transactions" => true];
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
     * The number of rows affected by a data manipulation query
     * @var integer
     * @access private
     */
    public $affected = 0;
    public function DB_ifx()
    {
        $this->DB_common();
    }
    public function connect($dsn, $persistent = false)
    {
        if (!PEAR::loadExtension("informix") && !PEAR::loadExtension("Informix")) {
            return $this->raiseError(DB_ERROR_EXTENSION_NOT_FOUND);
        }
        $this->dsn = $dsn;
        if ($dsn["dbsyntax"]) {
            $this->dbsyntax = $dsn["dbsyntax"];
        }
        $dbhost = $dsn["hostspec"] ? "@" . $dsn["hostspec"] : "";
        $dbname = $dsn["database"] ? $dsn["database"] . $dbhost : "";
        $user = $dsn["username"] ? $dsn["username"] : "";
        $pw = $dsn["password"] ? $dsn["password"] : "";
        $connect_function = $persistent ? "ifx_pconnect" : "ifx_connect";
        $this->connection = $connect_function($dbname, $user, $pw);
        if (!is_resource($this->connection)) {
            return $this->ifxRaiseError(DB_ERROR_CONNECT_FAILED);
        }
        return DB_OK;
    }
    public function disconnect()
    {
        $ret = ifx_close($this->connection);
        $this->connection = NULL;
        return $ret;
    }
    public function simpleQuery($query)
    {
        $ismanip = $this->_checkManip($query);
        $this->last_query = $query;
        $this->affected = NULL;
        if (preg_match("/(SELECT|EXECUTE)/i", $query)) {
            $result = ifx_query($query, $this->connection, IFX_SCROLL);
        } else {
            if (!$this->autocommit && $ismanip) {
                if ($this->transaction_opcount == 0) {
                    $result = ifx_query("BEGIN WORK", $this->connection);
                    if (!$result) {
                        return $this->ifxRaiseError();
                    }
                }
                $this->transaction_opcount++;
            }
            $result = ifx_query($query, $this->connection);
        }
        if (!$result) {
            return $this->ifxRaiseError();
        }
        $this->affected = ifx_affected_rows($result);
        if (preg_match("/(SELECT|EXECUTE)/i", $query)) {
            return $result;
        }
        ifx_free_result($result);
        return DB_OK;
    }
    public function nextResult($result)
    {
        return false;
    }
    public function affectedRows()
    {
        if ($this->_last_query_manip) {
            return $this->affected;
        }
        return 0;
    }
    public function fetchInto($result, &$arr, $fetchmode, $rownum = NULL)
    {
        if ($rownum !== NULL && $rownum < 0) {
            return NULL;
        }
        if ($rownum === NULL) {
            $rownum = "NEXT";
        } else {
            $rownum++;
        }
        if (!($arr = ifx_fetch_row($result, $rownum))) {
            return NULL;
        }
        if ($fetchmode !== DB_FETCHMODE_ASSOC) {
            $i = 0;
            $order = [];
            foreach ($arr as $val) {
                $order[$i++] = $val;
            }
            $arr = $order;
        } else {
            if ($fetchmode == DB_FETCHMODE_ASSOC && $this->options["portability"] & DB_PORTABILITY_LOWERCASE) {
                $arr = array_change_key_case($arr, CASE_LOWER);
            }
        }
        if ($this->options["portability"] & DB_PORTABILITY_RTRIM) {
            $this->_rtrimArrayValues($arr);
        }
        if ($this->options["portability"] & DB_PORTABILITY_NULL_TO_EMPTY) {
            $this->_convertNullArrayValuesToEmpty($arr);
        }
        return DB_OK;
    }
    public function numCols($result)
    {
        if (!($cols = ifx_num_fields($result))) {
            return $this->ifxRaiseError();
        }
        return $cols;
    }
    public function freeResult($result)
    {
        return is_resource($result) ? ifx_free_result($result) : false;
    }
    public function autoCommit($onoff = true)
    {
        $this->autocommit = $onoff ? true : false;
        return DB_OK;
    }
    public function commit()
    {
        if (0 < $this->transaction_opcount) {
            $result = ifx_query("COMMIT WORK", $this->connection);
            $this->transaction_opcount = 0;
            if (!$result) {
                return $this->ifxRaiseError();
            }
        }
        return DB_OK;
    }
    public function rollback()
    {
        if (0 < $this->transaction_opcount) {
            $result = ifx_query("ROLLBACK WORK", $this->connection);
            $this->transaction_opcount = 0;
            if (!$result) {
                return $this->ifxRaiseError();
            }
        }
        return DB_OK;
    }
    public function ifxRaiseError($errno = NULL)
    {
        if ($errno === NULL) {
            $errno = $this->errorCode(ifx_error());
        }
        return $this->raiseError($errno, NULL, NULL, NULL, $this->errorNative());
    }
    public function errorNative()
    {
        return ifx_error() . " " . ifx_errormsg();
    }
    public function errorCode($nativecode)
    {
        if (ereg("SQLCODE=(.*)]", $nativecode, $match)) {
            $code = $match[1];
            if (isset($this->errorcode_map[$code])) {
                return $this->errorcode_map[$code];
            }
        }
        return DB_ERROR;
    }
    public function tableInfo($result, $mode = NULL)
    {
        if (is_string($result)) {
            $id = ifx_query("SELECT * FROM " . $result . " WHERE 1=0", $this->connection);
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
            return $this->ifxRaiseError(DB_ERROR_NEED_MORE_DATA);
        }
        $flds = ifx_fieldproperties($id);
        $count = ifx_num_fields($id);
        if (count($flds) != $count) {
            return $this->raiseError("can't distinguish duplicate field names");
        }
        if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE) {
            $case_func = "strtolower";
        } else {
            $case_func = "strval";
        }
        $i = 0;
        $res = [];
        if ($mode) {
            $res["num_fields"] = $count;
        }
        foreach ($flds as $key => $value) {
            $props = explode(";", $value);
            $res[$i] = ["table" => $got_string ? $case_func($result) : "", "name" => $case_func($key), "type" => $props[0], "len" => $props[1], "flags" => $props[4] == "N" ? "not_null" : ""];
            if ($mode & DB_TABLEINFO_ORDER) {
                $res["order"][$res[$i]["name"]] = $i;
            }
            if ($mode & DB_TABLEINFO_ORDERTABLE) {
                $res["ordertable"][$res[$i]["table"]][$res[$i]["name"]] = $i;
            }
            $i++;
        }
        if ($got_string) {
            ifx_free_result($id);
        }
        return $res;
    }
    public function getSpecialQuery($type)
    {
        switch ($type) {
            case "tables":
                return "SELECT tabname FROM systables WHERE tabid >= 100";
                break;
        }
    }
}

?>