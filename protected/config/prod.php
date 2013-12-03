<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Application',
    'defaultController' => 'Home',
    'language' => 'en',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.base.*',
        'application.models.*',
        'application.components.*',
        'application.controllers.base.*',
        'application.widgets.base.*',
        'application.helpers.*'
    ),
    'modules' => array(
        'user' => array(
            'hash' => 'sha1',
            'sendActivationMail' => true,
            'activeAfterRegister' => false,
            'autoLogin' => true
        )
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'icoCMSClient' => array(
            "class" => "application.components.icoCMSClient.IcoCMSClient",
            "projectKey" => "00981f82c5ea11e1a81e00163e377f54",
            'db' => array(
                'connectionString' => 'mysql:host=109.123.107.147;port=3306;dbname=icocms',
                'emulatePrepare' => true,
                'username' => 'icocms',
                'password' => 'icocms_h0td0g',
                'charset' => 'utf8',
                'enableParamLogging' => true
            ),
            "modules" => array(
                "form" => array(
                    "notificationRecipients" => array(
                        "marcin.wiatr@icodesign.com"
                    )
                )
            )
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                array(
                    'class' => 'CEmailLogRoute',
                    'levels' => 'error, warning',
                    'emails' => 'marcin.wiatr@cms.icodesign.com',
                    'sentFrom' => 'developernotification@icodesign.com',
                    'filter' => 'CLogFilter'
                )
            // uncomment the following to show log messages on web pages
            /**
              array(
              'class'=>'CWebLogRoute',
              ),
             * */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
    // this is used in contact page
    ),
);