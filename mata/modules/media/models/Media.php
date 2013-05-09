<?php

/**
 * This is the model class for table "media".
 *
 * The followings are the available columns in table 'media':
 * @property string $Id
 * @property string $DateCreated
 * @property string $DateModified
 * @property string $Name
 * @property string $FilePath
 * @property string $Width
 * @property string $Height
 * @property string $CreatorCMSUserId
 * @property string $MediaFolderId
 * @property string $MimeType
 * @property integer $Active
 * @property integer $ModifierCMSUserId
 * @property string $FileSize
 * @property integer $IsPublic
 * @property string $Meta
 *
 * The followings are the available model relations:
 * @property Mediafolder $mediaFolder
 */
class Media extends MataCMSActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Media the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'media';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('DateCreated, DateModified, Name, MediaFolderId, ModifierCMSUserId, FileSize', 'required'),
            array('Active, ModifierCMSUserId, IsPublic', 'numerical', 'integerOnly' => true),
            array('Name', 'length', 'max' => 100),
            array('FilePath', 'length', 'max' => 255),
            array('Width, Height, MediaFolderId', 'length', 'max' => 10),
            array('CreatorCMSUserId', 'length', 'max' => 11),
            array('MimeType', 'length', 'max' => 30),
            array('FileSize', 'length', 'max' => 20),
            array('Meta', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, DateCreated, DateModified, Name, FilePath, Width, Height, CreatorCMSUserId, MediaFolderId, MimeType, Active, ModifierCMSUserId, FileSize, IsPublic, Meta', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'mediaFolder' => array(self::BELONGS_TO, 'Mediafolder', 'MediaFolderId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'DateCreated' => 'Date Created',
            'DateModified' => 'Date Modified',
            'Name' => 'Name',
            'FilePath' => 'File Path',
            'Width' => 'Width',
            'Height' => 'Height',
            'CreatorCMSUserId' => 'Creator Cmsuser',
            'MediaFolderId' => 'Media Folder',
            'MimeType' => 'Mime Type',
            'Active' => 'Active',
            'ModifierCMSUserId' => 'Modifier Cmsuser',
            'FileSize' => 'File Size',
            'IsPublic' => 'Is Public',
            'Meta' => 'Meta',
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
        $criteria->compare('DateCreated', $this->DateCreated, true);
        $criteria->compare('DateModified', $this->DateModified, true);
        $criteria->compare('Name', $this->Name, true);
        $criteria->compare('FilePath', $this->FilePath, true);
        $criteria->compare('Width', $this->Width, true);
        $criteria->compare('Height', $this->Height, true);
        $criteria->compare('CreatorCMSUserId', $this->CreatorCMSUserId, true);
        $criteria->compare('MediaFolderId', $this->MediaFolderId, true);
        $criteria->compare('MimeType', $this->MimeType, true);
        $criteria->compare('Active', $this->Active);
        $criteria->compare('ModifierCMSUserId', $this->ModifierCMSUserId);
        $criteria->compare('FileSize', $this->FileSize, true);
        $criteria->compare('IsPublic', $this->IsPublic);
        $criteria->compare('Meta', $this->Meta, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getLabel() {
        return $this->Name;
    }
    
    public function getSortableAttributes() {
        return array("Name", "FilePath", "MimeType");
    }
    
    public function getAbsoluteFilePath() {
        return Yii::app()->getModule("media")->baseMediaPath . $this->FilePath;
    }
}