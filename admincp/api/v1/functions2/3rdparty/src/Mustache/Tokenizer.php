<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Mustache Tokenizer class.
 *
 * This class is responsible for turning raw template source into a set of Mustache tokens.
 */
class Mustache_Tokenizer
{
    private $state = NULL;
    private $tagType = NULL;
    private $buffer = NULL;
    private $tokens = NULL;
    private $seenTag = NULL;
    private $line = NULL;
    private $otag = NULL;
    private $ctag = NULL;
    private $otagLen = NULL;
    private $ctagLen = NULL;
    private static $tagTypes = ["#" => true, "^" => true, "/" => true, "!" => true, ">" => true, "<" => true, "=" => true, "_v" => true, "{" => true, "&" => true, "%" => true, "\$" => true];
    const IN_TEXT = 0;
    const IN_TAG_TYPE = 1;
    const IN_TAG = 2;
    const T_SECTION = "#";
    const T_INVERTED = "^";
    const T_END_SECTION = "/";
    const T_COMMENT = "!";
    const T_PARTIAL = ">";
    const T_PARENT = "<";
    const T_DELIM_CHANGE = "=";
    const T_ESCAPED = "_v";
    const T_UNESCAPED = "{";
    const T_UNESCAPED_2 = "&";
    const T_TEXT = "_t";
    const T_PRAGMA = "%";
    const T_BLOCK_VAR = "\$";
    const T_BLOCK_ARG = "\$arg";
    const TYPE = "type";
    const NAME = "name";
    const OTAG = "otag";
    const CTAG = "ctag";
    const LINE = "line";
    const INDEX = "index";
    const END = "end";
    const INDENT = "indent";
    const NODES = "nodes";
    const VALUE = "value";
    const FILTERS = "filters";
    public function scan($text, $delimiters = NULL)
    {
        $encoding = NULL;
        if (function_exists("mb_internal_encoding") && ini_get("mbstring.func_overload") & 2) {
            $encoding = mb_internal_encoding();
            mb_internal_encoding("ASCII");
        }
        $this->reset();
        if ($delimiters = trim($delimiters)) {
            $this->setDelimiters($delimiters);
        }
        $len = strlen($text);
        $i = 0;
        while ($i < $len) {
            switch ($this->state) {
                case 0:
                    if ($this->tagChange($this->otag, $this->otagLen, $text, $i)) {
                        $i--;
                        $this->flushBuffer();
                        $this->state = 1;
                    } else {
                        $char = $text[$i];
                        $this->buffer .= $char;
                        if ($char === "\n") {
                            $this->flushBuffer();
                            $this->line++;
                        }
                    }
                    break;
                case 1:
                    $i += $this->otagLen - 1;
                    $char = $text[$i + 1];
                    if (isset(self::$tagTypes[$char])) {
                        $tag = $char;
                        $this->tagType = $tag;
                    } else {
                        $tag = NULL;
                        $this->tagType = "_v";
                    }
                    if ($this->tagType === "=") {
                        $i = $this->changeDelimiters($text, $i);
                        $this->state = 0;
                    } else {
                        if ($this->tagType === "%") {
                            $i = $this->addPragma($text, $i);
                            $this->state = 0;
                        } else {
                            if ($tag !== NULL) {
                                $i++;
                            }
                            $this->state = 2;
                        }
                    }
                    $this->seenTag = $i;
                    break;
                default:
                    if ($this->tagChange($this->ctag, $this->ctagLen, $text, $i)) {
                        $token = ["type" => $this->tagType, "name" => trim($this->buffer), "otag" => $this->otag, "ctag" => $this->ctag, "line" => $this->line, "index" => $this->tagType === "/" ? $this->seenTag - $this->otagLen : $i + $this->ctagLen];
                        if ($this->tagType === "{") {
                            if ($this->ctag === "}}") {
                                if ($i + 2 < $len && $text[$i + 2] === "}") {
                                    $i++;
                                } else {
                                    $msg = sprintf("Mismatched tag delimiters: %s on line %d", $token["name"], $token["line"]);
                                    throw new Mustache_Exception_SyntaxException($msg, $token);
                                }
                            } else {
                                $lastName = $token["name"];
                                if (substr($lastName, -1) === "}") {
                                    $token["name"] = trim(substr($lastName, 0, -1));
                                } else {
                                    $msg = sprintf("Mismatched tag delimiters: %s on line %d", $token["name"], $token["line"]);
                                    throw new Mustache_Exception_SyntaxException($msg, $token);
                                }
                            }
                        }
                        $this->buffer = "";
                        $i += $this->ctagLen - 1;
                        $this->state = 0;
                        $this->tokens[] = $token;
                    } else {
                        $this->buffer .= $text[$i];
                    }
                    $i++;
            }
        }
        $this->flushBuffer();
        if ($encoding) {
            mb_internal_encoding($encoding);
        }
        return $this->tokens;
    }
    private function reset()
    {
        $this->state = 0;
        $this->tagType = NULL;
        $this->buffer = "";
        $this->tokens = [];
        $this->seenTag = false;
        $this->line = 0;
        $this->otag = "{{";
        $this->ctag = "}}";
        $this->otagLen = 2;
        $this->ctagLen = 2;
    }
    private function flushBuffer()
    {
        if (0 < strlen($this->buffer)) {
            $this->tokens[] = ["type" => "_t", "line" => $this->line, "value" => $this->buffer];
            $this->buffer = "";
        }
    }
    private function changeDelimiters($text, $index)
    {
        $startIndex = strpos($text, "=", $index) + 1;
        $close = "=" . $this->ctag;
        $closeIndex = strpos($text, $close, $index);
        $this->setDelimiters(trim(substr($text, $startIndex, $closeIndex - $startIndex)));
        $this->tokens[] = ["type" => "=", "line" => $this->line];
        return $closeIndex + strlen($close) - 1;
    }
    private function setDelimiters($delimiters)
    {
        list($otag, $ctag) = explode(" ", $delimiters);
        $this->otag = $otag;
        $this->ctag = $ctag;
        $this->otagLen = strlen($otag);
        $this->ctagLen = strlen($ctag);
    }
    private function addPragma($text, $index)
    {
        $end = strpos($text, $this->ctag, $index);
        $pragma = trim(substr($text, $index + 2, $end - $index - 2));
        array_unshift($this->tokens, ["type" => "%", "name" => $pragma, "line" => 0]);
        return $end + $this->ctagLen - 1;
    }
    private function tagChange($tag, $tagLen, $text, $index)
    {
        return substr($text, $index, $tagLen) === $tag;
    }
}

?>