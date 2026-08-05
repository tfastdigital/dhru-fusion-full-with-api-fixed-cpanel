<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($allowprovider) {
    checkDemoMode(false);
    $assigned_provider = mysqli_fetch_assoc(dquery("select assigned_country\n         from tbl_services_imei where id=" . $id));
    if (!$assigned_provider["assigned_country"]) {
        $gc = mysqli_fetch_assoc(dquery("SELECT group_concat(ID) as gc FROM  \n           `tbl_provider_country` WHERE 1"));
        $country = explode(",", $gc["gc"]);
    } else {
        $country = explode(",", $assigned_provider["assigned_country"]);
    }
    foreach ($country as $c) {
        $sresult = dquery("select ID from tbl_provider where\n             C_ID=" . $c);
        while ($smodel = mysqli_fetch_assoc($sresult)) {
            $smodels[$smodel["ID"]] = $smodel["ID"];
        }
    }
    $countryarr = implode(",", $smodels);
    $data["assigned_provider"] = $countryarr;
    if ($db->update("tbl_services_imei", $data, "id=" . $id)) {
        echo "<div id=notification1 class=successbox> " . $LNG["providerassign"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
    $data = NULL;
} else {
    if (isset($counter)) {
        checkDemoMode(false);
        if ($id) {
            $assigned_model = mysqli_fetch_assoc(dquery("select assigned_provider from tbl_services_imei where id=" . $id));
            $models = explode(",", $assigned_model["assigned_provider"]);
            $sresult = dquery("select ID from tbl_provider where C_ID=" . $countryId);
            while ($smodel = mysqli_fetch_assoc($sresult)) {
                $smodels[$smodel["ID"]] = $smodel["ID"];
            }
            $model_check = explode(",", $counter);
            $diff = array_diff($models, $smodels);
            $selectedModel = array_merge($diff, $model_check);
            $assignedModel = implode(",", array_filter($selectedModel));
            $data["assigned_provider"] = $assignedModel;
            if ($db->update("tbl_services_imei", $data, "id=" . $id)) {
                echo "<div id=notification1 class=successbox> " . $LNG["providerassign"] . " " . $LNG["savesuccessfully"] . " </div>";
            } else {
                echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
            }
        } else {
            echo "<div id=notification1 class=errorbox>" . $LNG["service"] . " " . $LNG["not"] . "  " . $LNG["selected"] . " </div>";
        }
    }
}
if (isset($btnedituser)) {
    checkDemoMode(false);
    if ($provider_check) {
        $assigned_provider = mysqli_fetch_assoc(dquery("select assigned_provider from tbl_services_imei where id=" . $id));
        $providers = explode(",", $assigned_provider["assigned_provider"]);
        $sresult = dquery("select ID from tbl_provider where C_ID=" . $countryId);
        while ($sprovider = mysqli_fetch_assoc($sresult)) {
            $sproviders[$sprovider["ID"]] = $sprovider["ID"];
        }
        $diff = array_diff($providers, $sproviders);
        $selectedprovider = array_merge($diff, $provider_check);
        $assignedprovider = implode(",", array_filter($selectedprovider));
        $data["assigned_provider"] = $assignedprovider;
        if ($db->update("tbl_services_imei", $data, "id=" . $id)) {
            echo "<div id=notification1 class=successbox> " . $LNG["providerassign"] . " " . $LNG["savesuccessfully"] . " </div>";
        } else {
            echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
        }
    } else {
        echo "<div id=notification1 class=errorbox>" . $LNG["service"] . " " . $LNG["not"] . "  " . $LNG["selected"] . " </div>";
    }
}
include_once ROOTDIR . "/includes/imeiservices.fun.php";
$md5id = md5($id);
$imeiserviceDetails = getIMEIServices("", $md5id);
echo "<script>\nfunction setvals(ob){\n\tvar cnt=document.getElementById('counter').value;\n\tif(ob.checked){\n\t\tif(cnt!=\"\"){\n\t\t\tcnt= cnt+','+ob.value;\n\t\t}else{\n\t\t\tcnt= ob.value;\n\t\t}\n\t}else{\n\t\tvar spl=cnt.split(',');\n\t\tlen=spl.length;\n\t\tvar news=new Array(); \n\t\tfor(var i=0; i<len; i++) {\n\t\t\tvals=spl[i];\n\t\t\tif(vals!=ob.value){\n\t\t\t\tnews[i]=vals;\t\n\t\t\t}\n\t\t}\n\t\tcnt=\"\";\n\t\tlen=news.length;\n\t\tfor(var i=0;i<len; i++) {\n\t\t\tif(news[i]!=undefined){\n\t\t\t\t\n\t\t\t\tvals=news[i];\n\t\t\t\tif(cnt!=\"\"){\n\t\t\t\t\tcnt= cnt+','+vals;\n\t\t\t\t}else{\n\t\t\t\t\tcnt= vals;\n\t\t\t\t}\n\t\t\t\t\n\t\t\t}\n\t\t}\n\t}\n\t\n\tdocument.getElementById('counter').value=cnt;\n}\nfunction SetAllCheckBoxesS(val)\n{\n\tif(val.checked)\n\t{\n\t\t\tvar cnt=\"\";\n\t\tvar array = document.getElementsByTagName(\"input\");\n\t\tfor(var ii = 0; ii < array.length; ii++)\n\t\t{\n\t\t   if(array[ii].type == \"checkbox\")\n\t\t   {\n\t\t\t    if(array[ii].value!='ALL'){\n\t\t\t\t\t   if(cnt!=\"\"){\n\t\t\t\t\t\t\tcnt= cnt+','+array[ii].value;\n\t\t\t\t\t\t}else{\n\t\t\t\t\t\t\tcnt= array[ii].value;\n\t\t\t\t\t\t}\n\t\t\t    }\n\t\t\t\tarray[ii].checked = true;\n\t\t   }\n\t\t   document.getElementById('counter').value=cnt;\n\t\t}\n\t}\n\telse\n\t{\n\t\tdocument.getElementById('counter').value=\"\";\n\t\tvar array = document.getElementsByTagName(\"input\");\n\t\tfor(var ii = 0; ii < array.length; ii++)\n\t\t{\n\t\t   if(array[ii].type == \"checkbox\")\n\t\t   {\n\t\t\t\tarray[ii].checked = false;\n\t\t   }\n\t\t}\n\t}\t\n}\n</script>\n<script>\nfunction setUNchk(ob){\n    document.getElementById('alls').checked=false;\n   \tvar cnt=document.getElementById('counter').value;\n    if(ob.checked){\n\t\tif(cnt!=\"\"){\n\t\t\tcnt= cnt+','+ob.value;\n\t\t}else{\n\t\t\tcnt= ob.value;\n\t\t}\n\t}else{\n\t\tvar spl=cnt.split(',');\n\t\tlen=spl.length;\n\t\tvar news=new Array(); \n\t\tfor(var i=0; i<len; i++) {\n\t\t\tvals=spl[i];\n\t\t\tif(vals!=ob.value){\n\t\t\t\tnews[i]=vals;\t\n\t\t\t}\n\t\t}\n\t\tcnt=\"\";\n\t\tlen=news.length;\n\t\tfor(var i=0;i<len; i++) {\n\t\t\tif(news[i]!=undefined){\n\t\t\t\t\n\t\t\t\tvals=news[i];\n\t\t\t\tif(cnt!=\"\"){\n\t\t\t\t\tcnt= cnt+','+vals;\n\t\t\t\t}else{\n\t\t\t\t\tcnt= vals;\n\t\t\t\t}\n\t\t\t\t\n\t\t\t}\n\t\t}\n\t}\n\t\n\tdocument.getElementById('counter').value=cnt;\n}\n</script>\n<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n<script src=\"../js/jquery.js\" language=\"javascript\"></script>\n<div id=\"content\"><div id=\"content_padded\" style=\"padding: 35px;\">\n<form id=\"submitori\" method=\"post\"> \n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"";
echo $country;
echo "\" name=\"countryId\"/>\n";
$countrys = $imeiserviceDetails["reqredfield"]["assigned_country"];
if ($imeiserviceDetails["reqredfield"]["assigned_country"] == "ALL" || $imeiserviceDetails["reqredfield"]["assigned_country"] == "") {
    $query = "select ID,Name from tbl_provider_country";
} else {
    $query = "select ID,Name from tbl_provider_country where ID in (" . $countrys . ")";
}
$result = dquery("select ID,Name from tbl_provider where C_ID='" . $country . "'");
$prov = explode(",", $imeiserviceDetails["assigned_provider"]);
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
echo "\" />\n  \n\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"";
echo $country;
echo "\" name=\"countryId\"/>\n";
echo generate_token("form");
$countrys = $imeiserviceDetails["reqredfield"]["assigned_country"];
if ($imeiserviceDetails["reqredfield"]["assigned_country"] == "ALL" || $imeiserviceDetails["reqredfield"]["assigned_country"] == "") {
    $query = "select ID,Name from tbl_provider_country";
} else {
    $query = "select ID,Name from tbl_provider_country where ID in (" . $countrys . ")";
}
echo "    \n";
echo $LNG["selectcountry"];
echo " : <select name=\"country\" onchange=\"window.location.href='main2.php?page=editimeiservice.assignprovider&id=";
echo $id;
echo "&country='+this.value\"><option>";
echo $LNG["select"];
echo " </option>\n";
$result = dquery($query);
while ($row = mysqli_fetch_assoc($result)) {
    if ($country == $row["ID"]) {
        $selected = "selected";
    } else {
        $selected = "";
    }
    echo "<option value=" . $row["ID"] . " " . $selected . ">" . $row["Name"] . "</option>";
}
echo "</select><br><br>";
$result = dquery("select ID,Name from tbl_provider where C_ID=" . $country);
if ($result) {
    echo "<table id=\"main_tbl\" style=\"display: table;\">\n<thead>\n              <tr class=\"singletd\">\n                <th> <input value=\"ALL\" class=\"check-all\"  id=\"alls\" name=\"all_provider\" onclick=\"SetAllCheckBoxesS(this)\" type=\"checkbox\"/> <label for=\"alls\"></label></th><th width=\"20px\">";
    echo $LNG["id"];
    echo "</th><th><div align=\"left\">";
    echo $LNG["provider"];
    echo " ";
    echo $LNG["name"];
    echo "</div> </th>\n              </tr>\n            </thead>\n            <tbody>\n";
    $provider = explode(",", $imeiserviceDetails["assigned_provider"]);
    $uncheck = "";
    while ($rowm = mysqli_fetch_assoc($result)) {
        if (in_array($rowm["ID"], $provider)) {
            $checked = "checked";
        } else {
            $checked = "";
        }
        echo "<tr  class='singletd'><td><input \n     onclick='setvals(this);' name=provider_check[" . $rowm["ID"] . "] value='" . $rowm["ID"] . "' \n     type='checkbox' " . $checked . " id='i_" . $rowm["ID"] . "'><label for='i_" . $rowm["ID"] . "'></label></td><td>" . $rowm["ID"] . "</td><td>" . $rowm["Name"] . "</td></tr>";
    }
}
echo "</tbody></table>\n<p class=\"fixedbtn\">\n    <label class=\"btn-label\"><input type=\"checkbox\" name=\"allowprovider\" value=\"1\" />\n    Assign all provider for all allowed countries</label>\n    \n    <input name=\"btnedituser\" value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn save\" type=\"button\"\n    onclick=\"document.getElementById('submitori').submit();\"  />\n</p>\n</form>\n</div></div>\n<br /><br /><br />";
$fileverioncheck = "6.1.0";

?>