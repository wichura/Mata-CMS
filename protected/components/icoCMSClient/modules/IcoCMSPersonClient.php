<?php

/**
 * Description of IcoCMSEditorialClient
 *
 * @author marcinwiatr
 */
class IcoCMSPersonClient extends BaseIcoCMSClient {

    /**
     * Does a LIKE type search and returns a list of models
     * @param type $role
     * @return type String
     */
    public function getByRole($role) {
        $criteria = new CDbCriteria;
        $criteria->addCondition("Role like '" . $role . "'");
        return Person::model()->findAll($criteria);
    }

    protected function getModel() {
        return Person::model();
    }

}

?>
