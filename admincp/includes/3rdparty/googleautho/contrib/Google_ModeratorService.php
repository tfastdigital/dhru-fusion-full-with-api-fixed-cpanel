<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "votes" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $votes = $moderatorService->votes;
 *  </code>
 */
class Google_VotesServiceResource extends Google_ServiceResource
{
    public function insert($seriesId, $submissionId, Google_Vote $postBody, $optParams = [])
    {
        $params = ["seriesId" => $seriesId, "submissionId" => $submissionId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_Vote($data);
        }
        return $data;
    }
    public function patch($seriesId, $submissionId, Google_Vote $postBody, $optParams = [])
    {
        $params = ["seriesId" => $seriesId, "submissionId" => $submissionId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("patch", [$params]);
        if ($this->useObjects()) {
            return new Google_Vote($data);
        }
        return $data;
    }
    public function listVotes($seriesId, $optParams = [])
    {
        $params = ["seriesId" => $seriesId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_VoteList($data);
        }
        return $data;
    }
    public function update($seriesId, $submissionId, Google_Vote $postBody, $optParams = [])
    {
        $params = ["seriesId" => $seriesId, "submissionId" => $submissionId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("update", [$params]);
        if ($this->useObjects()) {
            return new Google_Vote($data);
        }
        return $data;
    }
    public function get($seriesId, $submissionId, $optParams = [])
    {
        $params = ["seriesId" => $seriesId, "submissionId" => $submissionId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Vote($data);
        }
        return $data;
    }
}
/**
 * The "responses" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $responses = $moderatorService->responses;
 *  </code>
 */
class Google_ResponsesServiceResource extends Google_ServiceResource
{
    public function insert($seriesId, $topicId, $parentSubmissionId, Google_Submission $postBody, $optParams = [])
    {
        $params = ["seriesId" => $seriesId, "topicId" => $topicId, "parentSubmissionId" => $parentSubmissionId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_Submission($data);
        }
        return $data;
    }
    public function listResponses($seriesId, $submissionId, $optParams = [])
    {
        $params = ["seriesId" => $seriesId, "submissionId" => $submissionId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_SubmissionList($data);
        }
        return $data;
    }
}
/**
 * The "tags" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $tags = $moderatorService->tags;
 *  </code>
 */
class Google_TagsServiceResource extends Google_ServiceResource
{
    public function insert($seriesId, $submissionId, Google_Tag $postBody, $optParams = [])
    {
        $params = ["seriesId" => $seriesId, "submissionId" => $submissionId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_Tag($data);
        }
        return $data;
    }
    public function listTags($seriesId, $submissionId, $optParams = [])
    {
        $params = ["seriesId" => $seriesId, "submissionId" => $submissionId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_TagList($data);
        }
        return $data;
    }
    public function delete($seriesId, $submissionId, $tagId, $optParams = [])
    {
        $params = ["seriesId" => $seriesId, "submissionId" => $submissionId, "tagId" => $tagId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("delete", [$params]);
        return $data;
    }
}
/**
 * The "series" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $series = $moderatorService->series;
 *  </code>
 */
class Google_SeriesServiceResource extends Google_ServiceResource
{
    public function insert(Google_Series $postBody, $optParams = [])
    {
        $params = ["postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_Series($data);
        }
        return $data;
    }
    public function patch($seriesId, Google_Series $postBody, $optParams = [])
    {
        $params = ["seriesId" => $seriesId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("patch", [$params]);
        if ($this->useObjects()) {
            return new Google_Series($data);
        }
        return $data;
    }
    public function listSeries($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_SeriesList($data);
        }
        return $data;
    }
    public function update($seriesId, Google_Series $postBody, $optParams = [])
    {
        $params = ["seriesId" => $seriesId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("update", [$params]);
        if ($this->useObjects()) {
            return new Google_Series($data);
        }
        return $data;
    }
    public function get($seriesId, $optParams = [])
    {
        $params = ["seriesId" => $seriesId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Series($data);
        }
        return $data;
    }
}
/**
 * The "submissions" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $submissions = $moderatorService->submissions;
 *  </code>
 */
class Google_SeriesSubmissionsServiceResource extends Google_ServiceResource
{
    public function listSeriesSubmissions($seriesId, $optParams = [])
    {
        $params = ["seriesId" => $seriesId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_SubmissionList($data);
        }
        return $data;
    }
}
/**
 * The "responses" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $responses = $moderatorService->responses;
 *  </code>
 */
class Google_SeriesResponsesServiceResource extends Google_ServiceResource
{
    public function listSeriesResponses($seriesId, $optParams = [])
    {
        $params = ["seriesId" => $seriesId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_SeriesList($data);
        }
        return $data;
    }
}
/**
 * The "topics" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $topics = $moderatorService->topics;
 *  </code>
 */
class Google_TopicsServiceResource extends Google_ServiceResource
{
    public function insert($seriesId, Google_Topic $postBody, $optParams = [])
    {
        $params = ["seriesId" => $seriesId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_Topic($data);
        }
        return $data;
    }
    public function listTopics($seriesId, $optParams = [])
    {
        $params = ["seriesId" => $seriesId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_TopicList($data);
        }
        return $data;
    }
    public function update($seriesId, $topicId, Google_Topic $postBody, $optParams = [])
    {
        $params = ["seriesId" => $seriesId, "topicId" => $topicId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("update", [$params]);
        if ($this->useObjects()) {
            return new Google_Topic($data);
        }
        return $data;
    }
    public function get($seriesId, $topicId, $optParams = [])
    {
        $params = ["seriesId" => $seriesId, "topicId" => $topicId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Topic($data);
        }
        return $data;
    }
}
/**
 * The "submissions" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $submissions = $moderatorService->submissions;
 *  </code>
 */
class Google_TopicsSubmissionsServiceResource extends Google_ServiceResource
{
    public function listTopicsSubmissions($seriesId, $topicId, $optParams = [])
    {
        $params = ["seriesId" => $seriesId, "topicId" => $topicId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_SubmissionList($data);
        }
        return $data;
    }
}
/**
 * The "global" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $global = $moderatorService->global;
 *  </code>
 */
class Google_ModeratorGlobalServiceResource extends Google_ServiceResource
{
}
/**
 * The "series" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $series = $moderatorService->series;
 *  </code>
 */
class Google_ModeratorGlobalSeriesServiceResource extends Google_ServiceResource
{
    public function listModeratorGlobalSeries($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_SeriesList($data);
        }
        return $data;
    }
}
/**
 * The "profiles" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $profiles = $moderatorService->profiles;
 *  </code>
 */
class Google_ProfilesServiceResource extends Google_ServiceResource
{
    public function patch(Google_Profile $postBody, $optParams = [])
    {
        $params = ["postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("patch", [$params]);
        if ($this->useObjects()) {
            return new Google_Profile($data);
        }
        return $data;
    }
    public function update(Google_Profile $postBody, $optParams = [])
    {
        $params = ["postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("update", [$params]);
        if ($this->useObjects()) {
            return new Google_Profile($data);
        }
        return $data;
    }
    public function get($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Profile($data);
        }
        return $data;
    }
}
/**
 * The "featured" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $featured = $moderatorService->featured;
 *  </code>
 */
class Google_FeaturedServiceResource extends Google_ServiceResource
{
}
/**
 * The "series" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $series = $moderatorService->series;
 *  </code>
 */
class Google_FeaturedSeriesServiceResource extends Google_ServiceResource
{
    public function listFeaturedSeries($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_SeriesList($data);
        }
        return $data;
    }
}
/**
 * The "myrecent" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $myrecent = $moderatorService->myrecent;
 *  </code>
 */
class Google_MyrecentServiceResource extends Google_ServiceResource
{
}
/**
 * The "series" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $series = $moderatorService->series;
 *  </code>
 */
class Google_MyrecentSeriesServiceResource extends Google_ServiceResource
{
    public function listMyrecentSeries($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_SeriesList($data);
        }
        return $data;
    }
}
/**
 * The "my" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $my = $moderatorService->my;
 *  </code>
 */
class Google_MyServiceResource extends Google_ServiceResource
{
}
/**
 * The "series" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $series = $moderatorService->series;
 *  </code>
 */
class Google_MySeriesServiceResource extends Google_ServiceResource
{
    public function listMySeries($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_SeriesList($data);
        }
        return $data;
    }
}
/**
 * The "submissions" collection of methods.
 * Typical usage is:
 *  <code>
 *   $moderatorService = new Google_ModeratorService(...);
 *   $submissions = $moderatorService->submissions;
 *  </code>
 */
class Google_SubmissionsServiceResource extends Google_ServiceResource
{
    public function insert($seriesId, $topicId, Google_Submission $postBody, $optParams = [])
    {
        $params = ["seriesId" => $seriesId, "topicId" => $topicId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_Submission($data);
        }
        return $data;
    }
    public function get($seriesId, $submissionId, $optParams = [])
    {
        $params = ["seriesId" => $seriesId, "submissionId" => $submissionId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Submission($data);
        }
        return $data;
    }
}
/**
 * Service definition for Google_Moderator (v1).
 *
 * <p>
 * Moderator API
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="http://code.google.com/apis/moderator/v1/using_rest.html" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_ModeratorService extends Google_Service
{
    public $votes = NULL;
    public $responses = NULL;
    public $tags = NULL;
    public $series = NULL;
    public $series_submissions = NULL;
    public $series_responses = NULL;
    public $topics = NULL;
    public $topics_submissions = NULL;
    public $global_series = NULL;
    public $profiles = NULL;
    public $featured_series = NULL;
    public $myrecent_series = NULL;
    public $my_series = NULL;
    public $submissions = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "moderator/v1/";
        $this->version = "v1";
        $this->serviceName = "moderator";
        $client->addService($this->serviceName, $this->version);
        $this->votes = new Google_VotesServiceResource($this, $this->serviceName, "votes", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"unauthToken\": {\"type\": \"string\", \"location\": \"query\"}, \"submissionId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}}, \"request\": {\"\$ref\": \"Vote\"}, \"response\": {\"\$ref\": \"Vote\"}, \"httpMethod\": \"POST\", \"path\": \"series/{seriesId}/submissions/{submissionId}/votes/@me\", \"id\": \"moderator.votes.insert\"}, \"patch\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"userId\": {\"type\": \"string\", \"location\": \"query\"}, \"unauthToken\": {\"type\": \"string\", \"location\": \"query\"}, \"submissionId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}}, \"request\": {\"\$ref\": \"Vote\"}, \"response\": {\"\$ref\": \"Vote\"}, \"httpMethod\": \"PATCH\", \"path\": \"series/{seriesId}/submissions/{submissionId}/votes/@me\", \"id\": \"moderator.votes.patch\"}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"max-results\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"start-index\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}}, \"id\": \"moderator.votes.list\", \"httpMethod\": \"GET\", \"path\": \"series/{seriesId}/votes/@me\", \"response\": {\"\$ref\": \"VoteList\"}}, \"update\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"userId\": {\"type\": \"string\", \"location\": \"query\"}, \"unauthToken\": {\"type\": \"string\", \"location\": \"query\"}, \"submissionId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}}, \"request\": {\"\$ref\": \"Vote\"}, \"response\": {\"\$ref\": \"Vote\"}, \"httpMethod\": \"PUT\", \"path\": \"series/{seriesId}/submissions/{submissionId}/votes/@me\", \"id\": \"moderator.votes.update\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"userId\": {\"type\": \"string\", \"location\": \"query\"}, \"unauthToken\": {\"type\": \"string\", \"location\": \"query\"}, \"submissionId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}}, \"id\": \"moderator.votes.get\", \"httpMethod\": \"GET\", \"path\": \"series/{seriesId}/submissions/{submissionId}/votes/@me\", \"response\": {\"\$ref\": \"Vote\"}}}}", true));
        $this->responses = new Google_ResponsesServiceResource($this, $this->serviceName, "responses", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"parentSubmissionId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"unauthToken\": {\"type\": \"string\", \"location\": \"query\"}, \"anonymous\": {\"type\": \"boolean\", \"location\": \"query\"}, \"topicId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}}, \"request\": {\"\$ref\": \"Submission\"}, \"response\": {\"\$ref\": \"Submission\"}, \"httpMethod\": \"POST\", \"path\": \"series/{seriesId}/topics/{topicId}/submissions/{parentSubmissionId}/responses\", \"id\": \"moderator.responses.insert\"}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"max-results\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"sort\": {\"type\": \"string\", \"location\": \"query\"}, \"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"author\": {\"type\": \"string\", \"location\": \"query\"}, \"start-index\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"submissionId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"q\": {\"type\": \"string\", \"location\": \"query\"}, \"hasAttachedVideo\": {\"type\": \"boolean\", \"location\": \"query\"}}, \"id\": \"moderator.responses.list\", \"httpMethod\": \"GET\", \"path\": \"series/{seriesId}/submissions/{submissionId}/responses\", \"response\": {\"\$ref\": \"SubmissionList\"}}}}", true));
        $this->tags = new Google_TagsServiceResource($this, $this->serviceName, "tags", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"submissionId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}}, \"request\": {\"\$ref\": \"Tag\"}, \"response\": {\"\$ref\": \"Tag\"}, \"httpMethod\": \"POST\", \"path\": \"series/{seriesId}/submissions/{submissionId}/tags\", \"id\": \"moderator.tags.insert\"}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"submissionId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}}, \"id\": \"moderator.tags.list\", \"httpMethod\": \"GET\", \"path\": \"series/{seriesId}/submissions/{submissionId}/tags\", \"response\": {\"\$ref\": \"TagList\"}}, \"delete\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"path\": \"series/{seriesId}/submissions/{submissionId}/tags/{tagId}\", \"id\": \"moderator.tags.delete\", \"parameters\": {\"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"tagId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"submissionId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}}, \"httpMethod\": \"DELETE\"}}}", true));
        $this->series = new Google_SeriesServiceResource($this, $this->serviceName, "series", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"request\": {\"\$ref\": \"Series\"}, \"response\": {\"\$ref\": \"Series\"}, \"httpMethod\": \"POST\", \"path\": \"series\", \"id\": \"moderator.series.insert\"}, \"patch\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}}, \"request\": {\"\$ref\": \"Series\"}, \"response\": {\"\$ref\": \"Series\"}, \"httpMethod\": \"PATCH\", \"path\": \"series/{seriesId}\", \"id\": \"moderator.series.patch\"}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"max-results\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"q\": {\"type\": \"string\", \"location\": \"query\"}, \"start-index\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}}, \"response\": {\"\$ref\": \"SeriesList\"}, \"httpMethod\": \"GET\", \"path\": \"series\", \"id\": \"moderator.series.list\"}, \"update\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}}, \"request\": {\"\$ref\": \"Series\"}, \"response\": {\"\$ref\": \"Series\"}, \"httpMethod\": \"PUT\", \"path\": \"series/{seriesId}\", \"id\": \"moderator.series.update\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}}, \"id\": \"moderator.series.get\", \"httpMethod\": \"GET\", \"path\": \"series/{seriesId}\", \"response\": {\"\$ref\": \"Series\"}}}}", true));
        $this->series_submissions = new Google_SeriesSubmissionsServiceResource($this, $this->serviceName, "submissions", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"lang\": {\"type\": \"string\", \"location\": \"query\"}, \"max-results\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"includeVotes\": {\"type\": \"boolean\", \"location\": \"query\"}, \"start-index\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"author\": {\"type\": \"string\", \"location\": \"query\"}, \"sort\": {\"type\": \"string\", \"location\": \"query\"}, \"q\": {\"type\": \"string\", \"location\": \"query\"}, \"hasAttachedVideo\": {\"type\": \"boolean\", \"location\": \"query\"}}, \"id\": \"moderator.series.submissions.list\", \"httpMethod\": \"GET\", \"path\": \"series/{seriesId}/submissions\", \"response\": {\"\$ref\": \"SubmissionList\"}}}}", true));
        $this->series_responses = new Google_SeriesResponsesServiceResource($this, $this->serviceName, "responses", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"max-results\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"sort\": {\"type\": \"string\", \"location\": \"query\"}, \"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"author\": {\"type\": \"string\", \"location\": \"query\"}, \"start-index\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"q\": {\"type\": \"string\", \"location\": \"query\"}, \"hasAttachedVideo\": {\"type\": \"boolean\", \"location\": \"query\"}}, \"id\": \"moderator.series.responses.list\", \"httpMethod\": \"GET\", \"path\": \"series/{seriesId}/responses\", \"response\": {\"\$ref\": \"SeriesList\"}}}}", true));
        $this->topics = new Google_TopicsServiceResource($this, $this->serviceName, "topics", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}}, \"request\": {\"\$ref\": \"Topic\"}, \"response\": {\"\$ref\": \"Topic\"}, \"httpMethod\": \"POST\", \"path\": \"series/{seriesId}/topics\", \"id\": \"moderator.topics.insert\"}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"max-results\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"q\": {\"type\": \"string\", \"location\": \"query\"}, \"start-index\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"mode\": {\"type\": \"string\", \"location\": \"query\"}, \"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}}, \"id\": \"moderator.topics.list\", \"httpMethod\": \"GET\", \"path\": \"series/{seriesId}/topics\", \"response\": {\"\$ref\": \"TopicList\"}}, \"update\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"topicId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}}, \"request\": {\"\$ref\": \"Topic\"}, \"response\": {\"\$ref\": \"Topic\"}, \"httpMethod\": \"PUT\", \"path\": \"series/{seriesId}/topics/{topicId}\", \"id\": \"moderator.topics.update\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"topicId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}}, \"id\": \"moderator.topics.get\", \"httpMethod\": \"GET\", \"path\": \"series/{seriesId}/topics/{topicId}\", \"response\": {\"\$ref\": \"Topic\"}}}}", true));
        $this->topics_submissions = new Google_TopicsSubmissionsServiceResource($this, $this->serviceName, "submissions", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"max-results\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"includeVotes\": {\"type\": \"boolean\", \"location\": \"query\"}, \"topicId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"start-index\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"author\": {\"type\": \"string\", \"location\": \"query\"}, \"sort\": {\"type\": \"string\", \"location\": \"query\"}, \"q\": {\"type\": \"string\", \"location\": \"query\"}, \"hasAttachedVideo\": {\"type\": \"boolean\", \"location\": \"query\"}}, \"id\": \"moderator.topics.submissions.list\", \"httpMethod\": \"GET\", \"path\": \"series/{seriesId}/topics/{topicId}/submissions\", \"response\": {\"\$ref\": \"SubmissionList\"}}}}", true));
        $this->global_series = new Google_ModeratorGlobalSeriesServiceResource($this, $this->serviceName, "series", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"max-results\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"q\": {\"type\": \"string\", \"location\": \"query\"}, \"start-index\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}}, \"response\": {\"\$ref\": \"SeriesList\"}, \"httpMethod\": \"GET\", \"path\": \"search\", \"id\": \"moderator.global.series.list\"}}}", true));
        $this->profiles = new Google_ProfilesServiceResource($this, $this->serviceName, "profiles", json_decode("{\"methods\": {\"patch\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"request\": {\"\$ref\": \"Profile\"}, \"response\": {\"\$ref\": \"Profile\"}, \"httpMethod\": \"PATCH\", \"path\": \"profiles/@me\", \"id\": \"moderator.profiles.patch\"}, \"update\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"request\": {\"\$ref\": \"Profile\"}, \"response\": {\"\$ref\": \"Profile\"}, \"httpMethod\": \"PUT\", \"path\": \"profiles/@me\", \"id\": \"moderator.profiles.update\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"path\": \"profiles/@me\", \"response\": {\"\$ref\": \"Profile\"}, \"id\": \"moderator.profiles.get\", \"httpMethod\": \"GET\"}}}", true));
        $this->featured_series = new Google_FeaturedSeriesServiceResource($this, $this->serviceName, "series", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"path\": \"series/featured\", \"response\": {\"\$ref\": \"SeriesList\"}, \"id\": \"moderator.featured.series.list\", \"httpMethod\": \"GET\"}}}", true));
        $this->myrecent_series = new Google_MyrecentSeriesServiceResource($this, $this->serviceName, "series", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"path\": \"series/@me/recent\", \"response\": {\"\$ref\": \"SeriesList\"}, \"id\": \"moderator.myrecent.series.list\", \"httpMethod\": \"GET\"}}}", true));
        $this->my_series = new Google_MySeriesServiceResource($this, $this->serviceName, "series", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"path\": \"series/@me/mine\", \"response\": {\"\$ref\": \"SeriesList\"}, \"id\": \"moderator.my.series.list\", \"httpMethod\": \"GET\"}}}", true));
        $this->submissions = new Google_SubmissionsServiceResource($this, $this->serviceName, "submissions", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"topicId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"unauthToken\": {\"type\": \"string\", \"location\": \"query\"}, \"anonymous\": {\"type\": \"boolean\", \"location\": \"query\"}}, \"request\": {\"\$ref\": \"Submission\"}, \"response\": {\"\$ref\": \"Submission\"}, \"httpMethod\": \"POST\", \"path\": \"series/{seriesId}/topics/{topicId}/submissions\", \"id\": \"moderator.submissions.insert\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/moderator\"], \"parameters\": {\"lang\": {\"type\": \"string\", \"location\": \"query\"}, \"seriesId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"submissionId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}, \"includeVotes\": {\"type\": \"boolean\", \"location\": \"query\"}}, \"id\": \"moderator.submissions.get\", \"httpMethod\": \"GET\", \"path\": \"series/{seriesId}/submissions/{submissionId}\", \"response\": {\"\$ref\": \"Submission\"}}}}", true));
    }
}
class Google_ModeratorTopicsResourcePartial extends Google_Model
{
    protected $__idType = "Google_ModeratorTopicsResourcePartialId";
    protected $__idDataType = "";
    public $id = NULL;
    public function setId(Google_ModeratorTopicsResourcePartialId $id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
}
class Google_ModeratorTopicsResourcePartialId extends Google_Model
{
    public $seriesId = NULL;
    public $topicId = NULL;
    public function setSeriesId($seriesId)
    {
        $this->seriesId = $seriesId;
    }
    public function getSeriesId()
    {
        return $this->seriesId;
    }
    public function setTopicId($topicId)
    {
        $this->topicId = $topicId;
    }
    public function getTopicId()
    {
        return $this->topicId;
    }
}
class Google_ModeratorVotesResourcePartial extends Google_Model
{
    public $vote = NULL;
    public $flag = NULL;
    public function setVote($vote)
    {
        $this->vote = $vote;
    }
    public function getVote()
    {
        return $this->vote;
    }
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }
    public function getFlag()
    {
        return $this->flag;
    }
}
class Google_Profile extends Google_Model
{
    public $kind = NULL;
    protected $__attributionType = "Google_ProfileAttribution";
    protected $__attributionDataType = "";
    public $attribution = NULL;
    protected $__idType = "Google_ProfileId";
    protected $__idDataType = "";
    public $id = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setAttribution(Google_ProfileAttribution $attribution)
    {
        $this->attribution = $attribution;
    }
    public function getAttribution()
    {
        return $this->attribution;
    }
    public function setId(Google_ProfileId $id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
}
class Google_ProfileAttribution extends Google_Model
{
    protected $__geoType = "Google_ProfileAttributionGeo";
    protected $__geoDataType = "";
    public $geo = NULL;
    public $displayName = NULL;
    public $location = NULL;
    public $avatarUrl = NULL;
    public function setGeo(Google_ProfileAttributionGeo $geo)
    {
        $this->geo = $geo;
    }
    public function getGeo()
    {
        return $this->geo;
    }
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
    public function getDisplayName()
    {
        return $this->displayName;
    }
    public function setLocation($location)
    {
        $this->location = $location;
    }
    public function getLocation()
    {
        return $this->location;
    }
    public function setAvatarUrl($avatarUrl)
    {
        $this->avatarUrl = $avatarUrl;
    }
    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }
}
class Google_ProfileAttributionGeo extends Google_Model
{
    public $latitude = NULL;
    public $location = NULL;
    public $longitude = NULL;
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }
    public function getLatitude()
    {
        return $this->latitude;
    }
    public function setLocation($location)
    {
        $this->location = $location;
    }
    public function getLocation()
    {
        return $this->location;
    }
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }
    public function getLongitude()
    {
        return $this->longitude;
    }
}
class Google_ProfileId extends Google_Model
{
    public $user = NULL;
    public function setUser($user)
    {
        $this->user = $user;
    }
    public function getUser()
    {
        return $this->user;
    }
}
class Google_Series extends Google_Model
{
    public $kind = NULL;
    public $description = NULL;
    protected $__rulesType = "Google_SeriesRules";
    protected $__rulesDataType = "";
    public $rules = NULL;
    public $unauthVotingAllowed = NULL;
    public $videoSubmissionAllowed = NULL;
    public $name = NULL;
    public $numTopics = NULL;
    public $anonymousSubmissionAllowed = NULL;
    public $unauthSubmissionAllowed = NULL;
    protected $__idType = "Google_SeriesId";
    protected $__idDataType = "";
    public $id = NULL;
    protected $__countersType = "Google_SeriesCounters";
    protected $__countersDataType = "";
    public $counters = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setRules(Google_SeriesRules $rules)
    {
        $this->rules = $rules;
    }
    public function getRules()
    {
        return $this->rules;
    }
    public function setUnauthVotingAllowed($unauthVotingAllowed)
    {
        $this->unauthVotingAllowed = $unauthVotingAllowed;
    }
    public function getUnauthVotingAllowed()
    {
        return $this->unauthVotingAllowed;
    }
    public function setVideoSubmissionAllowed($videoSubmissionAllowed)
    {
        $this->videoSubmissionAllowed = $videoSubmissionAllowed;
    }
    public function getVideoSubmissionAllowed()
    {
        return $this->videoSubmissionAllowed;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setNumTopics($numTopics)
    {
        $this->numTopics = $numTopics;
    }
    public function getNumTopics()
    {
        return $this->numTopics;
    }
    public function setAnonymousSubmissionAllowed($anonymousSubmissionAllowed)
    {
        $this->anonymousSubmissionAllowed = $anonymousSubmissionAllowed;
    }
    public function getAnonymousSubmissionAllowed()
    {
        return $this->anonymousSubmissionAllowed;
    }
    public function setUnauthSubmissionAllowed($unauthSubmissionAllowed)
    {
        $this->unauthSubmissionAllowed = $unauthSubmissionAllowed;
    }
    public function getUnauthSubmissionAllowed()
    {
        return $this->unauthSubmissionAllowed;
    }
    public function setId(Google_SeriesId $id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setCounters(Google_SeriesCounters $counters)
    {
        $this->counters = $counters;
    }
    public function getCounters()
    {
        return $this->counters;
    }
}
class Google_SeriesCounters extends Google_Model
{
    public $users = NULL;
    public $noneVotes = NULL;
    public $videoSubmissions = NULL;
    public $minusVotes = NULL;
    public $anonymousSubmissions = NULL;
    public $submissions = NULL;
    public $plusVotes = NULL;
    public function setUsers($users)
    {
        $this->users = $users;
    }
    public function getUsers()
    {
        return $this->users;
    }
    public function setNoneVotes($noneVotes)
    {
        $this->noneVotes = $noneVotes;
    }
    public function getNoneVotes()
    {
        return $this->noneVotes;
    }
    public function setVideoSubmissions($videoSubmissions)
    {
        $this->videoSubmissions = $videoSubmissions;
    }
    public function getVideoSubmissions()
    {
        return $this->videoSubmissions;
    }
    public function setMinusVotes($minusVotes)
    {
        $this->minusVotes = $minusVotes;
    }
    public function getMinusVotes()
    {
        return $this->minusVotes;
    }
    public function setAnonymousSubmissions($anonymousSubmissions)
    {
        $this->anonymousSubmissions = $anonymousSubmissions;
    }
    public function getAnonymousSubmissions()
    {
        return $this->anonymousSubmissions;
    }
    public function setSubmissions($submissions)
    {
        $this->submissions = $submissions;
    }
    public function getSubmissions()
    {
        return $this->submissions;
    }
    public function setPlusVotes($plusVotes)
    {
        $this->plusVotes = $plusVotes;
    }
    public function getPlusVotes()
    {
        return $this->plusVotes;
    }
}
class Google_SeriesId extends Google_Model
{
    public $seriesId = NULL;
    public function setSeriesId($seriesId)
    {
        $this->seriesId = $seriesId;
    }
    public function getSeriesId()
    {
        return $this->seriesId;
    }
}
class Google_SeriesList extends Google_Model
{
    protected $__itemsType = "Google_Series";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Series", "Google_SeriesList::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
}
class Google_SeriesRules extends Google_Model
{
    protected $__votesType = "Google_SeriesRulesVotes";
    protected $__votesDataType = "";
    public $votes = NULL;
    protected $__submissionsType = "Google_SeriesRulesSubmissions";
    protected $__submissionsDataType = "";
    public $submissions = NULL;
    public function setVotes(Google_SeriesRulesVotes $votes)
    {
        $this->votes = $votes;
    }
    public function getVotes()
    {
        return $this->votes;
    }
    public function setSubmissions(Google_SeriesRulesSubmissions $submissions)
    {
        $this->submissions = $submissions;
    }
    public function getSubmissions()
    {
        return $this->submissions;
    }
}
class Google_SeriesRulesSubmissions extends Google_Model
{
    public $close = NULL;
    public $open = NULL;
    public function setClose($close)
    {
        $this->close = $close;
    }
    public function getClose()
    {
        return $this->close;
    }
    public function setOpen($open)
    {
        $this->open = $open;
    }
    public function getOpen()
    {
        return $this->open;
    }
}
class Google_SeriesRulesVotes extends Google_Model
{
    public $close = NULL;
    public $open = NULL;
    public function setClose($close)
    {
        $this->close = $close;
    }
    public function getClose()
    {
        return $this->close;
    }
    public function setOpen($open)
    {
        $this->open = $open;
    }
    public function getOpen()
    {
        return $this->open;
    }
}
class Google_Submission extends Google_Model
{
    public $kind = NULL;
    protected $__attributionType = "Google_SubmissionAttribution";
    protected $__attributionDataType = "";
    public $attribution = NULL;
    public $created = NULL;
    public $text = NULL;
    protected $__topicsType = "Google_ModeratorTopicsResourcePartial";
    protected $__topicsDataType = "array";
    public $topics = NULL;
    public $author = NULL;
    protected $__translationsType = "Google_SubmissionTranslations";
    protected $__translationsDataType = "array";
    public $translations = NULL;
    protected $__parentSubmissionIdType = "Google_SubmissionParentSubmissionId";
    protected $__parentSubmissionIdDataType = "";
    public $parentSubmissionId = NULL;
    protected $__voteType = "Google_ModeratorVotesResourcePartial";
    protected $__voteDataType = "";
    public $vote = NULL;
    public $attachmentUrl = NULL;
    protected $__geoType = "Google_SubmissionGeo";
    protected $__geoDataType = "";
    public $geo = NULL;
    protected $__idType = "Google_SubmissionId";
    protected $__idDataType = "";
    public $id = NULL;
    protected $__countersType = "Google_SubmissionCounters";
    protected $__countersDataType = "";
    public $counters = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setAttribution(Google_SubmissionAttribution $attribution)
    {
        $this->attribution = $attribution;
    }
    public function getAttribution()
    {
        return $this->attribution;
    }
    public function setCreated($created)
    {
        $this->created = $created;
    }
    public function getCreated()
    {
        return $this->created;
    }
    public function setText($text)
    {
        $this->text = $text;
    }
    public function getText()
    {
        return $this->text;
    }
    public function setTopics($topics)
    {
        $this->assertIsArray($topics, "Google_ModeratorTopicsResourcePartial", "Google_Submission::setTopics");
        $this->topics = $topics;
    }
    public function getTopics()
    {
        return $this->topics;
    }
    public function setAuthor($author)
    {
        $this->author = $author;
    }
    public function getAuthor()
    {
        return $this->author;
    }
    public function setTranslations($translations)
    {
        $this->assertIsArray($translations, "Google_SubmissionTranslations", "Google_Submission::setTranslations");
        $this->translations = $translations;
    }
    public function getTranslations()
    {
        return $this->translations;
    }
    public function setParentSubmissionId(Google_SubmissionParentSubmissionId $parentSubmissionId)
    {
        $this->parentSubmissionId = $parentSubmissionId;
    }
    public function getParentSubmissionId()
    {
        return $this->parentSubmissionId;
    }
    public function setVote(Google_ModeratorVotesResourcePartial $vote)
    {
        $this->vote = $vote;
    }
    public function getVote()
    {
        return $this->vote;
    }
    public function setAttachmentUrl($attachmentUrl)
    {
        $this->attachmentUrl = $attachmentUrl;
    }
    public function getAttachmentUrl()
    {
        return $this->attachmentUrl;
    }
    public function setGeo(Google_SubmissionGeo $geo)
    {
        $this->geo = $geo;
    }
    public function getGeo()
    {
        return $this->geo;
    }
    public function setId(Google_SubmissionId $id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setCounters(Google_SubmissionCounters $counters)
    {
        $this->counters = $counters;
    }
    public function getCounters()
    {
        return $this->counters;
    }
}
class Google_SubmissionAttribution extends Google_Model
{
    public $displayName = NULL;
    public $location = NULL;
    public $avatarUrl = NULL;
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
    public function getDisplayName()
    {
        return $this->displayName;
    }
    public function setLocation($location)
    {
        $this->location = $location;
    }
    public function getLocation()
    {
        return $this->location;
    }
    public function setAvatarUrl($avatarUrl)
    {
        $this->avatarUrl = $avatarUrl;
    }
    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }
}
class Google_SubmissionCounters extends Google_Model
{
    public $noneVotes = NULL;
    public $minusVotes = NULL;
    public $plusVotes = NULL;
    public function setNoneVotes($noneVotes)
    {
        $this->noneVotes = $noneVotes;
    }
    public function getNoneVotes()
    {
        return $this->noneVotes;
    }
    public function setMinusVotes($minusVotes)
    {
        $this->minusVotes = $minusVotes;
    }
    public function getMinusVotes()
    {
        return $this->minusVotes;
    }
    public function setPlusVotes($plusVotes)
    {
        $this->plusVotes = $plusVotes;
    }
    public function getPlusVotes()
    {
        return $this->plusVotes;
    }
}
class Google_SubmissionGeo extends Google_Model
{
    public $latitude = NULL;
    public $location = NULL;
    public $longitude = NULL;
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }
    public function getLatitude()
    {
        return $this->latitude;
    }
    public function setLocation($location)
    {
        $this->location = $location;
    }
    public function getLocation()
    {
        return $this->location;
    }
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }
    public function getLongitude()
    {
        return $this->longitude;
    }
}
class Google_SubmissionId extends Google_Model
{
    public $seriesId = NULL;
    public $submissionId = NULL;
    public function setSeriesId($seriesId)
    {
        $this->seriesId = $seriesId;
    }
    public function getSeriesId()
    {
        return $this->seriesId;
    }
    public function setSubmissionId($submissionId)
    {
        $this->submissionId = $submissionId;
    }
    public function getSubmissionId()
    {
        return $this->submissionId;
    }
}
class Google_SubmissionList extends Google_Model
{
    protected $__itemsType = "Google_Submission";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Submission", "Google_SubmissionList::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
}
class Google_SubmissionParentSubmissionId extends Google_Model
{
    public $seriesId = NULL;
    public $submissionId = NULL;
    public function setSeriesId($seriesId)
    {
        $this->seriesId = $seriesId;
    }
    public function getSeriesId()
    {
        return $this->seriesId;
    }
    public function setSubmissionId($submissionId)
    {
        $this->submissionId = $submissionId;
    }
    public function getSubmissionId()
    {
        return $this->submissionId;
    }
}
class Google_SubmissionTranslations extends Google_Model
{
    public $lang = NULL;
    public $text = NULL;
    public function setLang($lang)
    {
        $this->lang = $lang;
    }
    public function getLang()
    {
        return $this->lang;
    }
    public function setText($text)
    {
        $this->text = $text;
    }
    public function getText()
    {
        return $this->text;
    }
}
class Google_Tag extends Google_Model
{
    public $text = NULL;
    public $kind = NULL;
    protected $__idType = "Google_TagId";
    protected $__idDataType = "";
    public $id = NULL;
    public function setText($text)
    {
        $this->text = $text;
    }
    public function getText()
    {
        return $this->text;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setId(Google_TagId $id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
}
class Google_TagId extends Google_Model
{
    public $seriesId = NULL;
    public $tagId = NULL;
    public $submissionId = NULL;
    public function setSeriesId($seriesId)
    {
        $this->seriesId = $seriesId;
    }
    public function getSeriesId()
    {
        return $this->seriesId;
    }
    public function setTagId($tagId)
    {
        $this->tagId = $tagId;
    }
    public function getTagId()
    {
        return $this->tagId;
    }
    public function setSubmissionId($submissionId)
    {
        $this->submissionId = $submissionId;
    }
    public function getSubmissionId()
    {
        return $this->submissionId;
    }
}
class Google_TagList extends Google_Model
{
    protected $__itemsType = "Google_Tag";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Tag", "Google_TagList::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
}
class Google_Topic extends Google_Model
{
    public $kind = NULL;
    public $description = NULL;
    protected $__rulesType = "Google_TopicRules";
    protected $__rulesDataType = "";
    public $rules = NULL;
    protected $__featuredSubmissionType = "Google_Submission";
    protected $__featuredSubmissionDataType = "";
    public $featuredSubmission = NULL;
    public $presenter = NULL;
    protected $__countersType = "Google_TopicCounters";
    protected $__countersDataType = "";
    public $counters = NULL;
    protected $__idType = "Google_TopicId";
    protected $__idDataType = "";
    public $id = NULL;
    public $name = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setRules(Google_TopicRules $rules)
    {
        $this->rules = $rules;
    }
    public function getRules()
    {
        return $this->rules;
    }
    public function setFeaturedSubmission(Google_Submission $featuredSubmission)
    {
        $this->featuredSubmission = $featuredSubmission;
    }
    public function getFeaturedSubmission()
    {
        return $this->featuredSubmission;
    }
    public function setPresenter($presenter)
    {
        $this->presenter = $presenter;
    }
    public function getPresenter()
    {
        return $this->presenter;
    }
    public function setCounters(Google_TopicCounters $counters)
    {
        $this->counters = $counters;
    }
    public function getCounters()
    {
        return $this->counters;
    }
    public function setId(Google_TopicId $id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
}
class Google_TopicCounters extends Google_Model
{
    public $users = NULL;
    public $noneVotes = NULL;
    public $videoSubmissions = NULL;
    public $minusVotes = NULL;
    public $submissions = NULL;
    public $plusVotes = NULL;
    public function setUsers($users)
    {
        $this->users = $users;
    }
    public function getUsers()
    {
        return $this->users;
    }
    public function setNoneVotes($noneVotes)
    {
        $this->noneVotes = $noneVotes;
    }
    public function getNoneVotes()
    {
        return $this->noneVotes;
    }
    public function setVideoSubmissions($videoSubmissions)
    {
        $this->videoSubmissions = $videoSubmissions;
    }
    public function getVideoSubmissions()
    {
        return $this->videoSubmissions;
    }
    public function setMinusVotes($minusVotes)
    {
        $this->minusVotes = $minusVotes;
    }
    public function getMinusVotes()
    {
        return $this->minusVotes;
    }
    public function setSubmissions($submissions)
    {
        $this->submissions = $submissions;
    }
    public function getSubmissions()
    {
        return $this->submissions;
    }
    public function setPlusVotes($plusVotes)
    {
        $this->plusVotes = $plusVotes;
    }
    public function getPlusVotes()
    {
        return $this->plusVotes;
    }
}
class Google_TopicId extends Google_Model
{
    public $seriesId = NULL;
    public $topicId = NULL;
    public function setSeriesId($seriesId)
    {
        $this->seriesId = $seriesId;
    }
    public function getSeriesId()
    {
        return $this->seriesId;
    }
    public function setTopicId($topicId)
    {
        $this->topicId = $topicId;
    }
    public function getTopicId()
    {
        return $this->topicId;
    }
}
class Google_TopicList extends Google_Model
{
    protected $__itemsType = "Google_Topic";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Topic", "Google_TopicList::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
}
class Google_TopicRules extends Google_Model
{
    protected $__votesType = "Google_TopicRulesVotes";
    protected $__votesDataType = "";
    public $votes = NULL;
    protected $__submissionsType = "Google_TopicRulesSubmissions";
    protected $__submissionsDataType = "";
    public $submissions = NULL;
    public function setVotes(Google_TopicRulesVotes $votes)
    {
        $this->votes = $votes;
    }
    public function getVotes()
    {
        return $this->votes;
    }
    public function setSubmissions(Google_TopicRulesSubmissions $submissions)
    {
        $this->submissions = $submissions;
    }
    public function getSubmissions()
    {
        return $this->submissions;
    }
}
class Google_TopicRulesSubmissions extends Google_Model
{
    public $close = NULL;
    public $open = NULL;
    public function setClose($close)
    {
        $this->close = $close;
    }
    public function getClose()
    {
        return $this->close;
    }
    public function setOpen($open)
    {
        $this->open = $open;
    }
    public function getOpen()
    {
        return $this->open;
    }
}
class Google_TopicRulesVotes extends Google_Model
{
    public $close = NULL;
    public $open = NULL;
    public function setClose($close)
    {
        $this->close = $close;
    }
    public function getClose()
    {
        return $this->close;
    }
    public function setOpen($open)
    {
        $this->open = $open;
    }
    public function getOpen()
    {
        return $this->open;
    }
}
class Google_Vote extends Google_Model
{
    public $vote = NULL;
    public $flag = NULL;
    protected $__idType = "Google_VoteId";
    protected $__idDataType = "";
    public $id = NULL;
    public $kind = NULL;
    public function setVote($vote)
    {
        $this->vote = $vote;
    }
    public function getVote()
    {
        return $this->vote;
    }
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }
    public function getFlag()
    {
        return $this->flag;
    }
    public function setId(Google_VoteId $id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
}
class Google_VoteId extends Google_Model
{
    public $seriesId = NULL;
    public $submissionId = NULL;
    public function setSeriesId($seriesId)
    {
        $this->seriesId = $seriesId;
    }
    public function getSeriesId()
    {
        return $this->seriesId;
    }
    public function setSubmissionId($submissionId)
    {
        $this->submissionId = $submissionId;
    }
    public function getSubmissionId()
    {
        return $this->submissionId;
    }
}
class Google_VoteList extends Google_Model
{
    protected $__itemsType = "Google_Vote";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Vote", "Google_VoteList::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
}

?>