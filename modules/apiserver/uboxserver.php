<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["uboxservername"] = "uboxserver";
$APIMODULE["uboxservervisiblename"] = "uboxserver.net";
$APIMODULE["uboxservernotes"] = "";
function uboxserver_activate()
{
    GatewayField("uboxserver", "text", "username", "", "User name", "30", "");
    GatewayField("uboxserver", "text", "password", "", "Password", "30", "");
    GatewayField("uboxserver", "text", "apikey", "", "APi KEY", "200", "");
    GatewayField("uboxserver", "System", "apiurl", "http://codes.ath.cx/UBoxAPI.asmx", "apiurl", "30", "");
}
function uboxserver_accoutinfo($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/uboxserver.class.php";
    $Sign = APIUBOX::GetApiSign($VAL["username"], $VAL["password"], $VAL["apikey"]);
    $params = ["user" => $VAL["username"], "sign" => $Sign];
    $XML = APIUBOX::CallMethod("GetUserInfo", $params);
    if (is_string($XML)) {
        $isError = APIUBOX::HasError($XML);
        if ($isError) {
            $return["ERROR"] = APIUBOX::GetErrorDescription($XML);
        } else {
            $doc = new DOMDocument();
            $loaded = $doc->loadXML($XML);
            $nodes = $doc->getElementsByTagName("email");
            foreach ($nodes as $nod) {
                $return["Account email"] = $nod->nodeValue;
            }
            $nodes = $doc->getElementsByTagName("credits");
            foreach ($nodes as $nod) {
                $return["Credits available"] = $nod->nodeValue;
            }
            return $return;
        }
    } else {
        $return["ERROR"] = "Could not parse the XML stream";
    }
    return $return;
}
function uboxserver_services($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/uboxserver.class.php";
    $Sign = APIUBOX::GetApiSign($VAL["username"], $VAL["password"], $VAL["apikey"]);
    $params = ["user" => $VAL["username"], "sign" => $Sign];
    $XML = APIUBOX::CallMethod("GetOperations", $params);
    if (is_string($XML)) {
        $isError = APIUBOX::HasError($XML);
        if ($isError) {
            $return["ERROR"] = APIUBOX::GetErrorDescription($XML);
            return $return;
        }
        $Services = new SimpleXMLElement($XML);
        $Models = APIUBOX::CallMethod("GetModels");
        $Brands = new SimpleXMLElement($Models);
        $GID = NULL;
        foreach ($Brands->result->model as $gk => $Group) {
            $GID = (string) $Group->id;
            $return["Group"][$GID]["ID"] = (string) $Group->id;
            $return["Group"][$GID]["Name"] = (string) $Group->name;
            $TID = NULL;
            foreach ($Services->result->operation as $kt => $Tool) {
                if ($Tool->modelId == $GID) {
                    $TID = (string) $Tool->id;
                    $return["Group"][$GID]["Tool"][$TID]["ID"] = (string) $Tool->id;
                    $return["Group"][$GID]["Tool"][$TID]["Name"] = (string) $Tool->name;
                    $return["Group"][$GID]["Tool"][$TID]["Message"] = (string) $Tool->description;
                    $return["Group"][$GID]["Tool"][$TID]["Credits"] = (string) $Tool->credits;
                    $return["Group"][$GID]["Tool"][$TID]["Delivery.Unit"] = (string) $Tool->resolutionTime;
                }
            }
        }
    } else {
        $return["ERROR"] = "Could not parse the XML stream";
    }
    return $return;
}
function uboxserver_provider_($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/uboxserver.class.php";
    $Sign = APIUBOX::GetApiSign($VAL["username"], $VAL["password"], $VAL["apikey"]);
    $params = ["idOperation" => 2404];
    $XML = APIUBOX::CallMethod("GetNetWorks", $params);
    echo $XML;
    if (is_string($XML)) {
        $isError = APIUBOX::HasError($XML);
        if ($isError) {
            $return["ERROR"] = APIUBOX::GetErrorDescription($XML);
            return $return;
        }
        $provider = new SimpleXMLElement($XML);
        print_r($provider);
        exit;
    }
    $return["ERROR"] = "Could not parse the XML stream";
    return $return;
}
function uboxserver_send($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/uboxserver.class.php";
    $Sign = APIUBOX::GetApiSign($VAL["username"], $VAL["password"], $VAL["apikey"]);
    $params = ["user" => $VAL["username"], "operationId" => $VAL["API_ID"], "imei" => $VAL["IMEI"], "notes" => "Submitted by Dhru Fusion api", "sign" => $Sign];
    $XML = APIUBOX::CallMethod("AddNewRequest", $params);
    if (is_string($XML)) {
        $isError = APIUBOX::HasError($XML);
        if ($isError) {
            $return["ERROR"] = APIUBOX::GetErrorDescription($XML);
            return $return;
        }
        $request = new SimpleXMLElement($XML);
        if ($request) {
            if ($request->result->petition->id) {
                $return["SUCCESS"] = true;
                $return["MESSAGE"] = htmlspecialchars($request->result->petition->id);
                $return["ID"] = (string) $request->result->petition->id;
            } else {
                $return["ERROR"] = $request->statusmessage;
            }
        }
    } else {
        $return["ERROR"] = "Could not parse the XML stream";
    }
    return $return;
}
function uboxserver_get($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/uboxserver.class.php";
    $Sign = APIUBOX::GetApiSign($VAL["username"], $VAL["password"], $VAL["apikey"]);
    $params = ["user" => $VAL["username"], "requestID" => $VAL["API_ORDER_ID"], "sign" => $Sign];
    $XML = APIUBOX::CallMethod("CheckRequest", $params);
    if (is_string($XML)) {
        $isError = APIUBOX::HasError($XML);
        if ($isError) {
            $return["ERROR"] = APIUBOX::GetErrorDescription($XML);
            return $return;
        }
        $request = new SimpleXMLElement($XML);
        if ($request) {
            if ($request->result->petition->state == "Resolved") {
                $return["SUCCESS"] = true;
                $return["MESSAGE"] = htmlspecialchars($request->result->petition->result);
                $return["CODES"] = (string) $request->result->petition->result;
            }
            if ($request->result->petition->state == "Erroneous" || $request->result->petition->state == "Cancelled" || $request->result->petition->state == "Undefined") {
                $return["ERROR"] = "Not Found";
                $return["MESSAGE"] = "Not Found";
            }
        }
    }
    return $return;
}

?>