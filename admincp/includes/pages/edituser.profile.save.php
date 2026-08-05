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
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
include_once ROOTDIR . "/includes/mail.fun.php";
include_once ROOTDIR . "/includes/invoice.fun.php";
dquery("delete from tbl_user_gateway where userid='" . $id . "'");
if ($usecustomgateway) {
    foreach ($gateway as $g => $v) {
        dquery("INSERT INTO tbl_user_gateway (userid,payment) VALUES  ('" . $id . "','" . $g . "')");
    }
}
$email = trim($email);
$cg = mysqli_fetch_assoc(dquery("select client_group,default_currency from tblUsers where id='" . $id . "'"));
if ($cg["client_group"] != $clientgroup) {
    dquery("DELETE from tbl_discount_imei where user_id='" . $id . "'");
    if ($clientgroup != "") {
        $data["client_group"] = $clientgroup;
        logActivityGlobal("Client group changed to : " . $clientgroup, "profile", $id, "admin");
    }
}
if ($_POST["recharge"]) {
    $recharge = 0;
} else {
    $recharge = 1;
}
if ($_POST["shopper"]) {
    $shopper = 1;
} else {
    $shopper = 0;
}
if ($_POST["verifiedm"]) {
    $verifiedm = 1;
} else {
    $verifiedm = 0;
}
if ($_POST["affiliate"]) {
    $affiliate = 1;
} else {
    $affiliate = 0;
}
if ($_POST["customize_email"]) {
    $customize_email = 1;
} else {
    $customize_email = 0;
}
if ($_POST["newsletter"]) {
    $newsletter = 1;
} else {
    $newsletter = 0;
}
if ($_POST["unsubscribe"]) {
    $unsubscribe = 1;
} else {
    $unsubscribe = 0;
}
if (isset($_POST["regular"])) {
    $data["guest"] = 0;
}
if ($usecustomgateway) {
    $data["customgateway"] = 1;
} else {
    $data["customgateway"] = 0;
}
$data["minaddfund"] = $minaddfund;
$data["maxaddfund"] = $maxaddfund;
$data["imei_service_access"] = $imeiservices;
$data["file_service_access"] = $fileservices;
$data["server_log_access"] = $serverservices;
$data["alow_remoteservices"] = $remoteservices;
if ($paypalaccount) {
    $paypalaccount = trim($paypalaccount);
    $paypalaccount = explode("\n", $paypalaccount);
    $newarr = [];
    foreach ($paypalaccount as $emas) {
        if (trim($emas)) {
            $newarr[] = $emas;
        }
    }
    $data["paypalaccount"] = json_encode($newarr);
} else {
    $data["paypalaccount"] = "";
}
if ($mobile) {
    if ($remove == 1) {
        $ids = explode("-", $id);
        foreach ($ids as $i) {
            dquery("delete from tblUsers where id='" . $i . "'");
            echo "success: Account removed successfully";
        }
    } else {
        if ($alls) {
            $id = str_replace("-", ",", $id);
            $data["userstatus"] = 0;
            if ($db->update("tblUsers", $data, "id IN (" . $id . ")")) {
                echo "success:" . $LNG["datasavesuccessfully"];
            } else {
                echo "error:" . $LNG["datanotsave"];
            }
        } else {
            if ($password) {
                $data["password"] = md5(md5($password) . $passenc);
                $data["lastpassreset"] = time();
            } else {
                $data["userstatus"] = $status;
                if ($status == 2) {
                    $data["inact"] = 1;
                }
            }
            if ($db->update("tblUsers", $data, "id='" . $id . "'")) {
                echo "success:" . $LNG["datasavesuccessfully"];
            } else {
                echo "error:" . $LNG["datanotsave"];
            }
        }
    }
} else {
    if ($short) {
        $data["credit_transfer"] = $allowtransfer;
        $data["transferfee"] = $transferfee;
        $data["notdiscounteduser"] = $notdiscounteduser;
        $data["fraud_protection"] = $fraud_protection;
        $data["affiliate"] = $affiliate;
        $data["ordersms"] = $ordersms;
        if ($db->update("tblUsers", $data, "id='" . $id . "'")) {
            echo "success:" . $LNG["datasavesuccessfully"];
        } else {
            echo "error:" . $LNG["datanotsave"];
        }
    } else {
        if ($username) {
            $data["username"] = $username;
            $data["first_name"] = $firstname;
            $data["last_name"] = $lastname;
            $data["verified"] = $verifiedm;
            if ($password) {
                $data["password"] = md5(md5($password) . $passenc);
                $data["lastpassreset"] = time();
                if ($config["smsgateway"] && $verified) {
                    sendSMS($phonenumber, 2, "", ["PASSWORD" => "*HIDDEN*"], $id);
                }
            }
            $email1 = mysqli_fetch_assoc(dquery("SELECT email FROM `tblUsers`\n     WHERE `username`='" . $username . "'"));
            if ($email != $email1["email"]) {
                $row = mysqli_num_rows(dquery("SELECT `id` FROM `tblUsers`\n         WHERE `email`='" . $email . "'"));
            }
            if ($row) {
                echo "error:" . $LNG["email"] . " " . $LNG["notavailable"];
                exit;
            }
            $data["email"] = $email;
            $data["usertype"] = $type;
            if ($type == 0) {
                dquery("UPDATE tblUsers set sell_credit_limit=''  where id='" . $id . "'");
            }
            $data["userstatus"] = $status;
            if ($status != "2") {
                $data["is_registered"] = "1";
            } else {
                $data["inact"] = 1;
            }
            if ($status == 1) {
                $data["canactive"] = 0;
            }
            $data["credit_transfer"] = $allowtransfer;
            $data["transferfee"] = $transferfee;
            $data["notdiscounteduser"] = $notdiscounteduser;
            if ($imeiaccess) {
                $data["imei_service_access"] = $imeiaccess;
            }
            if ($fileaccess) {
                $data["file_service_access"] = $fileaccess;
            }
            if ($serveraccess) {
                $data["server_log_access"] = $serveraccess;
            }
            $data["shop_service_access"] = $shopaccess;
            if ($currency) {
                $data["default_currency"] = $currency;
            }
            $data["company"] = $company;
            $data["fraud_protection"] = $fraud_protection;
            $data["address"] = $address;
            $data["customize_email"] = $customize_email;
            $data["address2"] = $address2;
            $data["state"] = $state;
            $data["city"] = $city;
            $data["zip"] = $zip;
            $data["affiliate"] = $affiliate;
            $data["block_reason"] = $block_reason;
            $data["rechargeblock"] = $recharge;
            $data["country"] = $country;
            $data["phonenumber"] = $phonenumber;
            $data["default_theme"] = $template;
            $data["language"] = $language;
            $data["news_letter"] = $newsletter;
            $data["unsubscribe"] = $unsubscribe;
            $data["idverification"] = $idverification;
            $data["otpfordirect"] = $otpfordirect;
            $data["reseller_can_setupstore"] = $shopper;
            if (!$shopper) {
                dquery("DELETE FROM tbl_store_config WHERE uid='" . $id . "'");
                dquery("DELETE FROM tbl_store_pages WHERE uid='" . $id . "'");
                dquery("DELETE FROM tbl_reseller_price WHERE supplier='" . $id . "'");
            }
            if ($paymentgatway) {
                $paymentgatways = implode(",", $paymentgatway);
            }
            $data["auto_recharge"] = $paymentgatways;
            $cd = mysqli_fetch_assoc(dquery("select * from tblUsers where id='" . $id . "'"));
            if ($db->update("tblUsers", $data, "id='" . $id . "'")) {
                foreach ($cd as $ck => $cv) {
                    if ($cv != $data[$ck] && $data[$ck]) {
                        $bff .= $ck . ":" . $cv . "\n";
                    }
                }
                if ($reply["status"] == "success") {
                    if (!is_dir("../../images/avtar/")) {
                        mkdir("../../images/avtar/");
                    }
                    $ifp = fopen("../../images/avtar/" . $id . "_avtar.jpg", "wb");
                    fwrite($ifp, base64_decode($reply["data"]));
                    fclose($ifp);
                }
                logActivityGlobal("Client Profile updated \n\n " . $bff, "profile", $id, "admin");
                saveCustomFields($id, $customfield);
                echo "success:" . $LNG["datasavesuccessfully"];
            } else {
                echo "error:" . $LNG["datanotsave"];
            }
        } else {
            echo "error:" . $LNG["username"] . " " . $LNG["required"];
        }
    }
}

?>