<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Dhru\Lib;

class DBCompare
{
    private $conn = NULL;
    public $schemaarray = NULL;
    public $diffquery = [];
    public function __construct($host, $database, $user, $pass)
    {
        try {
            $this->conn = new \PDO("mysql:host=" . $host . ";dbname=" . $database, $user, $pass);
        } catch (PDOException $e) {
            throw new \Exception($e);
        }
        $q = $this->conn->query("show tables");
        while ($r = $q->fetch(\PDO::FETCH_ASSOC)) {
            $tqs = $this->conn->prepare("SHOW COLUMNS FROM " . $r["Tables_in_" . $database] . "");
            $tqs->execute();
            while ($rq = $tqs->fetch(\PDO::FETCH_BOTH)) {
                $this->schemaarray[$r["Tables_in_" . $database]][$rq["Field"]] = $rq;
            }
        }
    }
    public function differ($json)
    {
        $dhrujson = json_decode($json, true);
        $localjson = $this->schemaarray;
        $MissingTable = [];
        $MissingField = [];
        $FieldDiff = [];
        foreach ($dhrujson as $table => $fields) {
            if (!$localjson[$table]) {
                $MissingTable[$table] = $fields;
            } else {
                foreach ($fields as $fieldname => $fielddetail) {
                    if (!$localjson[$table][$fieldname]) {
                        $MissingField[$table][$fieldname] = $fielddetail;
                    } else {
                        if ($localjson[$table][$fieldname]["Type"] != $fielddetail["Type"] || $localjson[$table][$fieldname]["Extra"] != $fielddetail["Extra"]) {
                            $FieldDiff[$table][$fieldname] = $fielddetail;
                        } else {
                            if ((contains($fielddetail["Type"], "decimal") || contains($fielddetail["Type"], "int")) && $localjson[$table][$fieldname]["Default"] != $fielddetail["Default"]) {
                                $FieldDiff[$table][$fieldname] = $fielddetail;
                            }
                        }
                    }
                }
            }
        }
        foreach ($MissingTable as $tablename => $field) {
            $Append = "";
            $SQL = "CREATE TABLE IF NOT EXISTS `" . $tablename . "` (";
            foreach ($field as $fieldname => $fielddetail) {
                $Primary = "";
                if ($fielddetail["Key"] == "PRI") {
                    $Append .= " ,PRIMARY KEY (`" . $fieldname . "`)";
                    if (stripos($fielddetail["Extra"], "auto_increment") !== false) {
                        $Primary = " AUTO_INCREMENT";
                    }
                }
                $Null = " NULL ";
                if ($fielddetail["Null"] == "NO") {
                    $Null = " NOT NULL ";
                }
                if ($fielddetail["Default"] != "") {
                    if ($fielddetail["Type"] == "datetime") {
                        $fielddetail["Default"] = "'" . $fielddetail["Default"] . "'";
                    }
                    $Null .= " DEFAULT " . $fielddetail["Default"] . " ";
                }
                $SQL .= " `" . $fieldname . "` " . $fielddetail["Type"] . " " . $Null . " " . $Primary . ",";
            }
            $SQL = rtrim($SQL, ",");
            $SQL .= " " . $Append . " )ENGINE=MyISAM DEFAULT CHARSET=latin1;";
            $this->diffquery[]["query"] = $SQL;
        }
        foreach ($MissingField as $tablename => $field) {
            $SQL = "ALTER TABLE `" . $tablename . "`";
            foreach ($field as $fieldname => $fielddetail) {
                $Primary = "";
                if ($fielddetail["Key"] == "PRI") {
                    $Primary = " PRIMARY KEY";
                }
                if (stripos($fielddetail["Extra"], "auto_increment") !== false) {
                    $Primary .= " AUTO_INCREMENT";
                }
                $Null = " NULL ";
                if ($fielddetail["Null"] == "NO") {
                    $Null = " NOT NULL ";
                }
                if ($fielddetail["Default"] != "") {
                    $Null .= " DEFAULT " . $fielddetail["Default"] . " ";
                }
                $SQL .= "ADD COLUMN `" . $fieldname . "` " . $fielddetail["Type"] . " " . $Null . " " . $Primary . ",";
            }
            $SQL = rtrim($SQL, ",");
            $SQL .= ";";
            $this->diffquery[]["query"] = $SQL;
        }
        foreach ($FieldDiff as $tablename => $field) {
            $SQL = "ALTER TABLE `" . $tablename . "`";
            foreach ($field as $fieldname => $fielddetail) {
                $Primary = "";
                if (stripos($fielddetail["Extra"], "auto_increment") !== false) {
                    $Primary = " AUTO_INCREMENT";
                    if ($localjson[$tablename][$fieldname]["Key"] != "PRI") {
                        $Primary .= " PRIMARY KEY";
                    }
                } else {
                    if ($fielddetail["Key"] == "PRI") {
                        $Primary = " PRIMARY KEY";
                    }
                }
                $Default = "";
                if ($fielddetail["Default"] != "") {
                    $Default = " DEFAULT " . $fielddetail["Default"] . " ";
                }
                $SQL .= " MODIFY  `" . $fieldname . "` " . $fielddetail["Type"] . " " . $Default . " " . $Primary . ",";
            }
            $SQL = rtrim($SQL, ",");
            $SQL .= ";";
            $this->diffquery[]["query"] = $SQL;
        }
    }
    public function exec()
    {
        foreach ($this->diffquery as $k => $sql) {
            if ($this->conn->query((string) $sql["query"])) {
                $this->diffquery[$k]["status"] = true;
            } else {
                $this->diffquery[$k]["status"] = false;
                $this->diffquery[$k]["details"] = $this->conn->errorInfo();
            }
        }
        return $this->diffquery;
    }
}

?>