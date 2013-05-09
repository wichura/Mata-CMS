<?php

/**
 * This is the model class for table "mediafolder".
 *
 * The followings are the available columns in table 'mediafolder':
 * @property string $Id
 * @property string $ParentId
 * @property string $Name
 * @property string $DateCreated
 * @property string $DateModified
 * @property integer $Active
 * @property string $ProjectKey
 * @property string $Password
 * @property integer $CreatorCMSUserId
 * @property integer $ModifierCMSUserId
 *
 * The followings are the available model relations:
 * @property Media[] $medias
 * @property MediaFolder $parent
 * @property MediaFolder[] $mediafolders
 * @property Project $projectKey
 */
class MediaFolder extends MataActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MediaFolder the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mediafolder';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('DateCreated, DateModified, ProjectKey, CreatorCMSUserId, ModifierCMSUserId', 'required'),
            array('Active, CreatorCMSUserId, ModifierCMSUserId', 'numerical', 'integerOnly'=>true),
            array('ParentId', 'length', 'max'=>11),
            array('Name', 'length', 'max'=>255),
            array('ProjectKey', 'length', 'max'=>32),
            array('Password', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, ParentId, Name, DateCreated, DateModified, Active, ProjectKey, Password, CreatorCMSUserId, ModifierCMSUserId', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'medias' => array(self::HAS_MANY, 'Media', 'MediaFolderId'),
            'parent' => array(self::BELONGS_TO, 'MediaFolder', 'ParentId'),
            'mediafolders' => array(self::HAS_MANY, 'MediaFolder', 'ParentId'),
            'projectKey' => array(self::BELONGS_TO, 'Project', 'ProjectKey'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'Id' => 'ID',
            'ParentId' => 'Parent',
            'Name' => 'Name',
            'DateCreated' => 'Date Created',
            'DateModified' => 'Date Modified',
            'Active' => 'Active',
            'ProjectKey' => 'Project Key',
            'Password' => 'Password',
            'CreatorCMSUserId' => 'Creator Cmsuser',
            'ModifierCMSUserId' => 'Modifier Cmsuser',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('Id',$this->Id,true);
        $criteria->compare('ParentId',$this->ParentId,true);
        $criteria->compare('Name',$this->Name,true);
        $criteria->compare('DateCreated',$this->DateCreated,true);
        $criteria->compare('DateModified',$this->DateModified,true);
        $criteria->compare('Active',$this->Active);
        $criteria->compare('ProjectKey',$this->ProjectKey,true);
        $criteria->compare('Password',$this->Password,true);
        $criteria->compare('CreatorCMSUserId',$this->CreatorCMSUserId);
        $criteria->compare('ModifierCMSUserId',$this->ModifierCMSUserId);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}