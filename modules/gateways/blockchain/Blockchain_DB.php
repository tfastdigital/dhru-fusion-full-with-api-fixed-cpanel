<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once __DIR__ . "/../../../configuration.php";
/**
 * Class Blockchain_DB
 */
class Blockchain_DB
{
    private $db_host = NULL;
    private $db_username = NULL;
    private $db_password = NULL;
    private $db_name = NULL;
    public static $FETCH_ASSOC = "assoc";
    public static $FETCH_ARRAY = "array";
    public function __construct()
    {
        global $db_host;
        global $db_username;
        global $db_password;
        global $db_name;
        $this->db_host = $db_host;
        $this->db_username = $db_username;
        $this->db_password = $db_password;
        $this->db_name = $db_name;
        $this->db_link = mysqli_connect($this->db_host, $this->db_username, $this->db_password, $this->db_name);
    }
    public function mysqlQuery($query)
    {
        $argcount = func_num_args();
        if (1 < $argcount) {
            $args = func_get_args();
            unset($args[0]);
            for ($i = 1; $i <= $argcount - 1; $i++) {
                $args[$i] = $args[$i] == "NULL" ? "NULL" : $this->quote_smart($args[$i]);
            }
            $query = vsprintf($query, $args);
        }
        $result = mysqli_query($this->db_link, $query);
        $err = mysqli_errno($this->db_link);
        if ($err === 2006 || $err === 2013) {
            $this->db_link = mysqli_connect($this->db_host, $this->db_username, $this->db_password, $this->db_name);
            return $this->mysqlQuery($query);
        }
        return $result;
    }
    public function fetch_assoc($result)
    {
        return mysqli_fetch_assoc($result);
    }
    private function quote_smart($value)
    {
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
        if (!is_numeric($value)) {
            $value = "'" . mysqli_real_escape_string($this->db_link, $value) . "'";
        }
        return $value;
    }
}

?>