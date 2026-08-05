<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("RSS1", "RSS 1.0", true);
define("RSS2", "RSS 2.0", true);
define("ATOM", "ATOM", true);
class FeedWriter
{
    private $channels = [];
    private $items = [];
    private $data = [];
    private $CDATAEncoding = [];
    private $version = NULL;
    public function __construct($version = RSS2)
    {
        $this->version = $version;
        $this->channels["title"] = $version . " Feed";
        $this->channels["link"] = "http://www.ajaxray.com/blog";
        $this->CDATAEncoding = ["description", "content:encoded", "summary"];
    }
    public function setChannelElement($elementName, $content)
    {
        $this->channels[$elementName] = $content;
    }
    public function setChannelElementsFromArray($elementArray)
    {
        if (!is_array($elementArray)) {
            return NULL;
        }
        foreach ($elementArray as $elementName => $content) {
            $this->setChannelElement($elementName, $content);
        }
    }
    public function genarateFeed()
    {
        header("Content-type: text/xml");
        $this->printHead();
        $this->printChannels();
        $this->printItems();
        $this->printTale();
    }
    public function createNewItem()
    {
        $Item = new FeedItem($this->version);
        return $Item;
    }
    public function addItem($feedItem)
    {
        $this->items[] = $feedItem;
    }
    public function setTitle($title)
    {
        $this->setChannelElement("title", $title);
    }
    public function setDescription($desciption)
    {
        $this->setChannelElement("description", $desciption);
    }
    public function setLink($link)
    {
        $this->setChannelElement("link", $link);
    }
    public function setImage($title, $link, $url)
    {
        $this->setChannelElement("image", ["title" => $title, "link" => $link, "url" => $url]);
    }
    public function setChannelAbout($url)
    {
        $this->data["ChannelAbout"] = $url;
    }
    public function uuid($key = NULL, $prefix = "")
    {
        $key = $key == NULL ? uniqid(rand()) : $key;
        $chars = md5($key);
        $uuid = substr($chars, 0, 8) . "-";
        $uuid .= substr($chars, 8, 4) . "-";
        $uuid .= substr($chars, 12, 4) . "-";
        $uuid .= substr($chars, 16, 4) . "-";
        $uuid .= substr($chars, 20, 12);
        return $prefix . $uuid;
    }
    private function printHead()
    {
        $out = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        if ($this->version == RSS2) {
            $out .= "<rss version=\"2.0\"\n\t\t\t\t\txmlns:content=\"http://purl.org/rss/1.0/modules/content/\"\n\t\t\t\t\txmlns:wfw=\"http://wellformedweb.org/CommentAPI/\"\n\t\t\t\t  >" . PHP_EOL;
        } else {
            if ($this->version == RSS1) {
                $out .= "<rdf:RDF \n\t\t\t\t\t xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"\n\t\t\t\t\t xmlns=\"http://purl.org/rss/1.0/\"\n\t\t\t\t\t xmlns:dc=\"http://purl.org/dc/elements/1.1/\"\n\t\t\t\t\t>" . PHP_EOL;
            } else {
                if ($this->version == ATOM) {
                    $out .= "<feed xmlns=\"http://www.w3.org/2005/Atom\">" . PHP_EOL;
                }
            }
        }
        echo $out;
    }
    private function printTale()
    {
        if ($this->version == RSS2) {
            echo "</channel>" . PHP_EOL . "</rss>";
        } else {
            if ($this->version == RSS1) {
                echo "</rdf:RDF>";
            } else {
                if ($this->version == ATOM) {
                    echo "</feed>";
                }
            }
        }
    }
    private function makeNode($tagName, $tagContent, $attributes = NULL)
    {
        $nodeText = "";
        $attrText = "";
        if (is_array($attributes)) {
            foreach ($attributes as $key => $value) {
                $attrText .= " " . $key . "=\"" . $value . "\" ";
            }
        }
        if (is_array($tagContent) && $this->version == RSS1) {
            $attrText = " rdf:parseType=\"Resource\"";
        }
        $attrText .= in_array($tagName, $this->CDATAEncoding) && $this->version == ATOM ? " type=\"html\" " : "";
        $nodeText .= in_array($tagName, $this->CDATAEncoding) ? "<" . $tagName . $attrText . "><![CDATA[" : "<" . $tagName . $attrText . ">";
        if (is_array($tagContent)) {
            foreach ($tagContent as $key => $value) {
                $nodeText .= $this->makeNode($key, $value);
            }
        } else {
            $nodeText .= in_array($tagName, $this->CDATAEncoding) ? $tagContent : htmlentities($tagContent);
        }
        $nodeText .= in_array($tagName, $this->CDATAEncoding) ? "]]></" . $tagName . ">" : "</" . $tagName . ">";
        return $nodeText . PHP_EOL;
    }
    private function printChannels()
    {
        switch ($this->version) {
            case RSS2:
                echo "<channel>" . PHP_EOL;
                break;
            case RSS1:
                echo isset($this->data["ChannelAbout"]) ? "<channel rdf:about=\"" . $this->data["ChannelAbout"] . "\">" : "<channel rdf:about=\"" . $this->channels["link"] . "\">";
                break;
            default:
                foreach ($this->channels as $key => $value) {
                    if ($this->version == ATOM && $key == "link") {
                        echo $this->makeNode($key, "", ["href" => $value]);
                        echo $this->makeNode("id", $this->uuid($value, "urn:uuid:"));
                    } else {
                        echo $this->makeNode($key, $value);
                    }
                }
                if ($this->version == RSS1) {
                    echo "<items>" . PHP_EOL . "<rdf:Seq>" . PHP_EOL;
                    foreach ($this->items as $item) {
                        $thisItems = $item->getElements();
                        echo "<rdf:li resource=\"" . $thisItems["link"]["content"] . "\"/>" . PHP_EOL;
                    }
                    echo "</rdf:Seq>" . PHP_EOL . "</items>" . PHP_EOL . "</channel>" . PHP_EOL;
                }
        }
    }
    private function printItems()
    {
        foreach ($this->items as $item) {
            $thisItems = $item->getElements();
            echo $this->startItem($thisItems["link"]["content"]);
            foreach ($thisItems as $feedItem) {
                echo $this->makeNode($feedItem["name"], $feedItem["content"], $feedItem["attributes"]);
            }
            echo $this->endItem();
        }
    }
    private function startItem($about = false)
    {
        if ($this->version == RSS2) {
            echo "<item>" . PHP_EOL;
        } else {
            if ($this->version == RSS1) {
                if ($about) {
                    echo "<item rdf:about=\"" . $about . "\">" . PHP_EOL;
                } else {
                    exit("link element is not set .\\n It's required for RSS 1.0 to be used as about attribute of item");
                }
            } else {
                if ($this->version == ATOM) {
                    echo "<entry>" . PHP_EOL;
                }
            }
        }
    }
    private function endItem()
    {
        if ($this->version == RSS2 || $this->version == RSS1) {
            echo "</item>" . PHP_EOL;
        } else {
            if ($this->version == ATOM) {
                echo "</entry>" . PHP_EOL;
            }
        }
    }
}
class FeedItem
{
    private $elements = [];
    private $version = NULL;
    public function __construct($version = RSS2)
    {
        $this->version = $version;
    }
    public function addElement($elementName, $content, $attributes = NULL)
    {
        $this->elements[$elementName]["name"] = $elementName;
        $this->elements[$elementName]["content"] = $content;
        $this->elements[$elementName]["attributes"] = $attributes;
    }
    public function addElementArray($elementArray)
    {
        if (!is_array($elementArray)) {
            return NULL;
        }
        foreach ($elementArray as $elementName => $content) {
            $this->addElement($elementName, $content);
        }
    }
    public function getElements()
    {
        return $this->elements;
    }
    public function setDescription($description)
    {
        $tag = $this->version == ATOM ? "summary" : "description";
        $this->addElement($tag, $description);
    }
    public function setTitle($title)
    {
        $this->addElement("title", $title);
    }
    public function setDate($date)
    {
        if (!is_numeric($date)) {
            $date = strtotime($date);
        }
        if ($this->version == ATOM) {
            $tag = "updated";
            $value = date(DATE_ATOM, $date);
        } else {
            if ($this->version == RSS2) {
                $tag = "pubDate";
                $value = date(DATE_RSS, $date);
            } else {
                $tag = "dc:date";
                $value = date("Y-m-d", $date);
            }
        }
        $this->addElement($tag, $value);
    }
    public function setLink($link)
    {
        if ($this->version == RSS2 || $this->version == RSS1) {
            $this->addElement("link", $link);
        } else {
            $this->addElement("link", "", ["href" => $link]);
            $this->addElement("id", FeedWriter::uuid($link, "urn:uuid:"));
        }
    }
    public function setEncloser($url, $length, $type)
    {
        $attributes = ["url" => $url, "length" => $length, "type" => $type];
        $this->addElement("enclosure", "", $attributes);
    }
}

?>