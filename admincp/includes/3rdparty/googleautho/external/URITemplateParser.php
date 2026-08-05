<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * A URI Template Parser which is used by the apiREST class to resolve the REST requests
 * Blogpost: http://lab.kevburnsjr.com/php-uri-template-parser
 * Source: http://github.com/KevBurnsJr/php-uri-template-parser
 */
class URI_Template_Parser
{
    public static $reserved_pct = NULL;
    public static $operators = ["+", ";", "?", "/", "."];
    public static $reserved_operators = ["|", "!", "@"];
    public static $explode_modifiers = ["+", "*"];
    public static $partial_modifiers = [":", "^"];
    public static $gen_delims = [":", "/", "?", "#", "[", "]", "@"];
    public static $gen_delims_pct = ["%3A", "%2F", "%3F", "%23", "%5B", "%5D", "%40"];
    public static $sub_delims = ["!", "\$", "&", "'", "(", ")", "*", "+", ",", ";", "="];
    public static $sub_delims_pct = ["%21", "%24", "%26", "%27", "%28", "%29", "%2A", "%2B", "%2C", "%3B", "%3D"];
    public static $reserved = NULL;
    public function __construct($template)
    {
        self::$reserved = array_merge(self::$gen_delims, self::$sub_delims);
        self::$reserved_pct = array_merge(self::$gen_delims_pct, self::$sub_delims_pct);
        $this->template = $template;
    }
    public function expand($data)
    {
        if (!is_array($data)) {
            $data = (array) $data;
        }
        preg_match_all("/\\{([^\\}]*)\\}/", $this->template, $em);
        foreach ($em[1] as $i => $bare_expression) {
            preg_match("/^([\\+\\;\\?\\/\\.]{1})?(.*)\$/", $bare_expression, $lm);
            $exp = new StdClass();
            $exp->expression = $em[0][$i];
            list($exp->operator, $exp->variable_list) = $lm;
            $exp->varspecs = explode(",", $exp->variable_list);
            $exp->vars = [];
            foreach ($exp->varspecs as $varspec) {
                preg_match("/^([a-zA-Z0-9_]+)([\\*\\+]{1})?([\\:\\^][0-9-]+)?(\\=[^,]+)?\$/", $varspec, $vm);
                $var = new StdClass();
                $var->name = $vm[1];
                $var->modifier = isset($vm[2]) && $vm[2] ? $vm[2] : NULL;
                $var->modifier = isset($vm[3]) && $vm[3] ? $vm[3] : $var->modifier;
                $var->default = isset($vm[4]) ? substr($vm[4], 1) : NULL;
                $exp->vars[] = $var;
            }
            $exp->reserved = false;
            $exp->prefix = "";
            $exp->delimiter = ",";
            switch ($exp->operator) {
                case "+":
                    $exp->reserved = "true";
                    break;
                case ";":
                    $exp->prefix = ";";
                    $exp->delimiter = ";";
                    break;
                case "?":
                    $exp->prefix = "?";
                    $exp->delimiter = "&";
                    break;
                case "/":
                    $exp->prefix = "/";
                    $exp->delimiter = "/";
                    break;
                case ".":
                    $exp->prefix = ".";
                    $exp->delimiter = ".";
                    break;
                default:
                    $expressions[] = $exp;
            }
        }
        $this->expansion = $this->template;
        foreach ($expressions as $exp) {
            $part = $exp->prefix;
            $exp->one_var_defined = false;
            foreach ($exp->vars as $var) {
                $val = "";
                if ($exp->one_var_defined && isset($data[$var->name])) {
                    $part .= $exp->delimiter;
                }
                if (isset($data[$var->name])) {
                    $exp->one_var_defined = true;
                    $var->data = $data[$var->name];
                    $val = self::val_from_var($var, $exp);
                } else {
                    if ($var->default) {
                        $exp->one_var_defined = true;
                        $val = $var->default;
                    }
                }
                $part .= $val;
            }
            if (!$exp->one_var_defined) {
                $part = "";
            }
            $this->expansion = str_replace($exp->expression, $part, $this->expansion);
        }
        return $this->expansion;
    }
    private function val_from_var($var, $exp)
    {
        $val = "";
        if (is_array($var->data)) {
            $i = 0;
            if ($exp->operator == "?" && !$var->modifier) {
                $val .= $var->name . "=";
            }
            foreach ($var->data as $k => $v) {
                $del = $var->modifier ? $exp->delimiter : ",";
                $ek = rawurlencode($k);
                $ev = rawurlencode($v);
                if ($k !== $i) {
                    if ($var->modifier == "+") {
                        $val .= $var->name . ".";
                    }
                    if ($exp->operator == "?" && $var->modifier || $exp->operator == ";" && $var->modifier == "*" || $exp->operator == ";" && $var->modifier == "+") {
                        $val .= $ek . "=";
                    } else {
                        $val .= $ek . $del;
                    }
                } else {
                    if ($var->modifier == "+") {
                        if ($exp->operator == ";" && $var->modifier == "*" || $exp->operator == ";" && $var->modifier == "+" || $exp->operator == "?" && $var->modifier == "+") {
                            $val .= $var->name . "=";
                        } else {
                            $val .= $var->name . ".";
                        }
                    }
                }
                $val .= $ev . $del;
                $i++;
            }
            $val = trim($val, $del);
        } else {
            if ($exp->operator == "?") {
                $val = $var->name . (isset($var->data) ? "=" : "");
            } else {
                if ($exp->operator == ";") {
                    $val = $var->name . ($var->data ? "=" : "");
                }
            }
            $val .= rawurlencode($var->data);
            if ($exp->operator == "+") {
                $val = str_replace(self::$reserved_pct, self::$reserved, $val);
            }
        }
        return $val;
    }
    public function match($uri)
    {
    }
    public function __toString()
    {
        return $this->template;
    }
}

?>