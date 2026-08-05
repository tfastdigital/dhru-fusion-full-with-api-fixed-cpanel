<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);

// Ajuste de paths para rodar na raiz do admincp
require_once "../comm.php";
require_once "includes/fun.inc.php";
// require_once "../../includes/fun.inc.php"; // Redundante ou incorreto se já incluiu acima

if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}

require_once ROOTDIR . "/includes/imeiservices.fun.php";

// Caminho do arquivo JSON temporário
$jsonFile = ROOTDIR . "/" . $admindirpath . "/tmp/" . $id . ".json";

if (!file_exists($jsonFile)) {
    die("Cache file not found. Please sync again.");
}

$File = file_get_contents($jsonFile);
$File = json_decode($File, true);
$totalv = 0;
$_t = "&nbsp;&nbsp;&nbsp;&nbsp;";

foreach ($File as $cnts => $fs) {
    if (!($starts && $starts != $cnts)) {
        if ($fs["group"]) {
            $GROUPS = $fs["group"];
            if ($onlyservice) {
                $GROUPS["name"] = str_replace("/", "", $GROUPS["name"]);
                $data = NULL;
                $data["gateway"] = $id;
                $data["type"] = "Group";
                $data["name"] = html_entity_decode(htmlspecialchars($GROUPS["name"]));
                $data["id"] = $GROUPS["id"];
                $data["useasserver"] = $GROUPS["useasserver"];
                if ($GROUPS["servicetype"]) {
                    $data["servicetype"] = $GROUPS["servicetype"];
                } else {
                    $data["servicetype"] = "";
                }
                
                // Verifica se já existe para evitar duplicatas desnecessárias (embora insert_query possa lidar com isso)
                $Groupid = insert_query("tbl_apiserversservices", $data);
                
                if ($GROUPS["servicetype"]) {
                    $__TYPE = " <strong>(File Service)</strong>";
                } else {
                    if ($GROUPS["useasserver"] == 1) {
                        $__TYPE = " <strong>(Server Service)</strong>";
                    } else {
                        if ($GROUPS["useasserver"] == 2) {
                            $__TYPE = " <strong>(Remote Service)</strong>";
                        } else {
                            $__TYPE = NULL;
                        }
                    }
                }
                if ($onlyservice && !$setupmyserver && !$setupmyserverserver && !$setupmyremote) {
                    displyOutput1("Group :: " . html_entity_decode(htmlspecialchars($GROUPS["name"])) . $__TYPE);
                }
                
                $SERVICE = $fs["service"];
                foreach ($SERVICE as $service) {
                    $ToolType = 0;
                    $CREDIT = $service["Credits"];
                    if ($service["ToolType"] == "REMOTE") {
                        $ToolType = 2;
                        if (0 < $remotefixed) {
                            $CREDIT = $CREDIT + $remotefixed;
                        } else {
                            if (0 < $remoteper) {
                                $incs = round($CREDIT * $remoteper / 100, 2);
                                $CREDIT = $CREDIT + $incs;
                            }
                        }
                    } else {
                        if ($service["ToolType"] == "SERVER") {
                            $ToolType = 1;
                            if (0 < $serverfixed) {
                                $CREDIT = $CREDIT + $serverfixed;
                            } else {
                                if (0 < $serverper) {
                                    $incs = round($CREDIT * $serverper / 100, 2);
                                    $CREDIT = $CREDIT + $incs;
                                }
                            }
                        } else {
                            if (0 < $imeifixed) {
                                $CREDIT = $CREDIT + $imeifixed;
                            } else {
                                if (0 < $imeiper) {
                                    $incs = round($CREDIT * $imeiper / 100, 2);
                                    $CREDIT = $CREDIT + $incs;
                                }
                            }
                        }
                    }
                    $data = NULL;
                    $data["gateway"] = $id;
                    $data["type"] = "Tool";
                    $data["name"] = html_entity_decode(htmlspecialchars($service["Name"]));
                    $data["id"] = $service["ID"];
                    $data["group"] = html_entity_decode(htmlspecialchars($GROUPS["name"]));
                    $data["credit"] = $CREDIT;
                    $data["time"] = html_entity_decode(htmlspecialchars($service["DeliveryTime"]));
                    $data["info"] = html_entity_decode(htmlspecialchars($service["Info"]));
                    $data["useasserver"] = $ToolType;
                    
                    // Tratamento extra para campos que podem não existir
                    if(isset($service["type_id"])) $data["type_id"] = $service["type_id"];
                    if(isset($service["requires.custom"])) $data["requires_custom"] = $service["requires.custom"];
                    if(isset($service["requires.model"])) $data["requires_model"] = $service["requires.model"];
                    if(isset($service["requires.provider"])) $data["requires_provider"] = $service["requires.provider"];
                    if(isset($service["requires.mep"])) $data["requires_mep"] = $service["requires.mep"];
                    if(isset($service["requires.pin"])) $data["requires_pin"] = $service["requires.pin"];
                    if(isset($service["requires.kbh"])) $data["requires_kbh"] = $service["requires.kbh"];
                    if(isset($service["requires.sn"])) $data["requires_sn"] = $service["requires.sn"];
                    if(isset($service["requires.secro"])) $data["requires_secro"] = $service["requires.secro"];
                    if(isset($service["requires.reference"])) $data["requires_reference"] = $service["requires.reference"];

                    insert_query("tbl_apiserversservices", $data);
                    
                    // Lógica de adicionar serviço ao sistema se solicitado
                    if ($setupmyserver && $ToolType == 0) {
                        install_imei_service($service, $GROUPS, $id, $imeifixed, $imeiper, $deleteservices);
                    }
                    if ($setupmyserverserver && $ToolType == 1) {
                        install_server_service($service, $GROUPS, $id, $serverfixed, $serverper, $deleteservicesserver);
                    }
                    if ($setupmyremote && $ToolType == 2) {
                        install_imei_service($service, $GROUPS, $id, $remotefixed, $remoteper, $deleteremote, true);
                    }
                }
            }
        }
    }
    $totalv++;
    if (2 < $totalv) {
        $next = $cnts + 1;
        if (count($File) == $next) {
            echo "Done+___+Finished";
        } else {
            echo "Done+___+" . $next;
        }
        exit;
    }
}
echo "Done+___+Finished";

function displyOutput1($str)
{
    echo $str . "<br>";
    flush();
    ob_flush();
}
?>