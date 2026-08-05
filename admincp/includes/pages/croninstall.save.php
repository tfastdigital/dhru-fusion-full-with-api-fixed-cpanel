<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
$_cpanel_password = $hostingpass;
$_cpanel_username = $hostingunm;
$cPanel = new Dhru_Cpanel($_cpanel_username, $_cpanel_password, $admindirpath);
$crons = $cPanel->removeAllCrons();
if (!$crons["error"]) {
    $timeingeverymin = ["weekday" => "*", "minute" => "*", "hour" => "*", "day" => "*", "month" => "*"];
    $timeingeveryhour = ["weekday" => "*", "minute" => "0", "hour" => "*", "day" => "*", "month" => "*"];
    $timeingevery5min = ["weekday" => "*", "minute" => "*/5", "hour" => "*", "day" => "*", "month" => "*"];
    if ($cronsetupimei) {
        $i = 0;
        $query = dquery("SELECT * FROM `tbl_apiservers` WHERE `setting`='name'");
        while ($row = mysqli_fetch_assoc($query)) {
            $row["value"] = str_replace(" ", "_", trim($row["value"]));
            $row["value"] = preg_replace("/[^a-zA-Z0-9_']/", "", trim($row["value"]));
            $queryxx = dquery("SELECT value FROM `tbl_apiservers` WHERE `gateway`='" . $row["gateway"] . "' AND `setting`='servicetype'");
            $queryxx = mysqli_fetch_assoc($queryxx);
            $configpass = $config["cron_password"] != "" ? "?a=" . $config["cron_password"] . "&action=" . $row["gateway"] : "?action=" . $row["gateway"];
            $url1 = "/usr/bin/wget -O - -q -t 1 ";
            if ($config["seperatecron"]) {
                $url2 = $config["site_address"] . "includes/cron.php" . $configpass . "_send&auto";
                $addcron[$i] = $timeingeverymin;
                $addcron[$i]["command"] = $url1 . $url2;
                $i++;
                $url2 = $config["site_address"] . "includes/cron.php" . $configpass . "_get&auto";
                $addcron[$i] = $timeingeverymin;
                $addcron[$i]["command"] = $url1 . $url2;
                $i++;
            } else {
                $url2 = $config["site_address"] . "includes/cron.php" . $configpass . "&auto";
                $addcron[$i] = $timeingeverymin;
                $addcron[$i]["command"] = $url1 . $url2;
                $i++;
            }
        }
    }
    if ($cronsetupfile) {
        $query = dquery("SELECT * FROM `tbl_apiservers` WHERE `setting`='name'");
        $AutomationCron = "";
        while ($Data = mysqli_fetch_assoc($query)) {
            $Data["value"] = str_replace(" ", "_", trim($Data["value"]));
            $Data["value"] = preg_replace("/[^a-zA-Z0-9_']/", "", trim($Data["value"]));
            $queryxx = dquery("SELECT value FROM `tbl_apiservers` WHERE `gateway`='" . $Data["gateway"] . "' AND `setting`='servicetype'");
            $queryxx = mysqli_fetch_assoc($queryxx);
            $configpass = $config["cron_password"] != "" ? "?a=" . $config["cron_password"] . "&action=" . $Data["gateway"] : "?action=" . $Data["gateway"];
            $url1 = "/usr/bin/wget -O - -q -t 1 ";
            if ($queryxx["value"] == "file") {
                if ($config["seperatecron"]) {
                    $url2 = $config["site_address"] . "includes/cron.php" . $configpass . "_send&service=file&auto";
                    $addcron[$i] = $timeingevery5min;
                    $addcron[$i]["command"] = $url1 . $url2;
                    $i++;
                    $url2 = $config["site_address"] . "includes/cron.php" . $configpass . "_get&service=file&auto";
                    $addcron[$i] = $timeingevery5min;
                    $addcron[$i]["command"] = $url1 . $url2;
                    $i++;
                } else {
                    $url2 = $config["site_address"] . "includes/cron.php" . $configpass . "&service=file&auto";
                    $addcron[$i] = $timeingevery5min;
                    $addcron[$i]["command"] = $url1 . $url2;
                    $i++;
                }
            }
        }
    }
    if ($cronsetupauto) {
        $query = dquery("SELECT * FROM `tbl_apiservers` WHERE `setting`='name'");
        for ($AutomationCron = ""; $Data = mysqli_fetch_assoc($query); $i++) {
            $Data["value"] = str_replace(" ", "_", trim($Data["value"]));
            $Data["value"] = preg_replace("/[^a-zA-Z0-9_']/", "", trim($Data["value"]));
            $queryxx = dquery("SELECT value FROM `tbl_apiservers` WHERE `gateway`='" . $Data["gateway"] . "' AND `setting`='servicetype'");
            $queryxx = mysqli_fetch_assoc($queryxx);
            $configpass = $config["cron_password"] != "" ? "?a=" . $config["cron_password"] . "&action=" . $Data["gateway"] : "?action=" . $Data["gateway"];
            $url1 = "/usr/bin/wget -O - -q -t 1 ";
            $url2 = $config["site_address"] . "includes/cron.php" . $configpass . "_updateprice&auto";
            $u1 = strip_tags($url1);
            $u2 = strip_tags($url2);
            $addcron[$i] = $timeingeveryhour;
            $addcron[$i]["command"] = $url1 . $url2;
        }
    }
    $crons = $cPanel->addCrons($addcron);
    $crons = $cPanel->listCrons();
    echo "success: " . count($crons["data"]) . " crons installed successfully";
} else {
    echo "error: " . $crons["error"];
}
class Dhru_Cpanel
{
    private $username = NULL;
    private $token = NULL;
    private $password = NULL;
    private $curl = NULL;
    private $adminpath = NULL;
    public function __construct($username, $password, $admindirpath)
    {
        $this->curl = curl_init();
        $this->username = trim($username);
        $this->password = trim($password);
        $this->adminpath = $admindirpath;
    }
    public function listCrons()
    {
        $result = $this->callapi($this->buildUrl("Cron", "listcron"));
        if (is_array($result["data"])) {
            foreach ($result["data"] as $k => $v) {
                if (!isset($v["command"])) {
                    unset($result["data"][$k]);
                }
            }
        }
        return $result;
    }
    public function removeAllCrons()
    {
        $crons = array_reverse($this->listCrons()[data]);
        if ($crons["error"]) {
            return $crons;
        }
        foreach ($crons as $k => $v) {
            $para[line] = $v[count];
            $result = $this->callapi($this->buildUrl("Cron", "remove_line", $para));
        }
        return $result;
    }
    public function addCrons($crons = [])
    {
        foreach ($crons as $v) {
            $result = $this->callapi($this->buildUrl("Cron", "add_line", $v));
        }
        return $result;
    }
    public function buildUrl($module, $func, $para = [])
    {
        if (!$this->token) {
            $postfields["user"] = $this->username;
            $postfields["pass"] = $this->password;
            $login = $this->callapi("https://localhost:2083/login/?login_only=1", $postfields);
            if (!$login["status"]) {
                return false;
            }
            $this->token = trim($login["security_token"], "/");
        }
        $para = $para ? "&" . http_build_query($para) : "";
        return "https://localhost:2083/" . $this->token . "/json-api/cpanel?cpanel_jsonapi_user=user&cpanel_jsonapi_apiversion=2&cpanel_jsonapi_module=" . $module . "&cpanel_jsonapi_func=" . $func . $para;
    }
    public function callapi($url, $postfields = [])
    {
        try {
            if (!$url) {
                throw new Exception("Invalid Login");
            }
            $crl = $this->curl;
            if ($this->token) {
                $headr = [];
                $headr[] = "Authorization: cpanel " . $this->username . ":" . $this->password;
                curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
            }
            if ($postfields) {
                $postfields = http_build_query($postfields);
                curl_setopt($crl, CURLOPT_POST, 1);
                curl_setopt($crl, CURLOPT_POSTFIELDS, $postfields);
            }
            curl_setopt($crl, CURLOPT_URL, $url);
            curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($crl, CURLOPT_USERAGENT, "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8");
            curl_setopt($crl, CURLOPT_COOKIESESSION, true);
            curl_setopt($crl, CURLOPT_COOKIEJAR, ROOTDIR . "/" . $this->adminpath . "//tmp/TEMP_COOKIEJAR.txt");
            curl_setopt($crl, CURLOPT_COOKIEFILE, ROOTDIR . "/" . $this->adminpath . "//tmp/TEMP_COOKIEFILE.txt");
            $rest = curl_exec($crl);
            $rest = json_decode($rest, true);
            if (curl_errno($crl)) {
                throw new Exception(curl_error($crl));
            }
            if (!$rest["cpanelresult"]) {
                return $rest;
            }
            return $rest["cpanelresult"];
        } catch (Exception $e) {
            $cpanelresult["error"] = $e->getMessage();
            return $cpanelresult;
        }
    }
}

?>