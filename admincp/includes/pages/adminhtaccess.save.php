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
$row = mysqli_fetch_assoc(dquery("select * from tbl_admin where id='" . $adminid . "'"));
if ($htconfirm == $htpass && $htconfirm != "") {
    $htpass = base64_decode($htpass, true);
    $htpass = urldecode($htpass);
    $htacess = file_get_contents("../.htaccess");
    if (!strpos($htacess, "AuthUserFile") !== false) {
        $htacess = $htacess . "\n\n" . "AuthName \"Admin Only\"" . "\n" . "AuthType Basic" . "\n" . "AuthName \"Password Protected Area\"" . "\n" . "AuthUserFile " . $_SERVER["DOCUMENT_ROOT"] . "/" . $admindirpath . "/.htpasswd\nRequire valid-user";
        $fh = fopen("../.htaccess", "w+");
        fwrite($fh, $htacess);
        fclose();
    }
    $pwd = "";
    if (is_file(".htpasswd")) {
        $pwd = file_get_contents("../.htpasswd");
        $pwdline = explode("\n", $pwd);
        $flags = true;
        foreach ($pwdline as $p) {
            $up = explode(":", $p);
            if (trim($up[0]) == $row["username"]) {
                $p = $up[0] . ":" . crypt($htpass);
                $flags = false;
            }
            $buff .= $p . "\n";
        }
        if ($flags) {
            $fh = fopen("../.htpasswd", "w+");
            fwrite($fh, $buff . $row["username"] . ":" . crypt($htpass));
            fclose();
        } else {
            $fh = fopen("../.htpasswd", "w+");
            fwrite($fh, $buff);
            fclose();
        }
    } else {
        $fh = fopen("../.htpasswd", "w+");
        fwrite($fh, $row["username"] . ":" . crypt($htpass));
        fclose();
    }
    echo "success: Password set successfully";
} else {
    echo "error: Both field required";
}

?>