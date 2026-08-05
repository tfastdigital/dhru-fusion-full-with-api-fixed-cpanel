<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe\Util;

class Util
{
    private static $isHashEqualsAvailable = NULL;
    private static $isMbstringAvailable = NULL;
    public static function isList($array)
    {
        if (!is_array($array)) {
            return false;
        }
        if ($array === []) {
            return true;
        }
        if (array_keys($array) !== range(0, count($array) - 1)) {
            return false;
        }
        return true;
    }
    public static function convertStripeObjectToArray($values)
    {
        $results = [];
        foreach ($values as $k => $v) {
            if ($k[0] != "_") {
                if ($v instanceof \Stripe\StripeObject) {
                    $results[$k] = $v->__toArray(true);
                } else {
                    if (is_array($v)) {
                        $results[$k] = self::convertStripeObjectToArray($v);
                    } else {
                        $results[$k] = $v;
                    }
                }
            }
        }
        return $results;
    }
    public static function convertToStripeObject($resp, $opts)
    {
        $types = [\Stripe\Collection::OBJECT_NAME => "Stripe\\Collection", \Stripe\Account::OBJECT_NAME => "Stripe\\Account", \Stripe\AccountLink::OBJECT_NAME => "Stripe\\AccountLink", \Stripe\AlipayAccount::OBJECT_NAME => "Stripe\\AlipayAccount", \Stripe\ApplePayDomain::OBJECT_NAME => "Stripe\\ApplePayDomain", \Stripe\ApplicationFee::OBJECT_NAME => "Stripe\\ApplicationFee", \Stripe\Balance::OBJECT_NAME => "Stripe\\Balance", \Stripe\BalanceTransaction::OBJECT_NAME => "Stripe\\BalanceTransaction", \Stripe\BankAccount::OBJECT_NAME => "Stripe\\BankAccount", \Stripe\BitcoinReceiver::OBJECT_NAME => "Stripe\\BitcoinReceiver", \Stripe\BitcoinTransaction::OBJECT_NAME => "Stripe\\BitcoinTransaction", \Stripe\Card::OBJECT_NAME => "Stripe\\Card", \Stripe\Charge::OBJECT_NAME => "Stripe\\Charge", \Stripe\Checkout\Session::OBJECT_NAME => "Stripe\\Checkout\\Session", \Stripe\CountrySpec::OBJECT_NAME => "Stripe\\CountrySpec", \Stripe\Coupon::OBJECT_NAME => "Stripe\\Coupon", \Stripe\CreditNote::OBJECT_NAME => "Stripe\\CreditNote", \Stripe\Customer::OBJECT_NAME => "Stripe\\Customer", \Stripe\Discount::OBJECT_NAME => "Stripe\\Discount", \Stripe\Dispute::OBJECT_NAME => "Stripe\\Dispute", \Stripe\EphemeralKey::OBJECT_NAME => "Stripe\\EphemeralKey", \Stripe\Event::OBJECT_NAME => "Stripe\\Event", \Stripe\ExchangeRate::OBJECT_NAME => "Stripe\\ExchangeRate", \Stripe\ApplicationFeeRefund::OBJECT_NAME => "Stripe\\ApplicationFeeRefund", \Stripe\File::OBJECT_NAME => "Stripe\\File", \Stripe\File::OBJECT_NAME_ALT => "Stripe\\File", \Stripe\FileLink::OBJECT_NAME => "Stripe\\FileLink", \Stripe\Invoice::OBJECT_NAME => "Stripe\\Invoice", \Stripe\InvoiceItem::OBJECT_NAME => "Stripe\\InvoiceItem", \Stripe\InvoiceLineItem::OBJECT_NAME => "Stripe\\InvoiceLineItem", \Stripe\IssuerFraudRecord::OBJECT_NAME => "Stripe\\IssuerFraudRecord", \Stripe\Issuing\Authorization::OBJECT_NAME => "Stripe\\Issuing\\Authorization", \Stripe\Issuing\Card::OBJECT_NAME => "Stripe\\Issuing\\Card", \Stripe\Issuing\CardDetails::OBJECT_NAME => "Stripe\\Issuing\\CardDetails", \Stripe\Issuing\Cardholder::OBJECT_NAME => "Stripe\\Issuing\\Cardholder", \Stripe\Issuing\Dispute::OBJECT_NAME => "Stripe\\Issuing\\Dispute", \Stripe\Issuing\Transaction::OBJECT_NAME => "Stripe\\Issuing\\Transaction", \Stripe\LoginLink::OBJECT_NAME => "Stripe\\LoginLink", \Stripe\Order::OBJECT_NAME => "Stripe\\Order", \Stripe\OrderItem::OBJECT_NAME => "Stripe\\OrderItem", \Stripe\OrderReturn::OBJECT_NAME => "Stripe\\OrderReturn", \Stripe\PaymentIntent::OBJECT_NAME => "Stripe\\PaymentIntent", \Stripe\PaymentMethod::OBJECT_NAME => "Stripe\\PaymentMethod", \Stripe\Payout::OBJECT_NAME => "Stripe\\Payout", \Stripe\Person::OBJECT_NAME => "Stripe\\Person", \Stripe\Plan::OBJECT_NAME => "Stripe\\Plan", \Stripe\Product::OBJECT_NAME => "Stripe\\Product", \Stripe\Radar\ValueList::OBJECT_NAME => "Stripe\\Radar\\ValueList", \Stripe\Radar\ValueListItem::OBJECT_NAME => "Stripe\\Radar\\ValueListItem", \Stripe\Recipient::OBJECT_NAME => "Stripe\\Recipient", \Stripe\RecipientTransfer::OBJECT_NAME => "Stripe\\RecipientTransfer", \Stripe\Refund::OBJECT_NAME => "Stripe\\Refund", \Stripe\Reporting\ReportRun::OBJECT_NAME => "Stripe\\Reporting\\ReportRun", \Stripe\Reporting\ReportType::OBJECT_NAME => "Stripe\\Reporting\\ReportType", \Stripe\Review::OBJECT_NAME => "Stripe\\Review", \Stripe\SKU::OBJECT_NAME => "Stripe\\SKU", \Stripe\Sigma\ScheduledQueryRun::OBJECT_NAME => "Stripe\\Sigma\\ScheduledQueryRun", \Stripe\Source::OBJECT_NAME => "Stripe\\Source", \Stripe\SourceTransaction::OBJECT_NAME => "Stripe\\SourceTransaction", \Stripe\Subscription::OBJECT_NAME => "Stripe\\Subscription", \Stripe\SubscriptionItem::OBJECT_NAME => "Stripe\\SubscriptionItem", \Stripe\SubscriptionSchedule::OBJECT_NAME => "Stripe\\SubscriptionSchedule", \Stripe\SubscriptionScheduleRevision::OBJECT_NAME => "Stripe\\SubscriptionScheduleRevision", \Stripe\TaxId::OBJECT_NAME => "Stripe\\TaxId", \Stripe\TaxRate::OBJECT_NAME => "Stripe\\TaxRate", \Stripe\ThreeDSecure::OBJECT_NAME => "Stripe\\ThreeDSecure", \Stripe\Terminal\ConnectionToken::OBJECT_NAME => "Stripe\\Terminal\\ConnectionToken", \Stripe\Terminal\Location::OBJECT_NAME => "Stripe\\Terminal\\Location", \Stripe\Terminal\Reader::OBJECT_NAME => "Stripe\\Terminal\\Reader", \Stripe\Token::OBJECT_NAME => "Stripe\\Token", \Stripe\Topup::OBJECT_NAME => "Stripe\\Topup", \Stripe\Transfer::OBJECT_NAME => "Stripe\\Transfer", \Stripe\TransferReversal::OBJECT_NAME => "Stripe\\TransferReversal", \Stripe\UsageRecord::OBJECT_NAME => "Stripe\\UsageRecord", \Stripe\UsageRecordSummary::OBJECT_NAME => "Stripe\\UsageRecordSummary", \Stripe\WebhookEndpoint::OBJECT_NAME => "Stripe\\WebhookEndpoint"];
        if (self::isList($resp)) {
            $mapped = [];
            foreach ($resp as $i) {
                array_push($mapped, self::convertToStripeObject($i, $opts));
            }
            return $mapped;
        } else {
            if (is_array($resp)) {
                if (isset($resp["object"]) && is_string($resp["object"]) && isset($types[$resp["object"]])) {
                    $class = $types[$resp["object"]];
                } else {
                    $class = "Stripe\\StripeObject";
                }
                return $class::constructFrom($resp, $opts);
            }
            return $resp;
        }
    }
    public static function utf8($value)
    {
        if (self::$isMbstringAvailable === NULL) {
            self::$isMbstringAvailable = function_exists("mb_detect_encoding");
            if (!self::$isMbstringAvailable) {
                trigger_error("It looks like the mbstring extension is not enabled. UTF-8 strings will not properly be encoded. Ask your system administrator to enable the mbstring extension, or write to support@stripe.com if you have any questions.", E_USER_WARNING);
            }
        }
        if (is_string($value) && self::$isMbstringAvailable && mb_detect_encoding($value, "UTF-8", true) != "UTF-8") {
            return utf8_encode($value);
        }
        return $value;
    }
    public static function secureCompare($a, $b)
    {
        if (self::$isHashEqualsAvailable === NULL) {
            self::$isHashEqualsAvailable = function_exists("hash_equals");
        }
        if (self::$isHashEqualsAvailable) {
            return hash_equals($a, $b);
        }
        if (strlen($a) != strlen($b)) {
            return false;
        }
        $result = 0;
        for ($i = 0; $i < strlen($a); $i++) {
            $result |= ord($a[$i]) ^ ord($b[$i]);
        }
        return $result == 0;
    }
    public static function objectsToIds($h)
    {
        if ($h instanceof \Stripe\ApiResource) {
            return $h->id;
        }
        if (static::isList($h)) {
            $results = [];
            foreach ($h as $v) {
                array_push($results, static::objectsToIds($v));
            }
            return $results;
        } else {
            if (is_array($h)) {
                $results = [];
                foreach ($h as $k => $v) {
                    if (!is_null($v)) {
                        $results[$k] = static::objectsToIds($v);
                    }
                }
                return $results;
            } else {
                return $h;
            }
        }
    }
    public static function encodeParameters($params)
    {
        $flattenedParams = self::flattenParams($params);
        $pieces = [];
        foreach ($flattenedParams as $param) {
            list($k, $v) = $param;
            array_push($pieces, self::urlEncode($k) . "=" . self::urlEncode($v));
        }
        return implode("&", $pieces);
    }
    public static function flattenParams($params, $parentKey = NULL)
    {
        $result = [];
        foreach ($params as $key => $value) {
            $calculatedKey = $parentKey ? $parentKey . "[" . $key . "]" : $key;
            if (self::isList($value)) {
                $result = array_merge($result, self::flattenParamsList($value, $calculatedKey));
            } else {
                if (is_array($value)) {
                    $result = array_merge($result, self::flattenParams($value, $calculatedKey));
                } else {
                    array_push($result, [$calculatedKey, $value]);
                }
            }
        }
        return $result;
    }
    public static function flattenParamsList($value, $calculatedKey)
    {
        $result = [];
        foreach ($value as $i => $elem) {
            if (self::isList($elem)) {
                $result = array_merge($result, self::flattenParamsList($elem, $calculatedKey));
            } else {
                if (is_array($elem)) {
                    $result = array_merge($result, self::flattenParams($elem, $calculatedKey . "[" . $i . "]"));
                } else {
                    array_push($result, [$calculatedKey . "[" . $i . "]", $elem]);
                }
            }
        }
        return $result;
    }
    public static function urlEncode($key)
    {
        $s = urlencode($key);
        $s = str_replace("%5B", "[", $s);
        $s = str_replace("%5D", "]", $s);
        return $s;
    }
    public static function normalizeId($id)
    {
        if (is_array($id)) {
            $params = $id;
            $id = $params["id"];
            unset($params["id"]);
        } else {
            $params = [];
        }
        return [$id, $params];
    }
    public static function currentTimeMillis()
    {
        return (int) round(microtime(true) * 1000);
    }
}

?>