<?php

/**
 * This is the model class for table "productvariation".
 *
 * The followings are the available columns in table 'productvariation':
 * @property string $ProductId
 * @property string $Name
 * @property double $Price
 * @property string $DateCreated
 * @property string $DateModified
 * @property string $CreatorCMSUserId
 * @property string $ModifierCMSUserId
 *
 * The followings are the available model relations:
 * @property Cmsuser $modifierCMSUser
 * @property Cmsuser $creatorCMSUser
 * @property Product $product
 */
class ProductVariation extends BaseIcoCMSClientModel {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProductVariation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'productvariation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Name, DateCreated, DateModified, CreatorCMSUserId, ModifierCMSUserId', 'required'),
            array('Price', 'numerical'),
            array('Name', 'length', 'max' => 255),
            array('CreatorCMSUserId, ModifierCMSUserId', 'length', 'max' => 11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ProductId, Name, Price, DateCreated, DateModified, CreatorCMSUserId, ModifierCMSUserId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'modifierCMSUser' => array(self::BELONGS_TO, 'Cmsuser', 'ModifierCMSUserId'),
            'creatorCMSUser' => array(self::BELONGS_TO, 'Cmsuser', 'CreatorCMSUserId'),
            'product' => array(self::BELONGS_TO, 'Product', 'ProductId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'ProductId' => 'Product',
            'Name' => 'Name',
            'Price' => 'Price',
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

        $criteria->compare('ProductId', $this->ProductId, true);
        $criteria->compare('Name', $this->Name, true);
        $criteria->compare('Price', $this->Price);
        $criteria->compare('DateCreated', $this->DateCreated, true);
        $criteria->compare('DateModified', $this->DateModified, true);
        $criteria->compare('CreatorCMSUserId', $this->CreatorCMSUserId, true);
        $criteria->compare('ModifierCMSUserId', $this->ModifierCMSUserId, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}