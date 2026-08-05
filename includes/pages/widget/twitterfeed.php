<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require_once "./comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
$numtweets = preg_replace("/[^0-9]/i", "", $numtweets);
installclient($pagetitle, $pageicon, $breadcrumbnav);
if ($config["twitter"] && $config["access_token"] && $config["token_secret"] && $config["consumer_key"] && $config["consumer_secret"]) {
    if (!$_SESSION["tweets"]) {
        $twitterusername = $config["twitter"];
        $twitter = new TwitterAPIExchange(["oauth_access_token" => $config["access_token"], "oauth_access_token_secret" => $config["token_secret"], "consumer_key" => $config["consumer_key"], "consumer_secret" => $config["consumer_secret"]]);
        $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
        $getfield = "?screen_name=" . $config["twitter"];
        $requestMethod = "GET";
        $response = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
        $twitterposts = json_decode($response, true);
        if (is_array($twitterposts)) {
            foreach ($twitterposts as $values) {
                $values["TEXT"] = nl2br($values["text"]);
                $values["TEXT"] = addslashes($values["TEXT"]);
                $values["TEXT"] = strip_tags($values["TEXT"]);
                $twitterdate = strtotime($values["created_at"]);
                $tweets[] = ["date" => formatDate(date("Y-m-d H:i", $twitterdate), true), "tweet" => AutoHyperlinks2($values["TEXT"])];
            }
        }
        if ($tweets) {
            $_SESSION["tweets"] = $tweets;
        }
    }
    $smarty->assign("tweets", $_SESSION["tweets"]);
    $numtweets = $numtweets ? $numtweets : "4";
    $smarty->assign("numtweets", $numtweets);
    echo processSingleTemplate("twitterfeed");
}
class TwitterAPIExchange
{
    private $oauth_access_token = NULL;
    private $oauth_access_token_secret = NULL;
    private $consumer_key = NULL;
    private $consumer_secret = NULL;
    private $postfields = NULL;
    private $getfield = NULL;
    protected $oauth = NULL;
    public $url = NULL;
    public function __construct($settings)
    {
        if (!in_array("curl", get_loaded_extensions())) {
            throw new Exception("You need to install cURL, see: https://curl.haxx.se/docs/install.html");
        }
        if (!isset($settings["oauth_access_token"]) || !isset($settings["oauth_access_token_secret"]) || !isset($settings["consumer_key"]) || !isset($settings["consumer_secret"])) {
            throw new Exception("Make sure you are passing in the correct parameters");
        }
        $this->oauth_access_token = $settings["oauth_access_token"];
        $this->oauth_access_token_secret = $settings["oauth_access_token_secret"];
        $this->consumer_key = $settings["consumer_key"];
        $this->consumer_secret = $settings["consumer_secret"];
    }
    public function setPostfields($array)
    {
        if (!is_null($this->getGetfield())) {
            throw new Exception("You can only choose get OR post fields.");
        }
        if (isset($array["status"]) && substr($array["status"], 0, 1) === "@") {
            $array["status"] = sprintf("\0%s", $array["status"]);
        }
        $this->postfields = $array;
        return $this;
    }
    public function setGetfield($string)
    {
        if (!is_null($this->getPostfields())) {
            throw new Exception("You can only choose get OR post fields.");
        }
        $search = ["#", ",", "+", ":"];
        $replace = ["%23", "%2C", "%2B", "%3A"];
        $string = str_replace($search, $replace, $string);
        $this->getfield = $string;
        return $this;
    }
    public function getGetfield()
    {
        return $this->getfield;
    }
    public function getPostfields()
    {
        return $this->postfields;
    }
    public function buildOauth($url, $requestMethod)
    {
        if (!in_array(strtolower($requestMethod), ["post", "get"])) {
            throw new Exception("Request method must be either POST or GET");
        }
        $consumer_key = $this->consumer_key;
        $consumer_secret = $this->consumer_secret;
        $oauth_access_token = $this->oauth_access_token;
        $oauth_access_token_secret = $this->oauth_access_token_secret;
        $oauth = ["oauth_consumer_key" => $consumer_key, "oauth_nonce" => time(), "oauth_signature_method" => "HMAC-SHA1", "oauth_token" => $oauth_access_token, "oauth_timestamp" => time(), "oauth_version" => "1.0"];
        $getfield = $this->getGetfield();
        if (!is_null($getfield)) {
            $getfields = str_replace("?", "", explode("&", $getfield));
            foreach ($getfields as $g) {
                $split = explode("=", $g);
                $oauth[$split[0]] = $split[1];
            }
        }
        $base_info = $this->buildBaseString($url, $requestMethod, $oauth);
        $composite_key = rawurlencode($consumer_secret) . "&" . rawurlencode($oauth_access_token_secret);
        $oauth_signature = base64_encode(hash_hmac("sha1", $base_info, $composite_key, true));
        $oauth["oauth_signature"] = $oauth_signature;
        $this->url = $url;
        $this->oauth = $oauth;
        return $this;
    }
    public function performRequest($return = true)
    {
        if (!is_bool($return)) {
            throw new Exception("performRequest parameter must be true or false");
        }
        $header = [$this->buildAuthorizationHeader($this->oauth), "Expect:"];
        $getfield = $this->getGetfield();
        $postfields = $this->getPostfields();
        $options = [CURLOPT_HTTPHEADER => $header, CURLOPT_HEADER => false, CURLOPT_URL => $this->url, CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 10];
        if (!is_null($postfields)) {
            $options[CURLOPT_POSTFIELDS] = $postfields;
        } else {
            if ($getfield !== "") {
                $options[CURLOPT_URL] .= $getfield;
            }
        }
        $feed = curl_init();
        curl_setopt_array($feed, $options);
        $json = curl_exec($feed);
        curl_close($feed);
        if ($return) {
            return $json;
        }
    }
    private function buildBaseString($baseURI, $method, $params)
    {
        $return = [];
        ksort($params);
        foreach ($params as $key => $value) {
            $return[] = $key . "=" . $value;
        }
        return $method . "&" . rawurlencode($baseURI) . "&" . rawurlencode(implode("&", $return));
    }
    private function buildAuthorizationHeader($oauth)
    {
        $return = "Authorization: OAuth ";
        $values = [];
        foreach ($oauth as $key => $value) {
            $values[] = $key . "=\"" . rawurlencode($value) . "\"";
        }
        $return .= implode(", ", $values);
        return $return;
    }
}
function AutoHyperlinks2($message)
{
    $message = preg_replace("/((http(s?):\\/\\/)|(www\\.))([\\w\\.]+)([a-zA-Z0-9?&%#.;:\\/=+_-]+)/i", "<a href=\"http\$3://\$4\$5\$6\" target=\"_blank\">\$2\$4\$5\$6</a>", $message);
    return $message;
}
function XMLtoARRAY($rawxml)
{
    $xml_parser = xml_parser_create();
    xml_parse_into_struct($xml_parser, $rawxml, $vals, $index);
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
            $php_stmt .= "[\$xml_elem['tag']] = \$xml_elem['value'];";
            eval($php_stmt);
        }
    }
    return $params;
}

?>