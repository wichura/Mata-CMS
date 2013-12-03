<?php

/**
 * Description of IcoCMSEditorialClient
 *
 * @author marcinwiatr
 */
class IcoCMSPostClient extends BaseIcoCMSClient {

    private static $REQUEST_PARAM_CURRENT_PAGE = "cP";
    private $totalNoOfPages = 0;

    protected function getModel() {
        return Post::model();
    }

    public function findByURI($uri) {
        return $this->findByAttributes(array(
                    "URI" => $uri,
                    "ContentLanguage" => Yii::app()->getLanguage()
                ));
    }

    public function findAll($pageSize = null, $condition = array(), $params = array()) {

        $condition = array_merge(array(
            "order" => "PublicationDate DESC",
            "condition" => "ContentLanguage = '" . Yii::app()->language . "'"
                ), $condition);

        if ($pageSize != null) {
            $condition = array_merge($condition, array(
                "limit" => $pageSize,
                "offset" => $pageSize * ($this->getCurrentPage() - 1),
                "condition" => "ContentLanguage = '" . Yii::app()->language . "'"
                    ));

            $this->totalNoOfPages = ceil($this->getModel()->count($condition, $params) / $pageSize);
        }


        return $this->normalizeList($this->getModel()->findAll($condition, $params));
    }

    public function getCurrentPage() {
        return Yii::app()->request->getParam(self::$REQUEST_PARAM_CURRENT_PAGE, 1);
    }

    public function getTotalNoOfPages() {
        return $this->totalNoOfPages;
    }

    /**
     * Gets the latest post
     */
    public function latest() {
        return $this->findByAttributes(array(), array(
                    "condition" => "ContentLanguage = '" . Yii::app()->language . "'",
                    "limit" => 1,
                    "order" => "PublicationDate DESC"
                ));
    }

    public function getArchiveMonths($includeCurrentMonth = false) {

        $condition = "";
        if ($includeCurrentMonth == false)
            $condition = "DATEDIFF(CURDATE(), PublicationDate) > 31";

        $retVal = array();

        $rs = $this->getModel()->findAll(array(
            "select" => "DISTINCT(DATE_FORMAT(`PublicationDate`,'%Y-%m-01')) PublicationDate, Id",
            "condition" => $condition
                ));

        foreach ($rs as $val) {
            array_push($retVal, $val->PublicationDate);
        }

        return $retVal;
    }

}

