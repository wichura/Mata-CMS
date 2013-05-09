
<?php

/**
 * This is the model class for table "project".
 *
 * The followings are the available columns in table 'project':
 * @property string $Id
 * @property string $DateCreated
 * @property string $Name
 * @property string $ProjectTypeId
 * @property string $ProjectKey
 * @property string $URI
 * @property string $ClientId
 * @property string $Language
 *
 * The followings are the available model relations:
 * @property Client $client
 * @property Cmsuser $creatorCMSUser
 * @property Media $media
 * @property Cmsuser $modifierCMSUser
 * @property Projecttype $projectType
 */
class Project extends MataCMSActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Project the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'project';
    }

    public function defaultScope() {
        return array(
            'with' => array(
                "users" => array(
                    "joinType" => "INNER JOIN",
                    "condition" => "UserId = " . Yii::app()->user->getId()
                )
            )
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Name, ProjectTypeId, ProjectKey, ClientId, CreatorUserId, ModifierUserId', 'required'),
            array('Name, URI', 'length', 'max' => 255),
            array('ProjectTypeId, ClientId', 'length', 'max' => 2),
            array('ProjectKey', 'length', 'max' => 32),
            array('Language', 'length', 'max' => 15),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, DateCreated, Name, ProjectTypeId, ProjectKey, URI, ClientId, Language, DateModified, CreatorUserId, ModifierUserId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'client' => array(self::BELONGS_TO, 'Client', 'ClientId'),
            'creatorCMSUser' => array(self::BELONGS_TO, 'Cmsuser', 'CreatorUserId'),
            'modifierCMSUser' => array(self::BELONGS_TO, 'Cmsuser', 'ModifierUserId'),
            'projectType' => array(self::BELONGS_TO, 'Projecttype', 'ProjectTypeId'),
            'users' => array(self::MANY_MANY, 'User', 'userproject(UserId, ProjectId)')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'DateCreated' => 'Date Created',
            'Name' => 'Name',
            'ProjectTypeId' => 'Project Type',
            'ProjectKey' => 'Project Key',
            'URI' => 'Website',
            'ClientId' => 'Client',
            'Language' => 'Language',
            'DateModified' => 'Date Modified',
            'CreatorUserId' => 'Creator Cmsuser',
            'ModifierUserId' => 'Modifier Cmsuser',
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
        $criteria->compare('Name', $this->Name, true);
        $criteria->compare('ProjectTypeId', $this->ProjectTypeId, true);
        $criteria->compare('ProjectKey', $this->ProjectKey, true);
        $criteria->compare('URI', $this->URI, true);
        $criteria->compare('ClientId', $this->ClientId, true);
        $criteria->compare('Language', $this->Language, true);
        $criteria->compare('DateModified', $this->DateModified, true);
        $criteria->compare('CreatorUserId', $this->CreatorUserId, true);
        $criteria->compare('ModifierUserId', $this->ModifierUserId, true);


        if (isset($_GET["filter"]) && !empty($_GET["filter"])) {
            $filter = $_GET["filter"];

            $criteria->compare("Name", $filter, true, "AND");
            $criteria->compare("Uri", $filter, true, "OR");
        }
        
        $criteria->together = true;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            "sort" => array(
                "defaultOrder" => "Name ASC"
            )
        ));
    }

    public function getLabel() {
        return $this->Name;
    }

    public function beforeValidate() {

        if ($this->isNewRecord) {
            $this->ProjectKey = new CDbExpression("REPLACE(UUID(), '-', '')");
        }

        return parent::beforeValidate();
    }
    
    protected function afterSave() {
        
        if ($this->isNewRecord) {
            $linking = new UserProject();
            $linking->attributes = array(
                "ProjectId" => $this->Id,
                "UserId" => Yii::app()->user->getId()
            );
            
            if ($linking->save() == false)
                throw new CHttpException("Could not create the linking between the new project and the user due to: " . $linking->getFirstError());
        }
        
        parent::afterSave();
    }

    public function getSortableAttributes() {
        return array("Name", "DateCreated", "URI");
    }


}