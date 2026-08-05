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
if ($next == 3) {
    if (!$campid) {
        $ca = mysqli_fetch_assoc(dquery("select id from tbl_campaign order by id desc"));
        $campid = $ca["id"];
    }
    if ($campid) {
        $user["users"] = $users;
        $user["usertype"] = $usertype;
        $user["userstatus"] = $userstatus;
        $user["clientgroup"] = $clientgroup;
        $user["unsubscriber"] = $unsubscriber;
        $data["users"] = json_encode($user);
        if ($edit) {
            $db->update("tbl_campaign", $data, "id=" . $campid);
            echo "success: Updated successfully";
        } else {
            $db->update("tbl_campaign", $data, "id=" . $campid);
            echo "callfunction2:campaignmain&laoddefaultpage=campaign.php:&campid=" . $campid . "&next=4";
        }
    }
} else {
    if ($next == 2) {
        if ($title) {
            $data["title"] = $title;
            $data["subject"] = $subject;
            $data["message"] = base64_encode($email);
            $data["createdby"] = $_SESSION["adminid"];
            $data["date"] = date("Y-m-d");
            $data["status"] = "draft";
            $data["mailserver"] = $mailserver;
            if ($edit) {
                $campid = $db->update("tbl_campaign", $data, "id='" . $edit . "'");
                echo "callfunction2:campaign&campid=" . $edit . "&next=3&edit=" . $edit;
            } else {
                $campid = $db->insert("tbl_campaign", $data);
                echo "callfunction2:campaignmain&laoddefaultpage=campaign.php:&campid=" . $edit . "&next=3";
            }
        } else {
            echo "error: Campaign name required";
        }
    } else {
        if ($next == 1) {
            if ($template) {
                $temp = mysqli_fetch_assoc(dquery("select * from tbl_emailtemplates where id='" . $template . "'"));
                if ($temp[layoutid]) {
                    $layout = mysqli_fetch_assoc(dquery("select * from tbl_email_layout where id='" . $temp["layoutid"] . "'"));
                }
            }
            echo "callfunction2:campaignmain&laoddefaultpage=campaign.php:&template=" . $template . "&layout=" . $layout . "&next=2";
        } else {
            echo "error: Field required";
        }
    }
}

?>