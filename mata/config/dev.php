<?php

return array(
    'name' => 'Mata CMS',
    'import' => array(
        'mata.models.base.*',
        'mata.models.*',
        'mata.controllers.base.*',
        'mata.widgets.base.*',
        "mata.helpers.*"
    ),
    'modules' => array(
        'user' => array(
            'class' => "mata.modules.user.UserModule",
            'hash' => 'sha1',
            'sendActivationMail' => true,
            'activeAfterRegister' => false,
            'autoLogin' => true,
            'tableUsers' => "user",
            "tableProfiles" => "userprofile",
            "tableProfileFields" => "userprofilefield",
            'returnUrl' => "/",
            'captcha' => array('registration' => false)
        )
    ),
    'components' => array(
        'user' => array(
            'class' => 'mata.modules.user.components.WebUser',
        ),
        'keyValue' => array(
            "class" => "mata.extensions.KeyValue"
        ),
        'eventLog' => array(
            "class" => "mata.extensions.SystemEventLog"
        )
    )
);
