<?php

/**
 * This is the model class for table "contentblock".
 *
 * The followings are the available columns in table 'contentblock':
 * @property string $Id
 * @property string $Title
 * @property string $Text
 * @property string $Region
 * @property string $Meta
 * @property string $ProjectKey
 * @property string $DateCreated
 * @property string $DateModified
 * @property string $CreatorUserId
 * @property string $ModifierUserId
 * @property string $ContentLanguage
 *
 * The followings are the available model relations:
 * @property Cmsuser $creatorUser
 * @property Cmsuser $modifierUser
 * @property Project $projectKey
 */
class ContentBlock extends MataActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
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
            array('Region, ProjectKey, DateCreated, DateModified, CreatorUserId, ModifierUserId, ContentLanguage', 'required'),
            array('Region', 'length', 'max' => 100),
            array('ProjectKey', 'length', 'max' => 32),
            array('CreatorUserId, ModifierUserId', 'length', 'max' => 11),
            array('ContentLanguage', 'length', 'max' => 2),
            array('Title, Text, Meta', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, Title, Text, Region, Meta, ProjectKey, DateCreated, DateModified, CreatorUserId, ModifierUserId, ContentLanguage', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'creatorCMSUser' => array(self::BELONGS_TO, 'Cmsuser', 'CreatorUserId'),
            'modifierCMSUser' => array(self::BELONGS_TO, 'Cmsuser', 'ModifierUserId'),
            'projectKey' => array(self::BELONGS_TO, 'Project', 'ProjectKey'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'Title' => 'Title',
            'Text' => 'Text',
            'Region' => 'Region',
            'Meta' => 'Meta',
            'ProjectKey' => 'Project Key',
            'DateCreated' => 'Date Created',
            'DateModified' => 'Date Modified',
            'CreatorUserId' => 'Creator Cmsuser',
            'ModifierUserId' => 'Modifier Cmsuser',
            'ContentLanguage' => 'Content Language',
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
        $criteria->compare('Title', $this->Title, true);
        $criteria->compare('Text', $this->Text, true);
        $criteria->compare('Region', $this->Region, true);
        $criteria->compare('Meta', $this->Meta, true);
        $criteria->compare('ProjectKey', $this->ProjectKey, true);
        $criteria->compare('DateCreated', $this->DateCreated, true);
        $criteria->compare('DateModified', $this->DateModified, true);
        $criteria->compare('CreatorUserId', $this->CreatorUserId, true);
        $criteria->compare('ModifierUserId', $this->ModifierUserId, true);
        $criteria->compare('ContentLanguage', $this->ContentLanguage, true);
        
        if (isset($_GET["filter"]) && !empty($_GET["filter"])) {
            $filter = $_GET["filter"];

            $criteria->compare("Title", $filter, true, "AND");
            $criteria->compare("Region", $filter, true, "OR");
        }
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getLabel() {
        return $this->Region;
    }

    public function getSortableAttributes() {
        return array("Title", "Region", "DateCreated");
    }

}