<?php

class TouchstoneModule extends CWebModule {

    public $defaultController = "touchstone";

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'touchstone.models.*'
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }

    public function addPoints($scenario, $points = 1) {
        $scenario = Touchstone::model()->findByPk($scenario);

        if ($scenario == null)
            throw new CHttpException("Could not find scenario");

        $scenario->Score += $points;
        if ($scenario->save() == false)
            throw new CHttpException("Could not save new score for scenario " . $scenario->Scenario);
    }

}