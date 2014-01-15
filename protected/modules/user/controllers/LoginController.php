<?php

class LoginController extends CController {

    public $defaultAction = 'login';
    public $layout = 'mata.views.layouts.mataMain';

    /**
     * Displays the login page
     */
    public function actionLogin() {
        if (Yii::app()->user->isGuest) {
            $model = new UserLogin;
            // collect user input data
            if (isset($_POST['UserLogin'])) {
                $model->attributes = $_POST['UserLogin'];
                // validate user input and redirect to previous page if valid
                if ($model->validate()) {
                    $this->lastViset();
                    if (Yii::app()->getBaseUrl() . "/index.php" === Yii::app()->user->returnUrl)
                        $this->redirect(Yii::app()->controller->module->returnUrl);
                    else
                        $this->redirect(Yii::app()->user->returnUrl);
                }
            }

            $assetUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('user') . DIRECTORY_SEPARATOR . "assets", false, -1, YII_DEBUG);
            $cs = Yii::app()->getClientScript();

            $cs->registerCssFile(Yii::app()->getMataAssetUrl() . '/css/reset.css');
            $cs->registerCssFile(Yii::app()->getMataAssetUrl() . '/css/layout.css');
            $cs->registerCssFile($assetUrl . '/css/login.css');

            // display the login form
            $this->render('/user/login', array('model' => $model));
        }
        else
            $this->redirect(Yii::app()->controller->module->returnUrl);
    }

    private function lastViset() {
        $lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        $lastVisit->lastvisit_at = date('Y-m-d H:i:s');
        $lastVisit->save();
    }

}