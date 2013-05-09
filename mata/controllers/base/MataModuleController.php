<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MataModuleController
 *
 * @author wichura
 */
abstract class MataModuleController extends MataController {

    public $layout = 'mata.views.layouts.mataModule';
    public $defaultAction = 'admin';

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = $this->getModel();
        $model = new $model;

        $modelClassName = get_class($this->getModel());
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST[$modelClassName])) {
            $model->attributes = $_POST[$modelClassName];
            if ($model->save()) {
                FlashMessage::setStandardModelCreateMessage($model);
                Yii::app()->eventLog->record(Yii::app()->user->FirstName . " " . Yii::app()->user->LastName . " created a new project " .
                        $model->getLabel());

                $modelClassNameLowerCase = strtolower($modelClassName);
                $this->redirect(array("/$modelClassNameLowerCase/$modelClassNameLowerCase"));
            }
        }

        $this->render('mata.views.module.create', array(
            'model' => $model,
            "modelName" => $modelClassName
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $modelClassName = get_class($this->getModel());

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST[$modelClassName])) {
            $model->attributes = $_POST[$modelClassName];
            if ($model->save()) {
                FlashMessage::setStandardModelUpdateMessage($model);
                $modelClassNameLowerCase = strtolower($modelClassName);
                $this->redirect(array("/$modelClassNameLowerCase/$modelClassNameLowerCase"));
            }
        }

        $this->render('mata.views.module.update', array(
            'model' => $model,
            "modelName" => $modelClassName,
            "modelNameLowerCase" => strtolower($modelClassName)
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = $this->getModel()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $modelClassName = get_class($this->getModel());

        $model = new $modelClassName('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET[$modelClassName]))
            $model->attributes = $_GET[$modelClassName];

        $this->render('mata.views.module.admin', array(
            'model' => $model,
            "modelName" => $modelClassName,
            "modelNameLowerCase" => strtolower($modelClassName)
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) &&
                $_POST['ajax'] === 'client-' .
                strtolower(get_class($this->getModel()))) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetVersions() {
        $model = $this->loadModel(Yii::app()->request->getParam("id"));

        if (array_key_exists("versions", $model->behaviors()))
            $this->renderPartial("mata.views.versions._versions", array(
                "versions" => $model->getAllVersions()
            ));
    }

    public abstract function getModel();
}

?>
