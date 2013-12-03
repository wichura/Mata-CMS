<?php

/**
 * Description of IcoCMSContentBlockClient
 *
 * @author marcinwiatr
 */
class IcoCMSContentBlockClient extends BaseIcoCMSClient {

    protected function getModel() {
        return ContentBlock::model();
    }

    /**
     * Returns Content Block by region.
     * @param type $region
     * @return type 
     */
    public function getByRegion($region) {

        return $this->getModel()->findByAttributes(array(
                    "Region" => $region,
                    "ContentLanguage" => Yii::app()->language
                ));
    }

    public function renderTextByRegion($region) {
        $model = $this->getByRegion($region);
        if ($model != null)
            $this->render($model->Text, $model->Id);
    }

}

?>
