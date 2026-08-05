<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
* For creating serializable abstractions of native PHP types.  This class
* allows element name/namespace, XSD type, and XML attributes to be
* associated with a value.  This is extremely useful when WSDL is not
* used, but is also useful when WSDL is used with polymorphic types, including
* xsd:anyType and user-defined types.
*
* @author   Dietrich Ayala <dietrich@ganx4.com>
* @version  $Id: class.soap_val.php,v 1.11 2007/04/06 13:56:32 snichol Exp $
* @access   public
*/
class soapval extends nusoap_base
{
    /**
     * The XML element name
     *
     * @var string
     * @access private
     */
    public $name = NULL;
    /**
     * The XML type name (string or false)
     *
     * @var mixed
     * @access private
     */
    public $type = NULL;
    /**
     * The PHP value
     *
     * @var mixed
     * @access private
     */
    public $value = NULL;
    /**
     * The XML element namespace (string or false)
     *
     * @var mixed
     * @access private
     */
    public $element_ns = NULL;
    /**
     * The XML type namespace (string or false)
     *
     * @var mixed
     * @access private
     */
    public $type_ns = NULL;
    /**
     * The XML element attributes (array or false)
     *
     * @var mixed
     * @access private
     */
    public $attributes = NULL;
    public function soapval($name = "soapval", $type = false, $value = -1, $element_ns = false, $type_ns = false, $attributes = false)
    {
        parent::nusoap_base();
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->element_ns = $element_ns;
        $this->type_ns = $type_ns;
        $this->attributes = $attributes;
    }
    public function serialize($use = "encoded")
    {
        return $this->serialize_val($this->value, $this->name, $this->type, $this->element_ns, $this->type_ns, $this->attributes, $use, true);
    }
    public function decode()
    {
        return $this->value;
    }
}

?>