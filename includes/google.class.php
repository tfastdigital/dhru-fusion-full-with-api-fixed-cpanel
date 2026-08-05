<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
class GoogleOpenID
{
    private $mode = NULL;
    private $response_nonce = NULL;
    private $return_to = NULL;
    private $realm = NULL;
    private $assoc_handle = NULL;
    private $claimed_id = NULL;
    private $identity = NULL;
    private $signed = NULL;
    private $sig = NULL;
    private $email = NULL;
    private $require_email = NULL;
    const google_discover_url = "https://www.google.com/accounts/o8/id";
    const openid_ns = "http://specs.openid.net/auth/2.0";
    const openid_ns_ext1 = "http://openid.net/srv/ax/1.0";
    const openid_ext1_mode = "fetch_request";
    const openid_ext1_type_email = "http://schema.openid.net/contact/email";
    const openid_ext1_required = "email";
    const openid_ext1_type_namePerson = "http://schema.openid.net/namePerson";
    const openid_ext2_required = "namePerson";
    private function GoogleOpenID($mode, $op_endpoint, $response_nonce, $return_to, $realm, $assoc_handle, $claimed_id, $signed, $sig, $email, $require_email)
    {
        if (is_null($assoc_handle)) {
            $assoc_handle = GoogleOpenID::getAssociationHandle();
        }
        if (!stripos($return_to, "http://") && !stripos($return_to, "https://")) {
            if (substr($return_to, 0, 1) == "/") {
                $return_to = substr($return_to, 1);
            }
            $server_name_pos = stripos($return_to, $_SERVER["SERVER_NAME"]);
            if ($server_name_pos && $server_name_pos == 0) {
                $return_to = "http://" . $return_to;
            } else {
                $return_to = "http://" . $_SERVER["SERVER_NAME"] . "/" . $return_to;
            }
        }
        if (is_null($realm) && !is_null($return_to)) {
            $pieces = parse_url($return_to);
            $realm = $pieces["scheme"] . "://" . $pieces["host"];
        }
        $this->mode = $mode;
        $this->op_endpoint = $op_endpoint;
        $this->response_nonce = $response_nonce;
        $this->return_to = $return_to;
        $this->realm = $realm;
        $this->assoc_handle = $assoc_handle;
        $this->claimed_id = $claimed_id;
        $this->identity = $claimed_id;
        $this->signed = $signed;
        $this->sig = $sig;
        $this->email = $email;
        $this->require_email = $require_email ? true : false;
    }
    public static function createRequest($return_to, $assoc_handle = NULL, $require_email = false)
    {
        return new GoogleOpenID("checkid_setup", NULL, NULL, $return_to, NULL, $assoc_handle, "http://specs.openid.net/auth/2.0/identifier_select", NULL, NULL, NULL, $require_email);
    }
    public static function create($params)
    {
        foreach ($params as $param => $value) {
            switch ($param) {
                case "openid_mode":
                    if ($value == "checkid_setup" || $value == "id_res" || $value == "cancel") {
                        $mode = $value;
                    } else {
                        $mode = "cancel";
                    }
                    break;
                case "openid_op_endpoint":
                    $op_endpoint = $value;
                    break;
                case "openid_response_nonce":
                    $response_nonce = $value;
                    break;
                case "openid_return_to":
                    $return_to = $value;
                    break;
                case "openid_realm":
                    $realm = $value;
                    break;
                case "openid_assoc_handle":
                    $assoc_handle = $value;
                    break;
                case "openid_claimed_id":
                    $claimed_id = $value;
                    break;
                case "openid_identity":
                    $claimed_id = $value;
                    break;
                case "openid_signed":
                    $signed = $value;
                    break;
                case "openid_sig":
                    $sig = $value;
                    break;
                case "openid_ext1_value_email":
                    $email = $value;
                    break;
                case "require_email":
                    $require_email = $value;
                    break;
            }
        }
        if (!is_bool($require_email)) {
            $require_email = false;
        }
        if (is_null($mode)) {
            $mode = "checkid_setup";
        }
        if (is_null($return_to) && $mode == "checkid_setup") {
            throw new Exception("GoogleOpenID.create() needs parameter openid.return_to");
        }
        return new GoogleOpenID($mode, $op_endpoint, $response_nonce, $return_to, $realm, $assoc_handle, $claimed_id, $signed, $sig, $email, $require_email);
    }
    public static function getResponse()
    {
        return GoogleOpenID::create($_GET);
    }
    public static function getAssociationHandle($endpoint = NULL)
    {
        if (is_null($endpoint)) {
            $request_url = GoogleOpenID::getEndPoint();
        } else {
            $request_url = $endpoint;
        }
        $request_url .= "?openid.ns=" . urlencode("http://specs.openid.net/auth/2.0");
        $request_url .= "&openid.mode=associate";
        $request_url .= "&openid.assoc_type=HMAC-SHA1";
        $request_url .= "&openid.session_type=no-encryption";
        $c = curl_init($request_url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_HEADER, false);
        $request_contents = curl_exec($c);
        curl_close($c);
        $assoc_handle = NULL;
        $lines = explode("\n", $request_contents);
        foreach ($lines as $line) {
            if (substr($line, 0, 13) == "assoc_handle:") {
                $assoc_handle = substr($line, 13);
                return $assoc_handle;
            }
        }
    }
    public static function getEndPoint()
    {
        $request_url = "https://www.google.com/accounts/o8/id";
        $c = curl_init($request_url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_HEADER, false);
        $request_contents = curl_exec($c);
        curl_close($c);
        $domdoc = new DOMDocument();
        $domdoc->loadXML($request_contents);
        $uri = $domdoc->getElementsByTagName("URI");
        $uri = $uri->item(0)->nodeValue;
        return $uri;
    }
    public function getArray()
    {
        $ret = [];
        $ret["openid.ns"] = "http://specs.openid.net/auth/2.0";
        if ($this->mode == "cancel") {
            $ret["openid.mode"] = "cancel";
            return $ret;
        }
        if (!is_null($this->claimed_id)) {
            $ret["openid.claimed_id"] = $this->claimed_id;
            $ret["openid.identity"] = $this->claimed_id;
        }
        if (!is_null($this->return_to)) {
            $ret["openid.return_to"] = $this->return_to;
        }
        if (!is_null($this->realm)) {
            $ret["openid.realm"] = $this->realm;
        }
        if (!is_null($this->assoc_handle)) {
            $ret["openid.assoc_handle"] = $this->assoc_handle;
        }
        if (!is_null($this->mode)) {
            $ret["openid.mode"] = $this->mode;
        }
        if ($this->mode == "checkid_setup" && $this->require_email || $this->mode == "id_res" && !is_null($this->email)) {
            $ret["openid.ns.ext1"] = "http://openid.net/srv/ax/1.0";
            $ret["openid.ext1.mode"] = "fetch_request";
            $ret["openid.ext1.type.email"] = "http://schema.openid.net/contact/email";
            $ret["openid.ext1.required"] = "email";
            if (!is_null($this->email)) {
                $ret["openid.ext1.value.email"] = $this->email;
            }
        }
        if ($this->mode == "id_res") {
            $ret["openid.op_endpoint"] = $this->op_endpoint;
            if (!is_null($this->response_nonce)) {
                $ret["openid.response_nonce"] = $this->response_nonce;
            }
            if (!is_null($this->signed)) {
                $ret["openid.signed"] = $this->signed;
            }
            if (!is_null($this->sig)) {
                $ret["openid.sig"] = $this->sig;
            }
        }
        return $ret;
    }
    public function endPoint()
    {
        if (!is_null($this->op_endpoint)) {
            return $this->op_endpoint;
        }
        $endpoint = GoogleOpenID::getEndPoint();
        $this->op_endpoint = $endpoint;
        return $endpoint;
    }
    private function getRequestURL()
    {
        $params = $this->getArray();
        $url = $this->endPoint();
        $first_attribute = true;
        foreach ($params as $param => $value) {
            if ($first_attribute) {
                $url .= "?";
                $first_attribute = false;
            } else {
                $url .= "&";
            }
            $url .= urlencode($param) . "=" . urlencode($value);
        }
        return $url;
    }
    public function redirect()
    {
        header("Location: " . $this->getRequestURL());
    }
    public function success()
    {
        return $this->mode == "id_res";
    }
    public function identity()
    {
        if ($this->mode != "id_res") {
            return NULL;
        }
        return $this->claimed_id;
    }
    public function email()
    {
        if ($this->mode != "id_res") {
            return NULL;
        }
        return $this->email;
    }
    public function assoc_handle()
    {
        return $this->assoc_handle();
    }
}

?>