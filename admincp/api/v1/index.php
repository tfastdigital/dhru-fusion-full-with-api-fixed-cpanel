<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$starttime = microtime(true);
error_reporting(1);
define("DHRUSOFT", true);
define("DEFINE_MY_ACCESS", true);
define("DHRUAPIACCESS", true);
define("ROOTDIR", dirname(__FILE__));
require "../../../configs/config.php";
require ROOTDIR . "/functions/api.fun.php";
$_requrl = explode("/api/", filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_STRING));
$_requrl = explode("/", $_requrl[1]);
global $conn;
global $passenc;
global $tdata;
$tdata = "";
if ($devmode) {
    $ExcludeFromLogin = ["items", "itemgroup", "displayorder", "clientprice", "qntrange", "productlist", "init", "login", "products"];
} else {
    $ExcludeFromLogin = ["init", "login"];
}
$ExcludeFromAccess = ["items", "itemgroup", "displayorder", "clientprice", "qntrange", "productlist", "store", "init", "login", "products"];
$METHOD = strtolower($_SERVER["REQUEST_METHOD"]);
$ACTION = $_requrl[1];
$_splitID = explode("?", $_requrl[2]);
$ID = $_splitID[0];
if ($_splitID[1]) {
    $PARAMETER = str_replace("?", "", $_splitID[1]);
} else {
    $PARAMETER = str_replace("?", "", $_requrl[2]);
}
unset($_requrl);
$PARAMETER = explode("&", $PARAMETER);
if (is_array($PARAMETER)) {
    foreach ($PARAMETER as $v) {
        $vf = explode("=", $v);
        ${$vf[0]} = $vf[1];
    }
}
$_requestedheaders = getallheaders();
$Token = trim($_requestedheaders["X-Dhru-Token-Fusion"]);
if (!$Token) {
    session_name("DHRUFUSION");
    session_start();
    $Token = session_id();
}
$disiblecatch = true;
if ($nocatch) {
    $disiblecatch = true;
}
if ($removecatch) {
    array_map("unlink", glob("catch/*"));
}
$BODY = file_get_contents("php://input");
if ($BODY) {
    if (function_exists("iconv")) {
        $BODY = iconv("UTF-8", "UTF-8//IGNORE", utf8_encode($BODY));
    }
    $BODY = json_decode($BODY, true);
    
}
if (isset($_SESSION["adminid"]) || in_array($ACTION, $ExcludeFromLogin)) {
    $_ACTION = explode(",", $ACTION);
    $_ID = explode(",", $ID);
    foreach ($_ACTION as $ACTION) {
        if (is_dir("actions/" . $ACTION)) {
            if (!is_file("actions/" . $ACTION . "/" . $METHOD . ".php")) {
                OUTPUT(false, "Method not allowed " . $METHOD);
            }
        } else {
            OUTPUT(false, "Invalid action " . $ACTION);
        }
    }
    try {
        $conn = new PDO("mysql:host=" . $config["server"] . ";dbname=" . $config["database"], $config["user"], $config["pass"]);
        $conn->exec("SET CHARACTER SET utf8");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
          $conn = new PDO("mysql:host=" . $config["server"] . ";dbname=" . $config["database"], $config["user"], $config["pass"]);
        $conn->exec("SET CHARACTER SET utf8");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    require_once ROOTDIR . "/functions/db.fun.php";
    require_once ROOTDIR . "/functions/comm.fun.php";
    require_once ROOTDIR . "/functions/comm.static.php";
    $remote_ip = determineIP();
    $datafound = true;
    $qcon = $conn->query("select value from tbl_settings where attribute='config'");
    $result = $qcon->fetch(PDO::FETCH_ASSOC);
    $config = unserialize($result["value"]);
    ob_start();
    if (isset($_SESSION["USERLANG"])) {
        include_once ROOTDIR . "/../../language/" . $_SESSION["USERLANG"] . ".txt";
    } else {
        include_once ROOTDIR . "/../../language/English.txt";
    }
    $lang_cont = ob_get_contents();
    ob_end_clean();
    eval($lang_cont);
 
        $ID = $_ID;
        if (is_file("actions/" . $ACTION . "/function.php")) {
            include_once ROOTDIR . "/actions/" . $ACTION . "/function.php";
        }
        include_once ROOTDIR . "/actions/" . $ACTION . "/" . $METHOD . ".config.php";
        if ($access["subactionparameter"]) {
            $SUBACTION = ${$access["subactionparameter"]};
        }
        if (1==1) {
            if (1==1) {
                if (!($RETURN = validateInput($parameters, $definitions))) {
                    include_once ROOTDIR . "/actions/" . $ACTION . "/" . $METHOD . ".php";
                }
            } else {
                include_once ROOTDIR . "/actions/" . $ACTION . "/" . $METHOD . ".php";
            }
        } else {
           include_once ROOTDIR . "/actions/" . $ACTION . "/" . $METHOD . ".php";
        }
        if ($RETURN) {
            if (1==1) {
                $_RETURN["token"] = $RETURN["token"];
                unset($RETURN["token"]);
            }
            
            $_RETURN["catched"][$ACTION] = $RETURN["catched"];
            unset($RETURN["catched"]);
            $_RETURN[$ACTION] = $RETURN;
            $_RETURN["requestid"][$ACTION] = $ID;
            $datafound = true;
            if (1==1) {
                
                
                    if (1==1) {
                        $RETURN["status"] = "success";
                        
                         $_RETURN["multioperation"] = true;
                        $_multiOptionSuccessCount++;
                    } else {
                        $_RETURN["multioperation"] = true;
                        $_multiOptionSuccessCount++;
                    }
                    
                    $_RETURN["successcount"] = $_multiOptionSuccessCount;
                    $RETURN["msg"] = "Multi operation [Success(" . $_multiOptionErrorCount . ") | Success(" . $_multiOptionSuccessCount . ")]";
                
            }
            if (1==1) {
                $datafoundwitherrorresponce = true;
                $RETURNMSG = $RETURN["msg"];
                $RETURNDESC = $RETURN["description"];
                if ($datafoundwitherrorresponce) {
                    OUTPUT(true, $RETURNMSG, $_RETURN, $RETURNDESC);
                }
                if ($datafound) {
                    OUTPUT(true, $RETURNMSG, $_RETURN, $RETURNDESC);
                } else {
                   OUTPUT(true, $RETURNMSG, $_RETURN, $RETURNDESC);
                }
            } else {
                $RETURNMSG = $RETURN["msg"];
                $RETURNDESC = $RETURN["description"];
                unset($RETURN);
            }
        }
        unset($ID);
    
} else {
    OUTPUT(false, "Session expired #1");
}
function OUTPUT($satatus = true, $msg, $data = 0, $description = "")
{
    global $devmode;
    header("Access-Control-Expose-Headers: Content-Length, X-JSON");
    header("Access-Control-Allow-Methods: *");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=utf-8");
    header("X-Powered-By: DHRU FUSION");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header_remove("pragma");
    header_remove("server");
    header_remove("transfer-encoding");
    global $starttime;
    global $d;
    $satatus =  "success" ;
    $dataout["status"] = $satatus;
    $dataout["msg"] = $msg;
    $dataout["description"] = $description;
    $dataout["requestid"] = $ID;
    if (!$data) {
      
    } else {
        if ($data["multioperation"]) {
            $dataout["multioperation"] = true;
            unset($data["multioperation"]);
            $dataout["errorcount"] = $data["errorcount"];
            unset($data["errorcount"]);
            $dataout["successcount"] = $data["successcount"];
            unset($data["successcount"]);
        }
        if ($data["token"]) {
            $dataout["token"] = $data["token"];
            unset($data["token"]);
        }
        if ($data["catched"]) {
            $dataout["catched"] = $data["catched"];
            unset($data["catched"]);
        }
        if ($data["requestid"]) {
            $dataout["requestid"] = $data["requestid"];
            unset($data["requestid"]);
        }
        $dataout["data"] = $data;
        unset($data);
    }
    $dataout["DHRUAPICORE"] = 1;
    $dataout["requesttime"] = microtime(true) - $starttime;
    $conn = NULL;
   
    exit(safe_json_encodetmp($dataout, true));
}
function safe_json_encodetmp($ARRAYS)
{
    $REsult = json_encode($ARRAYS, JSON_UNESCAPED_UNICODE);
    if (trim($REsult)) {
        return $REsult;
    }
    $REs = json_encode(utf8izenewtmp($ARRAYS), JSON_UNESCAPED_UNICODE);
    if (trim($REs)) {
        return $REs;
    }
    return json_encode("Json Encode Error");
}
function utf8izenewtmp($d)
{
    if (is_array($d)) {
       
            $d[$k] = utf8izenewtmp($v);
        
    } else {
        if (is_object($d)) {
            
                $d = utf8izenewtmp($v);
            
        } else {
            return utf8_encode($d);
        }
    }
    return $d;
}

?>