<?php

/**
 * This class is a wrapper for Controller providing additional base functionality required by the project.
 * W prefix is used to distinguish between the project specific files and base ones which then can be ported.
 * @author Wichura
 *
 */
class BaseController extends CController {

    // data sent to view from the controller
    protected $data = array();

    public function filters() {
        return array(
            'beforeBaseExec',
            'afterBaseExec',
            'beforeExec'
        );
    }

    public function actionIndex() {
        $this->render(Yii::app()->controller->id);
    }

    public function filterBeforeBaseExec($filterChain) {
        $this->setDefaultHeaders();
        $filterChain->run();
    }

    public function filterAfterBaseExec($filterChain) {
        $filterChain->run();
    }

    public function filterBeforeExec($filterChain) {
        $filterChain->run();
    }

    // shorthand to log information
    protected function log($message) {
        Yii::getLogger()->log($message, "DEVELOPER");
    }

    protected function getMandatoryParameterFromRequest($paramName) {

        if (!isset($_POST[$paramName]) && !isset($_GET[$paramName])) {
            throw new CHttpException(500, "Param " . $paramName . " not passed");
        } else {
            return Yii::app()->request->getParam($paramName);
        }
    }

    /**
     * renders a view with data
     * @param String $view
     * @param bool $return
     * @return String
     */
    public function render($view, $data = null, $return = false) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            return parent::renderPartial($view, array_merge($this->data, $data != null ? $data : array()), $return);
        } else {
            return parent::render($view, array_merge($this->data, $data != null ? $data : array()), $return);
        }
    }

    public function renderPartial($view, $data = null, $return = false) {
        return parent::renderPartial($view, array_merge($this->data, $data != null ? $data : array()), $return);
    }

    protected function setResponseType($responseType) {
        header("Content-type: " . $responseType);
    }

    /**
     * Sets variables accessible from views
     */
    public function setData($key, $value) {
        $this->data[$key] = $value;
    }

    protected function setContentType($contentType) {
        header("Content-type: " . $contentType);
    }

    private function setDefaultHeaders() {
        // Prevent caching
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    protected function sendError($message = null) {
        header('HTTP/1.1 500 Internal Server Error');
        $this->sendResponse($message, "text/html");
    }

    protected function sendResponse($message = null, $responseType = "application/x-javascript") {

        $this->setResponseType($responseType);

        if ($message != null) {
            echo $message;
        }

        Yii::app()->end();
    }

}