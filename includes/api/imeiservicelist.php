<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$pagelimit = 1000;
require ROOTDIR . "/includes/imeiservices.fun.php";
$ServiceDetails = getIMEIServicesNew("", "", $UserDetails["id"], true, false, "");
$NewServiceDetails = NULL;
foreach ($ServiceDetails as $Group => $Services) {
    $NewServiceDetails[$Group]["GROUPNAME"] = $Group;
    foreach ($Services as $Service) {
        $Type = "IMEI";
        if ($Service["useasserver"] == 2) {
            $Type = "REMOTE";
        } else {
            if ($Service["useasserver"] == 1) {
                $Type = "SERVER";
            }
        }
        $FullServiceDetails = $Service;
        $NewServiceDetails[$Group]["GROUPTYPE"] = $Type;
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["SERVICEID"] = $Service["id"] * 9 + 5;
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["SERVICETYPE"] = $Type;
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["QNT"] = $FullServiceDetails["qnt"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["SERVER"] = $FullServiceDetails["useasserver"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["MINQNT"] = $FullServiceDetails["minqnt"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["MAXQNT"] = $FullServiceDetails["maxqnt"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["CUSTOM"]["allow"] = $Service["imei_custom"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["CUSTOM"]["bulk"] = $Service["imei_bulk"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["CUSTOM"]["customname"] = $Service["imei_custom_name"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["CUSTOM"]["custominfo"] = $Service["imei_custom_info"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["CUSTOM"]["customlen"] = $Service["imei_custom_len"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["CUSTOM"]["maxlength"] = $Service["maxlength"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["CUSTOM"]["regex"] = $Service["imeiregex"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["CUSTOM"]["isalpha"] = $Service["isalpha"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["SERVICENAME"] = $Service["service_name"];
        if (!is_nan($Service["credit"])) {
            $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["CREDIT"] = round(isset($Service["credit"]) ? $Service["credit"] : 0, 3);
            $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["TIME"] = $Service["time"];
            $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["INFO"] = "";
            $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["INFO"] = utf8_encode($Service["info"]);
            $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.Network"] = $FullServiceDetails["reqredfield"]["network"] == "1" ? "Required" : "None";
            $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.Mobile"] = $FullServiceDetails["reqredfield"]["model"] == "1" ? "Required" : "None";
            $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.Provider"] = $FullServiceDetails["reqredfield"]["provider"] == "1" ? "Required" : "None";
            $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.PIN"] = $FullServiceDetails["reqredfield"]["PIN"] == "1" ? "Required" : "None";
            $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.KBH"] = $FullServiceDetails["reqredfield"]["KBH"] == "1" ? "Required" : "None";
            $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.MEP"] = $FullServiceDetails["reqredfield"]["mep"] == "1" ? "Required" : "None";
            $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.PRD"] = $FullServiceDetails["reqredfield"]["PRD"] == "1" ? "Required" : "None";
            $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.Type"] = $FullServiceDetails["reqredfield"]["type"] == "1" ? "Required" : "None";
            $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.Locks"] = $FullServiceDetails["reqredfield"]["locks"] == "1" ? "Required" : "None";
            $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.Reference"] = $FullServiceDetails["reqredfield"]["reference"] == "1" ? "Required" : "None";
            $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.SN"] = $FullServiceDetails["reqredfield"]["SN"] == "1" ? "Required" : "None";
            $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.SecRO"] = $FullServiceDetails["reqredfield"]["SecRO"] == "1" ? "Required" : "None";
            $CUSTOM = [];
            $cf = dquery("select `type`,fieldname,fieldtype,description,fieldoptions,regexpr,adminonly,required,enc from tbl_customfields where `type`='serviceimei' and relid='" . $Service["id"] . "'");
            for ($i = 0; $rcf = mysqli_fetch_assoc($cf); $i++) {
                $CUSTOM[$i]["type"] = $rcf["type"];
                $CUSTOM[$i]["fieldname"] = $rcf["fieldname"];
                $CUSTOM[$i]["fieldtype"] = $rcf["fieldtype"];
                $CUSTOM[$i]["description"] = $rcf["description"];
                $CUSTOM[$i]["fieldoptions"] = $rcf["fieldoptions"];
                $CUSTOM[$i]["regexpr"] = $rcf["regexpr"];
                $CUSTOM[$i]["adminonly"] = $rcf["adminonly"];
                $CUSTOM[$i]["required"] = $rcf["required"];
                $CUSTOM[$i]["enc"] = $rcf["enc"];
            }
            if ($i) {
                $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.Custom"] = $CUSTOM;
            }
        }
    }
}
$apiresults["SUCCESS"][] = ["MESSAGE" => "IMEI Service List", "LIST" => $NewServiceDetails];
unset($NewServiceDetails);
unset($ServiceDetails);

?>