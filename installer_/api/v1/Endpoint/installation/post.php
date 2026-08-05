<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Dhru\Endpoint\installation;

class post extends Installation
{
    public function __construct($Base)
    {
        parent::__construct($Base);
        $_SERVER["SERVER_NAME"] = $_SERVER["SERVER_NAME"] == "_" ? "dhru.local" : $_SERVER["SERVER_NAME"];
        $ConfigName = "config.php";
        $AdminDirName = "admin";
        if (ENV == "dev") {
            $ConfigName = "config.dev.php";
            $AdminDirName = "admindev";
        }
        $InstallationType = "new";
        if (is_file(ROOTDIR . "/../../../configs/" . $ConfigName)) {
            $InstallationType = "update";
            include ROOTDIR . "/../../../configs/" . $ConfigName;
        }
        if ($InstallationType == "new") {
            $this->para = $Base->parameters;
            $this->para["admindirectory"] = strtolower($this->para["admindirectory"]);
            
           
            $CONFIG = file_get_contents(ROOTDIR . "/Endpoint/installation/config.tpl");
            $CONFIG = str_replace("<DB_HOST>","localhost", $CONFIG);
            $CONFIG = str_replace("<DB_USER>","appunbsx_test5", $CONFIG);
            $CONFIG = str_replace("<DB_PASSWORD>", "appunbsx_test5", $CONFIG);
            $CONFIG = str_replace("<DB_NAME>", "appunbsx_test5", $CONFIG);
            $CONFIG = str_replace("<ENC_KEY>", md5(rand(22, 8998)), $CONFIG);
            $CONFIG = str_replace("<ADMIN_DIR>","admincp", $CONFIG);
            $CONFIG = str_replace("<CC_ENC>", md5(rand(1, 99)), $CONFIG);
            file_put_contents(ROOTDIR . "/../../../configs/" . $ConfigName . ".tmp", "SPACE");
            if (!is_file(ROOTDIR . "/../../../configs/" . $ConfigName . ".tmp")) {
                throw new \ErrorOut("Failed to write Config");
            }
            $_host = "localhost";
            $_databsename = "appunbsx_test5";
            $_databseusername = "appunbsx_test5";
            $_databsepassword = "appunbsx_test5";
            try {
                $conn = new \PDO("mysql:host=" . $_host . ";dbname=" . $_databsename, $_databseusername, $_databsepassword);
            } catch (PDOException $e) {
                throw new \ErrorOut("Connection failed: " . $e->connect_error);
            }
            $structure = file_get_contents(ROOTDIR . "/../../install/sql/structure.sql");
            if (!$structure) {
                throw new \ErrorOut("Structure fetching failed");
            }
            $conn->query("SELECT @@sql_mode");
            $conn->query("SET sql_mode = ''");
            $conn->query("SELECT @@GLOBAL.sql_mode");
            $conn->query("SET @@global.sql_mode = ''");
            $conn->exec($structure);
            $this->installData($conn);
            $licensekey = $this->encLic($this->para["licensekey"]);
            $conn->query("UPDATE `tbl_license` SET `license_key`='" . $licensekey . "'");
            $usersip = isset($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_ADDR"] : $_SERVER["LOCAL_ADDR"];
            $_post["json"] = true;
            $_post["licensekey"] = $this->para["licensekey"];
            $_post["domain"] = $_SERVER["SERVER_NAME"];
            $_post["ip"] = $usersip;
            $EndpointDir = dirname(__FILE__);
            $EndpointDir = explode("/", $EndpointDir);
            array_splice($EndpointDir, count($EndpointDir) - 5, 5);
            $EndpointDir = implode("/", $EndpointDir) . "/" . $this->para["admindirectory"] . "/includes";
            $_post["dir"] = $EndpointDir;
            $req = \Dhru\Lib\Comm::initCurl("https://cp.dhru.com/submit/verifylicense", $_post);
            rename(ROOTDIR . "/../../../" . $AdminDirName, ROOTDIR . "/../../../" . $this->para["admindirectory"]);
            if (!is_dir(ROOTDIR . "/../../../" . $this->para["admindirectory"])) {
                throw new \ErrorOut("Unable to rename admin dir");
            }
            $firstname = "demo";
            $lastname = "demo";
            $email = "admin@admin.com";
            $username = "admin";
            $password = "admin";
            $password = md5(md5($password) . "9486");
            $conn->query("UPDATE tbl_admin \r\n        set firstname='" . $firstname . "',lastname='" . $lastname . "',email='" . $email . "',username='" . $username . "',password='" . $password . "'\r\n            WHERE id='1'");
            $siteurl = "https://demo.afterunlock.com";
            $conn->query("update tbl_config_default set value='" . $siteurl . "'\r\n                where attribute='site_address' and configtype='config'");
            file_put_contents(ROOTDIR . "/../../../configs/" . $ConfigName, $CONFIG);
            $configarr = [];
            $qc = $conn->query("select * from tbl_config_default");
            while ($r = $qc->fetch(\PDO::FETCH_ASSOC)) {
                $configarr[$r["configtype"]][$r["attribute"]] = $r["value"];
            }
            $configarr["config"]["version"] = VERSION;
            $configarr["config"]["release_candidate"] = RC;
            foreach ($configarr as $configtype => $configdata) {
                $configdata = serialize($configdata);
                $conn->query("INSERT INTO tbl_settings (`attribute`,value)                VALUES ('" . $configtype . "','" . $configdata . "')");
            }
            $RETURN["status"] = "success";
            $RETURN["msg"] = "Installation Successful";
            rename("../../../installer", "../../../installer_" . md5(rand(99, 99999)));
            rename("../../../installer_", "../../../installer_" . md5(rand(99, 99999)));
            throw new \SuccessOut("New Installed !!!", $RETURN);
        } else {
            $dbc = new \Dhru\Lib\DBCompare($config["server"], $config["database"], $config["user"], $config["pass"]);
            $json = file_get_contents(ROOTDIR . "/../../install/sql/schema.json");
            try {
                $conn = new \PDO("mysql:host=" . $config["server"] . ";dbname=" . $config["database"], $config["user"], $config["pass"]);
            } catch (PDOException $e) {
                throw new \ErrorOut("Connection failed: " . $e->connect_error);
            }
            $conn->query("SELECT @@sql_mode");
            $conn->query("SET sql_mode = ''");
            $conn->query("SELECT @@GLOBAL.sql_mode");
            $conn->query("SET @@global.sql_mode = ''");
            $conn->query("ALTER TABLE `tbl_order_file` DROP INDEX `reply`;");
            $conn->query("DELETE FROM tbl_apiserversservices where gateway='blackberry'");
            $conn->query("DELETE FROM tbl_apiservers where gateway='blackberry'");
            $conn->query("update tbl_emailtemplates set fromemail='',fromname=''");
            $conn->query("update tbl_emailtemplates_backup set fromemail='',fromname=''");
            $dbc->differ($json);
            $Diff = $dbc->diffquery;
            file_put_contents(ROOTDIR . "/../../../" . $admindirpath . "/tmp/INSTALLER_" . date("Y-m-d"), json_encode($Diff));
            $conn->query("delete from tbl_admin_access_group where id=1");
            $RETURN = $dbc->exec();
            foreach ($RETURN as $dt) {
                if (!$dt["status"]) {
                    throw new \ErrorOut("Update Failed. Please contact support team to resolved issue!!!", $RETURN);
                }
            }
            $time = date("Y_m_d") . rand(99, 999);
            $conn->query("INSERT INTO tbl_settings (attribute,value)\r\n                VALUES ('config_backup_" . $time . "',(select a.value from tbl_settings as a\r\n                where a.attribute='config'))");
            $set = $conn->query("select value from tbl_settings where attribute='config'");
            $setr = $set->fetch(\PDO::FETCH_ASSOC);
            $setting = unserialize($setr["value"]);
            $_current_ver = (int) $setting["version"];
            if ($_current_ver < 8) {
                $conn->query("TRUNCATE `tbl_navigation`");
                $conn->query("DELETE FROM `tbl_bannerslider_banners` WHERE `id` = 1");
            }
            $this->installData($conn);
            if (!isset($setr["value"])) {
                $configarr = [];
                $qc = $conn->query("select * from tbl_config_default");
                while ($r = $qc->fetch(\PDO::FETCH_ASSOC)) {
                    $configarr[$r["configtype"]][$r["attribute"]] = $r["value"];
                }
                foreach ($configarr as $configtype => $configdata) {
                    $configdata = serialize($configdata);
                    $conn->query("INSERT INTO tbl_settings (`attribute`,value)                VALUES ('" . $configtype . "','" . $configdata . "')");
                }
                $setting = $configarr["config"];
            }
            $setting["version"] = VERSION;
            $setting["release_candidate"] = RC;
            if ($_current_ver < 8) {
                $setting["template"] = "default";
                $setting["template_afterlogin"] = "default";
                $setting["themecolor"] = "theme1";
                $setting["bannershape"] = "svg";
                $setting["faster_browsing_mode"] = "1";
            }
            $setting = serialize($setting);
            $conn->query("UPDATE tbl_settings SET value='" . $setting . "'\r\n            WHERE attribute='config'");
            $set = $conn->query("select license_key from tbl_license where id=1");
            $licenses = $set->fetch(\PDO::FETCH_ASSOC);
            $usersip = isset($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_ADDR"] : $_SERVER["LOCAL_ADDR"];
            $_post["json"] = true;
            $_post["licensekey"] = $this->decLic($licenses["license_key"]);
            $_post["domain"] = $_SERVER["SERVER_NAME"];
            $_post["ip"] = $usersip;
            $EndpointDir = dirname(__FILE__);
            $EndpointDir = explode("/", $EndpointDir);
            array_splice($EndpointDir, count($EndpointDir) - 5, 5);
            $EndpointDir = implode("/", $EndpointDir) . "/" . $admindirpath . "/includes";
            $_post["dir"] = $EndpointDir;
            $req = \Dhru\Lib\Comm::initCurl("https://cp.dhru.com/submit/verifylicense", $_post);
            throw new \SuccessOut("Update Successful !!!", $RETURN);
        }
    }
    public function decLic($text, $key = "")
    {
        $key = "ASDF2K29SLS90ASDF2K29SLS90";
        $text = base64_decode($text);
        if ($key == "") {
            return $text;
        }
        $key = str_replace(" ", "", $key);
        if (strlen($key) < 8) {
            exit("key error");
        }
        $key_len = strlen($key);
        if (32 < $key_len) {
            $key_len = 32;
        }
        $key = substr($key, 0, $key_len);
        $text_len = strlen($text);
        $lomask = str_repeat("\37", $text_len);
        $himask = str_repeat("�", $text_len);
        $k = str_pad("", $text_len, $key);
        $text = ($text ^ $k) & $lomask | $text & $himask;
        return $text;
    }
    public function encLic($text, $key = "")
    {
        $key = "ASDF2K29SLS90ASDF2K29SLS90";
        if ($key == "") {
            return $text;
        }
        $key = str_replace(" ", "", $key);
        if (strlen($key) < 8) {
            exit("key error");
        }
        $key_len = strlen($key);
        if (32 < $key_len) {
            $key_len = 32;
        }
        $key = substr($key, 0, $key_len);
        $text_len = strlen($text);
        $lomask = str_repeat("\37", $text_len);
        $himask = str_repeat("�", $text_len);
        $k = str_pad("", $text_len, $key);
        $text = ($text ^ $k) & $lomask | $text & $himask;
        return base64_encode($text);
    }
    public static function installData($conn)
    {
        $dir = opendir(ROOTDIR . "/../../install/sql/data/");
        while (($sqlfiles = readdir($dir)) !== false) {
            if (is_file(ROOTDIR . "/../../install/sql/data/" . $sqlfiles)) {
                $cont = file_get_contents(ROOTDIR . "/../../install/sql/data/" . $sqlfiles);
                $conn->exec($cont);
            }
        }
    }
    public static function config()
    {
        $RETURN["name"] = "Check License";
        $BODY["licensekey"]["type"] = "string";
        $BODY["licensekey"]["isrequired"] = true;
        $BODY["licensekey"]["example"] = "XXXX-XXXX-XXXX-XXXX-XXXX";
        $BODY["host"]["type"] = "string";
        $BODY["host"]["isrequired"] = true;
        $BODY["host"]["example"] = "localhost";
        $BODY["databasename"]["type"] = "string";
        $BODY["databasename"]["isrequired"] = true;
        $BODY["databasename"]["example"] = "DBNAME";
        $BODY["databaseusername"]["type"] = "string";
        $BODY["databaseusername"]["isrequired"] = true;
        $BODY["databaseusername"]["example"] = "DB_USERNAME";
        $BODY["databasepassword"]["type"] = "string";
        $BODY["databasepassword"]["isrequired"] = true;
        $BODY["databasepassword"]["example"] = "DB_PASSWORD";
        $BODY["admindirectory"]["type"] = "string";
        $BODY["admindirectory"]["isrequired"] = true;
        $BODY["admindirectory"]["example"] = "MyAdmin13";
        $BODY["adminfirstname"]["type"] = "string";
        $BODY["adminfirstname"]["isrequired"] = true;
        $BODY["adminfirstname"]["example"] = "Jon";
        $BODY["adminlastname"]["type"] = "string";
        $BODY["adminlastname"]["isrequired"] = true;
        $BODY["adminlastname"]["example"] = "Dos";
        $BODY["adminemail"]["type"] = "string";
        $BODY["adminemail"]["isrequired"] = true;
        $BODY["adminemail"]["example"] = "admin@domain.com";
        $BODY["adminusername"]["type"] = "string";
        $BODY["adminusername"]["isrequired"] = true;
        $BODY["adminusername"]["example"] = "admin";
        $BODY["adminpassword"]["type"] = "string";
        $BODY["adminpassword"]["isrequired"] = true;
        $BODY["adminpassword"]["example"] = "admin";
        $BODY["websiteurl"]["type"] = "string";
        $BODY["websiteurl"]["isrequired"] = true;
        $BODY["websiteurl"]["example"] = "http://demo.com/";
        $RETURN["body"] = $BODY;
        return $RETURN;
    }
}

?>