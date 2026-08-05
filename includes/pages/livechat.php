<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "comm.php";
require "includes/fun.inc.php";
require "includes/client.area.inc.php";
$step2 = NULL;
$step3 = NULL;
$pagetitle = "Live Help!";
$department = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $department);
installclient($pagetitle, $pageicon, $_nav);
$status = "Offline";
$sql = dquery("select * from tbl_support_department where status='1' AND `livehelp`=1");
while ($row = mysqli_fetch_assoc($sql)) {
    $online = mysqli_num_rows(dquery("select id from tbl_admin where online='1' and\n         (chatdepartment like '%," . $row["id"] . ",%' or chatdepartment like '" . $row["id"] . ",%' OR chatdepartment like '%,\n         " . $row["id"] . "' OR chatdepartment='" . $row["id"] . "') and onlinestatus='available'"));
    if ($online) {
        $status = "Online";
    }
}
if ($status == "Offline") {
    $tempalte_ver["error"] = "All departments are offline please submit Ticket";
}
if ($start) {
    if ($name != "" && $email != "" && $subject != "" && $message != "") {
        $flag = true;
        if (!preg_match("/^[a-zA-Z\\s]+\$/", $name)) {
            $tempalte_ver["error"] = "Name is not valid";
            $flag = false;
        } else {
            if (!preg_match("/^[a-zA-Z0-9\\s]+\$/", $subject)) {
                $tempalte_ver["error"] = "Subject is not valid";
                $flag = false;
            } else {
                if (!preg_match("/^([a-zA-Z0-9])+([\\.a-zA-Z0-9+_-])*@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)*\\.([a-zA-Z]{2,6})\$/", $email)) {
                    $tempalte_ver["error"] = "Email is not valid";
                    $flag = false;
                }
            }
        }
        if ($flag) {
            $sql = dquery("select id from tbl_admin where online='1' and onlinestatus='available' and\n         (chatdepartment like '%," . $department . ",%' or chatdepartment like '" . $department . ",%' OR chatdepartment like '%,\n         " . $department . "' OR chatdepartment='" . $department . "')");
            if (mysqli_num_rows($sql)) {
                $step2 = true;
            } else {
                $step3 = true;
            }
        }
    } else {
        $tempalte_ver["error"] = "(*) field is required.";
    }
}
if ($step3) {
    require_once ROOTDIR . "/includes/mail.fun.php";
    require_once ROOTDIR . "/includes/support.fun.php";
    $ticket["subject"] = $subject;
    $ticket["message"] = $message;
    $tid = ticket("", "", "", $name, $email, $department, 2, $ticket);
    $tempalte_ver["success"] = "Offline Ticket Created #" . $tid;
    $sql = dquery("select * from tbl_support_department where status='1' AND `livehelp`=1");
    $departmentdropdown = "<select name='department' class='form-control'>";
    while ($row = mysqli_fetch_assoc($sql)) {
        $online = mysqli_num_rows(dquery("select id from tbl_admin where online='1' and\n     (chatdepartment like '%," . $row["id"] . ",%' or chatdepartment like '" . $row["id"] . ",%' OR chatdepartment like '%," . $row["id"] . "' OR chatdepartment='" . $row["id"] . "') and onlinestatus='available'"));
        if ($online) {
            $status = "Online";
        } else {
            $status = "Offline";
        }
        $departmentdropdown .= "<option value='" . $row["id"] . "' class='select" . $status . "'>" . $row["department"] . " - " . $status . "</option>";
    }
    $templatefile = "step1";
    $departmentdropdown .= "</select>";
    $tempalte_ver["department"] = $departmentdropdown;
    $tempalte_ver["name"] = "<input type='text' class='form-control' placeholder='Full Name' name='name' />";
    $tempalte_ver["email"] = "<input type='text' class='form-control' placeholder='Email'  name='email' />";
    $tempalte_ver["subject"] = "<input type='text' class='form-control' placeholder='Subject'  name='subject' />";
    $tempalte_ver["message"] = "<textarea name='message' rows='5'  placeholder='Your Question' class='form-control'></textarea>";
    $tempalte_ver["action"] = "<input type='submit' class='btn btn-primary' name='start' value='Start Chat' />";
} else {
    if ($step2) {
        $data = NULL;
        $templatefile = "step2";
        $data["department"] = $department;
        $data["name"] = $name;
        $data["email"] = $email;
        $data["subject"] = $subject;
        $data["message"] = $message;
        $data["time"] = time();
        $data["ip"] = $remote_ip;
        $chatid = $db->insert("tbl_livehelp_conversation", $data);
        $data = NULL;
        $tempalte_ver["chatid"] = "<input type='hidden' id='chatid' name='chatid' value='" . md5($chatid) . "' />";
        $tempalte_ver["subject"] = "<input type='text' name='subject' />";
        $tempalte_ver["message"] = "<textarea name='message'></textarea>";
        $tempalte_ver["action"] = "<input type='submit' name='start' value='Start Chat' />";
    } else {
        $sql = dquery("select * from tbl_support_department where status='1' AND `livehelp`=1");
        $departmentdropdown = "<select name='department' class='form-control'>";
        while ($row = mysqli_fetch_assoc($sql)) {
            $online = mysqli_num_rows(dquery("select id from tbl_admin where online='1' and\n     (chatdepartment like '%," . $row["id"] . ",%' or chatdepartment like '" . $row["id"] . ",%' OR chatdepartment like '%," . $row["id"] . "' OR chatdepartment='" . $row["id"] . "') and onlinestatus='available'"));
            if ($online) {
                $status = "Online";
            } else {
                $status = "Offline";
            }
            $departmentdropdown .= "<option value='" . $row["id"] . "' class='select" . $status . "'>" . $row["department"] . " - " . $status . "</option>";
        }
        $templatefile = "step1";
        $departmentdropdown .= "</select>";
        $tempalte_ver["department"] = $departmentdropdown;
        $tempalte_ver["name"] = "<input type='text' class='form-control' placeholder='Full Name' name='name' />";
        $tempalte_ver["email"] = "<input type='text' class='form-control' placeholder='Email'  name='email' />";
        $tempalte_ver["subject"] = "<input type='text' class='form-control' placeholder='Subject'  name='subject' />";
        $tempalte_ver["message"] = "<textarea name='message' rows='5'  placeholder='Your Question' class='form-control'></textarea>";
        $tempalte_ver["action"] = "<input type='submit' class='btn btn-primary' name='start' value='Start Chat' />";
    }
}
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile, "livehelp");
chkMd5sumsubpage();
class no
{
}

?>