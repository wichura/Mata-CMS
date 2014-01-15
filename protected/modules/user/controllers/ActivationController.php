<?php

class ActivationController extends CController {

    public $defaultAction = 'activation';
    public $layout = 'mata.views.layouts.cmsLayout';

    /**
     * Activation user account
     */
    public function actionActivation() {
        $email = $_GET['email'];
        $activkey = $_GET['activkey'];
        if ($email && $activkey) {
            
            $loginLink = Yii::app()->mataScopeUrl . current($this->module->loginUrl);
            $loginLink = "<a href='/$loginLink'>Login</a>";
            
            $find = User::model()->notsafe()->findByAttributes(array('email' => $email));
            if (isset($find) && $find->status) {
                $this->render('/user/message', array('title' => UserModule::t("User activation"), 'content' => UserModule::t("You account is active. <br/>$loginLink")));
            } elseif (isset($find->activkey) && ($find->activkey == $activkey)) {
                $find->activkey = UserModule::encrypting(microtime());
                $find->status = 1;
                $find->save();
                $this->render('/user/message', array('title' => UserModule::t("User activation"), 'content' => UserModule::t("You account is activated. <br/>$loginLink")));
            } else {
                $this->render('/user/message', array('title' => UserModule::t("User activation"), 'content' => UserModule::t("Incorrect activation URL.")));
            }
        } else {
            $this->render('/user/message', array('title' => UserModule::t("User activation"), 'content' => UserModule::t("Incorrect activation URL.")));
        }
    }

}