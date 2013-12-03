<?php

/**
 * This is the model class for table "categoryitem".
 *
 * The followings are the available columns in table 'categoryitem':
 * @property string $CategoryId
 * @property string $ItemId
 *
 * The followings are the available model relations:
 * @property Category $category
 */
class CategoryItem extends BaseIcoCMSClientModel {

    public $context;

    /**
     * Returns the static model of the specified AR class.
     * @return CategoryItem the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'categoryitem';
    }

    public function order($context) {

        $this->context = $context;
        $this->with(array(
            "order" => array(
                'on' => 'Context = "' . $context . '"',
                )));

        $this->getDbCriteria()->mergeWith(array(
            "order" => "`Order` ASC"
        ));

        return $this;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('CategoryId, ItemId', 'required'),
            array('CategoryId, ItemId', 'length', 'max' => 11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('CategoryId, ItemId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'category' => array(self::BELONGS_TO, 'Category', 'CategoryId'),
            'order' => array(self::HAS_ONE, 'ItemOrder', array(
                    "ItemId" => "ItemId",
                    "ModuleId" => "ModuleId"
            )),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'CategoryId' => 'Category',
            'ItemId' => 'Item',
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

        $criteria->compare('CategoryId', $this->CategoryId, true);
        $criteria->compare('ItemId', $this->ItemId, true);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

}

