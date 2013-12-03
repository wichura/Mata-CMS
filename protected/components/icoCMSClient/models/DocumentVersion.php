<?php

/**
 * This is the model class for table "documentversion".
 *
 * The followings are the available columns in table 'documentversion':
 * @property string $DocumentId
 * @property string $Revision
 * @property string $DateCreated
 * @property string $ModelAttributes
 * @property string $CreatorCMSUserId
 *
 * The followings are the available model relations:
 * @property Cmsuser $creatorCMSUser
 */
class DocumentVersion extends BaseIcoCMSClientModel {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DocumentVersion the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'documentversion';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('DocumentId, Revision, DateCreated, ModelAttributes, CreatorCMSUserId', 'required'),
            array('DocumentId', 'length', 'max' => 40),
            array('Revision', 'length', 'max' => 10),
            array('CreatorCMSUserId', 'length', 'max' => 11),
            array("Comment", "safe"),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('DocumentId, Revision, DateCreated, ModelAttributes, CreatorCMSUserId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'creatorCMSUser' => array(self::BELONGS_TO, 'Cmsuser', 'CreatorCMSUserId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'DocumentId' => 'Document',
            'Revision' => 'Revision',
            'DateCreated' => 'Date Created',
            'ModelAttributes' => 'Model Attributes',
            'CreatorCMSUserId' => 'Creator Cmsuser',
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

        $criteria->compare('DocumentId', $this->DocumentId, true);
        $criteria->compare('Revision', $this->Revision, true);
        $criteria->compare('DateCreated', $this->DateCreated, true);
        $criteria->compare('ModelAttributes', $this->ModelAttributes, true);
        $criteria->compare('CreatorCMSUserId', $this->CreatorCMSUserId, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}

