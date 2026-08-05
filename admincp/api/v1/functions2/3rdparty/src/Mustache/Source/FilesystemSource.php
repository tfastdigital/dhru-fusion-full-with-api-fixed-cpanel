<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Mustache template Filesystem Source.
 *
 * This template Source uses stat() to generate the Source key, so that using
 * pre-compiled templates doesn't require hitting the disk to read the source.
 * It is more suitable for production use, and is used by default in the
 * ProductionFilesystemLoader.
 */
class Mustache_Source_FilesystemSource implements Mustache_Source
{
    private $fileName = NULL;
    private $statProps = NULL;
    private $stat = NULL;
    public function __construct($fileName, $statProps)
    {
        $this->fileName = $fileName;
        $this->statProps = $statProps;
    }
    public function getKey()
    {
        $chunks = ["fileName" => $this->fileName];
        if (!empty($this->statProps)) {
            if (!isset($this->stat)) {
                $this->stat = @stat($this->fileName);
            }
            if ($this->stat === false) {
                throw new RuntimeException(sprintf("Failed to read source file \"%s\".", $this->fileName));
            }
            foreach ($this->statProps as $prop) {
                $chunks[$prop] = $this->stat[$prop];
            }
        }
        return json_encode($chunks);
    }
    public function getSource()
    {
        return file_get_contents($this->fileName);
    }
}

?>