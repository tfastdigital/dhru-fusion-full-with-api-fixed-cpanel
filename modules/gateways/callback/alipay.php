<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\r\n";
define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
include "../../../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
include ROOTDIR . "/includes/gateway.fun.php";
include ROOTDIR . "/includes/invoice.fun.php";
$gatewaymodule = "alipay";
$GATEWAY = loadGatewayModule($gatewaymodule);
if (!$GATEWAY) {
    exit("Module Not Activated");
}
$_input_charset = "utf-8";
$sign_type = "MD5";
$transport = "https";
$gatewayPID = $GATEWAY["partnerID"];
$gatewaySELLER_EMAIL = $GATEWAY["seller_email"];
$gatewaySECURITY_CODE = $GATEWAY["security_code"];
$alipay = new alipay_notify($gatewayPID, $gatewaySECURITY_CODE, $sign_type, $_input_charset, $transport);
$verify_result = $alipay->notify_verify();
if (!$verify_result) {
    logTransaction($gatewaymodule, json_encode($_POST), "Unsuccessful");
    exit;
}
$status = $_POST["trade_status"];
$invoiceid = $_POST["out_trade_no"];
$transid = $_POST["trade_no"];
$amount = $_POST["total_fee"];
$fee = 0;
if (checkTransID($transid)) {
    exit;
}
if ($status == "TRADE_FINISHED" || $status == "TRADE_SUCCESS") {
    addPayment($invoiceid, $transid, $amount, $fee, $gatewaymodule);
    logTransaction($gatewaymodule, json_encode($_POST), "Successful");
}
class alipay_notify
{
    public $gateway = NULL;
    public $security_code = NULL;
    public $partner = NULL;
    public $sign_type = NULL;
    public $mysign = NULL;
    public $_input_charset = NULL;
    public $transport = NULL;
    public function alipay_notify($partner, $security_code, $sign_type = "MD5", $_input_charset = "GBK", $transport = "https")
    {
        $this->partner = $partner;
        $this->security_code = $security_code;
        $this->sign_type = $sign_type;
        $this->mysign = "";
        $this->_input_charset = $_input_charset;
        $this->transport = $transport;
        if ($this->transport == "https") {
            $this->gateway = "https://www.alipay.com/cooperate/gateway.do?";
        } else {
            $this->gateway = "http://notify.alipay.com/trade/notify_query.do?";
        }
    }
    public function notify_verify()
    {
        if ($this->transport == "https") {
            $veryfy_url = $this->gateway . "service=notify_verify" . "&partner=" . $this->partner . "&notify_id=" . $_POST["notify_id"];
        } else {
            $veryfy_url = $this->gateway . "partner=" . $this->partner . "&notify_id=" . $_POST["notify_id"];
        }
        $veryfy_result = $this->get_verify($veryfy_url);
        $post = $this->para_filter($_POST);
        $sortpost = $this->arg_sort($post);
        while (list($key, $val) = each($sort_post)) {
            $arg .= $key . "=" . $val . "&";
        }
        $prestr = substr($arg, 0, count($arg) - 2);
        $this->mysign = $this->sign($prestr . $this->security_code);
        if (deregi("true\$", $veryfy_result) && $this->mysign == $_POST["sign"]) {
            return true;
        }
        return false;
    }
    public function return_verify()
    {
        $sort_get = $this->arg_sort($_GET);
        while (list($key, $val) = each($sort_get)) {
            if ($key != "sign" && $key != "sign_type") {
                $arg .= $key . "=" . $val . "&";
            }
        }
        $prestr = substr($arg, 0, count($arg) - 2);
        $this->mysign = $this->sign($prestr . $this->security_code);
        if ($this->mysign == $_GET["sign"]) {
            return true;
        }
        return false;
    }
    public function get_verify($url, $time_out = "60")
    {
        $urlarr = parse_url($url);
        $errno = "";
        $errstr = "";
        $transports = "";
        if ($urlarr["scheme"] == "https") {
            $transports = "ssl://";
            $urlarr["port"] = "443";
        } else {
            $transports = "tcp://";
            $urlarr["port"] = "80";
        }
        $fp = @fsockopen($transports . $urlarr["host"], $urlarr["port"], $errno, $errstr, $time_out);
        if (!$fp) {
            exit("ERROR: " . $errno . " - " . $errstr . "<br />\n");
        }
        fputs($fp, "POST " . $urlarr["path"] . " HTTP/1.1\r\n");
        fputs($fp, "Host: " . $urlarr["host"] . "\r\n");
        fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
        fputs($fp, "Content-length: " . strlen($urlarr["query"]) . "\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        fputs($fp, $urlarr["query"] . "\r\n\r\n");
        while (!feof($fp)) {
            $info[] = @fgets($fp, 1024);
        }
        fclose($fp);
        $info = implode(",", $info);
        while (list($key, $val) = each($_POST)) {
            $arg .= $key . "=" . $val . "&";
        }
        return $info;
    }
    public function arg_sort($array)
    {
        ksort($array);
        reset($array);
        return $array;
    }
    public function sign($prestr)
    {
        $sign = "";
        if ($this->sign_type == "MD5") {
            $sign = md5($prestr);
            return $sign;
        }
        if ($this->sign_type == "DSA") {
            exit("DSA 签名方法待后续开发，请先使用MD5签名方式");
        }
        exit("支付宝暂不支持" . $this->sign_type . "类型的签名方式");
    }
    public function para_filter($parameter)
    {
        $para = [];
        while (list($key, $val) = each($parameter)) {
            if (!($key == "sign" || $key == "sign_type" || $val == "")) {
                $para[$key] = $parameter[$key];
            }
        }
        return $para;
    }
    public function charset_encode($input, $_output_charset, $_input_charset = "utf-8")
    {
        $output = "";
        if (!isset($_output_charset)) {
            $_output_charset = $this->parameter["_input_charset"];
        }
        if ($_input_charset == $_output_charset || $input == NULL) {
            $output = $input;
        } else {
            if (function_exists("mb_convert_encoding")) {
                $output = mb_convert_encoding($input, $_output_charset, $_input_charset);
            } else {
                if (function_exists("iconv")) {
                    $output = iconv($_input_charset, $_output_charset, $input);
                } else {
                    exit("sorry, you have no libs support for charset change.");
                }
            }
        }
        return $output;
    }
    public function charset_decode($input, $_input_charset, $_output_charset = "utf-8")
    {
        $output = "";
        if (!isset($_input_charset)) {
            $_input_charset = $this->_input_charset;
        }
        if ($_input_charset == $_output_charset || $input == NULL) {
            $output = $input;
        } else {
            if (function_exists("mb_convert_encoding")) {
                $output = mb_convert_encoding($input, $_output_charset, $_input_charset);
            } else {
                if (function_exists("iconv")) {
                    $output = iconv($_input_charset, $_output_charset, $input);
                } else {
                    exit("sorry, you have no libs support for charset changes.");
                }
            }
        }
        return $output;
    }
}

?>