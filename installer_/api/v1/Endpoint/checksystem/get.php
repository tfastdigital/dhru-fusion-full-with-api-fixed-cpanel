<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Dhru\Endpoint\checksystem;

class get extends Checksystem
{
    public function __construct($Base)
    {
        parent::__construct($Base);
        $RETURN["PHP Version"]["info"] = phpversion();
        $RETURN["PHP Version"]["status"] = 0 <= phpversion() ? true : false;
        unset($_status);
        unset($_info);
        if ($_ioncube_version = (int) str_replace(".", "", $this->GetIonCubeLoaderVersion())) {
            if ($_ioncube_version < 100) {
                $_info = "ioncube version 10.2 or grater required : installed version " . $this->GetIonCubeLoaderVersion();
                $_status = false;
            } else {
                $_info = $this->GetIonCubeLoaderVersion();
                $_status = true;
            }
        } else {
            $_info = "Not installed";
            $_status = true;
        }
        $RETURN["Ioncube Loader"]["info"] = $_info;
        $RETURN["Ioncube Loader"]["status"] = $_status;
        $RETURN["Ioncube Loader"]["link"] = "https://ioncube.com/";
        $_MODULES_REQ = ["curl", "mbstring", "date", "libxml", "openssl", "pcre", "zlib", "filter", "hash", "session", "ctype", "dom", "gd", "iconv", "json", "PDO", "SimpleXML", "xml", "xmlwriter", "zip", "mysqli", "pdo_mysql"];
        $_php_modules = get_loaded_extensions();
        foreach ($_MODULES_REQ as $module) {
            unset($_status);
            unset($_info);
            if (in_array($module, $_php_modules)) {
                $_info = phpversion($module);
                $_status = true;
            } else {
                $_info = "Not installed";
                $_status = false;
            }
            $RETURN["PHP Module " . $module]["info"] = $_info;
            $RETURN["PHP Module " . $module]["status"] = $_status;
        }
        $RETURN["PHP memory_limit"]["info"] = ini_get("memory_limit") != "256M" ? ini_get("memory_limit") . " <b>[Suggested 256M]</b>" : ini_get("memory_limit");
        $RETURN["PHP memory_limit"]["status"] = true;
        $RETURN["PHP max_execution_time"]["info"] = ini_get("max_execution_time") != "300" ? ini_get("max_execution_time") . " <b>[Suggested 300]</b>" : ini_get("max_execution_time");
        $RETURN["PHP max_execution_time"]["status"] = true;
        unset($_status);
        unset($_info);
        $_lic_server = file_get_contents("https://cp.dhru.com/submit/verifylicense");
        if (!strpos("Invalid", $_lic_server)) {
            $_info = "Ok";
            $_status = true;
        } else {
            $_info = "Unable to connect license server";
            $_status = false;
        }
        $RETURN["License server"]["info"] = $_info;
        $RETURN["License server"]["status"] = $_status;
        $_DIR_WRITE_PERMATIONS = ["templates_c", "configs", "admin/tmp", "download"];
        if (is_file(ROOTDIR . "/../../../configs/config.php")) {
            $_DIR_WRITE_PERMATIONS = ["templates_c", "configs", "download"];
        }
        foreach ($_DIR_WRITE_PERMATIONS as $dirpath) {
            unset($_status);
            unset($_info);
            if (is_writable(ROOTDIR . "/../../../" . $dirpath)) {
                $_info = "Ok";
                $_status = true;
            } else {
                $_info = "Directory has write permissions (777 Or 755)";
                $_status = false;
            }
            $RETURN["Writable permission " . $dirpath]["info"] = $_info;
            $RETURN["Writable permission " . $dirpath]["status"] = $_status;
        }
        throw new \SuccessOut("System Details", $RETURN);
    }
    public function GetIonCubeLoaderVersion()
    {
        if (function_exists("ioncube_loader_version")) {
            $version = ioncube_loader_version();
            $a = explode(".", $version);
            $count = count($a);
            if ($count == 3) {
                return $version;
            }
            if ($count == 2) {
                return $version . ".0";
            }
            if ($count == 1) {
                return $version . ".0.0";
            }
            $version = implode(".", array_slice($a, 0, 3));
            return $version;
        }
        return false;
    }
}

?>