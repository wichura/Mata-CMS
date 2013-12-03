<?php

/**
 * Description of IcoCMSClient
 *
 * @author marcinwiatr
 */
Yii::import("application.components.icoCMSClient.models.base.*");
Yii::import("application.components.icoCMSClient.models.*");
Yii::import("application.components.icoCMSClient.dependencies.*");
Yii::import("application.components.icoCMSClient.modules.*");
Yii::setPathOfAlias("icoCMSClient", dirname(__FILE__));

class IcoCMSClient extends CComponent {

    /**
     * The key identifier for the project
     * @var type String
     */
    public $projectKey;

    /**
     * Settings for db connection used to connect to the CMS
     * @var type array
     */
    public $db;
    private static $loggedInToCMS = null;
    public static $cmsUserName = null;
    public $generateCMSEditMarkup = true;

    /**
     * Flag if cache should be used
     * @var type 
     */
    public $cache = false;

    /**
     * Holds module-specific info
     * @var type 
     */
    public $modules;

    public function init() {

        if ($this->projectKey == null)
            throw new CHttpException(500, "Missing param project Key");
    }

    public function contentBlock() {
        return new IcoCMSContentBlockClient();
    }

    public function person() {
        return new IcoCMSPersonClient();
    }

    public function category() {
        return new IcoCMSCategoryClient();
    }

    public function country() {
        return new IcoCMSCountryClient();
    }

    public function post() {
        return new IcoCMSPostClient();
    }

    public function promoSpot() {
        return new IcoCMSPromoSpotClient();
    }

    public function media() {
        return new IcoCMSMediaClient();
    }

    public function project() {
        return new IcoCMSProjectClient();
    }

    public function product() {
        return new IcoCMSProductClient();
    }

    public function form($formId) {
        return new IcoCMSFormClient($formId);
    }

    public function comment($regionId) {
        return new IcoCMSCommentClient($regionId);
    }

    public function visualization() {
        return new IcoCMSVisualizationClient();
    }

    public function frontEndWidget() {
        Yii::app()->controller->widget('icoCMSClient.widgets.icoCMSClientFrontEndWidget.IcoCMSClientFrontEndWidget');
    }

    public static function isLoggedToCMS() {
        if (self::$loggedInToCMS === null) {
            self::$loggedInToCMS = false;

            $cookie = Yii::app()->getRequest()->getCookies()->itemAt(md5(Yii::app()->icoCMSClient->projectKey));

            if ($cookie != null) {
                $data = @unserialize($cookie->value);

                if ($data !== false) {

                    // Compare projectKey
                    if ($data["Project"]["ProjectKey"] == Yii::app()->icoCMSClient->projectKey) {
                        self::$cmsUserName = $data["UserName"];
                        self::$loggedInToCMS = true;
                    }
                }
            }
        }

        return self::$loggedInToCMS;
    }

}

abstract class BaseIcoCMSClient extends CComponent {

    /**
     * Gets model by id. If safe is set to false reset scope is applied;
     * @param type $id Number
     * @return type 
     */
    public function getById($id) {

        $model = $this->getModel();

        return $model->findByAttributes(
                        array(
                            "Id" => $id
                ));
    }

    protected abstract function getModel();

    public function getModuleId() {
        return $this->getModel()->getModuleId();
    }

    public function findByMeta($key, $value) {

        $model = $this->getModel();

        $models = $model->findAll();
        $retVal = null;

        foreach ($models as $model) {
            if ($model->getMeta($key) == $value) {
                $retVal = $model;
                break;
            }
        }

        return $retVal;
    }

    public function findAllByAttributes($attributes = array(), $condition = array(), $params = "") {
        return $this->normalizeList($this->getModel()->findAllByAttributes($attributes, $condition, $params));
    }

    public function findByAttributes($attributes = array(), $condition = array(), $params = "") {
        return $this->getModel()->findByAttributes($attributes, $condition, $params);
    }

    public function findAllBySql($sql, $params = array()) {
        return $this->getModel()->findAllBySql($sql, $params);
    }

    public function findBySql($sql, $params = array()) {
        return $this->getModel()->findBySql($sql, $params);
    }

    public function findByPk($pk) {
        return $this->getModel()->findByPk($pk);
    }

    public function findAll($condition = array(), $params = array(), $orderContext = null) {

        if ($this->getModel()->hasAttribute("ContentLanguage") && !isset($condition["condition"]))
            $condition = "ContentLanguage = '" . Yii::app()->getLanguage() . "'";

        if ($orderContext != null) {
            return $this->getModel()->order($orderContext)->findAll($condition, $params);
        } else {
            return $this->normalizeList($this->getModel()->findAll($condition, $params));
        }
    }

    /**
     * Removes models set to be destroyed from the rs
     */
    protected function normalizeList($rs) {

        $retVal = array();
        foreach ($rs as $model) {
            if ($model->setToDestroy == false)
                array_push($retVal, $model);
        }

        return $retVal;
    }

    protected function getConfig() {
        return Yii::app()->icoCMSClient->modules[strtolower(get_class($this->getModel()))];
    }

    /**
     * Outputs content in a format understandable to the CMS. 
     * @param String $content
     * @param int $modelId 
     */
    public function render($content, $modelId, $action = null) {
        if (Yii::app()->icoCMSClient->generateCMSEditMarkup && $modelId != null) {

            $modelName = get_class($this->getModel());
            $contentToRender = "<div class='icoCMSEditableSection " . strtolower($modelName[0]) . substr($modelName, 1) . "' ref='" . $modelId . "' ";

            if ($action != null) {
                $contentToRender .= "action='" . $action . "' ";
            }

            $contentToRender .= ">" . $content . "</div>";

            echo $contentToRender;
        } else {
            echo $content;
        }
    }

    public function findAllForCategory($categoryId, $pageSize = null) {

        $client = new IcoCMSCategoryClient();
        $items = $client->getItemsForCategory($categoryId);

        if (empty($items) || $items == null)
            return array();

        $itemIds = array();

        foreach ($items as $item) {
            array_push($itemIds, $item->ItemId);
        }

        $condition = array(
            "condition" => "Id in (" . implode(",", $itemIds) . ")"
        );

        if ($pageSize != null) {
            $condition = array_merge($condition, array(
                "limit" => $pageSize,
                "offset" => $pageSize * ($this->getCurrentPage() - 1),
                "condition" => "ContentLanguage = '" . Yii::app()->language . "'"
                    ));
            $this->totalNoOfPages = ceil($this->getModel()->count($condition) / $pageSize);
        }



        return $this->findAll($pageSize, $condition);
    }

}

?>
