<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$_include = "init,qntrange,products";
include_once "_autoload.php";
if ($clientid) {
    $Cur = $conn->query("select default_currency,(select code from tbl_currencies\r\n    where id=tblUsers.default_currency) as code,client_group from tblUsers where id='" . $clientid . "'");
    $Cur = $Cur->fetch(PDO::FETCH_ASSOC);
    $RETURN["client"] = $Cur;
}
$RETURN["productlist"] = getProductList($productgroupid, $clientid, $server, $filter);
class ServicePrice
{
    private $serviceid = NULL;
    private $userid = NULL;
    private $usercurrency = NULL;
    private $systemcurrency = NULL;
    private $clientgroupid = NULL;
    private $differentcurrency = NULL;
    private $qnt = NULL;
    private $currencyarr = NULL;
    private $pricingqntid = NULL;
    private $servicepricingarr = NULL;
    private $autopricing = NULL;
    private $serviceapi = NULL;
    private $serviceapiid = NULL;
    private $serviceapitypeid = NULL;
    private $apicredit = NULL;
    public $pricingfrom = NULL;
    private $useasserver = NULL;
    public function __construct($serviceid)
    {
        global $conn;
        $this->serviceid = $serviceid;
        $Sq = $conn->query("select id,useasserver,API,autoapi,API_ID,API_TYPEID\r\n        from tbl_services_imei where id='" . $this->serviceid . "'");
        $ServiceDetail = $Sq->fetch(PDO::FETCH_ASSOC);
        if (!$ServiceDetail["id"]) {
            return false;
        }
        $this->autopricing = $ServiceDetail["autoapi"];
        $this->serviceapi = $ServiceDetail["API"];
        $this->serviceapiid = $ServiceDetail["API_ID"];
        $this->serviceapitypeid = $ServiceDetail["API_TYPEID"];
        $this->pricingfrom = "base";
        $this->useasserver = $ServiceDetail["useasserver"];
        $Currency = getAllCurrency("id");
        if (!$Currency) {
            $cq = $conn->query("select * from tbl_currencies");
            while ($r = $cq->fetch(PDO::FETCH_ASSOC)) {
                $_SESSION["allcurrency"]["id"][$r["id"]] = $r;
            }
            $Currency = $_SESSION["allcurrency"]["id"];
        }
        if ($this->autopricing && $this->serviceapi && $this->serviceapiid) {
            $aq = $conn->query("select credits from \r\n                tbl_apiserversservices\r\n            where gateway='" . $this->serviceapi . "' \r\n            and id='" . $this->serviceapiid . "'  and `type`='Tool' and \r\n            type_id='" . $this->serviceapitypeid . "' and useasserver='" . $this->useasserver . "'");
            $apiprice = $aq->fetch(PDO::FETCH_ASSOC);
            $this->apicredit = $apiprice["credits"];
            $this->apicredit_base = $apiprice["credits"];
            $apic = $conn->query("select `value` from tbl_apiservers\r\n            where gateway='" . $this->serviceapi . "' and setting='currency'");
            $apicurrency = $apic->fetch(PDO::FETCH_ASSOC);
            $CurrencyCode = getAllCurrency("code");
            if (!$CurrencyCode) {
                $cq = $conn->query("select * from tbl_currencies");
                while ($r = $cq->fetch(PDO::FETCH_ASSOC)) {
                    $_SESSION["allcurrency"]["code"][$r["code"]] = $r;
                }
                $CurrencyCode = $_SESSION["allcurrency"]["code"];
            }
            $apicurrencyid = $CurrencyCode[$apicurrency["value"]]["id"];
            $this->apicurrency = $apicurrencyid;
            if ($this->apicurrency != $_SESSION["system_default_currency"]["id"]) {
                $this->apicredit = round($this->apicredit_base / $Currency[$this->apicurrency]["rate"], 3);
            } else {
                $this->apicredit = $this->apicredit_base;
            }
        }
        $this->differentcurrency = false;
        $this->systemcurrency = $_SESSION["system_default_currency"]["id"];
        $qc = $conn->query("select id,rate from tbl_currencies");
        $CurrencyArr = [];
        while ($rc = $qc->fetch(PDO::FETCH_ASSOC)) {
            $CurrencyArr[$rc["id"]] = $rc["rate"];
        }
        $this->currencyarr = $CurrencyArr;
    }
    public function getResellersUserPrice($resellerid, $price, $servicetype, $increase, $increaseby)
    {
        global $conn;
        $sq = $conn->query("select * from tbl_store_pricing\r\n            where resellerid='" . $resellerid . "' and serviceid='" . $this->serviceid . "'\r\n            and servicetype='" . $servicetype . "'");
        $storeprice = $sq->fetch(PDO::FETCH_ASSOC);
        if ($storeprice["increaseby"] == "Percent") {
            $price = $price + round($price * $storeprice["increase"] / 100, 3);
        } else {
            if ($storeprice["increaseby"] == "Fixed") {
                $price = $price + $storeprice["increase"];
            } else {
                if ($increaseby == "Percent") {
                    $price = $price + round($price * $increase / 100, 3);
                } else {
                    if ($increaseby == "Fixed") {
                        $price = $price + $increase;
                    }
                }
            }
        }
        return $price;
    }
    public function getServicePricing($currencyid, $qnt = 1, $clientgroupid = "", $customerid = "")
    {
        global $conn;
        if (!$qnt) {
            $qnt = 1;
        }
        if ($customerid) {
            $uq = $conn->query("select price from tbl_discount_imei where user_id='" . $customerid . "'\r\n            and service_id='" . $this->serviceid . "'");
            $uq = $uq->fetch(PDO::FETCH_ASSOC);
            if (0 < strlen($uq["price"])) {
                $this->pricingfrom = "Users Custom";
                return $uq["price"];
            }
        }
        $pricingqntid = $this->GetPricingQntID($qnt);
        if (!$clientgroupid) {
            $clientgroupid = "base";
        } else {
            $this->pricingfrom = "Client Group";
        }
        $PriceArr = $this->getServicePricingArr();
        return $PriceArr[$pricingqntid][$clientgroupid][$currencyid]["price"];
    }
    public function getServicePricingArr()
    {
        if ($this->autopricing && $this->apicredit) {
            return $this->getAutoServicePricingArr();
        }
        return $this->getManualServicePricingArr();
    }
    public function apiMargin($amount, $increase, $increaseby)
    {
        if ($increaseby == "Percentage") {
            $amount = $amount + round($amount * $increase / 100, 3);
        } else {
            if ($increaseby == "Fixed") {
                $amount = $amount + $increase;
            }
        }
        return $amount;
    }
    public function getAutoServicePricingArr()
    {
        global $conn;
        $qc = $conn->query("select * from tbl_group_api_price \r\n            where service_id='" . $this->serviceid . "'");
        $GroupArr = [];
        $q = $conn->query("select id from tbl_client_group");
        while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
            $GroupArr[$r["id"]] = $r["id"];
        }
        array_push($GroupArr, "base", "retail");
        $PricingQntarr = [];
        while ($rc = $qc->fetch(PDO::FETCH_ASSOC)) {
            $RETURN[$rc["pricingqntid"]][$rc["group_id"]][$this->systemcurrency]["price"] = $this->apiMargin($this->apicredit, $rc["price"], $rc["increaseby"]);
            $PricingQntarr[$rc["pricingqntid"]] = $rc["pricingqntid"];
        }
        $defaultautoprice = "";
        foreach ($GroupArr as $groupid) {
            if (!$RETURN[0][$groupid]) {
                $qA = $conn->query("select value from tbl_apiservers\r\nWHERE gateway='" . $this->serviceapi . "' and setting='priceincrease'");
                $APIpricing = $qA->fetch(PDO::FETCH_ASSOC);
                if ($APIpricing["value"]) {
                    $defaultautoprice = json_decode($APIpricing["value"], true);
                    if ($defaultautoprice) {
                        foreach ($GroupArr as $groupid) {
                            if (!$RETURN[0][$groupid] && $defaultautoprice[$groupid]["price"] && $defaultautoprice[$groupid]["increaseby"]) {
                                $RETURN[0][$groupid][$this->systemcurrency]["price"] = $this->apiMargin($this->apicredit, $defaultautoprice[$groupid]["price"], $defaultautoprice[$groupid]["increaseby"]);
                                $PricingQntarr[0] = 0;
                            }
                        }
                    }
                    foreach ($PricingQntarr as $pricingqntid) {
                        foreach ($GroupArr as $groupid) {
                            foreach ($this->currencyarr as $currencyid => $currate) {
                                if (!$RETURN[$pricingqntid][$groupid][$currencyid]["price"]) {
                                    $baseprice = 0;
                                    if ($RETURN[$pricingqntid][$groupid][$this->systemcurrency]["price"]) {
                                        $baseprice = $RETURN[$pricingqntid][$groupid][$this->systemcurrency]["price"];
                                        $baseprice = round($baseprice * $currate, 3);
                                    } else {
                                        if ($RETURN[$pricingqntid]["base"][$currencyid]) {
                                            $baseprice = $RETURN[$pricingqntid]["base"][$currencyid]["price"];
                                        } else {
                                            $baseprice = $RETURN[$pricingqntid]["base"][$this->systemcurrency]["price"];
                                            $baseprice = round($baseprice * $currate, 3);
                                        }
                                    }
                                    $RETURN[$pricingqntid][$groupid][$currencyid]["price"] = $baseprice;
                                }
                            }
                        }
                    }
                    return $RETURN;
                }
            }
        }
    }
    public function getManualServicePricingArr()
    {
        global $conn;
        $qc = $conn->query("select * from tbl_service_pricing \r\n            where serviceid='" . $this->serviceid . "'");
        $GroupArr = [];
        $q = $conn->query("select id from tbl_client_group");
        while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
            $GroupArr[$r["id"]] = $r["id"];
        }
        array_push($GroupArr, "base", "retail");
        $PricingQntarr = [];
        while ($rc = $qc->fetch(PDO::FETCH_ASSOC)) {
            $RETURN[$rc["pricingqntid"]][$rc["groupid"]][$rc["currencyid"]]["price"] = $rc["price"];
            $PricingQntarr[$rc["pricingqntid"]] = $rc["pricingqntid"];
        }
        foreach ($PricingQntarr as $pricingqntid) {
            foreach ($GroupArr as $groupid) {
                foreach ($this->currencyarr as $currencyid => $currate) {
                    if (!$RETURN[$pricingqntid][$groupid][$currencyid]["price"]) {
                        $baseprice = 0;
                        if ($RETURN[$pricingqntid][$groupid][$this->systemcurrency]["price"]) {
                            $baseprice = $RETURN[$pricingqntid][$groupid][$this->systemcurrency]["price"];
                            $baseprice = round($baseprice * $currate, 3);
                        } else {
                            if ($RETURN[$pricingqntid]["base"][$currencyid]) {
                                $baseprice = $RETURN[$pricingqntid]["base"][$currencyid]["price"];
                            } else {
                                $baseprice = $RETURN[$pricingqntid]["base"][$this->systemcurrency]["price"];
                                $baseprice = round($baseprice * $currate, 3);
                            }
                        }
                        $RETURN[$pricingqntid][$groupid][$currencyid]["price"] = $baseprice;
                    }
                }
            }
        }
        return $RETURN;
    }
    public function GetPricingQntID($qnt)
    {
        global $conn;
        $qp = $conn->query("select pricingqntid from tbl_pricing_qnt\r\n      where pricingqntid in (select distinct(pricingqntid)\r\n      from tbl_service_pricing where serviceid='" . $this->serviceid . "')\r\n      and end>='" . $qnt . "' and `start`<='" . $qnt . "' ORDER BY end asc limit 1");
        $qp = $qp->fetch(PDO::FETCH_ASSOC);
        if ($qp["pricingqntid"]) {
            return $qp["pricingqntid"];
        }
        return 0;
    }
}
function getProductList($productgroupid, $clientid = "", $server = 0, $filter)
{
    global $conn;
    global $Cur;
    $CLIENTGROUPARR = getClientGroup();
    if ($server) {
        $WHERCOND = " and useasserver='" . $server . "'";
    } else {
        $WHERCOND = " and useasserver=0";
    }
    if ($clientid) {
        if ($productgroupid) {
            $WHWERE = " and  group_id='" . $productgroupid . "'";
        }
        $q = $conn->query("select id,service_name \r\n        from tbl_services_imei WHERE 1=1 " . $WHWERE . " " . $WHERCOND . "\r\n        ORDER BY `sort` asc");
        while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
            $Service = new ServicePrice($r["id"]);
            $r["defaultprice"] = $Service->getServicePricing($Cur["default_currency"], "", $Cur["client_group"], "");
            $r["price"] = $Service->getServicePricing($Cur["default_currency"], "", $Cur["client_group"], $clientid);
            if ($Service->pricingfrom == "Users Custom") {
                $r["usercustomprice"] = $r["price"];
            } else {
                $r["usercustomprice"] = "";
            }
            $CLIENTGROUP = $Cur["client_group"];
            if ($Cur[client_group] == 0) {
                $CLIENTGROUP = "base";
            }
            $sta = $conn->query("select status from tbl_service_status where \r\n                groupid='" . $CLIENTGROUP . "' and serviceid='" . $r["id"] . "'");
            $status = $sta->fetch(PDO::FETCH_ASSOC);
            $r["active"] = 0;
            if ($status["status"]) {
                $r["active"] = 1;
            }
            $r["service_name"] = html_entity_decode($r["service_name"]);
            $RETURN[$r["id"]] = $r;
        }
        return $RETURN;
    }
    if (0 < strlen($filter)) {
        $filter = urldecode($filter);
        $q = $conn->query("select id from tbl_services_imei \r\n        where ( service_name like '%" . $filter . "%' ) " . $WHERCOND . "\r\n        ORDER BY `sort` ASC");
        while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
        }
        return $RETURN;
    }
    $q = $conn->query("select id from tbl_services_imei \r\n        where (group_id='" . $productgroupid . "' ) " . $WHERCOND . "\r\n        ORDER BY `sort` ASC");
    $RETURN[$r["id"]] = getProductDetail($r["id"]);
    if ($RETURN[$r["id"]]["product"]["sort"]) {
        $RETURN[$r["id"]]["product"]["sort"] = (int) $RETURN[$r["id"]]["product"]["sort"];
    }
}

?>