<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
* Contains information for a SOAP fault.
* Mainly used for returning faults from deployed functions
* in a server instance.
* @author   Dietrich Ayala <dietrich@ganx4.com>
* @version  $Id: class.soap_fault.php,v 1.14 2007/04/11 15:49:47 snichol Exp $
* @access public
*/
class nusoap_fault extends nusoap_base
{
    /**
     * The fault code (client|server)
     * @var string
     * @access private
     */
    public $faultcode = NULL;
    /**
     * The fault actor
     * @var string
     * @access private
     */
    public $faultactor = NULL;
    /**
     * The fault string, a description of the fault
     * @var string
     * @access private
     */
    public $faultstring = NULL;
    /**
     * The fault detail, typically a string or array of string
     * @var mixed
     * @access private
     */
    public $faultdetail = NULL;
    public function nusoap_fault($faultcode, $faultactor = "", $faultstring = "", $faultdetail = "")
    {
        parent::nusoap_base();
        $this->faultcode = $faultcode;
        $this->faultactor = $faultactor;
        $this->faultstring = $faultstring;
        $this->faultdetail = $faultdetail;
    }
    public function serialize()
    {
        $ns_string = "";
        foreach ($this->namespaces as $k => $v) {
            $ns_string .= "\n  xmlns:" . $k . "=\"" . $v . "\"";
        }
        $return_msg = "<?xml version=\"1.0\" encoding=\"" . $this->soap_defencoding . "\"?>" . "<SOAP-ENV:Envelope SOAP-ENV:encodingStyle=\"http://schemas.xmlsoap.org/soap/encoding/\"" . $ns_string . ">\n" . "<SOAP-ENV:Body>" . "<SOAP-ENV:Fault>" . $this->serialize_val($this->faultcode, "faultcode") . $this->serialize_val($this->faultactor, "faultactor") . $this->serialize_val($this->faultstring, "faultstring") . $this->serialize_val($this->faultdetail, "detail") . "</SOAP-ENV:Fault>" . "</SOAP-ENV:Body>" . "</SOAP-ENV:Envelope>";
        return $return_msg;
    }
}
/**
 * Backward compatibility
 */
class soap_fault extends nusoap_fault
{
}

?>