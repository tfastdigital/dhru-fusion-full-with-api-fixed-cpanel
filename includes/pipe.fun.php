<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class Mail_mimeDecode
{
    public $_input = NULL;
    public $_header = NULL;
    public $_body = NULL;
    public $_error = NULL;
    public $_include_bodies = NULL;
    public $_decode_bodies = NULL;
    public $_decode_headers = NULL;
    public $_rfc822_bodies = NULL;
    public function Mail_mimeDecode($input)
    {
        list($header, $body) = $this->_splitBodyHeader($input);
        $this->_input = $input;
        $this->_header = $header;
        $this->_body = $body;
        $this->_decode_bodies = false;
        $this->_include_bodies = true;
        $this->_rfc822_bodies = false;
    }
    /*
    ERROR in processing the function: Unknown opcode 186 at line 1
       at a4c0de.PHP.Parsers.OpcodeParser.processOpcode_7_2()
       at a4c0de.PHP.Parsers.OpcodeParser.parse()
       at a4c0de.PHP.Output.CodeGenerator.outputClassMethod(BinaryTextWriter writer, ZOpArray zoparray, String indent, Boolean isInInterface)
    */
    public function _decode($headers, $body, $default_ctype = "text/plain")
    {
        $return = new stdClass();
        $return->headers = [];
        $headers = $this->_parseHeaders($headers);
        foreach ($headers as $value) {
            $value["value"] = $this->_decode_headers ? $this->_decodeHeader($value["value"]) : $value["value"];
            if (isset($return->headers[strtolower($value["name"])]) && !is_array($return->headers[strtolower($value["name"])])) {
                $return->headers[strtolower($value["name"])] = [$return->headers[strtolower($value["name"])]];
                $return->headers[strtolower($value["name"])][] = $value["value"];
            } else {
                if (isset($return->headers[strtolower($value["name"])])) {
                    $return->headers[strtolower($value["name"])][] = $value["value"];
                } else {
                    $return->headers[strtolower($value["name"])] = $value["value"];
                }
            }
        }
        foreach ($headers as $key => $value) {
            $headers[$key]["name"] = strtolower($headers[$key]["name"]);
            switch ($headers[$key]["name"]) {
                case "content-type":
                    $content_type = $this->_parseHeaderValue($headers[$key]["value"]);
                    if (preg_match("/([0-9a-z+.-]+)\\/([0-9a-z+.-]+)/i", $content_type["value"], $regs)) {
                        list($return->ctype_primary, $return->ctype_secondary) = $regs;
                    }
                    if (isset($content_type["other"])) {
                        foreach ($content_type["other"] as $p_name => $p_value) {
                            $return->ctype_parameters[$p_name] = $p_value;
                        }
                    }
                    break;
                case "content-disposition":
                    $content_disposition = $this->_parseHeaderValue($headers[$key]["value"]);
                    $return->disposition = $content_disposition["value"];
                    if (isset($content_disposition["other"])) {
                        foreach ($content_disposition["other"] as $p_name => $p_value) {
                            $return->d_parameters[$p_name] = $p_value;
                        }
                    }
                    break;
                case "content-transfer-encoding":
                    $content_transfer_encoding = $this->_parseHeaderValue($headers[$key]["value"]);
                    break;
            }
        }
        if (isset($content_type)) {
            strtolower($content_type["value"]);
            switch (strtolower($content_type["value"])) {
                case "text/plain":
                    $encoding = isset($content_transfer_encoding) ? $content_transfer_encoding["value"] : "7bit";
                    $this->_include_bodies ? $return->body = $this->_decode_bodies ? $this->_decodeBody($body, $encoding) : $body : NULL;
                    break;
                case "text/html":
                    $encoding = isset($content_transfer_encoding) ? $content_transfer_encoding["value"] : "7bit";
                    $this->_include_bodies ? $return->body = $this->_decode_bodies ? $this->_decodeBody($body, $encoding) : $body : NULL;
                    break;
                case "multipart/parallel":
                case "multipart/appledouble":
                case "multipart/report":
                case "multipart/signed":
                case "multipart/digest":
                case "multipart/alternative":
                case "multipart/related":
                case "multipart/mixed":
                case "application/vnd.wap.multipart.related":
                    if (!isset($content_type["other"]["boundary"])) {
                        $this->_error = "No boundary found for " . $content_type["value"] . " part";
                        return false;
                    }
                    $default_ctype = strtolower($content_type["value"]) === "multipart/digest" ? "message/rfc822" : "text/plain";
                    $parts = $this->_boundarySplit($body, $content_type["other"]["boundary"]);
                    for ($i = 0; $i < count($parts); $i++) {
                        list($part_header, $part_body) = $this->_splitBodyHeader($parts[$i]);
                        $part = $this->_decode($part_header, $part_body, $default_ctype);
                        if ($part === false) {
                            $part = $this->raiseError($this->_error);
                        }
                        $return->parts[] = $part;
                    }
                    break;
                case "message/rfc822":
                    if ($this->_rfc822_bodies) {
                        $encoding = isset($content_transfer_encoding) ? $content_transfer_encoding["value"] : "7bit";
                        $return->body = $this->_decode_bodies ? $this->_decodeBody($body, $encoding) : $body;
                    }
                    $obj = new Mail_mimeDecode($body);
                    $return->parts[] = $obj->decode(["include_bodies" => $this->_include_bodies, "decode_bodies" => $this->_decode_bodies, "decode_headers" => $this->_decode_headers]);
                    unset($obj);
                    break;
                default:
                    if (!isset($content_transfer_encoding["value"])) {
                        $content_transfer_encoding["value"] = "7bit";
                    }
                    $this->_include_bodies ? $return->body = $this->_decode_bodies ? $this->_decodeBody($body, $content_transfer_encoding["value"]) : $body : NULL;
            }
        } else {
            $ctype = explode("/", $default_ctype);
            list($return->ctype_primary, $return->ctype_secondary) = $ctype;
            $this->_include_bodies ? $return->body = $this->_decode_bodies ? $this->_decodeBody($body) : $body : NULL;
        }
        return $return;
    }
    public function &getMimeNumbers(&$structure, $no_refs = false, $mime_number = "", $prepend = "")
    {
        $return = [];
        if (!empty($structure->parts)) {
            if ($mime_number != "") {
                $structure->mime_id = $prepend . $mime_number;
                $return[$prepend . $mime_number] =& $structure;
            }
            for ($i = 0; $i < count($structure->parts); $i++) {
                if (!empty($structure->headers["content-type"]) && substr(strtolower($structure->headers["content-type"]), 0, 8) == "message/") {
                    $prepend = $prepend . $mime_number . ".";
                    $_mime_number = "";
                } else {
                    $_mime_number = $mime_number == "" ? $i + 1 : sprintf("%s.%s", $mime_number, $i + 1);
                }
                $arr =& Mail_mimeDecode::getMimeNumbers($structure->parts[$i], $no_refs, $_mime_number, $prepend);
                foreach ($arr as $key => $val) {
                    $no_refs ? $return[$key] : ($return[$key] =& $arr[$key]);
                }
            }
        } else {
            if ($mime_number == "") {
                $mime_number = "1";
            }
            $structure->mime_id = $prepend . $mime_number;
            $no_refs ? $return[$prepend . $mime_number] : ($return[$prepend . $mime_number] =& $structure);
        }
        return $return;
    }
    public function _splitBodyHeader($input)
    {
        if (preg_match("/^(.*?)\r?\n\r?\n(.*)/s", $input, $match)) {
            return [$match[1], $match[2]];
        }
        if (count(explode("\n", $input))) {
            return [$input, ""];
        }
        $this->_error = "Could not split header and body";
        return false;
    }
    public function _parseHeaders($input)
    {
        if ($input !== "") {
            $input = preg_replace("/\r?\n/", "\r\n", $input);
            $input = preg_replace("/=\r\n(\t| )+/", "=", $input);
            $input = preg_replace("/\r\n(\t| )+/", " ", $input);
            $headers = explode("\r\n", trim($input));
            foreach ($headers as $value) {
                $hdr_name = substr($value, 0, $pos = strpos($value, ":"));
                $hdr_value = substr($value, $pos + 1);
                if ($hdr_value[0] == " ") {
                    $hdr_value = substr($hdr_value, 1);
                }
                $return[] = ["name" => $hdr_name, "value" => $hdr_value];
            }
        } else {
            $return = [];
        }
        return $return;
    }
    public function _parseHeaderValue($input)
    {
        if (($pos = strpos($input, ";")) === false) {
            $input = $this->_decode_headers ? $this->_decodeHeader($input) : $input;
            $return["value"] = trim($input);
            return $return;
        }
        $value = substr($input, 0, $pos);
        $value = $this->_decode_headers ? $this->_decodeHeader($value) : $value;
        $return["value"] = trim($value);
        $input = trim(substr($input, $pos + 1));
        if (0 < !strlen($input)) {
            return $return;
        }
        $i = 0;
        $l = strlen($input);
        $key = "";
        $val = false;
        $q = false;
        $lq = "";
        while ($i < $l) {
            $c = $input[$i];
            $escaped = false;
            if ($c == "\\") {
                $i++;
                if ($i != $l - 1) {
                    $escaped = true;
                    $c = $input[$i];
                }
            }
            if ($val === false) {
                if (!$escaped && $c == "=") {
                    $val = "";
                    $key = trim($key);
                    $i++;
                } else {
                    if (!$escaped && $c == ";") {
                        if ($key) {
                            $key = trim($key);
                            $return["other"][$key] = "";
                            $return["other"][strtolower($key)] = "";
                        }
                        $key = "";
                    }
                    $key .= $c;
                    $i++;
                }
            } else {
                if ($q === false) {
                    if ((!strlen($val) || $lq !== false) && $c == " " || $c == "\t") {
                        $i++;
                    } else {
                        if (!$escaped && ($c == "\"" || $c == "'")) {
                            $q = $c;
                            $val = !strlen(trim($val)) ? "" : trim($val);
                            $i++;
                        } else {
                            if (!$escaped && $c == ";") {
                                $val = trim($val);
                                $added = false;
                                if (preg_match("/\\*[0-9]+\$/", $key)) {
                                    $key = preg_replace("/\\*[0-9]+\$/", "", $key);
                                    if (isset($return["other"][$key])) {
                                        $return["other"][$key] .= $val;
                                        if (strtolower($key) != $key) {
                                            $return["other"][strtolower($key)] .= $val;
                                        }
                                        $added = true;
                                    }
                                }
                                if (!$added) {
                                    $return["other"][$key] = $val;
                                    $return["other"][strtolower($key)] = $val;
                                }
                                $val = false;
                                $key = "";
                                $lq = false;
                                $i++;
                            } else {
                                $val .= $c;
                                $i++;
                            }
                        }
                    }
                } else {
                    if (!$escaped && $c == $q) {
                        $lq = $q;
                        $q = false;
                        $i++;
                    } else {
                        $val .= $c;
                        $i++;
                    }
                }
            }
        }
        if (strlen(trim($key)) || $val !== false) {
            $val = trim($val);
            $added = false;
            if ($val !== false && preg_match("/\\*[0-9]+\$/", $key)) {
                $key = preg_replace("/\\*[0-9]+\$/", "", $key);
                if (isset($return["other"][$key])) {
                    $return["other"][$key] .= $val;
                    if (strtolower($key) != $key) {
                        $return["other"][strtolower($key)] .= $val;
                    }
                    $added = true;
                }
            }
            if (!$added) {
                $return["other"][$key] = $val;
                $return["other"][strtolower($key)] = $val;
            }
        }
        foreach ($return["other"] as $key => $val) {
            $return["other"][$key] = $this->_decode_headers ? $this->_decodeHeader($val) : $val;
        }
        return $return;
    }
    public function _boundarySplit($input, $boundary)
    {
        $parts = [];
        $bs_possible = substr($boundary, 2, -2);
        $bs_check = "\\\"" . $bs_possible . "\\\"";
        if ($boundary == $bs_check) {
            $boundary = $bs_possible;
        }
        $tmp = preg_split("/--" . preg_quote($boundary, "/") . "((?=\\s)|--)/", $input);
        $len = count($tmp) - 1;
        for ($i = 1; $i < $len; $i++) {
            if (strlen(trim($tmp[$i]))) {
                $parts[] = $tmp[$i];
            }
        }
        if (!empty($tmp[$len]) && strlen(trim($tmp[$len])) && $tmp[$len][0] != "-") {
            $parts[] = $tmp[$len];
        }
        return $parts;
    }
    public function _decodeHeader($input)
    {
        $input = preg_replace("/(=\\?[^?]+\\?(q|b)\\?[^?]*\\?=)(\\s)+=\\?/i", "\\1=?", $input);
        while (preg_match("/(=\\?([^?]+)\\?(q|b)\\?([^?]*)\\?=)/i", $input, $matches)) {
            list($encoded, $charset, $encoding, $text) = $matches;
            strtolower($encoding);
            switch (strtolower($encoding)) {
                case "b":
                    $text = base64_decode($text);
                    break;
                case "q":
                    $text = str_replace("_", " ", $text);
                    preg_match_all("/=([a-f0-9]{2})/i", $text, $matches);
                    foreach ($matches[1] as $value) {
                        $text = str_replace("=" . $value, chr(hexdec($value)), $text);
                    }
                    break;
                default:
                    $input = str_replace($encoded, $text, $input);
            }
        }
        return $input;
    }
    public function _decodeBody($input, $encoding = "7bit")
    {
        strtolower($encoding);
        switch (strtolower($encoding)) {
            case "7bit":
                return $input;
                break;
            case "quoted-printable":
                return $this->_quotedPrintableDecode($input);
                break;
            case "base64":
                return base64_decode($input);
                break;
            default:
                return $input;
        }
    }
    public function _quotedPrintableDecode($input)
    {
        $input = preg_replace("/=\r?\n/", "", $input);
        $input = preg_replace("/=([a-f0-9]{2})/ie", "chr(hexdec('\\1'))", $input);
        return $input;
    }
    public function &uudecode($input)
    {
        preg_match_all("/begin ([0-7]{3}) (.+)\r?\n(.+)\r?\nend/Us", $input, $matches);
        for ($j = 0; $j < count($matches[3]); $j++) {
            $str = $matches[3][$j];
            $filename = $matches[2][$j];
            $fileperm = $matches[1][$j];
            $file = "";
            $str = preg_split("/\r?\n/", trim($str));
            $strlen = count($str);
            for ($i = 0; $i < $strlen; $i++) {
                $pos = 1;
                $d = 0;
                $len = (int) (ord(substr($str[$i], 0, 1)) - 32 - " " & 63);
                while ($d + 3 <= $len && $pos + 4 <= strlen($str[$i])) {
                    $c0 = ord(substr($str[$i], $pos, 1)) ^ 32;
                    $c1 = ord(substr($str[$i], $pos + 1, 1)) ^ 32;
                    $c2 = ord(substr($str[$i], $pos + 2, 1)) ^ 32;
                    $c3 = ord(substr($str[$i], $pos + 3, 1)) ^ 32;
                    $file .= chr(($c0 - " " & 63) << 2 | ($c1 - " " & 63) >> 4);
                    $file .= chr(($c1 - " " & 63) << 4 | ($c2 - " " & 63) >> 2);
                    $file .= chr(($c2 - " " & 63) << 6 | $c3 - " " & 63);
                    $pos += 4;
                    $d += 3;
                }
                if ($d + 2 <= $len && $pos + 3 <= strlen($str[$i])) {
                    $c0 = ord(substr($str[$i], $pos, 1)) ^ 32;
                    $c1 = ord(substr($str[$i], $pos + 1, 1)) ^ 32;
                    $c2 = ord(substr($str[$i], $pos + 2, 1)) ^ 32;
                    $file .= chr(($c0 - " " & 63) << 2 | ($c1 - " " & 63) >> 4);
                    $file .= chr(($c1 - " " & 63) << 4 | ($c2 - " " & 63) >> 2);
                    $pos += 3;
                    $d += 2;
                }
                if ($d + 1 <= $len && $pos + 2 <= strlen($str[$i])) {
                    $c0 = ord(substr($str[$i], $pos, 1)) ^ 32;
                    $c1 = ord(substr($str[$i], $pos + 1, 1)) ^ 32;
                    $file .= chr(($c0 - " " & 63) << 2 | ($c1 - " " & 63) >> 4);
                }
            }
            $files[] = ["filename" => $filename, "fileperm" => $fileperm, "filedata" => $file];
        }
        return $files;
    }
    public function getSendArray()
    {
        $this->_decode_headers = false;
        $headerlist = $this->_parseHeaders($this->_header);
        $to = "";
        if (!$headerlist) {
            return $this->raiseError("Message did not contain headers");
        }
        foreach ($headerlist as $item) {
            $header[$item["name"]] = $item["value"];
            strtolower($item["name"]);
            switch (strtolower($item["name"])) {
                case "to":
                case "cc":
                case "bcc":
                    $to .= "," . $item["value"];
                    break;
            }
        }
        if ($to == "") {
            return $this->raiseError("Message did not contain any recipents");
        }
        $to = substr($to, 1);
        return [$to, $header, $this->_body];
    }
    public function getXML($input)
    {
        $crlf = "\r\n";
        $output = "<?xml version='1.0'?>" . $crlf . "<!DOCTYPE email SYSTEM \"http://www.phpguru.org/xmail/xmail.dtd\">" . $crlf . "<email>" . $crlf . Mail_mimeDecode::_getXML($input) . "</email>";
        return $output;
    }
    public function _getXML($input, $indent = 1)
    {
        $htab = "\t";
        $crlf = "\r\n";
        $output = "";
        $headers = (array) $input->headers;
        foreach ($headers as $hdr_name => $hdr_value) {
            if (is_array($headers[$hdr_name])) {
                for ($i = 0; $i < count($hdr_value); $i++) {
                    $output .= Mail_mimeDecode::_getXML_helper($hdr_name, $hdr_value[$i], $indent);
                }
            } else {
                $output .= Mail_mimeDecode::_getXML_helper($hdr_name, $hdr_value, $indent);
            }
        }
        if (!empty($input->parts)) {
            for ($i = 0; $i < count($input->parts); $i++) {
                $output .= $crlf . str_repeat($htab, $indent) . "<mimepart>" . $crlf . Mail_mimeDecode::_getXML($input->parts[$i], $indent + 1) . str_repeat($htab, $indent) . "</mimepart>" . $crlf;
            }
        } else {
            if (isset($input->body)) {
                $output .= $crlf . str_repeat($htab, $indent) . "<body><![CDATA[" . $input->body . "]]></body>" . $crlf;
            }
        }
        return $output;
    }
    public function _getXML_helper($hdr_name, $hdr_value, $indent)
    {
        $htab = "\t";
        $crlf = "\r\n";
        $return = "";
        $new_hdr_value = $hdr_name != "received" ? Mail_mimeDecode::_parseHeaderValue($hdr_value) : ["value" => $hdr_value];
        $new_hdr_name = str_replace(" ", "-", ucwords(str_replace("-", " ", $hdr_name)));
        if (!empty($new_hdr_value["other"])) {
            foreach ($new_hdr_value["other"] as $paramname => $paramvalue) {
                $params[] = str_repeat($htab, $indent) . $htab . "<parameter>" . $crlf . str_repeat($htab, $indent) . $htab . $htab . "<paramname>" . htmlspecialchars($paramname) . "</paramname>" . $crlf . str_repeat($htab, $indent) . $htab . $htab . "<paramvalue>" . htmlspecialchars($paramvalue) . "</paramvalue>" . $crlf . str_repeat($htab, $indent) . $htab . "</parameter>" . $crlf;
            }
            $params = implode("", $params);
        } else {
            $params = "";
        }
        $return = str_repeat($htab, $indent) . "<header>" . $crlf . str_repeat($htab, $indent) . $htab . "<headername>" . htmlspecialchars($new_hdr_name) . "</headername>" . $crlf . str_repeat($htab, $indent) . $htab . "<headervalue>" . htmlspecialchars($new_hdr_value["value"]) . "</headervalue>" . $crlf . $params . str_repeat($htab, $indent) . "</header>" . $crlf;
        return $return;
    }
}
function interpret_structure($structure)
{
    global $_emailoutput;
    $ctype = strtolower($structure->ctype_primary) . "/" . strtolower($structure->ctype_secondary);
    if (!$ctype) {
        $ctype = "text/plain";
    }
    if ($ctype == "text/html" || $ctype == "text/plain") {
        $charset = "us-ascii";
        if (!empty($structure->ctype_parameters) && isset($structure->ctype_parameters["charset"])) {
            $charset = $structure->ctype_parameters["charset"];
        }
        if (!empty($structure->disposition) && $structure->disposition == "attachment") {
            handle_attachment($structure);
        } else {
            $var = $ctype == "text/html" ? "html" : "text";
            $bodyUtf8 = $structure->body;
            if ($charset == "UTF-8") {
                $charset = "";
            }
            if ($charset && function_exists("iconv")) {
                $bodyUtf8 = iconv($charset, "utf-8", $bodyUtf8);
                if (!$_emailoutput["headers"]["convertedcharset"]) {
                    $_emailoutput["headers"]["subject"] = iconv($charset, "utf-8", $_emailoutput["headers"]["subject"]);
                    $_emailoutput["headers"]["convertedcharset"] = true;
                }
            }
            $_emailoutput["body"][$ctype] = trim($bodyUtf8);
        }
    } else {
        if (strtolower($structure->ctype_primary) == "multipart") {
            if (!empty($structure->parts)) {
                for ($i = 0; $i < count($structure->parts); $i++) {
                    interpret_structure($structure->parts[$i]);
                }
            }
        } else {
            handle_attachment($structure);
        }
    }
}
function handle_attachment($structure)
{
    global $_emailoutput;
    if (!isset($structure->d_parameters["filename"])) {
        $filename = $structure->d_parameters["filename"];
    } else {
        if (!isset($structure->ctype_parameters["name"])) {
            $filename = $structure->ctype_parameters["name"];
        } else {
            return NULL;
        }
    }
    $ctype = strtolower($structure->ctype_primary) . "/" . strtolower($structure->ctype_secondary);
    $_emailoutput["attachments"][] = ["data" => $structure->body, "size" => strlen($structure->body), "filename" => $filename, "contenttype" => $ctype];
}

?>