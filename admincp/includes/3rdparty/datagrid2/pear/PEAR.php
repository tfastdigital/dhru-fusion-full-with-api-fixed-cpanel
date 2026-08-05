<?php
/*
 *after.com
 * @ Release: 13/06/2023
 */

define("PEAR_ERROR_RETURN", 1);
define("PEAR_ERROR_PRINT", 2);
define("PEAR_ERROR_TRIGGER", 4);
define("PEAR_ERROR_DIE", 8);
define("PEAR_ERROR_CALLBACK", 16);
define("PEAR_ERROR_EXCEPTION", 32);
define("PEAR_ZE2", function_exists("version_compare") && version_compare(zend_version(), "2-dev", "ge"));
if (substr(PHP_OS, 0, 3) == "WIN") {
    define("OS_WINDOWS", true);
    define("OS_UNIX", false);
    define("PEAR_OS", "Windows");
} else {
    define("OS_WINDOWS", false);
    define("OS_UNIX", true);
    define("PEAR_OS", "Unix");
}
if (!defined("PATH_SEPARATOR")) {
    if (OS_WINDOWS) {
        define("PATH_SEPARATOR", ";");
    } else {
        define("PATH_SEPARATOR", ":");
    }
}
$GLOBALS["_PEAR_default_error_mode"] = PEAR_ERROR_RETURN;
$GLOBALS["_PEAR_default_error_options"] = 1024;
$GLOBALS["_PEAR_destructor_object_list"] = [];
$GLOBALS["_PEAR_shutdown_funcs"] = [];
$GLOBALS["_PEAR_error_handler_stack"] = [];
register_shutdown_function("_PEAR_call_destructors");
/**
 * Base class for other PEAR classes.  Provides rudimentary
 * emulation of destructors.
 *
 * If you want a destructor in your class, inherit PEAR and make a
 * destructor method called _yourclassname (same name as the
 * constructor, but with a "_" prefix).  Also, in your constructor you
 * have to call the PEAR constructor: $this->PEAR();.
 * The destructor method will be called without parameters.  Note that
 * at in some SAPI implementations (such as Apache), any output during
 * the request shutdown (in which destructors are called) seems to be
 * discarded.  If you need to get any debug information from your
 * destructor, use error_log(), syslog() or something similar.
 *
 * IMPORTANT! To use the emulated destructors you need to create the
 * objects by reference: $obj =& new PEAR_child;
 *
 * @since PHP 4.0.2
 * @author Stig Bakken <ssb@php.net>
 * @see http://pear.php.net/manual/
 */
