<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($save_token != sha1(session_id() . $_SESSION["adminid"] . ":SaveMe123122sds2")) {
    exit("error:invalid token");
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($ips) {
    $ip = explode("\n", $ips);
    foreach ($ip as $i) {
        $value = explode("#", $i);
        if (preg_match("/^([0-9]{1,3}\\.){2}([0-9*]{1,3}\\.)[0-9*]{1,3}\$/", trim($value[0]))) {
            $DATA["mode"] = $mode;
            $ConfigIP["target"] = "ip";
            $ConfigIP["value"] = trim($value[0]);
            $DATA["configuration"] = $ConfigIP;
            $DATA["notes"] = "Added From Fusion APi";
            $POST = json_encode($DATA);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/" . $config["cloudflarezoneid"] . "/firewall/access_rules/rules");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = ["Content-Type:application/json", "X-Auth-Key:" . $config["cloudflareapikey"], "X-Auth-Email:" . $config["cloudflareemail"]];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $server_output = curl_exec($ch);
            curl_close($ch);
        } else {
            echo "error:" . $LNG["wrongip"];
            exit;
        }
    }
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    echo "error:" . $LNG["field"] . " " . $LNG["required"];
}

?>