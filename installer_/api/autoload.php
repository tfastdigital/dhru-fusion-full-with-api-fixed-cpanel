<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("ENV", "production");
define("VERSION", "2022.1");
define("RC", "RC");
define("APPNAME", "DHRU FUSION");
global $conn;
error_reporting(0);
$starttime = microtime(true);
register_shutdown_function("shut");
set_exception_handler("UncaughtException");
if (!$_ENV["ENDPOINT_VERSION"]) {
    $_ENV["ENDPOINT_VERSION"] = str_replace(__DIR__ . "/", "", getcwd());
}
define("E_FATAL", 4437);
spl_autoload_register(function ($class) {
    $prefix = "Dhru\\";
    $base_dir = __DIR__ . "/" . $_ENV["ENDPOINT_VERSION"] . "/";
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return NULL;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace("\\", "/", $relative_class) . ".php";
    if (file_exists($file)) {
        require $file;
    }
});
class ErrorOut extends Exception
{
    private $_data = "";
    public function __construct($message, $data = [])
    {
        $this->_data = $data;
        parent::__construct($message);
    }
    public function getData()
    {
        return $this->_data;
    }
}
class SuccessOut extends Exception
{
    private $_data = "";
    public function __construct($message, $data = [])
    {
        $this->_data = $data;
        parent::__construct($message);
    }
    public function getData()
    {
        return $this->_data;
    }
}
function shut()
{
    $_OUT = "";
    $error = error_get_last();
    if ($error && $error["type"] & E_FATAL) {
        $message = "" . $error["type"] . ": " . $error["message"] . " in " . $error["file"] . " on line " . $error["line"] . " ";
        $_OUT->status = "error";
        if ($error["type"] & E_FATAL && ENV === "production") {
            $_OUT->message = "500 Internal Server Error";
        } else {
            $_OUT->message = $message;
            $_OUT->data = $error;
        }
        Out($_OUT);
    }
}
function Out($OUT)
{
    global $starttime;
    $OUT->details->version = VERSION;
    $OUT->details->requesttime = microtime(true) - $starttime;
    $OUT->details->referenceid = UUID();
    header("Status: " . $OUT->status);
    header("Access-Control-Allow-Methods: *");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=utf-8");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("X-Powered-By: " . APPNAME);
    header("X-App-Version: " . VERSION);
    header_remove("pragma");
    header_remove("server");
    header_remove("transfer-encoding");
    header("Status: 200", true, 200);
    exit(json_encode($OUT, JSON_UNESCAPED_UNICODE));
}
function UncaughtException($e)
{
    $_OUT = "";
    $_OUT->status = "error";
    $_OUT->message = $e->getMessage();
    if (ENV === "dev") {
        $_OUT->details->file = $e->getFile();
        $_OUT->details->line = $e->getline();
        $_OUT->details->code = $e->getCode();
    }
    out($_OUT);
}
function UUID()
{
    return sprintf("%04x%04x-%04x-%04x-%04x-%04x%04x%04x", mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 4095) | 16384, mt_rand(0, 16383) | 32768, mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}
function contains($string, $find)
{
    return stripos($string, $find) !== false;
}

?>