class PEAR
{
    /**
     * Whether to enable internal debug messages.
     *
     * @var     bool
     * @access  private
     */
    public $_debug = true;
    /**
     * Default error mode for this object.
     *
     * @var     int
     * @access  private
     */
    public $_default_error_mode = NULL;
    /**
     * Default error options used for this object when error mode
     * is PEAR_ERROR_TRIGGER.
     *
     * @var     int
     * @access  private
     */
    public $_default_error_options = NULL;
    /**
     * Default error handler (callback) for this object, if error mode is
     * PEAR_ERROR_CALLBACK.
     *
     * @var     string
     * @access  private
     */
    public $_default_error_handler = "";
    /**
     * Which class to use for error objects.
     *
     * @var     string
     * @access  private
     */
    public $_error_class = "PEAR_Error";
    /**
     * An array of expected errors.
     *
     * @var     array
     * @access  private
     */
    public $_expected_errors = [];
    public function PEAR($error_class = NULL)
    {
        $classname = get_class($this);
        if ($this->_debug) {
            echo "PEAR constructor called, class=" . $classname . "\n";
        }
        if ($error_class !== NULL) {
            $this->_error_class = $error_class;
            while ($classname) {
            }
        }
        $destructor = "_" . $classname;
        if (method_exists($this, $destructor)) {
            global $_PEAR_destructor_object_list;
            $_PEAR_destructor_object_list[] =& $this;
        } else {
            $classname = get_parent_class($classname);
        }
    }
    public function _PEAR()
    {
        if ($this->_debug) {
            printf("PEAR destructor called, class=%s\n", get_class($this));
        }
    }
    public function &getStaticProperty($class, $var)
    {
        return $properties[$class][$var];
    }
    public function registerShutdownFunc($func, $args = [])
    {
        $GLOBALS["_PEAR_shutdown_funcs"][] = [$func, $args];
    }
    public function isError($data, $code = NULL)
    {
        if (is_a($data, "PEAR_Error")) {
            if (is_null($code)) {
                return true;
            }
            if (is_string($code)) {
                return $data->getMessage() == $code;
            }
            return $data->getCode() == $code;
        }
        return false;
    }
    public function setErrorHandling($mode = NULL, $options = NULL)
    {
        if (isset($this) && is_a($this, "PEAR")) {
            $setmode =& $this->_default_error_mode;
            $setoptions =& $this->_default_error_options;
        } else {
            $setmode =& $GLOBALS["_PEAR_default_error_mode"];
            $setoptions =& $GLOBALS["_PEAR_default_error_options"];
        }
        switch ($mode) {
            case PEAR_ERROR_EXCEPTION:
            case PEAR_ERROR_RETURN:
            case PEAR_ERROR_PRINT:
            case PEAR_ERROR_TRIGGER:
            case PEAR_ERROR_DIE:
            case NULL:
                $setmode = $mode;
                $setoptions = $options;
                break;
            case PEAR_ERROR_CALLBACK:
                $setmode = $mode;
                if (is_callable($options)) {
                    $setoptions = $options;
                } else {
                    trigger_error("invalid error callback", 512);
                }
                break;
            default:
                trigger_error("invalid error mode", 512);
        }
    }
    public function expectError($code = "*")
    {
        if (is_array($code)) {
            array_push($this->_expected_errors, $code);
        } else {
            array_push($this->_expected_errors, [$code]);
        }
        return sizeof($this->_expected_errors);
    }
    public function popExpect()
    {
        return array_pop($this->_expected_errors);
    }
    public function _checkDelExpect($error_code)
    {
        $deleted = false;
        foreach ($this->_expected_errors as $key => $error_array) {
            if (in_array($error_code, $error_array)) {
                unset($this->_expected_errors[$key][array_search($error_code, $error_array)]);
                $deleted = true;
            }
            if (0 == count($this->_expected_errors[$key])) {
                unset($this->_expected_errors[$key]);
            }
        }
        return $deleted;
    }
    public function delExpect($error_code)
    {
        $deleted = false;
        if (is_array($error_code) && 0 != count($error_code)) {
            foreach ($error_code as $key => $error) {
                if ($this->_checkDelExpect($error)) {
                    $deleted = true;
                } else {
                    $deleted = false;
                }
            }
            return $deleted ? true : PEAR::raiseError("The expected error you submitted does not exist");
        } else {
            if (!empty($error_code)) {
                if ($this->_checkDelExpect($error_code)) {
                    return true;
                }
                return PEAR::raiseError("The expected error you submitted does not exist");
            }
            return PEAR::raiseError("The expected error you submitted is empty");
        }
    }
    public function raiseError($message = NULL, $code = NULL, $mode = NULL, $options = NULL, $userinfo = NULL, $error_class = NULL, $skipmsg = false)
    {
        if (is_object($message)) {
            $code = $message->getCode();
            $userinfo = $message->getUserInfo();
            $error_class = $message->getType();
            $message->error_message_prefix = "";
            $message = $message->getMessage();
        }
        if (isset($this) && isset($this->_expected_errors) && 0 < sizeof($this->_expected_errors) && sizeof($exp = end($this->_expected_errors)) && ($exp[0] == "*" || is_int(reset($exp)) && in_array($code, $exp) || is_string(reset($exp)) && in_array($message, $exp))) {
            $mode = PEAR_ERROR_RETURN;
        }
        if ($mode === NULL) {
            if (isset($this) && isset($this->_default_error_mode)) {
                $mode = $this->_default_error_mode;
                $options = $this->_default_error_options;
            } else {
                if (isset($GLOBALS["_PEAR_default_error_mode"])) {
                    $mode = $GLOBALS["_PEAR_default_error_mode"];
                    $options = $GLOBALS["_PEAR_default_error_options"];
                }
            }
        }
        if ($error_class !== NULL) {
            $ec = $error_class;
        } else {
            if (isset($this) && isset($this->_error_class)) {
                $ec = $this->_error_class;
            } else {
                $ec = "PEAR_Error";
            }
        }
        if ($skipmsg) {
            return new $ec($code, $mode, $options, $userinfo);
        }
        return new $ec($message, $code, $mode, $options, $userinfo);
    }
    public function throwError($message = NULL, $code = NULL, $userinfo = NULL)
    {
        if (isset($this) && is_a($this, "PEAR")) {
            return $this->raiseError($message, $code, NULL, NULL, $userinfo);
        }
        return PEAR::raiseError($message, $code, NULL, NULL, $userinfo);
    }
    public function pushErrorHandling($mode, $options = NULL)
    {
        $stack =& $GLOBALS["_PEAR_error_handler_stack"];
        if (isset($this) && is_a($this, "PEAR")) {
            $def_mode =& $this->_default_error_mode;
            $def_options =& $this->_default_error_options;
        } else {
            $def_mode =& $GLOBALS["_PEAR_default_error_mode"];
            $def_options =& $GLOBALS["_PEAR_default_error_options"];
        }
        $stack[] = [$def_mode, $def_options];
        if (isset($this) && is_a($this, "PEAR")) {
            $this->setErrorHandling($mode, $options);
        } else {
            PEAR::setErrorHandling($mode, $options);
        }
        $stack[] = [$mode, $options];
        return true;
    }
    public function popErrorHandling()
    {
        $stack =& $GLOBALS["_PEAR_error_handler_stack"];
        array_pop($stack);
        sizeof($stack);
        list($mode, $options) = $stack[sizeof($stack) - 1];
        array_pop($stack);
        if (isset($this) && is_a($this, "PEAR")) {
            $this->setErrorHandling($mode, $options);
        } else {
            PEAR::setErrorHandling($mode, $options);
        }
        return true;
    }
    public function loadExtension($ext)
    {
        if (!extension_loaded($ext)) {
            if (ini_get("enable_dl") != 1 || ini_get("safe_mode") == 1) {
                return false;
            }
            if (OS_WINDOWS) {
                $suffix = ".dll";
            } else {
                if (PHP_OS == "HP-UX") {
                    $suffix = ".sl";
                } else {
                    if (PHP_OS == "AIX") {
                        $suffix = ".a";
                    } else {
                        if (PHP_OS == "OSX") {
                            $suffix = ".bundle";
                        } else {
                            $suffix = ".so";
                        }
                    }
                }
            }
            return @dl("php_" . $ext . $suffix) || @dl($ext . $suffix);
        }
        return true;
    }
}
class PEAR_Error
{
    public $error_message_prefix = "";
    public $mode = PEAR_ERROR_RETURN;
    public $level = 1024;
    public $code = -1;
    public $message = "";
    public $userinfo = "";
    public $backtrace = NULL;
    public function PEAR_Error($message = "unknown error", $code = NULL, $mode = NULL, $options = NULL, $userinfo = NULL)
    {
        if ($mode === NULL) {
            $mode = PEAR_ERROR_RETURN;
        }
        $this->message = $message;
        $this->code = $code;
        $this->mode = $mode;
        $this->userinfo = $userinfo;
        if (function_exists("debug_backtrace")) {
            $this->backtrace = debug_backtrace();
        }
        if ($mode & PEAR_ERROR_CALLBACK) {
            $this->level = 1024;
            $this->callback = $options;
        } else {
            if ($options === NULL) {
                $options = 1024;
            }
            $this->level = $options;
            $this->callback = NULL;
        }
        if ($this->mode & PEAR_ERROR_PRINT) {
            if (is_null($options) || is_int($options)) {
                $format = "%s";
            } else {
                $format = $options;
            }
            printf($format, $this->getMessage());
        }
        if ($this->mode & PEAR_ERROR_TRIGGER) {
            trigger_error($this->getMessage(), $this->level);
        }
        if ($this->mode & PEAR_ERROR_DIE) {
            $msg = $this->getMessage();
            if (is_null($options) || is_int($options)) {
                $format = "%s";
                if (substr($msg, -1) != "\n") {
                    $msg .= "\n";
                }
            } else {
                $format = $options;
            }
            exit(sprintf($format, $msg));
        }
        if ($this->mode & PEAR_ERROR_CALLBACK && is_callable($this->callback)) {
            call_user_func($this->callback, $this);
        }
        if ($this->mode & PEAR_ERROR_EXCEPTION) {
            trigger_error("PEAR_ERROR_EXCEPTION is obsolete, use class PEAR_ErrorStack for exceptions", 512);
            eval("\$e = new Exception(\$this->message, \$this->code);\$e->PEAR_Error = \$this;throw(\$e);");
        }
    }
    public function getMode()
    {
        return $this->mode;
    }
    public function getCallback()
    {
        return $this->callback;
    }
    public function getMessage()
    {
        return $this->error_message_prefix . $this->message;
    }
    public function getCode()
    {
        return $this->code;
    }
    public function getType()
    {
        return get_class($this);
    }
    public function getUserInfo()
    {
        return $this->userinfo;
    }
    public function getDebugInfo()
    {
        return $this->getUserInfo();
    }
    public function getBacktrace($frame = NULL)
    {
        if ($frame === NULL) {
            return $this->backtrace;
        }
        return $this->backtrace[$frame];
    }
    public function addUserInfo($info)
    {
        if (empty($this->userinfo)) {
            $this->userinfo = $info;
        } else {
            $this->userinfo .= " ** " . $info;
        }
    }
    public function toString()
    {
        $modes = [];
        $levels = ["1024" => "notice", "512" => "warning", "256" => "error"];
        if ($this->mode & PEAR_ERROR_CALLBACK) {
            if (is_array($this->callback)) {
                $callback = get_class($this->callback[0]) . "::" . $this->callback[1];
            } else {
                $callback = $this->callback;
            }
            return sprintf("[%s: message=\"%s\" code=%d mode=callback callback=%s prefix=\"%s\" info=\"%s\"]", get_class($this), $this->message, $this->code, $callback, $this->error_message_prefix, $this->userinfo);
        }
        if ($this->mode & PEAR_ERROR_PRINT) {
            $modes[] = "print";
        }
        if ($this->mode & PEAR_ERROR_TRIGGER) {
            $modes[] = "trigger";
        }
        if ($this->mode & PEAR_ERROR_DIE) {
            $modes[] = "die";
        }
        if ($this->mode & PEAR_ERROR_RETURN) {
            $modes[] = "return";
        }
        return sprintf("[%s: message=\"%s\" code=%d mode=%s level=%s prefix=\"%s\" info=\"%s\"]", get_class($this), $this->message, $this->code, implode("|", $modes), $levels[$this->level], $this->error_message_prefix, $this->userinfo);
    }
}
function _PEAR_call_destructors()
{
    global $_PEAR_destructor_object_list;
    if (is_array($_PEAR_destructor_object_list) && sizeof($_PEAR_destructor_object_list)) {
        reset($_PEAR_destructor_object_list);
        while (list($k, $objref) = each($_PEAR_destructor_object_list)) {
            $classname = get_class($objref);
            while ($classname) {
                $destructor = "_" . $classname;
                if (method_exists($objref, $destructor)) {
                    $objref->{$destructor}();
                } else {
                    $classname = get_parent_class($classname);
                }
            }
        }
        $_PEAR_destructor_object_list = [];
    }
    if (is_array($GLOBALS["_PEAR_shutdown_funcs"]) && !empty($GLOBALS["_PEAR_shutdown_funcs"])) {
        foreach ($GLOBALS["_PEAR_shutdown_funcs"] as $value) {
            call_user_func_array($value[0], $value[1]);
        }
    }
}

?>