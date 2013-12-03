<?php

/**
 * This is the model class for table "contentBlock".
 *
 * The followings are the available columns in table 'contentBlock':
 * @property string $Id
 * @property string $ProjectKey
 * @property string $DateCreated
 * @property string $Title
 * @property string $Text
 *
 * The followings are the available model relations:
 * @property Project $projectKey
 */
class ContentBlock extends BaseIcoCMSClientModel {

    public function behaviors() {
        return array(
            'DocumentVersionBehavior' => array(
                'class' => 'icoCMSClient.behaviors.IcoCMSClientDocumentVersionBehavior'
            ),
            'ItemURIBehavior' => array(
                'class' => 'icoCMSClient.behaviors.IcoCMSClientItemURIBehavior'
            )
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * @return ContentBlock the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'contentblock';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Id, ProjectKey, DateCreated', 'required'),
            array('Id', 'length', 'max' => 11),
            array('Title, Text', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, ProjectKey, DateCreated, Title, Text', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'projectKey' => array(self::BELONGS_TO, 'Project', 'ProjectKey'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'ProjectKey' => 'Project Key',
            'DateCreated' => 'Date Created',
            'Title' => 'Title',
            'Text' => 'Text',
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

        $criteria->compare('Id', $this->Id, true);
        $criteria->compare('ProjectKey', $this->ProjectKey, true);
        $criteria->compare('DateCreated', $this->DateCreated, true);
        $criteria->compare('Title', $this->Title, true);
        $criteria->compare('Text', $this->Text, true);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }
    
    public function getModuleId() {
        return 1;
    }

}

