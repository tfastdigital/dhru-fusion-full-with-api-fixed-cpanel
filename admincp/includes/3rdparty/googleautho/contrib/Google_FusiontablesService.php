<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "column" collection of methods.
 * Typical usage is:
 *  <code>
 *   $fusiontablesService = new Google_FusiontablesService(...);
 *   $column = $fusiontablesService->column;
 *  </code>
 */
class Google_ColumnServiceResource extends Google_ServiceResource
{
    public function insert($tableId, Google_Column $postBody, $optParams = [])
    {
        $params = ["tableId" => $tableId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_Column($data);
        }
        return $data;
    }
    public function get($tableId, $columnId, $optParams = [])
    {
        $params = ["tableId" => $tableId, "columnId" => $columnId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Column($data);
        }
        return $data;
    }
    public function listColumn($tableId, $optParams = [])
    {
        $params = ["tableId" => $tableId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_ColumnList($data);
        }
        return $data;
    }
    public function update($tableId, $columnId, Google_Column $postBody, $optParams = [])
    {
        $params = ["tableId" => $tableId, "columnId" => $columnId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("update", [$params]);
        if ($this->useObjects()) {
            return new Google_Column($data);
        }
        return $data;
    }
    public function patch($tableId, $columnId, Google_Column $postBody, $optParams = [])
    {
        $params = ["tableId" => $tableId, "columnId" => $columnId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("patch", [$params]);
        if ($this->useObjects()) {
            return new Google_Column($data);
        }
        return $data;
    }
    public function delete($tableId, $columnId, $optParams = [])
    {
        $params = ["tableId" => $tableId, "columnId" => $columnId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("delete", [$params]);
        return $data;
    }
}
/**
 * The "query" collection of methods.
 * Typical usage is:
 *  <code>
 *   $fusiontablesService = new Google_FusiontablesService(...);
 *   $query = $fusiontablesService->query;
 *  </code>
 */
class Google_QueryServiceResource extends Google_ServiceResource
{
    public function sqlGet($sql, $optParams = [])
    {
        $params = ["sql" => $sql];
        $params = array_merge($params, $optParams);
        $data = $this->__call("sqlGet", [$params]);
        if ($this->useObjects()) {
            return new Google_Sqlresponse($data);
        }
        return $data;
    }
    public function sql($sql, $optParams = [])
    {
        $params = ["sql" => $sql];
        $params = array_merge($params, $optParams);
        $data = $this->__call("sql", [$params]);
        if ($this->useObjects()) {
            return new Google_Sqlresponse($data);
        }
        return $data;
    }
}
/**
 * The "style" collection of methods.
 * Typical usage is:
 *  <code>
 *   $fusiontablesService = new Google_FusiontablesService(...);
 *   $style = $fusiontablesService->style;
 *  </code>
 */
class Google_StyleServiceResource extends Google_ServiceResource
{
    public function insert($tableId, Google_StyleSetting $postBody, $optParams = [])
    {
        $params = ["tableId" => $tableId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_StyleSetting($data);
        }
        return $data;
    }
    public function get($tableId, $styleId, $optParams = [])
    {
        $params = ["tableId" => $tableId, "styleId" => $styleId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_StyleSetting($data);
        }
        return $data;
    }
    public function listStyle($tableId, $optParams = [])
    {
        $params = ["tableId" => $tableId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_StyleSettingList($data);
        }
        return $data;
    }
    public function update($tableId, $styleId, Google_StyleSetting $postBody, $optParams = [])
    {
        $params = ["tableId" => $tableId, "styleId" => $styleId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("update", [$params]);
        if ($this->useObjects()) {
            return new Google_StyleSetting($data);
        }
        return $data;
    }
    public function patch($tableId, $styleId, Google_StyleSetting $postBody, $optParams = [])
    {
        $params = ["tableId" => $tableId, "styleId" => $styleId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("patch", [$params]);
        if ($this->useObjects()) {
            return new Google_StyleSetting($data);
        }
        return $data;
    }
    public function delete($tableId, $styleId, $optParams = [])
    {
        $params = ["tableId" => $tableId, "styleId" => $styleId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("delete", [$params]);
        return $data;
    }
}
/**
 * The "template" collection of methods.
 * Typical usage is:
 *  <code>
 *   $fusiontablesService = new Google_FusiontablesService(...);
 *   $template = $fusiontablesService->template;
 *  </code>
 */
class Google_TemplateServiceResource extends Google_ServiceResource
{
    public function insert($tableId, Google_Template $postBody, $optParams = [])
    {
        $params = ["tableId" => $tableId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_Template($data);
        }
        return $data;
    }
    public function get($tableId, $templateId, $optParams = [])
    {
        $params = ["tableId" => $tableId, "templateId" => $templateId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Template($data);
        }
        return $data;
    }
    public function listTemplate($tableId, $optParams = [])
    {
        $params = ["tableId" => $tableId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_TemplateList($data);
        }
        return $data;
    }
    public function update($tableId, $templateId, Google_Template $postBody, $optParams = [])
    {
        $params = ["tableId" => $tableId, "templateId" => $templateId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("update", [$params]);
        if ($this->useObjects()) {
            return new Google_Template($data);
        }
        return $data;
    }
    public function patch($tableId, $templateId, Google_Template $postBody, $optParams = [])
    {
        $params = ["tableId" => $tableId, "templateId" => $templateId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("patch", [$params]);
        if ($this->useObjects()) {
            return new Google_Template($data);
        }
        return $data;
    }
    public function delete($tableId, $templateId, $optParams = [])
    {
        $params = ["tableId" => $tableId, "templateId" => $templateId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("delete", [$params]);
        return $data;
    }
}
/**
 * The "table" collection of methods.
 * Typical usage is:
 *  <code>
 *   $fusiontablesService = new Google_FusiontablesService(...);
 *   $table = $fusiontablesService->table;
 *  </code>
 */
class Google_TableServiceResource extends Google_ServiceResource
{
    public function insert(Google_Table $postBody, $optParams = [])
    {
        $params = ["postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_Table($data);
        }
        return $data;
    }
    public function get($tableId, $optParams = [])
    {
        $params = ["tableId" => $tableId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Table($data);
        }
        return $data;
    }
    public function listTable($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_TableList($data);
        }
        return $data;
    }
    public function update($tableId, Google_Table $postBody, $optParams = [])
    {
        $params = ["tableId" => $tableId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("update", [$params]);
        if ($this->useObjects()) {
            return new Google_Table($data);
        }
        return $data;
    }
    public function patch($tableId, Google_Table $postBody, $optParams = [])
    {
        $params = ["tableId" => $tableId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("patch", [$params]);
        if ($this->useObjects()) {
            return new Google_Table($data);
        }
        return $data;
    }
    public function delete($tableId, $optParams = [])
    {
        $params = ["tableId" => $tableId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("delete", [$params]);
        return $data;
    }
}
/**
 * Service definition for Google_Fusiontables (v1).
 *
 * <p>
 * API for working with Fusion Tables data.
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="https://developers.google.com/fusiontables" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_FusiontablesService extends Google_Service
{
    public $column = NULL;
    public $query = NULL;
    public $style = NULL;
    public $template = NULL;
    public $table = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "fusiontables/v1/";
        $this->version = "v1";
        $this->serviceName = "fusiontables";
        $client->addService($this->serviceName, $this->version);
        $this->column = new Google_ColumnServiceResource($this, $this->serviceName, "column", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\"], \"parameters\": {\"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"Column\"}, \"response\": {\"\$ref\": \"Column\"}, \"httpMethod\": \"POST\", \"path\": \"tables/{tableId}/columns\", \"id\": \"fusiontables.column.insert\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\", \"https://www.googleapis.com/auth/fusiontables.readonly\"], \"parameters\": {\"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"columnId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"fusiontables.column.get\", \"httpMethod\": \"GET\", \"path\": \"tables/{tableId}/columns/{columnId}\", \"response\": {\"\$ref\": \"Column\"}}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\", \"https://www.googleapis.com/auth/fusiontables.readonly\"], \"parameters\": {\"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"maxResults\": {\"minimum\": \"0\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}}, \"id\": \"fusiontables.column.list\", \"httpMethod\": \"GET\", \"path\": \"tables/{tableId}/columns\", \"response\": {\"\$ref\": \"ColumnList\"}}, \"update\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\"], \"parameters\": {\"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"columnId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"Column\"}, \"response\": {\"\$ref\": \"Column\"}, \"httpMethod\": \"PUT\", \"path\": \"tables/{tableId}/columns/{columnId}\", \"id\": \"fusiontables.column.update\"}, \"patch\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\"], \"parameters\": {\"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"columnId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"Column\"}, \"response\": {\"\$ref\": \"Column\"}, \"httpMethod\": \"PATCH\", \"path\": \"tables/{tableId}/columns/{columnId}\", \"id\": \"fusiontables.column.patch\"}, \"delete\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\"], \"path\": \"tables/{tableId}/columns/{columnId}\", \"id\": \"fusiontables.column.delete\", \"parameters\": {\"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"columnId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"httpMethod\": \"DELETE\"}}}", true));
        $this->query = new Google_QueryServiceResource($this, $this->serviceName, "query", json_decode("{\"methods\": {\"sqlGet\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\", \"https://www.googleapis.com/auth/fusiontables.readonly\"], \"parameters\": {\"typed\": {\"type\": \"boolean\", \"location\": \"query\"}, \"hdrs\": {\"type\": \"boolean\", \"location\": \"query\"}, \"sql\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}}, \"id\": \"fusiontables.query.sqlGet\", \"httpMethod\": \"GET\", \"path\": \"query\", \"response\": {\"\$ref\": \"Sqlresponse\"}}, \"sql\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\", \"https://www.googleapis.com/auth/fusiontables.readonly\"], \"parameters\": {\"typed\": {\"type\": \"boolean\", \"location\": \"query\"}, \"hdrs\": {\"type\": \"boolean\", \"location\": \"query\"}, \"sql\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}}, \"id\": \"fusiontables.query.sql\", \"httpMethod\": \"POST\", \"path\": \"query\", \"response\": {\"\$ref\": \"Sqlresponse\"}}}}", true));
        $this->style = new Google_StyleServiceResource($this, $this->serviceName, "style", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\"], \"parameters\": {\"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"StyleSetting\"}, \"response\": {\"\$ref\": \"StyleSetting\"}, \"httpMethod\": \"POST\", \"path\": \"tables/{tableId}/styles\", \"id\": \"fusiontables.style.insert\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\", \"https://www.googleapis.com/auth/fusiontables.readonly\"], \"parameters\": {\"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"styleId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"int32\"}}, \"id\": \"fusiontables.style.get\", \"httpMethod\": \"GET\", \"path\": \"tables/{tableId}/styles/{styleId}\", \"response\": {\"\$ref\": \"StyleSetting\"}}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\", \"https://www.googleapis.com/auth/fusiontables.readonly\"], \"parameters\": {\"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"maxResults\": {\"minimum\": \"0\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}}, \"id\": \"fusiontables.style.list\", \"httpMethod\": \"GET\", \"path\": \"tables/{tableId}/styles\", \"response\": {\"\$ref\": \"StyleSettingList\"}}, \"update\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\"], \"parameters\": {\"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"styleId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"int32\"}}, \"request\": {\"\$ref\": \"StyleSetting\"}, \"response\": {\"\$ref\": \"StyleSetting\"}, \"httpMethod\": \"PUT\", \"path\": \"tables/{tableId}/styles/{styleId}\", \"id\": \"fusiontables.style.update\"}, \"patch\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\"], \"parameters\": {\"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"styleId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"int32\"}}, \"request\": {\"\$ref\": \"StyleSetting\"}, \"response\": {\"\$ref\": \"StyleSetting\"}, \"httpMethod\": \"PATCH\", \"path\": \"tables/{tableId}/styles/{styleId}\", \"id\": \"fusiontables.style.patch\"}, \"delete\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\"], \"path\": \"tables/{tableId}/styles/{styleId}\", \"id\": \"fusiontables.style.delete\", \"parameters\": {\"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"styleId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"int32\"}}, \"httpMethod\": \"DELETE\"}}}", true));
        $this->template = new Google_TemplateServiceResource($this, $this->serviceName, "template", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\"], \"parameters\": {\"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"Template\"}, \"response\": {\"\$ref\": \"Template\"}, \"httpMethod\": \"POST\", \"path\": \"tables/{tableId}/templates\", \"id\": \"fusiontables.template.insert\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\", \"https://www.googleapis.com/auth/fusiontables.readonly\"], \"parameters\": {\"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"templateId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"int32\"}}, \"id\": \"fusiontables.template.get\", \"httpMethod\": \"GET\", \"path\": \"tables/{tableId}/templates/{templateId}\", \"response\": {\"\$ref\": \"Template\"}}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\", \"https://www.googleapis.com/auth/fusiontables.readonly\"], \"parameters\": {\"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"maxResults\": {\"minimum\": \"0\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}}, \"id\": \"fusiontables.template.list\", \"httpMethod\": \"GET\", \"path\": \"tables/{tableId}/templates\", \"response\": {\"\$ref\": \"TemplateList\"}}, \"update\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\"], \"parameters\": {\"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"templateId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"int32\"}}, \"request\": {\"\$ref\": \"Template\"}, \"response\": {\"\$ref\": \"Template\"}, \"httpMethod\": \"PUT\", \"path\": \"tables/{tableId}/templates/{templateId}\", \"id\": \"fusiontables.template.update\"}, \"patch\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\"], \"parameters\": {\"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"templateId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"int32\"}}, \"request\": {\"\$ref\": \"Template\"}, \"response\": {\"\$ref\": \"Template\"}, \"httpMethod\": \"PATCH\", \"path\": \"tables/{tableId}/templates/{templateId}\", \"id\": \"fusiontables.template.patch\"}, \"delete\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\"], \"path\": \"tables/{tableId}/templates/{templateId}\", \"id\": \"fusiontables.template.delete\", \"parameters\": {\"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"templateId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"int32\"}}, \"httpMethod\": \"DELETE\"}}}", true));
        $this->table = new Google_TableServiceResource($this, $this->serviceName, "table", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\"], \"request\": {\"\$ref\": \"Table\"}, \"response\": {\"\$ref\": \"Table\"}, \"httpMethod\": \"POST\", \"path\": \"tables\", \"id\": \"fusiontables.table.insert\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\", \"https://www.googleapis.com/auth/fusiontables.readonly\"], \"parameters\": {\"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"fusiontables.table.get\", \"httpMethod\": \"GET\", \"path\": \"tables/{tableId}\", \"response\": {\"\$ref\": \"Table\"}}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\", \"https://www.googleapis.com/auth/fusiontables.readonly\"], \"parameters\": {\"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"maxResults\": {\"minimum\": \"0\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}}, \"response\": {\"\$ref\": \"TableList\"}, \"httpMethod\": \"GET\", \"path\": \"tables\", \"id\": \"fusiontables.table.list\"}, \"update\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\"], \"parameters\": {\"replaceViewDefinition\": {\"type\": \"boolean\", \"location\": \"query\"}, \"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"Table\"}, \"response\": {\"\$ref\": \"Table\"}, \"httpMethod\": \"PUT\", \"path\": \"tables/{tableId}\", \"id\": \"fusiontables.table.update\"}, \"patch\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\"], \"parameters\": {\"replaceViewDefinition\": {\"type\": \"boolean\", \"location\": \"query\"}, \"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"Table\"}, \"response\": {\"\$ref\": \"Table\"}, \"httpMethod\": \"PATCH\", \"path\": \"tables/{tableId}\", \"id\": \"fusiontables.table.patch\"}, \"delete\": {\"scopes\": [\"https://www.googleapis.com/auth/fusiontables\"], \"path\": \"tables/{tableId}\", \"id\": \"fusiontables.table.delete\", \"parameters\": {\"tableId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"httpMethod\": \"DELETE\"}}}", true));
    }
}
class Google_Bucket extends Google_Model
{
    public $opacity = NULL;
    public $weight = NULL;
    public $min = NULL;
    public $color = NULL;
    public $max = NULL;
    public $icon = NULL;
    public function setOpacity($opacity)
    {
        $this->opacity = $opacity;
    }
    public function getOpacity()
    {
        return $this->opacity;
    }
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
    public function getWeight()
    {
        return $this->weight;
    }
    public function setMin($min)
    {
        $this->min = $min;
    }
    public function getMin()
    {
        return $this->min;
    }
    public function setColor($color)
    {
        $this->color = $color;
    }
    public function getColor()
    {
        return $this->color;
    }
    public function setMax($max)
    {
        $this->max = $max;
    }
    public function getMax()
    {
        return $this->max;
    }
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }
    public function getIcon()
    {
        return $this->icon;
    }
}
class Google_Column extends Google_Model
{
    public $kind = NULL;
    public $type = NULL;
    public $columnId = NULL;
    public $name = NULL;
    protected $__baseColumnType = "Google_ColumnBaseColumn";
    protected $__baseColumnDataType = "";
    public $baseColumn = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setColumnId($columnId)
    {
        $this->columnId = $columnId;
    }
    public function getColumnId()
    {
        return $this->columnId;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setBaseColumn(Google_ColumnBaseColumn $baseColumn)
    {
        $this->baseColumn = $baseColumn;
    }
    public function getBaseColumn()
    {
        return $this->baseColumn;
    }
}
class Google_ColumnBaseColumn extends Google_Model
{
    public $tableIndex = NULL;
    public $columnId = NULL;
    public function setTableIndex($tableIndex)
    {
        $this->tableIndex = $tableIndex;
    }
    public function getTableIndex()
    {
        return $this->tableIndex;
    }
    public function setColumnId($columnId)
    {
        $this->columnId = $columnId;
    }
    public function getColumnId()
    {
        return $this->columnId;
    }
}
class Google_ColumnList extends Google_Model
{
    public $nextPageToken = NULL;
    protected $__itemsType = "Google_Column";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public $totalItems = NULL;
    public function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }
    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Column", "Google_ColumnList::setItems");
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
    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;
    }
    public function getTotalItems()
    {
        return $this->totalItems;
    }
}
class Google_Geometry extends Google_Model
{
    public $geometry = NULL;
    public $type = NULL;
    public $geometries = NULL;
    public function setGeometry($geometry)
    {
        $this->geometry = $geometry;
    }
    public function getGeometry()
    {
        return $this->geometry;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setGeometries($geometries)
    {
        $this->assertIsArray($geometries, "Google_object", "Google_Geometry::setGeometries");
        $this->geometries = $geometries;
    }
    public function getGeometries()
    {
        return $this->geometries;
    }
}
class Google_Line extends Google_Model
{
    public $type = NULL;
    public $coordinates = NULL;
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setCoordinates($coordinates)
    {
        $this->assertIsArray($coordinates, "Google_double", "Google_Line::setCoordinates");
        $this->coordinates = $coordinates;
    }
    public function getCoordinates()
    {
        return $this->coordinates;
    }
}
class Google_LineStyle extends Google_Model
{
    public $strokeWeight = NULL;
    protected $__strokeWeightStylerType = "Google_StyleFunction";
    protected $__strokeWeightStylerDataType = "";
    public $strokeWeightStyler = NULL;
    public $strokeColor = NULL;
    public $strokeOpacity = NULL;
    protected $__strokeColorStylerType = "Google_StyleFunction";
    protected $__strokeColorStylerDataType = "";
    public $strokeColorStyler = NULL;
    public function setStrokeWeight($strokeWeight)
    {
        $this->strokeWeight = $strokeWeight;
    }
    public function getStrokeWeight()
    {
        return $this->strokeWeight;
    }
    public function setStrokeWeightStyler(Google_StyleFunction $strokeWeightStyler)
    {
        $this->strokeWeightStyler = $strokeWeightStyler;
    }
    public function getStrokeWeightStyler()
    {
        return $this->strokeWeightStyler;
    }
    public function setStrokeColor($strokeColor)
    {
        $this->strokeColor = $strokeColor;
    }
    public function getStrokeColor()
    {
        return $this->strokeColor;
    }
    public function setStrokeOpacity($strokeOpacity)
    {
        $this->strokeOpacity = $strokeOpacity;
    }
    public function getStrokeOpacity()
    {
        return $this->strokeOpacity;
    }
    public function setStrokeColorStyler(Google_StyleFunction $strokeColorStyler)
    {
        $this->strokeColorStyler = $strokeColorStyler;
    }
    public function getStrokeColorStyler()
    {
        return $this->strokeColorStyler;
    }
}
class Google_Point extends Google_Model
{
    public $type = NULL;
    public $coordinates = NULL;
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setCoordinates($coordinates)
    {
        $this->assertIsArray($coordinates, "Google_double", "Google_Point::setCoordinates");
        $this->coordinates = $coordinates;
    }
    public function getCoordinates()
    {
        return $this->coordinates;
    }
}
class Google_PointStyle extends Google_Model
{
    protected $__iconStylerType = "Google_StyleFunction";
    protected $__iconStylerDataType = "";
    public $iconStyler = NULL;
    public $iconName = NULL;
    public function setIconStyler(Google_StyleFunction $iconStyler)
    {
        $this->iconStyler = $iconStyler;
    }
    public function getIconStyler()
    {
        return $this->iconStyler;
    }
    public function setIconName($iconName)
    {
        $this->iconName = $iconName;
    }
    public function getIconName()
    {
        return $this->iconName;
    }
}
class Google_Polygon extends Google_Model
{
    public $type = NULL;
    public $coordinates = NULL;
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setCoordinates($coordinates)
    {
        $this->assertIsArray($coordinates, "Google_double", "Google_Polygon::setCoordinates");
        $this->coordinates = $coordinates;
    }
    public function getCoordinates()
    {
        return $this->coordinates;
    }
}
class Google_PolygonStyle extends Google_Model
{
    protected $__strokeColorStylerType = "Google_StyleFunction";
    protected $__strokeColorStylerDataType = "";
    public $strokeColorStyler = NULL;
    public $strokeWeight = NULL;
    public $strokeOpacity = NULL;
    protected $__strokeWeightStylerType = "Google_StyleFunction";
    protected $__strokeWeightStylerDataType = "";
    public $strokeWeightStyler = NULL;
    protected $__fillColorStylerType = "Google_StyleFunction";
    protected $__fillColorStylerDataType = "";
    public $fillColorStyler = NULL;
    public $fillColor = NULL;
    public $strokeColor = NULL;
    public $fillOpacity = NULL;
    public function setStrokeColorStyler(Google_StyleFunction $strokeColorStyler)
    {
        $this->strokeColorStyler = $strokeColorStyler;
    }
    public function getStrokeColorStyler()
    {
        return $this->strokeColorStyler;
    }
    public function setStrokeWeight($strokeWeight)
    {
        $this->strokeWeight = $strokeWeight;
    }
    public function getStrokeWeight()
    {
        return $this->strokeWeight;
    }
    public function setStrokeOpacity($strokeOpacity)
    {
        $this->strokeOpacity = $strokeOpacity;
    }
    public function getStrokeOpacity()
    {
        return $this->strokeOpacity;
    }
    public function setStrokeWeightStyler(Google_StyleFunction $strokeWeightStyler)
    {
        $this->strokeWeightStyler = $strokeWeightStyler;
    }
    public function getStrokeWeightStyler()
    {
        return $this->strokeWeightStyler;
    }
    public function setFillColorStyler(Google_StyleFunction $fillColorStyler)
    {
        $this->fillColorStyler = $fillColorStyler;
    }
    public function getFillColorStyler()
    {
        return $this->fillColorStyler;
    }
    public function setFillColor($fillColor)
    {
        $this->fillColor = $fillColor;
    }
    public function getFillColor()
    {
        return $this->fillColor;
    }
    public function setStrokeColor($strokeColor)
    {
        $this->strokeColor = $strokeColor;
    }
    public function getStrokeColor()
    {
        return $this->strokeColor;
    }
    public function setFillOpacity($fillOpacity)
    {
        $this->fillOpacity = $fillOpacity;
    }
    public function getFillOpacity()
    {
        return $this->fillOpacity;
    }
}
class Google_Sqlresponse extends Google_Model
{
    public $kind = NULL;
    public $rows = NULL;
    public $columns = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setRows($rows)
    {
        $this->assertIsArray($rows, "Google_object", "Google_Sqlresponse::setRows");
        $this->rows = $rows;
    }
    public function getRows()
    {
        return $this->rows;
    }
    public function setColumns($columns)
    {
        $this->assertIsArray($columns, "Google_string", "Google_Sqlresponse::setColumns");
        $this->columns = $columns;
    }
    public function getColumns()
    {
        return $this->columns;
    }
}
class Google_StyleFunction extends Google_Model
{
    protected $__gradientType = "Google_StyleFunctionGradient";
    protected $__gradientDataType = "";
    public $gradient = NULL;
    public $columnName = NULL;
    protected $__bucketsType = "Google_Bucket";
    protected $__bucketsDataType = "array";
    public $buckets = NULL;
    public $kind = NULL;
    public function setGradient(Google_StyleFunctionGradient $gradient)
    {
        $this->gradient = $gradient;
    }
    public function getGradient()
    {
        return $this->gradient;
    }
    public function setColumnName($columnName)
    {
        $this->columnName = $columnName;
    }
    public function getColumnName()
    {
        return $this->columnName;
    }
    public function setBuckets($buckets)
    {
        $this->assertIsArray($buckets, "Google_Bucket", "Google_StyleFunction::setBuckets");
        $this->buckets = $buckets;
    }
    public function getBuckets()
    {
        return $this->buckets;
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
class Google_StyleFunctionGradient extends Google_Model
{
    public $max = NULL;
    protected $__colorsType = "Google_StyleFunctionGradientColors";
    protected $__colorsDataType = "array";
    public $colors = NULL;
    public $min = NULL;
    public function setMax($max)
    {
        $this->max = $max;
    }
    public function getMax()
    {
        return $this->max;
    }
    public function setColors($colors)
    {
        $this->assertIsArray($colors, "Google_StyleFunctionGradientColors", "Google_StyleFunctionGradient::setColors");
        $this->colors = $colors;
    }
    public function getColors()
    {
        return $this->colors;
    }
    public function setMin($min)
    {
        $this->min = $min;
    }
    public function getMin()
    {
        return $this->min;
    }
}
class Google_StyleFunctionGradientColors extends Google_Model
{
    public $color = NULL;
    public $opacity = NULL;
    public function setColor($color)
    {
        $this->color = $color;
    }
    public function getColor()
    {
        return $this->color;
    }
    public function setOpacity($opacity)
    {
        $this->opacity = $opacity;
    }
    public function getOpacity()
    {
        return $this->opacity;
    }
}
class Google_StyleSetting extends Google_Model
{
    protected $__markerOptionsType = "Google_PointStyle";
    protected $__markerOptionsDataType = "";
    public $markerOptions = NULL;
    public $kind = NULL;
    public $name = NULL;
    protected $__polygonOptionsType = "Google_PolygonStyle";
    protected $__polygonOptionsDataType = "";
    public $polygonOptions = NULL;
    public $isDefaultForTable = NULL;
    protected $__polylineOptionsType = "Google_LineStyle";
    protected $__polylineOptionsDataType = "";
    public $polylineOptions = NULL;
    public $tableId = NULL;
    public $styleId = NULL;
    public function setMarkerOptions(Google_PointStyle $markerOptions)
    {
        $this->markerOptions = $markerOptions;
    }
    public function getMarkerOptions()
    {
        return $this->markerOptions;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setPolygonOptions(Google_PolygonStyle $polygonOptions)
    {
        $this->polygonOptions = $polygonOptions;
    }
    public function getPolygonOptions()
    {
        return $this->polygonOptions;
    }
    public function setIsDefaultForTable($isDefaultForTable)
    {
        $this->isDefaultForTable = $isDefaultForTable;
    }
    public function getIsDefaultForTable()
    {
        return $this->isDefaultForTable;
    }
    public function setPolylineOptions(Google_LineStyle $polylineOptions)
    {
        $this->polylineOptions = $polylineOptions;
    }
    public function getPolylineOptions()
    {
        return $this->polylineOptions;
    }
    public function setTableId($tableId)
    {
        $this->tableId = $tableId;
    }
    public function getTableId()
    {
        return $this->tableId;
    }
    public function setStyleId($styleId)
    {
        $this->styleId = $styleId;
    }
    public function getStyleId()
    {
        return $this->styleId;
    }
}
class Google_StyleSettingList extends Google_Model
{
    public $nextPageToken = NULL;
    protected $__itemsType = "Google_StyleSetting";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public $totalItems = NULL;
    public function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }
    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_StyleSetting", "Google_StyleSettingList::setItems");
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
    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;
    }
    public function getTotalItems()
    {
        return $this->totalItems;
    }
}
class Google_Table extends Google_Model
{
    public $kind = NULL;
    public $attribution = NULL;
    public $description = NULL;
    public $isExportable = NULL;
    public $baseTableIds = NULL;
    public $attributionLink = NULL;
    public $sql = NULL;
    public $tableId = NULL;
    protected $__columnsType = "Google_Column";
    protected $__columnsDataType = "array";
    public $columns = NULL;
    public $name = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setAttribution($attribution)
    {
        $this->attribution = $attribution;
    }
    public function getAttribution()
    {
        return $this->attribution;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setIsExportable($isExportable)
    {
        $this->isExportable = $isExportable;
    }
    public function getIsExportable()
    {
        return $this->isExportable;
    }
    public function setBaseTableIds($baseTableIds)
    {
        $this->assertIsArray($baseTableIds, "Google_string", "Google_Table::setBaseTableIds");
        $this->baseTableIds = $baseTableIds;
    }
    public function getBaseTableIds()
    {
        return $this->baseTableIds;
    }
    public function setAttributionLink($attributionLink)
    {
        $this->attributionLink = $attributionLink;
    }
    public function getAttributionLink()
    {
        return $this->attributionLink;
    }
    public function setSql($sql)
    {
        $this->sql = $sql;
    }
    public function getSql()
    {
        return $this->sql;
    }
    public function setTableId($tableId)
    {
        $this->tableId = $tableId;
    }
    public function getTableId()
    {
        return $this->tableId;
    }
    public function setColumns($columns)
    {
        $this->assertIsArray($columns, "Google_Column", "Google_Table::setColumns");
        $this->columns = $columns;
    }
    public function getColumns()
    {
        return $this->columns;
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
class Google_TableList extends Google_Model
{
    public $nextPageToken = NULL;
    protected $__itemsType = "Google_Table";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }
    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Table", "Google_TableList::setItems");
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
class Google_Template extends Google_Model
{
    public $body = NULL;
    public $kind = NULL;
    public $name = NULL;
    public $automaticColumnNames = NULL;
    public $isDefaultForTable = NULL;
    public $tableId = NULL;
    public $templateId = NULL;
    public function setBody($body)
    {
        $this->body = $body;
    }
    public function getBody()
    {
        return $this->body;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setAutomaticColumnNames($automaticColumnNames)
    {
        $this->assertIsArray($automaticColumnNames, "Google_string", "Google_Template::setAutomaticColumnNames");
        $this->automaticColumnNames = $automaticColumnNames;
    }
    public function getAutomaticColumnNames()
    {
        return $this->automaticColumnNames;
    }
    public function setIsDefaultForTable($isDefaultForTable)
    {
        $this->isDefaultForTable = $isDefaultForTable;
    }
    public function getIsDefaultForTable()
    {
        return $this->isDefaultForTable;
    }
    public function setTableId($tableId)
    {
        $this->tableId = $tableId;
    }
    public function getTableId()
    {
        return $this->tableId;
    }
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;
    }
    public function getTemplateId()
    {
        return $this->templateId;
    }
}
class Google_TemplateList extends Google_Model
{
    public $nextPageToken = NULL;
    protected $__itemsType = "Google_Template";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public $totalItems = NULL;
    public function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }
    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Template", "Google_TemplateList::setItems");
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
    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;
    }
    public function getTotalItems()
    {
        return $this->totalItems;
    }
}

?>