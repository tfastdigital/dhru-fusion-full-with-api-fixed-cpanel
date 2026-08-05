<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function getFeaturesFromGroup($gid)
{
    $featureslist = [];
    $sql = dquery("select id from tbl_products where group_id='" . $gid . "' and active='1'");
    while ($row = mysqli_fetch_assoc($sql)) {
        $f = dquery("select fieldid from tbl_featuresvalues where relid='" . $row["id"] . "'\n         and (value='Yes' or value='yes')");
        while ($fea = mysqli_fetch_assoc($f)) {
            $detail = mysqli_fetch_assoc(dquery("select fieldname from \n            tbl_features where id='" . $fea["fieldid"] . "'"));
            if ($detail["fieldname"]) {
                $key = md5($detail["fieldname"]);
                $featureslist[$key] = $detail["fieldname"];
                ${$detail["fieldname"]}++;
            }
        }
    }
    foreach ($featureslist as $k => $v) {
        $featureslist[$k] = $v . "_" . ${$v};
    }
    return $featureslist;
}
function getFeatures($type, $relid, $relid2, $admin = "", $order = "", $ordervalues = "", $onlyvalue = false)
{
    $customfields = $where = [];
    $where["type"] = $type;
    if ($relid) {
        $where["relid"] = $relid;
    }
    if (!$admin) {
        $where["adminonly"] = "";
    }
    if ($order) {
        $where["showorder"] = "on";
    }
    $result = select_query("tbl_features", "", $where, "sortorder` ASC,`id", "ASC");
    while ($data = mysqli_fetch_assoc($result)) {
        $id = $data["id"];
        $fieldname = $data["fieldname"];
        if (strpos($fieldname, "|")) {
            $fieldname = explode("|", $fieldname);
            $fieldname = trim($fieldname[1]);
        }
        $fieldtype = $data["fieldtype"];
        $description = $data["description"];
        $fieldoptions = $data["fieldoptions"];
        $required = $data["required"];
        $customfieldval = $ordervalues[$id];
        if ($relid2) {
            $result2 = select_query("tbl_featuresvalues", "value", ["fieldid" => $id, "relid" => $relid2]);
            $data = mysqli_fetch_assoc($result2);
            $customfieldval = $data["value"];
        }
        if ($required == "on") {
            $required = "*";
        }
        if ($fieldtype == "text") {
            $input = "<input type=\"text\" size=\"30\" name=\"customfield[" . $id . "]" . "\" id=\"customfield" . $id . "\" value=\"" . $customfieldval . "\">";
        } else {
            if ($fieldtype == "textarea") {
                $input = "<textarea name=\"customfield[" . $id . "]" . "\" id=\"customfield" . $id . "\" cols=\"60\" rows=\"3\">" . $customfieldval . "</textarea>";
            } else {
                if ($fieldtype == "dropdown") {
                    $input = "<select class=\"customfield\" name=\"customfield[" . $id . "]" . "\" id=\"customfield" . $id . "\">";
                    $fieldoptions = explode(",", $fieldoptions);
                    foreach ($fieldoptions as $optionvalue) {
                        $input .= "<option value=\"" . $optionvalue . "\"";
                        if ($customfieldval == $optionvalue) {
                            $input .= " selected";
                        }
                        if (strpos($optionvalue, "|")) {
                            $optionvalue = explode("|", $optionvalue);
                            $optionvalue = trim($optionvalue[1]);
                        }
                        $input .= ">" . $optionvalue . "</option>";
                    }
                    $input .= "</select>";
                } else {
                    if ($fieldtype == "tickbox") {
                        $input = "<input type=\"checkbox\" name=\"customfield[" . $id . "]" . "\" id=\"customfield" . $id . "\"";
                        if ($customfieldval == "on") {
                            $input .= " checked";
                        }
                        $input .= ">";
                    }
                }
            }
        }
        $customfieldvalraw = $customfieldval;
        if (strpos($customfieldval, "|")) {
            $customfieldval = explode("|", $customfieldval);
            $customfieldval = trim($customfieldval[1]);
        }
        if ($onlyvalue) {
            if ($customfieldval != "") {
                $customfields[] = ["id" => $id, "name" => $fieldname, "description" => $description, "value" => $customfieldval];
            }
        } else {
            $customfields[] = ["id" => $id, "name" => $fieldname, "description" => $description, "input" => $input, "value" => $customfieldval, "rawvalue" => $customfieldvalraw, "required" => $required];
        }
    }
    return $customfields;
}
function saveFeatures($relid, $customfields)
{
    if (is_array($customfields)) {
        foreach ($customfields as $id => $value) {
            $result = select_query("tbl_featuresvalues", "", ["fieldid" => $id, "relid" => $relid]);
            $num_rows = mysqli_num_rows($result);
            if ($num_rows == "0") {
                insert_query("tbl_featuresvalues", ["fieldid" => $id, "relid" => $relid, "value" => $value]);
            } else {
                update_query("tbl_featuresvalues", ["value" => $value], ["fieldid" => $id, "relid" => $relid]);
            }
        }
    }
}
function checkFeatures($customfields)
{
    global $lng_languag;
    if ($customfields) {
        foreach ($customfields as $id => $value) {
            $result = select_query("tbl_features", "", ["id" => $id]);
            $data = mysqli_fetch_assoc($result);
            $fieldname = $data["fieldname"];
            if (strpos($fieldname, "|")) {
                $fieldname = explode("|", $fieldname);
                $fieldname = trim($fieldname[1]);
            }
            $required = $data["required"];
            $regexpr = $data["regexpr"];
            if ($required == "on" && !$value) {
                $errormessage .= "<li>" . $fieldname . " " . $lng_languag["isrequired"];
            }
            if ($regexpr && $value) {
                if (substr($regexpr, 0, 2) == "/^") {
                    if (!preg_match($regexpr, $value)) {
                        $errormessage .= "<li>" . $fieldname . " " . $lng_languag["validationerror"];
                    }
                } else {
                    $errormessage .= "<li>" . $fieldname . " " . $lng_languag["validationerror"];
                }
            }
        }
    }
    return $errormessage;
}
function getFeaturesServicewise($type, $relid)
{
    global $LNG;
    $result = dquery("select * from tbl_features where type='" . $type . "' and relid='" . $relid . "'");
    while ($data = mysqli_fetch_assoc($result)) {
        $arr[$data["id"]]["fieldname"] = "<input type=\"text\"  name=\"customfield[" . $data["id"] . "][fieldname]\" value=\"" . $data["fieldname"] . "\">";
        $arr[$data["id"]]["description"] = "<input type=\"text\"  name=\"customfield[" . $data["id"] . "][description]\" value=\"" . $data["description"] . "\">";
        if ($data["fieldtype"] == "text") {
            $text = "selected";
        } else {
            if ($data["fieldtype"] == "dropdown") {
                $dropdown = "selected";
            } else {
                if ($data["fieldtype"] == "textarea") {
                    $textarea = "selected";
                } else {
                    if ($data["fieldtype"] == "tickbox") {
                        $tickbox = "selected";
                    }
                }
            }
        }
        $arr[$data["id"]]["fieldtype"] = "<select class=\"customfield\"  name=\"customfield[" . $data["id"] . "][fieldtype]\"><option value=\"text\" " . $text . ">" . $LNG["text"] . "</option><option value=\"dropdown\" " . $dropdown . ">" . $LNG["dropdown"] . "</option><option value=\"textarea\" " . $textarea . ">" . $LNG["textarea"] . "</option><option value=\"tickbox\" " . $tickbox . ">" . $LNG["tickbox"] . "</option></select>";
        $data["fieldtype"] = "";
        $text = "";
        $dropdown = "";
        $textarea = "";
        $tickbox = "";
        $arr[$data["id"]]["fieldoptions"] = "<input type=\"text\" class=\"fieldoptions\" name=\"customfield[" . $data["id"] . "][fieldoptions]\" value=\"" . $data["fieldoptions"] . "\">";
        $arr[$data["id"]]["regexpr"] = "<input type=\"text\" name=\"customfield[" . $data["id"] . "][regexpr]\" value=\"" . $data["regexpr"] . "\">";
        $arr[$data["id"]]["order"] = "<input type=\"text\" style=\"width: 20px;\" name=\"customfield[" . $data["id"] . "][sortorder]\" value=\"" . $data["sortorder"] . "\">";
        $sls = "";
        if ($data["quickinfo"]) {
            $sls = "checked='checked'";
        }
        $arr[$data["id"]]["quickinfo"] = "<input type=\"checkbox\" " . $sls . "\n                     name=\"customfield[" . $data["id"] . "][quickinfo]\"\n                     value=\"1\">";
        $sls = "";
        if ($data["filter"]) {
            $sls = "checked='checked'";
        }
        $arr[$data["id"]]["filter"] = "<input type=\"checkbox\" " . $sls . "\n                     name=\"customfield[" . $data["id"] . "][filter]\"\n                     value=\"1\">";
        if ($data["required"] == "on") {
            $selected = "checked";
        } else {
            $selected = "";
        }
        $arr[$data["id"]]["required"] = "<input type=\"checkbox\" value=\"on\" name=\"customfield[" . $data["id"] . "][required]\" " . $selected . ">";
    }
    return $arr;
}
function saveFeaturesServicewise($id, $customfield)
{
    if (is_array($customfield)) {
        $check = "false";
        foreach ($customfield as $id => $value) {
            $result = select_query("tbl_features", "", "id='" . $id . "'");
            $num_rows = mysqli_num_rows($result);
            $check = "true";
            if ($num_rows == "0") {
                insert_query("tbl_features", $customfield[$id]);
            } else {
                update_query("tbl_features", $customfield[$id], "id='" . $id . "'");
            }
        }
    }
    return $check;
}

?>