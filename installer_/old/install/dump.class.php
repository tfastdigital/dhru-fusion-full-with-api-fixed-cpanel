<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class dbStructUpdater
{
    public $sourceStruct = "";
    public $destStruct = "";
    public $config = [];
    public function dbStructUpdater()
    {
        $this->init();
    }
    public function init()
    {
        $this->config["updateTypes"] = "create, drop, add, remove, modify";
        $this->config["varcharDefaultIgnore"] = true;
        $this->config["intDefaultIgnore"] = true;
        $this->config["ignoreIncrement"] = true;
        $this->config["forceIfNotExists"] = true;
        $this->config["ingoreIfNotExists"] = true;
    }
    public function setConfig($config = [])
    {
        if (is_array($config)) {
            $this->config = array_merge($this->config, $config);
        }
    }
    public function getUpdates($source, $dest, $asString = false)
    {
        $result = $asString ? "" : [];
        $compRes = $this->compare($source, $dest);
        if (empty($compRes)) {
            return $result;
        }
        $compRes = $this->filterDiffs($compRes);
        if (empty($compRes)) {
            return $result;
        }
        $result = $this->getDiffSql($compRes);
        if ($asString) {
            $result = implode(";\r\n", $result);
        }
        return $result;
    }
    public function filterDiffs($compRes)
    {
        $result = [];
        if (is_array($this->config["updateTypes"])) {
            $updateActions = $this->config["updateTypes"];
        } else {
            $updateActions = array_map("trim", explode(",", $this->config["updateTypes"]));
        }
        $allowedActions = ["create", "drop", "add", "remove", "modify"];
        $updateActions = array_intersect($updateActions, $allowedActions);
        foreach ($compRes as $table => $info) {
            if ($info["sourceOrphan"]) {
                if (in_array("create", $updateActions)) {
                    $result[$table] = $info;
                }
            } else {
                if ($info["destOrphan"]) {
                    if (in_array("drop", $updateActions)) {
                        $result[$table] = $info;
                    }
                } else {
                    if ($info["differs"]) {
                        $resultInfo = $info;
                        unset($resultInfo["differs"]);
                        foreach ($info["differs"] as $diff) {
                            if (empty($diff["dest"]) && in_array("add", $updateActions)) {
                                $resultInfo["differs"][] = $diff;
                            } else {
                                if (empty($diff["source"]) && in_array("remove", $updateActions)) {
                                    $resultInfo["differs"][] = $diff;
                                } else {
                                    if (in_array("modify", $updateActions)) {
                                        $resultInfo["differs"][] = $diff;
                                    }
                                }
                            }
                        }
                        if (!empty($resultInfo["differs"])) {
                            $result[$table] = $resultInfo;
                        }
                    }
                }
            }
        }
        return $result;
    }
    public function getDiffInfo($compRes)
    {
        if (!is_array($compRes)) {
            return false;
        }
        $result = ["sourceOrphans" => [], "destOrphans" => [], "different" => []];
        foreach ($compRes as $table => $info) {
            if ($info["sourceOrphan"]) {
                $result["sourceOrphans"][] = $table;
            } else {
                if ($info["destOrphan"]) {
                    $result["destOrphans"][] = $table;
                } else {
                    $result["different"][] = $table;
                }
            }
        }
        return $result;
    }
    public function compare($source, $dest)
    {
        $this->sourceStruct = $source;
        $this->destStruct = $dest;
        $result = [];
        $destTabNames = $this->getTableList($this->destStruct);
        $sourceTabNames = $this->getTableList($this->sourceStruct);
        $common = array_intersect($destTabNames, $sourceTabNames);
        $destOrphans = array_diff($destTabNames, $common);
        $sourceOrphans = array_diff($sourceTabNames, $common);
        $all = array_unique(array_merge($destTabNames, $sourceTabNames));
        sort($all);
        foreach ($all as $tab) {
            $info = ["destOrphan" => false, "sourceOrphan" => false, "differs" => false];
            if (in_array($tab, $destOrphans)) {
                $info["destOrphan"] = true;
            } else {
                if (in_array($tab, $sourceOrphans)) {
                    $info["sourceOrphan"] = true;
                } else {
                    $destSql = $this->getTabSql($this->destStruct, $tab, true);
                    $sourceSql = $this->getTabSql($this->sourceStruct, $tab, true);
                    $diffs = $this->compareSql($sourceSql, $destSql);
                    if ($diffs === false) {
                        trigger_error("[WARNING] error parsing definition of table \"" . $tab . "\" - skipped");
                    } else {
                        if (!empty($diffs)) {
                            $info["differs"] = $diffs;
                        }
                    }
                }
            }
            $result[$tab] = $info;
        }
        return $result;
    }
    public function getTableList($struct)
    {
        $result = [];
        if (preg_match_all("/CREATE(?:\\s*TEMPORARY)?\\s*TABLE\\s*(?:IF NOT EXISTS\\s*)?(?:`?(\\w+)`?\\.)?`?(\\w+)`?/i", $struct, $m)) {
            foreach ($m[2] as $match) {
                $result[] = $match;
            }
        }
        return $result;
    }
    public function getTabSql($struct, $tab, $removeDatabase = true)
    {
        $result = "";
        if (preg_match("/(CREATE(?:\\s*TEMPORARY)?\\s*TABLE\\s*(?:IF NOT EXISTS\\s*)?)(?:`?(\\w+)`?\\.)?(`?(" . $tab . ")`?(\\W|\$))/i", $struct, $m, PREG_OFFSET_CAPTURE)) {
            $tableDef = $m[0][0];
            $start = $m[0][1];
            $database = $m[2][0];
            $offset = $start + strlen($m[0][0]);
            $end = $this->getDelimPos($struct, $offset);
            if ($end === false) {
                $result = substr($struct, $start);
            } else {
                $result = substr($struct, $start, $end - $start);
            }
        }
        $result = trim($result);
        if ($database && $removeDatabase) {
            $result = str_replace($tableDef, $m[1][0] . $m[3][0], $result);
        }
        return $result;
    }
    public function splitTabSql($sql)
    {
        $result = [];
        $openBracketPos = $this->getDelimPos($sql, 0, "(");
        if ($openBracketPos === false) {
            trigger_error("[WARNING] can not find opening bracket in table definition");
            return false;
        }
        $prefix = substr($sql, 0, $openBracketPos + 1);
        $result[] = trim($prefix);
        $body = substr($sql, strlen($prefix));
        while (($commaPos = $this->getDelimPos($body, 0, ",", true)) !== false) {
            $part = trim(substr($body, 0, $commaPos + 1));
            if ($part) {
                $result[] = $part;
            }
            $body = substr($body, $commaPos + 1);
        }
        $closeBracketPos = $this->getDelimRpos($body, 0, ")");
        if ($closeBracketPos === false) {
            trigger_error("[WARNING] can not find closing bracket in table definition");
            return false;
        }
        $part = substr($body, 0, $closeBracketPos);
        $result[] = trim($part);
        $suffix = substr($body, $closeBracketPos);
        $suffix = trim($suffix);
        if ($suffix) {
            $result[] = $suffix;
        }
        return $result;
    }
    public function compareSql($sourceSql, $destSql)
    {
        $result = [];
        $sourceParts = $this->splitTabSql($sourceSql);
        if ($sourceParts === false) {
            trigger_error("[WARNING] error parsing source sql");
            return false;
        }
        $destParts = $this->splitTabSql($destSql);
        if ($destParts === false) {
            trigger_error("[WARNING] error parsing destination sql");
            return false;
        }
        $sourcePartsIndexed = [];
        $destPartsIndexed = [];
        foreach ($sourceParts as $line) {
            $lineInfo = $this->processLine($line);
            if ($lineInfo) {
                if (stripos($lineInfo["key"], "KEY") === false) {
                    $lineInfo["line"] = str_replace("DEFAULT", "NOT", $lineInfo["line"]);
                    $sourcePartsIndexed[$lineInfo["key"]] = $lineInfo["line"];
                }
            }
        }
        foreach ($destParts as $line) {
            $lineInfo = $this->processLine($line);
            if ($lineInfo) {
                if (stripos($lineInfo["key"], "KEY") === false) {
                    $lineInfo["line"] = str_replace("DEFAULT", "NOT", $lineInfo["line"]);
                    $destPartsIndexed[$lineInfo["key"]] = $lineInfo["line"];
                }
            }
        }
        $sourceKeys = array_keys($sourcePartsIndexed);
        $destKeys = array_keys($destPartsIndexed);
        $all = array_unique(array_merge($sourceKeys, $destKeys));
        sort($all);
        foreach ($all as $key) {
            $info = ["source" => "", "dest" => ""];
            $inSource = in_array($key, $sourceKeys);
            $inDest = in_array($key, $destKeys);
            $sourceOrphan = $inSource && !$inDest;
            $destOrphan = $inDest && !$inSource;
            $different = $inSource && $inDest && $destPartsIndexed[$key] != $sourcePartsIndexed[$key];
            if ($sourceOrphan) {
                $info["source"] = $sourcePartsIndexed[$key];
            } else {
                if ($destOrphan) {
                    $info["dest"] = $destPartsIndexed[$key];
                } else {
                    if ($different) {
                        $info["source"] = $sourcePartsIndexed[$key];
                        $info["dest"] = $destPartsIndexed[$key];
                    }
                }
            }
            $result[] = $info;
        }
        return $result;
    }
    public function processLine($line)
    {
        $options = $this->config;
        $result = ["key" => "", "line" => ""];
        $line = rtrim(trim($line), ",");
        if (preg_match("/^(CREATE TABLE)|(\\) ENGINE=)/i", $line)) {
            return false;
        }
        if (preg_match("/^(PRIMARY KEY)|(((UNIQUE )|(FULLTEXT ))?KEY `?\\w+`?)/i", $line, $m)) {
            $key = $m[0];
        } else {
            if (preg_match("/^`?\\w+`?/i", $line, $m)) {
                $key = "!" . $m[0];
            } else {
                return false;
            }
        }
        if (!empty($options["varcharDefaultIgnore"])) {
            $line = preg_replace("/(var)?char\\(([0-9]+)\\) NOT NULL default ''/i", "\$1char(\$2) NOT NULL", $line);
        }
        if (!empty($options["intDefaultIgnore"])) {
            $line = preg_replace("/((?:big)|(?:tiny))?int\\(([0-9]+)\\) NOT NULL default '0'/i", "\$1int(\$2) NOT NULL", $line);
        }
        if (!empty($options["ignoreIncrement"])) {
            $line = preg_replace("/ AUTO_INCREMENT=[0-9]+/i", "", $line);
        }
        $result["key"] = $key;
        $result["line"] = preg_replace("/\\s+/", " ", $line);
        $result["line"] = str_replace(", ", ",", $result["line"]);
        $result["line"] = str_replace("enum (", "enum(", $result["line"]);
        return $result;
    }
    public function getDiffSql($diff)
    {
        $options = $this->config;
        $sqls = [];
        if (!is_array($diff) || empty($diff)) {
            return $sqls;
        }
        foreach ($diff as $tab => $info) {
            if ($info["sourceOrphan"]) {
                $sqls[] = "DROP TABLE `" . $tab . "`";
            } else {
                if ($info["destOrphan"]) {
                    $database = "";
                    $destSql = $this->getTabSql($this->destStruct, $tab, $database);
                    if (!empty($options["ignoreIncrement"])) {
                        $destSql = preg_replace("/\\s*AUTO_INCREMENT=[0-9]+/i", "", $destSql);
                    }
                    if (!empty($options["ingoreIfNotExists"])) {
                        $destSql = preg_replace("/IF NOT EXISTS\\s*/i", "", $destSql);
                    }
                    if (!empty($options["forceIfNotExists"])) {
                        $destSql = preg_replace("/(CREATE(?:\\s*TEMPORARY)?\\s*TABLE\\s*)(?:IF NOT EXISTS\\s*)?(`?\\w+`?)/i", "\$1IF NOT EXISTS \$2", $destSql);
                    }
                    $sqls[] = $destSql;
                } else {
                    foreach ($info["differs"] as $finfo) {
                        $inDest = !empty($finfo["dest"]);
                        $inSource = !empty($finfo["source"]);
                        if ($inSource && !$inDest) {
                            $sql = $finfo["source"];
                            $action = "drop";
                        } else {
                            if ($inDest && !$inSource) {
                                $sql = $finfo["dest"];
                                $action = "add";
                            } else {
                                $sql = $finfo["dest"];
                                $action = "modify";
                            }
                        }
                        $sql = $this->getActionSql($action, $tab, $sql);
                        $sqls[] = $sql;
                    }
                }
            }
        }
        return $sqls;
    }
    public function getActionSql($action, $tab, $sql)
    {
        $result = "ALTER TABLE `" . $tab . "` ";
        $action = strtolower($action);
        $keyField = "`?\\w`?(?:\\(\\d+\\))?";
        $keyFieldList = "(?:" . $keyField . "(?:,\\s?)?)+";
        if (preg_match("/((?:PRIMARY )|(?:UNIQUE )|(?:FULLTEXT ))?KEY `?(\\w+)?`?\\s(\\(" . $keyFieldList . "\\))/i", $sql, $m)) {
            $type = strtolower(trim($m[1]));
            $name = trim($m[2]);
            $fields = trim($m[3]);
            switch ($action) {
                case "drop":
                    if ($type == "primary") {
                        $result .= "DROP PRIMARY KEY";
                    } else {
                        $result .= "DROP INDEX `" . $name . "`";
                    }
                    break;
                case "add":
                    if ($type == "primary") {
                        $result .= "ADD PRIMARY KEY " . $fields;
                    } else {
                        if ($type == "") {
                            $result .= "ADD INDEX `" . $name . "` " . $fields;
                        } else {
                            $result .= "ADD " . strtoupper($type) . " `" . $name . "` " . $fields;
                        }
                    }
                    break;
                case "modify":
                    if ($type == "primary") {
                        $result .= "DROP PRIMARY KEY, ADD PRIMARY KEY " . $fields;
                    } else {
                        if ($type == "") {
                            $result .= "DROP INDEX `" . $name . "`, ADD INDEX `" . $name . "` " . $fields;
                        } else {
                            $result .= "DROP INDEX `" . $name . "`, ADD " . strtoupper($type) . " `" . $name . "` " . $fields;
                        }
                    }
                    break;
            }
        } else {
            $sql = rtrim(trim($sql), ",");
            $result .= strtoupper($action);
            if ($action == "drop") {
                $spacePos = strpos($sql, " ");
                $result .= " " . substr($sql, 0, $spacePos);
            } else {
                $result .= " " . $sql;
            }
        }
        return $result;
    }
    public function getDelimPos($string, $offset = 0, $delim = ";", $skipInBrackets = false)
    {
        $stack = [];
        $rbs = "\\\\";
        $regPrefix = "(?<!" . $rbs . ")(?:" . $rbs . "{2})*";
        $reg = $regPrefix . "(\"|')|(/\\*)|(\\*/)|(-- )|(\\r\\n|\\r|\\n)|";
        if ($skipInBrackets) {
            $reg .= "(\\(|\\))|";
        } else {
            $reg .= "()";
        }
        $reg .= "(" . preg_quote($delim) . ")";
        while (preg_match("%" . $reg . "%", $string, $m, PREG_OFFSET_CAPTURE, $offset)) {
            $offset = $m[0][1] + strlen($m[0][0]);
            if (end($stack) == "/*") {
                if (!empty($m[3][0])) {
                    array_pop($stack);
                }
            } else {
                if (end($stack) == "-- ") {
                    if (!empty($m[5][0])) {
                        array_pop($stack);
                    }
                } else {
                    if (!empty($m[7][0]) && empty($stack)) {
                        return $m[7][1];
                    }
                    if (!empty($m[6][0])) {
                        if (empty($stack) && $m[6][0] == "(") {
                            array_push($stack, $m[6][0]);
                        } else {
                            if ($m[6][0] == ")" && end($stack) == "(") {
                                array_pop($stack);
                            }
                        }
                    } else {
                        if (!empty($m[1][0])) {
                            if (end($stack) == $m[1][0]) {
                                array_pop($stack);
                            } else {
                                array_push($stack, $m[1][0]);
                            }
                        } else {
                            if (!empty($m[2][0])) {
                                array_push($stack, $m[2][0]);
                            } else {
                                if (!empty($m[4][0])) {
                                    array_push($stack, $m[4][0]);
                                }
                            }
                        }
                    }
                }
            }
        }
        return false;
    }
    public function getDelimRpos($string, $offset = 0, $delim = ";", $skipInBrackets = false)
    {
        $pos = $this->getDelimPos($string, $offset, $delim, $skipInBrackets);
        if ($pos === false) {
            return false;
        }
        do {
            $newPos = $this->getDelimPos($string, $pos + 1, $delim, $skipInBrackets);
            if ($newPos !== false) {
                $pos = $newPos;
            }
        } while ($newPos === false);
        return $pos;
    }
}
class MySQLDump1
{
    public $tables = [];
    public $connected = false;
    public $output = NULL;
    public $droptableifexists = false;
    public $mysqli_error = NULL;
    public $connection = "";
    public function dquery($query, $conn = "")
    {
        return mysqli_query($this->connection, $query);
    }
    public function connect($host, $user, $pass, $db)
    {
        $return = true;
        $conn = @mysqli_connect($host, $user, $pass, $db);
        if (!$conn) {
            $this->mysqli_error = mysqli_error();
            $return = false;
        }
        $this->connection = $conn;
        $this->connected = $return;
        return $return;
    }
    public function list_tables()
    {
        $return = true;
        if (!$this->connection) {
            $return = false;
        }
        $this->tables = [];
        $sql = $this->dquery("SHOW TABLES");
        while ($row = mysqli_fetch_row($sql)) {
            array_push($this->tables, $row[0]);
        }
        return $return;
    }
    public function dump()
    {
        $this->output = "";
        $this->list_tables() || trigger_error($this->mysqli_error, 256);
        foreach ($this->tables as $table) {
            $this->dump_table($table, false);
        }
        return true;
    }
    public function list_values($tablename)
    {
        $sql = $this->dquery("SELECT * FROM " . $tablename, $this->connection);
        $this->output .= "\n\n-- Dumping data for table: " . $tablename . "\n\n";
        while ($row = mysqli_fetch_assoc($sql)) {
            $broj_polja = count($row) / 2;
            $this->output .= "INSERT INTO `" . $tablename . "` VALUES(";
            $buffer = "";
            for ($i = 0; $i < $broj_polja; $i++) {
                $vrednost = trim($row[$i]);
                $vrednost = str_replace("\n", "", $vrednost);
                if (!is_integer($vrednost)) {
                    $vrednost = "'" . addslashes($vrednost) . "'";
                }
                $buffer .= $vrednost . ", ";
            }
            $buffer = substr($buffer, 0, count($buffer) - 3);
            $this->output .= $buffer . ");\n";
        }
    }
    public function dump_table($tablename, $single = true)
    {
        if ($single) {
            $this->output = "";
        }
        $this->get_table_structure($tablename);
    }
    public function get_table_structure($tablename)
    {
        $this->output .= "\n\n-- Dumping structure for table: " . $tablename . "\n\n";
        $sql = $this->dquery("SHOW CREATE TABLE " . $tablename);
        $vals = str_replace("auto_increment", "AUTO_INCREMENT", $this->mysqli_result($sql, 0, "Create Table") . ";");
        if (strpos($vals, "null default") !== false) {
            $vals = str_ireplace("null default", "NULL DEFAULT", $vals);
        }
        if (stripos($vals, "default null") !== false) {
            $vals = str_ireplace("default null", "DEFAULT NULL", $vals);
        }
        $this->output .= $vals;
    }
    public function mysqli_result($res, $row = 0, $col = 0)
    {
        $numrows = mysqli_num_rows($res);
        if ($numrows && $row <= $numrows - 1 && 0 <= $row) {
            mysqli_data_seek($res, $row);
            $resrow = is_numeric($col) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
            if (isset($resrow[$col])) {
                return $resrow[$col];
            }
        }
        return false;
    }
}

?>