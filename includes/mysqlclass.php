<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
class Database
{
    public $debug = true;
    private static $instance = NULL;
    private $server = "";
    private $user = "";
    private $pass = "";
    private $database = "";
    private $error = 0;
    public $affected_rows = 0;
    private $link_id = 0;
    private $query_id = 0;
    private function __construct($server = NULL, $user = NULL, $pass = NULL, $database = NULL)
    {
        if ($server == NULL || $user == NULL || $database == NULL) {
            $this->oops("Database information must be passed in when the object is first created.");
        }
        $this->server = $server;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;
    }
    public static function obtain($server = NULL, $user = NULL, $pass = NULL, $database = NULL)
    {
        if (!self::$instance) {
            self::$instance = new Database($server, $user, $pass, $database);
        }
        return self::$instance;
    }
    public function connect($new_link = false)
    {
        $this->link_id = mysqli_connect($this->server, $this->user, $this->pass, $this->database);
        if (mysqli_connect_errno()) {
            $this->oops("Could not open database: <b>" . $this->database . "</b>.");
        }
        $this->server = "";
        $this->user = "";
        $this->pass = "";
        $this->database = "";
    }
    public function close()
    {
        if (!mysqli_close($this->link_id)) {
            $this->oops("Connection close failed.");
        }
    }
    public function escape($string)
    {
        if (function_exists("get_magic_quotes_runtime") && get_magic_quotes_runtime()) {
            $string = stripslashes($string);
        }
        return mysqli_real_escape_string($this->link_id, $string);
    }
    public function query($sql)
    {
        mysqli_set_charset($this->link_id, "utf8");
        $this->query_id = mysqli_query($this->link_id, $sql);
        if (!$this->query_id) {
            $this->oops("<b>MySQL Query fail:</b> " . $sql);
            return 0;
        }
        $this->affected_rows = mysqli_affected_rows($this->link_id);
        return $this->query_id;
    }
    public function query_first($query_string)
    {
        $query_id = $this->query($query_string);
        $out = $this->fetch($query_id);
        $this->free_result($query_id);
        return $out;
    }
    public function fetch($query_id = -1)
    {
        if ($query_id != -1) {
            $this->query_id = $query_id;
        }
        if (isset($this->query_id)) {
            $record = mysqli_fetch_assoc($this->query_id);
        } else {
            $this->oops("Invalid query_id: <b>" . $this->query_id . "</b>. Records could not be fetched.");
        }
        return $record;
    }
    public function fetch_array($sql)
    {
        $query_id = $this->query($sql);
        $out = [];
        while ($row = $this->fetch($query_id)) {
            $out[] = $row;
        }
        $this->free_result($query_id);
        return $out;
    }
    public function updateFields2($table, $data)
    {
        $query_id = $this->query("SHOW COLUMNS FROM " . $table);
        $out = [];
        while ($row = $this->fetch($query_id)) {
            if (strpos($row["Type"], "int") !== false) {
                $flag = false;
                foreach ($data as $k => $v) {
                    if ($k == $row["Field"] && ($v == NULL || $v == "")) {
                        $data[$k] = 0;
                    }
                    if ($k == $row["Field"]) {
                        $flag = true;
                    }
                }
            } else {
                if (strpos($row["Type"], "decimal") !== false) {
                    $flag = false;
                    foreach ($data as $k => $v) {
                        if ($k == $row["Field"] && ($v == NULL || $v == "")) {
                            $data[$k] = 0;
                        }
                        if ($k == $row["Field"]) {
                            $flag = true;
                        }
                    }
                }
            }
        }
        return $data;
    }
    public function update($table, $data, $where = "1")
    {
        global $MySqlStricktMode;
        global $log;
        $q = "UPDATE `" . $table . "` SET ";
        if ($MySqlStricktMode) {
            $data = $this->updateFields2($table, $data);
        }
        foreach ($data as $key => $val) {
            if (strtolower($val) == "null") {
                $q .= "`" . $key . "` = NULL, ";
            } else {
                if (strtolower($val) == "now()") {
                    $q .= "`" . $key . "` = NOW(), ";
                } else {
                    if (preg_match("/^increment\\((\\-?\\d+)\\)\$/i", $val, $m)) {
                        $q .= "`" . $key . "` = `" . $key . "` + " . $m[1] . ", ";
                    } else {
                        $q .= "`" . $key . "`='" . $this->escape($val) . "', ";
                    }
                }
            }
        }
        $q = rtrim($q, ", ") . " WHERE " . $where . ";";
        if ($log) {
            $log->QueryCnt++;
            $log->Query($q);
        }
        return $this->query($q);
    }
    public function updateFields($table, $data)
    {
        $query_id = $this->query("SHOW COLUMNS FROM " . $table);
        $out = [];
        while ($row = $this->fetch($query_id)) {
            if (strpos($row["Type"], "int") !== false) {
                $flag = false;
                foreach ($data as $k => $v) {
                    if ($k == $row["Field"] && ($v == NULL || $v == "")) {
                        $data[$k] = 0;
                    }
                    if ($k == $row["Field"]) {
                        $flag = true;
                    }
                }
                if (!$flag) {
                    $data[$row["Field"]] = 0;
                }
            } else {
                if (strpos($row["Type"], "decimal") !== false) {
                    $flag = false;
                    foreach ($data as $k => $v) {
                        if ($k == $row["Field"] && ($v == NULL || $v == "")) {
                            $data[$k] = 0;
                        }
                        if ($k == $row["Field"]) {
                            $flag = true;
                        }
                    }
                    if (!$flag) {
                        $data[$row["Field"]] = 0;
                    }
                } else {
                    $flag = false;
                    foreach ($data as $k => $v) {
                        if ($k == $row["Field"]) {
                            $flag = true;
                        }
                    }
                    if (!$flag) {
                        $data[$row["Field"]] = "";
                    }
                }
            }
        }
        return $data;
    }
    public function insertMultiple($table, $multipledata)
    {
        global $MySqlStricktMode;
        global $log;
        if (0 < count($multipledata)) {
            $q = "INSERT INTO `" . $table . "` ";
            $v = "";
            $n = "";
            foreach ($multipledata as $k => $data) {
                if ($MySqlStricktMode) {
                    $data = $this->updateFields($table, $data);
                }
                $n = "";
                $v = "";
                foreach ($data as $key => $val) {
                    $n .= "`" . $key . "`, ";
                    if (strtolower($val) == "null") {
                        $v .= "NULL, ";
                    } else {
                        if (strtolower($val) == "now()") {
                            $v .= "NOW(), ";
                        } else {
                            $v .= "'" . $this->escape($val) . "', ";
                        }
                    }
                }
                if ($k == 0) {
                    $q .= "(" . rtrim($n, ", ") . ") VALUES (" . rtrim($v, ", ") . "),";
                } else {
                    $q .= "  (" . rtrim($v, ", ") . "),";
                }
            }
            $q = trim($q, ",");
            $q = $q . ";";
            if ($log) {
                $log->QueryCnt++;
                $log->Query($q);
            }
            if ($this->query($q)) {
                return mysqli_insert_id($this->link_id);
            }
            return false;
        }
    }
    public function insert($table, $data)
    {
        global $MySqlStricktMode;
        global $log;
        $q = "INSERT INTO `" . $table . "` ";
        $v = "";
        $n = "";
        if ($MySqlStricktMode) {
            $data = $this->updateFields($table, $data);
        }
        foreach ($data as $key => $val) {
            $n .= "`" . $key . "`, ";
            if (strtolower($val) == "null") {
                $v .= "NULL, ";
            } else {
                if (strtolower($val) == "now()") {
                    $v .= "NOW(), ";
                } else {
                    $v .= "'" . $this->escape($val) . "', ";
                }
            }
        }
        $q .= "(" . rtrim($n, ", ") . ") VALUES (" . rtrim($v, ", ") . ");";
        if ($log) {
            $log->QueryCnt++;
            $log->Query($q);
        }
        if ($this->query($q)) {
            return mysqli_insert_id($this->link_id);
        }
        return false;
    }
    private function free_result($query_id = -1)
    {
        if ($query_id != -1) {
            $this->query_id = $query_id;
        }
        if ($this->query_id != 0 && !mysqli_free_result($this->query_id)) {
            $this->oops("Result ID: <b>" . $this->query_id . "</b> could not be freed.");
        }
    }
    private function oops($msg = "")
    {
        if (!empty($this->link_id)) {
            $this->error = mysqli_error($this->link_id);
        } else {
            $this->error = mysqli_error();
            $msg = "<b>WARNING:</b> No link_id found. Likely not be connected to database.<br />" . $msg;
        }
        if (!$this->debug) {
            return NULL;
        }
        echo "        <table align=\"center\" border=\"1\" cellspacing=\"0\" style=\"background:white;color:black;width:80%;\">\n        <tr><th colspan=2>Database Error</th></tr>\n        <tr><td align=\"right\" valign=\"top\">Message:</td><td>";
        echo $msg;
        echo "</td></tr>\n        ";
        if (!empty($this->error)) {
            echo "<tr><td align=\"right\" valign=\"top\" nowrap>MySQL Error:</td><td>" . $this->error . "</td></tr>";
        }
        echo "        <tr><td align=\"right\">Date:</td><td>";
        echo date("l, F j, Y \\a\\t g:i:s A");
        echo "</td></tr>\n        ";
        if (!empty($_SERVER["REQUEST_URI"])) {
            echo "<tr><td align=\"right\">Script:</td><td><a href=\"" . $_SERVER["REQUEST_URI"] . "\">" . $_SERVER["REQUEST_URI"] . "</a></td></tr>";
        }
        echo "        ";
        if (!empty($_SERVER["HTTP_REFERER"])) {
            echo "<tr><td align=\"right\">Referer:</td><td><a href=\"" . $_SERVER["HTTP_REFERER"] . "\">" . $_SERVER["HTTP_REFERER"] . "</a></td></tr>";
        }
        echo "        </table>\n    ";
    }
}

?>
