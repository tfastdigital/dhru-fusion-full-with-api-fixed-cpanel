<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\GraphNodes;

/**
 * Class GraphEdge
 *
 * @package Facebook
 */
class GraphEdge extends Collection
{
    /**
     * @var FacebookRequest The original request that generated this data.
     */
    protected $request = NULL;
    /**
     * @var array An array of Graph meta data like pagination, etc.
     */
    protected $metaData = [];
    /**
     * @var string|null The parent Graph edge endpoint that generated the list.
     */
    protected $parentEdgeEndpoint = NULL;
    /**
     * @var string|null The subclass of the child GraphNode's.
     */
    protected $subclassName = NULL;
    public function __construct(\Facebook\FacebookRequest $request, $data = [], $metaData = [], $parentEdgeEndpoint = NULL, $subclassName = NULL)
    {
        $this->request = $request;
        $this->metaData = $metaData;
        $this->parentEdgeEndpoint = $parentEdgeEndpoint;
        $this->subclassName = $subclassName;
        parent::__construct($data);
    }
    public function getParentGraphEdge()
    {
        return $this->parentEdgeEndpoint;
    }
    public function getSubClassName()
    {
        return $this->subclassName;
    }
    public function getMetaData()
    {
        return $this->metaData;
    }
    public function getNextCursor()
    {
        return $this->getCursor("after");
    }
    public function getPreviousCursor()
    {
        return $this->getCursor("before");
    }
    public function getCursor($direction)
    {
        if (isset($this->metaData["paging"]["cursors"][$direction])) {
            return $this->metaData["paging"]["cursors"][$direction];
        }
        return NULL;
    }
    public function getPaginationUrl($direction)
    {
        $this->validateForPagination();
        if (isset($this->metaData["paging"][$direction])) {
            $pageUrl = $this->metaData["paging"][$direction];
            return \Facebook\Url\FacebookUrlManipulator::baseGraphUrlEndpoint($pageUrl);
        }
        $cursorDirection = $direction === "next" ? "after" : "before";
        $cursor = $this->getCursor($cursorDirection);
        if (!$cursor) {
            return NULL;
        }
        if (!$this->parentEdgeEndpoint) {
            return NULL;
        }
        $pageUrl = $this->parentEdgeEndpoint . "?" . $cursorDirection . "=" . urlencode($cursor);
        $originalUrl = $this->request->getUrl();
        $pageUrl = \Facebook\Url\FacebookUrlManipulator::mergeUrlParams($originalUrl, $pageUrl);
        return \Facebook\Url\FacebookUrlManipulator::forceSlashPrefix($pageUrl);
    }
    public function validateForPagination()
    {
        if ($this->request->getMethod() !== "GET") {
            throw new \Facebook\Exceptions\FacebookSDKException("You can only paginate on a GET request.", 720);
        }
    }
    public function getPaginationRequest($direction)
    {
        $pageUrl = $this->getPaginationUrl($direction);
        if (!$pageUrl) {
            return NULL;
        }
        $newRequest = clone $this->request;
        $newRequest->setEndpoint($pageUrl);
        return $newRequest;
    }
    public function getNextPageRequest()
    {
        return $this->getPaginationRequest("next");
    }
    public function getPreviousPageRequest()
    {
        return $this->getPaginationRequest("previous");
    }
    public function getTotalCount()
    {
        if (isset($this->metaData["summary"]["total_count"])) {
            return $this->metaData["summary"]["total_count"];
        }
        return NULL;
    }
}

?>