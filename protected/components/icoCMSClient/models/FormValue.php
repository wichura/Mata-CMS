<?php

/**
 * This is the model class for table "formvalue".
 *
 * The followings are the available columns in table 'formvalue':
 * @property string $FormId
 * @property string $DateCreated
 * @property string $Value
 * @property string $UniqueValue
 *
 * The followings are the available model relations:
 * @property Form $form
 */
class FormValue extends BaseIcoCMSClientModel {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return FormValue the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'formvalue';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('FormId, DateCreated, Meta', 'required'),
            array('FormId', 'length', 'max' => 11),
            array('UniqueValue', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('FormId, DateCreated, Meta, UniqueValue', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'form' => array(self::BELONGS_TO, 'Form', 'FormId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'FormId' => 'Form',
            'DateCreated' => 'Date Created',
            'Meta' => 'Meta',
            'UniqueValue' => 'Form Value',
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

        $criteria->compare('FormId', $this->FormId, true);
        $criteria->compare('DateCreated', $this->DateCreated, true);
        $criteria->compare('Meta', $this->Meta, true);
        $criteria->compare('UniqueValue', $this->UniqueValue, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
}