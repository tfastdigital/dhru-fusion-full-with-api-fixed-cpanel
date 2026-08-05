<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DHRUSOFT") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function installadmin($pagetitle, $pageicon, $_nav, $userno = "")
{
    global $config;
    global $smarty;
    global $currentpage;
    global $_nav;
    global $admindirpath;
    global $LNG;
    include_once ROOTDIR . "/includes/smarty/Smarty.class.php";
    $smarty = new SmartyBC();
    $smarty->caching = 0;
    $smarty->template_dir = ROOTDIR . "/templates/";
    $smarty->compile_dir = ROOTDIR . "/" . $config["config_template_c"];
    $filename = $_SERVER["PHP_SELF"];
    $filename = substr($filename, strrpos($filename, "/"));
    $filename = str_replace("/", "", $filename);
    $filename = explode(".", $filename);
    $filename = $filename[0];
    $smarty->assign("page", $filename);
    $smarty->assign("template", $_SESSION["admin_template"]);
    $smarty->assign("adminurl", $config["site_address"] . "/" . $admindirpath . "/");
    $smarty->assign("lang", $LNG);
}
function AdminAreaProcessTemplate($templatefile)
{
    global $config;
    global $smarty;
    global $tempalte_ver;
    global $admindirpath;
    if ($tempalte_ver) {
        foreach ($tempalte_ver as $value => $value) {
            $smarty->assign($key, $value);
        }
    }
    $body_file = $smarty->fetch(ROOTDIR . "/" . $admindirpath . "/templates/" . $_SESSION["admin_template"] . "/" . $templatefile . ".tpl");
    return $body_file;
}

?>