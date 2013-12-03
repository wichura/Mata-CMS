<?php

/**
 * This is the model class for table "itemuri".
 *
 * The followings are the available columns in table 'itemuri':
 * @property string $Id
 * @property string $ModuleId
 * @property string $URI
 */
class ItemURI extends BaseIcoCMSClientModel {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ItemURI the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'itemuri';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Id, ModuleId, URI', 'required'),
            array('Id, ModuleId', 'length', 'max' => 11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, ModuleId, URI', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'ModuleId' => 'Module',
            'URI' => 'Uri',
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
        $criteria->compare('ModuleId', $this->ModuleId, true);
        $criteria->compare('URI', $this->URI, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function getModuleId() {
        return 1;
    }
}