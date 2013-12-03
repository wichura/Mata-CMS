<?php

/**
 * Description of IcoCMSEditorialClient
 *
 * @author marcinwiatr
 */
class IcoCMSVisualizationClient extends BaseIcoCMSClient {

    protected function getModel() {
        return Visualization::model();
    }

    public function getByRegion($region) {
        return $this->getModel()->findByAttributes(array(
                    "Region" => $region
                ));
    }

    public function render($vis) {

        if (is_string($vis))
            $vis = $this->getByRegion($region);
        
        Yii::app()->controller->widget('icoCMSClient.widgets.icoCMSClientVisualization.' .
                'icoCMSClientSunburstVisualization.IcoCMSClientSunburstVisualizationWidget', array(
            "visualization" => $vis
        ));
    }

}

?>
