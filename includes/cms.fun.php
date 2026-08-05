<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DHRUSOFT") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function GiveMeDoctype()
{
    $query = "SELECT value FROM tbl_cms_settings WHERE setting='doctype'";
    $result1 = dquery($query);
    $mrdoctype = mysqli_result($result1, 0);
    return $mrdoctype;
}
function mysqli_result($res, $row = 0, $col = 0)
{
    $numrows = mysqli_num_rows($res);
    if ($numrows && $row <= $numrows - 1 && 0 <= $row) {
        mysqli_data_seek($res, $row);
        $resrow = is_numeric($col) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])) {
            return $resrow[$col];
        }
    }
    return false;
}
function GiveMeSeo()
{
    $query = "SELECT value FROM tbl_cms_settings WHERE setting='seofriendly'";
    $result1 = dquery($query);
    $mrseo = mysqli_result($result1, 0);
    return $mrseo;
}
function GiveMe404()
{
    $query = "SELECT value FROM tbl_cms_settings WHERE setting='error404'";
    $result1 = dquery($query);
    $mr404 = mysqli_result($result1, 0);
    return $mr404;
}
function defaultLanguage()
{
    $sql = "SELECT `value` FROM `tblconfiguration` WHERE `setting` = 'Language' LIMIT 1";
    $lang = mysqli_fetch_row(dquery($sql));
    $lang = !$lang[0] ? "english" : strtolower($lang[0]);
    return $lang;
}
function cms_getstock($method, $get)
{
    return false;
}

?>