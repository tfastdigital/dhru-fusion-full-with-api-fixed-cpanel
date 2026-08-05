<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class ShippingCalculator
{
    public $weight = 1;
    public $weight_unit = "lb";
    public $size_length = 4;
    public $size_width = 8;
    public $size_height = 2;
    public $size_unit = "in";
    public $debug = false;
    public $batch_ups = false;
    public $batch_usps = true;
    public $batch_fedex = false;
    public $services = NULL;
    public $from_zip = NULL;
    public $from_state = NULL;
    public $from_country = NULL;
    public $to_zip = NULL;
    public $to_stat = NULL;
    public $to_country = NULL;
    public $ups_access = NULL;
    public $ups_user = NULL;
    public $ups_pass = NULL;
    public $ups_account = NULL;
    public $usps_user = NULL;
    public $fedex_account = NULL;
    public $fedex_meter = NULL;
    public $rates = NULL;
    public function ShippingCalculator($config)
    {
        if ($config) {
            foreach ($config as $k => $v) {
                $this->{$k} = $v;
            }
        }
    }
    public function calculate($company = NULL, $code = NULL)
    {
        $this->rates = NULL;
        $services = $this->services;
        if ($company && $code) {
            $services[$company][$code] = 1;
        }
        if ($services) {
            foreach ($services as $company => $codes) {
                foreach ($codes as $code => $name) {
                    switch ($company) {
                        case "ups":
                            $this->rates[$company][$code] = $this->calculate_ups($code);
                            break;
                        case "usps":
                            if ($this->batch_usps) {
                                $batch[] = $code;
                            } else {
                                $this->rates[$company][$code] = $this->calculate_usps($code);
                            }
                            break;
                        case "fedex":
                            $this->rates[$company][$code] = $this->calculate_fedex($code);
                            break;
                    }
                }
                if ($company == "usps" && $this->batch_usps && 0 < count($batch)) {
                    $this->rates[$company] = $this->calculate_usps($batch);
                }
            }
        }
        return $this->rates;
    }
    public function calculate_ups($code)
    {
        $url = "https://www.ups.com/ups.app/xml/Rate";
        $data = "<?xml version=\"1.0\"?>  \n<AccessRequest xml:lang=\"en-US\">  \n\t<AccessLicenseNumber>" . $this->ups_access . "</AccessLicenseNumber>  \n\t<UserId>" . $this->ups_user . "</UserId>  \n\t<Password>" . $this->ups_pass . "</Password>  \n</AccessRequest>  \n<?xml version=\"1.0\"?>  \n<RatingServiceSelectionRequest xml:lang=\"en-US\">  \n\t<Request>  \n\t\t<TransactionReference>  \n\t\t\t<CustomerContext>Bare Bones Rate Request</CustomerContext>  \n\t\t\t<XpciVersion>1.0001</XpciVersion>  \n\t\t</TransactionReference>  \n\t\t<RequestAction>Rate</RequestAction>  \n\t\t<RequestOption>Rate</RequestOption>  \n\t</Request>  \n\t<PickupType>  \n\t\t<Code>01</Code>  \n\t</PickupType>  \n\t<Shipment>  \n\t\t<Shipper>  \n\t\t\t<Address>  \n\t\t\t\t<PostalCode>" . $this->from_zip . "</PostalCode>  \n\t\t\t\t<CountryCode>" . $this->from_country . "</CountryCode>  \n\t\t\t</Address>  \n\t\t<ShipperNumber>" . $this->ups_account . "</ShipperNumber>  \n\t\t</Shipper>  \n\t\t<ShipTo>  \n\t\t\t<Address>  \n\t\t\t\t<PostalCode>" . $this->to_zip . "</PostalCode>  \n\t\t\t\t<CountryCode>" . $this->to_country . "</CountryCode>  \n\t\t\t<ResidentialAddressIndicator/>  \n\t\t\t</Address>  \n\t\t</ShipTo>  \n\t\t<ShipFrom>  \n\t\t\t<Address>  \n\t\t\t\t<PostalCode>" . $this->from_zip . "</PostalCode>  \n\t\t\t\t<CountryCode>" . $this->from_country . "</CountryCode>  \n\t\t\t</Address>  \n\t\t</ShipFrom>  \n\t\t<Service>  \n\t\t\t<Code>" . $code . "</Code>  \n\t\t</Service>  \n\t\t<Package>  \n\t\t\t<PackagingType>  \n\t\t\t\t<Code>02</Code>  \n\t\t\t</PackagingType>  \n\t\t\t<Dimensions>  \n\t\t\t\t<UnitOfMeasurement>  \n\t\t\t\t\t<Code>IN</Code>  \n\t\t\t\t</UnitOfMeasurement>  \n\t\t\t\t<Length>" . ($this->size_unit != "in" ? $this->convert_sze($this->size_length, $this->size_unit, "in") : $this->size_length) . "</Length>  \n\t\t\t\t<Width>" . ($this->size_unit != "in" ? $this->convert_sze($this->size_width, $this->size_unit, "in") : $this->size_width) . "</Width>  \n\t\t\t\t<Height>" . ($this->size_unit != "in" ? $this->convert_sze($this->size_height, $this->size_unit, "in") : $this->size_height) . "</Height>  \n\t\t\t</Dimensions>  \n\t\t\t<PackageWeight>  \n\t\t\t\t<UnitOfMeasurement>  \n\t\t\t\t\t<Code>LBS</Code>  \n\t\t\t\t</UnitOfMeasurement>  \n\t\t\t\t<Weight>" . ($this->weight_unit != "lb" ? $this->convert_weight($this->weight, $this->weight_unit, "lb") : $this->weight) . "</Weight>  \n\t\t\t</PackageWeight>  \n\t\t</Package>  \n\t</Shipment>  \n</RatingServiceSelectionRequest>";
        $results = $this->curl($url, $data);
        if ($this->debug) {
            echo "<xmp>" . $data . "</xmp><br />";
            echo "<xmp>" . $results . "</xmp><br />";
        }
        preg_match("/<MonetaryValue>(.*?)<\\/MonetaryValue>/", $results, $rate);
        return $rate[1];
    }
    public function calculate_usps($code)
    {
        if ($this->weight_unit != "lb") {
            $weight = $this->convert_weight($weight, $this->weight_unit, "lb");
        } else {
            $weight = $this->weight;
        }
        $lbs = floor($weight);
        $ozs = ($weight - $lbs) * 16;
        if ($lbs == 0 && $ozs < 1) {
            $ozs = 1;
        }
        $array = true;
        if (!is_array($code)) {
            $array = false;
            $code = [$code];
        }
        $url = "http://Production.ShippingAPIs.com/ShippingAPI.dll";
        $data = "API=RateV2&XML=<RateV2Request USERID=\"" . $this->usps_user . "\">";
        foreach ($code as $x => $c) {
            $data .= "<Package ID=\"" . $x . "\"><Service>" . $c . "</Service><ZipOrigination>" . $this->from_zip . "</ZipOrigination><ZipDestination>" . $this->to_zip . "</ZipDestination><Pounds>" . $lbs . "</Pounds><Ounces>" . $ozs . "</Ounces><Size>REGULAR</Size><Machinable>TRUE</Machinable></Package>";
        }
        $data .= "</RateV2Request>";
        $results = $this->curl($url, $data);
        if ($this->debug) {
            echo "<xmp>" . $data . "</xmp><br />";
            echo "<xmp>" . $results . "</xmp><br />";
        }
        preg_match_all("/<Package ID=\"([0-9]{1,3})\">(.+?)<\\/Package>/", $results, $packages);
        foreach ($packages[1] as $x => $package) {
            preg_match("/<Rate>(.+?)<\\/Rate>/", $packages[2][$x], $rate);
            $rates[$code[$package]] = $rate[1];
        }
        if ($array) {
            return $rates;
        }
        return $rate[1];
    }
    public function calculate_fedex($code)
    {
        $url = "https://gatewaybeta.fedex.com/GatewayDC";
        $data = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n<FDXRateRequest xmlns:api=\"http://www.fedex.com/fsmapi\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"FDXRateRequest.xsd\">\n\t<RequestHeader>\n\t\t<CustomerTransactionIdentifier>Express Rate</CustomerTransactionIdentifier>\n\t\t<AccountNumber>" . $this->fedex_account . "</AccountNumber>\n\t\t<MeterNumber>" . $this->fedex_meter . "</MeterNumber>\n\t\t<CarrierCode>" . (in_array($code, ["FEDEXGROUND", "GROUNDHOMEDELIVERY"]) ? "FDXG" : "FDXE") . "</CarrierCode>\n\t</RequestHeader>\n\t<DropoffType>REGULARPICKUP</DropoffType>\n\t<Service>" . $code . "</Service>\n\t<Packaging>YOURPACKAGING</Packaging>\n\t<WeightUnits>LBS</WeightUnits>\n\t<Weight>" . number_format($this->weight_unit != "lb" ? convert_weight($this->weight, $this->weight_unit, "lb") : $this->weight, 1, ".", "") . "</Weight>\n\t<OriginAddress>\n\t\t<StateOrProvinceCode>" . $this->from_state . "</StateOrProvinceCode>\n\t\t<PostalCode>" . $this->from_zip . "</PostalCode>\n\t\t<CountryCode>" . $this->from_country . "</CountryCode>\n\t</OriginAddress>\n\t<DestinationAddress>\n\t\t<StateOrProvinceCode>" . $this->to_state . "</StateOrProvinceCode>\n\t\t<PostalCode>" . $this->to_zip . "</PostalCode>\n\t\t<CountryCode>" . $this->to_country . "</CountryCode>\n\t</DestinationAddress>\n\t<Payment>\n\t\t<PayorType>SENDER</PayorType>\n\t</Payment>\n\t<PackageCount>1</PackageCount>\n</FDXRateRequest>";
        $results = $this->curl($url, $data);
        if ($this->debug) {
            echo "<xmp>" . $data . "</xmp><br />";
            echo "<xmp>" . $results . "</xmp><br />";
        }
        preg_match("/<NetCharge>(.*?)<\\/NetCharge>/", $results, $rate);
        return $rate[1];
    }
    public function curl($url, $data = NULL)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        if ($data) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        $contents = curl_exec($ch);
        return $contents;
    }
    public function convert_weight($weight, $old_unit, $new_unit)
    {
        $units["oz"] = 1;
        $units["lb"] = 0;
        $units["gram"] = 0;
        $units["kg"] = 0;
        if ($old_unit != "oz") {
            $weight = $weight / $units[$old_unit];
        }
        $weight = $weight * $units[$new_unit];
        if ($weight < 0) {
            $weight = 0;
        }
        return round($weight, 2);
    }
    public function convert_size($size, $old_unit, $new_unit)
    {
        $units["in"] = 1;
        $units["cm"] = 0;
        $units["feet"] = 0;
        if ($old_unit != "in") {
            $size = $size / $units[$old_unit];
        }
        $size = $size * $units[$new_unit];
        if ($size < 0) {
            $size = 0;
        }
        return round($size, 2);
    }
    public function set_value($k, $v)
    {
        $this->{$k} = $v;
    }
}

?>