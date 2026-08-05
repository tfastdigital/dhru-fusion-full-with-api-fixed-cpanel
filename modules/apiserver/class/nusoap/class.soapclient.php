<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
*
* [nu]soapclient higher level class for easy usage.
*
* usage:
*
* // instantiate client with server info
* $soapclient = new nusoap_client( string path [ ,mixed wsdl] );
*
* // call method, get results
* echo $soapclient->call( string methodname [ ,array parameters] );
*
* // bye bye client
* unset($soapclient);
*
* @author   Dietrich Ayala <dietrich@ganx4.com>
* @author   Scott Nichol <snichol@users.sourceforge.net>
* @version  $Id: class.soapclient.php,v 1.69 2010/04/26 20:15:08 snichol Exp $
* @access   public
*/
class nusoap_client extends nusoap_base
{
    public $username = "";
    public $password = "";
    public $authtype = "";
    public $certRequest = [];
    public $requestHeaders = false;
    public $responseHeaders = "";
    public $responseHeader = NULL;
    public $document = "";
    public $endpoint = NULL;
    public $forceEndpoint = "";
    public $proxyhost = "";
    public $proxyport = "";
    public $proxyusername = "";
    public $proxypassword = "";
    public $portName = "";
    public $xml_encoding = "";
    public $http_encoding = false;
    public $timeout = 0;
    public $response_timeout = 30;
    public $endpointType = "";
    public $persistentConnection = false;
    public $defaultRpcParams = false;
    public $request = "";
    public $response = "";
    public $responseData = "";
    public $cookies = [];
    public $decode_utf8 = true;
    public $operations = [];
    public $curl_options = [];
    public $bindingType = "";
    public $use_curl = false;
    /**
     * @var      fault
     * @access   public
     */
    public $fault = NULL;
    /**
     * @var      faultcode
     * @access   public
     */
    public $faultcode = NULL;
    /**
     * @var      faultstring
     * @access   public
     */
    public $faultstring = NULL;
    /**
     * @var      faultdetail
     * @access   public
     */
    public $faultdetail = NULL;
    public function nusoap_client($endpoint, $wsdl = false, $proxyhost = false, $proxyport = false, $proxyusername = false, $proxypassword = false, $timeout = 0, $response_timeout = 30, $portName = "")
    {
        parent::nusoap_base();
        $this->endpoint = $endpoint;
        $this->proxyhost = $proxyhost;
        $this->proxyport = $proxyport;
        $this->proxyusername = $proxyusername;
        $this->proxypassword = $proxypassword;
        $this->timeout = $timeout;
        $this->response_timeout = $response_timeout;
        $this->portName = $portName;
        $this->debug("ctor wsdl=" . $wsdl . " timeout=" . $timeout . " response_timeout=" . $response_timeout);
        $this->appendDebug("endpoint=" . $this->varDump($endpoint));
        if ($wsdl) {
            if (is_object($endpoint) && get_class($endpoint) == "wsdl") {
                $this->wsdl = $endpoint;
                $this->endpoint = $this->wsdl->wsdl;
                $this->wsdlFile = $this->endpoint;
                $this->debug("existing wsdl instance created from " . $this->endpoint);
                $this->checkWSDL();
            } else {
                $this->wsdlFile = $this->endpoint;
                $this->wsdl = NULL;
                $this->debug("will use lazy evaluation of wsdl from " . $this->endpoint);
            }
            $this->endpointType = "wsdl";
        } else {
            $this->debug("instantiate SOAP with endpoint at " . $endpoint);
            $this->endpointType = "soap";
        }
    }
    public function call($operation, $params = [], $namespace = "http://tempuri.org", $soapAction = "", $headers = false, $rpcParams = NULL, $style = "rpc", $use = "encoded")
    {
        $this->operation = $operation;
        $this->fault = false;
        $this->setError("");
        $this->request = "";
        $this->response = "";
        $this->responseData = "";
        $this->faultstring = "";
        $this->faultcode = "";
        $this->opData = [];
        $this->debug("call: operation=" . $operation . ", namespace=" . $namespace . ", soapAction=" . $soapAction . ", rpcParams=" . $rpcParams . ", style=" . $style . ", use=" . $use . ", endpointType=" . $this->endpointType);
        $this->appendDebug("params=" . $this->varDump($params));
        $this->appendDebug("headers=" . $this->varDump($headers));
        if ($headers) {
            $this->requestHeaders = $headers;
        }
        if ($this->endpointType == "wsdl" && is_null($this->wsdl)) {
            $this->loadWSDL();
            if ($this->getError()) {
                return false;
            }
        }
        if ($this->endpointType == "wsdl" && ($opData = $this->getOperationData($operation))) {
            $this->opData = $opData;
            $this->debug("found operation");
            $this->appendDebug("opData=" . $this->varDump($opData));
            if (isset($opData["soapAction"])) {
                $soapAction = $opData["soapAction"];
            }
            if (!$this->forceEndpoint) {
                $this->endpoint = $opData["endpoint"];
            } else {
                $this->endpoint = $this->forceEndpoint;
            }
            $namespace = isset($opData["input"]["namespace"]) ? $opData["input"]["namespace"] : $namespace;
            $style = $opData["style"];
            $use = $opData["input"]["use"];
            if ($namespace != "" && !isset($this->wsdl->namespaces[$namespace])) {
                $nsPrefix = "ns" . rand(1000, 9999);
                $this->wsdl->namespaces[$nsPrefix] = $namespace;
            }
            $nsPrefix = $this->wsdl->getPrefixFromNamespace($namespace);
            if (is_string($params)) {
                $this->debug("serializing param string for WSDL operation " . $operation);
                $payload = $params;
            } else {
                if (is_array($params)) {
                    $this->debug("serializing param array for WSDL operation " . $operation);
                    $payload = $this->wsdl->serializeRPCParameters($operation, "input", $params, $this->bindingType);
                } else {
                    $this->debug("params must be array or string");
                    $this->setError("params must be array or string");
                    return false;
                }
            }
            $usedNamespaces = $this->wsdl->usedNamespaces;
            if (isset($opData["input"]["encodingStyle"])) {
                $encodingStyle = $opData["input"]["encodingStyle"];
            } else {
                $encodingStyle = "";
            }
            $this->appendDebug($this->wsdl->getDebug());
            $this->wsdl->clearDebug();
            if ($errstr = $this->wsdl->getError()) {
                $this->debug("got wsdl error: " . $errstr);
                $this->setError("wsdl error: " . $errstr);
                return false;
            }
        } else {
            if ($this->endpointType == "wsdl") {
                $this->appendDebug($this->wsdl->getDebug());
                $this->wsdl->clearDebug();
                $this->setError("operation " . $operation . " not present in WSDL.");
                $this->debug("operation '" . $operation . "' not present in WSDL.");
                return false;
            }
            $nsPrefix = "ns" . rand(1000, 9999);
            $payload = "";
            if (is_string($params)) {
                $this->debug("serializing param string for operation " . $operation);
                $payload = $params;
            } else {
                if (is_array($params)) {
                    $this->debug("serializing param array for operation " . $operation);
                    foreach ($params as $k => $v) {
                        $payload .= $this->serialize_val($v, $k, false, false, false, false, $use);
                    }
                } else {
                    $this->debug("params must be array or string");
                    $this->setError("params must be array or string");
                    return false;
                }
            }
            $usedNamespaces = [];
            if ($use == "encoded") {
                $encodingStyle = "http://schemas.xmlsoap.org/soap/encoding/";
            } else {
                $encodingStyle = "";
            }
        }
        if ($style == "rpc") {
            if ($use == "literal") {
                $this->debug("wrapping RPC request with literal method element");
                if ($namespace) {
                    $payload = "<" . $nsPrefix . ":" . $operation . " xmlns:" . $nsPrefix . "=\"" . $namespace . "\">" . $payload . "</" . $nsPrefix . ":" . $operation . ">";
                } else {
                    $payload = "<" . $operation . ">" . $payload . "</" . $operation . ">";
                }
            } else {
                $this->debug("wrapping RPC request with encoded method element");
                if ($namespace) {
                    $payload = "<" . $nsPrefix . ":" . $operation . " xmlns:" . $nsPrefix . "=\"" . $namespace . "\">" . $payload . "</" . $nsPrefix . ":" . $operation . ">";
                } else {
                    $payload = "<" . $operation . ">" . $payload . "</" . $operation . ">";
                }
            }
        }
        $soapmsg = $this->serializeEnvelope($payload, $this->requestHeaders, $usedNamespaces, $style, $use, $encodingStyle);
        $this->debug("endpoint=" . $this->endpoint . ", soapAction=" . $soapAction . ", namespace=" . $namespace . ", style=" . $style . ", use=" . $use . ", encodingStyle=" . $encodingStyle);
        $this->debug("SOAP message length=" . strlen($soapmsg) . " contents (max 1000 bytes)=" . substr($soapmsg, 0, 1000));
        $return = $this->send($this->getHTTPBody($soapmsg), $soapAction, $this->timeout, $this->response_timeout);
        if ($errstr = $this->getError()) {
            $this->debug("Error: " . $errstr);
            return false;
        }
        $this->return = $return;
        $this->debug("sent message successfully and got a(n) " . gettype($return));
        $this->appendDebug("return=" . $this->varDump($return));
        if (is_array($return) && isset($return["faultcode"])) {
            $this->debug("got fault");
            $this->setError($return["faultcode"] . ": " . $return["faultstring"]);
            $this->fault = true;
            foreach ($return as $k => $v) {
                $this->{$k} = $v;
                $this->debug($k . " = " . $v . "<br>");
            }
            return $return;
        } else {
            if ($style == "document") {
                return $return;
            }
            if (is_array($return)) {
                if (1 < sizeof($return)) {
                    return $return;
                }
                $return = array_shift($return);
                $this->debug("return shifted value: ");
                $this->appendDebug($this->varDump($return));
                return $return;
            }
            return "";
        }
    }
    public function checkWSDL()
    {
        $this->appendDebug($this->wsdl->getDebug());
        $this->wsdl->clearDebug();
        $this->debug("checkWSDL");
        if ($errstr = $this->wsdl->getError()) {
            $this->appendDebug($this->wsdl->getDebug());
            $this->wsdl->clearDebug();
            $this->debug("got wsdl error: " . $errstr);
            $this->setError("wsdl error: " . $errstr);
        } else {
            if ($this->operations = $this->wsdl->getOperations($this->portName, "soap")) {
                $this->appendDebug($this->wsdl->getDebug());
                $this->wsdl->clearDebug();
                $this->bindingType = "soap";
                $this->debug("got " . count($this->operations) . " operations from wsdl " . $this->wsdlFile . " for binding type " . $this->bindingType);
            } else {
                if ($this->operations = $this->wsdl->getOperations($this->portName, "soap12")) {
                    $this->appendDebug($this->wsdl->getDebug());
                    $this->wsdl->clearDebug();
                    $this->bindingType = "soap12";
                    $this->debug("got " . count($this->operations) . " operations from wsdl " . $this->wsdlFile . " for binding type " . $this->bindingType);
                    $this->debug("**************** WARNING: SOAP 1.2 BINDING *****************");
                } else {
                    $this->appendDebug($this->wsdl->getDebug());
                    $this->wsdl->clearDebug();
                    $this->debug("getOperations returned false");
                    $this->setError("no operations defined in the WSDL document!");
                }
            }
        }
    }
    public function loadWSDL()
    {
        $this->debug("instantiating wsdl class with doc: " . $this->wsdlFile);
        $this->wsdl = new wsdl("", $this->proxyhost, $this->proxyport, $this->proxyusername, $this->proxypassword, $this->timeout, $this->response_timeout, $this->curl_options, $this->use_curl);
        $this->wsdl->setCredentials($this->username, $this->password, $this->authtype, $this->certRequest);
        $this->wsdl->fetchWSDL($this->wsdlFile);
        $this->checkWSDL();
    }
    public function getOperationData($operation)
    {
        if ($this->endpointType == "wsdl" && is_null($this->wsdl)) {
            $this->loadWSDL();
            if ($this->getError()) {
                return false;
            }
        }
        if (isset($this->operations[$operation])) {
            return $this->operations[$operation];
        }
        $this->debug("No data for operation: " . $operation);
    }
    public function send($msg, $soapaction = "", $timeout = 0, $response_timeout = 30)
    {
        $this->checkCookies();
        if (preg_match("/^http/", $this->endpoint)) {
            $this->setError("no transport found, or selected transport is not yet supported!");
            return false;
        }
        $this->debug("transporting via HTTP");
        if ($this->persistentConnection && is_object($this->persistentConnection)) {
            $http =& $this->persistentConnection;
        } else {
            $http = new soap_transport_http($this->endpoint, $this->curl_options, $this->use_curl);
            if ($this->persistentConnection) {
                $http->usePersistentConnection();
            }
        }
        $http->setContentType($this->getHTTPContentType(), $this->getHTTPContentTypeCharset());
        $http->setSOAPAction($soapaction);
        if ($this->proxyhost && $this->proxyport) {
            $http->setProxy($this->proxyhost, $this->proxyport, $this->proxyusername, $this->proxypassword);
        }
        if ($this->authtype != "") {
            $http->setCredentials($this->username, $this->password, $this->authtype, [], $this->certRequest);
        }
        if ($this->http_encoding != "") {
            $http->setEncoding($this->http_encoding);
        }
        $this->debug("sending message, length=" . strlen($msg));
        if (preg_match("/^http:/", $this->endpoint)) {
            $this->responseData = $http->send($msg, $timeout, $response_timeout, $this->cookies);
        } else {
            if (preg_match("/^https/", $this->endpoint)) {
                $this->responseData = $http->sendHTTPS($msg, $timeout, $response_timeout, $this->cookies);
            } else {
                $this->setError("no http/s in endpoint url");
            }
        }
        $this->request = $http->outgoing_payload;
        $this->response = $http->incoming_payload;
        $this->appendDebug($http->getDebug());
        $this->UpdateCookies($http->incoming_cookies);
        if ($this->persistentConnection) {
            $http->clearDebug();
            if (!is_object($this->persistentConnection)) {
                $this->persistentConnection = $http;
            }
        }
        if ($err = $http->getError()) {
            $this->setError("HTTP Error: " . $err);
            return false;
        }
        if ($this->getError()) {
            return false;
        }
        $this->debug("got response, length=" . strlen($this->responseData) . " type=" . $http->incoming_headers["content-type"]);
        return $this->parseResponse($http->incoming_headers, $this->responseData);
    }
    public function parseResponse($headers, $data)
    {
        $this->debug("Entering parseResponse() for data of length " . strlen($data) . " headers:");
        $this->appendDebug($this->varDump($headers));
        if (!isset($headers["content-type"])) {
            $this->setError("Response not of type text/xml (no content-type header)");
            return false;
        }
        if (!strstr($headers["content-type"], "text/xml")) {
            $this->setError("Response not of type text/xml: " . $headers["content-type"]);
            return false;
        }
        if (strpos($headers["content-type"], "=")) {
            $enc = str_replace("\"", "", substr(strstr($headers["content-type"], "="), 1));
            $this->debug("Got response encoding: " . $enc);
            if (preg_match("/^(ISO-8859-1|US-ASCII|UTF-8)\$/i", $enc)) {
                $this->xml_encoding = strtoupper($enc);
            } else {
                $this->xml_encoding = "US-ASCII";
            }
        } else {
            $this->xml_encoding = "ISO-8859-1";
        }
        $this->debug("Use encoding: " . $this->xml_encoding . " when creating nusoap_parser");
        $parser = new nusoap_parser($data, $this->xml_encoding, $this->operation, $this->decode_utf8);
        $this->appendDebug($parser->getDebug());
        if ($errstr = $parser->getError()) {
            $this->setError($errstr);
            unset($parser);
            return false;
        }
        $this->responseHeaders = $parser->getHeaders();
        $this->responseHeader = $parser->get_soapheader();
        $return = $parser->get_soapbody();
        $this->document = $parser->document;
        unset($parser);
        return $return;
    }
    public function setCurlOption($option, $value)
    {
        $this->debug("setCurlOption option=" . $option . ", value=");
        $this->appendDebug($this->varDump($value));
        $this->curl_options[$option] = $value;
    }
    public function setEndpoint($endpoint)
    {
        $this->debug("setEndpoint(\"" . $endpoint . "\")");
        $this->forceEndpoint = $endpoint;
    }
    public function setHeaders($headers)
    {
        $this->debug("setHeaders headers=");
        $this->appendDebug($this->varDump($headers));
        $this->requestHeaders = $headers;
    }
    public function getHeaders()
    {
        return $this->responseHeaders;
    }
    public function getHeader()
    {
        return $this->responseHeader;
    }
    public function setHTTPProxy($proxyhost, $proxyport, $proxyusername = "", $proxypassword = "")
    {
        $this->proxyhost = $proxyhost;
        $this->proxyport = $proxyport;
        $this->proxyusername = $proxyusername;
        $this->proxypassword = $proxypassword;
    }
    public function setCredentials($username, $password, $authtype = "basic", $certRequest = [])
    {
        $this->debug("setCredentials username=" . $username . " authtype=" . $authtype . " certRequest=");
        $this->appendDebug($this->varDump($certRequest));
        $this->username = $username;
        $this->password = $password;
        $this->authtype = $authtype;
        $this->certRequest = $certRequest;
    }
    public function setHTTPEncoding($enc = "gzip, deflate")
    {
        $this->debug("setHTTPEncoding(\"" . $enc . "\")");
        $this->http_encoding = $enc;
    }
    public function setUseCURL($use)
    {
        $this->debug("setUseCURL(" . $use . ")");
        $this->use_curl = $use;
    }
    public function useHTTPPersistentConnection()
    {
        $this->debug("useHTTPPersistentConnection");
        $this->persistentConnection = true;
    }
    public function getDefaultRpcParams()
    {
        return $this->defaultRpcParams;
    }
    public function setDefaultRpcParams($rpcParams)
    {
        $this->defaultRpcParams = $rpcParams;
    }
    public function getProxy()
    {
        $r = rand();
        $evalStr = $this->_getProxyClassCode($r);
        if ($this->getError()) {
            $this->debug("Error from _getProxyClassCode, so return NULL");
        } else {
            eval($evalStr);
            eval("\$proxy = new nusoap_proxy_" . $r . "('');");
            $proxy->endpointType = "wsdl";
            $proxy->wsdlFile = $this->wsdlFile;
            $proxy->wsdl = $this->wsdl;
            $proxy->operations = $this->operations;
            $proxy->defaultRpcParams = $this->defaultRpcParams;
            $proxy->soap_defencoding = $this->soap_defencoding;
            $proxy->username = $this->username;
            $proxy->password = $this->password;
            $proxy->authtype = $this->authtype;
            $proxy->certRequest = $this->certRequest;
            $proxy->requestHeaders = $this->requestHeaders;
            $proxy->endpoint = $this->endpoint;
            $proxy->forceEndpoint = $this->forceEndpoint;
            $proxy->proxyhost = $this->proxyhost;
            $proxy->proxyport = $this->proxyport;
            $proxy->proxyusername = $this->proxyusername;
            $proxy->proxypassword = $this->proxypassword;
            $proxy->http_encoding = $this->http_encoding;
            $proxy->timeout = $this->timeout;
            $proxy->response_timeout = $this->response_timeout;
            $proxy->persistentConnection =& $this->persistentConnection;
            $proxy->decode_utf8 = $this->decode_utf8;
            $proxy->curl_options = $this->curl_options;
            $proxy->bindingType = $this->bindingType;
            $proxy->use_curl = $this->use_curl;
            return $proxy;
        }
    }
    public function _getProxyClassCode($r)
    {
        $this->debug("in getProxy endpointType=" . $this->endpointType);
        $this->appendDebug("wsdl=" . $this->varDump($this->wsdl));
        if ($this->endpointType != "wsdl") {
            $evalStr = "A proxy can only be created for a WSDL client";
            $this->setError($evalStr);
            $evalStr = "echo \"" . $evalStr . "\";";
            return $evalStr;
        }
        if ($this->endpointType == "wsdl" && is_null($this->wsdl)) {
            $this->loadWSDL();
            if ($this->getError()) {
                return "echo \"" . $this->getError() . "\";";
            }
        }
        $evalStr = "";
        foreach ($this->operations as $operation => $opData) {
            if ($operation != "") {
                if (0 < sizeof($opData["input"]["parts"])) {
                    $paramStr = "";
                    $paramArrayStr = "";
                    $paramCommentStr = "";
                    foreach ($opData["input"]["parts"] as $name => $type) {
                        $paramStr .= "\$" . $name . ", ";
                        $paramArrayStr .= "'" . $name . "' => \$" . $name . ", ";
                        $paramCommentStr .= $type . " \$" . $name . ", ";
                    }
                    $paramStr = substr($paramStr, 0, strlen($paramStr) - 2);
                    $paramArrayStr = substr($paramArrayStr, 0, strlen($paramArrayStr) - 2);
                    $paramCommentStr = substr($paramCommentStr, 0, strlen($paramCommentStr) - 2);
                } else {
                    $paramStr = "";
                    $paramArrayStr = "";
                    $paramCommentStr = "void";
                }
                $opData["namespace"] = !isset($opData["namespace"]) ? "http://testuri.com" : $opData["namespace"];
                $evalStr .= "// " . $paramCommentStr . "\r\n\tfunction " . str_replace(".", "__", $operation) . "(" . $paramStr . ") {\r\n\t\t\$params = array(" . $paramArrayStr . ");\r\n\t\treturn \$this->call('" . $operation . "', \$params, '" . $opData["namespace"] . "', '" . (isset($opData["soapAction"]) ? $opData["soapAction"] : "") . "');\r\n\t}\r\n\t";
                unset($paramStr);
                unset($paramCommentStr);
            }
        }
        $evalStr = "class nusoap_proxy_" . $r . " extends nusoap_client {\r\n\t" . $evalStr . "\r\n}";
        return $evalStr;
    }
    public function getProxyClassCode()
    {
        $r = rand();
        return $this->_getProxyClassCode($r);
    }
    public function getHTTPBody($soapmsg)
    {
        return $soapmsg;
    }
    public function getHTTPContentType()
    {
        return "text/xml";
    }
    public function getHTTPContentTypeCharset()
    {
        return $this->soap_defencoding;
    }
    public function decodeUTF8($bool)
    {
        $this->decode_utf8 = $bool;
        return true;
    }
    public function setCookie($name, $value)
    {
        if (strlen($name) == 0) {
            return false;
        }
        $this->cookies[] = ["name" => $name, "value" => $value];
        return true;
    }
    public function getCookies()
    {
        return $this->cookies;
    }
    public function checkCookies()
    {
        if (sizeof($this->cookies) == 0) {
            return true;
        }
        $this->debug("checkCookie: check " . sizeof($this->cookies) . " cookies");
        $curr_cookies = $this->cookies;
        $this->cookies = [];
        foreach ($curr_cookies as $cookie) {
            if (!is_array($cookie)) {
                $this->debug("Remove cookie that is not an array");
            } else {
                if (isset($cookie["expires"]) && !empty($cookie["expires"])) {
                    if (time() < strtotime($cookie["expires"])) {
                        $this->cookies[] = $cookie;
                    } else {
                        $this->debug("Remove expired cookie " . $cookie["name"]);
                    }
                } else {
                    $this->cookies[] = $cookie;
                }
            }
        }
        $this->debug("checkCookie: " . sizeof($this->cookies) . " cookies left in array");
        return true;
    }
    public function UpdateCookies($cookies)
    {
        if (sizeof($this->cookies) == 0) {
            if (0 < sizeof($cookies)) {
                $this->debug("Setting new cookie(s)");
                $this->cookies = $cookies;
            }
            return true;
        }
        if (sizeof($cookies) == 0) {
            return true;
        }
        foreach ($cookies as $newCookie) {
            if (is_array($newCookie)) {
                if (isset($newCookie["name"]) && isset($newCookie["value"])) {
                    $newName = $newCookie["name"];
                    $found = false;
                    for ($i = 0; $i < count($this->cookies); $i++) {
                        $cookie = $this->cookies[$i];
                        if (is_array($cookie)) {
                            if (isset($cookie["name"])) {
                                if ($newName == $cookie["name"]) {
                                    $newDomain = isset($newCookie["domain"]) ? $newCookie["domain"] : "NODOMAIN";
                                    $domain = isset($cookie["domain"]) ? $cookie["domain"] : "NODOMAIN";
                                    if ($newDomain == $domain) {
                                        $newPath = isset($newCookie["path"]) ? $newCookie["path"] : "NOPATH";
                                        $path = isset($cookie["path"]) ? $cookie["path"] : "NOPATH";
                                        if ($newPath == $path) {
                                            $this->cookies[$i] = $newCookie;
                                            $found = true;
                                            $this->debug("Update cookie " . $newName . "=" . $newCookie["value"]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if (!$found) {
                        $this->debug("Add cookie " . $newName . "=" . $newCookie["value"]);
                        $this->cookies[] = $newCookie;
                    }
                }
            }
        }
        return true;
    }
}
if (!extension_loaded("soap")) {
    /**
     *	For backwards compatiblity, define soapclient unless the PHP SOAP extension is loaded.
     */
    class soapclient extends nusoap_client
    {
    }
}

?>