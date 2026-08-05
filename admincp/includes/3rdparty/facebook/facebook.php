<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "base_facebook.php";
/**
 * Extends the BaseFacebook class with the intent of using
 * PHP sessions to store user ids and access tokens.
 */
class Facebook extends BaseFacebook
{
    protected static $kSupportedKeys = ["state", "code", "access_token", "user_id"];
    public function __construct($config)
    {
        if (!session_id()) {
            session_start();
        }
        parent::__construct($config);
    }
    protected function setPersistentData($key, $value)
    {
        if (!in_array($key, self::$kSupportedKeys)) {
            self::errorLog("Unsupported key passed to setPersistentData.");
        } else {
            $session_var_name = $this->constructSessionVariableName($key);
            $_SESSION[$session_var_name] = $value;
        }
    }
    protected function getPersistentData($key, $default = false)
    {
        if (!in_array($key, self::$kSupportedKeys)) {
            self::errorLog("Unsupported key passed to getPersistentData.");
            return $default;
        }
        $session_var_name = $this->constructSessionVariableName($key);
        return isset($_SESSION[$session_var_name]) ? $_SESSION[$session_var_name] : $default;
    }
    protected function clearPersistentData($key)
    {
        if (!in_array($key, self::$kSupportedKeys)) {
            self::errorLog("Unsupported key passed to clearPersistentData.");
        } else {
            $session_var_name = $this->constructSessionVariableName($key);
            unset($_SESSION[$session_var_name]);
        }
    }
    protected function clearAllPersistentData()
    {
        foreach (self::$kSupportedKeys as $key) {
            $this->clearPersistentData($key);
        }
    }
    protected function constructSessionVariableName($key)
    {
        return implode("_", ["fb", $this->getAppId(), $key]);
    }
}

?>