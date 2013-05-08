<?php

/**
 * Description of DocumentVersionBehavior
 *
 * @author marcinwiatr
 */
class VersionedModelBehavior extends CActiveRecordBehavior {

    protected static $REQUEST_KEY_SAVE_MODE = "saveMode";
    protected static $REQUEST_VALUE_PUBLISH_MODE = "publish";

    public function afterSave($event) {
        $this->saveNewVersion();
    }

    private function saveNewVersion() {

        $version = new DocumentVersion();
        $latestVersion = $this->getLatestVersion();

        $revision = $latestVersion != null ? ++$latestVersion->Revision : 1;

        $version->attributes = array(
            "DocumentId" => $this->getDocumentId(),
            "Revision" => $revision,
            "CreatorUserId" => $this->getOwner()->CreatorUserId,
            "ModelAttributes" => serialize($this->getOwner()->attributes),
            "IsPublished" => Yii::app() instanceof CConsoleApplication ||
            (Yii::app()->user->checkAccess("publisher") &&
            Yii::app()->getRequest()->getParam(self::$REQUEST_KEY_SAVE_MODE, 0) == self::$REQUEST_VALUE_PUBLISH_MODE)
        );

        if ($version->save() === false) {
            // TODO Implement better error handling, add reason
            throw new CHttpException(500, "Could not save version " . $version->getFirstError());
        }
    }

    private function getDocumentId() {
        return get_class($this->getOwner()) . $this->getOwner()->Id;
    }

    public function getLatestVersion() {
        return DocumentVersion::model()->findByAttributes(array(
                    "DocumentId" => $this->getDocumentId()
                        ), array(
                    "order" => "Revision DESC"
                ));
    }

    public function getRevision($revision) {
        return DocumentVersion::model()->findByAttributes(array(
                    "DocumentId" => $this->getDocumentId(),
                    "Revision" => $revision
                        ), array(
                    "order" => "Revision DESC"
                ));
    }

    public function getAllVersions() {
        return DocumentVersion::model()->findAllByAttributes(array(
                    "DocumentId" => $this->getDocumentId()
                        ), array(
                    "order" => "Revision DESC"
                ));
    }

    public function getNewestPublishedVersion() {
        return DocumentVersion::model()->findByAttributes(array(
                    "DocumentId" => $this->getDocumentId(),
                    "IsPublished" => 1
                        ), array(
                    "order" => "Revision DESC"
                ));
    }

}


/**
 * This is the model class for table "modelversion".
 *
 * The followings are the available columns in table 'modelversion':
 * @property string $DocumentId
 * @property string $Revision
 * @property string $DateCreated
 * @property string $ModelAttributes
 * @property string $CreatorUserId
 *
 * The followings are the available model relations:
 * @property Cmsuser $creatorUser
 */
class DocumentVersion extends MataActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DocumentVersion the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'documentversion';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('DocumentId, Revision, ModelAttributes', 'required'),
            array('DocumentId', 'length', 'max' => 40),
            array('Revision', 'length', 'max' => 10),
            array("Comment", "safe"),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('DocumentId, Revision, DateCreated, ModelAttributes', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'creatorCMSUser' => array(self::BELONGS_TO, 'Cmsuser', 'CreatorCMSUserId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'DocumentId' => 'Document',
            'Revision' => 'Revision',
            'DateCreated' => 'Date Created',
            'ModelAttributes' => 'Model Attributes',
            'CreatorUserId' => 'Author',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('DocumentId', $this->DocumentId, true);
        $criteria->compare('Revision', $this->Revision, true);
        $criteria->compare('DateCreated', $this->DateCreated, true);
        $criteria->compare('ModelAttributes', $this->ModelAttributes, true);
        $criteria->compare('CreatorCMSUserId', $this->CreatorCMSUserId, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}

?>
