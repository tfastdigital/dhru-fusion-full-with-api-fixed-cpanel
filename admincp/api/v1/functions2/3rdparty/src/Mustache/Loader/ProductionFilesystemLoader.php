<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Mustache Template production filesystem Loader implementation.
 *
 * A production-ready FilesystemLoader, which doesn't require reading a file if it already exists in the template cache.
 *
 * {@inheritdoc}
 */
class Mustache_Loader_ProductionFilesystemLoader extends Mustache_Loader_FilesystemLoader
{
    private $statProps = NULL;
    public function __construct($baseDir, $options = [])
    {
        parent::__construct($baseDir, $options);
        if (array_key_exists("stat_props", $options)) {
            if (empty($options["stat_props"])) {
                $this->statProps = [];
            } else {
                $this->statProps = $options["stat_props"];
            }
        } else {
            $this->statProps = ["size", "mtime"];
        }
    }
    protected function loadFile($name)
    {
        $fileName = $this->getFileName($name);
        if (!file_exists($fileName)) {
            throw new Mustache_Exception_UnknownTemplateException($name);
        }
        return new Mustache_Source_FilesystemSource($fileName, $this->statProps);
    }
}

?>