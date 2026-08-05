<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once dirname(__FILE__) . "/Smarty.class.php";
/**
 * Smarty Backward Compatibility Wrapper Class
 *
 * @package Smarty
 */
class SmartyBC extends Smarty
{
    /**
     * Smarty 2 BC
     *
     * @var string
     */
    public $_version = self::SMARTY_VERSION;
    /**
     * This is an array of directories where trusted php scripts reside.
     *
     * @var array
     */
    public $trusted_dir = [];
    public function __construct()
    {
        parent::__construct();
    }
    public function assign_by_ref($tpl_var, &$value)
    {
        $this->assignByRef($tpl_var, $value);
    }
    public function append_by_ref($tpl_var, &$value, $merge = false)
    {
        $this->appendByRef($tpl_var, $value, $merge);
    }
    public function clear_assign($tpl_var)
    {
        $this->clearAssign($tpl_var);
    }
    public function register_function($function, $function_impl, $cacheable = true, $cache_attrs = NULL)
    {
        $this->registerPlugin("function", $function, $function_impl, $cacheable, $cache_attrs);
    }
    public function unregister_function($function)
    {
        $this->unregisterPlugin("function", $function);
    }
    public function register_object($object, $object_impl, $allowed = [], $smarty_args = true, $block_methods = [])
    {
        settype($allowed, "array");
        settype($smarty_args, "boolean");
        $this->registerObject($object, $object_impl, $allowed, $smarty_args, $block_methods);
    }
    public function unregister_object($object)
    {
        $this->unregisterObject($object);
    }
    public function register_block($block, $block_impl, $cacheable = true, $cache_attrs = NULL)
    {
        $this->registerPlugin("block", $block, $block_impl, $cacheable, $cache_attrs);
    }
    public function unregister_block($block)
    {
        $this->unregisterPlugin("block", $block);
    }
    public function register_compiler_function($function, $function_impl, $cacheable = true)
    {
        $this->registerPlugin("compiler", $function, $function_impl, $cacheable);
    }
    public function unregister_compiler_function($function)
    {
        $this->unregisterPlugin("compiler", $function);
    }
    public function register_modifier($modifier, $modifier_impl)
    {
        $this->registerPlugin("modifier", $modifier, $modifier_impl);
    }
    public function unregister_modifier($modifier)
    {
        $this->unregisterPlugin("modifier", $modifier);
    }
    public function register_resource($type, $functions)
    {
        $this->registerResource($type, $functions);
    }
    public function unregister_resource($type)
    {
        $this->unregisterResource($type);
    }
    public function register_prefilter($function)
    {
        $this->registerFilter("pre", $function);
    }
    public function unregister_prefilter($function)
    {
        $this->unregisterFilter("pre", $function);
    }
    public function register_postfilter($function)
    {
        $this->registerFilter("post", $function);
    }
    public function unregister_postfilter($function)
    {
        $this->unregisterFilter("post", $function);
    }
    public function register_outputfilter($function)
    {
        $this->registerFilter("output", $function);
    }
    public function unregister_outputfilter($function)
    {
        $this->unregisterFilter("output", $function);
    }
    public function load_filter($type, $name)
    {
        $this->loadFilter($type, $name);
    }
    public function clear_cache($tpl_file = NULL, $cache_id = NULL, $compile_id = NULL, $exp_time = NULL)
    {
        return $this->clearCache($tpl_file, $cache_id, $compile_id, $exp_time);
    }
    public function clear_all_cache($exp_time = NULL)
    {
        return $this->clearCache(NULL, NULL, NULL, $exp_time);
    }
    public function is_cached($tpl_file, $cache_id = NULL, $compile_id = NULL)
    {
        return $this->isCached($tpl_file, $cache_id, $compile_id);
    }
    public function clear_all_assign()
    {
        $this->clearAllAssign();
    }
    public function clear_compiled_tpl($tpl_file = NULL, $compile_id = NULL, $exp_time = NULL)
    {
        return $this->clearCompiledTemplate($tpl_file, $compile_id, $exp_time);
    }
    public function template_exists($tpl_file)
    {
        return $this->templateExists($tpl_file);
    }
    public function get_template_vars($name = NULL)
    {
        return $this->getTemplateVars($name);
    }
    public function get_config_vars($name = NULL)
    {
        return $this->getConfigVars($name);
    }
    public function config_load($file, $section = NULL, $scope = "global")
    {
        $this->ConfigLoad($file, $section, $scope);
    }
    public function get_registered_object($name)
    {
        return $this->getRegisteredObject($name);
    }
    public function clear_config($var = NULL)
    {
        $this->clearConfig($var);
    }
    public function trigger_error($error_msg, $error_type = E_USER_WARNING)
    {
        trigger_error("Smarty error: " . $error_msg, $error_type);
    }
}

?>