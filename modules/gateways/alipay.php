<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class alipay_service
{
    public $gateway = "https://www.alipay.com/cooperate/gateway.do?";
    public $parameter = NULL;
    public $security_code = NULL;
    public $mysign = NULL;
    public function alipay_service($parameter, $security_code, $sign_type = "MD5", $transport = "https")
    {
        $this->parameter = $this->para_filter($parameter);
        $this->security_code = $security_code;
        $this->sign_type = $sign_type;
        $this->mysign = "";
        $this->transport = $transport;
        if ($parameter["_input_charset"] == "") {
            $this->parameter["_input_charset"] = "GBK";
        }
        if ($this->transport == "https") {
            $this->gateway = "https://www.alipay.com/cooperate/gateway.do?";
        } else {
            $this->gateway = "http://www.alipay.com/cooperate/gateway.do?";
        }
        $sort_array = [];
        $arg = "";
        $sort_array = $this->arg_sort($this->parameter);
        while (list($key, $val) = each($sort_array)) {
            $arg .= $key . "=" . $this->charset_encode($val, $this->parameter["_input_charset"]) . "&";
        }
        $prestr = substr($arg, 0, count($arg) - 2);
        $this->mysign = $this->sign($prestr . $this->security_code);
    }
    public function create_url()
    {
        $url = $this->gateway;
        $sort_array = [];
        $arg = "";
        $sort_array = $this->arg_sort($this->parameter);
        while (list($key, $val) = each($sort_array)) {
            $arg .= $key . "=" . urlencode($this->charset_encode($val, $this->parameter["_input_charset"])) . "&";
        }
        $url .= $arg . "sign=" . $this->mysign . "&sign_type=" . $this->sign_type;
        return $url;
    }
    public function arg_sort($array)
    {
        ksort($array);
        reset($array);
        return $array;
    }
    public function sign($prestr)
    {
        $mysign = "";
        if ($this->sign_type == "MD5") {
            $mysign = md5($prestr);
            return $mysign;
        }
        if ($this->sign_type == "DSA") {
            exit("DSA signature method to be subsequent development, please use the MD5 signature way");
        }
        exit("Paypal does not support" . $this->sign_type . "Type of signature way");
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
}
function alipay_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "Alipay 支付宝接口"], "seller_email" => ["Name" => "Alipay businesses", "Type" => "text", "Size" => "32", "Description" => "需要申请支付宝商家集成"], "partnerID" => ["Name" => "Partner ID", "Type" => "text", "Size" => "16", "Description" => "合作伙伴ID"], "security_code" => ["Name" => "Security check code", "Type" => "text", "Size" => "32", "Description" => "安全检验码"]];
    return $configarray;
}
function alipay_link($params)
{
    $_input_charset = "utf-8";
    $sign_type = "MD5";
    $transport = "https";
    $gatewayPID = $params["partnerID"];
    $gatewaySELLER_EMAIL = $params["seller_email"];
    $gatewaySECURITY_CODE = $params["security_code"];
    $TEST_MODE = $params["testmode"];
    $invoiceid = $params["invoiceid"];
    $description = $params["description"];
    $amount = $params["amount"];
    $currency = $params["currency"];
    $companyname = $params["companyname"];
    $systemurl = $params["systemurl"];
    $currency = $params["currency"];
    $notify_url = $systemurl . "/modules/gateways/callback/alipay.php";
    $return_url = $systemurl;
    $parameter = ["service" => "create_direct_pay_by_user", "partner" => $gatewayPID, "return_url" => $params["returnurl"], "notify_url" => $systemurl . "/modules/gateways/callback/alipay.php", "_input_charset" => $_input_charset, "subject" => $companyname . " 订单", "body" => $description, "out_trade_no" => $invoiceid, "total_fee" => $amount, "payment_type" => "1", "show_url" => $systemurl, "seller_email" => $gatewaySELLER_EMAIL];
    $alipay = new alipay_service($parameter, $gatewaySECURITY_CODE, $sign_type);
    $link = $alipay->create_url();
    $img = $systemurl . "/modules/gateways/callback/alipay.gif";
    $code = "<a href='" . $link . "' target=_blank ><img src='" . $img . "' alt='Click to use Alipay'></a>";
    return $code;
}

?>