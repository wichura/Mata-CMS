<?php

/**
 * This is the model class for table "form".
 *
 * The followings are the available columns in table 'form':
 * @property string $Id
 * @property string $Name
 * @property string $ProjectKey
 * @property string $DateCreated
 * @property string $DateModified
 * @property string $CreatorCMSUserId
 * @property string $ModifierCMSUserId
 *
 * The followings are the available model relations:
 * @property Cmsuser $creatorCMSUser
 * @property Cmsuser $modifierCMSUser
 * @property Project $projectKey
 * @property Formvalue[] $formvalues
 */
class Form extends BaseIcoCMSClientModel {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Form the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'form';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Name, ProjectKey, DateCreated, DateModified, CreatorCMSUserId, ModifierCMSUserId', 'required'),
            array('Name', 'length', 'max' => 128),
            array('ProjectKey', 'length', 'max' => 32),
            array('CreatorCMSUserId, ModifierCMSUserId', 'length', 'max' => 11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, Name, ProjectKey, DateCreated, DateModified, CreatorCMSUserId, ModifierCMSUserId', 'safe', 'on' => 'search'),
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
            'modifierCMSUser' => array(self::BELONGS_TO, 'Cmsuser', 'ModifierCMSUserId'),
            'projectKey' => array(self::BELONGS_TO, 'Project', 'ProjectKey'),
            'formvalues' => array(self::HAS_MANY, 'Formvalue', 'FormId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'Name' => 'Name',
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
        $criteria->compare('Name', $this->Name, true);
        $criteria->compare('ProjectKey', $this->ProjectKey, true);
        $criteria->compare('DateCreated', $this->DateCreated, true);
        $criteria->compare('DateModified', $this->DateModified, true);
        $criteria->compare('CreatorCMSUserId', $this->CreatorCMSUserId, true);
        $criteria->compare('ModifierCMSUserId', $this->ModifierCMSUserId, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}