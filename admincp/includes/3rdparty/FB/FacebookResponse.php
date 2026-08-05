<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook;

/**
 * Class FacebookResponse
 *
 * @package Facebook
 */
class FacebookResponse
{
    /**
     * @var int The HTTP status code response from Graph.
     */
    protected $httpStatusCode = NULL;
    /**
     * @var array The headers returned from Graph.
     */
    protected $headers = NULL;
    /**
     * @var string The raw body of the response from Graph.
     */
    protected $body = NULL;
    /**
     * @var array The decoded body of the Graph response.
     */
    protected $decodedBody = [];
    /**
     * @var FacebookRequest The original request that returned this response.
     */
    protected $request = NULL;
    /**
     * @var FacebookSDKException The exception thrown by this request.
     */
    protected $thrownException = NULL;
    public function __construct(FacebookRequest $request, $body = NULL, $httpStatusCode = NULL, $headers = [])
    {
        $this->request = $request;
        $this->body = $body;
        $this->httpStatusCode = $httpStatusCode;
        $this->headers = $headers;
        $this->decodeBody();
    }
    public function getRequest()
    {
        return $this->request;
    }
    public function getApp()
    {
        return $this->request->getApp();
    }
    public function getAccessToken()
    {
        return $this->request->getAccessToken();
    }
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }
    public function getHeaders()
    {
        return $this->headers;
    }
    public function getBody()
    {
        return $this->body;
    }
    public function getDecodedBody()
    {
        return $this->decodedBody;
    }
    public function getAppSecretProof()
    {
        return $this->request->getAppSecretProof();
    }
    public function getETag()
    {
        return isset($this->headers["ETag"]) ? $this->headers["ETag"] : NULL;
    }
    public function getGraphVersion()
    {
        return isset($this->headers["Facebook-API-Version"]) ? $this->headers["Facebook-API-Version"] : NULL;
    }
    public function isError()
    {
        return isset($this->decodedBody["error"]);
    }
    public function throwException()
    {
        throw $this->thrownException;
    }
    public function makeException()
    {
        $this->thrownException = Exceptions\FacebookResponseException::create($this);
    }
    public function getThrownException()
    {
        return $this->thrownException;
    }
    public function decodeBody()
    {
        $this->decodedBody = json_decode($this->body, true);
        if ($this->decodedBody === NULL) {
            $this->decodedBody = [];
            parse_str($this->body, $this->decodedBody);
        } else {
            if (is_bool($this->decodedBody)) {
                $this->decodedBody = ["success" => $this->decodedBody];
            } else {
                if (is_numeric($this->decodedBody)) {
                    $this->decodedBody = ["id" => $this->decodedBody];
                }
            }
        }
        if (!is_array($this->decodedBody)) {
            $this->decodedBody = [];
        }
        if ($this->isError()) {
            $this->makeException();
        }
    }
    public function getGraphObject($subclassName = NULL)
    {
        return $this->getGraphNode($subclassName);
    }
    public function getGraphNode($subclassName = NULL)
    {
        $factory = new GraphNodes\GraphNodeFactory($this);
        return $factory->makeGraphNode($subclassName);
    }
    public function getGraphAlbum()
    {
        $factory = new GraphNodes\GraphNodeFactory($this);
        return $factory->makeGraphAlbum();
    }
    public function getGraphPage()
    {
        $factory = new GraphNodes\GraphNodeFactory($this);
        return $factory->makeGraphPage();
    }
    public function getGraphSessionInfo()
    {
        $factory = new GraphNodes\GraphNodeFactory($this);
        return $factory->makeGraphSessionInfo();
    }
    public function getGraphUser()
    {
        $factory = new GraphNodes\GraphNodeFactory($this);
        return $factory->makeGraphUser();
    }
    public function getGraphEvent()
    {
        $factory = new GraphNodes\GraphNodeFactory($this);
        return $factory->makeGraphEvent();
    }
    public function getGraphGroup()
    {
        $factory = new GraphNodes\GraphNodeFactory($this);
        return $factory->makeGraphGroup();
    }
    public function getGraphList($subclassName = NULL, $auto_prefix = true)
    {
        return $this->getGraphEdge($subclassName, $auto_prefix);
    }
    public function getGraphEdge($subclassName = NULL, $auto_prefix = true)
    {
        $factory = new GraphNodes\GraphNodeFactory($this);
        return $factory->makeGraphEdge($subclassName, $auto_prefix);
    }
}

?>