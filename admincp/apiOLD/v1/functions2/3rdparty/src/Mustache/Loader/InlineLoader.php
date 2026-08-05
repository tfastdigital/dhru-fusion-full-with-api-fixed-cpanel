<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * A Mustache Template loader for inline templates.
 *
 * With the InlineLoader, templates can be defined at the end of any PHP source
 * file:
 *
 *     $loader  = new Mustache_Loader_InlineLoader(__FILE__, __COMPILER_HALT_OFFSET__);
 *     $hello   = $loader->load('hello');
 *     $goodbye = $loader->load('goodbye');
 *
 *     __halt_compiler();
 *
 *     @@ hello
 *     Hello, {{ planet }}!
 *
 *     @@ goodbye
 *     Goodbye, cruel {{ planet }}
 *
 * Templates are deliniated by lines containing only `@@ name`.
 *
 * The InlineLoader is well-suited to micro-frameworks such as Silex:
 *
 *     $app->register(new MustacheServiceProvider, array(
 *         'mustache.loader' => new Mustache_Loader_InlineLoader(__FILE__, __COMPILER_HALT_OFFSET__)
 *     ));
 *
 *     $app->get('/{name}', function ($name) use ($app) {
 *         return $app['mustache']->render('hello', compact('name'));
 *     })
 *     $this->value('name', 'world');
 *
 *     // ...
 *
 *     __halt_compiler();
 *
 *     @@ hello
 *     Hello, {{ name }}!
 */
class Mustache_Loader_InlineLoader implements Mustache_Loader
{
    protected $fileName = NULL;
    protected $offset = NULL;
    protected $templates = NULL;
    public function __construct($fileName, $offset)
    {
        if (!is_file($fileName)) {
            throw new Mustache_Exception_InvalidArgumentException("InlineLoader expects a valid filename.");
        }
        if (!is_int($offset) || $offset < 0) {
            throw new Mustache_Exception_InvalidArgumentException("InlineLoader expects a valid file offset.");
        }
        $this->fileName = $fileName;
        $this->offset = $offset;
    }
    public function load($name)
    {
        $this->loadTemplates();
        if (!array_key_exists($name, $this->templates)) {
            throw new Mustache_Exception_UnknownTemplateException($name);
        }
        return $this->templates[$name];
    }
    protected function loadTemplates()
    {
        if ($this->templates === NULL) {
            $this->templates = [];
            $data = file_get_contents($this->fileName, false, NULL, $this->offset);
            foreach (preg_split("/^@@(?= [\\w\\d\\.]+\$)/m", $data, -1) as $chunk) {
                if (trim($chunk)) {
                    list($name, $content) = explode("\n", $chunk, 2);
                    $this->templates[trim($name)] = trim($content);
                }
            }
        }
    }
}

?>