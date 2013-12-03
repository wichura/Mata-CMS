<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property string $Id
 * @property string $Name
 * @property string $Description
 * @property string $Tags
 * @property string $Text
 * @property string $MediaId
 * @property string $Dimensions
 * @property double $Weight
 * @property string $Color
 * @property double $Price
 * @property string $Availibility
 * @property integer $StockLevel
 * @property integer $Active
 * @property string $Meta
 * @property string $ProjectKey
 * @property string $DateCreated
 * @property string $DateModified
 * @property string $CreatorCMSUserId
 * @property string $ModifierCMSUserId
 *
 * The followings are the available model relations:
 * @property Contentblock $contentBlock
 * @property Cmsuser $creatorCMSUser
 * @property Media $media
 * @property Cmsuser $modifierCMSUser
 * @property Project $projectKey
 */
class Product extends IcoCMSClientCategorizedModel {

    public $context = null;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Product the static model class
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

    public function order($context) {

        $this->context = $context;
        $this->with(array(
            "order" => array(
                'on' => '`order`.`ItemId`=`t`.`Id` AND Context = "' . $context . '"',
                )));

        $this->getDbCriteria()->mergeWith(array(
            "order" => "`Order` ASC"
        ));

        return $this;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'product';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Id, Name, ProjectKey, DateCreated, DateModified, CreatorCMSUserId, Opinion, ModifierCMSUserId', 'required'),
            array('StockLevel, Active', 'numerical', 'integerOnly' => true),
            array('Weight, Price', 'numerical'),
            array('Id', 'unique'),
            array('Id', 'length', 'max' => 64),
            array('Name, Tags, Dimensions', 'length', 'max' => 255),
            array('MediaId, CreatorCMSUserId, ModifierCMSUserId', 'length', 'max' => 11),
            array('Color, ProjectKey', 'length', 'max' => 32),
            array('Availibility', 'length', 'max' => 12),
            array('Description, Meta, Text, UUId', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, Name, Description, Tags,  Text, MediaId, Dimensions, Weight, Color, Price, Availibility, StockLevel, Active, Meta, ProjectKey, DateCreated, DateModified, CreatorCMSUserId, ModifierCMSUserId', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array_merge(parent::relations(), array(
                    'productperson' => array(self::HAS_MANY, 'ProductPerson', array('ProductId' => 'Id')),
                    'person' => array(self::HAS_MANY, 'Person', array('PersonId' => 'Id'), 'through' => 'productperson'),
                    'order' => array(self::HAS_ONE, 'ItemOrder', "ItemId"),
                    'variations' => array(self::HAS_MANY, 'ProductVariation', 'ProductId')
                ));
    }

    public function getForOwner($personId) {
        return $this->with("person")->findAll(array(
                    "condition" => "PersonId = " . $personId
                ));
        ;
    }

    public function getOwner() {
        $this->addRelatedRecord("Person", "person", false);
        $this->person = $this->person[0];

        return $this->person;
    }

    protected function afterFind() {
        parent::afterFind();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'Identifier',
            'Name' => 'Name',
            'Description' => 'Description',
            'Tags' => 'Tags',
            'Text' => 'Text',
            'MediaId' => 'Media',
            'Dimensions' => 'Dimensions',
            'Weight' => 'Weight',
            'Color' => 'Color',
            'Price' => 'Price',
            'Availibility' => 'Availibility',
            'StockLevel' => 'Stock Level',
            'Active' => 'Active',
            'Meta' => 'Meta',
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
        $criteria->compare('Description', $this->Description, true);
        $criteria->compare('Tags', $this->Tags, true);
        $criteria->compare('Text', $this->Text, true);
        $criteria->compare('MediaId', $this->MediaId, true);
        $criteria->compare('Dimensions', $this->Dimensions, true);
        $criteria->compare('Weight', $this->Weight);
        $criteria->compare('Color', $this->Color, true);
        $criteria->compare('Price', $this->Price);
        $criteria->compare('Availibility', $this->Availibility, true);
        $criteria->compare('StockLevel', $this->StockLevel);
        $criteria->compare('Active', $this->Active);
        $criteria->compare('Meta', $this->Meta, true);
        $criteria->compare('ProjectKey', $this->ProjectKey, true);
        $criteria->compare('DateCreated', $this->DateCreated, true);
        $criteria->compare('DateModified', $this->DateModified, true);
        $criteria->compare('CreatorCMSUserId', $this->CreatorCMSUserId, true);
        $criteria->compare('ModifierCMSUserId', $this->ModifierCMSUserId, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getModuleId() {
        return 6;
    }

    public function getVariation($variationName) {

        foreach ($this->variations as $variation) {
            if ($variation->Name == $variationName)
                return $variation;
        }
    }

    public function getVariationById($variationId) {
        foreach ($this->variations as $variation) {
            if ($variation->Id == $variationId)
                return $variation;
        }
    }

}

