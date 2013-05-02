<?php

/**
 * This is the model class for table "touchstone".
 *
 * The followings are the available columns in table 'touchstone':
 * @property string $Id
 * @property string $Scenario
 * @property string $Description
 * @property integer $Goal
 * @property integer $Score
 */
class Touchstone extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Touchstone the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'touchstone';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Scenario, Description, Goal, Score', 'required'),
            array('Goal, Score', 'numerical', 'integerOnly' => true),
            array('Scenario', 'length', 'max' => 32),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, Scenario, Description, Goal, Score', 'safe', 'on' => 'search'),
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
            'Scenario' => 'Scenario',
            'Description' => 'Description',
            'Goal' => 'Goal',
            'Score' => 'Score',
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
        $criteria->compare('Scenario', $this->Scenario, true);
        $criteria->compare('Description', $this->Description, true);
        $criteria->compare('Goal', $this->Goal);
        $criteria->compare('Score', $this->Score);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}