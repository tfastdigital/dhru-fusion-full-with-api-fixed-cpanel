<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "comm.php";
$item = preg_replace("/[^0-9a-zA-Z]/i", "", $item);
$imei = preg_replace("/[^0-9]/i", "", $imei);
echo "<body style=\"background: #ccc;text-align: center;font-family:arial\">    \n    <form id=\"tracker2\" name=\"track2\" method=\"post\" style=\"margin:200px auto 0;width:500px\">\n      ";
if ($config["logo_link"]) {
    echo "<img src='" . $config["logo_link"] . "'>";
} else {
    echo "<h1>" . $config["companyname"] . "</h1>";
}
echo " \n      <br />             \n      <input type=\"text\"  value=\"Enter IMEI Number\" onfocus=\"if(this.value=='Enter IMEI Number') this.value=''\" onblur=\"if(this.value=='') this.value='Enter IMEI Number'\"  name=\"imei\" style=\"padding: 10px;width:300px;font-size:20px;\"/>\n      <input type=\"submit\" value=\"View Status\" name=\"view\" style=\"padding: 8px 15px;font-size:20px;\"/>  \n  \n    <br /><br /><br />\n    ";
if (isset($view)) {
    if ($imei != "" && is_numeric($imei) && 15 <= strlen($imei)) {
        $sql = dquery("select order_id,imei,reply,user_can_c from tbl_order_imei where imei='" . $imei . "'");
        if (mysqli_num_rows($sql)) {
            $data = mysqli_fetch_assoc($sql);
            if ($data["user_can_c"] == 0) {
                $buf = "New";
            } else {
                if ($data["user_can_c"] == 1) {
                    $buf = "In Process";
                } else {
                    if ($data["user_can_c"] == 3) {
                        $buf = "Rejected";
                        $tempalte_ver["reply"] = $data["reply"];
                    } else {
                        if ($data["user_can_c"] == 4) {
                            $buf = "Replied";
                            $tempalte_ver["reply"] = $data["reply"];
                        } else {
                            if ($data["user_can_c"] == 5) {
                                $buf = "Unpaid";
                            }
                        }
                    }
                }
            }
            echo "<div style='background:#888;padding:10px 0;margin:auto;color:white'>Your IMEI : " . $imei . " <br/><br/> Status : " . $buf . " <br/><br/> Code : " . $data["reply"] . " </div>";
        } else {
            echo "<div style='background:#888;padding:10px 0;margin:auto;color:white'>Invalid IMEI</div>";
        }
    } else {
        echo "<div style='background:#888;padding:10px 0;margin:auto;color:white'>Invalid IMEI</div>";
    }
}
echo "      </form>\n</body>\n    \n    ";
class no
{
}

?>