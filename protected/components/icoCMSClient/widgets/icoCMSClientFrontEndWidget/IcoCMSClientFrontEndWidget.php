<?php

/**
 * Description of IcoCMSClientFrontEndWidget
 *
 * @author marcinwiatr
 */
class IcoCMSClientFrontEndWidget extends CWidget {

    /**
     * Data passed to the view
     * @var type 
     */
    private $data = array();

    public function init() {
        if (IcoCMSClient::isLoggedToCMS()) {
            $cssPath = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . "css", false, -1, YII_DEBUG);
            Yii::app()->getClientScript()->registerCssFile($cssPath . '/icoCMSClientFrontEndWidget.css');

            $jsPath = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . "js", false, -1, YII_DEBUG);
            Yii::app()->getClientScript()->registerScriptFile($jsPath . '/icoCMSClientFrontEndWidget.js', CClientScript::POS_END);
            Yii::app()->getClientScript()->registerScriptFile($jsPath . '/jquery.ui.sortable.min.js', CClientScript::POS_END);
            Yii::app()->getClientScript()->registerScriptFile($jsPath . '/jquery.cookie.js', CClientScript::POS_END);
            Yii::app()->getClientScript()->registerScriptFile($jsPath . '/jquery.modal.js', CClientScript::POS_END);
            Yii::app()->getClientScript()->registerScriptFile($jsPath . '/jquery.tooltip.js', CClientScript::POS_END);
        }
    }

    public function run() {
        if (IcoCMSClient::isLoggedToCMS())
            $this->render("icoCMSClient.widgets.icoCMSClientFrontEndWidget.views.IcoCMSClientFrontEndWidgetView", $this->data);
    }

}

?>
