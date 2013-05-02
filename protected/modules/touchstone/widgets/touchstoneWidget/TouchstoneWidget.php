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

        $this->scenario = Touchstone::model()->findByPk($this->scenario);

        if ($this->scenario == null)
            throw new CHttpException("COuld not find scenario " . $this->scenario);
    }

    public function run() {
        $this->renderDefaultView(__FILE__, array(
            "scenario" => $this->scenario,
            "currentScore" => round(($this->scenario->Score / $this->scenario->Goal) * 100, 1)
                ), "application.modules.touchstone.widgets");
    }

}

?>
