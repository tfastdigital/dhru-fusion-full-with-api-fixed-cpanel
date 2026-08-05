<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once PEAR_DIR . "DB/common.php";
/**
 * The methods PEAR DB uses to interact with PHP's dbase extension
 * for interacting with dBase databases
 *
 * These methods overload the ones declared in DB_common.
 *
 * @category   Database
 * @package    DB
 * @author     Tomas V.V. Cox <cox@idecnet.com>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1997-2007 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.7.14RC1
 * @link       http://pear.php.net/package/DB
 */
class DB_dbase extends DB_common
{
    /**
     * The DB driver type (mysql, oci8, odbc, etc.)
     * @var string
     */
    public $phptype = "dbase";
    /**
     * The database syntax variant to be used (db2, access, etc.), if any
     * @var string
     */
    public $dbsyntax = "dbase";
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
    public $features = ["limit" => false, "new_link" => false, "numrows" => true, "pconnect" => false, "prepare" => false, "ssl" => false, "transactions" => false];
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
     * A means of emulating result resources
     * @var array
     */
    public $res_row = [];
    /**
     * The quantity of results so far
     *
     * For emulating result resources.
     *
     * @var integer
     */
    public $result = 0;
    /**
     * Maps dbase data type id's to human readable strings
     *
     * The human readable values are based on the output of PHP's
     * dbase_get_header_info() function.
     *
     * @var array
     * @since Property available since Release 1.7.0
     */
    public $types = ["C" => "character", "D" => "date", "L" => "boolean", "M" => "memo", "N" => "number"];
    public function DB_dbase()
    {
        $this->DB_common();
    }
    public function connect($dsn, $persistent = false)
    {
        if (!PEAR::loadExtension("dbase")) {
            return $this->raiseError(DB_ERROR_EXTENSION_NOT_FOUND);
        }
        $this->dsn = $dsn;
        if ($dsn["dbsyntax"]) {
            $this->dbsyntax = $dsn["dbsyntax"];
        }
        @ini_set("track_errors", 1);
        $php_errormsg = "";
        if (!file_exists($dsn["database"])) {
            $this->dsn["mode"] = 2;
            if (empty($dsn["fields"]) || !is_array($dsn["fields"])) {
                return $this->raiseError(DB_ERROR_CONNECT_FAILED, NULL, NULL, NULL, "the dbase file does not exist and it could not be created because the \"fields\" element of the DSN is not properly set");
            }
            $this->connection = @dbase_create($dsn["database"], $dsn["fields"]);
            if (!$this->connection) {
                return $this->raiseError(DB_ERROR_CONNECT_FAILED, NULL, NULL, NULL, "the dbase file does not exist and the attempt to create it failed: " . $php_errormsg);
            }
        } else {
           
            $this->connection = @dbase_open($dsn["database"], $this->dsn["mode"]);
           
        }
        return DB_OK;
    }
    public function disconnect()
    {
        $ret = @dbase_close($this->connection);
        $this->connection = NULL;
        return $ret;
    }
    public function &query($query = NULL)
    {
        $this->res_row[(int) $this->result] = 0;
        $tmp = new DB_result($this, $this->result++);
        return $tmp;
    }
    public function fetchInto($result, &$arr, $fetchmode, $rownum = NULL)
    {
        if ($rownum === NULL) {
            $rownum = $this->res_row[(int) $result]++;
        }
        if ($fetchmode & DB_FETCHMODE_ASSOC) {
            $arr = @dbase_get_record_with_names($this->connection, $rownum);
            if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE && $arr) {
                $arr = array_change_key_case($arr, CASE_LOWER);
            }
        } else {
            $arr = @dbase_get_record($this->connection, $rownum);
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
        return true;
    }
    public function numCols($foo)
    {
        return @dbase_numfields($this->connection);
    }
    public function numRows($foo)
    {
        return @dbase_numrecords($this->connection);
    }
    public function quoteBoolean($boolean)
    {
        return $boolean ? "T" : "F";
    }
    public function tableInfo($result = NULL, $mode = NULL)
    {
        if (function_exists("dbase_get_header_info")) {
            $id = @dbase_get_header_info($this->connection);
            if (!$id && $php_errormsg) {
                
            }
        } else {
            $db = @fopen($this->dsn["database"], "r");
            if (!$db) {
                return $this->raiseError(DB_ERROR_CONNECT_FAILED, NULL, NULL, NULL, $php_errormsg);
            }
            $id = [];
            $i = 0;
            $line = fread($db, 32);
            while (!feof($db)) {
                $line = fread($db, 32);
                if (substr($line, 0, 1) != chr(13)) {
                    $pos = strpos(substr($line, 0, 10), chr(0));
                    $pos = $pos == 0 ? 10 : $pos;
                    $id[$i] = ["name" => substr($line, 0, $pos), "type" => $this->types[substr($line, 11, 1)], "length" => ord(substr($line, 16, 1)), "precision" => ord(substr($line, 17, 1))];
                    $i++;
                }
            }
            fclose($db);
        }
        if ($this->options["portability"] & DB_PORTABILITY_LOWERCASE) {
            $case_func = "strtolower";
        } else {
            $case_func = "strval";
        }
        $res = [];
        $count = count($id);
        if ($mode) {
            $res["num_fields"] = $count;
        }
        for ($i = 0; $i < $count; $i++) {
            $res[$i] = ["table" => $this->dsn["database"], "name" => $case_func($id[$i]["name"]), "type" => $id[$i]["type"], "len" => $id[$i]["length"], "flags" => ""];
            if ($mode & DB_TABLEINFO_ORDER) {
                $res["order"][$res[$i]["name"]] = $i;
            }
            if ($mode & DB_TABLEINFO_ORDERTABLE) {
                $res["ordertable"][$res[$i]["table"]][$res[$i]["name"]] = $i;
            }
        }
        return $res;
    }
}

?>