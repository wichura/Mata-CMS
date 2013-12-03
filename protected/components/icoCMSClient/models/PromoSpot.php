<?php

/**
 * This is the model class for table "promospot".
 *
 * The followings are the available columns in table 'promospot':
 * @property string $Id
 * @property string $DateCreated
 * @property string $DateModified
 * @property string $Key
 * @property integer $Value
 * @property string $ProjectKey
 *
 * The followings are the available model relations:
 * @property Project $projectKey
 */
class PromoSpot extends BaseIcoCMSClientModel {

    /**
     * Returns the static model of the specified AR class.
     * @return PromoSpot the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'promospot';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('DateCreated, DateModified, Key, Value, ProjectKey', 'required'),
            array('Value', 'numerical', 'integerOnly' => true),
            array('Key', 'length', 'max' => 100),
            array('ProjectKey', 'length', 'max' => 32),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, DateCreated, DateModified, Key, Value, ProjectKey', 'safe', 'on' => 'search'),
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
            'DateCreated' => 'Date Created',
            'DateModified' => 'Date Modified',
            'Key' => 'Key',
            'Value' => 'Value',
            'ProjectKey' => 'Project Key',
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
        $criteria->compare('Key', $this->Key, true);
        $criteria->compare('Value', $this->Value);
        $criteria->compare('ProjectKey', $this->ProjectKey, true);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

}