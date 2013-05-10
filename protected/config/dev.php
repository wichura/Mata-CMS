<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Mata CMS',
    // preloading 'log' component
    'language' => 'en',
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.base.*',
        'application.controllers.*',
        'application.models.*',
        'application.components.*',
        'application.helpers.*'
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'dev',
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        "touchstone" => array(
            "active" => false
        ),
        'project',
        'client',
        'contentBlock'
    ),
    'components' => array(
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'db' => array(
            'connectionString' => 'mysql:host=37.123.117.163;dbname=matacmsnewdesign',
            'emulatePrepare' => true,
            'username' => 'matacms',
            'password' => 'V9gOhicqxwHpY6p',
            'charset' => 'utf8',
            'enableParamLogging' => true
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
    // this is used in contact page
    ),
);