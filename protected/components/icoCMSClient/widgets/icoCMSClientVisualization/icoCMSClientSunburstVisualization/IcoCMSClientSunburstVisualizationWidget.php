<?php

/**
 * Description of IcoCMSClientFrontEndWidget
 *
 * @author marcinwiatr
 */
Yii::import("icoCMSClient.widgets.icoCMSClientVisualization.base.*");

class IcoCMSClientSunburstVisualizationWidget extends IcoCMSClientBaseVisualizationWidget {

    public function init() {

        $jsPath = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . "js" . DIRECTORY_SEPARATOR . "icoCMSClientSunburstVisualization", false, -1, YII_DEBUG);
        Yii::app()->getClientScript()->registerScriptFile($jsPath . '/icoCMSClientSunburstVisualization.js', CClientScript::POS_BEGIN);
        $this->setDefaults();
        parent::init();
    }

    public function run() {
        $this->render("icoCMSClient.widgets.icoCMSClientVisualization." .
                "icoCMSClientSunburstVisualization.views.IcoCMSClientSunburstVisualizationWidgetView");
    }

    private function setDefaults() {

        if ($this->visualization->hasMeta("Color") == false)
            $this->visualization->addMeta("Color", "#FFFFFF");

        if ($this->visualization->hasMeta("StrokeColor")) {
            if ($this->visualization->hasMeta("StrokeThickness") == false)
                $this->visualization->addMeta("StrokeThickness", 1);
        } else {
            $this->visualization->addMeta("StrokeThickness", 0);
        }
    }

}

?>
