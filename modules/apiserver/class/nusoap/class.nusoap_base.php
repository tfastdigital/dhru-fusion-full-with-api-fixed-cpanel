<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$GLOBALS["_transient"]["static"]["nusoap_base"]["globalDebugLevel"] = 9;
/**
*
* nusoap_base
*
* @author   Dietrich Ayala <dietrich@ganx4.com>
* @author   Scott Nichol <snichol@users.sourceforge.net>
* @version  $Id: class.nusoap_base.php,v 1.56 2010/04/26 20:15:08 snichol Exp $
* @access   public
*/
class nusoap_base
{
    /**
     * Identification for HTTP headers.
     *
     * @var string
     * @access private
     */
    public $title = "NuSOAP";
    /**
     * Version for HTTP headers.
     *
     * @var string
     * @access private
     */
    public $version = "0.9.5";
    /**
     * CVS revision for HTTP headers.
     *
     * @var string
     * @access private
     */
    public $revision = "\$Revision: 1.56 \$";
    /**
     * Current error string (manipulated by getError/setError)
     *
     * @var string
     * @access private
     */
    public $error_str = "";
    /**
     * Current debug string (manipulated by debug/appendDebug/clearDebug/getDebug/getDebugAsXMLComment)
     *
     * @var string
     * @access private
     */
    public $debug_str = "";
    /**
     * toggles automatic encoding of special characters as entities
     * (should always be true, I think)
     *
     * @var boolean
     * @access private
     */
    public $charencoding = true;
    /**
     * the debug level for this instance
     *
     * @var	integer
     * @access private
     */
    public $debugLevel = NULL;
    /**
     * set schema version
     *
     * @var      string
     * @access   public
     */
    public $XMLSchemaVersion = "http://www.w3.org/2001/XMLSchema";
    /**
     * charset encoding for outgoing messages
     *
     * @var      string
     * @access   public
     */
    public $soap_defencoding = "ISO-8859-1";
    /**
     * namespaces in an array of prefix => uri
     *
     * this is "seeded" by a set of constants, but it may be altered by code
     *
     * @var      array
     * @access   public
     */
    public $namespaces = ["SOAP-ENV" => "http://schemas.xmlsoap.org/soap/envelope/", "xsd" => "http://www.w3.org/2001/XMLSchema", "xsi" => "http://www.w3.org/2001/XMLSchema-instance", "SOAP-ENC" => "http://schemas.xmlsoap.org/soap/encoding/"];
    /**
     * namespaces used in the current context, e.g. during serialization
     *
     * @var      array
     * @access   private
     */
    public $usedNamespaces = [];
    /**
     * XML Schema types in an array of uri => (array of xml type => php type)
     * is this legacy yet?
     * no, this is used by the nusoap_xmlschema class to verify type => namespace mappings.
     * @var      array
     * @access   public
     */
    public $typemap = ["http://www.w3.org/2001/XMLSchema" => ["string" => "string", "boolean" => "boolean", "float" => "double", "double" => "double", "decimal" => "double", "duration" => "", "dateTime" => "string", "time" => "string", "date" => "string", "gYearMonth" => "", "gYear" => "", "gMonthDay" => "", "gDay" => "", "gMonth" => "", "hexBinary" => "string", "base64Binary" => "string", "anyType" => "string", "anySimpleType" => "string", "normalizedString" => "string", "token" => "string", "language" => "", "NMTOKEN" => "", "NMTOKENS" => "", "Name" => "", "NCName" => "", "ID" => "", "IDREF" => "", "IDREFS" => "", "ENTITY" => "", "ENTITIES" => "", "integer" => "integer", "nonPositiveInteger" => "integer", "negativeInteger" => "integer", "long" => "integer", "int" => "integer", "short" => "integer", "byte" => "integer", "nonNegativeInteger" => "integer", "unsignedLong" => "", "unsignedInt" => "", "unsignedShort" => "", "unsignedByte" => "", "positiveInteger" => ""], "http://www.w3.org/2000/10/XMLSchema" => ["i4" => "", "int" => "integer", "boolean" => "boolean", "string" => "string", "double" => "double", "float" => "double", "dateTime" => "string", "timeInstant" => "string", "base64Binary" => "string", "base64" => "string", "ur-type" => "array"], "http://www.w3.org/1999/XMLSchema" => ["i4" => "", "int" => "integer", "boolean" => "boolean", "string" => "string", "double" => "double", "float" => "double", "dateTime" => "string", "timeInstant" => "string", "base64Binary" => "string", "base64" => "string", "ur-type" => "array"], "http://soapinterop.org/xsd" => ["SOAPStruct" => "struct"], "http://schemas.xmlsoap.org/soap/encoding/" => ["base64" => "string", "array" => "array", "Array" => "array"], "http://xml.apache.org/xml-soap" => ["Map"]];
    /**
     * XML entities to convert
     *
     * @var      array
     * @access   public
     * @deprecated
     * @see	expandEntities
     */
    public $xmlEntities = ["quot" => "\"", "amp" => "&", "lt" => "<", "gt" => ">", "apos" => "'"];
    public function nusoap_base()
    {
        $this->debugLevel = $GLOBALS["_transient"]["static"]["nusoap_base"]["globalDebugLevel"];
    }
    public function getGlobalDebugLevel()
    {
        return $GLOBALS["_transient"]["static"]["nusoap_base"]["globalDebugLevel"];
    }
    public function setGlobalDebugLevel($level)
    {
        $GLOBALS["_transient"]["static"]["nusoap_base"]["globalDebugLevel"] = $level;
    }
    public function getDebugLevel()
    {
        return $this->debugLevel;
    }
    public function setDebugLevel($level)
    {
        $this->debugLevel = $level;
    }
    public function debug($string)
    {
        if (0 < $this->debugLevel) {
            $this->appendDebug($this->getmicrotime() . " " . get_class($this) . ": " . $string . "\n");
        }
    }
    public function appendDebug($string)
    {
        if (0 < $this->debugLevel) {
            $this->debug_str .= $string;
        }
    }
    public function clearDebug()
    {
        $this->debug_str = "";
    }
    public function &getDebug()
    {
        return $this->debug_str;
    }
    public function &getDebugAsXMLComment()
    {
        while (strpos($this->debug_str, "--")) {
            $this->debug_str = str_replace("--", "- -", $this->debug_str);
        }
        $ret = "<!--\n" . $this->debug_str . "\n-->";
        return $ret;
    }
    public function expandEntities($val)
    {
        if ($this->charencoding) {
            $val = str_replace("&", "&amp;", $val);
            $val = str_replace("'", "&apos;", $val);
            $val = str_replace("\"", "&quot;", $val);
            $val = str_replace("<", "&lt;", $val);
            $val = str_replace(">", "&gt;", $val);
        }
        return $val;
    }
    public function getError()
    {
        if ($this->error_str != "") {
            return $this->error_str;
        }
        return false;
    }
    public function setError($str)
    {
        $this->error_str = $str;
    }
    public function isArraySimpleOrStruct($val)
    {
        $keyList = array_keys($val);
        foreach ($keyList as $keyListValue) {
            if (!is_int($keyListValue)) {
                return "arrayStruct";
            }
        }
        return "arraySimple";
    }
    public function serialize_val($val, $name = false, $type = false, $name_ns = false, $type_ns = false, $attributes = false, $use = "encoded", $soapval = false)
    {
        $this->debug("in serialize_val: name=" . $name . ", type=" . $type . ", name_ns=" . $name_ns . ", type_ns=" . $type_ns . ", use=" . $use . ", soapval=" . $soapval);
        $this->appendDebug("value=" . $this->varDump($val));
        $this->appendDebug("attributes=" . $this->varDump($attributes));
        if (is_object($val) && get_class($val) == "soapval" && !$soapval) {
            $this->debug("serialize_val: serialize soapval");
            $xml = $val->serialize($use);
            $this->appendDebug($val->getDebug());
            $val->clearDebug();
            $this->debug("serialize_val of soapval returning " . $xml);
            return $xml;
        }
        if (is_numeric($name)) {
            $name = "__numeric_" . $name;
        } else {
            if (!$name) {
                $name = "noname";
            }
        }
        $xmlns = "";
        if ($name_ns) {
            $prefix = "nu" . rand(1000, 9999);
            $name = $prefix . ":" . $name;
            $xmlns .= " xmlns:" . $prefix . "=\"" . $name_ns . "\"";
        }
        if ($type_ns != "" && $type_ns == $this->namespaces["xsd"]) {
            $type_prefix = "xsd";
        } else {
            if ($type_ns) {
                $type_prefix = "ns" . rand(1000, 9999);
                $xmlns .= " xmlns:" . $type_prefix . "=\"" . $type_ns . "\"";
            }
        }
        $atts = "";
        if ($attributes) {
            foreach ($attributes as $k => $v) {
                $atts .= " " . $k . "=\"" . $this->expandEntities($v) . "\"";
            }
        }
        if (is_null($val)) {
            $this->debug("serialize_val: serialize null");
            if ($use == "literal") {
                $xml = "<" . $name . $xmlns . $atts . "/>";
                $this->debug("serialize_val returning " . $xml);
                return $xml;
            }
            if (isset($type) && isset($type_prefix)) {
                $type_str = " xsi:type=\"" . $type_prefix . ":" . $type . "\"";
            } else {
                $type_str = "";
            }
            $xml = "<" . $name . $xmlns . $type_str . $atts . " xsi:nil=\"true\"/>";
            $this->debug("serialize_val returning " . $xml);
            return $xml;
        }
        if ($type != "" && isset($this->typemap[$this->XMLSchemaVersion][$type])) {
            $this->debug("serialize_val: serialize xsd built-in primitive type");
            if (is_bool($val)) {
                if ($type == "boolean") {
                    $val = $val ? "true" : "false";
                } else {
                    if (!$val) {
                        $val = 0;
                    }
                }
            } else {
                if (is_string($val)) {
                    $val = $this->expandEntities($val);
                }
            }
            if ($use == "literal") {
                $xml = "<" . $name . $xmlns . $atts . ">" . $val . "</" . $name . ">";
                $this->debug("serialize_val returning " . $xml);
                return $xml;
            }
            $xml = "<" . $name . $xmlns . " xsi:type=\"xsd:" . $type . "\"" . $atts . ">" . $val . "</" . $name . ">";
            $this->debug("serialize_val returning " . $xml);
            return $xml;
        }
        $xml = "";
        if (is_bool($val) || $type == "boolean") {
            if (is_int($val) || is_long($val) || $type == "int") {
                if (is_float($val) || is_double($val) || $type == "float") {
                    if (is_string($val) || $type == "string") {
                        if (is_object($val)) {
                            if (is_array($val) || $type) {
                                $this->debug("serialize_val: serialize unknown");
                                $xml .= "not detected, got " . gettype($val) . " for " . $val;
                            } else {
                                $valueType = $this->isArraySimpleOrStruct($val);
                                if ($valueType == "arraySimple" || preg_match("/^ArrayOf/", $type)) {
                                    $this->debug("serialize_val: serialize array");
                                    $i = 0;
                                    if (is_array($val) && 0 < count($val)) {
                                        foreach ($val as $v) {
                                            if (is_object($v) && get_class($v) == "soapval") {
                                                $tt_ns = $v->type_ns;
                                                $tt = $v->type;
                                            } else {
                                                if (is_array($v)) {
                                                    $tt = $this->isArraySimpleOrStruct($v);
                                                } else {
                                                    $tt = gettype($v);
                                                }
                                            }
                                            $array_types[$tt] = 1;
                                            $xml .= $this->serialize_val($v, "item", false, false, false, false, $use);
                                            $i++;
                                        }
                                        if (1 < count($array_types)) {
                                            $array_typename = "xsd:anyType";
                                        } else {
                                            if (isset($tt) && isset($this->typemap[$this->XMLSchemaVersion][$tt])) {
                                                if ($tt == "integer") {
                                                    $tt = "int";
                                                }
                                                $array_typename = "xsd:" . $tt;
                                            } else {
                                                if (isset($tt) && $tt == "arraySimple") {
                                                    $array_typename = "SOAP-ENC:Array";
                                                } else {
                                                    if (isset($tt) && $tt == "arrayStruct") {
                                                        $array_typename = "unnamed_struct_use_soapval";
                                                    } else {
                                                        if ($tt_ns != "" && $tt_ns == $this->namespaces["xsd"]) {
                                                            $array_typename = "xsd:" . $tt;
                                                        } else {
                                                            if ($tt_ns) {
                                                                $tt_prefix = "ns" . rand(1000, 9999);
                                                                $array_typename = $tt_prefix . ":" . $tt;
                                                                $xmlns .= " xmlns:" . $tt_prefix . "=\"" . $tt_ns . "\"";
                                                            } else {
                                                                $array_typename = $tt;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        $array_type = $i;
                                        if ($use == "literal") {
                                            $type_str = "";
                                        } else {
                                            if (isset($type) && isset($type_prefix)) {
                                                $type_str = " xsi:type=\"" . $type_prefix . ":" . $type . "\"";
                                            } else {
                                                $type_str = " xsi:type=\"SOAP-ENC:Array\" SOAP-ENC:arrayType=\"" . $array_typename . "[" . $array_type . "]\"";
                                            }
                                        }
                                    } else {
                                        if ($use == "literal") {
                                            $type_str = "";
                                        } else {
                                            if (isset($type) && isset($type_prefix)) {
                                                $type_str = " xsi:type=\"" . $type_prefix . ":" . $type . "\"";
                                            } else {
                                                $type_str = " xsi:type=\"SOAP-ENC:Array\" SOAP-ENC:arrayType=\"xsd:anyType[0]\"";
                                            }
                                        }
                                    }
                                    $xml = "<" . $name . $xmlns . $type_str . $atts . ">" . $xml . "</" . $name . ">";
                                } else {
                                    $this->debug("serialize_val: serialize struct");
                                    if (isset($type) && isset($type_prefix)) {
                                        $type_str = " xsi:type=\"" . $type_prefix . ":" . $type . "\"";
                                    } else {
                                        $type_str = "";
                                    }
                                    if ($use == "literal") {
                                        $xml .= "<" . $name . $xmlns . $atts . ">";
                                    } else {
                                        $xml .= "<" . $name . $xmlns . $type_str . $atts . ">";
                                    }
                                    foreach ($val as $k => $v) {
                                        if ($type == "Map" && $type_ns == "http://xml.apache.org/xml-soap") {
                                            $xml .= "<item>";
                                            $xml .= $this->serialize_val($k, "key", false, false, false, false, $use);
                                            $xml .= $this->serialize_val($v, "value", false, false, false, false, $use);
                                            $xml .= "</item>";
                                        } else {
                                            $xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
                                        }
                                    }
                                    $xml .= "</" . $name . ">";
                                }
                            }
                        } else {
                            $this->debug("serialize_val: serialize object");
                            if (get_class($val) == "soapval") {
                                $this->debug("serialize_val: serialize soapval object");
                                $pXml = $val->serialize($use);
                                $this->appendDebug($val->getDebug());
                                $val->clearDebug();
                            } else {
                                if (!$name) {
                                    $name = get_class($val);
                                    $this->debug("In serialize_val, used class name " . $name . " as element name");
                                } else {
                                    $this->debug("In serialize_val, do not override name " . $name . " for element name for class " . get_class($val));
                                }
                                foreach (get_object_vars($val) as $k => $v) {
                                    $pXml = isset($pXml) ? $pXml . $this->serialize_val($v, $k, false, false, false, false, $use) : $this->serialize_val($v, $k, false, false, false, false, $use);
                                }
                            }
                            if (isset($type) && isset($type_prefix)) {
                                $type_str = " xsi:type=\"" . $type_prefix . ":" . $type . "\"";
                            } else {
                                $type_str = "";
                            }
                            if ($use == "literal") {
                                $xml .= "<" . $name . $xmlns . $atts . ">" . $pXml . "</" . $name . ">";
                            } else {
                                $xml .= "<" . $name . $xmlns . $type_str . $atts . ">" . $pXml . "</" . $name . ">";
                            }
                        }
                    } else {
                        $this->debug("serialize_val: serialize string");
                        $val = $this->expandEntities($val);
                        if ($use == "literal") {
                            $xml .= "<" . $name . $xmlns . $atts . ">" . $val . "</" . $name . ">";
                        } else {
                            $xml .= "<" . $name . $xmlns . " xsi:type=\"xsd:string\"" . $atts . ">" . $val . "</" . $name . ">";
                        }
                    }
                } else {
                    $this->debug("serialize_val: serialize float");
                    if ($use == "literal") {
                        $xml .= "<" . $name . $xmlns . $atts . ">" . $val . "</" . $name . ">";
                    } else {
                        $xml .= "<" . $name . $xmlns . " xsi:type=\"xsd:float\"" . $atts . ">" . $val . "</" . $name . ">";
                    }
                }
            } else {
                $this->debug("serialize_val: serialize int");
                if ($use == "literal") {
                    $xml .= "<" . $name . $xmlns . $atts . ">" . $val . "</" . $name . ">";
                } else {
                    $xml .= "<" . $name . $xmlns . " xsi:type=\"xsd:int\"" . $atts . ">" . $val . "</" . $name . ">";
                }
            }
        } else {
            $this->debug("serialize_val: serialize boolean");
            if ($type == "boolean") {
                $val = $val ? "true" : "false";
            } else {
                if (!$val) {
                    $val = 0;
                }
            }
            if ($use == "literal") {
                $xml .= "<" . $name . $xmlns . $atts . ">" . $val . "</" . $name . ">";
            } else {
                $xml .= "<" . $name . $xmlns . " xsi:type=\"xsd:boolean\"" . $atts . ">" . $val . "</" . $name . ">";
            }
        }
        $this->debug("serialize_val returning " . $xml);
        return $xml;
    }
    public function serializeEnvelope($body, $headers = false, $namespaces = [], $style = "rpc", $use = "encoded", $encodingStyle = "http://schemas.xmlsoap.org/soap/encoding/")
    {
        $this->debug("In serializeEnvelope length=" . strlen($body) . " body (max 1000 characters)=" . substr($body, 0, 1000) . " style=" . $style . " use=" . $use . " encodingStyle=" . $encodingStyle);
        $this->debug("headers:");
        $this->appendDebug($this->varDump($headers));
        $this->debug("namespaces:");
        $this->appendDebug($this->varDump($namespaces));
        $ns_string = "";
        foreach (array_merge($this->namespaces, $namespaces) as $k => $v) {
            $ns_string .= " xmlns:" . $k . "=\"" . $v . "\"";
        }
        if ($encodingStyle) {
            $ns_string = " SOAP-ENV:encodingStyle=\"" . $encodingStyle . "\"" . $ns_string;
        }
        if ($headers) {
            if (is_array($headers)) {
                $xml = "";
                foreach ($headers as $k => $v) {
                    if (is_object($v) && get_class($v) == "soapval") {
                        $xml .= $this->serialize_val($v, false, false, false, false, false, $use);
                    } else {
                        $xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
                    }
                }
                $headers = $xml;
                $this->debug("In serializeEnvelope, serialized array of headers to " . $headers);
            }
            $headers = "<SOAP-ENV:Header>" . $headers . "</SOAP-ENV:Header>";
        }
        return "<?xml version=\"1.0\" encoding=\"" . $this->soap_defencoding . "\"?" . ">" . "<SOAP-ENV:Envelope" . $ns_string . ">" . $headers . "<SOAP-ENV:Body>" . $body . "</SOAP-ENV:Body>" . "</SOAP-ENV:Envelope>";
    }
    public function formatDump($str)
    {
        $str = htmlspecialchars($str);
        return nl2br($str);
    }
    public function contractQname($qname)
    {
        if (strrpos($qname, ":")) {
            $name = substr($qname, strrpos($qname, ":") + 1);
            $ns = substr($qname, 0, strrpos($qname, ":"));
            $p = $this->getPrefixFromNamespace($ns);
            if ($p) {
                return $p . ":" . $name;
            }
            return $qname;
        }
        return $qname;
    }
    public function expandQname($qname)
    {
        if (strpos($qname, ":") && !preg_match("/^http:\\/\\//", $qname)) {
            $name = substr(strstr($qname, ":"), 1);
            $prefix = substr($qname, 0, strpos($qname, ":"));
            if (isset($this->namespaces[$prefix])) {
                return $this->namespaces[$prefix] . ":" . $name;
            }
            return $qname;
        }
        return $qname;
    }
    public function getLocalPart($str)
    {
        if ($sstr = strrchr($str, ":")) {
            return substr($sstr, 1);
        }
        return $str;
    }
    public function getPrefix($str)
    {
        if ($pos = strrpos($str, ":")) {
            return substr($str, 0, $pos);
        }
        return false;
    }
    public function getNamespaceFromPrefix($prefix)
    {
        if (isset($this->namespaces[$prefix])) {
            return $this->namespaces[$prefix];
        }
        return false;
    }
    public function getPrefixFromNamespace($ns)
    {
        foreach ($this->namespaces as $p => $n) {
            if ($ns == $n || $ns == $p) {
                $this->usedNamespaces[$p] = $n;
                return $p;
            }
        }
        return false;
    }
    public function getmicrotime()
    {
        if (function_exists("gettimeofday")) {
            $tod = gettimeofday();
            $sec = $tod["sec"];
            $usec = $tod["usec"];
        } else {
            $sec = time();
            $usec = 0;
        }
        return strftime("%Y-%m-%d %H:%M:%S", $sec) . "." . sprintf("%06d", $usec);
    }
    public function varDump($data)
    {
        ob_start();
        var_dump($data);
        $ret_val = ob_get_contents();
        ob_end_clean();
        return $ret_val;
    }
    public function __toString()
    {
        return $this->varDump($this);
    }
}
function timestamp_to_iso8601($timestamp, $utc = true)
{
    $datestr = date("Y-m-d\\TH:i:sO", $timestamp);
    $pos = strrpos($datestr, "+");
    if ($pos === false) {
        $pos = strrpos($datestr, "-");
    }
    if ($pos !== false && strlen($datestr) == $pos + 5) {
        $datestr = substr($datestr, 0, $pos + 3) . ":" . substr($datestr, -2);
    }
    if ($utc) {
        $pattern = "/([0-9]{4})-([0-9]{2})-([0-9]{2})T([0-9]{2}):([0-9]{2}):([0-9]{2})(\\.[0-9]*)?(Z|[+\\-][0-9]{2}:?[0-9]{2})?/";
        if (preg_match($pattern, $datestr, $regs)) {
            return sprintf("%04d-%02d-%02dT%02d:%02d:%02dZ", $regs[1], $regs[2], $regs[3], $regs[4], $regs[5], $regs[6]);
        }
        return false;
    }
    return $datestr;
}
function iso8601_to_timestamp($datestr)
{
    $pattern = "/([0-9]{4})-([0-9]{2})-([0-9]{2})T([0-9]{2}):([0-9]{2}):([0-9]{2})(\\.[0-9]+)?(Z|[+\\-][0-9]{2}:?[0-9]{2})?/";
    if (preg_match($pattern, $datestr, $regs)) {
        if ($regs[8] != "Z") {
            $op = substr($regs[8], 0, 1);
            $h = substr($regs[8], 1, 2);
            $m = substr($regs[8], strlen($regs[8]) - 2, 2);
            if ($op == "-") {
                $regs[4] = $regs[4] + $h;
                $regs[5] = $regs[5] + $m;
            } else {
                if ($op == "+") {
                    $regs[4] = $regs[4] - $h;
                    $regs[5] = $regs[5] - $m;
                }
            }
        }
        return gmmktime($regs[4], $regs[5], $regs[6], $regs[2], $regs[3], $regs[1]);
    }
    return false;
}
function usleepWindows($usec)
{
    do {
        $start = gettimeofday();
        $stop = gettimeofday();
        $timePassed = 1000000 * ($stop["sec"] - $start["sec"]) + $stop["usec"] - $start["usec"];
    } while ($timePassed >= $usec);
}

?>