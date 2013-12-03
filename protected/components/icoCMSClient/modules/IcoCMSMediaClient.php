<?php

/**
 * Description of IcoCMSEditorialClient
 *
 * @author marcinwiatr
 */
class IcoCMSMediaClient extends BaseIcoCMSClient {

    protected function getModel() {
        return Media::model();
    }

    public function image($media, $baseSrc = null, $alt = null, $htmlOptions = array()) {

        if ($baseSrc == null && isset(Yii::app()->params["mediaBaseURL"]))
            $baseSrc = Yii::app()->params["mediaBaseURL"];

        if (is_numeric($media))
            $media = $this->getModel()->findByPk($media);

        if ($media != null) {
            return CHtml::image($baseSrc . $media->FilePath, $alt, $htmlOptions);
        }
    }

}

?>
