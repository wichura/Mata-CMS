<?php

/**
 * This is the model class for table "itemorder".
 *
 * The followings are the available columns in table 'itemorder':
 * @property string $ItemId
 * @property string $Context
 * @property integer $Order
 */
class ItemOrder extends BaseIcoCMSClientModel {
 
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ItemOrder the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function defaultScope() {
        return array();
    }
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'itemorder';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ItemId, Context, Order', 'required'),
            array('Order', 'numerical', 'integerOnly' => true),
            array('ItemId, ModuleId', 'length', 'max' => 11),
            array('Context, ProjectKey', 'length', 'max' => 32),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ItemId, Context, Order', 'safe', 'on' => 'search'),
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
            'ItemId' => 'Item',
            'Context' => 'Context',
            'Order' => 'Order',
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

        $criteria->compare('ItemId', $this->ItemId, true);
        $criteria->compare('Context', $this->Context, true);
        $criteria->compare('Order', $this->Order);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}