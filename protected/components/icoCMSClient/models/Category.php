<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property string $Id
 * @property string $ParentId
 * @property string $Name
 * @property string $ModuleId
 * @property string $ItemId
 * @property string $URI
 * @property string $Meta
 * @property string $ProjectKey
 * @property string $DateCreated
 * @property string $DateModified
 * @property string $CreatorCMSUserId
 * @property string $ModifierCMSUserId
 *
 * The followings are the available model relations:
 * @property Cmsuser $creatorCMSUser
 * @property Cmsuser $modifierCMSUser
 * @property Module $module
 * @property Category $parent
 * @property Category[] $categories
 * @property Project $projectKey
 */
class Category extends BaseIcoCMSClientModel {

    /**
     * Returns the static model of the specified AR class.
     * @return Category the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'category';
    }

    public function defaultScope() {
        return array_merge(array(
                    "order" => "Name ASC"
                        ), parent::defaultScope());
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Name, ModuleId, URI, ProjectKey, DateCreated, DateModified, CreatorCMSUserId, ModifierCMSUserId', 'required'),
            array('ParentId, ModuleId, ItemId, CreatorCMSUserId, ModifierCMSUserId', 'length', 'max' => 11),
            array('Name, URI', 'length', 'max' => 255),
            array('ProjectKey', 'length', 'max' => 32),
            array('Meta', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, ParentId, Name, ModuleId, ItemId, URI, Meta, ProjectKey, DateCreated, DateModified, CreatorCMSUserId, ModifierCMSUserId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'creatorCMSUser' => array(self::BELONGS_TO, 'CMSUser', 'CreatorCMSUserId'),
            'modifierCMSUser' => array(self::BELONGS_TO, 'CMSUser', 'ModifierCMSUserId'),
            'module' => array(self::BELONGS_TO, 'Module', 'ModuleId'),
            'parent' => array(self::BELONGS_TO, 'Category', 'ParentId'),
            'categories' => array(self::HAS_MANY, 'Category', 'ParentId'),
            'projectKey' => array(self::BELONGS_TO, 'Project', 'ProjectKey'),
            'categoryitems' => array(self::HAS_MANY, 'CategoryItem', 'CategoryId')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'ParentId' => 'Parent',
            'Name' => 'Name',
            'ModuleId' => 'Module',
            'ItemId' => 'Item',
            'URI' => 'Uri',
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
        $criteria->compare('ParentId', $this->ParentId, true);
        $criteria->compare('Name', $this->Name, true);
        $criteria->compare('ModuleId', $this->ModuleId, true);
        $criteria->compare('ItemId', $this->ItemId, true);
        $criteria->compare('URI', $this->URI, true);
        $criteria->compare('Meta', $this->Meta, true);
        $criteria->compare('ProjectKey', $this->ProjectKey, true);
        $criteria->compare('DateCreated', $this->DateCreated, true);
        $criteria->compare('DateModified', $this->DateModified, true);
        $criteria->compare('CreatorCMSUserId', $this->CreatorCMSUserId, true);
        $criteria->compare('ModifierCMSUserId', $this->ModifierCMSUserId, true);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

    /**
     * Gets full url with all parents
     * @return type array()
     */
    public function getFullURI() {

        $retVal = array();

        $levelModel = $this;

        array_push($retVal, $levelModel->URI);
        while ($levelModel->ParentId != null) {
            $levelModel = Category::model()->findByPk($levelModel->ParentId);
            array_push($retVal, $levelModel->URI);
        }

        return array_reverse($retVal);
    }

    public function getFullURIAsString() {
        return implode("/", $this->getFullURI());
    }

}