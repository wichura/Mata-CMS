<?php

class HomeController extends BaseAuthorizedController {

    public function actionIndex() {
        $this->pageTitle = Yii::app()->name . " - Dashboard";
        parent::actionIndex();
    }

    public function actionSetProject($projectId) {
        Yii::app()->user->setProject($projectId);

        $this->setResponseType("application/json");
        echo CJSON::encode($this->user->project);
    }

    public function actionGetProjectsSelector() {
        echo $this->renderPartial("_projectsSelector", array(
            "projects" => Project::model()->findAll(array(
                "order" => "Name ASC"
            ))
        ));
    }

}

?>
