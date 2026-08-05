<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Api;

/**
 * TransactionsApi Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://squareup.com/developers
 */
class TransactionsApi
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
    public function captureTransaction($location_id, $transaction_id)
    {
        list($response, $statusCode, $httpHeader) = $this->captureTransactionWithHttpInfo($location_id, $transaction_id);
        return $response;
    }
    public function captureTransactionWithHttpInfo($location_id, $transaction_id)
    {
        while ($location_id === NULL) {
            if ($transaction_id === NULL) {
                throw new \InvalidArgumentException("Missing the required parameter \$transaction_id when calling captureTransaction");
            }
            $resourcePath = "/v2/locations/{location_id}/transactions/{transaction_id}/capture";
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
            if ($transaction_id !== NULL) {
                $resourcePath = str_replace("{transaction_id}", $this->apiClient->getSerializer()->toPathValue($transaction_id), $resourcePath);
            }
            $resourcePath = str_replace("{format}", "json", $resourcePath);
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
                list($response, $statusCode, $httpHeader) = $this->apiClient->callApi($resourcePath, "POST", $queryParams, $httpBody, $headerParams, "\\SquareConnect\\Model\\CaptureTransactionResponse");
                if (!$response) {
                    return [NULL, $statusCode, $httpHeader];
                }
                return [\SquareConnect\ObjectSerializer::deserialize($response, "\\SquareConnect\\Model\\CaptureTransactionResponse", $httpHeader), $statusCode, $httpHeader];
            } catch (\SquareConnect\ApiException $e) {
                $e->getCode();
                switch ($e->getCode()) {
                    case 200:
                        $data = \SquareConnect\ObjectSerializer::deserialize($e->getResponseBody(), "\\SquareConnect\\Model\\CaptureTransactionResponse", $e->getResponseHeaders());
                        $e->setResponseObject($data);
                        break;
                    default:
                        throw $e;
                }
            }
        }
        throw new \InvalidArgumentException("Missing the required parameter \$location_id when calling captureTransaction");
    }
    public function charge($location_id, $body)
    {
        list($response, $statusCode, $httpHeader) = $this->chargeWithHttpInfo($location_id, $body);
        return $response;
    }
    public function chargeWithHttpInfo($location_id, $body)
    {
        while ($location_id === NULL) {
            if ($body === NULL) {
                throw new \InvalidArgumentException("Missing the required parameter \$body when calling charge");
            }
            $resourcePath = "/v2/locations/{location_id}/transactions";
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
                list($response, $statusCode, $httpHeader) = $this->apiClient->callApi($resourcePath, "POST", $queryParams, $httpBody, $headerParams, "\\SquareConnect\\Model\\ChargeResponse");
                if (!$response) {
                    return [NULL, $statusCode, $httpHeader];
                }
                return [\SquareConnect\ObjectSerializer::deserialize($response, "\\SquareConnect\\Model\\ChargeResponse", $httpHeader), $statusCode, $httpHeader];
            } catch (\SquareConnect\ApiException $e) {
                $e->getCode();
                switch ($e->getCode()) {
                    case 200:
                        $data = \SquareConnect\ObjectSerializer::deserialize($e->getResponseBody(), "\\SquareConnect\\Model\\ChargeResponse", $e->getResponseHeaders());
                        $e->setResponseObject($data);
                        break;
                    default:
                        throw $e;
                }
            }
        }
        throw new \InvalidArgumentException("Missing the required parameter \$location_id when calling charge");
    }
    public function createRefund($location_id, $transaction_id, $body)
    {
        list($response, $statusCode, $httpHeader) = $this->createRefundWithHttpInfo($location_id, $transaction_id, $body);
        return $response;
    }
    public function createRefundWithHttpInfo($location_id, $transaction_id, $body)
    {
        while ($location_id === NULL) {
            if ($transaction_id === NULL) {
                throw new \InvalidArgumentException("Missing the required parameter \$transaction_id when calling createRefund");
            }
            if ($body === NULL) {
                throw new \InvalidArgumentException("Missing the required parameter \$body when calling createRefund");
            }
            $resourcePath = "/v2/locations/{location_id}/transactions/{transaction_id}/refund";
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
            if ($transaction_id !== NULL) {
                $resourcePath = str_replace("{transaction_id}", $this->apiClient->getSerializer()->toPathValue($transaction_id), $resourcePath);
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
                list($response, $statusCode, $httpHeader) = $this->apiClient->callApi($resourcePath, "POST", $queryParams, $httpBody, $headerParams, "\\SquareConnect\\Model\\CreateRefundResponse");
                if (!$response) {
                    return [NULL, $statusCode, $httpHeader];
                }
                return [\SquareConnect\ObjectSerializer::deserialize($response, "\\SquareConnect\\Model\\CreateRefundResponse", $httpHeader), $statusCode, $httpHeader];
            } catch (\SquareConnect\ApiException $e) {
                $e->getCode();
                switch ($e->getCode()) {
                    case 200:
                        $data = \SquareConnect\ObjectSerializer::deserialize($e->getResponseBody(), "\\SquareConnect\\Model\\CreateRefundResponse", $e->getResponseHeaders());
                        $e->setResponseObject($data);
                        break;
                    default:
                        throw $e;
                }
            }
        }
        throw new \InvalidArgumentException("Missing the required parameter \$location_id when calling createRefund");
    }
    public function listRefunds($location_id, $begin_time = NULL, $end_time = NULL, $sort_order = NULL, $cursor = NULL)
    {
        list($response, $statusCode, $httpHeader) = $this->listRefundsWithHttpInfo($location_id, $begin_time, $end_time, $sort_order, $cursor);
        return $response;
    }
    public function listRefundsWithHttpInfo($location_id, $begin_time = NULL, $end_time = NULL, $sort_order = NULL, $cursor = NULL)
    {
        while ($location_id === NULL) {
            $resourcePath = "/v2/locations/{location_id}/refunds";
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
            if ($begin_time !== NULL) {
                $queryParams["begin_time"] = $this->apiClient->getSerializer()->toQueryValue($begin_time);
            }
            if ($end_time !== NULL) {
                $queryParams["end_time"] = $this->apiClient->getSerializer()->toQueryValue($end_time);
            }
            if ($sort_order !== NULL) {
                $queryParams["sort_order"] = $this->apiClient->getSerializer()->toQueryValue($sort_order);
            }
            if ($cursor !== NULL) {
                $queryParams["cursor"] = $this->apiClient->getSerializer()->toQueryValue($cursor);
            }
            if ($location_id !== NULL) {
                $resourcePath = str_replace("{location_id}", $this->apiClient->getSerializer()->toPathValue($location_id), $resourcePath);
            }
            $resourcePath = str_replace("{format}", "json", $resourcePath);
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
                list($response, $statusCode, $httpHeader) = $this->apiClient->callApi($resourcePath, "GET", $queryParams, $httpBody, $headerParams, "\\SquareConnect\\Model\\ListRefundsResponse");
                if (!$response) {
                    return [NULL, $statusCode, $httpHeader];
                }
                return [\SquareConnect\ObjectSerializer::deserialize($response, "\\SquareConnect\\Model\\ListRefundsResponse", $httpHeader), $statusCode, $httpHeader];
            } catch (\SquareConnect\ApiException $e) {
                $e->getCode();
                switch ($e->getCode()) {
                    case 200:
                        $data = \SquareConnect\ObjectSerializer::deserialize($e->getResponseBody(), "\\SquareConnect\\Model\\ListRefundsResponse", $e->getResponseHeaders());
                        $e->setResponseObject($data);
                        break;
                    default:
                        throw $e;
                }
            }
        }
        throw new \InvalidArgumentException("Missing the required parameter \$location_id when calling listRefunds");
    }
    public function listTransactions($location_id, $begin_time = NULL, $end_time = NULL, $sort_order = NULL, $cursor = NULL)
    {
        list($response, $statusCode, $httpHeader) = $this->listTransactionsWithHttpInfo($location_id, $begin_time, $end_time, $sort_order, $cursor);
        return $response;
    }
    public function listTransactionsWithHttpInfo($location_id, $begin_time = NULL, $end_time = NULL, $sort_order = NULL, $cursor = NULL)
    {
        while ($location_id === NULL) {
            $resourcePath = "/v2/locations/{location_id}/transactions";
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
            if ($begin_time !== NULL) {
                $queryParams["begin_time"] = $this->apiClient->getSerializer()->toQueryValue($begin_time);
            }
            if ($end_time !== NULL) {
                $queryParams["end_time"] = $this->apiClient->getSerializer()->toQueryValue($end_time);
            }
            if ($sort_order !== NULL) {
                $queryParams["sort_order"] = $this->apiClient->getSerializer()->toQueryValue($sort_order);
            }
            if ($cursor !== NULL) {
                $queryParams["cursor"] = $this->apiClient->getSerializer()->toQueryValue($cursor);
            }
            if ($location_id !== NULL) {
                $resourcePath = str_replace("{location_id}", $this->apiClient->getSerializer()->toPathValue($location_id), $resourcePath);
            }
            $resourcePath = str_replace("{format}", "json", $resourcePath);
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
                list($response, $statusCode, $httpHeader) = $this->apiClient->callApi($resourcePath, "GET", $queryParams, $httpBody, $headerParams, "\\SquareConnect\\Model\\ListTransactionsResponse");
                if (!$response) {
                    return [NULL, $statusCode, $httpHeader];
                }
                return [\SquareConnect\ObjectSerializer::deserialize($response, "\\SquareConnect\\Model\\ListTransactionsResponse", $httpHeader), $statusCode, $httpHeader];
            } catch (\SquareConnect\ApiException $e) {
                $e->getCode();
                switch ($e->getCode()) {
                    case 200:
                        $data = \SquareConnect\ObjectSerializer::deserialize($e->getResponseBody(), "\\SquareConnect\\Model\\ListTransactionsResponse", $e->getResponseHeaders());
                        $e->setResponseObject($data);
                        break;
                    default:
                        throw $e;
                }
            }
        }
        throw new \InvalidArgumentException("Missing the required parameter \$location_id when calling listTransactions");
    }
    public function retrieveTransaction($location_id, $transaction_id)
    {
        list($response, $statusCode, $httpHeader) = $this->retrieveTransactionWithHttpInfo($location_id, $transaction_id);
        return $response;
    }
    public function retrieveTransactionWithHttpInfo($location_id, $transaction_id)
    {
        while ($location_id === NULL) {
            if ($transaction_id === NULL) {
                throw new \InvalidArgumentException("Missing the required parameter \$transaction_id when calling retrieveTransaction");
            }
            $resourcePath = "/v2/locations/{location_id}/transactions/{transaction_id}";
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
            if ($transaction_id !== NULL) {
                $resourcePath = str_replace("{transaction_id}", $this->apiClient->getSerializer()->toPathValue($transaction_id), $resourcePath);
            }
            $resourcePath = str_replace("{format}", "json", $resourcePath);
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
                list($response, $statusCode, $httpHeader) = $this->apiClient->callApi($resourcePath, "GET", $queryParams, $httpBody, $headerParams, "\\SquareConnect\\Model\\RetrieveTransactionResponse");
                if (!$response) {
                    return [NULL, $statusCode, $httpHeader];
                }
                return [\SquareConnect\ObjectSerializer::deserialize($response, "\\SquareConnect\\Model\\RetrieveTransactionResponse", $httpHeader), $statusCode, $httpHeader];
            } catch (\SquareConnect\ApiException $e) {
                $e->getCode();
                switch ($e->getCode()) {
                    case 200:
                        $data = \SquareConnect\ObjectSerializer::deserialize($e->getResponseBody(), "\\SquareConnect\\Model\\RetrieveTransactionResponse", $e->getResponseHeaders());
                        $e->setResponseObject($data);
                        break;
                    default:
                        throw $e;
                }
            }
        }
        throw new \InvalidArgumentException("Missing the required parameter \$location_id when calling retrieveTransaction");
    }
    public function voidTransaction($location_id, $transaction_id)
    {
        list($response, $statusCode, $httpHeader) = $this->voidTransactionWithHttpInfo($location_id, $transaction_id);
        return $response;
    }
    public function voidTransactionWithHttpInfo($location_id, $transaction_id)
    {
        while ($location_id === NULL) {
            if ($transaction_id === NULL) {
                throw new \InvalidArgumentException("Missing the required parameter \$transaction_id when calling voidTransaction");
            }
            $resourcePath = "/v2/locations/{location_id}/transactions/{transaction_id}/void";
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
            if ($transaction_id !== NULL) {
                $resourcePath = str_replace("{transaction_id}", $this->apiClient->getSerializer()->toPathValue($transaction_id), $resourcePath);
            }
            $resourcePath = str_replace("{format}", "json", $resourcePath);
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
                list($response, $statusCode, $httpHeader) = $this->apiClient->callApi($resourcePath, "POST", $queryParams, $httpBody, $headerParams, "\\SquareConnect\\Model\\VoidTransactionResponse");
                if (!$response) {
                    return [NULL, $statusCode, $httpHeader];
                }
                return [\SquareConnect\ObjectSerializer::deserialize($response, "\\SquareConnect\\Model\\VoidTransactionResponse", $httpHeader), $statusCode, $httpHeader];
            } catch (\SquareConnect\ApiException $e) {
                $e->getCode();
                switch ($e->getCode()) {
                    case 200:
                        $data = \SquareConnect\ObjectSerializer::deserialize($e->getResponseBody(), "\\SquareConnect\\Model\\VoidTransactionResponse", $e->getResponseHeaders());
                        $e->setResponseObject($data);
                        break;
                    default:
                        throw $e;
                }
            }
        }
        throw new \InvalidArgumentException("Missing the required parameter \$location_id when calling voidTransaction");
    }
}

?>