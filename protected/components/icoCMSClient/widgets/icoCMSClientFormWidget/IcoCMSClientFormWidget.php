<?php

class IcoCMSClientFormWidget extends CWidget {

    public $attributes = array();
    public $submitButtonText = "Submit";
    public $CMSFormName = null;
    public $requiredCharacter = " *";
    public $isAjax = false;
    public $ajaxProcessURL = null;
    public $formOptions = array(
        "method" => "POST",
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
            'validateOnType' => false,
            'validationUrl' => "/validate",
            'afterValidate' => "js:afterFormValidate"
            ));
    private $validationErrors = array();

    public function init() {

        if ($this->isAjax && $this->ajaxProcessURL == null)
            throw new CHttpException(500, "ajaxProcessURL cannot be null if AJAX is to be used on form");

        if (isset(Yii::app()->session[$this->id . "[validationErrors]"])) {
            $this->validationErrors = Yii::app()->session[$this->id . "[validationErrors]"];
            unset(Yii::app()->session[$this->id . "[validationErrors]"]);
        }



        if ($this->CMSFormName == null)
            throw new CHttpException(500, "CMSFormId needs to be supplied");

        $this->formOptions["id"] = $this->id;
    }

    public function run() {
        $this->render("icoCMSClient.widgets.icoCMSClientFormWidget.views.IcoCMSClientFormWidgetView", array(
            "validationErrors" => $this->validationErrors
        ));
    }

}

?>
