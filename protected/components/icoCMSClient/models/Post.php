<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 * @property string $Id
 * @property string $DateCreated
 * @property string $DateModified
 * @property string $CreatorCMSUserId
 * @property string $Title
 * @property string $AuthorId
 * @property string $CategoryId
 * @property string $Lead
 * @property string $Text
 * @property string $SEOFriendlyURL
 * @property string $ProjectKey
 * @property string $Meta
 *
 * The followings are the available model relations:
 * @property Category $category
 * @property Cmsuser $author
 * @property Cmsuser $creatorCMSUser
 * @property Project $projectKey
 */
class Post extends IcoCMSClientCategorizedModel {

    /**
     * Returns the static model of the specified AR class.
     * @return Post the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function behaviors() {
        return array(
            'DocumentVersionBehavior' => array(
                'class' => 'icoCMSClient.behaviors.IcoCMSClientDocumentVersionBehavior'
            ),
             'ItemURIBehavior' => array(
                'class' => 'icoCMSClient.behaviors.IcoCMSClientItemURIBehavior'
            )
        );
    }

    public function defaultScope() {
        $parentCondition = parent::defaultScope();
        $condition = array(
            "condition" => $parentCondition["condition"] . " and PublicationDate <= now()",
            "order" => "PublicationDate DESC"
        );

        return $condition;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'post';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('DateCreated, DateModified, CreatorCMSUserId, AuthorId, Text, SEOFriendlyURL, ProjectKey, Meta', 'required'),
            array('CreatorCMSUserId, AuthorId, CategoryId', 'length', 'max' => 11),
            array('SEOFriendlyURL', 'length', 'max' => 255),
            array('ProjectKey', 'length', 'max' => 32),
            array('Title, Lead, LeadMediaId, PublicationDate', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, DateCreated, DateModified, CreatorCMSUserId, Title, AuthorId, CategoryId, Lead, Text, SEOFriendlyURL, ProjectKey, Meta', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'category' => array(self::HAS_MANY, 'Category', array('CategoryId' => 'Id'), 'through' => 'categoryitem',
                'condition' => "category.ModuleId = " . $this->getModuleId()),
            'categoryitem' => array(self::HAS_MANY, 'CategoryItem', array('ItemId' => 'Id')),
            'author' => array(self::BELONGS_TO, 'CMSUser', 'AuthorId'),
            'creatorCMSUser' => array(self::BELONGS_TO, 'CMSUser', 'CreatorCMSUserId'),
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
            'CreatorCMSUserId' => 'Creator Cmsuser',
            'LeadMediaId' => "Lead Media",
            'Title' => 'Title',
            'AuthorId' => 'Author',
            'CategoryId' => 'Category',
            'Lead' => 'Lead',
            'Text' => 'Text',
            'SEOFriendlyURL' => 'Seofriendly Url',
            'ProjectKey' => 'Project Key',
            'Meta' => 'Meta',
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
        $criteria->compare('CreatorCMSUserId', $this->CreatorCMSUserId, true);
        $criteria->compare('Title', $this->Title, true);
        $criteria->compare('AuthorId', $this->AuthorId, true);
        $criteria->compare('CategoryId', $this->CategoryId, true);
        $criteria->compare('Lead', $this->Lead, true);
        $criteria->compare('Text', $this->Text, true);
        $criteria->compare('SEOFriendlyURL', $this->SEOFriendlyURL, true);
        $criteria->compare('ProjectKey', $this->ProjectKey, true);
        $criteria->compare('Meta', $this->Meta, true);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

    public function getModuleId() {
        return 3;
    }

    public function getAuthor() {
        $this->addRelatedRecord("Author", "author", false);
        return $this->author->getName();
    }

}