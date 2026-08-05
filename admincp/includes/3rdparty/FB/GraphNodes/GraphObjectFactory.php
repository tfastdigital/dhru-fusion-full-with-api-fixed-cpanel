<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\GraphNodes;

/**
 * Class GraphObjectFactory
 *
 * @package Facebook
 *
 * @deprecated 5.0.0 GraphObjectFactory has been renamed to GraphNodeFactory
 * @todo v6: Remove this class
 */
class GraphObjectFactory extends GraphNodeFactory
{
    const BASE_GRAPH_NODE_CLASS = "\\Facebook\\GraphNodes\\GraphObject";
    const BASE_GRAPH_EDGE_CLASS = "\\Facebook\\GraphNodes\\GraphList";
    public function makeGraphObject($subclassName = NULL)
    {
        return $this->makeGraphNode($subclassName);
    }
    public function makeGraphEvent()
    {
        return $this->makeGraphObject(static::BASE_GRAPH_OBJECT_PREFIX . "GraphEvent");
    }
    public function makeGraphList($subclassName = NULL, $auto_prefix = true)
    {
        return $this->makeGraphEdge($subclassName, $auto_prefix);
    }
}

?>