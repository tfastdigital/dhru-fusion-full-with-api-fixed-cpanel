<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Api;

/**
 * CheckoutApi Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://squareup.com/developers
 */
class CheckoutApi
{
    /**
     * API Client
     * @var \SquareConnect\ApiClient instance of the ApiClient
     */
    protected $apiClient = NULL;
    public function __construct($apiClient = NULL)
    {
        if ($apiClient == NULL) {
            $apiClient = new \SquareConnect\ApiClient();
            $apiClient->getConfig()->setHost("https://connect.squareup.com");
        }
        $this->apiClient = $apiClient;
    }
    public function getApiClient()
    {
        return $this->apiClient;
    }
    public function setApiClient(\SquareConnect\ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        return $this;
    }
    public function createCheckout($location_id, $body)
    {
        list($response, $statusCode, $httpHeader) = $this->createCheckoutWithHttpInfo($location_id, $body);
        return $response;
    }
    public function createCheckoutWithHttpInfo($location_id, $body)
    {
        while ($location_id === NULL) {
            if ($body === NULL) {
                throw new \InvalidArgumentException("Missing the required parameter \$body when calling createCheckout");
            }
            $resourcePath = "/v2/locations/{location_id}/checkouts";
            $httpBody = "";
            $queryParams = [];
            $headerParams = [];
            $formParams = [];
            $_header_accept = \SquareConnect\ApiClient::selectHeaderAccept(["application/json"]);
            if (!is_null($_header_accept)) {
                $headerParams["Accept"] = $_header_accept;
            }
            $headerParams["Content-Type"] = \SquareConnect\ApiClient::selectHeaderContentType(["application/json"]);
            $headerParams["Square-Version"] = "2019-06-12";
            if ($location_id !== NULL) {
                $resourcePath = str_replace("{location_id}", $this->apiClient->getSerializer()->toPathValue($location_id), $resourcePath);
            }
            $resourcePath = str_replace("{format}", "json", $resourcePath);
            $_tempBody = NULL;
            if (isset($body)) {
                $_tempBody = $body;
            }
            if (isset($_tempBody)) {
                $httpBody = $_tempBody;
            } else {
                if (0 < count($formParams)) {
                    $httpBody = $formParams;
                }
            }
            if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
                $headerParams["Authorization"] = "Bearer " . $this->apiClient->getConfig()->getAccessToken();
            }
            try {
                list($response, $statusCode, $httpHeader) = $this->apiClient->callApi($resourcePath, "POST", $queryParams, $httpBody, $headerParams, "\\SquareConnect\\Model\\CreateCheckoutResponse");
                if (!$response) {
                    return [NULL, $statusCode, $httpHeader];
                }
                return [\SquareConnect\ObjectSerializer::deserialize($response, "\\SquareConnect\\Model\\CreateCheckoutResponse", $httpHeader), $statusCode, $httpHeader];
            } catch (\SquareConnect\ApiException $e) {
                $e->getCode();
                switch ($e->getCode()) {
                    case 200:
                        $data = \SquareConnect\ObjectSerializer::deserialize($e->getResponseBody(), "\\SquareConnect\\Model\\CreateCheckoutResponse", $e->getResponseHeaders());
                        $e->setResponseObject($data);
                        break;
                    default:
                        throw $e;
                }
            }
        }
        throw new \InvalidArgumentException("Missing the required parameter \$location_id when calling createCheckout");
    }
}

?>