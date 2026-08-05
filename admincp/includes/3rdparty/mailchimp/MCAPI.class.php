<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class MCAPI
{
    public $version = "1.3";
    public $errorMessage = NULL;
    public $errorCode = NULL;
    public $apiUrl = NULL;
    public $timeout = 300;
    public $chunkSize = 8192;
    public $api_key = NULL;
    public $secure = false;
    public function __construct($apikey, $secure = false)
    {
        $this->secure = $secure;
        $this->apiUrl = parse_url("http://api.mailchimp.com/" . $this->version . "/?output=php");
        $this->api_key = $apikey;
    }
    public function setTimeout($seconds)
    {
        if (is_int($seconds)) {
            $this->timeout = $seconds;
            return true;
        }
    }
    public function getTimeout()
    {
        return $this->timeout;
    }
    public function useSecure($val)
    {
        if ($val === true) {
            $this->secure = true;
        } else {
            $this->secure = false;
        }
    }
    public function campaignUnschedule($cid)
    {
        $params = [];
        $params["cid"] = $cid;
        return $this->callServer("campaignUnschedule", $params);
    }
    public function campaignSchedule($cid, $schedule_time, $schedule_time_b = NULL)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["schedule_time"] = $schedule_time;
        $params["schedule_time_b"] = $schedule_time_b;
        return $this->callServer("campaignSchedule", $params);
    }
    public function campaignResume($cid)
    {
        $params = [];
        $params["cid"] = $cid;
        return $this->callServer("campaignResume", $params);
    }
    public function campaignPause($cid)
    {
        $params = [];
        $params["cid"] = $cid;
        return $this->callServer("campaignPause", $params);
    }
    public function campaignSendNow($cid)
    {
        $params = [];
        $params["cid"] = $cid;
        return $this->callServer("campaignSendNow", $params);
    }
    public function campaignSendTest($cid, $test_emails = [], $send_type = NULL)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["test_emails"] = $test_emails;
        $params["send_type"] = $send_type;
        return $this->callServer("campaignSendTest", $params);
    }
    public function campaignSegmentTest($list_id, $options)
    {
        $params = [];
        $params["list_id"] = $list_id;
        $params["options"] = $options;
        return $this->callServer("campaignSegmentTest", $params);
    }
    public function campaignCreate($type, $options, $content, $segment_opts = NULL, $type_opts = NULL)
    {
        $params = [];
        $params["type"] = $type;
        $params["options"] = $options;
        $params["content"] = $content;
        $params["segment_opts"] = $segment_opts;
        $params["type_opts"] = $type_opts;
        return $this->callServer("campaignCreate", $params);
    }
    public function campaignUpdate($cid, $name, $value)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["name"] = $name;
        $params["value"] = $value;
        return $this->callServer("campaignUpdate", $params);
    }
    public function campaignReplicate($cid)
    {
        $params = [];
        $params["cid"] = $cid;
        return $this->callServer("campaignReplicate", $params);
    }
    public function campaignDelete($cid)
    {
        $params = [];
        $params["cid"] = $cid;
        return $this->callServer("campaignDelete", $params);
    }
    public function campaigns($filters = [], $start = 0, $limit = 25)
    {
        $params = [];
        $params["filters"] = $filters;
        $params["start"] = $start;
        $params["limit"] = $limit;
        return $this->callServer("campaigns", $params);
    }
    public function campaignStats($cid)
    {
        $params = [];
        $params["cid"] = $cid;
        return $this->callServer("campaignStats", $params);
    }
    public function campaignClickStats($cid)
    {
        $params = [];
        $params["cid"] = $cid;
        return $this->callServer("campaignClickStats", $params);
    }
    public function campaignEmailDomainPerformance($cid)
    {
        $params = [];
        $params["cid"] = $cid;
        return $this->callServer("campaignEmailDomainPerformance", $params);
    }
    public function campaignMembers($cid, $status = NULL, $start = 0, $limit = 1000)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["status"] = $status;
        $params["start"] = $start;
        $params["limit"] = $limit;
        return $this->callServer("campaignMembers", $params);
    }
    public function campaignHardBounces($cid, $start = 0, $limit = 1000)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["start"] = $start;
        $params["limit"] = $limit;
        return $this->callServer("campaignHardBounces", $params);
    }
    public function campaignSoftBounces($cid, $start = 0, $limit = 1000)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["start"] = $start;
        $params["limit"] = $limit;
        return $this->callServer("campaignSoftBounces", $params);
    }
    public function campaignUnsubscribes($cid, $start = 0, $limit = 1000)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["start"] = $start;
        $params["limit"] = $limit;
        return $this->callServer("campaignUnsubscribes", $params);
    }
    public function campaignAbuseReports($cid, $since = NULL, $start = 0, $limit = 500)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["since"] = $since;
        $params["start"] = $start;
        $params["limit"] = $limit;
        return $this->callServer("campaignAbuseReports", $params);
    }
    public function campaignAdvice($cid)
    {
        $params = [];
        $params["cid"] = $cid;
        return $this->callServer("campaignAdvice", $params);
    }
    public function campaignAnalytics($cid)
    {
        $params = [];
        $params["cid"] = $cid;
        return $this->callServer("campaignAnalytics", $params);
    }
    public function campaignGeoOpens($cid)
    {
        $params = [];
        $params["cid"] = $cid;
        return $this->callServer("campaignGeoOpens", $params);
    }
    public function campaignGeoOpensForCountry($cid, $code)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["code"] = $code;
        return $this->callServer("campaignGeoOpensForCountry", $params);
    }
    public function campaignEepUrlStats($cid)
    {
        $params = [];
        $params["cid"] = $cid;
        return $this->callServer("campaignEepUrlStats", $params);
    }
    public function campaignBounceMessage($cid, $email)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["email"] = $email;
        return $this->callServer("campaignBounceMessage", $params);
    }
    public function campaignBounceMessages($cid, $start = 0, $limit = 25, $since = NULL)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["start"] = $start;
        $params["limit"] = $limit;
        $params["since"] = $since;
        return $this->callServer("campaignBounceMessages", $params);
    }
    public function campaignEcommOrders($cid, $start = 0, $limit = 100, $since = NULL)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["start"] = $start;
        $params["limit"] = $limit;
        $params["since"] = $since;
        return $this->callServer("campaignEcommOrders", $params);
    }
    public function campaignShareReport($cid, $opts = [])
    {
        $params = [];
        $params["cid"] = $cid;
        $params["opts"] = $opts;
        return $this->callServer("campaignShareReport", $params);
    }
    public function campaignContent($cid, $for_archive = true)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["for_archive"] = $for_archive;
        return $this->callServer("campaignContent", $params);
    }
    public function campaignTemplateContent($cid)
    {
        $params = [];
        $params["cid"] = $cid;
        return $this->callServer("campaignTemplateContent", $params);
    }
    public function campaignOpenedAIM($cid, $start = 0, $limit = 1000)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["start"] = $start;
        $params["limit"] = $limit;
        return $this->callServer("campaignOpenedAIM", $params);
    }
    public function campaignNotOpenedAIM($cid, $start = 0, $limit = 1000)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["start"] = $start;
        $params["limit"] = $limit;
        return $this->callServer("campaignNotOpenedAIM", $params);
    }
    public function campaignClickDetailAIM($cid, $url, $start = 0, $limit = 1000)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["url"] = $url;
        $params["start"] = $start;
        $params["limit"] = $limit;
        return $this->callServer("campaignClickDetailAIM", $params);
    }
    public function campaignEmailStatsAIM($cid, $email_address)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["email_address"] = $email_address;
        return $this->callServer("campaignEmailStatsAIM", $params);
    }
    public function campaignEmailStatsAIMAll($cid, $start = 0, $limit = 100)
    {
        $params = [];
        $params["cid"] = $cid;
        $params["start"] = $start;
        $params["limit"] = $limit;
        return $this->callServer("campaignEmailStatsAIMAll", $params);
    }
    public function campaignEcommOrderAdd($order)
    {
        $params = [];
        $params["order"] = $order;
        return $this->callServer("campaignEcommOrderAdd", $params);
    }
    public function lists($filters = [], $start = 0, $limit = 25)
    {
        $params = [];
        $params["filters"] = $filters;
        $params["start"] = $start;
        $params["limit"] = $limit;
        return $this->callServer("lists", $params);
    }
    public function listMergeVars($id)
    {
        $params = [];
        $params["id"] = $id;
        return $this->callServer("listMergeVars", $params);
    }
    public function listMergeVarAdd($id, $tag, $name, $options = [])
    {
        $params = [];
        $params["id"] = $id;
        $params["tag"] = $tag;
        $params["name"] = $name;
        $params["options"] = $options;
        return $this->callServer("listMergeVarAdd", $params);
    }
    public function listMergeVarUpdate($id, $tag, $options)
    {
        $params = [];
        $params["id"] = $id;
        $params["tag"] = $tag;
        $params["options"] = $options;
        return $this->callServer("listMergeVarUpdate", $params);
    }
    public function listMergeVarDel($id, $tag)
    {
        $params = [];
        $params["id"] = $id;
        $params["tag"] = $tag;
        return $this->callServer("listMergeVarDel", $params);
    }
    public function listInterestGroupings($id)
    {
        $params = [];
        $params["id"] = $id;
        return $this->callServer("listInterestGroupings", $params);
    }
    public function listInterestGroupAdd($id, $group_name, $grouping_id = NULL)
    {
        $params = [];
        $params["id"] = $id;
        $params["group_name"] = $group_name;
        $params["grouping_id"] = $grouping_id;
        return $this->callServer("listInterestGroupAdd", $params);
    }
    public function listInterestGroupDel($id, $group_name, $grouping_id = NULL)
    {
        $params = [];
        $params["id"] = $id;
        $params["group_name"] = $group_name;
        $params["grouping_id"] = $grouping_id;
        return $this->callServer("listInterestGroupDel", $params);
    }
    public function listInterestGroupUpdate($id, $old_name, $new_name, $grouping_id = NULL)
    {
        $params = [];
        $params["id"] = $id;
        $params["old_name"] = $old_name;
        $params["new_name"] = $new_name;
        $params["grouping_id"] = $grouping_id;
        return $this->callServer("listInterestGroupUpdate", $params);
    }
    public function listInterestGroupingAdd($id, $name, $type, $groups)
    {
        $params = [];
        $params["id"] = $id;
        $params["name"] = $name;
        $params["type"] = $type;
        $params["groups"] = $groups;
        return $this->callServer("listInterestGroupingAdd", $params);
    }
    public function listInterestGroupingUpdate($grouping_id, $name, $value)
    {
        $params = [];
        $params["grouping_id"] = $grouping_id;
        $params["name"] = $name;
        $params["value"] = $value;
        return $this->callServer("listInterestGroupingUpdate", $params);
    }
    public function listInterestGroupingDel($grouping_id)
    {
        $params = [];
        $params["grouping_id"] = $grouping_id;
        return $this->callServer("listInterestGroupingDel", $params);
    }
    public function listWebhooks($id)
    {
        $params = [];
        $params["id"] = $id;
        return $this->callServer("listWebhooks", $params);
    }
    public function listWebhookAdd($id, $url, $actions = [], $sources = [])
    {
        $params = [];
        $params["id"] = $id;
        $params["url"] = $url;
        $params["actions"] = $actions;
        $params["sources"] = $sources;
        return $this->callServer("listWebhookAdd", $params);
    }
    public function listWebhookDel($id, $url)
    {
        $params = [];
        $params["id"] = $id;
        $params["url"] = $url;
        return $this->callServer("listWebhookDel", $params);
    }
    public function listStaticSegments($id)
    {
        $params = [];
        $params["id"] = $id;
        return $this->callServer("listStaticSegments", $params);
    }
    public function listStaticSegmentAdd($id, $name)
    {
        $params = [];
        $params["id"] = $id;
        $params["name"] = $name;
        return $this->callServer("listStaticSegmentAdd", $params);
    }
    public function listStaticSegmentReset($id, $seg_id)
    {
        $params = [];
        $params["id"] = $id;
        $params["seg_id"] = $seg_id;
        return $this->callServer("listStaticSegmentReset", $params);
    }
    public function listStaticSegmentDel($id, $seg_id)
    {
        $params = [];
        $params["id"] = $id;
        $params["seg_id"] = $seg_id;
        return $this->callServer("listStaticSegmentDel", $params);
    }
    public function listStaticSegmentMembersAdd($id, $seg_id, $batch)
    {
        $params = [];
        $params["id"] = $id;
        $params["seg_id"] = $seg_id;
        $params["batch"] = $batch;
        return $this->callServer("listStaticSegmentMembersAdd", $params);
    }
    public function listStaticSegmentMembersDel($id, $seg_id, $batch)
    {
        $params = [];
        $params["id"] = $id;
        $params["seg_id"] = $seg_id;
        $params["batch"] = $batch;
        return $this->callServer("listStaticSegmentMembersDel", $params);
    }
    public function listSubscribe($id, $email_address, $merge_vars = NULL, $email_type = "html", $double_optin = true, $update_existing = false, $replace_interests = true, $send_welcome = false)
    {
        $params = [];
        $params["id"] = $id;
        $params["email_address"] = $email_address;
        $params["merge_vars"] = $merge_vars;
        $params["email_type"] = $email_type;
        $params["double_optin"] = $double_optin;
        $params["update_existing"] = $update_existing;
        $params["replace_interests"] = $replace_interests;
        $params["send_welcome"] = $send_welcome;
        return $this->callServer("listSubscribe", $params);
    }
    public function listUnsubscribe($id, $email_address, $delete_member = false, $send_goodbye = true, $send_notify = true)
    {
        $params = [];
        $params["id"] = $id;
        $params["email_address"] = $email_address;
        $params["delete_member"] = $delete_member;
        $params["send_goodbye"] = $send_goodbye;
        $params["send_notify"] = $send_notify;
        return $this->callServer("listUnsubscribe", $params);
    }
    public function listUpdateMember($id, $email_address, $merge_vars, $email_type = "", $replace_interests = true)
    {
        $params = [];
        $params["id"] = $id;
        $params["email_address"] = $email_address;
        $params["merge_vars"] = $merge_vars;
        $params["email_type"] = $email_type;
        $params["replace_interests"] = $replace_interests;
        return $this->callServer("listUpdateMember", $params);
    }
    public function listBatchSubscribe($id, $batch, $double_optin = true, $update_existing = false, $replace_interests = true)
    {
        $params = [];
        $params["id"] = $id;
        $params["batch"] = $batch;
        $params["double_optin"] = $double_optin;
        $params["update_existing"] = $update_existing;
        $params["replace_interests"] = $replace_interests;
        return $this->callServer("listBatchSubscribe", $params);
    }
    public function listBatchUnsubscribe($id, $emails, $delete_member = false, $send_goodbye = true, $send_notify = false)
    {
        $params = [];
        $params["id"] = $id;
        $params["emails"] = $emails;
        $params["delete_member"] = $delete_member;
        $params["send_goodbye"] = $send_goodbye;
        $params["send_notify"] = $send_notify;
        return $this->callServer("listBatchUnsubscribe", $params);
    }
    public function listMembers($id, $status = "subscribed", $since = NULL, $start = 0, $limit = 100)
    {
        $params = [];
        $params["id"] = $id;
        $params["status"] = $status;
        $params["since"] = $since;
        $params["start"] = $start;
        $params["limit"] = $limit;
        return $this->callServer("listMembers", $params);
    }
    public function listMemberInfo($id, $email_address)
    {
        $params = [];
        $params["id"] = $id;
        $params["email_address"] = $email_address;
        return $this->callServer("listMemberInfo", $params);
    }
    public function listMemberActivity($id, $email_address)
    {
        $params = [];
        $params["id"] = $id;
        $params["email_address"] = $email_address;
        return $this->callServer("listMemberActivity", $params);
    }
    public function listAbuseReports($id, $start = 0, $limit = 500, $since = NULL)
    {
        $params = [];
        $params["id"] = $id;
        $params["start"] = $start;
        $params["limit"] = $limit;
        $params["since"] = $since;
        return $this->callServer("listAbuseReports", $params);
    }
    public function listGrowthHistory($id)
    {
        $params = [];
        $params["id"] = $id;
        return $this->callServer("listGrowthHistory", $params);
    }
    public function listActivity($id)
    {
        $params = [];
        $params["id"] = $id;
        return $this->callServer("listActivity", $params);
    }
    public function listLocations($id)
    {
        $params = [];
        $params["id"] = $id;
        return $this->callServer("listLocations", $params);
    }
    public function listClients($id)
    {
        $params = [];
        $params["id"] = $id;
        return $this->callServer("listClients", $params);
    }
    public function templates($types = [], $category = NULL, $inactives = [])
    {
        $params = [];
        $params["types"] = $types;
        $params["category"] = $category;
        $params["inactives"] = $inactives;
        return $this->callServer("templates", $params);
    }
    public function templateInfo($tid, $type = "user")
    {
        $params = [];
        $params["tid"] = $tid;
        $params["type"] = $type;
        return $this->callServer("templateInfo", $params);
    }
    public function templateAdd($name, $html)
    {
        $params = [];
        $params["name"] = $name;
        $params["html"] = $html;
        return $this->callServer("templateAdd", $params);
    }
    public function templateUpdate($id, $values)
    {
        $params = [];
        $params["id"] = $id;
        $params["values"] = $values;
        return $this->callServer("templateUpdate", $params);
    }
    public function templateDel($id)
    {
        $params = [];
        $params["id"] = $id;
        return $this->callServer("templateDel", $params);
    }
    public function templateUndel($id)
    {
        $params = [];
        $params["id"] = $id;
        return $this->callServer("templateUndel", $params);
    }
    public function getAccountDetails()
    {
        $params = [];
        return $this->callServer("getAccountDetails", $params);
    }
    public function generateText($type, $content)
    {
        $params = [];
        $params["type"] = $type;
        $params["content"] = $content;
        return $this->callServer("generateText", $params);
    }
    public function inlineCss($html, $strip_css = false)
    {
        $params = [];
        $params["html"] = $html;
        $params["strip_css"] = $strip_css;
        return $this->callServer("inlineCss", $params);
    }
    public function folders($type = "campaign")
    {
        $params = [];
        $params["type"] = $type;
        return $this->callServer("folders", $params);
    }
    public function folderAdd($name, $type = "campaign")
    {
        $params = [];
        $params["name"] = $name;
        $params["type"] = $type;
        return $this->callServer("folderAdd", $params);
    }
    public function folderUpdate($fid, $name, $type = "campaign")
    {
        $params = [];
        $params["fid"] = $fid;
        $params["name"] = $name;
        $params["type"] = $type;
        return $this->callServer("folderUpdate", $params);
    }
    public function folderDel($fid, $type = "campaign")
    {
        $params = [];
        $params["fid"] = $fid;
        $params["type"] = $type;
        return $this->callServer("folderDel", $params);
    }
    public function ecommOrders($start = 0, $limit = 100, $since = NULL)
    {
        $params = [];
        $params["start"] = $start;
        $params["limit"] = $limit;
        $params["since"] = $since;
        return $this->callServer("ecommOrders", $params);
    }
    public function ecommOrderAdd($order)
    {
        $params = [];
        $params["order"] = $order;
        return $this->callServer("ecommOrderAdd", $params);
    }
    public function ecommOrderDel($store_id, $order_id)
    {
        $params = [];
        $params["store_id"] = $store_id;
        $params["order_id"] = $order_id;
        return $this->callServer("ecommOrderDel", $params);
    }
    public function listsForEmail($email_address)
    {
        $params = [];
        $params["email_address"] = $email_address;
        return $this->callServer("listsForEmail", $params);
    }
    public function campaignsForEmail($email_address)
    {
        $params = [];
        $params["email_address"] = $email_address;
        return $this->callServer("campaignsForEmail", $params);
    }
    public function chimpChatter()
    {
        $params = [];
        return $this->callServer("chimpChatter", $params);
    }
    public function apikeys($username, $password, $expired = false)
    {
        $params = [];
        $params["username"] = $username;
        $params["password"] = $password;
        $params["expired"] = $expired;
        return $this->callServer("apikeys", $params);
    }
    public function apikeyAdd($username, $password)
    {
        $params = [];
        $params["username"] = $username;
        $params["password"] = $password;
        return $this->callServer("apikeyAdd", $params);
    }
    public function apikeyExpire($username, $password)
    {
        $params = [];
        $params["username"] = $username;
        $params["password"] = $password;
        return $this->callServer("apikeyExpire", $params);
    }
    public function ping()
    {
        $params = [];
        return $this->callServer("ping", $params);
    }
    public function callMethod()
    {
        $params = [];
        return $this->callServer("callMethod", $params);
    }
    public function callServer($method, $params)
    {
        $dc = "us1";
        if (strstr($this->api_key, "-")) {
            list($key, $dc) = explode("-", $this->api_key, 2);
            if (!$dc) {
                $dc = "us1";
            }
        }
        $host = $dc . "." . $this->apiUrl["host"];
        $params["apikey"] = $this->api_key;
        $this->errorMessage = "";
        $this->errorCode = "";
        $sep_changed = false;
        if (ini_get("arg_separator.output") != "&") {
            $sep_changed = true;
            $orig_sep = ini_get("arg_separator.output");
            ini_set("arg_separator.output", "&");
        }
        $post_vars = http_build_query($params);
        if ($sep_changed) {
            ini_set("arg_separator.output", $orig_sep);
        }
        $payload = "POST " . $this->apiUrl["path"] . "?" . $this->apiUrl["query"] . "&method=" . $method . " HTTP/1.0\r\n";
        $payload .= "Host: " . $host . "\r\n";
        $payload .= "User-Agent: MCAPI/" . $this->version . "\r\n";
        $payload .= "Content-type: application/x-www-form-urlencoded\r\n";
        $payload .= "Content-length: " . strlen($post_vars) . "\r\n";
        $payload .= "Connection: close \r\n\r\n";
        $payload .= $post_vars;
        ob_start();
        if ($this->secure) {
            $sock = fsockopen("ssl://" . $host, 443, $errno, $errstr, 30);
        } else {
            $sock = fsockopen($host, 80, $errno, $errstr, 30);
        }
        if (!$sock) {
            $this->errorMessage = "Could not connect (ERR " . $errno . ": " . $errstr . ")";
            $this->errorCode = "-99";
            ob_end_clean();
            return false;
        }
        $response = "";
        fwrite($sock, $payload);
        stream_set_timeout($sock, $this->timeout);
        $info = stream_get_meta_data($sock);
        while (!feof($sock) && !$info["timed_out"]) {
            $response .= fread($sock, $this->chunkSize);
            $info = stream_get_meta_data($sock);
        }
        fclose($sock);
        ob_end_clean();
        if ($info["timed_out"]) {
            $this->errorMessage = "Could not read response (timed out)";
            $this->errorCode = -98;
            return false;
        }
        list($headers, $response) = explode("\r\n\r\n", $response, 2);
        $headers = explode("\r\n", $headers);
        $errored = false;
        foreach ($headers as $h) {
            if (substr($h, 0, 26) === "X-MailChimp-API-Error-Code") {
                $errored = true;
                $error_code = trim(substr($h, 27));
                if (ini_get("magic_quotes_runtime")) {
                    $response = stripslashes($response);
                }
                $serial = unserialize($response);
                if ($response && $serial === false) {
                    $response = ["error" => "Bad Response.  Got This: " . $response, "code" => "-99"];
                } else {
                    $response = $serial;
                }
                if ($errored && is_array($response) && isset($response["error"])) {
                    $this->errorMessage = $response["error"];
                    $this->errorCode = $response["code"];
                    return false;
                }
                if ($errored) {
                    $this->errorMessage = "No error message was found";
                    $this->errorCode = $error_code;
                    return false;
                }
                return $response;
            }
        }
    }
}
function storeAddress($api_key, $list_uniqueid, $email, $fname = "", $lname = "", $address = "", $city = "", $state = "", $zip = "", $flag = false)
{
    if (!$email) {
        return "No email address provided";
    }
    if (!preg_match("/^[_a-z0-9-]+(\\.[_a-z0-9-]+)*@[a-z0-9-]+(\\.[a-z0-9-]+)*\$/i", $email)) {
        return "Error: Email address is invalid";
    }
    $api = new MCAPI($api_key);
    $list_id = $list_uniqueid;
    $mergeVars = ["FNAME" => $fname, "LNAME" => $lname, "ADDRESS" => $address, "CITY" => $city, "STATE" => $state, "ZIP" => $zip];
    $vars["email_address"] = $email;
    $vars["status"] = "subscribed";
    $vars = json_encode($vars);
    $explode = explode("-", $api_key);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://" . $explode[1] . ".api.mailchimp.com/3.0/lists/" . $list_uniqueid . "/members");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERNAME, "anystring:" . $api_key);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = ["Content-Type:application/json", "Authorization:Basic " . $api_key];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $server_output = curl_exec($ch);
    curl_close($ch);
    return "Success: Contact Subscribed :" . $email;
}

?>