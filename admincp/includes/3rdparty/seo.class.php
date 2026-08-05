<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class xml_sitemap_generator_config
{
    private $_domain = NULL;
    private $_path = NULL;
    private $_filename = NULL;
    private $_entries = [];
    public function get($arg)
    {
        switch ($arg) {
            case "domain":
                return $this->_domain;
                break;
            case "path":
                return $this->_path;
                break;
            case "filename":
                return $this->_filename;
                break;
            case "filepath":
                return $this->_getFilepath();
                break;
            case "entries":
                return $this->_entries;
                break;
        }
    }
    public function setDomain($domain)
    {
        $this->_domain = trim($domain);
        return $this;
    }
    public function setPath($path)
    {
        $path = trim($path);
        if (substr($path, -1) == "/") {
            $path = substr($path, 0, -1);
        }
        if (!is_dir($path)) {
            exit(sprintf("write directory does not exist: %s\n", $path));
        }
        if (!is_writable($path)) {
            exit(sprintf("write directory not writable: %s\n", $path));
        }
        $this->_path = $path;
        return $this;
    }
    public function setFilename($filename)
    {
        $filename = trim($filename);
        if (strtolower(substr($filename, -3)) != "xml") {
            exit(sprintf("filename must end with: xml: %s\n", $filename));
        }
        if (substr($filename, 0, 1) == "/") {
            $filename = substr($filename, 1, 0);
        }
        $this->_filename = $filename;
        return $this;
    }
    public function setEntries($entries)
    {
        if (!is_array($entries)) {
            throw new exception("setEntries() method expecs an array of objects");
        }
        foreach ($entries as $entry) {
            if (!is_object($entry) || !get_class($entry) == "xml_sitemap_entry") {
                throw new exception("setEntries() method expects an aray of xml_sitemap_entry objects");
            }
        }
        $this->_entries = $entries;
        return $this;
    }
    public function sanityCheck()
    {
        if (0 < !strlen($this->_filename)) {
            exit("Error: sitemap filename not set in configuration object");
        }
        if (0 < !strlen($this->_domain)) {
        }
    }
    private function _getFilepath()
    {
        return sprintf("%s/%s", $this->_path, $this->_filename);
    }
}
class xml_sitemap_entry
{
    private $_loc = NULL;
    private $_priority = NULL;
    private $_changefreq = NULL;
    private $_lastmod = NULL;
    private $_frequencies = ["always", "hourly", "daily", "weekly", "monthly", "yearly", "never"];
    private $_priorities = ["0.0", "0.1", "0.2", "0.3", "0.4", "0.5", "0.6", "0.7", "0.8", "0.9", "1.0"];
    public function __construct($loc, $priority, $changefreq = "", $lastmod = "")
    {
        $this->_setLoc($loc);
        $this->_setPriority($priority);
        if (0 < strlen($changefreq)) {
            $this->_setChangefreq($changefreq);
        }
        if (0 < strlen($lastmod)) {
            $this->_setLastmod($lastmod);
        }
    }
    public function get($arg)
    {
        switch ($arg) {
            case "loc":
                return $this->_getLoc();
                break;
            case "priority":
                return $this->_getPriority();
                break;
            case "changefreq":
                return $this->_getChangefreq();
                break;
            case "lastmod":
                return $this->_getLastmod();
                break;
            case "frequencies":
                return $this->_frequencies;
                break;
            case "priorities":
                return $this->_priorities;
                break;
            default:
                throw new Exception("get() method in class: xml_sitemap_entry did not recognize the argument");
        }
    }
    private function _setLoc($loc)
    {
        $this->_loc = $loc;
        return $this;
    }
    private function _setPriority($priority)
    {
        $priority = trim($priority);
        if (!in_array($priority, $this->_priorities)) {
            throw new Exception("setPriority() method is expecting a value between 0.0 and 1.0");
        }
        $this->_priority = trim($priority);
        return $this;
    }
    private function _setChangefreq($changefreq)
    {
        $changefreq = strtolower(trim($changefreq));
        if (!in_array($changefreq, $this->_frequencies)) {
            throw new Exception("setChangefreq() method is expecting a value such as hourly daily, weekly etc");
        }
        $this->_changefreq = $changefreq;
        return $this;
    }
    private function _setLastmod($lastmod)
    {
        $arr = date_parse($lastmod);
        if (!checkdate($arr["month"], $arr["day"], $arr["year"])) {
            throw new Exception("setLastmod() method expects a valid date");
        }
        $this->_lastmod = sprintf("%s-%s-%s", $arr["year"], $arr["month"], $arr["day"]);
        return $this;
    }
    private function _getLoc()
    {
        return $this->_loc;
    }
    private function _getPriority()
    {
        if (0 < !strlen($this->_priority)) {
            return "0.5";
        }
        return $this->_priority;
    }
    private function _getLastmod()
    {
        if (0 < !strlen($this->_lastmod)) {
            return date("Y-m-d");
        }
        return $this->_lastmod;
    }
    private function _getChangefreq()
    {
        if (0 < !strlen($this->_changefreq)) {
            return "monthly";
        }
        return $this->_changefreq;
    }
}
class xml_sitemap_generator
{
    private $_conf = NULL;
    private $_blocks = NULL;
    private $_xml = NULL;
    public function __construct(xml_sitemap_generator_config $conf)
    {
        $this->_conf = $conf;
    }
    public function build()
    {
        $this->_build();
    }
    public function getXml()
    {
        $this->_build();
        return $this->_xml;
    }
    public function toString()
    {
        $this->_build();
        return $this->_xml;
    }
    public function write()
    {
        $this->_build();
        if (!file_put_contents($this->_conf->get("filepath"), $this->_xml)) {
            throw new Exception("cound not write file: " . $this->_conf->get("filepath") . "\n");
        }
    }
    private function _append($xml)
    {
        $this->_xml .= $xml;
    }
    private function _build()
    {
        $this->_conf->sanityCheck();
        $this->_append($this->_buildHeader());
        $this->_append($this->_buildBlocks());
        $this->_append($this->_buildFooter());
    }
    private function _buildHeader()
    {
        $header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $header .= "\t<urlset ";
        $header .= "xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        return $header;
    }
    private function _buildFooter()
    {
        return "</urlset>\n";
    }
    private function _buildBlocks()
    {
        foreach ($this->_conf->get("entries") as $entry) {
            $this->_blocks .= $this->_buildEntry($entry);
        }
        return $this->_blocks;
    }
    private function _buildEntry(xml_sitemap_entry $entry)
    {
        $loc = sprintf("%s%s", $this->_conf->get("domain"), $entry->get("loc"));
        return sprintf("<url>\n%s%s%s%s</url>\n", $this->_buildLine("loc", $loc), $this->_buildLine("priority", $entry->get("priority")), $this->_buildLine("changefreq", $entry->get("changefreq")), $this->_buildLine("lastmod", $entry->get("lastmod")));
    }
    private function _buildLine($tagname, $content)
    {
        if (!$this->_is_utf8($content)) {
            $content = trim(utf8_encode($content));
        }
        return sprintf("\t<%s>%s</%s>\n", $tagname, $content, $tagname);
    }
    private function _is_utf8($str)
    {
        return preg_match("%^(?:\n              [\\x09\\x0A\\x0D\\x20-\\x7E]            # ASCII\n            | [\\xC2-\\xDF][\\x80-\\xBF]             # non-overlong 2-byte\n            |  \\xE0[\\xA0-\\xBF][\\x80-\\xBF]        # excluding overlongs\n            | [\\xE1-\\xEC\\xEE\\xEF][\\x80-\\xBF]{2}  # straight 3-byte\n            |  \\xED[\\x80-\\x9F][\\x80-\\xBF]        # excluding surrogates\n            |  \\xF0[\\x90-\\xBF][\\x80-\\xBF]{2}     # planes 1-3\n            | [\\xF1-\\xF3][\\x80-\\xBF]{3}          # planes 4-15\n            |  \\xF4[\\x80-\\x8F][\\x80-\\xBF]{2}     # plane 16\n        )*\$%xs", $str);
    }
}

?>