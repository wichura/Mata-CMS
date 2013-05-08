<?php

class BaseApplicationController extends BaseController {

    public $layout = "mainWithMenu";
    public function filters() {
        return array_merge(array(
            'registerCoreScript',
                ), parent::filters());
    }

    public function filterRegisterCoreScript($filterChain) {
        
        Yii::app()->clientScript->scriptMap = array(
            'jquery.js' => false,
        );
        
        $filterChain->run();
    }

}

?>
