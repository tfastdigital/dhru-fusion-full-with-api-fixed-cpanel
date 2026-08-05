<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
$fileverioncheck = "6.1.0";
function getBrandDropdown($selected = "", $serviceid = "", $fieldname = "brandId", $foreignkey = false)
{
    global $LNG;
    $data = mysqli_fetch_assoc(dquery("SELECT `assigned_brand`,`listing` FROM `tbl_services_imei` WHERE md5(id)='" . $serviceid . "'"));
    if ($data["assigned_brand"]) {
        if ($data["assigned_brand"] == "ALL" || $data["assigned_brand"] == "") {
            $WHERE = " WHERE 1=1";
        } else {
            $WHERE = "WHERE `id` IN (" . $data["assigned_brand"] . ")";
        }
    }
    if ($foreignkey) {
        $foreignkeyvalue = "onchange=javascript:getModels(this.value,'" . $serviceid . "','#modelsdropdown','true','#main_loader');";
    }
    $result = dquery("SELECT `ID`,`Name` FROM `tbl_model_brand`  " . $WHERE);
    $returnvalue = "<select name=\"" . $fieldname . "\" " . $foreignkeyvalue . " ><option value=0>" . $LNG["select"] . "</option>";
    if ($result) {
        while ($data = mysqli_fetch_assoc($result)) {
            $returnvalue .= "<option value=\"" . $data["ID"] . "\"" . ($selected == $data["ID"] ? " selected=selected" : "") . ">" . $data["Name"] . "</option>";
        }
    }
    $returnvalue .= "</select>";
    unset($WHERE);
    return $returnvalue;
}
function getModelDropdown($bId, $selected = "", $serviceid = "", $fieldname = "modelId1")
{
    global $LNG;
    $data = mysqli_fetch_assoc(dquery("SELECT `assigned_model`,`listing` FROM `tbl_services_imei` WHERE md5(id)='" . $serviceid . "'"));
    if ($data["assigned_model"] == "ALL" || $data["assigned_model"] == "") {
        $WHERE = " 1=1 AND ";
    } else {
        $WHERE = " `id` IN (" . $data["assigned_model"] . ") AND ";
    }
    $result = dquery("SELECT `ID`,`Name` FROM `tbl_mobile` WHERE " . $WHERE . "  B_ID=" . $bId);
    $tempalte_ver["models"] = "<select name=\"" . $fieldname . "\"><option value=0>" . $LNG["select"] . "</option>";
    if ($result) {
        while ($data = mysqli_fetch_assoc($result)) {
            $tempalte_ver["models"] .= "<option value=\"" . $data["ID"] . "\"" . ($selected == $data["ID"] ? " selected=selected" : "") . ">" . $data["Name"] . "</option>";
        }
    }
    $tempalte_ver["models"] .= "</select>";
    unset($WHERE);
    return $tempalte_ver["models"];
}
function getProviderCountryDropdown($selected = "", $serviceid = "", $fieldname = "countryId", $foreignkey = false)
{
    global $LNG;
    $data = mysqli_fetch_assoc(dquery("SELECT `assigned_country`,`listing` FROM `tbl_services_imei` WHERE md5(id)='" . $serviceid . "'"));
    if ($data["assigned_country"] == "ALL" || $data["assigned_country"] == "") {
        $WHERE = " WHERE 1=1";
    } else {
        $WHERE = " WHERE `id` IN (" . $data["assigned_country"] . ")";
    }
    if ($foreignkey) {
        $foreignkeyvalue = "onchange=javascript:getProvider(this.value,'" . $serviceid . "','#providerdropdown','true','#main_loader');";
    }
    $result = dquery("SELECT `ID`,`Name` FROM `tbl_provider_country`  " . $WHERE);
    $returnvalue = "<select name=\"" . $fieldname . "\" " . $foreignkeyvalue . " ><option value=0>" . $LNG["select"] . "</option>";
    if ($result) {
        while ($data = mysqli_fetch_assoc($result)) {
            $returnvalue .= "<option value=\"" . $data["ID"] . "\"" . ($selected == $data["ID"] ? " selected=selected" : "") . ">" . $data["Name"] . "</option>";
        }
    }
    $returnvalue .= "</select>";
    unset($WHERE);
    return $returnvalue;
}
function getProviderDropdown($bId, $selected = "", $serviceid = "", $fieldname = "providerId1")
{
    global $LNG;
    $data = mysqli_fetch_assoc(dquery("SELECT `assigned_provider`,`listing` FROM `tbl_services_imei` WHERE md5(id)='" . $serviceid . "'"));
    if ($data["assigned_provider"]) {
        if ($data["assigned_provider"] == "ALL" || $data["assigned_provider"] == "") {
            $WHERE = " 1=1 AND ";
        } else {
            $WHERE = " `id` IN (" . $data["assigned_provider"] . ") AND ";
        }
    }
    $result = dquery("SELECT `ID`,`Name` FROM `tbl_provider` WHERE " . $WHERE . "  C_ID=" . $bId);
    $tempalte_ver["provider"] = "<select name=\"" . $fieldname . "\"><option value=0>" . $LNG["select"] . "</option>";
    if ($result) {
        while ($data = mysqli_fetch_assoc($result)) {
            $tempalte_ver["provider"] .= "<option value=\"" . $data["ID"] . "\"" . ($selected == $data["ID"] ? " selected=selected" : "") . ">" . $data["Name"] . "</option>";
        }
    }
    $tempalte_ver["provider"] .= "</select>";
    unset($WHERE);
    return $tempalte_ver["provider"];
}
function getNetworkDropdown($selected = "", $serviceid = "", $fieldname = "networkId")
{
    global $LNG;
    $data = mysqli_fetch_assoc(dquery("SELECT `assigned_network`,`listing` FROM `tbl_services_imei` WHERE md5(id)='" . $serviceid . "'"));
    if ($data["assigned_network"] == "ALL" || $data["assigned_network"] == "") {
        $WHERE = " WHERE 1=1";
    } else {
        $WHERE = " WHERE `id` IN (" . $data["assigned_network"] . ")";
    }
    $result = dquery("SELECT `ID`,`Name` FROM `tbl_network` " . $WHERE);
    $tempalte_ver["network"] = "<select name=\"" . $fieldname . "\"><option value=0>" . $LNG["select"] . "</option>";
    if ($result) {
        while ($data = mysqli_fetch_assoc($result)) {
            $tempalte_ver["network"] .= "<option value=\"" . $data["ID"] . "\"" . ($selected == $data["ID"] ? " selected=selected" : "") . ">" . $data["Name"] . "</option>";
        }
    }
    $tempalte_ver["network"] .= "</select>";
    unset($WHERE);
    return $tempalte_ver["network"];
}
function getmepDropdown($selected = "", $serviceid = "", $fieldname = "mepId")
{
    global $LNG;
    $data = mysqli_fetch_assoc(dquery("SELECT `assigned_mep`,`listing` FROM `tbl_services_imei` WHERE md5(id)='" . $serviceid . "'"));
    if ($data["assigned_mep"] == "ALL" || $data["assigned_mep"] == "") {
        $WHERE = " WHERE 1=1";
    } else {
        $WHERE = " WHERE `id` IN (" . $data["assigned_mep"] . ")";
    }
    $result = dquery("SELECT `id`,`mep` FROM `tbl_mep` " . $WHERE);
    $tempalte_ver["mep"] = "<select name=\"" . $fieldname . "\"><option value=0>" . $LNG["select"] . "</option>";
    if ($result) {
        while ($data = mysqli_fetch_assoc($result)) {
            $tempalte_ver["mep"] .= "<option value=\"" . $data["id"] . "\"" . ($selected == $data["id"] ? " selected=selected" : "") . ">" . $data["mep"] . "</option>";
        }
    }
    $tempalte_ver["mep"] .= "</select>";
    unset($WHERE);
    return $tempalte_ver["mep"];
}

?>