<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($save_token != sha1(session_id() . $_SESSION["adminid"] . ":SaveMe123122sds2")) {
    exit("error:invalid token");
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($_POST["status"]) {
    $status = 1;
} else {
    $status = 0;
}
if ($username || $password) {
    if ($username) {
        if ($password) {
            $data["username"] = $username;
            $check = mysqli_num_rows(dquery("SELECT username FROM tbl_admin where username='" . $username . "'"));
            if ($check != 0) {
                echo "error:" . $LNG["username"] . " " . $LNG["already"] . " " . $LNG["exists"];
                exit;
            }
            if ($password) {
                $data["password"] = md5(md5($password) . "9486");
            }
            $data["group_id"] = $group_name;
            $data["status"] = $status;
            $data["language"] = $language;
            $data["template"] = $template;
            $data["firstname"] = $firstname;
            $data["lastname"] = $lastname;
            $data["email"] = $email;
            $data["contact"] = $contact;
            if ($db->insert("tbl_admin", $data)) {
                echo "success:" . $LNG["datasavesuccessfully"];
            } else {
                echo "error:" . $LNG["datanotsave"];
            }
        } else {
            echo "error:" . $LNG["password"] . " " . $LNG["required"];
        }
    } else {
        echo "error:" . $LNG["username"] . " " . $LNG["required"];
    }
} else {
    echo "error:" . $LNG["username"] . " " . $LNG["and"] . " " . $LNG["password"] . " " . $LNG["required"];
}

?>