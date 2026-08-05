<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 *Creates, encrypts, sends and receives messages to and from DC-unlocker API server 
 */
class Message
{
    /**
     *Stores \action object variable's values
     * @var array
     */
    private $message_vars = NULL;
    /**
     *Stores response message from DC-unlocker API server
     * @var JSON format 
     */
    private $response = NULL;
    /**
     *Message holds commands for DC-Unlocker API server
     * @var string 
     */
    private $message = NULL;
    private function createmsg()
    {
        $this->message = json_encode($this->message_vars);
    }
    private function encryptmsg()
    {
        $plaintext = $this->message;
        $pkey = defined("DCU_API_PUBLIC_KEY") ? DCU_API_PUBLIC_KEY : dirname(__FILE__) . "/public.key";
        if (!file_exists($pkey)) {
            exit("PUBLIC KEY FILE NOT FOUND");
        }
        $publicKey = openssl_pkey_get_public("file://" . $pkey);
        $encrypted = "";
        if (!openssl_public_encrypt($plaintext, $encrypted, $publicKey)) {
            exit("Failed to encrypt data");
        }
        openssl_free_key($publicKey);
        $encrypted = urlencode($encrypted);
        $encrypted = base64_encode($encrypted);
        $this->message = "message=" . $encrypted;
    }
    private function sendmsg()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.dc-unlocker.com/dcu_api/202.php");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->message);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public function get_response()
    {
        $out = json_decode($this->response, true);
        if ($out == NULL) {
            return "false:" . $this->response;
        }
        return $out;
    }
    public function buildrequest($action, $username, $password, $version)
    {
        $this->message_vars = $action->getMsgVars();
        $this->message_vars["username"] = $username;
        $this->message_vars["pass"] = $password;
        $this->message_vars["ip"] = isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : "";
        $this->message_vars["api"] = $version;
    }
    public function send()
    {
        if (!empty($this->message_vars)) {
            $this->createmsg();
            $this->encryptmsg();
            $this->response = $this->sendmsg();
            return $this;
        }
        return $this;
    }
}

?>