<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("IOS_API_PHP_VERSION_REQUIRED", "5.1.0");
if (!function_exists("parse_ini_string")) {
    function parse_ini_string($str, $ProcessSections = false)
    {
        $lines = explode("\n", $str);
        $return = [];
        $inSect = false;
        foreach ($lines as $line) {
            $line = trim($line);
            if (!(!$line || $line[0] == "#" || $line[0] == ";")) {
                if ($line[0] == "[" && ($endIdx = strpos($line, "]"))) {
                    $inSect = substr($line, 1, $endIdx - 1);
                } else {
                    if (strpos($line, "=")) {
                        $tmp = explode("=", $line, 2);
                        if ($ProcessSections && $inSect) {
                            $return[$inSect][trim($tmp[0])] = ltrim($tmp[1]);
                        } else {
                            $return[trim($tmp[0])] = ltrim($tmp[1]);
                        }
                    }
                }
            }
        }
        return $return;
    }
}
class iosAPI
{
    public $Trace = false;
    public $Debug = 0;
    private $Version = 1;
    private $Protocol = 1;
    private $URL = NULL;
    private $user = NULL;
    private $pass = NULL;
    private $Cryptor = NULL;
    private $Request = [];
    private $Response = NULL;
    const LF = "\r\n";
    public function __construct($URL, $user, $pass, $Debug = 0)
    {
        if (!extension_loaded("curl")) {
            throw new Exception(sprintf("cURL extension required !"));
        }
        if (strlen($URL) == 0) {
            throw new Exception(sprintf("wrong URL `%s`", $URL));
        }
        if (strlen($user) == 0) {
            throw new Exception(sprintf("wrong Username `%s`", $user));
        }
        if (strlen($pass) == 0) {
            throw new Exception(sprintf("wrong Password `%s`", $pass));
        }
        $this->Debug = $Debug;
        $this->URL = $URL;
        $this->user = $user;
        $this->pass = $this->PreparePassword($pass);
        $this->Cryptor = new Cryptography($this->user, $this->pass);
    }
    public function VersionApi()
    {
        $Params["Operation"] = "VersionApi";
        return $this->SendRequest($Params);
    }
    public function ProductList($Params = [])
    {
        $Params["Operation"] = "ProductList";
        return $this->SendRequest($Params);
    }
    public function OrderAdd($Params)
    {
        $Params["CheckIsOrderExist"] = 0;
        $Params["Operation"] = "OrderAdd";
        return $this->SendRequest($Params);
    }
    public function OrderCheck($Params)
    {
        $Params["Operation"] = "OrderCheck";
        return $this->SendRequest($Params);
    }
    public function UserExist($User)
    {
        $Params["User"] = $User;
        $Params["Operation"] = "UserExist";
        return $this->SendRequest($Params);
    }
    public function Balance()
    {
        $Params["Operation"] = "Balance";
        return $this->SendRequest($Params);
    }
    public function CreditMoveTo($Receiver, $Quantity, $NoteForSender = "", $NoteForReceiver = "")
    {
        $Params["Operation"] = "CreditMoveTo";
        $Params["Receiver"] = $Receiver;
        $Params["Quantity"] = $Quantity;
        $Params["NoteForSender"] = $NoteForSender;
        $Params["NoteForReceiver"] = $NoteForReceiver;
        return $this->SendRequest($Params);
    }
    public function SL3JobAdd($Imei, $Hash)
    {
        $Params["Operation"] = "SL3JobAdd";
        $Params["IMEI"] = $Imei;
        $Params["Hash"] = $Hash;
        return $this->SendRequest($Params);
    }
    public function SL3JobCheck($Imei)
    {
        $Params["Operation"] = "SL3JobCheck";
        $Params["IMEI"] = $Imei;
        return $this->SendRequest($Params);
    }
    public function SendRequest($Param = [])
    {
        $this->Request = $Param;
        $this->Request["Debug"] = $this->Debug;
        $this->Request["Rnd"] = rand();
        $this->Request["Challenge"] = $this->Request["Rnd"];
        $this->Request["ApiVersion"] = $this->Version;
        $this->Request["Login"] = $this->user;
        $this->Request = $this->PreparePostData($this->Request);
        $Handler = curl_init();
        curl_setopt($Handler, CURLOPT_HEADER, false);
        curl_setopt($Handler, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        curl_setopt($Handler, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($Handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($Handler, CURLOPT_URL, $this->URL);
        curl_setopt($Handler, CURLOPT_POST, true);
        curl_setopt($Handler, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($Handler, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($Handler, CURLOPT_POST, true);
        curl_setopt($Handler, CURLOPT_POSTFIELDS, $this->Request);
        $this->Response = curl_exec($Handler);
        $Error = curl_error($Handler);
        curl_close($Handler);
        if ($this->Trace) {
            echo "<pre>Response: " . print_r($this->Response, true) . "</pre>";
        }
        if (0 < strlen($Error)) {
            $this->Response = ["Error" => 255, "Message" => $Error];
        } else {
            $this->Response = $this->DecryptResponse($this->Response);
        }
        return $this->Response;
    }
    private function DecryptResponse($Response)
    {
        $ResponseArray = explode("\r\n", $Response);
        if (count($ResponseArray) == 2) {
            $Response = strtoupper($ResponseArray[0]);
            $Response = pack("H*", $Response);
            $Response = $this->Cryptor->encryptDecrypt($Response, Cryptography::MODE_DECRYPT);
            $signature = $this->Cryptor->getSignature($Response);
            $signature = unpack("H*", $signature);
            $signature = $signature[1];
        }
        $Response = $this->TransportDecode($Response);
        return $Response;
    }
    private function PreparePassword($Password)
    {
        return strtoupper(sha1($Password));
    }
    private function PreparePostData($Params)
    {
        $RawRequest = $this->TransportEncode($Params);
        $RawRequest = $RawRequest . "\r\n";
        $RawRequest = Cryptography::padForEncryption($RawRequest);
        $EncryptedRequest = $this->Cryptor->encryptDecrypt($RawRequest, Cryptography::MODE_ENCRYPT);
        $EncryptedRequest = unpack("H*", $EncryptedRequest);
        $EncryptedRequest = $EncryptedRequest[1];
        $EncryptedRequest = strtoupper($EncryptedRequest);
        $signature = $this->Cryptor->getSignature($RawRequest);
        $signature = unpack("H*", $signature);
        $signature = $signature[1];
        $signature = strtoupper($signature);
        $Post["Protocol"] = $this->Protocol;
        $Post["ApiVersion"] = $this->Version;
        $Post["Login"] = $this->user;
        $Post["Request"] = $EncryptedRequest;
        $Post["Signature"] = $signature;
        if ($this->Trace) {
            echo "<pre>Request inner: " . print_r($Params, true) . "</pre>";
            echo "<pre>Request outer: " . print_r($Post, true) . "</pre>";
        }
        return $Post;
    }
    private function TransportDecode($Buffer)
    {
        switch ($this->Protocol) {
            case 1:
                $Result = $this->XMLToArray($Buffer);
                break;
            default:
                $Result = $this->INIToArray($Buffer);
                if (!$Result) {
                    $Result = $this->INIToArray($Buffer);
                }
                return $Result;
        }
    }
    private function TransportEncode($Buffer)
    {
        switch ($this->Protocol) {
            case 1:
                $Result = $this->ArrayToXML($Buffer);
                break;
            default:
                $Result = $this->ArrayToINI($Buffer);
                return $Result;
        }
    }
    private function ArrayToINI($Array)
    {
        $Result = "";
        foreach ($Array as $Key => $Value) {
            $Result .= $Key . "=" . $Value . "\r\n";
        }
        return trim($Result);
    }
    private function INIToArray($INI)
    {
        return parse_ini_string($INI);
    }
    private function ArrayToXML($Array)
    {
        $XML = ARRAYtoXML($Array, "xREQUEST");
        return $XML;
    }
    private function XMLToArray($XML)
    {
        $Array = XMLtoARRAY($XML);
        return isset($Array["xREQUEST"]) ? $Array["xREQUEST"] : [];
    }
}
class Cryptography
{
    private $_login = NULL;
    private $_password = NULL;
    const MODE_ENCRYPT = 1;
    const MODE_DECRYPT = 2;
    const KEY_SIZE = 24;
    const BLOCK_SIZE = 8;
    const IV_SIZE = 8;
    public function __construct($login, $password)
    {
        $this->_login = $login;
        $this->_password = $password;
    }
    public function getKey()
    {
        return substr($this->getSignature("Key" . $this->_password . $this->_login . "Key") . $this->getSignature($this->_password), 0, 24);
    }
    public function getIV()
    {
        return substr($this->getSignature("IV" . $this->_login . $this->_password . "IV") . $this->getSignature($this->_login), 0, 8);
    }
    public function assertLenIsMultiple($point, $name, $value, $expectedMultiple)
    {
        if (strlen($value) % $expectedMultiple !== 0) {
            throw new Exception(sprintf("[%s]: Parameter \"%s\" must be a multiple of %d, but \"%d\" found", $point, $name, $expectedMultiple, strlen($value)));
        }
    }
    public function encryptDecrypt($value, $mode)
    {
        $this->assertLenIsMultiple("encryptDecrypt", "value", $value, 8);
        $mcryptHandle = mcrypt_module_open(MCRYPT_3DES, "", MCRYPT_MODE_CBC, "");
        if ($mcryptHandle === false) {
            throw new Exception("mcrypt_module_open failed");
        }
        $key = $this->getKey();
        $iv = $this->getIV();
        $result = mcrypt_generic_init($mcryptHandle, $key, $iv);
        if ($result !== 0) {
            throw new Exception(sprintf("mcrypt_generic_init error %s !", $result));
        }
        switch ($mode) {
            case 1:
                return mcrypt_generic($mcryptHandle, $value);
                break;
            case 2:
                return mdecrypt_generic($mcryptHandle, $value);
                break;
            default:
                throw new Exception("Invalid encryption mode in encryptDecrypt !");
        }
    }
    public function getSignature($value)
    {
        return sha1($value, true);
    }
    public static function padForEncryption($data)
    {
        if (strlen($data) % 8 != 0) {
            $data .= str_repeat(" ", 8 - strlen($data) % 8);
        }
        return $data;
    }
}
function ARRAYtoXML($Array, $RootNodeName = NULL)
{
    $XML = XML_serialize($Array, 0, NULL);
    if (!is_null($RootNodeName)) {
        $XML = "<" . $RootNodeName . ">\r\n" . $XML . "</" . $RootNodeName . ">";
    }
    return $XML;
}
function XMLtoARRAY($XML)
{
    return XML_unserialize($XML);
}
function XML_serialize($data, $level = 0, $prior_key = NULL)
{
    if ($level == 0) {
        ob_start();
        while (list($key, $value) = each($data)) {
        }
        reset($data);
        if ($level == 0) {
            $str = ob_get_contents();
            ob_end_clean();
            return $str;
        }
    }
    if (!strpos($key, " attr")) {
        if (is_array($value) && array_key_exists(0, $value)) {
            XML_serialize($value, $level, $key);
        } else {
            $tag = $prior_key ? $prior_key : $key;
            echo str_repeat("\t", $level);
            echo "<";
            echo $tag;
            if (array_key_exists($key . " attr", $data)) {
                while (list($attr_name, $attr_value) = each($data[$key . " attr"])) {
                    echo " ";
                    echo $attr_name;
                    echo "=\"";
                    echo htmlspecialchars($attr_value);
                    echo "\"";
                }
                reset($data[$key . " attr"]);
            }
            if (is_null($value)) {
                echo " />\n";
            } else {
                if (!is_array($value)) {
                    echo ">";
                    echo htmlspecialchars($value);
                    echo "</" . $tag . ">\n";
                } else {
                    echo ">\n";
                    echo XML_serialize($value, $level + 1);
                    echo str_repeat("\t", $level);
                    echo "</" . $tag . ">\n";
                }
            }
        }
    }
}
function XML_unserialize($XML)
{
    $xml_parser = xml_parser_create();
    xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, false);
    xml_parse_into_struct($xml_parser, $XML, $vals, $index);
    xml_parser_free($xml_parser);
    $params = [];
    $level = [];
    $alreadyused = [];
    $x = 0;
    foreach ($vals as $xml_elem) {
        if ($xml_elem["type"] == "open") {
            if (in_array($xml_elem["tag"], $alreadyused)) {
                $x++;
                $xml_elem["tag"] = $xml_elem["tag"] . $x;
            }
            $level[$xml_elem["level"]] = $xml_elem["tag"];
            $alreadyused[] = $xml_elem["tag"];
        }
        if ($xml_elem["type"] == "complete") {
            $start_level = 1;
            for ($php_stmt = "\$params"; $start_level < $xml_elem["level"]; $start_level++) {
                $php_stmt .= "[\$level[" . $start_level . "]]";
            }
            if (!isset($xml_elem["value"])) {
                $xml_elem["value"] = "";
            }
            $php_stmt .= "[\$xml_elem['tag']] = \$xml_elem['value'];";
            eval($php_stmt);
        }
    }
    return $params;
}

?>