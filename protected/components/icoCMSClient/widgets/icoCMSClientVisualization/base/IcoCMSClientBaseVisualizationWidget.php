<?php

abstract class IcoCMSClientBaseVisualizationWidget extends CWidget {

    public $visualization;

    public function init() {

        if ($this->visualization == null)
            throw new CHttpException(500, "Param visualization missng from the widget");

        $jsPath = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . "js", false, -1, YII_DEBUG);
        Yii::app()->getClientScript()->registerScriptFile($jsPath . '/d3.js', CClientScript::POS_BEGIN);

        parent::init();
    }
}
