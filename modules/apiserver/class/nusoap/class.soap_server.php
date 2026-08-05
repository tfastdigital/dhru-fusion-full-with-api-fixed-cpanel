<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
*
* nusoap_server allows the user to create a SOAP server
* that is capable of receiving messages and returning responses
*
* @author   Dietrich Ayala <dietrich@ganx4.com>
* @author   Scott Nichol <snichol@users.sourceforge.net>
* @version  $Id: class.soap_server.php,v 1.63 2010/04/26 20:15:08 snichol Exp $
* @access   public
*/
class nusoap_server extends nusoap_base
{
    /**
     * HTTP headers of request
     * @var array
     * @access private
     */
    public $headers = [];
    /**
     * HTTP request
     * @var string
     * @access private
     */
    public $request = "";
    /**
     * SOAP headers from request (incomplete namespace resolution; special characters not escaped) (text)
     * @var string
     * @access public
     */
    public $requestHeaders = "";
    /**
     * SOAP Headers from request (parsed)
     * @var mixed
     * @access public
     */
    public $requestHeader = NULL;
    /**
     * SOAP body request portion (incomplete namespace resolution; special characters not escaped) (text)
     * @var string
     * @access public
     */
    public $document = "";
    /**
     * SOAP payload for request (text)
     * @var string
     * @access public
     */
    public $requestSOAP = "";
    /**
     * requested method namespace URI
     * @var string
     * @access private
     */
    public $methodURI = "";
    /**
     * name of method requested
     * @var string
     * @access private
     */
    public $methodname = "";
    /**
     * method parameters from request
     * @var array
     * @access private
     */
    public $methodparams = [];
    /**
     * SOAP Action from request
     * @var string
     * @access private
     */
    public $SOAPAction = "";
    /**
     * character set encoding of incoming (request) messages
     * @var string
     * @access public
     */
    public $xml_encoding = "";
    /**
     * toggles whether the parser decodes element content w/ utf8_decode()
     * @var boolean
     * @access public
     */
    public $decode_utf8 = true;
    /**
     * HTTP headers of response
     * @var array
     * @access public
     */
    public $outgoing_headers = [];
    /**
     * HTTP response
     * @var string
     * @access private
     */
    public $response = "";
    /**
     * SOAP headers for response (text or array of soapval or associative array)
     * @var mixed
     * @access public
     */
    public $responseHeaders = "";
    /**
     * SOAP payload for response (text)
     * @var string
     * @access private
     */
    public $responseSOAP = "";
    /**
     * method return value to place in response
     * @var mixed
     * @access private
     */
    public $methodreturn = false;
    /**
     * whether $methodreturn is a string of literal XML
     * @var boolean
     * @access public
     */
    public $methodreturnisliteralxml = false;
    /**
     * SOAP fault for response (or false)
     * @var mixed
     * @access private
     */
    public $fault = false;
    /**
     * text indication of result (for debugging)
     * @var string
     * @access private
     */
    public $result = "successful";
    /**
     * assoc array of operations => opData; operations are added by the register()
     * method or by parsing an external WSDL definition
     * @var array
     * @access private
     */
    public $operations = [];
    /**
     * wsdl instance (if one)
     * @var mixed
     * @access private
     */
    public $wsdl = false;
    /**
     * URL for WSDL (if one)
     * @var mixed
     * @access private
     */
    public $externalWSDLURL = false;
    /**
     * whether to append debug to response as XML comment
     * @var boolean
     * @access public
     */
    public $debug_flag = false;
    public function nusoap_server($wsdl = false)
    {
        parent::nusoap_base();
        global $debug;
        global $HTTP_SERVER_VARS;
        if (isset($_SERVER)) {
            $this->debug("_SERVER is defined:");
            $this->appendDebug($this->varDump($_SERVER));
        } else {
            if (isset($HTTP_SERVER_VARS)) {
                $this->debug("HTTP_SERVER_VARS is defined:");
                $this->appendDebug($this->varDump($HTTP_SERVER_VARS));
            } else {
                $this->debug("Neither _SERVER nor HTTP_SERVER_VARS is defined.");
            }
        }
        if (isset($debug)) {
            $this->debug("In nusoap_server, set debug_flag=" . $debug . " based on global flag");
            $this->debug_flag = $debug;
        } else {
            if (isset($_SERVER["QUERY_STRING"])) {
                $qs = explode("&", $_SERVER["QUERY_STRING"]);
                foreach ($qs as $v) {
                    if (substr($v, 0, 6) == "debug=") {
                        $this->debug("In nusoap_server, set debug_flag=" . substr($v, 6) . " based on query string #1");
                        $this->debug_flag = substr($v, 6);
                    }
                }
            } else {
                if (isset($HTTP_SERVER_VARS["QUERY_STRING"])) {
                    $qs = explode("&", $HTTP_SERVER_VARS["QUERY_STRING"]);
                    foreach ($qs as $v) {
                        if (substr($v, 0, 6) == "debug=") {
                            $this->debug("In nusoap_server, set debug_flag=" . substr($v, 6) . " based on query string #2");
                            $this->debug_flag = substr($v, 6);
                        }
                    }
                }
            }
        }
        if ($wsdl) {
            $this->debug("In nusoap_server, WSDL is specified");
            if (is_object($wsdl) && get_class($wsdl) == "wsdl") {
                $this->wsdl = $wsdl;
                $this->externalWSDLURL = $this->wsdl->wsdl;
                $this->debug("Use existing wsdl instance from " . $this->externalWSDLURL);
            } else {
                $this->debug("Create wsdl from " . $wsdl);
                $this->wsdl = new wsdl($wsdl);
                $this->externalWSDLURL = $wsdl;
            }
            $this->appendDebug($this->wsdl->getDebug());
            $this->wsdl->clearDebug();
            if ($err = $this->wsdl->getError()) {
                exit("WSDL ERROR: " . $err);
            }
        }
    }
    public function service($data)
    {
        global $HTTP_SERVER_VARS;
        if (isset($_SERVER["REQUEST_METHOD"])) {
            $rm = $_SERVER["REQUEST_METHOD"];
        } else {
            if (isset($HTTP_SERVER_VARS["REQUEST_METHOD"])) {
                $rm = $HTTP_SERVER_VARS["REQUEST_METHOD"];
            } else {
                $rm = "";
            }
        }
        if (isset($_SERVER["QUERY_STRING"])) {
            $qs = $_SERVER["QUERY_STRING"];
        } else {
            if (isset($HTTP_SERVER_VARS["QUERY_STRING"])) {
                $qs = $HTTP_SERVER_VARS["QUERY_STRING"];
            } else {
                $qs = "";
            }
        }
        $this->debug("In service, request method=" . $rm . " query string=" . $qs . " strlen(\$data)=" . strlen($data));
        if ($rm == "POST") {
            $this->debug("In service, invoke the request");
            $this->parse_request($data);
            if (!$this->fault) {
                $this->invoke_method();
            }
            if (!$this->fault) {
                $this->serialize_return();
            }
            $this->send_response();
        } else {
            if (preg_match("/wsdl/", $qs)) {
                $this->debug("In service, this is a request for WSDL");
                if ($this->externalWSDLURL) {
                    if (strpos($this->externalWSDLURL, "http://") !== false) {
                        $this->debug("In service, re-direct for WSDL");
                        header("Location: " . $this->externalWSDLURL);
                    } else {
                        $this->debug("In service, use file passthru for WSDL");
                        header("Content-Type: text/xml\r\n");
                        $pos = strpos($this->externalWSDLURL, "file://");
                        if ($pos === false) {
                            $filename = $this->externalWSDLURL;
                        } else {
                            $filename = substr($this->externalWSDLURL, $pos + 7);
                        }
                        $fp = fopen($this->externalWSDLURL, "r");
                        fpassthru($fp);
                    }
                } else {
                    if ($this->wsdl) {
                        $this->debug("In service, serialize WSDL");
                        header("Content-Type: text/xml; charset=ISO-8859-1\r\n");
                        echo $this->wsdl->serialize($this->debug_flag);
                        if ($this->debug_flag) {
                            $this->debug("wsdl:");
                            $this->appendDebug($this->varDump($this->wsdl));
                            echo $this->getDebugAsXMLComment();
                        }
                    } else {
                        $this->debug("In service, there is no WSDL");
                        header("Content-Type: text/html; charset=ISO-8859-1\r\n");
                        echo "This service does not provide WSDL";
                    }
                }
            } else {
                if ($this->wsdl) {
                    $this->debug("In service, return Web description");
                    echo $this->wsdl->webDescription();
                } else {
                    $this->debug("In service, no Web description");
                    header("Content-Type: text/html; charset=ISO-8859-1\r\n");
                    echo "This service does not provide a Web description";
                }
            }
        }
    }
    public function parse_http_headers()
    {
        global $HTTP_SERVER_VARS;
        $this->request = "";
        $this->SOAPAction = "";
        if (function_exists("getallheaders")) {
            $this->debug("In parse_http_headers, use getallheaders");
            $headers = getallheaders();
            foreach ($headers as $k => $v) {
                $k = strtolower($k);
                $this->headers[$k] = $v;
                $this->request .= $k . ": " . $v . "\r\n";
                $this->debug($k . ": " . $v);
            }
            if (isset($this->headers["soapaction"])) {
                $this->SOAPAction = str_replace("\"", "", $this->headers["soapaction"]);
            }
            if (isset($this->headers["content-type"]) && strpos($this->headers["content-type"], "=")) {
                $enc = str_replace("\"", "", substr(strstr($this->headers["content-type"], "="), 1));
                if (preg_match("/^(ISO-8859-1|US-ASCII|UTF-8)\$/i", $enc)) {
                    $this->xml_encoding = strtoupper($enc);
                } else {
                    $this->xml_encoding = "US-ASCII";
                }
            } else {
                $this->xml_encoding = "ISO-8859-1";
            }
        } else {
            if (isset($_SERVER) && is_array($_SERVER)) {
                $this->debug("In parse_http_headers, use _SERVER");
                foreach ($_SERVER as $k => $v) {
                    if (substr($k, 0, 5) == "HTTP_") {
                        $k = str_replace(" ", "-", strtolower(str_replace("_", " ", substr($k, 5))));
                    } else {
                        $k = str_replace(" ", "-", strtolower(str_replace("_", " ", $k)));
                    }
                    if ($k == "soapaction") {
                        $k = "SOAPAction";
                        $v = str_replace("\"", "", $v);
                        $v = str_replace("\\", "", $v);
                        $this->SOAPAction = $v;
                    } else {
                        if ($k == "content-type") {
                            if (strpos($v, "=")) {
                                $enc = substr(strstr($v, "="), 1);
                                $enc = str_replace("\"", "", $enc);
                                $enc = str_replace("\\", "", $enc);
                                if (preg_match("/^(ISO-8859-1|US-ASCII|UTF-8)\$/i", $enc)) {
                                    $this->xml_encoding = strtoupper($enc);
                                } else {
                                    $this->xml_encoding = "US-ASCII";
                                }
                            } else {
                                $this->xml_encoding = "ISO-8859-1";
                            }
                        }
                    }
                    $this->headers[$k] = $v;
                    $this->request .= $k . ": " . $v . "\r\n";
                    $this->debug($k . ": " . $v);
                }
            } else {
                if (is_array($HTTP_SERVER_VARS)) {
                    $this->debug("In parse_http_headers, use HTTP_SERVER_VARS");
                    foreach ($HTTP_SERVER_VARS as $k => $v) {
                        if (substr($k, 0, 5) == "HTTP_") {
                            $k = str_replace(" ", "-", strtolower(str_replace("_", " ", substr($k, 5))));
                            $k = strtolower(substr($k, 5));
                        } else {
                            $k = str_replace(" ", "-", strtolower(str_replace("_", " ", $k)));
                            $k = strtolower($k);
                        }
                        if ($k == "soapaction") {
                            $k = "SOAPAction";
                            $v = str_replace("\"", "", $v);
                            $v = str_replace("\\", "", $v);
                            $this->SOAPAction = $v;
                        } else {
                            if ($k == "content-type") {
                                if (strpos($v, "=")) {
                                    $enc = substr(strstr($v, "="), 1);
                                    $enc = str_replace("\"", "", $enc);
                                    $enc = str_replace("\\", "", $enc);
                                    if (preg_match("/^(ISO-8859-1|US-ASCII|UTF-8)\$/i", $enc)) {
                                        $this->xml_encoding = strtoupper($enc);
                                    } else {
                                        $this->xml_encoding = "US-ASCII";
                                    }
                                } else {
                                    $this->xml_encoding = "ISO-8859-1";
                                }
                            }
                        }
                        $this->headers[$k] = $v;
                        $this->request .= $k . ": " . $v . "\r\n";
                        $this->debug($k . ": " . $v);
                    }
                } else {
                    $this->debug("In parse_http_headers, HTTP headers not accessible");
                    $this->setError("HTTP headers not accessible");
                }
            }
        }
    }
    public function parse_request($data = "")
    {
        $this->debug("entering parse_request()");
        $this->parse_http_headers();
        $this->debug("got character encoding: " . $this->xml_encoding);
        if (isset($this->headers["content-encoding"]) && $this->headers["content-encoding"] != "") {
            $this->debug("got content encoding: " . $this->headers["content-encoding"]);
            if ($this->headers["content-encoding"] == "deflate" || $this->headers["content-encoding"] == "gzip") {
                if (function_exists("gzuncompress")) {
                    if ($this->headers["content-encoding"] == "deflate" && ($degzdata = gzuncompress($data))) {
                        $data = $degzdata;
                    } else {
                        if ($this->headers["content-encoding"] == "gzip" && ($degzdata = gzinflate(substr($data, 10)))) {
                            $data = $degzdata;
                        } else {
                            $this->fault("SOAP-ENV:Client", "Errors occurred when trying to decode the data");
                            return NULL;
                        }
                    }
                } else {
                    $this->fault("SOAP-ENV:Client", "This Server does not support compressed data");
                    return NULL;
                }
            }
        }
        $this->request .= "\r\n" . $data;
        $data = $this->parseRequest($this->headers, $data);
        $this->requestSOAP = $data;
        $this->debug("leaving parse_request");
    }
    public function invoke_method()
    {
        $this->debug("in invoke_method, methodname=" . $this->methodname . " methodURI=" . $this->methodURI . " SOAPAction=" . $this->SOAPAction);
        $orig_methodname = $this->methodname;
        if ($this->wsdl) {
            if ($this->opData = $this->wsdl->getOperationData($this->methodname)) {
                $this->debug("in invoke_method, found WSDL operation=" . $this->methodname);
                $this->appendDebug("opData=" . $this->varDump($this->opData));
            } else {
                if ($this->opData = $this->wsdl->getOperationDataForSoapAction($this->SOAPAction)) {
                    $this->debug("in invoke_method, found WSDL soapAction=" . $this->SOAPAction . " for operation=" . $this->opData["name"]);
                    $this->appendDebug("opData=" . $this->varDump($this->opData));
                    $this->methodname = $this->opData["name"];
                } else {
                    $this->debug("in invoke_method, no WSDL for operation=" . $this->methodname);
                    $this->fault("SOAP-ENV:Client", "Operation '" . $this->methodname . "' is not defined in the WSDL for this service");
                    return NULL;
                }
            }
        } else {
            $this->debug("in invoke_method, no WSDL to validate method");
        }
        if (0 < strpos($this->methodname, "..")) {
            $delim = "..";
        } else {
            if (0 < strpos($this->methodname, ".")) {
                $delim = ".";
            } else {
                $delim = "";
            }
        }
        $this->debug("in invoke_method, delim=" . $delim);
        $class = "";
        $method = "";
        if (0 < strlen($delim) && substr_count($this->methodname, $delim) == 1) {
            $try_class = substr($this->methodname, 0, strpos($this->methodname, $delim));
            if (class_exists($try_class)) {
                $class = $try_class;
                $method = substr($this->methodname, strpos($this->methodname, $delim) + strlen($delim));
                $this->debug("in invoke_method, class=" . $class . " method=" . $method . " delim=" . $delim);
            } else {
                $this->debug("in invoke_method, class=" . $try_class . " not found");
            }
        } else {
            $try_class = "";
            $this->debug("in invoke_method, no class to try");
        }
        if ($class == "") {
            if (!function_exists($this->methodname)) {
                $this->debug("in invoke_method, function '" . $this->methodname . "' not found!");
                $this->result = "fault: method not found";
                $this->fault("SOAP-ENV:Client", "method '" . $this->methodname . "'('" . $orig_methodname . "') not defined in service('" . $try_class . "' '" . $delim . "')");
                return NULL;
            }
        } else {
            $method_to_compare = substr(phpversion(), 0, 2) == "4." ? strtolower($method) : $method;
            if (!in_array($method_to_compare, get_class_methods($class))) {
                $this->debug("in invoke_method, method '" . $this->methodname . "' not found in class '" . $class . "'!");
                $this->result = "fault: method not found";
                $this->fault("SOAP-ENV:Client", "method '" . $this->methodname . "'/'" . $method_to_compare . "'('" . $orig_methodname . "') not defined in service/'" . $class . "'('" . $try_class . "' '" . $delim . "')");
                return NULL;
            }
        }
        if (!$this->verify_method($this->methodname, $this->methodparams)) {
            $this->debug("ERROR: request not verified against method signature");
            $this->result = "fault: request failed validation against method signature";
            $this->fault("SOAP-ENV:Client", "Operation '" . $this->methodname . "' not defined in service.");
        } else {
            $this->debug("in invoke_method, params:");
            $this->appendDebug($this->varDump($this->methodparams));
            $this->debug("in invoke_method, calling '" . $this->methodname . "'");
            if (!function_exists("call_user_func_array")) {
                if ($class == "") {
                    $this->debug("in invoke_method, calling function using eval()");
                    $funcCall = "\$this->methodreturn = " . $this->methodname . "(";
                } else {
                    if ($delim == "..") {
                        $this->debug("in invoke_method, calling class method using eval()");
                        $funcCall = "\$this->methodreturn = " . $class . "::" . $method . "(";
                    } else {
                        $this->debug("in invoke_method, calling instance method using eval()");
                        $instname = "\$inst_" . time();
                        $funcCall = $instname . " = new " . $class . "(); ";
                        $funcCall .= "\$this->methodreturn = " . $instname . "->" . $method . "(";
                    }
                }
                if ($this->methodparams) {
                    foreach ($this->methodparams as $param) {
                        if (is_array($param) || is_object($param)) {
                            $this->fault("SOAP-ENV:Client", "NuSOAP does not handle complexType parameters correctly when using eval; call_user_func_array must be available");
                            return NULL;
                        }
                        $funcCall .= "\"" . $param . "\",";
                    }
                    $funcCall = substr($funcCall, 0, -1);
                }
                $funcCall .= ");";
                $this->debug("in invoke_method, function call: " . $funcCall);
                eval($funcCall);
            } else {
                if ($class == "") {
                    $this->debug("in invoke_method, calling function using call_user_func_array()");
                    $call_arg = (string) $this->methodname;
                } else {
                    if ($delim == "..") {
                        $this->debug("in invoke_method, calling class method using call_user_func_array()");
                        $call_arg = [$class, $method];
                    } else {
                        $this->debug("in invoke_method, calling instance method using call_user_func_array()");
                        $instance = new $class();
                        $call_arg = [$instance, $method];
                    }
                }
                if (is_array($this->methodparams)) {
                    $this->methodreturn = call_user_func_array($call_arg, array_values($this->methodparams));
                } else {
                    $this->methodreturn = call_user_func_array($call_arg, []);
                }
            }
            $this->debug("in invoke_method, methodreturn:");
            $this->appendDebug($this->varDump($this->methodreturn));
            $this->debug("in invoke_method, called method " . $this->methodname . ", received data of type " . gettype($this->methodreturn));
        }
    }
    public function serialize_return()
    {
        $this->debug("Entering serialize_return methodname: " . $this->methodname . " methodURI: " . $this->methodURI);
        if (isset($this->methodreturn) && is_object($this->methodreturn) && (get_class($this->methodreturn) == "soap_fault" || get_class($this->methodreturn) == "nusoap_fault")) {
            $this->debug("got a fault object from method");
            $this->fault = $this->methodreturn;
        } else {
            if ($this->methodreturnisliteralxml) {
                $return_val = $this->methodreturn;
            } else {
                $this->debug("got a(n) " . gettype($this->methodreturn) . " from method");
                $this->debug("serializing return value");
                if ($this->wsdl) {
                    if (1 < sizeof($this->opData["output"]["parts"])) {
                        $this->debug("more than one output part, so use the method return unchanged");
                        $opParams = $this->methodreturn;
                    } else {
                        if (sizeof($this->opData["output"]["parts"]) == 1) {
                            $this->debug("exactly one output part, so wrap the method return in a simple array");
                            $opParams = [$this->methodreturn];
                        }
                    }
                    $return_val = $this->wsdl->serializeRPCParameters($this->methodname, "output", $opParams);
                    $this->appendDebug($this->wsdl->getDebug());
                    $this->wsdl->clearDebug();
                    if ($errstr = $this->wsdl->getError()) {
                        $this->debug("got wsdl error: " . $errstr);
                        $this->fault("SOAP-ENV:Server", "unable to serialize result");
                        return NULL;
                    }
                } else {
                    if (isset($this->methodreturn)) {
                        $return_val = $this->serialize_val($this->methodreturn, "return");
                    } else {
                        $return_val = "";
                        $this->debug("in absence of WSDL, assume void return for backward compatibility");
                    }
                }
            }
            $this->debug("return value:");
            $this->appendDebug($this->varDump($return_val));
            $this->debug("serializing response");
            if ($this->wsdl) {
                $this->debug("have WSDL for serialization: style is " . $this->opData["style"]);
                if ($this->opData["style"] == "rpc") {
                    $this->debug("style is rpc for serialization: use is " . $this->opData["output"]["use"]);
                    if ($this->opData["output"]["use"] == "literal") {
                        if ($this->methodURI) {
                            $payload = "<ns1:" . $this->methodname . "Response xmlns:ns1=\"" . $this->methodURI . "\">" . $return_val . "</ns1:" . $this->methodname . "Response>";
                        } else {
                            $payload = "<" . $this->methodname . "Response>" . $return_val . "</" . $this->methodname . "Response>";
                        }
                    } else {
                        if ($this->methodURI) {
                            $payload = "<ns1:" . $this->methodname . "Response xmlns:ns1=\"" . $this->methodURI . "\">" . $return_val . "</ns1:" . $this->methodname . "Response>";
                        } else {
                            $payload = "<" . $this->methodname . "Response>" . $return_val . "</" . $this->methodname . "Response>";
                        }
                    }
                } else {
                    $this->debug("style is not rpc for serialization: assume document");
                    $payload = $return_val;
                }
            } else {
                $this->debug("do not have WSDL for serialization: assume rpc/encoded");
                $payload = "<ns1:" . $this->methodname . "Response xmlns:ns1=\"" . $this->methodURI . "\">" . $return_val . "</ns1:" . $this->methodname . "Response>";
            }
            $this->result = "successful";
            if ($this->wsdl) {
                $this->appendDebug($this->wsdl->getDebug());
                if (isset($this->opData["output"]["encodingStyle"])) {
                    $encodingStyle = $this->opData["output"]["encodingStyle"];
                } else {
                    $encodingStyle = "";
                }
                $this->responseSOAP = $this->serializeEnvelope($payload, $this->responseHeaders, $this->wsdl->usedNamespaces, $this->opData["style"], $this->opData["output"]["use"], $encodingStyle);
            } else {
                $this->responseSOAP = $this->serializeEnvelope($payload, $this->responseHeaders);
            }
            $this->debug("Leaving serialize_return");
        }
    }
    public function send_response()
    {
        $this->debug("Enter send_response");
        if ($this->fault) {
            $payload = $this->fault->serialize();
            $this->outgoing_headers[] = "HTTP/1.0 500 Internal Server Error";
            $this->outgoing_headers[] = "Status: 500 Internal Server Error";
        } else {
            $payload = $this->responseSOAP;
        }
        if (isset($this->debug_flag) && $this->debug_flag) {
            $payload .= $this->getDebugAsXMLComment();
        }
        $this->outgoing_headers[] = "Server: " . $this->title . " Server v" . $this->version;
        preg_match("/\\\$Revision: ([^ ]+)/", $this->revision, $rev);
        $this->outgoing_headers[] = "X-SOAP-Server: " . $this->title . "/" . $this->version . " (" . $rev[1] . ")";
        $payload = $this->getHTTPBody($payload);
        $type = $this->getHTTPContentType();
        $charset = $this->getHTTPContentTypeCharset();
        $this->outgoing_headers[] = "Content-Type: " . $type . ($charset ? "; charset=" . $charset : "");
        if (1024 < strlen($payload) && isset($this->headers) && isset($this->headers["accept-encoding"])) {
            if (strstr($this->headers["accept-encoding"], "gzip")) {
                if (function_exists("gzencode")) {
                    if (isset($this->debug_flag) && $this->debug_flag) {
                        $payload .= "<!-- Content being gzipped -->";
                    }
                    $this->outgoing_headers[] = "Content-Encoding: gzip";
                    $payload = gzencode($payload);
                } else {
                    if (isset($this->debug_flag) && $this->debug_flag) {
                        $payload .= "<!-- Content will not be gzipped: no gzencode -->";
                    }
                }
            } else {
                if (strstr($this->headers["accept-encoding"], "deflate")) {
                    if (function_exists("gzdeflate")) {
                        if (isset($this->debug_flag) && $this->debug_flag) {
                            $payload .= "<!-- Content being deflated -->";
                        }
                        $this->outgoing_headers[] = "Content-Encoding: deflate";
                        $payload = gzdeflate($payload);
                    } else {
                        if (isset($this->debug_flag) && $this->debug_flag) {
                            $payload .= "<!-- Content will not be deflated: no gzcompress -->";
                        }
                    }
                }
            }
        }
        $this->outgoing_headers[] = "Content-Length: " . strlen($payload);
        reset($this->outgoing_headers);
        foreach ($this->outgoing_headers as $hdr) {
            header($hdr, false);
        }
        echo $payload;
        $this->response = join("\r\n", $this->outgoing_headers) . "\r\n\r\n" . $payload;
    }
    public function verify_method($operation, $request)
    {
        if (isset($this->wsdl) && is_object($this->wsdl)) {
            if ($this->wsdl->getOperationData($operation)) {
                return true;
            }
        } else {
            if (isset($this->operations[$operation])) {
                return true;
            }
        }
        return false;
    }
    public function parseRequest($headers, $data)
    {
        $this->debug("Entering parseRequest() for data of length " . strlen($data) . " headers:");
        $this->appendDebug($this->varDump($headers));
        if (!isset($headers["content-type"])) {
            $this->setError("Request not of type text/xml (no content-type header)");
            return false;
        }
        if (!strstr($headers["content-type"], "text/xml")) {
            $this->setError("Request not of type text/xml");
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
        $parser = new nusoap_parser($data, $this->xml_encoding, "", $this->decode_utf8);
        $this->debug("parser debug: \n" . $parser->getDebug());
        if ($err = $parser->getError()) {
            $this->result = "fault: error in msg parsing: " . $err;
            $this->fault("SOAP-ENV:Client", "error in msg parsing:\n" . $err);
        } else {
            $this->methodURI = $parser->root_struct_namespace;
            $this->methodname = $parser->root_struct_name;
            $this->debug("methodname: " . $this->methodname . " methodURI: " . $this->methodURI);
            $this->debug("calling parser->get_soapbody()");
            $this->methodparams = $parser->get_soapbody();
            $this->requestHeaders = $parser->getHeaders();
            $this->requestHeader = $parser->get_soapheader();
            $this->document = $parser->document;
        }
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
    public function add_to_map($methodname, $in, $out)
    {
        $this->operations[$methodname] = ["name" => $methodname, "in" => $in, "out" => $out];
    }
    public function register($name, $in = [], $out = [], $namespace = false, $soapaction = false, $style = false, $use = false, $documentation = "", $encodingStyle = "")
    {
        global $HTTP_SERVER_VARS;
        if ($this->externalWSDLURL) {
            exit("You cannot bind to an external WSDL file, and register methods outside of it! Please choose either WSDL or no WSDL.");
        }
        if (!$name) {
            exit("You must specify a name when you register an operation");
        }
        if (!is_array($in)) {
            exit("You must provide an array for operation inputs");
        }
        if (!is_array($out)) {
            exit("You must provide an array for operation outputs");
        }
        if (!$namespace) {
        }
        if (!$soapaction) {
            if (isset($_SERVER)) {
                $SERVER_NAME = $_SERVER["SERVER_NAME"];
                $SCRIPT_NAME = isset($_SERVER["PHP_SELF"]) ? $_SERVER["PHP_SELF"] : $_SERVER["SCRIPT_NAME"];
                $HTTPS = isset($_SERVER["HTTPS"]) ? $_SERVER["HTTPS"] : (isset($HTTP_SERVER_VARS["HTTPS"]) ? $HTTP_SERVER_VARS["HTTPS"] : "off");
            } else {
                if (isset($HTTP_SERVER_VARS)) {
                    $SERVER_NAME = $HTTP_SERVER_VARS["SERVER_NAME"];
                    $SCRIPT_NAME = isset($HTTP_SERVER_VARS["PHP_SELF"]) ? $HTTP_SERVER_VARS["PHP_SELF"] : $HTTP_SERVER_VARS["SCRIPT_NAME"];
                    $HTTPS = isset($HTTP_SERVER_VARS["HTTPS"]) ? $HTTP_SERVER_VARS["HTTPS"] : "off";
                } else {
                    $this->setError("Neither _SERVER nor HTTP_SERVER_VARS is available");
                }
            }
            if ($HTTPS == "1" || $HTTPS == "on") {
                $SCHEME = "https";
            } else {
                $SCHEME = "http";
            }
            $soapaction = $SCHEME . "://" . $SERVER_NAME . $SCRIPT_NAME . "/" . $name;
        }
        if (!$style) {
            $style = "rpc";
        }
        if (!$use) {
            $use = "encoded";
        }
        if ($use == "encoded" && $encodingStyle == "") {
            $encodingStyle = "http://schemas.xmlsoap.org/soap/encoding/";
        }
        $this->operations[$name] = ["name" => $name, "in" => $in, "out" => $out, "namespace" => $namespace, "soapaction" => $soapaction, "style" => $style];
        if ($this->wsdl) {
            $this->wsdl->addOperation($name, $in, $out, $namespace, $soapaction, $style, $use, $documentation, $encodingStyle);
        }
        return true;
    }
    public function fault($faultcode, $faultstring, $faultactor = "", $faultdetail = "")
    {
        if ($faultdetail == "" && $this->debug_flag) {
            $faultdetail = $this->getDebug();
        }
        $this->fault = new nusoap_fault($faultcode, $faultactor, $faultstring, $faultdetail);
        $this->fault->soap_defencoding = $this->soap_defencoding;
    }
    public function configureWSDL($serviceName, $namespace = false, $endpoint = false, $style = "rpc", $transport = "http://schemas.xmlsoap.org/soap/http", $schemaTargetNamespace = false)
    {
        global $HTTP_SERVER_VARS;
        if (isset($_SERVER)) {
            $SERVER_NAME = $_SERVER["SERVER_NAME"];
            $SERVER_PORT = $_SERVER["SERVER_PORT"];
            $SCRIPT_NAME = isset($_SERVER["PHP_SELF"]) ? $_SERVER["PHP_SELF"] : $_SERVER["SCRIPT_NAME"];
            $HTTPS = isset($_SERVER["HTTPS"]) ? $_SERVER["HTTPS"] : (isset($HTTP_SERVER_VARS["HTTPS"]) ? $HTTP_SERVER_VARS["HTTPS"] : "off");
        } else {
            if (isset($HTTP_SERVER_VARS)) {
                $SERVER_NAME = $HTTP_SERVER_VARS["SERVER_NAME"];
                $SERVER_PORT = $HTTP_SERVER_VARS["SERVER_PORT"];
                $SCRIPT_NAME = isset($HTTP_SERVER_VARS["PHP_SELF"]) ? $HTTP_SERVER_VARS["PHP_SELF"] : $HTTP_SERVER_VARS["SCRIPT_NAME"];
                $HTTPS = isset($HTTP_SERVER_VARS["HTTPS"]) ? $HTTP_SERVER_VARS["HTTPS"] : "off";
            } else {
                $this->setError("Neither _SERVER nor HTTP_SERVER_VARS is available");
            }
        }
        $colon = strpos($SERVER_NAME, ":");
        if ($colon) {
            $SERVER_NAME = substr($SERVER_NAME, 0, $colon);
        }
        if ($SERVER_PORT == 80) {
            $SERVER_PORT = "";
        } else {
            $SERVER_PORT = ":" . $SERVER_PORT;
        }
        if (!$namespace) {
            $namespace = "http://" . $SERVER_NAME . "/soap/" . $serviceName;
        }
        if (!$endpoint) {
            if ($HTTPS == "1" || $HTTPS == "on") {
                $SCHEME = "https";
            } else {
                $SCHEME = "http";
            }
            $endpoint = $SCHEME . "://" . $SERVER_NAME . $SERVER_PORT . $SCRIPT_NAME;
        }
        if (!$schemaTargetNamespace) {
            $schemaTargetNamespace = $namespace;
        }
        $this->wsdl = new wsdl();
        $this->wsdl->serviceName = $serviceName;
        $this->wsdl->endpoint = $endpoint;
        $this->wsdl->namespaces["tns"] = $namespace;
        $this->wsdl->namespaces["soap"] = "http://schemas.xmlsoap.org/wsdl/soap/";
        $this->wsdl->namespaces["wsdl"] = "http://schemas.xmlsoap.org/wsdl/";
        if ($schemaTargetNamespace != $namespace) {
            $this->wsdl->namespaces["types"] = $schemaTargetNamespace;
        }
        $this->wsdl->schemas[$schemaTargetNamespace][0] = new nusoap_xmlschema("", "", $this->wsdl->namespaces);
        if ($style == "document") {
            $this->wsdl->schemas[$schemaTargetNamespace][0]->schemaInfo["elementFormDefault"] = "qualified";
        }
        $this->wsdl->schemas[$schemaTargetNamespace][0]->schemaTargetNamespace = $schemaTargetNamespace;
        $this->wsdl->schemas[$schemaTargetNamespace][0]->imports["http://schemas.xmlsoap.org/soap/encoding/"][0] = ["location" => "", "loaded" => true];
        $this->wsdl->schemas[$schemaTargetNamespace][0]->imports["http://schemas.xmlsoap.org/wsdl/"][0] = ["location" => "", "loaded" => true];
        $this->wsdl->bindings[$serviceName . "Binding"] = ["name" => $serviceName . "Binding", "style" => $style, "transport" => $transport, "portType" => $serviceName . "PortType"];
        $this->wsdl->ports[$serviceName . "Port"] = ["binding" => $serviceName . "Binding", "location" => $endpoint, "bindingType" => "http://schemas.xmlsoap.org/wsdl/soap/"];
    }
}
/**
 * Backward compatibility
 */
class soap_server extends nusoap_server
{
}

?>