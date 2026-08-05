<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require_once "../comm.php";
require_once "fun.inc.php";
require_once "client.area.inc.php";
require_once "customfield.fun.inc.php";
require_once "clients.fun.inc.php";
$servicetype = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $servicetype);
$action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
$serviceid = preg_replace("/[^0-9]/i", "", $serviceid);
$bycheckbox = preg_replace("/[^a-z]/i", "", $bycheckbox);
$addremove = preg_replace("/[^a-z]/i", "", $addremove);
$quick = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $quick);
if ($action == "signup") {
    $email = preg_replace("/[^a-z0-9\\-a-zA-Z\\.@]/i", "", $email);
    $name = preg_replace("/[^a-zA-Z0-9]/i", "", $name);
    if (!preg_match("/^([a-zA-Z0-9])+([\\.a-zA-Z0-9+_-])*@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)*\\.([a-zA-Z]{2,6})\$/", $email)) {
        echo "error:" . $lng_languag["clientareaerroremailinvalid"];
    } else {
        if ($name != "") {
            $sql = dquery("select id,pid from tbl_newsletter where \r\n            `email`='" . $email . "'");
            if (!mysqli_num_rows($sql)) {
                $pid = mysqli_fetch_assoc(dquery("select id from tbl_products \r\n                where md5(id)='" . $id . "'"));
                $data["email"] = $email;
                $data["IP"] = $remote_ip;
                $data["active"] = 1;
                $data["name"] = $name;
                $data["time"] = time();
                $data["pid"] = $pid["id"];
                $db->insert("tbl_newsletter", $data);
                $data = NULL;
            } else {
                $sql = mysqli_fetch_assoc($sql);
                $pid = mysqli_fetch_assoc(dquery("select id from tbl_products \r\n                where md5(id)='" . $id . "'"));
                $arr = explode(",", $sql["pid"]);
                if (!in_array($pid["id"], $arr)) {
                    $data["pid"] = trim($sql["pid"] . "," . $pid["id"], ",");
                    $db->update("tbl_newsletter", $data, "id=" . $sql["id"]);
                    $data = NULL;
                }
            }
            echo "success:" . $lng_languag["subscriptionsuccess"];
        } else {
            echo "error:" . $lng_languag["filefield"];
        }
    }
}
if ($action == "compare") {
    if ($serviceid) {
        $sql = mysqli_fetch_assoc(dquery("select service_name from tbl_products \r\n    where id='" . $serviceid . "'"));
        if ($bycheckbox) {
            if ($_SESSION["COMPARE"][$serviceid]) {
                unset($_SESSION["COMPARE"][$serviceid]);
            } else {
                $_SESSION["COMPARE"][$serviceid] = $serviceid;
            }
        } else {
            $_SESSION["COMPARE"][$serviceid] = $serviceid;
        }
    }
    echo count($_SESSION["COMPARE"]);
    exit;
}
if ($servicetype == "imei" || $servicetype == "server") {
    require_once "imeiservices.fun.php";
    $serviceDetails = getIMEIServices("", $id, "", "", "", "", true);
    if ($serviceDetails["acceptterms"] && !$accept) {
        echo "error: " . $lng_languag["agreewithterms"];
        exit;
    }
    if ($imei_custom && stripos($imei_custom, "\n") !== false) {
        echo "error: You cant buy more than one in retail";
        exit;
    }
    if ($serviceDetails["stock_allow"] && $serviceDetails["stock"] <= 0) {
        $error = "error:" . $lng_languag["outofstock"];
    }
    if (!$error) {
        $serviceDetails["reqredfield"]["customimeiname"] = $serviceDetails["imei_custom_name"];
        $error = placeOrderIMEIvalidation($serviceDetails["reqredfield"], false, "", $serviceDetails);
    }
    if ($error) {
        echo $error;
        exit;
    }
    if ($emptycart) {
        unset($_SESSION["CART"]);
        unset($_SESSION["CARTPROMOTION"]);
    }
    if (addtocart("imei")) {
        if ($skipviewcart) {
            $ste_addr = str_replace("http://", "", $config["site_address"]);
            $ste_addr = str_replace("https://", "", $ste_addr);
            echo "redirectto:" . $ste_addr . "/cart.php?action=checkout";
        } else {
            echo "success_addedcart: " . $lng_languag["itemaddedcart"];
        }
    }
} else {
    if ($servicetype == "server") {
        require_once "imeiservices.fun.php";
        global $customfield;
        global $lng_languag;
        $serviceDetails = getIMEIServices("", $id, "", "", "", "", true);
        if ($serviceDetails["stock_allow"] && $serviceDetails["stock"] <= 0) {
            $error = $lng_languag["outofstock"];
        }
        if (!function_exists(checkCustomFields)) {
            require_once "customfield.fun.inc.php";
        }
        if (!$error) {
            $error = checkCustomFields($customfield);
        }
        if ($error) {
            echo "error: " . $error;
            exit;
        }
        if (addtocart("server")) {
            echo "success_addedcart: " . $lng_languag["itemaddedcart"];
        }
    } else {
        if ($servicetype == "remote") {
            require_once "serverservices.fun.php";
            global $customfield;
            global $lng_languag;
            $serviceDetails = getServerServices("", $id, "", "", "", "", true);
            if ($serviceDetails["stock_allow"] && $serviceDetails["stock"] <= 0) {
                $error = $lng_languag["outofstock"];
            }
            if (!function_exists(checkCustomFields)) {
                require_once "customfield.fun.inc.php";
            }
            if (!$error) {
                $error = checkCustomFields($customfield);
            }
            if ($error) {
                echo "error: " . $error;
                exit;
            }
            if (addtocart("server")) {
                echo "success_addedcart: " . $lng_languag["itemaddedcart"];
            }
        } else {
            if ($servicetype == "product" && $action != "signup") {
                require_once "products.fun.php";
                global $customfield;
                global $lng_languag;
                global $price;
                global $skipviewcart;
                $serviceDetails = getProducts("", $id, "", "", "", "", "", "", "", "", "", "", "", "", "", $quantity, "", "", "", "", "I");
                if ($serviceDetails["stock_allow"] && $serviceDetails["stock"] <= 0) {
                    $error = "error:" . $lng_languag["outofstock"];
                }
                if (!$error) {
                    $error = placeOrderProductvalidation($serviceDetails["reqredfield"], false);
                }
                if (!$error && $serviceDetails["credit"] == 0 && $serviceDetails["zeropriceaction"] == 3 && ($price <= 0 || !is_numeric($price))) {
                    $error = "error: Please Enter Price";
                }
                if ($error) {
                    echo $error;
                    exit;
                }
                if ($bycheckbox && $addremove == "false") {
                    unset($_SESSION["CART"]["p_" . $serviceDetails["id"]]);
                    exit;
                }
                if (addtocart("product")) {
                    if ($quick) {
                        $bufs = " <a target='_parent' href='cart.php?service=product&group=" . $serviceDetails["group_id"] . "&item=" . $quick . "'> Go to Product.</a>";
                    }
                    if ($skipviewcart) {
                        $ste_addr = str_replace("http://", "", $config["site_address"]);
                        $ste_addr = str_replace("https://", "", $ste_addr);
                        echo "redirectto:" . $ste_addr . "/cart.php?action=checkout";
                    } else {
                        echo "success_addedcart: " . $lng_languag["itemaddedcart"] . ". " . $bufs;
                    }
                }
            }
        }
    }
}
function addtocart($types)
{
    if ($types == "imei") {
        global $config;
        global $db;
        global $model_id;
        global $provider_id;
        global $network_id;
        global $mep;
        global $PIN;
        global $KBH;
        global $PRD;
        global $Type;
        global $Reference;
        global $Locks;
        global $country;
        global $notes;
        global $comments;
        global $serviceDetails;
        global $imei1;
        global $imei_custom;
        global $imei2;
        global $customfield;
        global $qnt;
        $tmpid = rand(99, 99999);
        $_SESSION["CART"][$tmpid]["qnt"] = 0 < $qnt ? $qnt : 1;
        $_SESSION["CART"][$tmpid]["name"] = $serviceDetails["service_name"] . ($serviceDetails["sku"] ? " #" . $serviceDetails["sku"] : "");
        $_SESSION["CART"][$tmpid]["id"] = $serviceDetails["id"];
        $_SESSION["CART"][$tmpid]["type"] = "imei";
        if ($imei1) {
            $_SESSION["CART"][$tmpid]["orderdetail"]["imei"] = $imei1 . $imei2;
        } else {
            foreach ($imei_custom as $so) {
                $_SESSION["CART"][$tmpid]["orderdetail"]["imei"] = $so;
            }
        }
        $_SESSION["CART"][$tmpid]["orderdetail"]["model_id"] = $model_id;
        $_SESSION["CART"][$tmpid]["orderdetail"]["provider_id"] = $provider_id;
        $_SESSION["CART"][$tmpid]["orderdetail"]["provider_c_id"] = $country;
        $_SESSION["CART"][$tmpid]["orderdetail"]["network_id"] = $network_id;
        $_SESSION["CART"][$tmpid]["orderdetail"]["mep"] = $mep;
        $_SESSION["CART"][$tmpid]["orderdetail"]["KBH"] = $KBH;
        $_SESSION["CART"][$tmpid]["orderdetail"]["PIN"] = $PIN;
        $_SESSION["CART"][$tmpid]["orderdetail"]["PRD"] = $PRD;
        $_SESSION["CART"][$tmpid]["orderdetail"]["Type"] = $Type;
        $_SESSION["CART"][$tmpid]["orderdetail"]["Reference"] = $Reference;
        $_SESSION["CART"][$tmpid]["orderdetail"]["note"] = $notes;
        $_SESSION["CART"][$tmpid]["orderdetail"]["comments"] = $comments;
        $_SESSION["CART"][$tmpid]["orderdetail"]["thumb"] = $serviceDetails["thumb"];
        if ($Locks) {
            foreach ($Locks as $L) {
                $T .= "," . $L;
            }
            $_SESSION["CART"][$tmpid]["orderdetail"]["Locks"] = $T;
        }
        $_SESSION["CART"][$tmpid]["orderdetail"]["credit"] = $serviceDetails["credit"];
        $_SESSION["CART"][$tmpid]["orderdetail"]["image_link"] = $serviceDetails["image_link"];
        $_SESSION["CART"][$tmpid]["orderdetail"]["discount"] = $serviceDetails["discount"];
        $_SESSION["CART"][$tmpid]["orderdetail"]["fprice"] = $serviceDetails["credit"] - $serviceDetails["discount"];
        $_SESSION["CART"][$tmpid]["orderdetail"]["purchase_cost"] = $serviceDetails["purchase_cost"];
        $_SESSION["CART"][$tmpid]["orderdetail"]["customfield"] = $customfield;
        return true;
    } else {
        if ($types == "server") {
            global $config;
            global $db;
            global $notes;
            global $comments;
            global $serviceDetails;
            global $customfield;
            $tmpid = rand(99, 99999);
            $_SESSION["CART"][$tmpid]["qnt"] = 1;
            $_SESSION["CART"][$tmpid]["name"] = $serviceDetails["service_name"];
            $_SESSION["CART"][$tmpid]["id"] = $serviceDetails["id"];
            $_SESSION["CART"][$tmpid]["type"] = "server";
            $_SESSION["CART"][$tmpid]["orderdetail"]["note"] = $notes;
            $_SESSION["CART"][$tmpid]["orderdetail"]["comments"] = $comments;
            $_SESSION["CART"][$tmpid]["orderdetail"]["credit"] = $serviceDetails["credit"];
            $_SESSION["CART"][$tmpid]["orderdetail"]["discount"] = $serviceDetails["discount"];
            $_SESSION["CART"][$tmpid]["orderdetail"]["fprice"] = $serviceDetails["credit"] - $serviceDetails["discount"];
            $_SESSION["CART"][$tmpid]["orderdetail"]["image_link"] = $serviceDetails["image_link"];
            $_SESSION["CART"][$tmpid]["orderdetail"]["purchase_cost"] = $serviceDetails["purchase_cost"];
            $_SESSION["CART"][$tmpid]["orderdetail"]["customfield"] = $customfield;
            $_SESSION["CART"][$tmpid]["orderdetail"]["thumb"] = $serviceDetails["thumb"];
            return true;
        }
        if ($types == "product") {
            global $config;
            global $db;
            global $notes;
            global $comments;
            global $serviceDetails;
            global $customfield;
            global $quantity;
            global $price;
            $tmpid = "p_" . $serviceDetails["id"];
            if ($_SESSION["CART"][$tmpid]) {
                if ($_SESSION["CART"][$tmpid]["orderdetail"]["customfield"] == $customfield) {
                    $_SESSION["CART"][$tmpid]["qnt"]++;
                } else {
                    $flag = false;
                    $int = 0;
                    for ($i = 1; $i < 20; $i++) {
                        $_tmpid = "p" . $i . "_" . $serviceDetails["id"];
                        if (is_array($_SESSION["CART"][$_tmpid])) {
                            $__tmpid = "p" . $i . "_" . $serviceDetails["id"];
                            if ($_SESSION["CART"][$__tmpid]["orderdetail"]["customfield"] == $customfield) {
                                $tmpid = "p" . $i . "_" . $serviceDetails["id"];
                                $_SESSION["CART"][$tmpid]["qnt"]++;
                                $flag = true;
                            }
                            $int++;
                        }
                    }
                    if (!$flag) {
                        $int++;
                        $tmpid = "p" . $int . "_" . $serviceDetails["id"];
                        $_SESSION["CART"][$tmpid]["qnt"] = 1;
                    }
                }
            } else {
                $_SESSION["CART"][$tmpid]["qnt"] = 1;
            }
            if ($quantity && is_numeric($quantity)) {
                $_SESSION["CART"][$tmpid]["qnt"] = $quantity;
            }
            $_SESSION["CART"][$tmpid]["name"] = $serviceDetails["service_name"] . ($serviceDetails["sku"] ? " #" . $serviceDetails["sku"] : "");
            $_SESSION["CART"][$tmpid]["id"] = $serviceDetails["id"];
            $_SESSION["CART"][$tmpid]["mdid"] = md5($serviceDetails["id"]);
            $_SESSION["CART"][$tmpid]["type"] = "product";
            $_SESSION["CART"][$tmpid]["gid"] = $serviceDetails["group_id"];
            $_SESSION["CART"][$tmpid]["orderdetail"]["note"] = $notes;
            $_SESSION["CART"][$tmpid]["orderdetail"]["comments"] = $comments;
            if ($serviceDetails["credit"] == 0 && $serviceDetails["zeropriceaction"] == 3) {
                $_SESSION["CART"][$tmpid]["orderdetail"]["price"] = $price;
            }
            $_SESSION["CART"][$tmpid]["orderdetail"]["credit"] = $serviceDetails["credit"];
            $_SESSION["CART"][$tmpid]["orderdetail"]["discount"] = $serviceDetails["discount"];
            $_SESSION["CART"][$tmpid]["orderdetail"]["fprice"] = $serviceDetails["credit"] - $serviceDetails["discount"];
            $_SESSION["CART"][$tmpid]["orderdetail"]["purchase_cost"] = $serviceDetails["purchase_cost"];
            $_SESSION["CART"][$tmpid]["orderdetail"]["customfield"] = $customfield;
            $_SESSION["CART"][$tmpid]["orderdetail"]["thumb"] = $serviceDetails["thumb"];
            return true;
        }
    }
}

?>