<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TouchstoneWidget
 *
 * @author wichura
 */
Yii::import("application.modules.touchstone.models.*");

class TouchstoneWidget extends BaseWidget {

    public $scenario;

    public function init() {

        if (Yii::app()->getModule("touchstone")->active == false)
            return false;

        $this->scenario = Touchstone::model()->findByPk($this->scenario);

        if ($this->scenario == null)
            throw new CHttpException("Could not find scenario " . $this->scenario);
    }

    public function run() {

        if (Yii::app()->getModule("touchstone")->active == false)
            return false;

        $this->renderDefaultView(__FILE__, array(
            "scenario" => $this->scenario,
            "currentScore" => round(($this->scenario->Score / $this->scenario->Goal) * 100, 1)
                ), "application.modules.touchstone.widgets");
    }

}

?>
