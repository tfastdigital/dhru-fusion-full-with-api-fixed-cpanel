<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "Mail/mimeDecode.php";
require_once "Mail/mimePart.php";
/**
* nusoap_client_mime client supporting MIME attachments defined at
* http://www.w3.org/TR/SOAP-attachments.  It depends on the PEAR Mail_MIME library.
*
* @author   Scott Nichol <snichol@users.sourceforge.net>
* @author	Thanks to Guillaume and Henning Reich for posting great attachment code to the mail list
* @version  $Id: nusoapmime.php,v 1.13 2010/04/26 20:15:08 snichol Exp $
* @access   public
*/
class nusoap_client_mime extends nusoap_client
{
    /**
     * @var array Each array element in the return is an associative array with keys
     * data, filename, contenttype, cid
     * @access private
     */
    public $requestAttachments = [];
    /**
     * @var array Each array element in the return is an associative array with keys
     * data, filename, contenttype, cid
     * @access private
     */
    public $responseAttachments = NULL;
    /**
     * @var string
     * @access private
     */
    public $mimeContentType = NULL;
    public function addAttachment($data, $filename = "", $contenttype = "application/octet-stream", $cid = false)
    {
        if (!$cid) {
            $cid = md5(uniqid(time()));
        }
        $info["data"] = $data;
        $info["filename"] = $filename;
        $info["contenttype"] = $contenttype;
        $info["cid"] = $cid;
        $this->requestAttachments[] = $info;
        return $cid;
    }
    public function clearAttachments()
    {
        $this->requestAttachments = [];
    }
    public function getAttachments()
    {
        return $this->responseAttachments;
    }
    public function getHTTPBody($soapmsg)
    {
        if (0 < count($this->requestAttachments)) {
            $params["content_type"] = "multipart/related; type=\"text/xml\"";
            $mimeMessage = new Mail_mimePart("", $params);
            unset($params);
            $params["content_type"] = "text/xml";
            $params["encoding"] = "8bit";
            $params["charset"] = $this->soap_defencoding;
            $mimeMessage->addSubpart($soapmsg, $params);
            foreach ($this->requestAttachments as $att) {
                unset($params);
                $params["content_type"] = $att["contenttype"];
                $params["encoding"] = "base64";
                $params["disposition"] = "attachment";
                $params["dfilename"] = $att["filename"];
                $params["cid"] = $att["cid"];
                if ($att["data"] == "" && $att["filename"] != "") {
                    if ($fd = fopen($att["filename"], "rb")) {
                        $data = fread($fd, filesize($att["filename"]));
                        fclose($fd);
                    } else {
                        $data = "";
                    }
                    $mimeMessage->addSubpart($data, $params);
                } else {
                    $mimeMessage->addSubpart($att["data"], $params);
                }
            }
            $output = $mimeMessage->encode();
            $mimeHeaders = $output["headers"];
            foreach ($mimeHeaders as $k => $v) {
                $this->debug("MIME header " . $k . ": " . $v);
                if (strtolower($k) == "content-type") {
                    $this->mimeContentType = str_replace("\r\n", " ", $v);
                }
            }
            return $output["body"];
        } else {
            return parent::getHTTPBody($soapmsg);
        }
    }
    public function getHTTPContentType()
    {
        if (0 < count($this->requestAttachments)) {
            return $this->mimeContentType;
        }
        return parent::getHTTPContentType();
    }
    public function getHTTPContentTypeCharset()
    {
        if (0 < count($this->requestAttachments)) {
            return false;
        }
        return parent::getHTTPContentTypeCharset();
    }
    public function parseResponse($headers, $data)
    {
        $this->debug("Entering parseResponse() for payload of length " . strlen($data) . " and type of " . $headers["content-type"]);
        $this->responseAttachments = [];
        if (strstr($headers["content-type"], "multipart/related")) {
            $this->debug("Decode multipart/related");
            $input = "";
            foreach ($headers as $k => $v) {
                $input .= $k . ": " . $v . "\r\n";
            }
            $params["input"] = $input . "\r\n" . $data;
            $params["include_bodies"] = true;
            $params["decode_bodies"] = true;
            $params["decode_headers"] = true;
            $structure = Mail_mimeDecode::decode($params);
            foreach ($structure->parts as $part) {
                if (!isset($part->disposition) && strstr($part->headers["content-type"], "text/xml")) {
                    $this->debug("Have root part of type " . $part->headers["content-type"]);
                    $root = $part->body;
                    $return = parent::parseResponse($part->headers, $part->body);
                } else {
                    $this->debug("Have an attachment of type " . $part->headers["content-type"]);
                    $info["data"] = $part->body;
                    $info["filename"] = isset($part->d_parameters["filename"]) ? $part->d_parameters["filename"] : "";
                    $info["contenttype"] = $part->headers["content-type"];
                    $info["cid"] = $part->headers["content-id"];
                    $this->responseAttachments[] = $info;
                }
            }
            if (isset($return)) {
                $this->responseData = $root;
                return $return;
            }
            $this->setError("No root part found in multipart/related content");
            return "";
        } else {
            $this->debug("Not multipart/related");
            return parent::parseResponse($headers, $data);
        }
    }
}
if (!extension_loaded("soap")) {
    class soapclientmime extends nusoap_client_mime
    {
    }
}
/**
* nusoap_server_mime server supporting MIME attachments defined at
* http://www.w3.org/TR/SOAP-attachments.  It depends on the PEAR Mail_MIME library.
*
* @author   Scott Nichol <snichol@users.sourceforge.net>
* @author	Thanks to Guillaume and Henning Reich for posting great attachment code to the mail list
* @version  $Id: nusoapmime.php,v 1.13 2010/04/26 20:15:08 snichol Exp $
* @access   public
*/
class nusoap_server_mime extends nusoap_server
{
    /**
     * @var array Each array element in the return is an associative array with keys
     * data, filename, contenttype, cid
     * @access private
     */
    public $requestAttachments = [];
    /**
     * @var array Each array element in the return is an associative array with keys
     * data, filename, contenttype, cid
     * @access private
     */
    public $responseAttachments = NULL;
    /**
     * @var string
     * @access private
     */
    public $mimeContentType = NULL;
    public function addAttachment($data, $filename = "", $contenttype = "application/octet-stream", $cid = false)
    {
        if (!$cid) {
            $cid = md5(uniqid(time()));
        }
        $info["data"] = $data;
        $info["filename"] = $filename;
        $info["contenttype"] = $contenttype;
        $info["cid"] = $cid;
        $this->responseAttachments[] = $info;
        return $cid;
    }
    public function clearAttachments()
    {
        $this->responseAttachments = [];
    }
    public function getAttachments()
    {
        return $this->requestAttachments;
    }
    public function getHTTPBody($soapmsg)
    {
        if (0 < count($this->responseAttachments)) {
            $params["content_type"] = "multipart/related; type=\"text/xml\"";
            $mimeMessage = new Mail_mimePart("", $params);
            unset($params);
            $params["content_type"] = "text/xml";
            $params["encoding"] = "8bit";
            $params["charset"] = $this->soap_defencoding;
            $mimeMessage->addSubpart($soapmsg, $params);
            foreach ($this->responseAttachments as $att) {
                unset($params);
                $params["content_type"] = $att["contenttype"];
                $params["encoding"] = "base64";
                $params["disposition"] = "attachment";
                $params["dfilename"] = $att["filename"];
                $params["cid"] = $att["cid"];
                if ($att["data"] == "" && $att["filename"] != "") {
                    if ($fd = fopen($att["filename"], "rb")) {
                        $data = fread($fd, filesize($att["filename"]));
                        fclose($fd);
                    } else {
                        $data = "";
                    }
                    $mimeMessage->addSubpart($data, $params);
                } else {
                    $mimeMessage->addSubpart($att["data"], $params);
                }
            }
            $output = $mimeMessage->encode();
            $mimeHeaders = $output["headers"];
            foreach ($mimeHeaders as $k => $v) {
                $this->debug("MIME header " . $k . ": " . $v);
                if (strtolower($k) == "content-type") {
                    $this->mimeContentType = str_replace("\r\n", " ", $v);
                }
            }
            return $output["body"];
        } else {
            return parent::getHTTPBody($soapmsg);
        }
    }
    public function getHTTPContentType()
    {
        if (0 < count($this->responseAttachments)) {
            return $this->mimeContentType;
        }
        return parent::getHTTPContentType();
    }
    public function getHTTPContentTypeCharset()
    {
        if (0 < count($this->responseAttachments)) {
            return false;
        }
        return parent::getHTTPContentTypeCharset();
    }
    public function parseRequest($headers, $data)
    {
        $this->debug("Entering parseRequest() for payload of length " . strlen($data) . " and type of " . $headers["content-type"]);
        $this->requestAttachments = [];
        if (strstr($headers["content-type"], "multipart/related")) {
            $this->debug("Decode multipart/related");
            $input = "";
            foreach ($headers as $k => $v) {
                $input .= $k . ": " . $v . "\r\n";
            }
            $params["input"] = $input . "\r\n" . $data;
            $params["include_bodies"] = true;
            $params["decode_bodies"] = true;
            $params["decode_headers"] = true;
            $structure = Mail_mimeDecode::decode($params);
            foreach ($structure->parts as $part) {
                if (!isset($part->disposition) && strstr($part->headers["content-type"], "text/xml")) {
                    $this->debug("Have root part of type " . $part->headers["content-type"]);
                    $return = parent::parseRequest($part->headers, $part->body);
                } else {
                    $this->debug("Have an attachment of type " . $part->headers["content-type"]);
                    $info["data"] = $part->body;
                    $info["filename"] = isset($part->d_parameters["filename"]) ? $part->d_parameters["filename"] : "";
                    $info["contenttype"] = $part->headers["content-type"];
                    $info["cid"] = $part->headers["content-id"];
                    $this->requestAttachments[] = $info;
                }
            }
            if (isset($return)) {
                return $return;
            }
            $this->setError("No root part found in multipart/related content");
            return NULL;
        } else {
            $this->debug("Not multipart/related");
            return parent::parseRequest($headers, $data);
        }
    }
}
class nusoapservermime extends nusoap_server_mime
{
}

?>