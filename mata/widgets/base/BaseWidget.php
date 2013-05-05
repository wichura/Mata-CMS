<?php

/**
 * Description of BaseWidget
 *
 * @author marcinwiatr
 */
class BaseWidget extends CWidget {

    protected $assetsBase;

    protected function publishAssets($folder) {
        $this->assetsBase = Yii::app()->assetManager->publish($folder . "/assets", false, -1, YII_DEBUG);
    }

    public function run() {

        parent::run();
    }

    public function renderDefaultView($widgetFile, $data = array(), $basePath = "mata.widgets") {

        $widgetLocation = dirname($widgetFile);

        $container = explode(DIRECTORY_SEPARATOR . "widgets" . DIRECTORY_SEPARATOR, $widgetLocation);

        $containerFolder = str_replace("/", ".", $container[1]);
        $this->render($basePath . "." . $containerFolder . ".views." . lcfirst(basename($container[1])), $data);
    }

    public function registerDefaultCssFile($cssFileName) {
        Yii::app()->getClientScript()->registerCssFile(__DIR__ . "/css/" . $cssFileName);
    }

    protected function checkMandatoryParameterIsSet($paramName) {

        if (is_array($paramName)) {
            foreach ($paramName as $value) {
                $this->checkMandatoryParameterIsSet($value);
            }
        } else {
            if ($this->$paramName === null) {
                throw new CHttpException(500, "Param " . $paramName . " not passed");
            }
        }
    }

}

?>
