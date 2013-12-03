<?php

/**
 * This is the model class for table "media".
 *
 * The followings are the available columns in table 'media':
 * @property string $Id
 * @property string $DateCreated
 * @property string $FilePath
 * @property string $Width
 * @property string $Height
 * @property string $UploaderCMSUserId
 * @property string $MediaFolderId
 *
 * The followings are the available model relations:
 * @property Blogpost[] $blogposts
 * @property Mediafolder $mediaFolder
 * @property Cmsuser $uploaderCMSUser
 */
class Media extends BaseIcoCMSClientModel {

    /**
     * Returns the static model of the specified AR class.
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
            array('FilePath', 'length', 'max' => 255),
            array('Width, Height, MediaFolderId', 'length', 'max' => 10),
            array('UploaderCMSUserId', 'length', 'max' => 11),
            array('DateCreated', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, DateCreated, FilePath, Width, Height, UploaderCMSUserId, MediaFolderId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'blogposts' => array(self::HAS_MANY, 'Blogpost', 'PreviewImageMediaId'),
            'mediaFolder' => array(self::BELONGS_TO, 'Mediafolder', 'MediaFolderId'),
            'uploaderCMSUser' => array(self::BELONGS_TO, 'Cmsuser', 'UploaderCMSUserId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'DateCreated' => 'Date Created',
            'FilePath' => 'File Path',
            'Width' => 'Width',
            'Height' => 'Height',
            'UploaderCMSUserId' => 'Uploader Cmsuser',
            'MediaFolderId' => 'Media Folder',
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

        $criteria->compare('Id', $this->Id, false);
        $criteria->compare('DateCreated', $this->DateCreated, false);
        $criteria->compare('FilePath', $this->FilePath, true);
        $criteria->compare('Width', $this->Width, false);
        $criteria->compare('Height', $this->Height, false);
        $criteria->compare('UploaderCMSUserId', $this->UploaderCMSUserId, false);
        $criteria->compare('MediaFolderId', $this->MediaFolderId, false);
        $criteria->order = "DateCreated DESC";

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

}