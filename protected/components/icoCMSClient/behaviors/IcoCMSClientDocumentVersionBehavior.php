<?php

/**
 * Description of DocumentVersionBehavior
 * Pulls a specific version of documents 
 * in the request
 * @author marcinwiatr
 */
class IcoCMSClientDocumentVersionBehavior extends CActiveRecordBehavior {

    // When set in the request the a specific document is requested. Value is document Id 
    private static $REQUEST_KEY_DOCUMENT = "cD";
    // Specific revision as expressed by numerical values
    private static $REQUEST_KEY_REVISION = "cRev";
    // Set by the front end client to alter preview mode state
    private static $COOKIE_KEY_PREVIEW_MODE = "cPm";

    /**
     * After finiding a record this method checks if we are in Preview Mode, and gets 
     * a Preview Version of the document if that is the case. 
     * This gets overwritten if specific version is requested via Request Parameters. 
     * If both conditions are false, the original model attributes are kept.
     * @param type $event 
     */
    public function afterFind($event) {

        $rev = null;
        $debugMsg = null;

        if (IcoCMSClient::isLoggedToCMS() === false || (
                isset(Yii::app()->request->cookies[self::$COOKIE_KEY_PREVIEW_MODE]) &&
                Yii::app()->request->cookies[self::$COOKIE_KEY_PREVIEW_MODE]->value == "false")) {
            $debugMsg = "GETTING LIVE";
            $rev = $this->getPublishedVersion();

            if ($rev == null) {
                // Reset attributes - no published version is available
                $this->getOwner()->unsetAttributes();
                $this->getOwner()->setAttribute("setToDestroy", "true");
            }
        }

        if (Yii::app()->getRequest()->getParam(self::$REQUEST_KEY_DOCUMENT) == $this->getDocumentId() &&
                $this->getRevisionFromRequest() != null) {
            $rev = $this->getRevision($this->getRevisionFromRequest());
        }

        $debugMsg = $debugMsg == null ? "GETTING PREVIEW" : $debugMsg;

        if ($rev != null)
            $this->getOwner()->attributes = unserialize($rev->ModelAttributes);

        Yii::log($debugMsg . " for " . $this->getDocumentId(), CLogger::LEVEL_INFO);
        
    }

    public function getRevision($revision) {
        return DocumentVersion::model()->findByAttributes(array(
                    "DocumentId" => $this->getDocumentId(),
                    "Revision" => $revision,
                ));
    }

    private function getDocumentId() {
        return get_class($this->getOwner()) . $this->getOwner()->Id;
    }

    private function getRevisionFromRequest() {
        return Yii::app()->getRequest()->getParam(self::$REQUEST_KEY_REVISION);
    }

    private function getPublishedVersion() {
        if (Yii::app()->icoCMSClient->cache == true) {

            $dependency = new DbCacheDependency($this->getOwner()->DateModified);
            $dependency->setDbConnection($this->getOwner()->getDbConnection());

            return DocumentVersion::model()->cache(60 * 60 * 12, $dependency)->findByAttributes(array(
                        "DocumentId" => $this->getDocumentId(),
                        "IsPublished" => 1,
                            ), array(
                        "order" => "Revision DESC"
                    ));
        } else {
            return DocumentVersion::model()->findByAttributes(array(
                        "DocumentId" => $this->getDocumentId(),
                        "IsPublished" => 1,
                            ), array(
                        "order" => "Revision DESC"
                    ));
        }
    }

}

?>
