<?php

/**
 * Description of IcoCMSEditorialClient
 *
 * @author marcinwiatr
 */
class IcoCMSCountryClient extends BaseIcoCMSClient {

    protected function getModel() {
        return Country::model();
    }

    public function findAll($condition = '', $params = array()) {

        $condition = new CDbCriteria();
        $condition->order = "Name ASC";

        return parent::findAll($condition, $params);
    }

    public function getAllAsListData($condition = '', $params = array(), $key = "CountryCode", $value = "Name") {
        $data = self::findAll($condition, $params);
        return CHtml::listData($data, $key, $value);
    }

    public function getPrimaryLanguageForCountryCode($countryCode, $defaultLanguageCode = null) {
        $model = Language::model()->with(array(
                    "countrylanguages" => array(
                        "condition" => "CountryCode = '$countryCode'",
                        "order" => "`Priority` asc"
                    )
                ))->find();

        if ($model == null) {
            $model = Language::model()->findByAttributes(array(
                "LanguageCode" => $defaultLanguageCode
                    ));
        }

        return $model;
    }

}

?>
