<?php

/**
 * This is the model class for table "visualization".
 *
 * The followings are the available columns in table 'visualization':
 * @property string $Id
 * @property string $Name
 * @property string $Data
 * @property string $DateCreated
 * @property string $DateModified
 * @property string $CreatorCMSUserId
 * @property string $ModifierCMSUserId
 * @property string $ProjectKey
 * @property string $Description
 */
class Visualization extends BaseIcoCMSClientModel {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Visualization the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'visualization';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Data, Region', 'required'),
            array('Name', 'length', 'max' => 255),
            array('CreatorCMSUserId, ModifierCMSUserId', 'length', 'max' => 11),
            array('Region', 'length', 'max' => 128),
            array('Description', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, Name, Data, DateCreated, DateModified, CreatorCMSUserId, ModifierCMSUserId, ProjectKey, Description', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'Name' => 'Name',
            'Data' => 'Data',
            'DateCreated' => 'Date Created',
            'DateModified' => 'Date Modified',
            'CreatorCMSUserId' => 'Creator Cmsuser',
            'ModifierCMSUserId' => 'Modifier Cmsuser',
            'ProjectKey' => 'Project Key',
            'Description' => 'Description',
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
        $criteria->compare('Data', $this->Data, true);
        $criteria->compare('DateCreated', $this->DateCreated, true);
        $criteria->compare('DateModified', $this->DateModified, true);
        $criteria->compare('CreatorCMSUserId', $this->CreatorCMSUserId, true);
        $criteria->compare('ModifierCMSUserId', $this->ModifierCMSUserId, true);
        $criteria->compare('ProjectKey', $this->ProjectKey, true);
        $criteria->compare('Description', $this->Description, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getModuleId() {
        return 10;
    }

}