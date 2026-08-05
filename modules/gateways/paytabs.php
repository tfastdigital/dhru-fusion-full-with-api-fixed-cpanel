<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function paytabs_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "PayTab"], "profileserverkey" => ["Name" => "Profile Server Key", "Type" => "text", "Size" => "100"], "profile_id" => ["Name" => "Profile ID", "Type" => "text", "Size" => "50"], "website" => ["Name" => "Website name", "Type" => "text", "Size" => "20"]];
    return $configarray;
}
function paytabs_link($params)
{
    global $config;
    global $paytabs;
    if ($paytabs) {
        $profileserverkey = $params["profileserverkey"];
        $profile_id = $params["profile_id"];
        $invoiceid = $params["invoiceid"];
        $SiteAddress = $config["site_address"];
        if ($config["config_ssl_allow"]) {
            $SiteAddress = $config["config_ssl_allow"];
        }
        $description = $params["description"];
        $data["profile_id"] = $profile_id;
        $data["tran_type"] = "sale";
        $data["tran_class"] = "ecom";
        $data["cart_id"] = $invoiceid;
        $data["cart_description"] = $description;
        $data["cart_currency"] = $params["currency"];
        $data["cart_amount"] = $params["amount"];
        $data["callback"] = $SiteAddress . "modules/gateways/callback/paytabs.php";
        $aggr = explode("_", $invoiceid);
        if ($aggr[0] == "B") {
            $data["return"] = $SiteAddress . "merchant/index.php?showcounter=true&payment=success&check=1";
        } else {
            $data["return"] = _url("viewinvoice/a/1/showcounter/true/id/" . md5($params["invoiceid"]), true);
        }
        $CurlPost["HEADER"] = ["authorization: " . $profileserverkey, "content-type: application/json"];
        $ch = initCurl("https://secure.paytabs.com/payment/request", "", $CurlPost, "", $data);
        $Res = json_decode($ch, true);
        if ($Res["redirect_url"]) {
            header("Location: " . $Res["redirect_url"]);
            echo "            <script>\n                location.href='";
            echo $Res["redirect_url"];
            echo "';\n            </script>\n";
            exit;
        }
        return "Error:" . json_encode($Res);
    }
    $code = "";
    $month = "<select name='expiry_month' class='form-control'>";
    for ($i = 1; $i <= 12; $i++) {
        $month .= "<option>" . $i . "</option>";
    }
    $month .= "</select>";
    $year = "<select name='expiry_year'  class='form-control'>";
    for ($i = date("Y"); $i <= date("Y") + 10; $i++) {
        $year .= "<option>" . $i . "</option>";
    }
    $year .= "</select>";
    $code .= "<form action=\"\" method=\"post\">\n   <input type=\"hidden\" name=\"paytabs\" value=\"1\" />\n\n\n    <input type=\"submit\" name=\"submit\" class=\"btn btn-primary btn-primary paymentbtn\" value=\"Pay Now\" />\n\n    </form>";
    return $code;
}

?>