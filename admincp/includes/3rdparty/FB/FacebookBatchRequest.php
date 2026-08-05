<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook;

/**
 * Class BatchRequest
 *
 * @package Facebook
 */
class FacebookBatchRequest extends FacebookRequest implements \IteratorAggregate, \ArrayAccess
{
    /**
     * @var array An array of FacebookRequest entities to send.
     */
    protected $requests = NULL;
    /**
     * @var array An array of files to upload.
     */
    protected $attachedFiles = NULL;
    public function __construct(FacebookApp $app = NULL, $requests = [], $accessToken = NULL, $graphVersion = NULL)
    {
        parent::__construct($app, $accessToken, "POST", "", [], NULL, $graphVersion);
        $this->add($requests);
    }
    public function add($request, $name = NULL)
    {
        if (is_array($request)) {
            foreach ($request as $key => $req) {
                $this->add($req, $key);
            }
            return $this;
        } else {
            if (!$request instanceof FacebookRequest) {
                throw new \InvalidArgumentException("Argument for add() must be of type array or FacebookRequest.");
            }
            $this->addFallbackDefaults($request);
            $requestToAdd = ["name" => $name, "request" => $request];
            $attachedFiles = $this->extractFileAttachments($request);
            if ($attachedFiles) {
                $requestToAdd["attached_files"] = $attachedFiles;
            }
            $this->requests[] = $requestToAdd;
            return $this;
        }
    }
    public function addFallbackDefaults(FacebookRequest $request)
    {
        if (!$request->getApp()) {
            $app = $this->getApp();
            if (!$app) {
                throw new Exceptions\FacebookSDKException("Missing FacebookApp on FacebookRequest and no fallback detected on FacebookBatchRequest.");
            }
            $request->setApp($app);
        }
        if (!$request->getAccessToken()) {
            $accessToken = $this->getAccessToken();
            if (!$accessToken) {
                throw new Exceptions\FacebookSDKException("Missing access token on FacebookRequest and no fallback detected on FacebookBatchRequest.");
            }
            $request->setAccessToken($accessToken);
        }
    }
    public function extractFileAttachments(FacebookRequest $request)
    {
        if (!$request->containsFileUploads()) {
            return NULL;
        }
        $files = $request->getFiles();
        $fileNames = [];
        foreach ($files as $file) {
            $fileName = uniqid();
            $this->addFile($fileName, $file);
            $fileNames[] = $fileName;
        }
        $request->resetFiles();
        return implode(",", $fileNames);
    }
    public function getRequests()
    {
        return $this->requests;
    }
    public function prepareRequestsForBatch()
    {
        $this->validateBatchRequestCount();
        $params = ["batch" => $this->convertRequestsToJson(), "include_headers" => true];
        $this->setParams($params);
    }
    public function convertRequestsToJson()
    {
        $requests = [];
        foreach ($this->requests as $request) {
            $attachedFiles = isset($request["attached_files"]) ? $request["attached_files"] : NULL;
            $requests[] = $this->requestEntityToBatchArray($request["request"], $request["name"], $attachedFiles);
        }
        return json_encode($requests);
    }
    public function validateBatchRequestCount()
    {
        $batchCount = count($this->requests);
        if ($batchCount === 0) {
            throw new Exceptions\FacebookSDKException("There are no batch requests to send.");
        }
        if (50 < $batchCount) {
            throw new Exceptions\FacebookSDKException("You cannot send more than 50 batch requests at a time.");
        }
    }
    public function requestEntityToBatchArray(FacebookRequest $request, $requestName = NULL, $attachedFiles = NULL)
    {
        $compiledHeaders = [];
        $headers = $request->getHeaders();
        foreach ($headers as $name => $value) {
            $compiledHeaders[] = $name . ": " . $value;
        }
        $batch = ["headers" => $compiledHeaders, "method" => $request->getMethod(), "relative_url" => $request->getUrl()];
        $body = $request->getUrlEncodedBody()->getBody();
        if ($body) {
            $batch["body"] = $body;
        }
        if (isset($requestName)) {
            $batch["name"] = $requestName;
        }
        if (isset($attachedFiles)) {
            $batch["attached_files"] = $attachedFiles;
        }
        return $batch;
    }
    public function getIterator()
    {
        return new \ArrayIterator($this->requests);
    }
    public function offsetSet($offset, $value)
    {
        $this->add($value, $offset);
    }
    public function offsetExists($offset)
    {
        return isset($this->requests[$offset]);
    }
    public function offsetUnset($offset)
    {
        unset($this->requests[$offset]);
    }
    public function offsetGet($offset)
    {
        return isset($this->requests[$offset]) ? $this->requests[$offset] : NULL;
    }
}

?>