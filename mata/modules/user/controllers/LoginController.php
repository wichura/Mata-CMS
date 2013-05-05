<?php

class LoginController extends CController {

    public $defaultAction = 'login';
    public $layout='mata.views.layouts.main';

    /**
     * Displays the login page
     */
    public function actionLogin() {
        if (Yii::app()->user->isGuest) {

            Yii::app()->getModule("touchstone")->addPoints("User module testing");
            $model = new UserLogin;
            // collect user input data
            if (isset($_POST['UserLogin'])) {
                $model->attributes = $_POST['UserLogin'];
                // validate user input and redirect to previous page if valid
                if ($model->validate()) {
                    $this->lastViset();
                    Yii::app()->eventLog->record(Yii::app()->user->FirstName . " " . Yii::app()->user->LastName . " logged into " . 
                            Yii::app()->user->project->Name);
                    if (Yii::app()->getBaseUrl() . "/index.php" === Yii::app()->user->returnUrl)
                        $this->redirect(Yii::app()->controller->module->returnUrl);
                    else
                        $this->redirect(Yii::app()->user->returnUrl);
                }
            }
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