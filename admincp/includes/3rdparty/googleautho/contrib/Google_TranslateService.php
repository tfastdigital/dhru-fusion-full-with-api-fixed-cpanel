<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "languages" collection of methods.
 * Typical usage is:
 *  <code>
 *   $translateService = new Google_TranslateService(...);
 *   $languages = $translateService->languages;
 *  </code>
 */
class Google_LanguagesServiceResource extends Google_ServiceResource
{
    public function listLanguages($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_LanguagesListResponse($data);
        }
        return $data;
    }
}
/**
 * The "detections" collection of methods.
 * Typical usage is:
 *  <code>
 *   $translateService = new Google_TranslateService(...);
 *   $detections = $translateService->detections;
 *  </code>
 */
class Google_DetectionsServiceResource extends Google_ServiceResource
{
    public function listDetections($q, $optParams = [])
    {
        $params = ["q" => $q];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_DetectionsListResponse($data);
        }
        return $data;
    }
}
/**
 * The "translations" collection of methods.
 * Typical usage is:
 *  <code>
 *   $translateService = new Google_TranslateService(...);
 *   $translations = $translateService->translations;
 *  </code>
 */
class Google_TranslationsServiceResource extends Google_ServiceResource
{
    public function listTranslations($q, $target, $optParams = [])
    {
        $params = ["q" => $q, "target" => $target];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_TranslationsListResponse($data);
        }
        return $data;
    }
}
/**
 * Service definition for Google_Translate (v2).
 *
 * <p>
 * Lets you translate text from one language to another
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="http://code.google.com/apis/language/translate/v2/using_rest.html" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_TranslateService extends Google_Service
{
    public $languages = NULL;
    public $detections = NULL;
    public $translations = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "language/translate/";
        $this->version = "v2";
        $this->serviceName = "translate";
        $client->addService($this->serviceName, $this->version);
        $this->languages = new Google_LanguagesServiceResource($this, $this->serviceName, "languages", json_decode("{\"methods\": {\"list\": {\"httpMethod\": \"GET\", \"response\": {\"\$ref\": \"LanguagesListResponse\"}, \"id\": \"language.languages.list\", \"parameters\": {\"target\": {\"type\": \"string\", \"location\": \"query\"}}, \"path\": \"v2/languages\"}}}", true));
        $this->detections = new Google_DetectionsServiceResource($this, $this->serviceName, "detections", json_decode("{\"methods\": {\"list\": {\"httpMethod\": \"GET\", \"response\": {\"\$ref\": \"DetectionsListResponse\"}, \"id\": \"language.detections.list\", \"parameters\": {\"q\": {\"repeated\": true, \"required\": true, \"type\": \"string\", \"location\": \"query\"}}, \"path\": \"v2/detect\"}}}", true));
        $this->translations = new Google_TranslationsServiceResource($this, $this->serviceName, "translations", json_decode("{\"methods\": {\"list\": {\"httpMethod\": \"GET\", \"response\": {\"\$ref\": \"TranslationsListResponse\"}, \"id\": \"language.translations.list\", \"parameters\": {\"q\": {\"repeated\": true, \"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"source\": {\"type\": \"string\", \"location\": \"query\"}, \"format\": {\"enum\": [\"html\", \"text\"], \"type\": \"string\", \"location\": \"query\"}, \"target\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"cid\": {\"repeated\": true, \"type\": \"string\", \"location\": \"query\"}}, \"path\": \"v2\"}}}", true));
    }
}
class Google_DetectionsListResponse extends Google_Model
{
    protected $__detectionsType = "Google_DetectionsResourceItems";
    protected $__detectionsDataType = "array";
    public $detections = NULL;
    public function setDetections($detections)
    {
        $this->assertIsArray($detections, "Google_DetectionsResourceItems", "Google_DetectionsListResponse::setDetections");
        $this->detections = $detections;
    }
    public function getDetections()
    {
        return $this->detections;
    }
}
class Google_DetectionsResourceItems extends Google_Model
{
    public $isReliable = NULL;
    public $confidence = NULL;
    public $language = NULL;
    public function setIsReliable($isReliable)
    {
        $this->isReliable = $isReliable;
    }
    public function getIsReliable()
    {
        return $this->isReliable;
    }
    public function setConfidence($confidence)
    {
        $this->confidence = $confidence;
    }
    public function getConfidence()
    {
        return $this->confidence;
    }
    public function setLanguage($language)
    {
        $this->language = $language;
    }
    public function getLanguage()
    {
        return $this->language;
    }
}
class Google_LanguagesListResponse extends Google_Model
{
    protected $__languagesType = "Google_LanguagesResource";
    protected $__languagesDataType = "array";
    public $languages = NULL;
    public function setLanguages($languages)
    {
        $this->assertIsArray($languages, "Google_LanguagesResource", "Google_LanguagesListResponse::setLanguages");
        $this->languages = $languages;
    }
    public function getLanguages()
    {
        return $this->languages;
    }
}
class Google_LanguagesResource extends Google_Model
{
    public $name = NULL;
    public $language = NULL;
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setLanguage($language)
    {
        $this->language = $language;
    }
    public function getLanguage()
    {
        return $this->language;
    }
}
class Google_TranslationsListResponse extends Google_Model
{
    protected $__translationsType = "Google_TranslationsResource";
    protected $__translationsDataType = "array";
    public $translations = NULL;
    public function setTranslations($translations)
    {
        $this->assertIsArray($translations, "Google_TranslationsResource", "Google_TranslationsListResponse::setTranslations");
        $this->translations = $translations;
    }
    public function getTranslations()
    {
        return $this->translations;
    }
}
class Google_TranslationsResource extends Google_Model
{
    public $detectedSourceLanguage = NULL;
    public $translatedText = NULL;
    public function setDetectedSourceLanguage($detectedSourceLanguage)
    {
        $this->detectedSourceLanguage = $detectedSourceLanguage;
    }
    public function getDetectedSourceLanguage()
    {
        return $this->detectedSourceLanguage;
    }
    public function setTranslatedText($translatedText)
    {
        $this->translatedText = $translatedText;
    }
    public function getTranslatedText()
    {
        return $this->translatedText;
    }
}

?>