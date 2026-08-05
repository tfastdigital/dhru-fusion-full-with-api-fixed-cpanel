<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function squareup_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "SqureUp"], "accesstoken" => ["Name" => "Access Token", "Type" => "text", "Size" => "40"], "locationid" => ["Name" => "Location ID", "Type" => "text", "Size" => "30"]];
    return $configarray;
}
function squareup_link($params)
{
    global $config;
    global $lng_languag;
    $code = "";
    $invoiceid = $params["invoiceid"];
    $invoicetotal = $params["amount"];
    $invoicetotal = formatCurrency2($invoicetotal);
    require_once ROOTDIR . "/includes/3rdparty/squareup/autoload.php";
    $accessToken = $params["accesstoken"];
    $locationId = $params["locationid"];
    $defaultApiConfig = new SquareConnect\Configuration();
    $defaultApiConfig->setAccessToken($accessToken);
    $defaultApiClient = new SquareConnect\ApiClient($defaultApiConfig);
    $checkoutClient = new SquareConnect\Api\CheckoutApi($defaultApiClient);
    $price = new SquareConnect\Model\Money();
    $price->setAmount(round($invoicetotal * 100));
    $price->setCurrency($params["currency"]);
    $book = new SquareConnect\Model\CreateOrderRequestLineItem();
    $book->setName($params["description"]);
    $book->setQuantity("1");
    $book->setBasePriceMoney($price);
    $lineItems = [];
    array_push($lineItems, $book);
    $order = new SquareConnect\Model\CreateOrderRequest();
    $order->setIdempotencyKey(uniqid());
    $order->setLineItems($lineItems);
    $checkout = new SquareConnect\Model\CreateCheckoutRequest();
    $checkout->setIdempotencyKey(uniqid());
    $checkout->setOrder($order);
    $sitelink = $config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"];
    $checkout->setRedirectUrl(_url("viewinvoice", true));
    try {
        $result = $checkoutClient->createCheckout($locationId, $checkout);
        $checkoutId = $result->getCheckout()->getId();
        $checkoutUrl = $result->getCheckout()->getCheckoutPageUrl();
        $_SESSION["checkoutid"] = $checkoutId;
        dquery("UPDATE tbl_invoices set businessid='" . $checkoutId . "' where id='" . $invoiceid . "'");
        header("Location: " . $checkoutUrl);
        echo "        <script>\r\n            location.href='";
        echo $checkoutUrl;
        echo "';\r\n        </script>\r\n";
    } catch (Exception $e) {
        echo "Exception when calling CheckoutApi->createCheckout: ";
        echo $e->getMessage();
        echo PHP_EOL;
    }
}

?>