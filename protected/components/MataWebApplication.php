<?php

/**
 * Description of IcoCMSApplication
 *
 * @author marcinwiatr
 */
class MataWebApplication extends CWebApplication {

    public $defaultContentLanguage = "en";
    public $mataScopeUrl = "mata";

    function __construct($config = null) {

        $mataFolderPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "mata";
        Yii::setPathOfAlias("mata", $mataFolderPath);

        $mataConfig = require($mataFolderPath . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . (YII_DEBUG ? "dev.php" : "prod.php"));
        $config = CMap::mergeArray($mataConfig, require($config));


        $this->setComponents(array(
            'matadb' => array(
                'class' => 'CDbConnection',
            )
        ));

        parent::__construct($config);
    }

    public function createController($route, $owner = null) {

        if ($owner === null)
            $owner = $this;

        if (($route = trim($route, '/')) === '')
            $route = $owner->defaultController;

        $explodedRoute = explode("/", $route);
        if (count($explodedRoute) > 0 && $explodedRoute[0] == $this->mataScopeUrl) {
            $this->setControllerPath(Yii::getPathOfAlias("mata") . DIRECTORY_SEPARATOR . "controllers");
            $this->setViewPath(Yii::getPathOfAlias("mata") . DIRECTORY_SEPARATOR . 'views');
            $this->setLayoutPath($this->getViewPath() . DIRECTORY_SEPARATOR . "layouts");

            unset($explodedRoute[0]);
            $route = implode("/", $explodedRoute);
        }

        return parent::createController($route, $owner);
    }

    public function getDb() {
        return $this->getComponent('matadb');
    }

    public function setContentLanguage($contentLanguage) {
        $_SESSION["mata::contentLanguage::" . Yii::app()->user->getProject()->ProjectKey] = $contentLanguage;
    }

    public function getContentLanguage() {
        return isset($_SESSION["mata::contentLanguage::" . Yii::app()->user->getProject()->ProjectKey]) ?
                $_SESSION["mata::contentLanguage::" . Yii::app()->user->getProject()->ProjectKey] : $this->defaultContentLanguage;
    }

}