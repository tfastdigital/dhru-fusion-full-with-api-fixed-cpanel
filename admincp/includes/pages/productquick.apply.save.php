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
if (!$imei_check) {
    echo "error:" . $LNG["selectanyservice"];
} else {
    foreach ($imei_check as $ids) {
        if ($quickapply == 1) {
            if ($all_imei) {
                dquery("update tbl_products set key_selling=0");
            }
            $data["key_selling"] = 0;
            $db->update("tbl_products", $data, "id='" . $ids . "'");
            $data = NULL;
        } else {
            if ($quickapply == 2) {
                if ($all_imei) {
                    dquery("update tbl_products set show_onhome=1");
                }
                $data["show_onhome"] = 1;
                $db->update("tbl_products", $data, "id='" . $ids . "'");
                $data = NULL;
            } else {
                if ($quickapply == 3) {
                    if ($all_imei) {
                        dquery("update tbl_products set show_onhome=0");
                    }
                    $data["show_onhome"] = 0;
                    $db->update("tbl_products", $data, "id='" . $ids . "'");
                    $data = NULL;
                } else {
                    if ($quickapply == 4) {
                        if ($all_imei) {
                            dquery("update tbl_products set hot=1");
                        }
                        $data["hot"] = 1;
                        $db->update("tbl_products", $data, "id='" . $ids . "'");
                        $data = NULL;
                    } else {
                        if ($quickapply == 5) {
                            if ($all_imei) {
                                dquery("update tbl_products set hot=0");
                            }
                            $data["hot"] = 0;
                            $db->update("tbl_products", $data, "id='" . $ids . "'");
                            $data = NULL;
                        } else {
                            if ($quickapply == 6) {
                                if ($all_imei) {
                                    dquery("update tbl_products set stock_allow=1");
                                }
                                $data["stock_allow"] = 1;
                                $db->update("tbl_products", $data, "id='" . $ids . "'");
                                $data = NULL;
                            } else {
                                if ($quickapply == 7) {
                                    if ($all_imei) {
                                        dquery("update tbl_products set stock_allow=0");
                                    }
                                    $data["stock_allow"] = 0;
                                    $db->update("tbl_products", $data, "id='" . $ids . "'");
                                    $data = NULL;
                                } else {
                                    if ($quickapply == 8) {
                                        if ($all_imei) {
                                            dquery("update tbl_products set happy_hours_weekdays='',happy_hours_start='',\n                happy_hours_end='',promotiondis=0,happy_hours_repetation=''");
                                        }
                                        $data["happy_hours_weekdays"] = "";
                                        $data["happy_hours_start"] = "";
                                        $data["happy_hours_end"] = "";
                                        $data["promotiondis"] = $promotional = "0";
                                        $data["happy_hours_repetation"] = "";
                                        $db->update("tbl_products", $data, "id='" . $ids . "'");
                                        $data = NULL;
                                    } else {
                                        if ($quickapply == 11) {
                                            if ($all_imei) {
                                                dquery("update tbl_products set review='1'");
                                            }
                                            $data["review"] = "1";
                                            $db->update("tbl_products", $data, "id='" . $ids . "'");
                                            $data = NULL;
                                        } else {
                                            if ($quickapply == 12) {
                                                if ($all_imei) {
                                                    dquery("update tbl_products set review='0'");
                                                }
                                                $data["review"] = "0";
                                                $db->update("tbl_products", $data, "id='" . $ids . "'");
                                                $data = NULL;
                                            } else {
                                                if ($quickapply == 13) {
                                                    $data["taxed"] = "1";
                                                    $db->update("tbl_products", $data, "id='" . $ids . "'");
                                                    $data = NULL;
                                                } else {
                                                    if ($quickapply == 14) {
                                                        $data["taxed"] = "0";
                                                        $db->update("tbl_products", $data, "id='" . $ids . "'");
                                                        $data = NULL;
                                                    } else {
                                                        if ($quickapply == 16) {
                                                            $data["store"] = "1";
                                                            $db->update("tbl_products", $data, "id='" . $ids . "'");
                                                            $data = NULL;
                                                        } else {
                                                            if ($quickapply == 17) {
                                                                $data["store"] = "0";
                                                                $db->update("tbl_products", $data, "id='" . $ids . "'");
                                                                $data = NULL;
                                                            } else {
                                                                if ($quickapply == 15) {
                                                                    if ($removetype == 1) {
                                                                        dquery("UPDATE tbl_products set active='2' where id='" . $ids . "'");
                                                                    } else {
                                                                        dquery("DELETE FROM tbl_products WHERE id='" . $ids . "'");
                                                                        dquery("DELETE FROM tbl_product_credit WHERE service_id='" . $ids . "'");
                                                                        if ($remorder) {
                                                                            dquery("DELETE FROM tbl_order_product WHERE service_id='" . $ids . "'");
                                                                        }
                                                                        dquery("DELETE FROM tbl_discount_product WHERE service_id='" . $ids . "'");
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
    if ($all_imei && $quickapply == 1) {
        dquery("UPDATE  `tbl_products` SET `API_ID`='',`API`=''");
    }
    echo "success:" . $LNG["datasavesuccessfully"];
}
unset($grp);
unset($imei_check);
echo " ";

?>