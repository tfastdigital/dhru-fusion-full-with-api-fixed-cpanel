<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["samkeynewname"] = "samkeynew";
$APIMODULE["samkeynewvisiblename"] = "samkey new (icell.ae)";
$APIMODULE["samkeynewnotes"] = "";
function samkeynew_activate()
{
    GatewayField("samkeynew", "text", "username", "", "User name", "30", "");
    GatewayField("samkeynew", "text", "password", "", "Password", "200", "");
    GatewayField("samkeynew", "text", "token", "", "Token", "200", "");
    GatewayField("samkeynew", "System", "apiurl", "http://icell.ae/mypanel/Api/", "apiurl", "30", "");
}
function samkeynew_accoutinfo($VAL)
{
}
function samkeynew_services($VAL)
{
    $return["Group"][0]["ID"] = "samkey new";
    $return["Group"][0]["Name"] = "samkey new";
    $return["Group"][0]["GroupType"] = "SERVER";
    $CustomFields = $__CustomFields = [];
    $__CustomFields[fieldtype] = "text";
    $__CustomFields[fieldoptions] = "";
    $__CustomFields[type] = "serviceimei";
    $__CustomFields[fieldname] = "USERNAME";
    $__CustomFields[description] = "";
    $__CustomFields[regexpr] = "";
    $__CustomFields[adminonly] = "";
    $__CustomFields[required] = "on";
    $__CustomFields[enc] = "";
    $CustomFields[] = $__CustomFields;
    $tool_id = 1;
    $return["Group"][0]["Tool"][$tool_id]["ID"] = $tool_id;
    $return["Group"][0]["Tool"][$tool_id]["ToolType"] = "SERVER";
    $return["Group"][0]["Tool"][$tool_id]["Name"] = "samkeynew Credits for New User";
    $return["Group"][0]["Tool"][$tool_id]["QNT"] = 1;
    $return["Group"][0]["Tool"][$tool_id]["Credits"] = "1";
    $return["Group"][0]["Tool"][$tool_id]["Requires.Custom"] = $CustomFields;
    $tool_id = 2;
    $return["Group"][0]["Tool"][$tool_id]["ID"] = $tool_id;
    $return["Group"][0]["Tool"][$tool_id]["ToolType"] = "SERVER";
    $return["Group"][0]["Tool"][$tool_id]["Name"] = "samkeynew Credits for Existing User";
    $return["Group"][0]["Tool"][$tool_id]["QNT"] = 1;
    $return["Group"][0]["Tool"][$tool_id]["Credits"] = "1";
    $return["Group"][0]["Tool"][$tool_id]["Requires.Custom"] = $CustomFields;
    return $return;
}
function samkeynew_send($VAL)
{
    print_r($VAL);
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            $customfields[$customfield["name"]] = $customfield["value"];
        }
    }
    $_username = $customfields["USERNAME"];
    $refNo = $VAL[ORDERID];
    $quantity = $VAL[QNT];
    if ($VAL["API_ID"] == 1) {
        $_pass = generatePasswdSamkey();
        $_URL = $VAL["apiurl"] . "CreateUser?token=" . $VAL["token"] . "&resellerid=" . $VAL["username"] . "&resellerpassword=" . $VAL["password"] . "&";
        $_URL .= "username=" . $_username . "&password=" . $_pass . "&credits=" . $quantity;
        $request = json_decode(initCurl($_URL), true);
        print_r($request);
        if ($request["status"] == "error") {
            $return["ERROR"] = json_encode($request);
            $return["MESSAGE"] = $request["msg"];
        } else {
            if ($request["status"] == "success") {
                $return["SUCCESS"] = true;
                $return["CODES"] = "Username: " . $_username . " <br />Password: " . $_pass . "<br />Credit: " . $quantity;
            }
        }
    } else {
        if ($VAL["API_ID"] == 2) {
            $_URL = $VAL["apiurl"] . "AddCredits?token=" . $VAL["token"] . "&resellerid=" . $VAL["username"] . "&resellerpassword=" . $VAL["password"] . "&";
            $_URL .= "username=" . $_username . "&credits=" . $quantity;
            $request = json_decode(initCurl($_URL), true);
            if ($request["status"] == "error") {
                $return["ERROR"] = json_encode($request);
                $return["MESSAGE"] = $request["msg"];
            } else {
                if ($request["status"] == "success") {
                    $return["SUCCESS"] = true;
                    $return["CODES"] = $request["msg"];
                }
            }
        }
    }
    return $return;
}
function generatePasswdSamkey($numAlpha = 10)
{
    $listAlpha = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return str_shuffle(substr(str_shuffle($listAlpha), 0, $numAlpha));
}

?>