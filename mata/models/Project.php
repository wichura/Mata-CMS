
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
 * @property string $Alias
 * @property string $MediaId
 * @property string $DateModified
 * @property string $CreatorCMSUserId
 * @property string $ModifierCMSUserId
 *
 * The followings are the available model relations:
 * @property Client $client
 * @property Cmsuser $creatorCMSUser
 * @property Media $media
 * @property Cmsuser $modifierCMSUser
 * @property Projecttype $projectType
 */
class Project extends BaseActiveRecord {

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
             'with'=> array(
                 "users" => array(
                     "joinType" => "INNER JOIN"
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
            array('Name, ProjectTypeId, ProjectKey, ClientId, CreatorCMSUserId, ModifierCMSUserId', 'required'),
            array('Name, URI', 'length', 'max' => 255),
            array('ProjectTypeId, ClientId', 'length', 'max' => 2),
            array('ProjectKey', 'length', 'max' => 32),
            array('Language, Alias', 'length', 'max' => 15),
            array('MediaId, CreatorCMSUserId, ModifierCMSUserId', 'length', 'max' => 11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, DateCreated, Name, ProjectTypeId, ProjectKey, URI, ClientId, Language, Alias, MediaId, DateModified, CreatorCMSUserId, ModifierCMSUserId', 'safe', 'on' => 'search'),
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
            'creatorCMSUser' => array(self::BELONGS_TO, 'Cmsuser', 'CreatorCMSUserId'),
            'media' => array(self::BELONGS_TO, 'Media', 'MediaId'),
            'modifierCMSUser' => array(self::BELONGS_TO, 'Cmsuser', 'ModifierCMSUserId'),
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
            'URI' => 'Uri',
            'ClientId' => 'Client',
            'Language' => 'Language',
            'Alias' => 'Alias',
            'MediaId' => 'Media',
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
        $criteria->compare('DateCreated', $this->DateCreated, true);
        $criteria->compare('Name', $this->Name, true);
        $criteria->compare('ProjectTypeId', $this->ProjectTypeId, true);
        $criteria->compare('ProjectKey', $this->ProjectKey, true);
        $criteria->compare('URI', $this->URI, true);
        $criteria->compare('ClientId', $this->ClientId, true);
        $criteria->compare('Language', $this->Language, true);
        $criteria->compare('Alias', $this->Alias, true);
        $criteria->compare('MediaId', $this->MediaId, true);
        $criteria->compare('DateModified', $this->DateModified, true);
        $criteria->compare('CreatorCMSUserId', $this->CreatorCMSUserId, true);
        $criteria->compare('ModifierCMSUserId', $this->ModifierCMSUserId, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}