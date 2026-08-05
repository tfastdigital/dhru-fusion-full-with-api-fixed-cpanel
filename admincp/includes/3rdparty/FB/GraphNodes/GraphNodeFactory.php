<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\GraphNodes;

/**
 * Class GraphNodeFactory
 *
 * @package Facebook
 *
 * ## Assumptions ##
 * GraphEdge - is ALWAYS a numeric array
 * GraphEdge - is ALWAYS an array of GraphNode types
 * GraphNode - is ALWAYS an associative array
 * GraphNode - MAY contain GraphNode's "recurrable"
 * GraphNode - MAY contain GraphEdge's "recurrable"
 * GraphNode - MAY contain DateTime's "primitives"
 * GraphNode - MAY contain string's "primitives"
 */
class GraphNodeFactory
{
    /**
     * @var FacebookResponse The response entity from Graph.
     */
    protected $response = NULL;
    /**
     * @var array The decoded body of the FacebookResponse entity from Graph.
     */
    protected $decodedBody = NULL;
    const BASE_GRAPH_NODE_CLASS = "\\Facebook\\GraphNodes\\GraphNode";
    const BASE_GRAPH_EDGE_CLASS = "\\Facebook\\GraphNodes\\GraphEdge";
    const BASE_GRAPH_OBJECT_PREFIX = "\\Facebook\\GraphNodes\\";
    public function __construct(\Facebook\FacebookResponse $response)
    {
        $this->response = $response;
        $this->decodedBody = $response->getDecodedBody();
    }
    public function makeGraphNode($subclassName = NULL)
    {
        $this->validateResponseAsArray();
        $this->validateResponseCastableAsGraphNode();
        return $this->castAsGraphNodeOrGraphEdge($this->decodedBody, $subclassName);
    }
    public function makeGraphAchievement()
    {
        return $this->makeGraphNode(static::BASE_GRAPH_OBJECT_PREFIX . "GraphAchievement");
    }
    public function makeGraphAlbum()
    {
        return $this->makeGraphNode(static::BASE_GRAPH_OBJECT_PREFIX . "GraphAlbum");
    }
    public function makeGraphPage()
    {
        return $this->makeGraphNode(static::BASE_GRAPH_OBJECT_PREFIX . "GraphPage");
    }
    public function makeGraphSessionInfo()
    {
        return $this->makeGraphNode(static::BASE_GRAPH_OBJECT_PREFIX . "GraphSessionInfo");
    }
    public function makeGraphUser()
    {
        return $this->makeGraphNode(static::BASE_GRAPH_OBJECT_PREFIX . "GraphUser");
    }
    public function makeGraphEvent()
    {
        return $this->makeGraphNode(static::BASE_GRAPH_OBJECT_PREFIX . "GraphEvent");
    }
    public function makeGraphGroup()
    {
        return $this->makeGraphNode(static::BASE_GRAPH_OBJECT_PREFIX . "GraphGroup");
    }
    public function makeGraphEdge($subclassName = NULL, $auto_prefix = true)
    {
        $this->validateResponseAsArray();
        $this->validateResponseCastableAsGraphEdge();
        if ($subclassName && $auto_prefix) {
            $subclassName = static::BASE_GRAPH_OBJECT_PREFIX . $subclassName;
        }
        return $this->castAsGraphNodeOrGraphEdge($this->decodedBody, $subclassName);
    }
    public function validateResponseAsArray()
    {
        if (!is_array($this->decodedBody)) {
            throw new \Facebook\Exceptions\FacebookSDKException("Unable to get response from Graph as array.", 620);
        }
    }
    public function validateResponseCastableAsGraphNode()
    {
        if (isset($this->decodedBody["data"]) && static::isCastableAsGraphEdge($this->decodedBody["data"])) {
            throw new \Facebook\Exceptions\FacebookSDKException("Unable to convert response from Graph to a GraphNode because the response looks like a GraphEdge. Try using GraphNodeFactory::makeGraphEdge() instead.", 620);
        }
    }
    public function validateResponseCastableAsGraphEdge()
    {
        if (!(isset($this->decodedBody["data"]) && static::isCastableAsGraphEdge($this->decodedBody["data"]))) {
            throw new \Facebook\Exceptions\FacebookSDKException("Unable to convert response from Graph to a GraphEdge because the response does not look like a GraphEdge. Try using GraphNodeFactory::makeGraphNode() instead.", 620);
        }
    }
    public function safelyMakeGraphNode($data, $subclassName = NULL)
    {
        $subclassName = $subclassName ?: static::BASE_GRAPH_NODE_CLASS;
        static::validateSubclass($subclassName);
        $parentNodeId = isset($data["id"]) ? $data["id"] : NULL;
        $items = [];
        foreach ($data as $k => $v) {
            if (is_array($v)) {
                $graphObjectMap = $subclassName::getObjectMap();
                $objectSubClass = isset($graphObjectMap[$k]) ? $graphObjectMap[$k] : NULL;
                $items[$k] = $this->castAsGraphNodeOrGraphEdge($v, $objectSubClass, $k, $parentNodeId);
            } else {
                $items[$k] = $v;
            }
        }
        return new $subclassName($items);
    }
    public function castAsGraphNodeOrGraphEdge($data, $subclassName = NULL, $parentKey = NULL, $parentNodeId = NULL)
    {
        if (isset($data["data"])) {
            if (static::isCastableAsGraphEdge($data["data"])) {
                return $this->safelyMakeGraphEdge($data, $subclassName, $parentKey, $parentNodeId);
            }
            $data = $data["data"];
        }
        return $this->safelyMakeGraphNode($data, $subclassName);
    }
    public function safelyMakeGraphEdge($data, $subclassName = NULL, $parentKey = NULL, $parentNodeId = NULL)
    {
        if (!isset($data["data"])) {
            throw new \Facebook\Exceptions\FacebookSDKException("Cannot cast data to GraphEdge. Expected a \"data\" key.", 620);
        }
        $dataList = [];
        foreach ($data["data"] as $graphNode) {
            $dataList[] = $this->safelyMakeGraphNode($graphNode, $subclassName);
        }
        $metaData = $this->getMetaData($data);
        $parentGraphEdgeEndpoint = $parentNodeId && $parentKey ? "/" . $parentNodeId . "/" . $parentKey : NULL;
        $className = static::BASE_GRAPH_EDGE_CLASS;
        return new $className($this->response->getRequest(), $dataList, $metaData, $parentGraphEdgeEndpoint, $subclassName);
    }
    public function getMetaData($data)
    {
        unset($data["data"]);
        return $data;
    }
    public static function isCastableAsGraphEdge($data)
    {
        if ($data === []) {
            return true;
        }
        return array_keys($data) === range(0, count($data) - 1);
    }
    public static function validateSubclass($subclassName)
    {
        if ($subclassName == static::BASE_GRAPH_NODE_CLASS || is_subclass_of($subclassName, static::BASE_GRAPH_NODE_CLASS)) {
            return NULL;
        }
        throw new \Facebook\Exceptions\FacebookSDKException("The given subclass \"" . $subclassName . "\" is not valid. Cannot cast to an object that is not a GraphNode subclass.", 620);
    }
}

?>