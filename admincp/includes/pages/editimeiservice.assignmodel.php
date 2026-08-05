<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
if ($allmodelassign) {
    checkDemoMode(false);
    $assigned_provider = mysqli_fetch_assoc(dquery("select assigned_brand\n         from tbl_services_imei where id=" . $id));
    if (!$assigned_provider["assigned_brand"]) {
        $gc = mysqli_fetch_assoc(dquery("SELECT group_concat(ID) as gc \n            FROM `tbl_model_brand` WHERE 1"));
        $country = explode(",", $gc["gc"]);
    } else {
        $country = explode(",", $assigned_provider["assigned_brand"]);
    }
    foreach ($country as $c) {
        $sresult = dquery("select ID from tbl_mobile where B_ID=" . $c);
        while ($smodel = mysqli_fetch_assoc($sresult)) {
            $smodels[$smodel["ID"]] = $smodel["ID"];
        }
    }
    $countryarr = implode(",", $smodels);
    $data["assigned_model"] = $countryarr;
    if ($db->update("tbl_services_imei", $data, "id=" . $id)) {
        echo "<div id=notification1 class=successbox> " . $LNG["modelassign"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
    $data = NULL;
} else {
    if (isset($counter)) {
        checkDemoMode(false);
        if ($id) {
            $assigned_model = mysqli_fetch_assoc(dquery("select assigned_model \n        from tbl_services_imei where id=" . $id));
            $models = explode(",", $assigned_model["assigned_model"]);
            $sresult = dquery("select ID from tbl_mobile where B_ID=" . $brandId);
            while ($smodel = mysqli_fetch_assoc($sresult)) {
                $smodels[$smodel["ID"]] = $smodel["ID"];
            }
            $model_check = explode(",", $counter);
            $diff = array_diff($models, $smodels);
            $selectedModel = array_merge($diff, $model_check);
            $assignedModel = implode(",", array_filter($selectedModel));
            $data["assigned_model"] = $assignedModel;
            if ($db->update("tbl_services_imei", $data, "id=" . $id)) {
                echo "<div id=notification1 class=successbox> " . $LNG["modelassign"] . " " . $LNG["savesuccessfully"] . " </div>";
            } else {
                echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
            }
        } else {
            echo "<div id=notification1 class=errorbox>" . $LNG["service"] . " " . $LNG["not"] . "  " . $LNG["selected"] . " </div>";
        }
    }
}
include_once ROOTDIR . "/includes/imeiservices.fun.php";
$md5id = md5($id);
$imeiserviceDetails = getIMEIServices("", $md5id);
echo "<script>\nfunction setUNchk(ob){\n    document.getElementById('alls').checked=false;\n    \tvar cnt=document.getElementById('counter').value;\n\tif(ob.checked){\n\t\tif(cnt!=\"\"){\n\t\t\tcnt= cnt+','+ob.value;\n\t\t}else{\n\t\t\tcnt= ob.value;\n\t\t}\n\t}else{\n\t\tvar spl=cnt.split(',');\n\t\tlen=spl.length;\n\t\tvar news=new Array(); \n\t\tfor(var i=0; i<len; i++) {\n\t\t\tvals=spl[i];\n\t\t\tif(vals!=ob.value){\n\t\t\t\tnews[i]=vals;\t\n\t\t\t}\n\t\t}\n\t\tcnt=\"\";\n\t\tlen=news.length;\n\t\tfor(var i=0;i<len; i++) {\n\t\t\tif(news[i]!=undefined){\n\t\t\t\t\n\t\t\t\tvals=news[i];\n\t\t\t\tif(cnt!=\"\"){\n\t\t\t\t\tcnt= cnt+','+vals;\n\t\t\t\t}else{\n\t\t\t\t\tcnt= vals;\n\t\t\t\t}\n\t\t\t\t\n\t\t\t}\n\t\t}\n\t}\n\t\n\tdocument.getElementById('counter').value=cnt;\n}\n</script>\n<script>\nfunction setvals(ob){\n\tvar cnt=document.getElementById('counter').value;\n\tif(ob.checked){\n\t\tif(cnt!=\"\"){\n\t\t\tcnt= cnt+','+ob.value;\n\t\t}else{\n\t\t\tcnt= ob.value;\n\t\t}\n\t}else{\n\t\tvar spl=cnt.split(',');\n\t\tlen=spl.length;\n\t\tvar news=new Array(); \n\t\tfor(var i=0; i<len; i++) {\n\t\t\tvals=spl[i];\n\t\t\tif(vals!=ob.value){\n\t\t\t\tnews[i]=vals;\t\n\t\t\t}\n\t\t}\n\t\tcnt=\"\";\n\t\tlen=news.length;\n\t\tfor(var i=0;i<len; i++) {\n\t\t\tif(news[i]!=undefined){\n\t\t\t\t\n\t\t\t\tvals=news[i];\n\t\t\t\tif(cnt!=\"\"){\n\t\t\t\t\tcnt= cnt+','+vals;\n\t\t\t\t}else{\n\t\t\t\t\tcnt= vals;\n\t\t\t\t}\n\t\t\t\t\n\t\t\t}\n\t\t}\n\t}\n\t\n\tdocument.getElementById('counter').value=cnt;\n}\nfunction SetAllCheckBoxesS(val)\n{\n\tif(val.checked)\n\t{\n\t\t\tvar cnt=\"\";\n\t\tvar array = document.getElementsByTagName(\"input\");\n\t\tfor(var ii = 0; ii < array.length; ii++)\n\t\t{\n\t\t   if(array[ii].type == \"checkbox\")\n\t\t   {\n\t\t\t    if(array[ii].value!='ALL'){\n\t\t\t\t\t    if(cnt!=\"\"){\n\t\t\t\t\t\t\tcnt= cnt+','+array[ii].value;\n\t\t\t\t\t\t}else{\n\t\t\t\t\t\t\tcnt= array[ii].value;\n\t\t\t\t\t\t}\n\t\t\t    }\n\t\t\t\tarray[ii].checked = true;\n\t\t   }\n\t\t   document.getElementById('counter').value=cnt;\n\t\t}\n\t}\n\telse\n\t{\n\t\tdocument.getElementById('counter').value=\"\";\n\t\tvar array = document.getElementsByTagName(\"input\");\n\t\tfor(var ii = 0; ii < array.length; ii++)\n\t\t{\n\t\t   if(array[ii].type == \"checkbox\")\n\t\t   {\n\t\t\t\tarray[ii].checked = false;\n\t\t   }\n\t\t}\n\t}\t\n} \n</script>\n\n<div id=\"content\"><div id=\"content_padded\" style=\"padding: 35px;\">\n\n<form id=\"submitori\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"";
echo $brand;
echo "\" name=\"brandId\"/>\n";
$countrys = $imeiserviceDetails["reqredfield"]["assigned_brand"];
if ($imeiserviceDetails["reqredfield"]["assigned_brand"] == "ALL" || $imeiserviceDetails["reqredfield"]["assigned_country"] == "") {
    $query = "select ID,Name from tbl_model_brand";
} else {
    $query = "select ID,Name from tbl_model_brand where ID in (" . $countrys . ")";
}
$result = dquery("select ID,Name from tbl_mobile where B_ID='" . $brand . "'");
$prov = explode(",", $imeiserviceDetails["assigned_model"]);
$uncheck = "";
while ($rowm = mysqli_fetch_assoc($result)) {
    if (in_array($rowm["ID"], $prov)) {
        $assini = $assini . "," . $rowm["ID"];
    } else {
        $checked = "";
    }
}
echo "<input type=\"hidden\" name=\"counter\" id=\"counter\" value=\"";
echo trim($assini, ",");
echo "\" />\n    <input type=\"checkbox\" name=\"allmodelassign\" value=\"1\" id=\"a\" />\n    <label class=\"btn-label\" for=\"a\" >Assign all models for all allowed Brands</label>\n\n</form>\n \n<form id=\"frmmodel\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"";
echo $brand;
echo "\" name=\"brandId\"/>\n";
echo generate_token("form");
$brands = $imeiserviceDetails["reqredfield"]["assigned_brand"];
if ($imeiserviceDetails["reqredfield"]["assigned_brand"] == "ALL" || $imeiserviceDetails["reqredfield"]["assigned_brand"] == "") {
    $query = "select ID,Name from tbl_model_brand order by Name ASC";
} else {
    $query = "select ID,Name from tbl_model_brand where ID in (" . $brands . ") order by Name ASC";
}
echo "    \n";
echo $LNG["selectbrand"];
echo " : <select name=\"brand\" class=\"chosen\"  onchange=\"window.location.href='main2.php?page=editimeiservice.assignmodel&id=";
echo $id;
echo "&brand='+this.value\"><option>";
echo $LNG["select"];
echo " </option>\n";
$result = dquery($query);
while ($row = mysqli_fetch_assoc($result)) {
    if ($brand == $row["ID"]) {
        $selected = "selected";
    } else {
        $selected = "";
    }
    echo "<option value=" . $row["ID"] . " " . $selected . ">" . $row["Name"] . "</option>";
}
echo "</select><br><br>";
$result = dquery("select ID,Name from tbl_mobile where B_ID=" . $brand . " order by Name ASC");
if ($result) {
    echo "<table id=\"main_tbl\" style=\"display: table;\">\n            <thead>\n              <tr class=\"singletd\">\n                <th> <input value=\"ALL\" class=\"check-all\"  id=\"alls\" name=\"all_model\" onclick=\"SetAllCheckBoxesS(this)\" type=\"checkbox\"/> <label for=\"alls\"></label></th><th width=\"20px\">";
    echo $LNG["id"];
    echo "</th><th><div align=\"left\">";
    echo $LNG["model"];
    echo " ";
    echo $LNG["name"];
    echo "</div> </th>\n                <th></th>\n              </tr>\n            </thead>\n            <tbody>\n";
    $model = explode(",", $imeiserviceDetails["assigned_model"]);
    $uncheck = "";
    while ($rowm = mysqli_fetch_assoc($result)) {
        if (in_array($rowm["ID"], $model)) {
            $checked = "checked";
        } else {
            $checked = "";
        }
        echo "<tr class='singletd'><td><input  id='i_" . $rowm["ID"] . "' \n    onclick='setvals(this);' name=model_check[" . $rowm["ID"] . "] value=" . $rowm["ID"] . " type=checkbox " . $checked . "> <label for='i_" . $rowm["ID"] . "'></laebl></td><td>" . $rowm["ID"] . "</td><td>" . $rowm["Name"] . "</td><td></td> </tr>";
    }
}
echo "</tbody></table>\n \n\n \n<p class=\"fixedbtn\">\n\n\n<input name=\"btnedituser\" value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn save\" type=\"button\" \nonclick=\"document.getElementById('submitori').submit();\" /></p>\n</form>\n\n </div> </div>\n \n<br /><br /><br />";
$fileverioncheck = "6.1.0";
function trim_value(&$value)
{
    $value = trim($value);
}

?>