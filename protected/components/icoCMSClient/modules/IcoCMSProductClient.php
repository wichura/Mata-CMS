<?php

/**
 * Description of IcoCMSEditorialClient
 *
 * @author marcinwiatr
 */
class IcoCMSProductClient extends BaseIcoCMSClient {

    private static $REQUEST_PARAM_CURRENT_PAGE = "cPP";
    private $totalNoOfPages = 0;
    
    protected function getModel() {
        return Product::model();
    }

    public function getForOwner($person) {
        $personId = is_numeric($person) ? $person : $person->Id;
        return Product::model()->getForOwner($personId);
    }

    public function getById($id, $withVariations = false) {

        if ($withVariations) {
            return $this->getModel()->with("variations")->findByPk($id);
        } else {
            return $this->getModel()->findByPk($id);
        }
    }

    public function findAll($pageSize = null, $condition = array(), $params = array()) {

        $condition = array_merge(array(
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
}

?>
