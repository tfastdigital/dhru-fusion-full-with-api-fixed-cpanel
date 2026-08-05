<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class BFM
{
    private $bfm_user = NULL;
    private $bfm_key = NULL;
    const BFM_URL = "https://bruteforcemarket.com/api/";
    public function __construct($user, $key)
    {
        $this->bfm_user = $user;
        $this->bfm_key = $key;
    }
    private function connect($cmd, $params = [])
    {
        $params["cmd"] = $cmd;
        $params["bfm_user"] = $this->bfm_user;
        $params["bfm_key"] = $this->bfm_key;
        foreach ($params as $key => $value) {
            $up[] = $key . "=" . urlencode($value);
        }
        $r = file_get_contents("https://bruteforcemarket.com/api/?" . join("&", $up));
        if ($r === false) {
            return ["error" => 1, "error_no" => "E_000", "error_msg" => "Couldn't connect to API!"];
        }
        if (empty($r)) {
            return ["error" => 1, "error_no" => "E_001", "error_msg" => "No response from API server!"];
        }
        return json_decode($r, true);
    }
    public function uploadFile($file)
    {
        if (!file_exists($file)) {
            return ["error" => 1, "error_no" => "E_013", "error_msg" => "File does not exist!"];
        }
        if (!is_readable($file)) {
            return ["error" => 1, "error_no" => "E_014", "error_msg" => "File is not readable!"];
        }
        $pi = pathinfo($file);
        $content = base64_encode(file_get_contents($file));
        return $this->connect("uploadfile", ["filename" => $pi["basename"], "content" => $content]);
    }
    public function upload($imei, $hash)
    {
        return $this->connect("upload", ["imei" => $imei, "hash" => $hash]);
    }
    public function delete($imei)
    {
        return $this->connect("delete", ["imei" => $imei]);
    }
    public function getinfo()
    {
        return $this->connect("getinfo");
    }
    public function myqueue()
    {
        return $this->connect("myqueue");
    }
    public function job($imei)
    {
        return $this->connect("job", ["imei" => $imei]);
    }
}

?>