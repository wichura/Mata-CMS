<?php

/**
 * Description of BaseIcoCMSClientModel
 *
 * @author marcinwiatr
 */
class BaseIcoCMSClientModel extends BaseActiveRecord {

    public static $cmsDb = null;

    /**
     * Flags that this model is to be destructed when findAll is called
     * @var type 
     */
    public $setToDestroy = false;

    public function beforeValidate() {
        $this->setProjectKey();
        return parent::beforeValidate();
    }

    public function getDbConnection() {
        if (self::$cmsDb !== null)
            return self::$cmsDb;
        else {
            self::$cmsDb = new CDbConnection(Yii::app()->icoCMSClient->db["connectionString"],
                            Yii::app()->icoCMSClient->db["username"],
                            Yii::app()->icoCMSClient->db["password"]);

            self::$cmsDb->charset = Yii::app()->icoCMSClient->db["charset"];
            if (self::$cmsDb instanceof CDbConnection) {
                self::$cmsDb->setActive(true);
                return self::$cmsDb;
            }
            else
                throw new CDbException(Yii::t('yii', 'Active Record requires a "db" CDbConnection application component.'));
        }
    }

    protected function setProjectKey() {
        if ($this->hasAttribute("ProjectKey")) {
            $this->ProjectKey = Yii::app()->icoCMSClient->projectKey;
        }
    }

    public function defaultScope() {
        $scope = array();

        if ($this->hasAttribute("ProjectKey")) {
            $scope = array(
                "condition" => $this->getTableAlias(false, false) . ".ProjectKey = '" . Yii::app()->icoCMSClient->projectKey . "'"
            );
        }

        return $scope;
    }

    public function hasMeta($key) {
        $meta = unserialize($this->Meta);
        return (isset($meta) && empty($meta) == false && array_key_exists($key, $meta));
    }
    

    public function getMeta($key) {
        if ($this->hasMeta($key)) {
            $meta = unserialize($this->Meta);
            return $meta[$key];
        }
    }

    public function setMeta($values = array()) {
        $this->Meta = serialize($values);
    }
    public function addMeta($key, $value) {

        if ($this->Meta == null) {
            $meta = $this->Meta = array();
        } else {
            $meta = unserialize($this->Meta);
        }

        $this->Meta = serialize(array_merge($meta, array(
                    $key => $value
                )));
    }

}

?>