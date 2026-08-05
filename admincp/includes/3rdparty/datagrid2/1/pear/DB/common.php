<?php
/*
 *after.com
 * @ Release: 13/06/2023
 */

require_once PEAR_DIR . "PEAR.php";
/**
 * DB_common is the base class from which each database driver class extends
 *
 * All common methods are declared here.  If a given DBMS driver contains
 * a particular method, that method will overload the one here.
 *
 * @category   Database
 * @package    DB
 * @author     Stig Bakken <ssb@php.net>
 * @author     Tomas V.V. Cox <cox@idecnet.com>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1997-2007 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.7.14RC1
 * @link       http://pear.php.net/package/DB
 */
class DB_common extends PEAR
{
    /**
     * The current default fetch mode
     * @var integer
     */
    public $fetchmode = DB_FETCHMODE_ORDERED;
    /**
     * The name of the class into which results should be fetched when
     * DB_FETCHMODE_OBJECT is in effect
     *
     * @var string
     */
    public $fetchmode_object_class = "stdClass";
    /**
     * Was a connection present when the object was serialized()?
     * @var bool
     * @see DB_common::__sleep(), DB_common::__wake()
     */
    public $was_connected = NULL;
    /**
     * The most recently executed query
     * @var string
     */
    public $last_query = "";
    /**
     * Run-time configuration options
     *
     * The 'optimize' option has been deprecated.  Use the 'portability'
     * option instead.
     *
     * @var array
     * @see DB_common::setOption()
     */
    public $options = NULL;
    /**
     * The parameters from the most recently executed query
     * @var array
     * @since Property available since Release 1.7.0
     */
    public $last_parameters = [];
    /**
     * The elements from each prepared statement
     * @var array
     */
    public $prepare_tokens = [];
    /**
     * The data types of the various elements in each prepared statement
     * @var array
     */
    public $prepare_types = [];
    /**
     * The prepared queries
     * @var array
     */
    public $prepared_queries = [];
    /**
     * Flag indicating that the last query was a manipulation query.
     * @access protected
     * @var boolean
     */
    public $_last_query_manip = false;
    /**
     * Flag indicating that the next query <em>must</em> be a manipulation
     * query.
     * @access protected
     * @var boolean
     */
    public $_next_query_manip = false;
    public function DB_common()
    {
        $this->PEAR("DB_Error");
    }
    public function __sleep()
    {
        if ($this->connection) {
            $this->was_connected = true;
        } else {
            $this->was_connected = false;
        }
        if (isset($this->autocommit)) {
            return ["autocommit", "dbsyntax", "dsn", "features", "fetchmode", "fetchmode_object_class", "options", "was_connected"];
        }
        return ["dbsyntax", "dsn", "features", "fetchmode", "fetchmode_object_class", "options", "was_connected"];
    }
    public function __wakeup()
    {
        if ($this->was_connected) {
            $this->connect($this->dsn, $this->options);
        }
    }
    public function __toString()
    {
        $info = strtolower(get_class($this));
        $info .= ": (phptype=" . $this->phptype . ", dbsyntax=" . $this->dbsyntax . ")";
        if ($this->connection) {
            $info .= " [connected]";
        }
        return $info;
    }
    public function toString()
    {
        return $this->__toString();
    }
    public function quoteString($string)
    {
        $string = $this->quote($string);
        if ($string[0] == "'") {
            return substr($string, 1, -1);
        }
        return $string;
    }
    public function quote($string = NULL)
    {
        return $string === NULL ? "NULL" : "'" . str_replace("'", "''", $string) . "'";
    }
    public function quoteIdentifier($str)
    {
        return "\"" . str_replace("\"", "\"\"", $str) . "\"";
    }
    public function quoteSmart($in)
    {
        if (is_int($in)) {
            return $in;
        }
        if (is_float($in)) {
            return $this->quoteFloat($in);
        }
        if (is_bool($in)) {
            return $this->quoteBoolean($in);
        }
        if (is_null($in)) {
            return "NULL";
        }
        if ($this->dbsyntax == "access" && preg_match("/^#.+#\$/", $in)) {
            return $this->escapeSimple($in);
        }
        return "'" . $this->escapeSimple($in) . "'";
    }
    public function quoteBoolean($boolean)
    {
        return $boolean ? "1" : "0";
    }
    public function quoteFloat($float)
    {
        return "'" . $this->escapeSimple(str_replace(",", ".", strval(floatval($float)))) . "'";
    }
    public function escapeSimple($str)
    {
        return str_replace("'", "''", $str);
    }
    public function provides($feature)
    {
        return $this->features[$feature];
    }
    public function setFetchMode($fetchmode, $object_class = "stdClass")
    {
        switch ($fetchmode) {
            case DB_FETCHMODE_OBJECT:
                $this->fetchmode_object_class = $object_class;
                break;
            case DB_FETCHMODE_ORDERED:
            case DB_FETCHMODE_ASSOC:
                $this->fetchmode = $fetchmode;
                break;
            default:
                return $this->raiseError("invalid fetchmode mode");
        }
    }
    public function setOption($option, $value)
    {
        if (isset($this->options[$option])) {
            $this->options[$option] = $value;
            if ($option == "optimize") {
                if ($value == "portability") {
                    switch ($this->phptype) {
                        case "oci8":
                            $this->options["portability"] = DB_PORTABILITY_LOWERCASE | DB_PORTABILITY_NUMROWS;
                            break;
                        case "fbsql":
                        case "mysql":
                        case "mysqli":
                        case "sqlite":
                            $this->options["portability"] = DB_PORTABILITY_DELETE_COUNT;
                            break;
                    }
                } else {
                    $this->options["portability"] = DB_PORTABILITY_NONE;
                }
            }
            return DB_OK;
        }
        return $this->raiseError("unknown option " . $option);
    }
    public function getOption($option)
    {
        if (isset($this->options[$option])) {
            return $this->options[$option];
        }
        return $this->raiseError("unknown option " . $option);
    }
    public function prepare($query)
    {
        $tokens = preg_split("/((?<!\\\\)[&?!])/", $query, -1, PREG_SPLIT_DELIM_CAPTURE);
        $token = 0;
        $types = [];
        $newtokens = [];
        foreach ($tokens as $val) {
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
                    $newtokens[] = preg_replace("/\\\\([&?!])/", "\\1", $val);
            }
        }
        $this->prepare_tokens[] =& $newtokens;
        end($this->prepare_tokens);
        $k = key($this->prepare_tokens);
        $this->prepare_types[$k] = $types;
        $this->prepared_queries[$k] = implode(" ", $newtokens);
        return $k;
    }
    public function autoPrepare($table, $table_fields, $mode = DB_AUTOQUERY_INSERT, $where = false)
    {
        global $dbc;
        $query = $this->buildManipSQL($table, $table_fields, $mode, $where);
        if ($dbc->isError($query)) {
            return $query;
        }
        return $this->prepare($query);
    }
    public function autoExecute($table, $fields_values, $mode = DB_AUTOQUERY_INSERT, $where = false)
    {
        global $dbc;
        $sth = $this->autoPrepare($table, array_keys($fields_values), $mode, $where);
        if ($dbc->isError($sth)) {
            return $sth;
        }
        $ret = $this->execute($sth, array_values($fields_values));
        $this->freePrepared($sth);
        return $ret;
    }
    public function buildManipSQL($table, $table_fields, $mode, $where = false)
    {
        if (count($table_fields) == 0) {
            return $this->raiseError(DB_ERROR_NEED_MORE_DATA);
        }
        $first = true;
        switch ($mode) {
            case DB_AUTOQUERY_INSERT:
                $values = "";
                $names = "";
                foreach ($table_fields as $value) {
                    if ($first) {
                        $first = false;
                    } else {
                        $names .= ",";
                        $values .= ",";
                    }
                    $names .= $value;
                    $values .= "?";
                }
                return "INSERT INTO " . $table . " (" . $names . ") VALUES (" . $values . ")";
                break;
            case DB_AUTOQUERY_UPDATE:
                $set = "";
                foreach ($table_fields as $value) {
                    if ($first) {
                        $first = false;
                    } else {
                        $set .= ",";
                    }
                    $set .= $value . " = ?";
                }
                $sql = "UPDATE " . $table . " SET " . $set;
                if ($where) {
                    $sql .= " WHERE " . $where;
                }
                return $sql;
                break;
            default:
                return $this->raiseError(DB_ERROR_SYNTAX);
        }
    }
    public function &execute($stmt, $data = [])
    {
        global $dbc;
        $realquery = $this->executeEmulateQuery($stmt, $data);
        if ($dbc->isError($realquery)) {
            return $realquery;
        }
        $result = $this->simpleQuery($realquery);
        if ($result === DB_OK || $dbc->isError($result)) {
            return $result;
        }
        $tmp = new DB_result($this, $result);
        return $tmp;
    }
    public function executeEmulateQuery($stmt, $data = [])
    {
        $stmt = (int) $stmt;
        $data = (array) $data;
        $this->last_parameters = $data;
        if (count($this->prepare_types[$stmt]) != count($data)) {
            $this->last_query = $this->prepared_queries[$stmt];
            return $this->raiseError(DB_ERROR_MISMATCH);
        }
        $realquery = $this->prepare_tokens[$stmt][0];
        $i = 0;
        foreach ($data as $value) {
            if ($this->prepare_types[$stmt][$i] == DB_PARAM_SCALAR) {
                $realquery .= $this->quoteSmart($value);
            } else {
                if ($this->prepare_types[$stmt][$i] == DB_PARAM_OPAQUE) {
                    $fp = @fopen($value, "rb");
                    if (!$fp) {
                        return $this->raiseError(DB_ERROR_ACCESS_VIOLATION);
                    }
                    $realquery .= $this->quoteSmart(fread($fp, filesize($value)));
                    fclose($fp);
                } else {
                    $realquery .= $value;
                }
            }
            $realquery .= $this->prepare_tokens[$stmt][++$i];
        }
        return $realquery;
    }
    public function executeMultiple($stmt, $data)
    {
        global $dbc;
        foreach ($data as $value) {
            $res = $this->execute($stmt, $value);
            if ($dbc->isError($res)) {
                return $res;
            }
        }
        return DB_OK;
    }
    public function freePrepared($stmt, $free_resource = true)
    {
        $stmt = (int) $stmt;
        if (isset($this->prepare_tokens[$stmt])) {
            unset($this->prepare_tokens[$stmt]);
            unset($this->prepare_types[$stmt]);
            unset($this->prepared_queries[$stmt]);
            return true;
        }
        return false;
    }
    public function modifyQuery($query)
    {
        return $query;
    }
    public function modifyLimitQuery($query, $from, $count, $params = [])
    {
        return $query;
    }
    public function &query($query, $params = [])
    {
        global $dbc;
        if (0 < sizeof($params)) {
            $sth = $this->prepare($query);
            if ($dbc->isError($sth)) {
                return $sth;
            }
            $ret = $this->execute($sth, $params);
            $this->freePrepared($sth, false);
            return $ret;
        }
        $this->last_parameters = [];
        $result = $this->simpleQuery($query);
        if ($result === DB_OK || $dbc->isError($result)) {
            return $result;
        }
        $tmp = new DB_result($this, $result);
        return $tmp;
    }
    public function &limitQuery($query, $from, $count, $params = [])
    {
        global $dbc;
        $query = $this->modifyLimitQuery($query, $from, $count, $params);
        if ($dbc->isError($query)) {
            return $query;
        }
        $result = $this->query($query, $params);
        if (is_a($result, "DB_result")) {
            $result->setOption("limit_from", $from);
            $result->setOption("limit_count", $count);
        }
        return $result;
    }
    public function &getOne($query, $params = [])
    {
        global $dbc;
        $params = (array) $params;
        if (0 < sizeof($params)) {
            $sth = $this->prepare($query);
            if ($dbc->isError($sth)) {
                return $sth;
            }
            $res = $this->execute($sth, $params);
            $this->freePrepared($sth);
        } else {
            $res = $this->query($query);
        }
        if ($dbc->isError($res)) {
            return $res;
        }
        $err = $res->fetchInto($row, DB_FETCHMODE_ORDERED);
        $res->free();
        if ($err !== DB_OK) {
            return $err;
        }
        return $row[0];
    }
    public function &getRow($query, $params = [], $fetchmode = DB_FETCHMODE_DEFAULT)
    {
        global $dbc;
        if (!is_array($params)) {
            if (is_array($fetchmode)) {
                if ($params === NULL) {
                    $tmp = DB_FETCHMODE_DEFAULT;
                } else {
                    $tmp = $params;
                }
                $params = $fetchmode;
                $fetchmode = $tmp;
            } else {
                if ($params !== NULL) {
                    $fetchmode = $params;
                    $params = [];
                }
            }
        }
        if (0 < sizeof($params)) {
            $sth = $this->prepare($query);
            if ($dbc->isError($sth)) {
                return $sth;
            }
            $res = $this->execute($sth, $params);
            $this->freePrepared($sth);
        } else {
            $res = $this->query($query);
        }
        if ($dbc->isError($res)) {
            return $res;
        }
        $err = $res->fetchInto($row, $fetchmode);
        $res->free();
        if ($err !== DB_OK) {
            return $err;
        }
        return $row;
    }
    public function &getCol($query, $col = 0, $params = [])
    {
        global $dbc;
        $params = (array) $params;
        if (0 < sizeof($params)) {
            $sth = $this->prepare($query);
            if ($dbc->isError($sth)) {
                return $sth;
            }
            $res = $this->execute($sth, $params);
            $this->freePrepared($sth);
        } else {
            $res = $this->query($query);
        }
        if ($dbc->isError($res)) {
            return $res;
        }
        $fetchmode = is_int($col) ? DB_FETCHMODE_ORDERED : DB_FETCHMODE_ASSOC;
        if (!is_array($row = $res->fetchRow($fetchmode))) {
            $ret = [];
        } else {
            if (!array_key_exists($col, $row)) {
                $ret = $this->raiseError(DB_ERROR_NOSUCHFIELD);
            } else {
                $ret = [$row[$col]];
                while (is_array($row = $res->fetchRow($fetchmode))) {
                    $ret[] = $row[$col];
                }
            }
        }
        $res->free();
        if ($dbc->isError($row)) {
            $ret = $row;
        }
        return $ret;
    }
    public function &getAssoc($query, $force_array = false, $params = [], $fetchmode = DB_FETCHMODE_DEFAULT, $group = false)
    {
        global $dbc;
        $params = (array) $params;
        if (0 < sizeof($params)) {
            $sth = $this->prepare($query);
            if ($dbc->isError($sth)) {
                return $sth;
            }
            $res = $this->execute($sth, $params);
            $this->freePrepared($sth);
        } else {
            $res = $this->query($query);
        }
        if ($dbc->isError($res)) {
            return $res;
        }
        if ($fetchmode == DB_FETCHMODE_DEFAULT) {
            $fetchmode = $this->fetchmode;
        }
        $cols = $res->numCols();
        if ($cols < 2) {
            $tmp = $this->raiseError(DB_ERROR_TRUNCATED);
            return $tmp;
        }
        $results = [];
        if (2 < $cols || $force_array) {
            if ($fetchmode == DB_FETCHMODE_ASSOC) {
                while (is_array($row = $res->fetchRow(DB_FETCHMODE_ASSOC))) {
                    reset($row);
                    $key = current($row);
                    unset($row[key($row)]);
                    if ($group) {
                        $results[$key][] = $row;
                    } else {
                        $results[$key] = $row;
                    }
                }
            } else {
                if ($fetchmode == DB_FETCHMODE_OBJECT) {
                    while ($row = $res->fetchRow(DB_FETCHMODE_OBJECT)) {
                        $arr = get_object_vars($row);
                        $key = current($arr);
                        if ($group) {
                            $results[$key][] = $row;
                        } else {
                            $results[$key] = $row;
                        }
                    }
                } else {
                    while (is_array($row = $res->fetchRow(DB_FETCHMODE_ORDERED))) {
                        $key = array_shift($row);
                        if ($group) {
                            $results[$key][] = $row;
                        } else {
                            $results[$key] = $row;
                        }
                    }
                }
            }
            if ($dbc->isError($row)) {
                $results = $row;
            }
        } else {
            while (is_array($row = $res->fetchRow(DB_FETCHMODE_ORDERED))) {
                if ($group) {
                    $results[$row[0]][] = $row[1];
                } else {
                    $results[$row[0]] = $row[1];
                }
            }
            if ($dbc->isError($row)) {
                $results = $row;
            }
        }
        $res->free();
        return $results;
    }
    public function &getAll($query, $params = [], $fetchmode = DB_FETCHMODE_DEFAULT)
    {
        if (!is_array($params)) {
            if (is_array($fetchmode)) {
                if ($params === NULL) {
                    $tmp = DB_FETCHMODE_DEFAULT;
                } else {
                    $tmp = $params;
                }
                $params = $fetchmode;
                $fetchmode = $tmp;
            } else {
                if ($params !== NULL) {
                    $fetchmode = $params;
                    $params = [];
                }
            }
        }
        if (0 < sizeof($params)) {
            $sth = $this->prepare($query);
            if ($dbc->isError($sth)) {
                return $sth;
            }
            $res = $this->execute($sth, $params);
            $this->freePrepared($sth);
        } else {
            $res = $this->query($query);
        }
        if ($res === DB_OK || $dbc->isError($res)) {
            return $res;
        }
        $results = [];
        while (DB_OK === $res->fetchInto($row, $fetchmode)) {
            if ($fetchmode & DB_FETCHMODE_FLIPPED) {
                foreach ($row as $key => $val) {
                    $results[$key][] = $val;
                }
            } else {
                $results[] = $row;
            }
        }
        $res->free();
        if ($dbc->isError($row)) {
            $tmp = $this->raiseError($row);
            return $tmp;
        }
        return $results;
    }
    public function autoCommit($onoff = false)
    {
        return $this->raiseError(DB_ERROR_NOT_CAPABLE);
    }
    public function commit()
    {
        return $this->raiseError(DB_ERROR_NOT_CAPABLE);
    }
    public function rollback()
    {
        return $this->raiseError(DB_ERROR_NOT_CAPABLE);
    }
    public function numRows($result)
    {
        return $this->raiseError(DB_ERROR_NOT_CAPABLE);
    }
    public function affectedRows()
    {
        return $this->raiseError(DB_ERROR_NOT_CAPABLE);
    }
    public function getSequenceName($sqn)
    {
        return sprintf($this->getOption("seqname_format"), preg_replace("/[^a-z0-9_.]/i", "_", $sqn));
    }
    public function nextId($seq_name, $ondemand = true)
    {
        return $this->raiseError(DB_ERROR_NOT_CAPABLE);
    }
    public function createSequence($seq_name)
    {
        return $this->raiseError(DB_ERROR_NOT_CAPABLE);
    }
    public function dropSequence($seq_name)
    {
        return $this->raiseError(DB_ERROR_NOT_CAPABLE);
    }
    public function &raiseError($code = DB_ERROR, $mode = NULL, $options = NULL, $userinfo = NULL, $nativecode = NULL, $dummy1 = NULL, $dummy2 = NULL)
    {
        if (is_object($code)) {
            if ($mode === NULL && !empty($this->_default_error_mode)) {
                $mode = $this->_default_error_mode;
                $options = $this->_default_error_options;
            }
            $tmp = PEAR::raiseError($code, NULL, $mode, $options, NULL, NULL, true);
            return $tmp;
        }
        if ($userinfo === NULL) {
            $userinfo = $this->last_query;
        }
        if ($nativecode) {
            $userinfo .= " [nativecode=" . trim($nativecode) . "]";
        }
        $tmp = PEAR::raiseError(NULL, $code, $mode, $options, $userinfo, "DB_Error", true);
        return $tmp;
    }
    public function errorNative()
    {
        return $this->raiseError(DB_ERROR_NOT_CAPABLE);
    }
    public function errorCode($nativecode)
    {
        if (isset($this->errorcode_map[$nativecode])) {
            return $this->errorcode_map[$nativecode];
        }
        return DB_ERROR;
    }
    public function errorMessage($dbcode)
    {
        global $dbc;
        return $dbc->errorMessage($this->errorcode_map[$dbcode]);
    }
    public function tableInfo($result, $mode = NULL)
    {
        return $this->raiseError(DB_ERROR_NOT_CAPABLE);
    }
    public function getTables()
    {
        return $this->getListOf("tables");
    }
    public function getListOf($type)
    {
        global $dbc;
        $sql = $this->getSpecialQuery($type);
        if ($sql === NULL) {
            $this->last_query = "";
            return $this->raiseError(DB_ERROR_UNSUPPORTED);
        }
        if (is_int($sql) || $dbc->isError($sql)) {
            return $this->raiseError($sql);
        }
        if (is_array($sql)) {
            return $sql;
        }
        return $this->getCol($sql);
    }
    public function getSpecialQuery($type)
    {
        return $this->raiseError(DB_ERROR_UNSUPPORTED);
    }
    public function nextQueryIsManip($manip)
    {
        $this->_next_query_manip = $manip;
    }
    public function _checkManip($query)
    {
        global $dbc;
        if ($this->_next_query_manip || $dbc->isManip($query)) {
            $this->_last_query_manip = true;
        } else {
            $this->_last_query_manip = false;
        }
        $this->_next_query_manip = false;
        return $this->_last_query_manip;
    }
    public function _rtrimArrayValues(&$array)
    {
        foreach ($array as $key => $value) {
            if (is_string($value)) {
                $array[$key] = rtrim($value);
            }
        }
    }
    public function _convertNullArrayValuesToEmpty(&$array)
    {
        foreach ($array as $key => $value) {
            if (is_null($value)) {
                $array[$key] = "";
            }
        }
    }
}

?>