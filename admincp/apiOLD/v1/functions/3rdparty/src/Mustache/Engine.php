<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * A Mustache implementation in PHP.
 *
 * {@link http://defunkt.github.com/mustache}
 *
 * Mustache is a framework-agnostic logic-less templating language. It enforces separation of view
 * logic from template files. In fact, it is not even possible to embed logic in the template.
 *
 * This is very, very rad.
 *
 * @author Justin Hileman {@link http://justinhileman.com}
 */
class Mustache_Engine
{
    private $templates = [];
    private $templateClassPrefix = "__Mustache_";
    private $cache = NULL;
    private $lambdaCache = NULL;
    private $cacheLambdaTemplates = false;
    private $loader = NULL;
    private $partialsLoader = NULL;
    private $helpers = NULL;
    private $escape = NULL;
    private $entityFlags = ENT_COMPAT;
    private $charset = "UTF-8";
    private $logger = NULL;
    private $strictCallables = false;
    private $pragmas = [];
    private $delimiters = NULL;
    private $tokenizer = NULL;
    private $parser = NULL;
    private $compiler = NULL;
    private static $knownPragmas = ["FILTERS" => true, "BLOCKS" => true, "ANCHORED-DOT" => true];
    const VERSION = "2.12.0";
    const SPEC_VERSION = "1.1.2";
    const PRAGMA_FILTERS = "FILTERS";
    const PRAGMA_BLOCKS = "BLOCKS";
    const PRAGMA_ANCHORED_DOT = "ANCHORED-DOT";
    public function __construct($options = [])
    {
        if (isset($options["template_class_prefix"])) {
            if ((string) $options["template_class_prefix"] === "") {
                throw new Mustache_Exception_InvalidArgumentException("Mustache Constructor \"template_class_prefix\" must not be empty");
            }
            $this->templateClassPrefix = $options["template_class_prefix"];
        }
        if (isset($options["cache"])) {
            $cache = $options["cache"];
            if (is_string($cache)) {
                $mode = isset($options["cache_file_mode"]) ? $options["cache_file_mode"] : NULL;
                $cache = new Mustache_Cache_FilesystemCache($cache, $mode);
            }
            $this->setCache($cache);
        }
        if (isset($options["cache_lambda_templates"])) {
            $this->cacheLambdaTemplates = (bool) $options["cache_lambda_templates"];
        }
        if (isset($options["loader"])) {
            $this->setLoader($options["loader"]);
        }
        if (isset($options["partials_loader"])) {
            $this->setPartialsLoader($options["partials_loader"]);
        }
        if (isset($options["partials"])) {
            $this->setPartials($options["partials"]);
        }
        if (isset($options["helpers"])) {
            $this->setHelpers($options["helpers"]);
        }
        if (isset($options["escape"])) {
            if (!is_callable($options["escape"])) {
                throw new Mustache_Exception_InvalidArgumentException("Mustache Constructor \"escape\" option must be callable");
            }
            $this->escape = $options["escape"];
        }
        if (isset($options["entity_flags"])) {
            $this->entityFlags = $options["entity_flags"];
        }
        if (isset($options["charset"])) {
            $this->charset = $options["charset"];
        }
        if (isset($options["logger"])) {
            $this->setLogger($options["logger"]);
        }
        if (isset($options["strict_callables"])) {
            $this->strictCallables = $options["strict_callables"];
        }
        if (isset($options["delimiters"])) {
            $this->delimiters = $options["delimiters"];
        }
        if (isset($options["pragmas"])) {
            foreach ($options["pragmas"] as $pragma) {
                if (!isset(self::$knownPragmas[$pragma])) {
                    throw new Mustache_Exception_InvalidArgumentException(sprintf("Unknown pragma: \"%s\".", $pragma));
                }
                $this->pragmas[$pragma] = true;
            }
        }
    }
    public function render($template, $context = [])
    {
        return $this->loadTemplate($template)->render($context);
    }
    public function getEscape()
    {
        return $this->escape;
    }
    public function getEntityFlags()
    {
        return $this->entityFlags;
    }
    public function getCharset()
    {
        return $this->charset;
    }
    public function getPragmas()
    {
        return array_keys($this->pragmas);
    }
    public function setLoader(Mustache_Loader $loader)
    {
        $this->loader = $loader;
    }
    public function getLoader()
    {
        if (!isset($this->loader)) {
            $this->loader = new Mustache_Loader_StringLoader();
        }
        return $this->loader;
    }
    public function setPartialsLoader(Mustache_Loader $partialsLoader)
    {
        $this->partialsLoader = $partialsLoader;
    }
    public function getPartialsLoader()
    {
        if (!isset($this->partialsLoader)) {
            $this->partialsLoader = new Mustache_Loader_ArrayLoader();
        }
        return $this->partialsLoader;
    }
    public function setPartials($partials = [])
    {
        if (!isset($this->partialsLoader)) {
            $this->partialsLoader = new Mustache_Loader_ArrayLoader();
        }
        if (!$this->partialsLoader instanceof Mustache_Loader_MutableLoader) {
            throw new Mustache_Exception_RuntimeException("Unable to set partials on an immutable Mustache Loader instance");
        }
        $this->partialsLoader->setTemplates($partials);
    }
    public function setHelpers($helpers)
    {
        if (!is_array($helpers) && !$helpers instanceof Traversable) {
            throw new Mustache_Exception_InvalidArgumentException("setHelpers expects an array of helpers");
        }
        $this->getHelpers()->clear();
        foreach ($helpers as $name => $helper) {
            $this->addHelper($name, $helper);
        }
    }
    public function getHelpers()
    {
        if (!isset($this->helpers)) {
            $this->helpers = new Mustache_HelperCollection();
        }
        return $this->helpers;
    }
    public function addHelper($name, $helper)
    {
        $this->getHelpers()->add($name, $helper);
    }
    public function getHelper($name)
    {
        return $this->getHelpers()->get($name);
    }
    public function hasHelper($name)
    {
        return $this->getHelpers()->has($name);
    }
    public function removeHelper($name)
    {
        $this->getHelpers()->remove($name);
    }
    public function setLogger($logger = NULL)
    {
        if ($logger !== NULL && !($logger instanceof Mustache_Logger || is_a($logger, "Psr\\Log\\LoggerInterface"))) {
            throw new Mustache_Exception_InvalidArgumentException("Expected an instance of Mustache_Logger or Psr\\Log\\LoggerInterface.");
        }
        if ($this->getCache()->getLogger() === NULL) {
            $this->getCache()->setLogger($logger);
        }
        $this->logger = $logger;
    }
    public function getLogger()
    {
        return $this->logger;
    }
    public function setTokenizer(Mustache_Tokenizer $tokenizer)
    {
        $this->tokenizer = $tokenizer;
    }
    public function getTokenizer()
    {
        if (!isset($this->tokenizer)) {
            $this->tokenizer = new Mustache_Tokenizer();
        }
        return $this->tokenizer;
    }
    public function setParser(Mustache_Parser $parser)
    {
        $this->parser = $parser;
    }
    public function getParser()
    {
        if (!isset($this->parser)) {
            $this->parser = new Mustache_Parser();
        }
        return $this->parser;
    }
    public function setCompiler(Mustache_Compiler $compiler)
    {
        $this->compiler = $compiler;
    }
    public function getCompiler()
    {
        if (!isset($this->compiler)) {
            $this->compiler = new Mustache_Compiler();
        }
        return $this->compiler;
    }
    public function setCache(Mustache_Cache $cache)
    {
        if (isset($this->logger) && $cache->getLogger() === NULL) {
            $cache->setLogger($this->getLogger());
        }
        $this->cache = $cache;
    }
    public function getCache()
    {
        if (!isset($this->cache)) {
            $this->setCache(new Mustache_Cache_NoopCache());
        }
        return $this->cache;
    }
    protected function getLambdaCache()
    {
        if ($this->cacheLambdaTemplates) {
            return $this->getCache();
        }
        if (!isset($this->lambdaCache)) {
            $this->lambdaCache = new Mustache_Cache_NoopCache();
        }
        return $this->lambdaCache;
    }
    public function getTemplateClassName($source)
    {
        $chunks = ["charset" => $this->charset, "delimiters" => $this->delimiters ? $this->delimiters : "{{ }}", "entityFlags" => $this->entityFlags, "escape" => isset($this->escape) ? "custom" : "default", "key" => $source instanceof Mustache_Source ? $source->getKey() : "source", "pragmas" => $this->getPragmas(), "strictCallables" => $this->strictCallables, "version" => "2.12.0"];
        $key = json_encode($chunks);
        if (!$source instanceof Mustache_Source) {
            $key .= "\n" . $source;
        }
        return $this->templateClassPrefix . md5($key);
    }
    public function loadTemplate($name)
    {
        return $this->loadSource($this->getLoader()->load($name));
    }
    public function loadPartial($name)
    {
        try {
            if (isset($this->partialsLoader)) {
                $loader = $this->partialsLoader;
            } else {
                if (isset($this->loader) && !$this->loader instanceof Mustache_Loader_StringLoader) {
                    $loader = $this->loader;
                } else {
                    throw new Mustache_Exception_UnknownTemplateException($name);
                }
            }
            return $this->loadSource($loader->load($name));
        } catch (Mustache_Exception_UnknownTemplateException $e) {
            $this->log(Mustache_Logger::WARNING, "Partial not found: \"{name}\"", ["name" => $e->getTemplateName()]);
        }
    }
    public function loadLambda($source, $delims = NULL)
    {
        if ($delims !== NULL) {
            $source = $delims . "\n" . $source;
        }
        return $this->loadSource($source, $this->getLambdaCache());
    }
    private function loadSource($source, Mustache_Cache $cache = NULL)
    {
        $className = $this->getTemplateClassName($source);
        if (!isset($this->templates[$className])) {
            if ($cache === NULL) {
                $cache = $this->getCache();
            }
            if (!class_exists($className, false) && !$cache->load($className)) {
                $compiled = $this->compile($source);
                $cache->cache($className, $compiled);
            }
            $this->log(Mustache_Logger::DEBUG, "Instantiating template: \"{className}\"", ["className" => $className]);
            $this->templates[$className] = new $className($this);
        }
        return $this->templates[$className];
    }
    private function tokenize($source)
    {
        return $this->getTokenizer()->scan($source, $this->delimiters);
    }
    private function parse($source)
    {
        $parser = $this->getParser();
        $parser->setPragmas($this->getPragmas());
        return $parser->parse($this->tokenize($source));
    }
    private function compile($source)
    {
        $name = $this->getTemplateClassName($source);
        $this->log(Mustache_Logger::INFO, "Compiling template to \"{className}\" class", ["className" => $name]);
        if ($source instanceof Mustache_Source) {
            $source = $source->getSource();
        }
        $tree = $this->parse($source);
        $compiler = $this->getCompiler();
        $compiler->setPragmas($this->getPragmas());
        return $compiler->compile($source, $tree, $name, isset($this->escape), $this->charset, $this->strictCallables, $this->entityFlags);
    }
    private function log($level, $message, $context = [])
    {
        if (isset($this->logger)) {
            $this->logger->log($level, $message, $context);
        }
    }
}

?>