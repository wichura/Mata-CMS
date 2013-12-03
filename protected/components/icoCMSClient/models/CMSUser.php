<?php

/**
 * This is the model class for table "CMSUser".
 *
 * The followings are the available columns in table 'CMSUser':
 * @property string $Id
 * @property string $DateCreated
 * @property string $UserName
 * @property string $FirstName
 * @property string $LastName
 * @property string $EmailAddress
 * @property string $Password
 * @property string $Language
 * @property string $CreatorCMSUserId
 */
class CMSUser extends BaseIcoCMSClientModel {

    /**
     * Returns the static model of the specified AR class.
     * @return CMSUser the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cmsuser';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('UserName, FirstName', 'length', 'max' => 100),
            array('UserName, EmailAddress', 'unique'),
            array('LastName', 'length', 'max' => 150),
            array('Language', 'length', 'max' => 2),
            array('EmailAddress', 'length', 'max' => 255),
            array('EmailAddress', 'email'),
            array('Password', 'length', 'max' => 64),
            array('UserName, LastName, FirstName, EmailAddress, Password', 'required'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, DateCreated, UserName, FirstName, LastName, EmailAddress', 'safe', 'on' => 'search'),
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
            'cmsusers' => array(self::HAS_MANY, 'Cmsuser', 'CreatorCMSUserId'),
            'projects' => array(self::MANY_MANY, 'Project', 'cmsuserproject(CMSUserId, ProjectId)'),
            'medias' => array(self::HAS_MANY, 'Media', 'UploaderCMSUserId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'DateCreated' => 'Date Created',
            'UserName' => 'User Name',
            'FirstName' => 'First Name',
            'LastName' => 'Last Name',
            'EmailAddress' => 'Email Address',
            'Password' => 'Password',
            'Language' => 'Language',
            'CreatorCMSUserId' => 'Creator Cmsuser',
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
        $criteria->compare('UserName', $this->UserName, true);
        $criteria->compare('FirstName', $this->FirstName, true);
        $criteria->compare('LastName', $this->LastName, true);
        $criteria->compare('EmailAddress', $this->EmailAddress, true);
        $criteria->compare('Password', $this->Password, true);
        $criteria->compare('CreatorCMSUserId', $this->CreatorCMSUserId, true);

        $criteria->with = "projects";
        $criteria->condition = "projectId = " . Yii::app()->user->getProject()->Id;
        $criteria->together = true;


        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }
    
    public function getName() {
        return $this->FirstName . " " . $this->LastName;
    }

}