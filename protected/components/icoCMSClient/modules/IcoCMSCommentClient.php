<?php

/**
 * Description of IcoCMSEditorialClient
 *
 * @author marcinwiatr
 */
Yii::import("icoCMSClient.modules.IcoCMSFormClient");

class IcoCMSCommentClient extends IcoCMSFormClient {

    function __construct($formId) {
        $this->formId = $formId;
    }

    protected function getModel() {
        return Comment::model();
    }

    public function postForm($options = array()) {

        $options = array_merge($options, array(
            "id" => $this->formId,
            "CMSFormName" => $this->formId
                ));
        Yii::app()->controller->widget('icoCMSClient.widgets.icoCMSClientFormWidget.IcoCMSClientFormWidget', $options);
    }

//    /**
//     * Processes request and logs data in database
//     * @return mixed
//     * @throws CHttpException 
//     */
    public function process() {
        if ($this->isDataSubmitted()) {
            if ($this->validate() && $this->hasErrors() == false) {
                if (isset($_POST[$this->formId]["CMSFormName"]) == false)
                    throw new CHttpException(500, "Could not get CMSFormName from request");


// Remove form information, otherwise will be saved in meta
                $comment = new Comment();
                $comment->RegionId = $_POST[$this->formId]["CMSFormName"];

                unset($_POST[$this->formId]["CMSFormName"]);
                $comment->attributes = $_POST[$this->formId];


                if ($comment->save() == false) {
                    print_r($comment->getErrors());
                    Yii::app()->end();
                    throw new CHttpException(500, "Could not save comment " . $this->formId);
                }
            } else {
                throw new ValidationException();
            }
        } else {
            throw new CHttpException(500, "No data submitted to " . $this->formId);
        }

        return $this;
    }

    public function notify() {
        
    }

    public function renderComments($template = null, $dateFormat = "d F Y, H:i") {

        if ($template == null) {
            $template = <<<EOT
<div class="comment-comment">
    <p>#{Comment}</p>
    <div class="comment-meta">
        <p>Posted by <span class='comment-author-name'>#{Name}</span> on <span class='comment-date-created'>#{DateCreated}</span></p>
    </div>
    <hr />
</div>
EOT;
        }

        $comments = $this->getComments();

        $retVal = "";
        $i = 0;
        foreach ($comments as $comment) {
            $renderedComment = str_replace("#{Comment}", $comment->Comment, $template);
            $renderedComment = str_replace("#{Name}", $comment->Name, $renderedComment);
            $renderedComment = str_replace("#{DateCreated}", date($dateFormat, strtotime($comment->DateCreated)), $renderedComment);
            $retVal .= $renderedComment;

            $this->render($renderedComment, $comment->Id, "/comment/comment/delete/id/" . $comment->Id);
        }
    }

    public function getComments() {
        return $this->getModel()->findAllByAttributes(array(
                    "RegionId" => $this->formId
                ));
    }

    public function notifyMailChimp() {
        throw new Exception("Don't notify mailchimp for comments");
    }

    public function hasComments() {
        return count($this->getComments()) > 0;
    }

}

?>