<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once PEAR_DIR . "DB.php";
/**
 * Provides an object interface to a table row
 *
 * It lets you add, delete and change rows using objects rather than SQL
 * statements.
 *
 * @category   Database
 * @package    DB
 * @author     Stig Bakken <stig@php.net>
 * @copyright  1997-2007 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.7.14RC1
 * @link       http://pear.php.net/package/DB
 */
class DB_storage extends PEAR
{
    /** the name of the table (or view, if the backend database supports
        updates in views) we hold data from */
    public $_table = NULL;
    /** which column(s) in the table contains primary keys, can be a
        string for single-column primary keys, or an array of strings
        for multiple-column primary keys */
    public $_keycolumn = NULL;
    /** DB connection handle used for all transactions */
    public $_dbh = NULL;
    /** an assoc with the names of database fields stored as properties
        in this object */
    public $_properties = [];
    /** an assoc with the names of the properties in this object that
        have been changed since they were fetched from the database */
    public $_changes = [];
    /** flag that decides if data in this object can be changed.
        objects that don't have their table's key column in their
        property lists will be flagged as read-only. */
    public $_readonly = false;
    /** function or method that implements a validator for fields that
        are set, this validator function returns true if the field is
        valid, false if not */
    public $_validator = NULL;
    public function DB_storage($table, $keycolumn, &$dbh, $validator = NULL)
    {
        $this->PEAR("DB_Error");
        $this->_table = $table;
        $this->_keycolumn = $keycolumn;
        $this->_dbh = $dbh;
        $this->_readonly = false;
        $this->_validator = $validator;
    }
    public function _makeWhere($keyval = NULL)
    {
        if (is_array($this->_keycolumn)) {
            if ($keyval === NULL) {
                for ($i = 0; $i < sizeof($this->_keycolumn); $i++) {
                    $keyval[] = $this->{$this->_keycolumn[$i]};
                }
            }
            $whereclause = "";
            for ($i = 0; $i < sizeof($this->_keycolumn); $i++) {
                if (0 < $i) {
                    $whereclause .= " AND ";
                }
                $whereclause .= $this->_keycolumn[$i];
                if (is_null($keyval[$i])) {
                    $whereclause .= " IS NULL";
                } else {
                    $whereclause .= " = " . $this->_dbh->quote($keyval[$i]);
                }
            }
        } else {
            if ($keyval === NULL) {
                $keyval = $this->{$this->_keycolumn};
            }
            $whereclause = $this->_keycolumn;
            if (is_null($keyval)) {
                $whereclause .= " IS NULL";
            } else {
                $whereclause .= " = " . $this->_dbh->quote($keyval);
            }
        }
        return $whereclause;
    }
    public function setup($keyval)
    {
        $whereclause = $this->_makeWhere($keyval);
        $query = "SELECT * FROM " . $this->_table . " WHERE " . $whereclause;
        $sth = $this->_dbh->query($query);
        if (DB::isError($sth)) {
            return $sth;
        }
        $row = $sth->fetchRow(DB_FETCHMODE_ASSOC);
        if (DB::isError($row)) {
            return $row;
        }
        if (!$row) {
            return $this->raiseError(NULL, DB_ERROR_NOT_FOUND, NULL, NULL, $query, NULL, true);
        }
        
        return DB_OK;
    }
    public function insert($newpk)
    {
        if (is_array($this->_keycolumn)) {
            $primarykey = $this->_keycolumn;
        } else {
            $primarykey = [$this->_keycolumn];
        }
        settype($newpk, "array");
        for ($i = 0; $i < sizeof($primarykey); $i++) {
            $pkvals[] = $this->_dbh->quote($newpk[$i]);
        }
        $sth = $this->_dbh->query("INSERT INTO " . $this->_table . " (" . implode(",", $primarykey) . ") VALUES(" . implode(",", $pkvals) . ")");
        if (DB::isError($sth)) {
            return $sth;
        }
        if (sizeof($newpk) == 1) {
            $newpk = $newpk[0];
        }
        $this->setup($newpk);
    }
    public function toString()
    {
        $info = strtolower(get_class($this));
        $info .= " (table=";
        $info .= $this->_table;
        $info .= ", keycolumn=";
        if (is_array($this->_keycolumn)) {
            $info .= "(" . implode(",", $this->_keycolumn) . ")";
        } else {
            $info .= $this->_keycolumn;
        }
        $info .= ", dbh=";
        if (is_object($this->_dbh)) {
            $info .= $this->_dbh->toString();
        } else {
            $info .= "null";
        }
        $info .= ")";
        if (sizeof($this->_properties)) {
            $info .= " [loaded, key=";
            $keyname = $this->_keycolumn;
            if (is_array($keyname)) {
                $info .= "(";
                for ($i = 0; $i < sizeof($keyname); $i++) {
                    if (0 < $i) {
                        $info .= ",";
                    }
                    $info .= $this->{$keyname}[$i];
                }
                $info .= ")";
            } else {
                $info .= $this->{$keyname};
            }
            $info .= "]";
        }
        if (sizeof($this->_changes)) {
            $info .= " [modified]";
        }
        return $info;
    }
    public function dump()
    {
        foreach ($this->_properties as $prop => $foo) {
            echo $prop . " = ";
            echo htmlentities($this->{$prop});
            echo "<br />\n";
        }
    }
    public function &create($table, &$data)
    {
        $classname = strtolower(get_class($this));
        $obj = new $classname($table);
        foreach ($data as $name => $value) {
            $obj->_properties[$name] = true;
            $obj->{$name} =& $value;
        }
        return $obj;
    }
    public function set($property, $newvalue)
    {
        if ($this->_readonly) {
            return $this->raiseError(NULL, DB_WARNING_READ_ONLY, NULL, NULL, NULL, NULL, true);
        }
        if (isset($this->_properties[$property])) {
            if (empty($this->_validator)) {
                $valid = true;
            } else {
                $valid = @call_user_func($this->_validator, $this->_table, $property, $newvalue, $this->{$property}, $this);
            }
            if ($valid) {
                $this->{$property} = $newvalue;
                if (empty($this->_changes[$property])) {
                    $this->_changes[$property] = 0;
                } else {
                    $this->_changes[$property]++;
                }
                return true;
            }
            return $this->raiseError(NULL, DB_ERROR_INVALID, NULL, NULL, "invalid field: " . $property, NULL, true);
        }
        return $this->raiseError(NULL, DB_ERROR_NOSUCHFIELD, NULL, NULL, "unknown field: " . $property, NULL, true);
    }
    public function &get($property)
    {
        if (isset($this->_properties[$property])) {
            return $this->{$property};
        }
        $tmp = NULL;
        return $tmp;
    }
    public function _DB_storage()
    {
        if (sizeof($this->_changes)) {
            $this->store();
        }
        $this->_properties = [];
        $this->_changes = [];
        $this->_table = NULL;
    }
    public function store()
    {
        $params = [];
        $vars = [];
        foreach ($this->_changes as $name => $foo) {
            $params[] =& $this->{$name};
            $vars[] = $name . " = ?";
        }
        if ($vars) {
            $query = "UPDATE " . $this->_table . " SET " . implode(", ", $vars) . " WHERE " . $this->_makeWhere();
            $stmt = $this->_dbh->prepare($query);
            $res = $this->_dbh->execute($stmt, $params);
            if (DB::isError($res)) {
                return $res;
            }
            $this->_changes = [];
        }
        return DB_OK;
    }
    public function remove()
    {
        if ($this->_readonly) {
            return $this->raiseError(NULL, DB_WARNING_READ_ONLY, NULL, NULL, NULL, NULL, true);
        }
        $query = "DELETE FROM " . $this->_table . " WHERE " . $this->_makeWhere();
        $res = $this->_dbh->query($query);
        if (DB::isError($res)) {
            return $res;
        }
        foreach ($this->_properties as $prop => $foo) {
            unset($this->{$prop});
        }
        $this->_properties = [];
        $this->_changes = [];
        return DB_OK;
    }
}

?>