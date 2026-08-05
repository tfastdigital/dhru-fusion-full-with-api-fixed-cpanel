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
    echo "error: This function not enabled in demo mode.";
    exit;
}
if ($next) {
    if (!$campid) {
        $ca = mysqli_fetch_assoc(dquery("select id from tbl_campaign order by id desc"));
        $campid = $ca["id"];
    }
    $user["users"] = $users;
    $user["usertype"] = $usertype;
    $user["userstatus"] = $userstatus;
    $user["unsubscriber"] = $unsubscriber;
    $user["clientgroup"] = $clientgroup;
    $data["users"] = json_encode($user);
    $data["status"] = "publish";
    $db->update("tbl_campaign", $data, "id=" . $campid);
    if ($users == 1) {
        $where = " 1=1 ";
        if ($usertype) {
            $where .= " and usertype=" . $usertype;
        }
        if ($userstatus == 2) {
            $where .= " and userstatus=2";
        }
        if ($userstatus == 1) {
            $where .= " and userstatus=0";
        }
        if ($clientgroup) {
            $where .= " and client_group='" . $clientgroup . "'";
        }
        if ($unsubscriber) {
            $where .= " and news_letter=1";
        }
        $cnt = 0;
        $q = dquery("select * from tblUsers where " . $where);
        while ($r = mysqli_fetch_assoc($q)) {
            $cnt++;
            $datas["campaignid"] = $campid;
            $datas["email"] = $r["email"];
            $datas["userid"] = $r["id"];
            $datas["date"] = date("Y-m-d");
            $id = $db->insert("tbl_campaign_users", $datas);
            $md5id = md5($id);
            dquery("UPDATE tbl_campaign_users set md5id='" . $md5id . "' where id='" . $id . "'");
            $datas = NULL;
        }
        $data = NULL;
        $data["total"] = $cnt;
        $db->update("tbl_campaign", $data, "id=" . $campid);
    } else {
        $q = dquery("select * from tbl_newsletter");
        $cnt = 0;
        while ($r = mysqli_fetch_assoc($q)) {
            $datas["campaignid"] = $campid;
            $datas["email"] = $r["email"];
            $datas["date"] = date("Y-m-d");
            $id = $db->insert("tbl_campaign_users", $datas);
            $md5id = md5($id);
            dquery("UPDATE tbl_campaign_users set md5id='" . $md5id . "' where id='" . $id . "'");
            $cnt++;
            $datas = NULL;
        }
        $data = NULL;
        $data["total"] = $cnt;
        $db->update("tbl_campaign", $data, "id=" . $campid);
    }
    if ($edit) {
        echo "callfunction2:campaign&publish=1";
    } else {
        echo "callfunction2:campaignmain&laoddefaultpage=campaign.php:&publish=1";
    }
}

?>