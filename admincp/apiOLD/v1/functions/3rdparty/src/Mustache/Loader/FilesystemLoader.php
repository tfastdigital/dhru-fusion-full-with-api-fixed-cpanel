<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Mustache Template filesystem Loader implementation.
 *
 * A FilesystemLoader instance loads Mustache Template source from the filesystem by name:
 *
 *     $loader = new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views');
 *     $tpl = $loader->load('foo'); // equivalent to `file_get_contents(dirname(__FILE__).'/views/foo.mustache');
 *
 * This is probably the most useful Mustache Loader implementation. It can be used for partials and normal Templates:
 *
 *     $m = new Mustache(array(
 *          'loader'          => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views'),
 *          'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views/partials'),
 *     ));
 */
class Mustache_Loader_FilesystemLoader implements Mustache_Loader
{
    private $baseDir = NULL;
    private $extension = ".mustache";
    private $templates = [];
    public function __construct($baseDir, $options = [])
    {
        $this->baseDir = $baseDir;
        if (strpos($this->baseDir, "://") === false) {
            $this->baseDir = realpath($this->baseDir);
        }
        if ($this->shouldCheckPath() && !is_dir($this->baseDir)) {
            throw new Mustache_Exception_RuntimeException(sprintf("FilesystemLoader baseDir must be a directory: %s", $baseDir));
        }
        if (array_key_exists("extension", $options)) {
            if (empty($options["extension"])) {
                $this->extension = "";
            } else {
                $this->extension = "." . ltrim($options["extension"], ".");
            }
        }
    }
    public function load($name)
    {
        if (!isset($this->templates[$name])) {
            $this->templates[$name] = $this->loadFile($name);
        }
        return $this->templates[$name];
    }
    protected function loadFile($name)
    {
        $fileName = $this->getFileName($name);
        if ($this->shouldCheckPath() && !file_exists($fileName)) {
            throw new Mustache_Exception_UnknownTemplateException($name);
        }
        return file_get_contents($fileName);
    }
    protected function getFileName($name)
    {
        $fileName = $this->baseDir . "/" . $name;
        if (substr($fileName, 0 - strlen($this->extension)) !== $this->extension) {
            $fileName .= $this->extension;
        }
        return $fileName;
    }
    protected function shouldCheckPath()
    {
        return strpos($this->baseDir, "://") === false || strpos($this->baseDir, "file://") === 0;
    }
}

?>