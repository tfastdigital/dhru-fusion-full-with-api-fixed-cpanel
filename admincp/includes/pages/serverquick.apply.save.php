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
if (!$server_check && $apply) {
    echo "error:" . $LNG["selectanyservice"];
} else {
    foreach ($server_check as $ids) {
        if ($apply == 1) {
            $data["API_ID"] = "";
            $data["API"] = "";
            $db->update("tbl_server_log", $data, "id='" . $ids . "'");
            $data = NULL;
        } else {
            if ($apply == 2) {
                $data["retail"] = 1;
                $db->update("tbl_server_log", $data, "id='" . $ids . "'");
                $data = NULL;
            } else {
                if ($apply == 3) {
                    $data["retail"] = 0;
                    $db->update("tbl_server_log", $data, "id='" . $ids . "'");
                    $data = NULL;
                } else {
                    if ($apply == 4) {
                        $data["notificationemail"] = 1;
                        $db->update("tbl_server_log", $data, "id='" . $ids . "'");
                        $data = NULL;
                    } else {
                        if ($apply == 5) {
                            $data["notificationemail"] = 0;
                            $db->update("tbl_server_log", $data, "id='" . $ids . "'");
                            $data = NULL;
                        } else {
                            if ($apply == 6) {
                                $data["smsnotification"] = 1;
                                $db->update("tbl_server_log", $data, "id='" . $ids . "'");
                                $data = NULL;
                            } else {
                                if ($apply == 7) {
                                    $data["smsnotification"] = 0;
                                    $db->update("tbl_server_log", $data, "id='" . $ids . "'");
                                    $data = NULL;
                                } else {
                                    if ($apply == 10) {
                                        $data["discount"] = "0";
                                        $db->update("tbl_discount_server_log", $data, "service_id='" . $ids . "'");
                                        $data = NULL;
                                    } else {
                                        if ($apply == 11) {
                                            $data["review"] = "1";
                                            $db->update("tbl_server_log", $data, "id='" . $ids . "'");
                                            $data = NULL;
                                        } else {
                                            if ($apply == 12) {
                                                $data["review"] = "0";
                                                $db->update("tbl_server_log", $data, "id='" . $ids . "'");
                                                $data = NULL;
                                            } else {
                                                if ($apply == 13) {
                                                    $data["taxed"] = "1";
                                                    $db->update("tbl_server_log", $data, "id='" . $ids . "'");
                                                    $data = NULL;
                                                } else {
                                                    if ($apply == 14) {
                                                        $data["taxed"] = "0";
                                                        $db->update("tbl_server_log", $data, "id='" . $ids . "'");
                                                        $data = NULL;
                                                    } else {
                                                        if ($apply == 16) {
                                                            $data["store"] = "1";
                                                            $db->update("tbl_server_log", $data, "id='" . $ids . "'");
                                                            $data = NULL;
                                                        } else {
                                                            if ($apply == 17) {
                                                                $data["store"] = "0";
                                                                $db->update("tbl_server_log", $data, "id='" . $ids . "'");
                                                                $data = NULL;
                                                            } else {
                                                                if ($apply == 15) {
                                                                    if ($removetype == 1) {
                                                                        dquery("UPDATE tbl_server_log set active='2' where id='" . $ids . "'");
                                                                    } else {
                                                                        dquery("DELETE FROM tbl_server_log WHERE id='" . $ids . "'");
                                                                        dquery("DELETE FROM tbl_server_credit WHERE service_id='" . $ids . "'");
                                                                        if ($remorder) {
                                                                            dquery("DELETE FROM tbl_order_server WHERE service_id='" . $ids . "'");
                                                                        }
                                                                        if ($remclient) {
                                                                            dquery("DELETE FROM tbl_client_group_price WHERE service_id='" . $ids . "' \n                    AND service_type='server'");
                                                                        }
                                                                        dquery("DELETE FROM tbl_discount_server_log WHERE service_id='" . $ids . "'");
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    echo "success:" . $LNG["datasavesuccessfully"];
}
unset($grp);
unset($server_check);

?>