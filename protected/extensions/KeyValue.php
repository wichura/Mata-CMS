<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SystemEventLog
 *
 * @author wichura
 */
class KeyValue extends CApplicationComponent {

    public $tableName = "keyvalue";
    
    public function set($key, $value, $scope = null) {

        $existingModel = KeyValueModel::model()->findByAttributes(array(
            "Key" => $key,
            "Scope" => $scope
        ));

        // TODO Use transactions to ensure ACIDity
        if ($existingModel != null)
            $existingModel->delete();
        
        $newModel = new KeyValueModel();
        $newModel->attributes = array(
            "Key" => $key,
            "Value" => $value,
            "Scope" => $scope
        );
        
        if ($newModel->save() == false) 
            throw new CHttpException(500, current($newModel->getErrors()));
    }
    
    public function get($key, $scope = null) {
        $model = KeyValueModel::model()->findByAttributes(array(
            "Key" => $key,
            "Scope" => $scope
        ));
        
        return $model != null ? $model->Value : null;
    }

}

/**
 * This is the model class for table "keyvalue".
 *
 * The followings are the available columns in table 'keyvalue':
 * @property string $Id
 * @property string $Key
 * @property string $Value
 * @property string $DateCreated
 * @property string $Scope
 */
class KeyValueModel extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KeyValue the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return Yii::app()->keyValue->tableName;
    }

    public function rules() {
        return array(
            array('Key, Value', 'required'),
            array('Key', 'length', 'max' => 64),
            array('Scope', 'length', 'max' => 32),
            // The following rule is used by search().
            array('Id, Key, Value, DateCreated, Scope', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array();
    }

    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'Key' => 'Key',
            'Value' => 'Value',
            'DateCreated' => 'Date Created',
            'Scope' => 'Scope',
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('Id', $this->Id, true);
        $criteria->compare('Key', $this->Key, true);
        $criteria->compare('Value', $this->Value, true);
        $criteria->compare('DateCreated', $this->DateCreated, true);
        $criteria->compare('Scope', $this->Scope, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}