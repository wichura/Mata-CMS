<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MataCMSActiveRecord
 *
 * @author wichura
 */
class MataCMSActiveRecord extends MataActiveRecord {

    public function behaviors() {
        return array(
            "versions" => "mata.behaviors.VersionedModelBehavior"
        );
    }

    public function beforeValidate() {
        $this->setProjectKey();
        $this->manageCMSUser();
        $this->manageContentLanguage();
        return parent::beforeValidate();
    }

    protected function manageCMSUser() {

        if ($this->hasAttribute("CreatorUserId") &&
                $this->CreatorUserId == null && $this->getIsNewRecord()) {
            $this->CreatorUserId = Yii::app()->user->getId();
        }

        if ($this->hasAttribute("ModifierUserId") && $this->ModifierUserId == null)
            $this->ModifierUserId = Yii::app()->user->getId();
    }

    protected function setProjectKey() {
        if ($this->hasAttribute("ProjectKey") && $this->ProjectKey == null) {
            $this->ProjectKey = Yii::app()->user->getProject()->ProjectKey;
        }
    }

    private function manageContentLanguage() {
        if ($this->hasAttribute("ContentLanguage") && $this->ContentLanguage == null)
            $this->ContentLanguage = Yii::app()->getContentLanguage();
    }

    public function getSortableAttributes() {
        return array();
    }

}

?>
