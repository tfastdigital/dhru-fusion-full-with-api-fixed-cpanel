<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "taskqueues" collection of methods.
 * Typical usage is:
 *  <code>
 *   $taskqueueService = new Google_TaskqueueService(...);
 *   $taskqueues = $taskqueueService->taskqueues;
 *  </code>
 */
class Google_TaskqueuesServiceResource extends Google_ServiceResource
{
    public function get($project, $taskqueue, $optParams = [])
    {
        $params = ["project" => $project, "taskqueue" => $taskqueue];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_TaskQueue($data);
        }
        return $data;
    }
}
/**
 * The "tasks" collection of methods.
 * Typical usage is:
 *  <code>
 *   $taskqueueService = new Google_TaskqueueService(...);
 *   $tasks = $taskqueueService->tasks;
 *  </code>
 */
class Google_TasksServiceResource extends Google_ServiceResource
{
    public function insert($project, $taskqueue, Google_Task $postBody, $optParams = [])
    {
        $params = ["project" => $project, "taskqueue" => $taskqueue, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_Task($data);
        }
        return $data;
    }
    public function get($project, $taskqueue, $task, $optParams = [])
    {
        $params = ["project" => $project, "taskqueue" => $taskqueue, "task" => $task];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Task($data);
        }
        return $data;
    }
    public function listTasks($project, $taskqueue, $optParams = [])
    {
        $params = ["project" => $project, "taskqueue" => $taskqueue];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_Tasks2($data);
        }
        return $data;
    }
    public function update($project, $taskqueue, $task, $newLeaseSeconds, Google_Task $postBody, $optParams = [])
    {
        $params = ["project" => $project, "taskqueue" => $taskqueue, "task" => $task, "newLeaseSeconds" => $newLeaseSeconds, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("update", [$params]);
        if ($this->useObjects()) {
            return new Google_Task($data);
        }
        return $data;
    }
    public function patch($project, $taskqueue, $task, $newLeaseSeconds, Google_Task $postBody, $optParams = [])
    {
        $params = ["project" => $project, "taskqueue" => $taskqueue, "task" => $task, "newLeaseSeconds" => $newLeaseSeconds, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("patch", [$params]);
        if ($this->useObjects()) {
            return new Google_Task($data);
        }
        return $data;
    }
    public function delete($project, $taskqueue, $task, $optParams = [])
    {
        $params = ["project" => $project, "taskqueue" => $taskqueue, "task" => $task];
        $params = array_merge($params, $optParams);
        $data = $this->__call("delete", [$params]);
        return $data;
    }
    public function lease($project, $taskqueue, $numTasks, $leaseSecs, $optParams = [])
    {
        $params = ["project" => $project, "taskqueue" => $taskqueue, "numTasks" => $numTasks, "leaseSecs" => $leaseSecs];
        $params = array_merge($params, $optParams);
        $data = $this->__call("lease", [$params]);
        if ($this->useObjects()) {
            return new Google_Tasks($data);
        }
        return $data;
    }
}
/**
 * Service definition for Google_Taskqueue (v1beta2).
 *
 * <p>
 * Lets you access a Google App Engine Pull Task Queue over REST.
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="http://code.google.com/appengine/docs/python/taskqueue/rest.html" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_TaskqueueService extends Google_Service
{
    public $taskqueues = NULL;
    public $tasks = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "taskqueue/v1beta2/projects/";
        $this->version = "v1beta2";
        $this->serviceName = "taskqueue";
        $client->addService($this->serviceName, $this->version);
        $this->taskqueues = new Google_TaskqueuesServiceResource($this, $this->serviceName, "taskqueues", json_decode("{\"methods\": {\"get\": {\"scopes\": [\"https://www.googleapis.com/auth/taskqueue\", \"https://www.googleapis.com/auth/taskqueue.consumer\"], \"parameters\": {\"project\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"taskqueue\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"getStats\": {\"type\": \"boolean\", \"location\": \"query\"}}, \"id\": \"taskqueue.taskqueues.get\", \"httpMethod\": \"GET\", \"path\": \"{project}/taskqueues/{taskqueue}\", \"response\": {\"\$ref\": \"TaskQueue\"}}}}", true));
        $this->tasks = new Google_TasksServiceResource($this, $this->serviceName, "tasks", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/taskqueue\", \"https://www.googleapis.com/auth/taskqueue.consumer\"], \"parameters\": {\"project\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"taskqueue\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"Task\"}, \"response\": {\"\$ref\": \"Task\"}, \"httpMethod\": \"POST\", \"path\": \"{project}/taskqueues/{taskqueue}/tasks\", \"id\": \"taskqueue.tasks.insert\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/taskqueue\", \"https://www.googleapis.com/auth/taskqueue.consumer\"], \"parameters\": {\"project\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"taskqueue\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"task\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"taskqueue.tasks.get\", \"httpMethod\": \"GET\", \"path\": \"{project}/taskqueues/{taskqueue}/tasks/{task}\", \"response\": {\"\$ref\": \"Task\"}}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/taskqueue\", \"https://www.googleapis.com/auth/taskqueue.consumer\"], \"parameters\": {\"project\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"taskqueue\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"taskqueue.tasks.list\", \"httpMethod\": \"GET\", \"path\": \"{project}/taskqueues/{taskqueue}/tasks\", \"response\": {\"\$ref\": \"Tasks2\"}}, \"update\": {\"scopes\": [\"https://www.googleapis.com/auth/taskqueue\", \"https://www.googleapis.com/auth/taskqueue.consumer\"], \"parameters\": {\"project\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"taskqueue\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"task\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"newLeaseSeconds\": {\"required\": true, \"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}}, \"request\": {\"\$ref\": \"Task\"}, \"response\": {\"\$ref\": \"Task\"}, \"httpMethod\": \"POST\", \"path\": \"{project}/taskqueues/{taskqueue}/tasks/{task}\", \"id\": \"taskqueue.tasks.update\"}, \"patch\": {\"scopes\": [\"https://www.googleapis.com/auth/taskqueue\", \"https://www.googleapis.com/auth/taskqueue.consumer\"], \"parameters\": {\"project\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"taskqueue\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"task\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"newLeaseSeconds\": {\"required\": true, \"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}}, \"request\": {\"\$ref\": \"Task\"}, \"response\": {\"\$ref\": \"Task\"}, \"httpMethod\": \"PATCH\", \"path\": \"{project}/taskqueues/{taskqueue}/tasks/{task}\", \"id\": \"taskqueue.tasks.patch\"}, \"delete\": {\"scopes\": [\"https://www.googleapis.com/auth/taskqueue\", \"https://www.googleapis.com/auth/taskqueue.consumer\"], \"path\": \"{project}/taskqueues/{taskqueue}/tasks/{task}\", \"id\": \"taskqueue.tasks.delete\", \"parameters\": {\"project\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"taskqueue\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"task\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"httpMethod\": \"DELETE\"}, \"lease\": {\"scopes\": [\"https://www.googleapis.com/auth/taskqueue\", \"https://www.googleapis.com/auth/taskqueue.consumer\"], \"parameters\": {\"groupByTag\": {\"type\": \"boolean\", \"location\": \"query\"}, \"leaseSecs\": {\"required\": true, \"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}, \"project\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"taskqueue\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"tag\": {\"type\": \"string\", \"location\": \"query\"}, \"numTasks\": {\"required\": true, \"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}}, \"id\": \"taskqueue.tasks.lease\", \"httpMethod\": \"POST\", \"path\": \"{project}/taskqueues/{taskqueue}/tasks/lease\", \"response\": {\"\$ref\": \"Tasks\"}}}}", true));
    }
}
class Google_Task extends Google_Model
{
    public $kind = NULL;
    public $leaseTimestamp = NULL;
    public $id = NULL;
    public $tag = NULL;
    public $payloadBase64 = NULL;
    public $queueName = NULL;
    public $enqueueTimestamp = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setLeaseTimestamp($leaseTimestamp)
    {
        $this->leaseTimestamp = $leaseTimestamp;
    }
    public function getLeaseTimestamp()
    {
        return $this->leaseTimestamp;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setTag($tag)
    {
        $this->tag = $tag;
    }
    public function getTag()
    {
        return $this->tag;
    }
    public function setPayloadBase64($payloadBase64)
    {
        $this->payloadBase64 = $payloadBase64;
    }
    public function getPayloadBase64()
    {
        return $this->payloadBase64;
    }
    public function setQueueName($queueName)
    {
        $this->queueName = $queueName;
    }
    public function getQueueName()
    {
        return $this->queueName;
    }
    public function setEnqueueTimestamp($enqueueTimestamp)
    {
        $this->enqueueTimestamp = $enqueueTimestamp;
    }
    public function getEnqueueTimestamp()
    {
        return $this->enqueueTimestamp;
    }
}
class Google_TaskQueue extends Google_Model
{
    public $kind = NULL;
    protected $__statsType = "Google_TaskQueueStats";
    protected $__statsDataType = "";
    public $stats = NULL;
    public $id = NULL;
    public $maxLeases = NULL;
    protected $__aclType = "Google_TaskQueueAcl";
    protected $__aclDataType = "";
    public $acl = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setStats(Google_TaskQueueStats $stats)
    {
        $this->stats = $stats;
    }
    public function getStats()
    {
        return $this->stats;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setMaxLeases($maxLeases)
    {
        $this->maxLeases = $maxLeases;
    }
    public function getMaxLeases()
    {
        return $this->maxLeases;
    }
    public function setAcl(Google_TaskQueueAcl $acl)
    {
        $this->acl = $acl;
    }
    public function getAcl()
    {
        return $this->acl;
    }
}
class Google_TaskQueueAcl extends Google_Model
{
    public $consumerEmails = NULL;
    public $producerEmails = NULL;
    public $adminEmails = NULL;
    public function setConsumerEmails($consumerEmails)
    {
        $this->assertIsArray($consumerEmails, "Google_string", "Google_TaskQueueAcl::setConsumerEmails");
        $this->consumerEmails = $consumerEmails;
    }
    public function getConsumerEmails()
    {
        return $this->consumerEmails;
    }
    public function setProducerEmails($producerEmails)
    {
        $this->assertIsArray($producerEmails, "Google_string", "Google_TaskQueueAcl::setProducerEmails");
        $this->producerEmails = $producerEmails;
    }
    public function getProducerEmails()
    {
        return $this->producerEmails;
    }
    public function setAdminEmails($adminEmails)
    {
        $this->assertIsArray($adminEmails, "Google_string", "Google_TaskQueueAcl::setAdminEmails");
        $this->adminEmails = $adminEmails;
    }
    public function getAdminEmails()
    {
        return $this->adminEmails;
    }
}
class Google_TaskQueueStats extends Google_Model
{
    public $oldestTask = NULL;
    public $leasedLastMinute = NULL;
    public $totalTasks = NULL;
    public $leasedLastHour = NULL;
    public function setOldestTask($oldestTask)
    {
        $this->oldestTask = $oldestTask;
    }
    public function getOldestTask()
    {
        return $this->oldestTask;
    }
    public function setLeasedLastMinute($leasedLastMinute)
    {
        $this->leasedLastMinute = $leasedLastMinute;
    }
    public function getLeasedLastMinute()
    {
        return $this->leasedLastMinute;
    }
    public function setTotalTasks($totalTasks)
    {
        $this->totalTasks = $totalTasks;
    }
    public function getTotalTasks()
    {
        return $this->totalTasks;
    }
    public function setLeasedLastHour($leasedLastHour)
    {
        $this->leasedLastHour = $leasedLastHour;
    }
    public function getLeasedLastHour()
    {
        return $this->leasedLastHour;
    }
}
class Google_Tasks extends Google_Model
{
    protected $__itemsType = "Google_Task";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Task", "Google_Tasks::setItems");
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
class Google_Tasks2 extends Google_Model
{
    protected $__itemsType = "Google_Task";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Task", "Google_Tasks2::setItems");
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