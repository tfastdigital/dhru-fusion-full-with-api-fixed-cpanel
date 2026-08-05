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
require_once "../../comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/customfield.fun.inc.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
global $token;
$check = generate_token("plain");
if ($token != $check) {
}
if ($action == "verifymyphone") {
    if ($otp) {
        if ($otp == $_SESSION["otptoverify"]) {
            $_SESSION["finalphone"] = $_SESSION["phonetoverify"];
            echo "success: Phone verified. Complete your registration::#verifyotp,#otpcounter,.hideotprelate";
        } else {
            echo "error: Wrong OTP";
        }
    } else {
        echo "error: OTP Required";
    }
    exit;
}
if ($action == "verifyphone") {
    if ($phonenumber && $phonenumber1) {
        require_once ROOTDIR . "/" . $admindirpath . "/" . "includes/gallery.comm.php";
        require_once ROOTDIR . "/" . $admindirpath . "/" . "includes/fun.inc.php";
        $licinfo = licince\mainChd19k521("", "", "", 1);
        $_SESSION["otptoverify"] = rand(1000, 9999);
        $otp = $_SESSION["otptoverify"];
        $POST["json"] = true;
        $POST["licensekey"] = $licinfo["licensekey"];
        $POST["otp"] = $otp;
        $POST["coname"] = utf8_encode($config["companyname"]);
        $POST["channel"] = $verifyby;
        $POST["accesskey"] = md5($licinfo["licensekey"] . "369");
        $POST["to"] = "+" . $phonenumber1 . $phonenumber;
        $url = "https://cp.dhru.com/submit/verifylicense";
        $Result = initCurl($url, $POST);
        SMSCreditLog($Result, $phonenumber1 . $phonenumber);
        $res = json_decode($Result, true);
        if ($res["status"] == "success") {
            $_SESSION["phonetoverify"] = $phonenumber1 . $phonenumber;
            echo "showdiv:#verifyotp:Enter OTP to verify your phone number:.phoness";
        } else {
            echo "error: Unable to send OTP check phone number or contact support::#otpcounter";
        }
    } else {
        echo "error: Phone and Country code required::#otpcounter";
    }
    exit;
}
if ($action == "newsletter") {
    if ($email && $captcha) {
        if (md5($captcha) != $_SESSION["varify"]) {
            echo "error:Wrong Captcha";
            $_SESSION["varify"] = rand(333, 8888);
            exit;
        }
        if (!preg_match("/^([a-zA-Z0-9])+([\\.a-zA-Z0-9+_-])*@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)*\\.([a-zA-Z]{2,6})\$/", $email)) {
            echo "error:" . $lng_languag["clientareaerroremailinvalid"];
        } else {
            $sql = dquery("select id from tbl_newsletter where `email`='" . $email . "'");
            if (!mysqli_num_rows($sql)) {
                $data = NULL;
                $data["email"] = $email;
                $data["IP"] = $remote_ip;
                $data["active"] = 0;
                $data["time"] = time();
                $nic = $db->insert("tbl_newsletter", $data);
                $data = NULL;
                require_once ROOTDIR . "/includes/mail.fun.php";
                $link = _url("newsletter/va/" . md5($nic), true);
                $email_merge_fields["link"] = $link;
                $toemails[]["to"] = $email;
                sendMail(79, "", "", $email_merge_fields, "", "", "", "", $toemails);
            }
            echo "success:" . $lng_languag["subscriptionsuccess"] . " " . $lng_languag["please"] . " " . $lng_languag["check"] . " " . $lng_languag["your"] . " " . $lng_languag["email"];
        }
    } else {
        echo "error: Required field should not blank";
    }
    exit;
}
if ($validateregistration) {
    $validator = [];
    global $lng_languag;
    global $username;
    global $password;
    global $confirmation;
    global $email;
    global $contact;
    global $first_name;
    global $last_name;
    global $address1;
    global $address2;
    global $city;
    global $state;
    global $zip;
    global $country;
    global $currency;
    global $retail;
    global $question;
    global $answer;
    global $phonenumber;
    global $phonenumber1;
    global $guestcheck;
    global $remote_ip;
    global $language;
    $validator["username"] = ["", false];
    $validator["email"] = ["", false];
    $validator["first_name"] = ["", false];
    $validator["last_name"] = ["", false];
    $validator["address1"] = ["", false];
    $validator["address2"] = ["", false];
    $validator["city"] = ["", false];
    $validator["state"] = ["", false];
    $validator["zip"] = ["", false];
    $validator["country"] = ["", false];
    $validator["phonenumber"] = ["", false];
    $validator["password"] = ["", false];
    $validator["confirmation"] = ["", false];
    $validator["language"] = ["", false];
    $validator["currency"] = ["", false];
    if ($step == 1) {
        $validator["email"] = [$email, true];
        if ($username) {
            $validator["username"] = [$username, true];
        } else {
            if ($email) {
                $validator["email"] = [$email, true];
                $u = explode("@", $email);
            }
            if ($email) {
                $validator["username"] = [$u[0], true];
                $username = $validator["username"][0];
            }
        }
        if ($email && mysqli_num_rows(dquery("select * from tblUsers where email='" . $email . "'"))) {
            echo "error: Email already exists";
            exit;
        }
        if ($username && mysqli_num_rows(dquery("select * from tblUsers where username='" . $username . "'"))) {
            echo "error: Username already exists";
            exit;
        }
        $validator["password"] = [$password, true];
        $validator["confirmation"] = [$confirmation, true];
        $validator["language"] = [$language, false];
        $validator["currency"] = [$_POST["currency"], true];
    } else {
        if ($step == 2) {
            $validator["first_name"] = [$first_name, true];
            $validator["last_name"] = [$last_name, true];
            if (!$config["minregistration"]) {
                $validator["address1"] = [$address1, true];
                $validator["address2"] = [$address2, false];
                $validator["city"] = [$city, true];
                $validator["state"] = [$state, true];
                $validator["zip"] = [$zip, true];
                $validator["country"] = [$country, true];
            }
        } else {
            if ($step == 3) {
                if (!$phonenumber) {
                    $phonenumber1 = "";
                }
                if ($config["phonerequired"] || $config["mobile_verification"]) {
                    $validator["phonenumber"] = [$phonenumber1 . $phonenumber, true];
                } else {
                    $validator["phonenumber"] = [$phonenumber1 . $phonenumber, false];
                }
            }
        }
    }
    if ($error = validateProfiles($validator)) {
        echo "error:" . $error;
    } else {
        echo "";
    }
    exit;
}
if ($email && !$username) {
    $u = explode("@", $email);
    $validator["username"] = [$u[0], true];
    $username = $validator["username"][0];
}
if ($username) {
    foreach ($_SESSION["CART"] as $key => $_subtotal) {
        if ($_subtotal["type"] == "product") {
            unset($config["minregistration"]);
        }
    }
    global $lng_languag;
    global $username;
    global $password;
    global $confirmation;
    global $email;
    global $contact;
    global $first_name;
    global $last_name;
    global $address1;
    global $address2;
    global $city;
    global $state;
    global $zip;
    global $country;
    global $currency;
    global $retail;
    global $question;
    global $answer;
    global $phonenumber;
    global $phonenumber1;
    global $guestcheck;
    global $remote_ip;
}
if (!$storeowner["id"] && !$config["minregistration"] && !mysqli_num_rows(dquery("select id from \n    tbl_currencies where id='" . $currency . "'")) && $currency) {
    echo "error: Something Wrong #4586";
    exit;
}
if (isset($_SESSION["finalphone"])) {
    $phonenumber = $_SESSION["finalphone"];
}
if ($type == 2 || $type == 3 || $config["minregistration"]) {
    global $email;
    global $password;
    global $confirmation;
    global $first_name;
    global $last_name;
    global $captcha;
    global $remote_ip;
    global $phonenumber;
    global $phonenumber1;
    global $country;
    $validator["email"] = [$email, true];
    $u = explode("@", $email);
    if ($email) {
        $validator["username"] = [$u[0], true];
    }
    if ($type == 3) {
        $validator["password"] = [$password, true];
        $validator["confirmation"] = [$confirmation, true];
        $validator["first_name"] = [$first_name, true];
        $validator["last_name"] = [$last_name, true];
        global $address1;
        global $address2;
        global $city;
        global $state;
        global $zip;
        global $country;
        $validator["address1"] = [$address1, true];
        $validator["address2"] = [$address2, false];
        $validator["city"] = [$city, true];
        $validator["state"] = [$state, true];
        $validator["zip"] = [$zip, true];
        $validator["country"] = [$country, true];
    } else {
        if ($password) {
            $validator["password"] = [$password, true];
            $validator["confirmation"] = [$confirmation, true];
        }
        if ($first_name) {
            $validator["first_name"] = [$first_name, true];
        }
        if ($last_name) {
            $validator["last_name"] = [$last_name, true];
        }
    }
    $validator["country"] = [$country, true];
    if (!$phonenumber) {
        $phonenumber1 = "";
    }
    $validator["phonenumber"] = [$phonenumber1 . $phonenumber, true];
    if ($config["captcha_registration"]) {
        $validator["captcha"] = [$captcha, true];
    }
    $validator["currency"] = [$config["registration_currency"], true];
    if ($error = validateProfiles($validator)) {
        echo "error:" . $error;
        exit;
    }
    if ($error = addNewUser($validator, true, "", true)) {
        echo "error: " . $error;
        exit;
    }
    if ($config["slack_newusersignup"]) {
        $_cols[0]["titel"] = $email;
        $_cols[0]["text"] = $u[0];
        $_cols[1]["titel"] = $first_name . " " . $last_name;
        $_cols[1]["text"] = $country;
        $_cols[2]["titel"] = $phonenumber;
        $_cols[2]["text"] = $remote_ip;
        SlackSendMsg($config["slack_newusersignup"], "New User Registered", "good", $_cols, true);
    }
    echo "success: " . $lng_languag["checkmail"] . " <br/> " . $lng_languag["wesentmail"] . " " . $email . "<br/> " . $lng_languag["clicktoresetpassword"] . " <br/> " . $lng_languag["ifudontseemail"];
    exit;
}
$validator = NULL;
$validator["username"] = [$username, true];
$validator["password"] = [$password, true];
$validator["confirmation"] = [$confirmation, true];
$validator["email"] = [$email, true];
if ($config["phonerequired"]) {
    $validator["phonenumber"] = [$phonenumber1 . $phonenumber, true];
} else {
    $validator["phonenumber"] = [$phonenumber1 . $phonenumber, false];
}
$validator["first_name"] = [$first_name, true];
$validator["last_name"] = [$last_name, true];
$validator["address1"] = [$address1, true];
$validator["address2"] = [$address2, false];
$validator["city"] = [$city, true];
$validator["state"] = [$state, true];
$validator["zip"] = [$zip, true];
$validator["country"] = [$country, true];
$validator["language"] = [$language, false];
$validator["currency"] = [$_POST["currency"], true];
$validator["question"] = [$question, true];
$validator["answer"] = [$answer, true];
$validator["newsletter"] = [$newsletter, true];
if ($guestcheck) {
    $validator["guest"] = [true, true];
}
if ($config["registration_terms"]) {
    $validator["terms"] = [$terms, true];
}
if ($config["captcha_registration"]) {
    $validator["captcha"] = [$captcha, true];
}
if ($error = validateProfiles($validator)) {
    echo "error: " . $error;
    exit;
}
if ($error = addNewUser($validator)) {
    echo "error: " . $error;
    exit;
}
if ($config["slack_newusersignup"]) {
    $_cols[0]["titel"] = $email;
    $_cols[0]["text"] = $username;
    $_cols[1]["titel"] = $first_name . " " . $last_name;
    $_cols[1]["text"] = $country;
    $_cols[2]["titel"] = $phonenumber;
    $_cols[2]["text"] = $remote_ip;
    SlackSendMsg($config["slack_newusersignup"], "New User Registered", "good", $_cols, true);
}
if ($config["registration_type"] == 2) {
    echo "success: " . $lng_languag["regsuccess"] . "<br/>" . $lng_languag["checkmailforlogin"];
} else {
    echo "success: " . $lng_languag["regmanual"];
}

?>