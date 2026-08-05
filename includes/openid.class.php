<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
class LightOpenID
{
    public $returnUrl = NULL;
    public $required = [];
    public $optional = [];
    public $verify_peer = NULL;
    public $capath = NULL;
    public $cainfo = NULL;
    private $identity = NULL;
    private $claimed_id = NULL;
    protected $server = NULL;
    protected $version = NULL;
    protected $trustRoot = NULL;
    protected $aliases = NULL;
    protected $identifier_select = false;
    protected $ax = false;
    protected $sreg = false;
    protected $data = NULL;
    protected static $ax_to_sreg = ["namePerson/friendly" => "nickname", "contact/email" => "email", "namePerson" => "fullname", "birthDate" => "dob", "person/gender" => "gender", "contact/postalCode/home" => "postcode", "contact/country/home" => "country", "pref/language" => "language", "pref/timezone" => "timezone"];
    public function __construct()
    {
        $this->trustRoot = (!empty($_SERVER["HTTPS"]) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"];
        $uri = rtrim(preg_replace("#((?<=\\?)|&)openid\\.[^&]+#", "", $_SERVER["REQUEST_URI"]), "?");
        $this->returnUrl = $this->trustRoot . $uri;
        $this->data = $_POST + $_GET;
    }
    public function __set($name, $value)
    {
        switch ($name) {
            case "identity":
                if (strlen($value = trim((string) $value))) {
                    if (preg_match("#^xri:/*#i", $value, $m)) {
                        $value = substr($value, strlen($m[0]));
                    } else {
                        if (!preg_match("/^(?:[=@+\\\$!\\(]|https?:)/i", $value)) {
                            $value = "http://" . $value;
                        }
                    }
                    if (preg_match("#^https?://[^/]+\$#i", $value, $m)) {
                        $value .= "/";
                    }
                }
                $this->{$name} = $this->claimed_id = $value;
                break;
            case "trustRoot":
            case "realm":
                $this->trustRoot = trim($value);
                break;
        }
    }
    public function __get($name)
    {
        switch ($name) {
            case "identity":
                return $this->claimed_id;
                break;
            case "trustRoot":
            case "realm":
                return $this->trustRoot;
                break;
            case "mode":
                return empty($this->data["openid_mode"]) ? NULL : $this->data["openid_mode"];
                break;
        }
    }
    public function hostExists($url)
    {
        if (strpos($url, "/") === false) {
            $server = $url;
        } else {
            $server = parse_url($url, PHP_URL_HOST);
        }
        if (!$server) {
            return false;
        }
        return gethostbynamel($server);
    }
    protected function request_curl($url, $method = "GET", $params = [])
    {
        $params = http_build_query($params, "", "&");
        $curl = curl_init($url . ($method == "GET" && $params ? "?" . $params : ""));
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Accept: application/xrds+xml, */*"]);
        if ($this->verify_peer !== NULL) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $this->verify_peer);
            if ($this->capath) {
                curl_setopt($curl, CURLOPT_CAPATH, $this->capath);
            }
            if ($this->cainfo) {
                curl_setopt($curl, CURLOPT_CAINFO, $this->cainfo);
            }
        }
        if ($method == "POST") {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        } else {
            if ($method == "HEAD") {
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_NOBODY, true);
            } else {
                curl_setopt($curl, CURLOPT_HTTPGET, true);
            }
        }
        $response = curl_exec($curl);
        if ($method == "HEAD") {
            $headers = [];
            foreach (explode("\n", $response) as $header) {
                $pos = strpos($header, ":");
                $name = strtolower(trim(substr($header, 0, $pos)));
                $headers[$name] = trim(substr($header, $pos + 1));
            }
            $effective_url = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
            if ($effective_url != $url) {
                $this->identity = $this->claimed_id = $effective_url;
            }
            return $headers;
        } else {
            if (curl_errno($curl)) {
                throw new ErrorException(curl_error($curl), curl_errno($curl));
            }
            return $response;
        }
    }
    protected function request_streams($url, $method = "GET", $params = [])
    {
        while (!$this->hostExists($url)) {
            $params = http_build_query($params, "", "&");
            switch ($method) {
                case "GET":
                    $opts = ["http" => ["method" => "GET", "header" => "Accept: application/xrds+xml, */*", "ignore_errors" => true]];
                    $url = $url . ($params ? "?" . $params : "");
                    break;
                case "POST":
                    $opts = ["http" => ["method" => "POST", "header" => "Content-type: application/x-www-form-urlencoded", "content" => $params, "ignore_errors" => true]];
                    break;
                case "HEAD":
                    $default = stream_context_get_options(stream_context_get_default());
                    stream_context_get_default(["http" => ["method" => "HEAD", "header" => "Accept: application/xrds+xml, */*", "ignore_errors" => true]]);
                    $url = $url . ($params ? "?" . $params : "");
                    $headers_tmp = $this->get_headers_curl($url);
                    if (!$headers_tmp) {
                        return [];
                    }
                    $headers = [];
                    foreach ($headers_tmp as $header) {
                        $pos = strpos($header, ":");
                        $name = strtolower(trim(substr($header, 0, $pos)));
                        $headers[$name] = trim(substr($header, $pos + 1));
                        if ($name == "location") {
                            if (strpos($headers[$name], "http") === 0) {
                                $this->identity = $this->claimed_id = $headers[$name];
                            } else {
                                if ($headers[$name][0] == "/") {
                                    $parsed_url = parse_url($this->claimed_id);
                                    $this->identity = $this->claimed_id = $parsed_url["scheme"] . "://" . $parsed_url["host"] . $headers[$name];
                                }
                            }
                        }
                    }
                    stream_context_get_default($default);
                    return $headers;
                    break;
                default:
                    if ($this->verify_peer) {
                        $opts += ["ssl" => ["verify_peer" => true, "capath" => $this->capath, "cafile" => $this->cainfo]];
                    }
                    $context = stream_context_create($opts);
                    return $this->curl_get_file_contents($url, false, $context);
            }
        }
        throw new ErrorException("Invalid request.");
    }
    protected function request($url, $method = "GET", $params = [])
    {
        if (function_exists("curl_init") && !ini_get("safe_mode")) {
            return $this->request_curl($url, $method, $params);
        }
        return $this->request_streams($url, $method, $params);
    }
    protected function build_url($url, $parts)
    {
        if (isset($url["query"]) && isset($parts["query"])) {
            $parts["query"] = $url["query"] . "&" . $parts["query"];
        }
        $url = $parts + $url;
        $url = $url["scheme"] . "://" . (empty($url["username"]) ? "" : (empty($url["password"]) ? $url["username"] . "@" : $url["username"] . ":" . $url["password"] . "@")) . $url["host"] . (empty($url["port"]) ? "" : ":" . $url["port"]) . (empty($url["path"]) ? "" : $url["path"]) . (empty($url["query"]) ? "" : "?" . $url["query"]) . (empty($url["fragment"]) ? "" : "#" . $url["fragment"]);
        return $url;
    }
    protected function htmlTag($content, $tag, $attrName, $attrValue, $valueName)
    {
        preg_match_all("#<" . $tag . "[^>]*" . $attrName . "=['\"].*?" . $attrValue . ".*?['\"][^>]*" . $valueName . "=['\"](.+?)['\"][^>]*/?>#i", $content, $matches1);
        preg_match_all("#<" . $tag . "[^>]*" . $valueName . "=['\"](.+?)['\"][^>]*" . $attrName . "=['\"].*?" . $attrValue . ".*?['\"][^>]*/?>#i", $content, $matches2);
        $result = array_merge($matches1[1], $matches2[1]);
        return empty($result) ? false : $result[0];
    }
    public function discover($url)
    {
        if (!$url) {
            throw new ErrorException("No identity supplied.");
        }
        if (!preg_match("#^https?:#", $url)) {
            $url = "https://xri.net/" . $url;
        }
        $originalUrl = $url;
        $yadis = true;
        $i = 0;
        while ($i < 5) {
            if ($yadis) {
                $headers = $this->request($url, "HEAD");
                $next = false;
                if (isset($headers["x-xrds-location"])) {
                    $url = $this->build_url(parse_url($url), parse_url(trim($headers["x-xrds-location"])));
                    $next = true;
                }
                if (isset($headers["content-type"]) && (strpos($headers["content-type"], "application/xrds+xml") !== false || strpos($headers["content-type"], "text/xml") !== false)) {
                    $content = $this->request($url, "GET");
                    preg_match_all("#<Service.*?>(.*?)</Service>#s", $content, $m);
                    foreach ($m[1] as $content) {
                        $content = " " . $content;
                        $ns = preg_quote("http://specs.openid.net/auth/2.0/");
                        if (preg_match("#<Type>\\s*" . $ns . "(server|signon)\\s*</Type>#s", $content, $type)) {
                            if ($type[1] == "server") {
                                $this->identifier_select = true;
                            }
                            preg_match("#<URI.*?>(.*)</URI>#", $content, $server);
                            preg_match("#<(Local|Canonical)ID>(.*)</\\1ID>#", $content, $delegate);
                            if (empty($server)) {
                                return false;
                            }
                            $this->ax = (bool) strpos($content, "<Type>http://openid.net/srv/ax/1.0</Type>");
                            $this->sreg = strpos($content, "<Type>http://openid.net/sreg/1.0</Type>") || strpos($content, "<Type>http://openid.net/extensions/sreg/1.1</Type>");
                            $server = $server[1];
                            if (isset($delegate[2])) {
                                $this->identity = trim($delegate[2]);
                            }
                            $this->version = 2;
                            $this->server = $server;
                            return $server;
                        }
                        $ns = preg_quote("http://openid.net/signon/1.1");
                        if (preg_match("#<Type>\\s*" . $ns . "\\s*</Type>#s", $content)) {
                            preg_match("#<URI.*?>(.*)</URI>#", $content, $server);
                            preg_match("#<.*?Delegate>(.*)</.*?Delegate>#", $content, $delegate);
                            if (empty($server)) {
                                return false;
                            }
                            $this->sreg = strpos($content, "<Type>http://openid.net/sreg/1.0</Type>") || strpos($content, "<Type>http://openid.net/extensions/sreg/1.1</Type>");
                            $server = $server[1];
                            if (isset($delegate[1])) {
                                $this->identity = $delegate[1];
                            }
                            $this->version = 1;
                            $this->server = $server;
                            return $server;
                        }
                    }
                    $next = true;
                    $yadis = false;
                    $url = $originalUrl;
                    $content = NULL;
                } else {
                    if (!$next) {
                        $content = $this->request($url, "GET");
                        $location = $this->htmlTag($content, "meta", "http-equiv", "X-XRDS-Location", "content");
                        if ($location) {
                            $url = $this->build_url(parse_url($url), parse_url($location));
                        }
                    }
                    $i++;
                }
            }
            if (!$content) {
                $content = $this->request($url, "GET");
            }
            $server = $this->htmlTag($content, "link", "rel", "openid2.provider", "href");
            $delegate = $this->htmlTag($content, "link", "rel", "openid2.local_id", "href");
            $this->version = 2;
            if (!$server) {
                $server = $this->htmlTag($content, "link", "rel", "openid.server", "href");
                $delegate = $this->htmlTag($content, "link", "rel", "openid.delegate", "href");
                $this->version = 1;
            }
            if ($server) {
                if ($delegate) {
                    $this->identity = $delegate;
                }
                $this->server = $server;
                return $server;
            }
            throw new ErrorException("No servers found!");
        }
        throw new ErrorException("Endless redirection!");
    }
    protected function sregParams()
    {
        $params = [];
        $params["openid.ns.sreg"] = "http://openid.net/extensions/sreg/1.1";
        if ($this->required) {
            $params["openid.sreg.required"] = [];
            foreach ($this->required as $required) {
                if (isset(self::$ax_to_sreg[$required])) {
                    $params["openid.sreg.required"][] = self::$ax_to_sreg[$required];
                }
            }
            $params["openid.sreg.required"] = implode(",", $params["openid.sreg.required"]);
        }
        if ($this->optional) {
            $params["openid.sreg.optional"] = [];
            foreach ($this->optional as $optional) {
                if (isset(self::$ax_to_sreg[$optional])) {
                    $params["openid.sreg.optional"][] = self::$ax_to_sreg[$optional];
                }
            }
            $params["openid.sreg.optional"] = implode(",", $params["openid.sreg.optional"]);
        }
        return $params;
    }
    protected function axParams()
    {
        $params = [];
        if ($this->required || $this->optional) {
            $params["openid.ns.ax"] = "http://openid.net/srv/ax/1.0";
            $params["openid.ax.mode"] = "fetch_request";
            $this->aliases = [];
            $counts = [];
            $required = [];
            $optional = [];
            foreach (["required", "optional"] as $type) {
                foreach ($this->{$type} as $alias => $field) {
                    if (is_int($alias)) {
                        $alias = strtr($field, "/", "_");
                    }
                    $this->aliases[$alias] = "http://axschema.org/" . $field;
                    if (empty($counts[$alias])) {
                        $counts[$alias] = 0;
                    }
                    $counts[$alias] += 1;
                    ${$type}[] = $alias;
                }
            }
            foreach ($this->aliases as $alias => $ns) {
                $params["openid.ax.type." . $alias] = $ns;
            }
            foreach ($counts as $alias => $count) {
                if ($count != 1) {
                    $params["openid.ax.count." . $alias] = $count;
                }
            }
            if ($required) {
                $params["openid.ax.required"] = implode(",", $required);
            }
            if ($optional) {
                $params["openid.ax.if_available"] = implode(",", $optional);
            }
        }
        return $params;
    }
    protected function authUrl_v1()
    {
        $returnUrl = $this->returnUrl;
        if ($this->identity != $this->claimed_id) {
            $returnUrl .= (strpos($returnUrl, "?") ? "&" : "?") . "openid.claimed_id=" . $this->claimed_id;
        }
        $params = ["openid.return_to" => $returnUrl, "openid.mode" => "checkid_setup", "openid.identity" => $this->identity, "openid.trust_root" => $this->trustRoot] + $this->sregParams();
        return $this->build_url(parse_url($this->server), ["query" => http_build_query($params, "", "&")]);
    }
    protected function authUrl_v2($identifier_select)
    {
        $params = ["openid.ns" => "http://specs.openid.net/auth/2.0", "openid.mode" => "checkid_setup", "openid.return_to" => $this->returnUrl, "openid.realm" => $this->trustRoot];
        if ($this->ax) {
            $params += $this->axParams();
        }
        if ($this->sreg) {
            $params += $this->sregParams();
        }
        if (!$this->ax && !$this->sreg) {
            $params += $this->axParams() + $this->sregParams();
        }
        if ($identifier_select) {
            $params["openid.claimed_id"] = "http://specs.openid.net/auth/2.0/identifier_select";
            $params["openid.identity"] = $params["openid.claimed_id"];
        } else {
            $params["openid.identity"] = $this->identity;
            $params["openid.claimed_id"] = $this->claimed_id;
        }
        return $this->build_url(parse_url($this->server), ["query" => http_build_query($params, "", "&")]);
    }
    public function authUrl($identifier_select = NULL)
    {
        if (!$this->server) {
            $this->discover($this->identity);
        }
        if ($this->version == 2) {
            if ($identifier_select === NULL) {
                return $this->authUrl_v2($this->identifier_select);
            }
            return $this->authUrl_v2($identifier_select);
        }
        return $this->authUrl_v1();
    }
    public function validate()
    {
        $this->claimed_id = isset($this->data["openid_claimed_id"]) ? $this->data["openid_claimed_id"] : $this->data["openid_identity"];
        $params = ["openid.assoc_handle" => $this->data["openid_assoc_handle"], "openid.signed" => $this->data["openid_signed"], "openid.sig" => $this->data["openid_sig"]];
        if (isset($this->data["openid_ns"])) {
            $params["openid.ns"] = "http://specs.openid.net/auth/2.0";
        } else {
            if (isset($this->data["openid_claimed_id"]) && $this->data["openid_claimed_id"] != $this->data["openid_identity"]) {
                $this->returnUrl .= (strpos($this->returnUrl, "?") ? "&" : "?") . "openid.claimed_id=" . $this->claimed_id;
            }
        }
        if ($this->data["openid_return_to"] != $this->returnUrl) {
            return false;
        }
        $server = $this->discover($this->claimed_id);
        foreach (explode(",", $this->data["openid_signed"]) as $item) {
            $value = $this->data["openid_" . str_replace(".", "_", $item)];
            $params["openid." . $item] = get_magic_quotes_gpc() ? stripslashes($value) : $value;
        }
        $params["openid.mode"] = "check_authentication";
        $response = $this->request($server, "POST", $params);
        return preg_match("/is_valid\\s*:\\s*true/i", $response);
    }
    protected function getAxAttributes()
    {
        $alias = NULL;
        if (isset($this->data["openid_ns_ax"]) && $this->data["openid_ns_ax"] != "http://openid.net/srv/ax/1.0") {
            $alias = "ax";
        } else {
            foreach ($this->data as $key => $val) {
                if (substr($key, 0, strlen("openid_ns_")) == "openid_ns_" && $val == "http://openid.net/srv/ax/1.0") {
                    $alias = substr($key, strlen("openid_ns_"));
                }
            }
        }
        if (!$alias) {
            return [];
        }
        $attributes = [];
        foreach ($this->data as $key => $value) {
            $keyMatch = "openid_" . $alias . "_value_";
            if (substr($key, 0, strlen($keyMatch)) == $keyMatch) {
                $key = substr($key, strlen($keyMatch));
                if (isset($this->data["openid_" . $alias . "_type_" . $key])) {
                    $key = substr($this->data["openid_" . $alias . "_type_" . $key], strlen("http://axschema.org/"));
                    $attributes[$key] = $value;
                }
            }
        }
        return $attributes;
    }
    protected function getSregAttributes()
    {
        $attributes = [];
        $sreg_to_ax = array_flip(self::$ax_to_sreg);
        foreach ($this->data as $key => $value) {
            $keyMatch = "openid_sreg_";
            if (substr($key, 0, strlen($keyMatch)) == $keyMatch) {
                $key = substr($key, strlen($keyMatch));
                if (isset($sreg_to_ax[$key])) {
                    $attributes[$sreg_to_ax[$key]] = $value;
                }
            }
        }
        return $attributes;
    }
    public function getAttributes()
    {
        if (isset($this->data["openid_ns"]) && $this->data["openid_ns"] == "http://specs.openid.net/auth/2.0") {
            return $this->getAxAttributes() + $this->getSregAttributes();
        }
        return $this->getSregAttributes();
    }
    public function get_headers_curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $r = curl_exec($ch);
        $r = explode("\n", $r);
        return $r;
    }
    public function curl_get_file_contents($URL)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);
        if ($contents) {
            return $contents;
        }
        return false;
    }
}

?>