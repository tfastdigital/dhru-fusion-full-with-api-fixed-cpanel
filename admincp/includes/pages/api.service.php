<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
$s = dquery("select * from \n                 tbl_services_imei where \n                 (model='1' OR `provider`='1' OR `mep`='1') AND `active`='1'");
$flag = 0;
$brnd = [];
$modl = [];
$flag2 = 0;
$brnd2 = [];
$modl2 = [];
$cntmep = [];
while ($r = mysqli_fetch_assoc($s)) {
    if ($r["model"] == 1) {
        if ($r["assigned_brand"] == "ALL" || $r["assigned_brand"] == "") {
            $flag = 1;
            $BRAND = mysqli_num_rows(dquery("select ID from  tbl_model_brand"));
            $MODEL = mysqli_num_rows(dquery("select ID from  tbl_mobile"));
        } else {
            if ($r["assigned_model"] == "ALL" || $r["assigned_model"] == "") {
                $exp = explode(",", $r["assigned_brand"]);
                foreach ($exp as $e) {
                    $MODEL = $MODEL + mysqli_num_rows(dquery("select ID from tbl_mobile where B_ID='" . $e . "'"));
                }
            }
        }
        if ($r["assigned_brand"] && $r["assigned_brand"] != "ALL" && $r["assigned_brand"] != "") {
            $brnd = array_merge($brnd, explode(",", $r["assigned_brand"]));
            $brnd = array_unique($brnd);
        }
        if ($r["assigned_model"] && $r["assigned_model"] != "ALL" && $r["assigned_model"] != "") {
            $modl = array_merge($modl, explode(",", $r["assigned_model"]));
            $modl = array_unique($modl);
        }
    }
    if ($r["provider"] == 1) {
        if ($r["assigned_country"] == "ALL" || $r["assigned_country"] == "") {
            $flag2 = 1;
            $BRAND2 = mysqli_num_rows(dquery("select ID from  tbl_provider_country"));
            $MODEL2 = mysqli_num_rows(dquery("select ID from  tbl_provider"));
        } else {
            if ($r["assigned_provider"] == "ALL" || $r["assigned_provider"] == "") {
                $exp = explode(",", $r["assigned_country"]);
                foreach ($exp as $e) {
                    $MODEL2 = $MODEL2 + mysqli_num_rows(dquery("select ID from tbl_provider where C_ID='" . $e . "'"));
                }
            }
        }
        if ($r["assigned_country"] && $r["assigned_country"] != "ALL" && $r["assigned_country"] != "") {
            $brnd2 = array_merge($brnd2, explode(",", $r["assigned_country"]));
            $brnd2 = array_unique($brnd2);
        }
        if ($r["assigned_provider"] && $r["assigned_provider"] != "ALL" && $r["assigned_provider"] != "") {
            $modl2 = array_merge($modl2, explode(",", $r["assigned_provider"]));
            $modl2 = array_unique($modl2);
        }
    }
    if ($r["mep"]) {
        if ($r["assigned_mep"] == "ALL" || $r["assigned_mep"] == "") {
            $MEP += mysqli_num_rows(dquery("select id from  tbl_mep"));
        } else {
            if ($r["assigned_mep"]) {
                $cntmep = array_merge($cntmep, explode(",", $r["assigned_mep"]));
                $cntmep = array_unique($cntmep);
            }
        }
    }
}
echo "<style>\n.boxer{\n    width: 15px;\n    height: 15px;\n    background-color: red;\n    text-align: center;\n}\n.cls{\n    border: 1px solid #ccc;\n    padding : 10px;\n    background:white;\n    font-family: arial;\n    font-size: 15px;\n    margin-bottom:10px;\n}\n</style>\n";
if (!$MEP) {
    $MEP = count($cntmep);
}
if ($flag == 0) {
    $BRAND = $BRAND + count($brnd);
    $MODEL = $MODEL + count($modl);
}
if ($flag2 == 0) {
    $BRAND2 = $BRAND2 + count($brnd2);
    $MODEL2 = $MODEL2 + count($modl2);
}
if (40000 < $BRAND + $MODEL) {
    echo "<div id='notification1' class='info errorbox'>Your brand and models list is too large to synchronize</div>";
}
if (40000 < $BRAND2 + $MODEL2) {
    echo "<div id='notification1' class='info errorbox'>Your Country and Providers list is too large to synchronize</div>";
}
echo "<div id='notification1' class='info'>\n    While your client synchronize with your system they will list total <br />\n    Brand : " . $BRAND . " <br />";
echo "Model : " . $MODEL . " <br /> Country : " . $BRAND2 . " <br /> Provider : " . $MODEL2 . "  <br /> MEP : " . $MEP . " </div>";
include DATAGRID_DIR . "comm.php";
$sql = "SELECT id,\nCONCAT( '<a class=\\'default_dg_a\\' href=\"javascript:redirectedit(\\'editimeiservice\\', ',tbl_services_imei.id,')\">',service_name,'</a>' )  AS service_name,\nIF(model=1 AND (assigned_model='' OR assigned_model='ALL') ,'<div class=\"boxer\">&nbsp</div>','-') as models\n,IF(model=1 AND (assigned_brand='' OR assigned_brand='ALL') ,'<div class=\"boxer\">&nbsp</div>','-') as brands\n,IF(provider=1 AND (assigned_country='' OR assigned_country='ALL') ,'<div class=\"boxer\">&nbsp</div>','-') as countrys\n,IF(provider=1 AND (assigned_provider='' OR assigned_provider='ALL') ,'<div class=\"boxer\">&nbsp</div>','-') as providers\n,IF(mep=1 AND (assigned_mep='' OR assigned_mep='ALL') ,'<div class=\"boxer\">&nbsp</div>','-') as meps\n\n FROM tbl_services_imei\n\nWHERE \n(\n(mep=1 AND (assigned_mep='' OR assigned_mep='ALL'))\nOR (model=1 AND (assigned_model='' OR assigned_model='ALL' OR assigned_brand='' OR assigned_brand='ALL'))\nOR (provider=1 AND (assigned_country='' OR assigned_country='ALL' OR assigned_provider='' OR assigned_provider='ALL'))\n)\n";
if (mysqli_num_rows(dquery($sql))) {
    echo "<div class='cls'>Below services has not assigned brand/models and country/provider .</div>";
}
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = false;
}
$messaging = true;
$unique_prefix = "";
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
$default_order_field = "id";
$default_order_type = "ASC";
$dgrid->DataSource($db_conn, $sql, $default_order_field, $default_order_type);
$ajax_option = true;
$dgrid->AllowAjax($ajax_option);
$layouts = ["edit" => "0", "details" => "0", "filter" => "1"];
$dgrid->SetLayouts($layouts);
$modes = ["add" => ["view" => false, "edit" => false, "type" => "link", "show_add_button" => "inside|outside"], "edit" => ["view" => false, "edit" => false, "type" => "link", "byFieldValue" => ""], "cancel" => ["view" => false, "edit" => true, "type" => "link"], "details" => ["view" => false, "edit" => false, "type" => "link"], "delete" => ["view" => false, "edit" => true, "type" => "image"]];
$dgrid->SetModes($modes);
$dgrid->safeMode = false;
$multirow_option = true;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false]];
$dgrid->SetMultirowOperations($multirow_operations);
$http_get_vars = ["page", "accesskey", "display_errors", "pass", "id", "laoddefaultpage"];
$dgrid->SetHttpGetVars($http_get_vars);
$dg_caption = "";
$dgrid->SetCaption($dg_caption);
$printing_option = true;
$dgrid->AllowPrinting($printing_option);
$exporting_option = true;
$exporting_directory = "tmp/";
$dgrid->AllowExporting($exporting_option, $exporting_directory);
$exporting_types = ["excel" => "true", "pdf" => "true", "xml" => "true"];
$dgrid->AllowExportingTypes($exporting_types);
$paging_option = true;
$rows_numeration = false;
$numeration_sign = "N #";
$dropdown_paging = true;
$dgrid->AllowPaging($paging_option, $rows_numeration, $numeration_sign, $dropdown_paging);
$bottom_paging = ["results" => true, "results_align" => "left", "pages" => true, "pages_align" => "center", "page_size" => true, "page_size_align" => "right"];
$top_paging = [];
$pages_array = ["5" => "5", "10" => "10", "25" => "25", "50" => "50", "100" => "100", "250" => "250", "500" => "500", "1000" => "1000"];
$default_page_size = 500;
$paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
$filtering_option = false;
$show_search_type = false;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$filtering_fields = ["ID" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_services_imei", "field" => "id", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "service_name" => ["header" => (string) $LNG["service"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "models" => ["header" => (string) $LNG["model"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "brands" => ["header" => (string) $LNG["brand"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "countrys" => ["header" => (string) $LNG["country"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "providers" => ["header" => (string) $LNG["provider"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "meps" => ["header" => (string) $LNG["mep"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_services_imei";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
$fileverioncheck = "6.1.0";

?>