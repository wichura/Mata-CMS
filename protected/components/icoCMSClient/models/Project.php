<?php

/**
 * This is the model class for table "project".
 *
 * The followings are the available columns in table 'project':
 * @property string $Id
 * @property string $Name
 * @property string $ProjectTypeId
 * @property string $URI
 * @property string $ProjectKey
 *  * @property Number $MediaId
 * @property string $Alias
 *
 * The followings are the available model relations:
 * @property Blogpost[] $blogposts
 * @property Client[] $clients
 * @property Cmsuserdesktopicon[] $cmsuserdesktopicons
 * @property Cmsuser[] $cmsusers
 * @property Mediafolder[] $mediafolders
 * @property Projecttype $projectType
 * @property Projectmenuitem[] $projectmenuitems
 * @property Yiimoduleprojectsetting[] $yiimoduleprojectsettings
 */
class Project extends BaseIcoCMSClientModel {

    /**
     * Returns the static model of the specified AR class.
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

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Name, ProjectTypeId, ProjectKey', 'required'),
            array('Name, URI', 'length', 'max' => 255),
            array('ProjectTypeId', 'length', 'max' => 2),
            array('ProjectKey', 'length', 'max' => 32),
            array('MediaId', 'length', 'max' => 1),
            array('Alias', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, Name, ProjectTypeId, URI, ProjectKey, Alias', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'blogposts' => array(self::HAS_MANY, 'Blogpost', 'ProjectKey'),
            'clients' => array(self::MANY_MANY, 'Client', 'clientproject(ProjectId, ClientId)'),
            'cmsuserdesktopicons' => array(self::HAS_MANY, 'Cmsuserdesktopicon', 'ProjectId'),
            'CMSUser' => array(self::MANY_MANY, 'Cmsuser', 'cmsuserproject(ProjectId, CMSUserId)'),
            'CMSUserRaw' => array(self::MANY_MANY, 'CMSUserRaw', 'cmsuserproject(ProjectId, CMSUserId)'),
            'mediafolders' => array(self::HAS_MANY, 'Mediafolder', 'ProjectKey'),
            'projectType' => array(self::BELONGS_TO, 'Projecttype', 'ProjectTypeId'),
            'projectmenuitems' => array(self::HAS_MANY, 'Projectmenuitem', 'ProjectId'),
            'yiimoduleprojectsettings' => array(self::HAS_MANY, 'Yiimoduleprojectsetting', 'ProjectId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'Name' => 'Name',
            'ProjectTypeId' => 'Project Type',
            'URI' => 'Uri',
            'ProjectKey' => 'Project Key',
            'Alias' => 'Alias',
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
        $criteria->compare('ProjectTypeId', $this->ProjectTypeId, true);
        $criteria->compare('URI', $this->URI, true);
        $criteria->compare('ProjectKey', $this->ProjectKey, true);
        $criteria->compare('Alias', $this->Alias, true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
                ));
    }

    public function getAvatarPath() {
        if ($this->MediaId != null) {
            $media = Media::model()->findByPk($this->MediaId);
            return Yii::app()->params["pathToMediaFolder"] . $media->FilePath;
        } else {
            return "/images/icons/project-96.png";
        }
    }

    public function beforeValidate() {

        if ($this->isNewRecord) {
            $this->ProjectKey = new CDbCommand("SELECT REPLACE(UUID(), '-', '')");
        }
    }

    private function assignActiveUser() {

        $model = new CMSUserProject();
        $model->attributes(array(
            "CMSUserId" => Yii::app()->user->getId(),
            "ProjectId" => $this->Id
        ));

        if ($model->save() == false)
            throw new CHttpException(500, "Could not assign user to project");
    }

    private function createMediaFolder() {
        // create folder in the file system 
        $filePath = Yii::app()->params["filePathToMedia"] . $this->Name;
        mkdir(Yii::app()->params["filePathToMedia"] . $this->Name);
        chmod($filePath, 0777);

        $mf = new MediaFolder();

        $mf->attributes(array(
            "ParentId" => null,
            "Name" => $this->Name
        ));

        if ($mf->save())
            throw new CHttpException(500, "Could not store folder in db");
    }

    protected function afterSave() {

        if ($this->isNewRecord) {
            $this->createMediaFolder();
            $this->assignActiveUser();
        }

        parent::afterSave();
    }

    public function getModuleId() {
        return 11;
    }

}