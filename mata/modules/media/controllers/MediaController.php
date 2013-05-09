<?php

class MediaController extends MataModuleController {

    /**
     * Manages all models.
     */
    public function actionAdmin() {

        $model = new Media('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET["Media"]))
            $model->attributes = $_GET["Media"];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function getModel() {
        return Media::model();
    }

}
