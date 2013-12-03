<?php

/**
 * This is the model class for table "person".
 *
 * The followings are the available columns in table 'person':
 * @property string $Id
 * @property string $FirstName
 * @property string $LastName
 * @property string $JobTitle
 * @property string $EmailAddress
 * @property string $Company
 * @property string $PrimaryTelephoneNo
 * @property string $SecondaryTelephoneNo
 * @property string $Address
 * @property string $PostCode
 * @property string $City
 * @property string $Role
 * @property string $Notes
 * @property string $ProjectKey
 * @property string $DateCreated
 * @property string $DateModified
 * @property string $CreatorCMSUserId
 * @property string $ModifierCMSUserId
 *
 * The followings are the available model relations:
 * @property Cmsuser $modifierCMSUser
 * @property Cmsuser $creatorCMSUser
 */
class Person extends IcoCMSClientCategorizedModel {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Person the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function behaviors() {
        return array(
            'DocumentVersionBehavior' => array(
                'class' => 'icoCMSClient.behaviors.IcoCMSClientDocumentVersionBehavior'
            ),
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'person';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('FirstName, LastName, JobTitle, EmailAddress, PrimaryTelephoneNo, ProjectKey, DateCreated, DateModified, CreatorCMSUserId, ModifierCMSUserId', 'required'),
            array('FirstName, LastName, EmailAddress, Roles', 'length', 'max' => 255),
            array('JobTitle, Company, City', 'length', 'max' => 100),
            array('PrimaryTelephoneNo, SecondaryTelephoneNo', 'length', 'max' => 45),
            array('PostCode', 'length', 'max' => 25),
            array('ProjectKey', 'length', 'max' => 32),
            array('CreatorCMSUserId, ModifierCMSUserId', 'length', 'max' => 11),
            array('Address, Notes', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, FirstName, LastName, JobTitle, EmailAddress, Company, PrimaryTelephoneNo, SecondaryTelephoneNo, Address, PostCode, City, Roles, Notes, ProjectKey, DateCreated, DateModified, CreatorCMSUserId, ModifierCMSUserId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array_merge(parent::relations(), array(
                    'modifierCMSUser' => array(self::BELONGS_TO, 'Cmsuser', 'ModifierCMSUserId'),
                    'creatorCMSUser' => array(self::BELONGS_TO, 'Cmsuser', 'CreatorCMSUserId')
                ));
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'FirstName' => 'First Name',
            'LastName' => 'Last Name',
            'JobTitle' => 'Job Title',
            'EmailAddress' => 'Email Address',
            'Company' => 'Company',
            'PrimaryTelephoneNo' => 'Primary Telephone No',
            'SecondaryTelephoneNo' => 'Secondary Telephone No',
            'Address' => 'Address',
            'PostCode' => 'Post Code',
            'City' => 'City',
            'Roles' => 'Roles',
            'Notes' => 'Notes',
            'ProjectKey' => 'Project Key',
            'DateCreated' => 'Date Created',
            'DateModified' => 'Date Modified',
            'CreatorCMSUserId' => 'Creator Cmsuser',
            'ModifierCMSUserId' => 'Modifier Cmsuser',
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
        $criteria->compare('FirstName', $this->FirstName, true);
        $criteria->compare('LastName', $this->LastName, true);
        $criteria->compare('JobTitle', $this->JobTitle, true);
        $criteria->compare('EmailAddress', $this->EmailAddress, true);
        $criteria->compare('Company', $this->Company, true);
        $criteria->compare('PrimaryTelephoneNo', $this->PrimaryTelephoneNo, true);
        $criteria->compare('SecondaryTelephoneNo', $this->SecondaryTelephoneNo, true);
        $criteria->compare('Address', $this->Address, true);
        $criteria->compare('PostCode', $this->PostCode, true);
        $criteria->compare('City', $this->City, true);
        $criteria->compare('Role', $this->Role, true);
        $criteria->compare('Notes', $this->Notes, true);
        $criteria->compare('ProjectKey', $this->ProjectKey, true);
        $criteria->compare('DateCreated', $this->DateCreated, true);
        $criteria->compare('DateModified', $this->DateModified, true);
        $criteria->compare('CreatorCMSUserId', $this->CreatorCMSUserId, true);
        $criteria->compare('ModifierCMSUserId', $this->ModifierCMSUserId, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getFullName() {
        return $this->FirstName . " " . $this->LastName;
    }

    protected function getModuleId() {
        return 5;
    }

}

