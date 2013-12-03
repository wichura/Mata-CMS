<?php

/**
 * Description of IcoCMSEditorialClient
 *
 * @author marcinwiatr
 */
class IcoCMSFormClient extends BaseIcoCMSClient {

    protected $formId;
    protected $form = null;
    protected $validationErrors = array();

    function __construct($formId) {
        $this->formId = $formId;
    }

    protected function getModel() {
        return Form::model();
    }

    public function widget($options = array()) {

        $options = array_merge($options, array(
            "id" => $this->formId
                ));

        Yii::app()->controller->widget('icoCMSClient.widgets.icoCMSClientFormWidget.IcoCMSClientFormWidget', $options);
    }

    /**
     * Processes request and logs data in database
     * @return mixed
     * @throws CHttpException 
     */
    public function process() {
        if ($this->isDataSubmitted()) {
            if ($this->validate() && $this->hasErrors() == false) {
                if (isset($_POST[$this->formId]["CMSFormName"]) == false)
                    throw new CHttpException(500, "Could not get CMSFormName from request");

                $this->form = $this->getModel()->findByAttributes(array(
                    "Name" => $_POST[$this->formId]["CMSFormName"]
                        ));

                if ($this->form == null)
                    throw new CHttpException(500, "Could not find form by name " . $_POST[$this->formId]["CMSFormName"]);

                // Remove form information, otherwise will be saved in meta
                unset($_POST[$this->formId]["CMSFormName"]);

                $formValue = new FormValue();
                $formValue->FormId = $this->form->Id;
                
                $formValue->setMeta($_POST[$this->formId]);

                if ($formValue->save() == false)
                    throw new CHttpException(500, "Could not save formValue " . $this->formId);
            } else {
                throw new ValidationException();
            }
        } else {
            throw new CHttpException(500, "No data submitted to " . $this->formId);
        }

        return $this;
    }

    /**
     * Sends email notifications to people set up in config[notificationRecipients]
     * @return \IcoCMSFormClient 
     */
    public function notify($recipients = null) {

        if ($this->isDataSubmitted() && $this->hasErrors() == false) {
            $config = $this->getConfig();
            $recipients = $recipients ? $recipients : $config["notificationRecipients"];


            $valuesBreakdown = array();

            foreach ($_POST[$this->formId] as $name => $value) {
                $msg = "<div style='width: 200px; float: left;'>" . $name . ": </div><div style='float:left;'>" . $value . "</div>";
                array_push($valuesBreakdown, $msg);
            }

            foreach ($recipients as $value) {

                $cmsURL = "http://cms.icodesign.com/form/form/view/id/" . $this->form->Id;

                mail($value, "New " . $this->form->Name . " submission", nl2br("New submission made. \n\r<a href='" . $cmsURL . "'>" . $cmsURL . "</a>" .
                                "\n\r\n\r" . implode("\n\r", $valuesBreakdown)), "Content-type: text/html; charset=iso-8859-1\r\n");
            }
        }

        return $this;
    }

    /**
     * Redirects to another page. 
     * @param type $url
     * @param type $terminate
     * @param type $statusCode 
     */
    public function redirect($url, $terminate = true, $statusCode = 302) {
        if ($this->isDataSubmitted() && $this->hasErrors() == false)
            Yii::app()->controller->redirect($url, $terminate, $statusCode);
    }

    public function isDataSubmitted() {
        return isset($_POST[$this->formId]);
    }

    public function hasAttribute($attr) {
        return isset($_POST[$this->formId][$attr]);
    }

    public function hasErrors() {
        return count($this->validationErrors) > 0;
    }

    public function validate() {

        if (Yii::app()->session[$this->formId . "[validators]"] == null)
            return $this;

        $validators = Yii::app()->session[$this->formId . "[validators]"];
        foreach ($validators as $attribute => $validators) {
            $validators = preg_split("/,/", $validators);
            $this->validateAttribute($attribute, $validators);
        }

        Yii::app()->session[$this->formId . "[validationErrors]"] = $this->validationErrors;
        return $this;
    }

    public function notifyMailChimp($apiKey, $listId, $emailAddressToAdd, $fields = array()) {
        if ($this->isDataSubmitted() && $this->hasErrors() == false) {

            Yii::import("icoCMSClient.extensions.mailChimpClient.MCAPI");

            $api = new MCAPI($apiKey);
            $api->listSubscribe($listId, $emailAddressToAdd, $fields);

            if ($api->errorCode)
                throw new IntegrationException($api->errorMessage);
        }

        return $this;
    }

    public function clearValidationErrors() {
        $this->validationErrors = array();
        Yii::app()->session[$this->formId . "[validationErrors]"] = null;
    }

    /**
     * Runs recursively through all validators
     * @param type $attr
     * @param type $validators
     * @throws CHttpException 
     */
    private function validateAttribute($attr, $validators) {

        $validator = array_shift($validators);

        // This check if for checkboxes - the attribtue exists, but no value is sent in the request
        if (isset($_POST[$this->formId][$attr])) {

            $value = $_POST[$this->formId][$attr];

            switch (trim($validator)) {
                case "required":
                    if ($this->checkRequired($value) == false)
                        $this->addError($attr, $this->generateAttributeLabel($attr) . " cannot be empty");
                    break;

                case "email":
                    if ($this->checkEmail($value) == false)
                        $this->addError($attr, $this->generateAttributeLabel($attr) . " is not a valid email address");
                    break;

                default:
                    throw new CHttpException(500, "Unknown validator " . $validator);
                    break;
            }
        }

        if (count($validators) > 0)
            $this->validateAttribute($attr, $validators);
    }

    private function checkRequired($value) {
        return $value !== null && $value !== array() && $value !== '';
    }

    private function checkEmail($value) {
        return is_string($value) && strlen($value) <= 254 &&
                (preg_match('/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/', $value) ||
                preg_match('/^[^@]*<[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?>$/', $value));
    }

    private function addError($attr, $message) {
        $this->validationErrors = array_merge($this->validationErrors, array(
            $attr => array(
                "message" => $message
                ))
        );
    }

    public function getValidationErrors() {
        return $this->validationErrors;
    }

    /**
     * 
     * @param type $name
     * @return typeTaken from CModel
     */
    private function generateAttributeLabel($name) {
        return ucwords(trim(strtolower(str_replace(array('-', '_', '.'), ' ', preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $name)))));
    }

}

/**
 * Thrown when validation fails 
 */
class ValidationException extends CException {

    public function __construct() {
        parent::__construct(null, 0);
    }

}

/**
 * Thrown when integration fails 
 */
class IntegrationException extends CException {

    public function __construct($message) {
        parent::__construct($message, 0);
    }

}

?>