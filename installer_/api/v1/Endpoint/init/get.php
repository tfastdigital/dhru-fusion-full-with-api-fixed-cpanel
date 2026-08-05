<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Dhru\Endpoint\init;

class get extends Init
{
    public function __construct($Base)
    {
        parent::__construct($Base);
        $RETURN["applicationversion"] = VERSION;
        $RETURN["applicationrc"] = RC;
        $RETURN["installedversion"] = "6.1";
        $RETURN["installedrc"] = "RC7.0";
        $RETURN["productname"] = APPNAME;
        $ConfigName = "config.php";
        if (ENV == "dev") {
            $ConfigName = "config.dev.php";
        }
        if (is_file(ROOTDIR . "/../../../configs/" . $ConfigName)) {
            $config = [];
            $RETURN["installationtype"] = "update";
            include ROOTDIR . "/../../../configs/config.php";
            try {
                $conn = new \PDO("mysql:host=" . $config["server"] . ";dbname=" . $config["database"], $config[user], $config[pass]);
            } catch (PDOException $e) {
                throw new \Exception($e);
            }
            $q = $conn->query("select value from tbl_settings where attribute='config'");
            $configrow = $q->fetch(\PDO::FETCH_ASSOC);
            $config = unserialize($configrow["value"]);
            $RETURN["installedversion"] = $config["version"];
            $RETURN["installedrc"] = $config["release_candidate"];
        } else {
            $RETURN["installationtype"] = "new";
        }
        throw new \SuccessOut("Init Data", $RETURN);
    }
    public static function config()
    {
        $RETURN["name"] = "System Init";
        return $RETURN;
    }
}

?>