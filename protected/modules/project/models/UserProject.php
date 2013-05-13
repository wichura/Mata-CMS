
<?php

/**
 * This is the model class for table "userproject".
 *
 * The followings are the available columns in table 'userproject':
 * @property string $UserId
 * @property string $ProjectId
 * @property string $DateCreated
 */
class UserProject extends BaseActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserProject the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'userproject';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('UserId, ProjectId', 'required'),
            array('UserId, ProjectId', 'length', 'max' => 11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('UserId, ProjectId, DateCreated', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'UserId' => 'User',
            'ProjectId' => 'Project',
            'DateCreated' => 'Date Created',
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

        $criteria->compare('UserId', $this->UserId, true);
        $criteria->compare('ProjectId', $this->ProjectId, true);
        $criteria->compare('DateCreated', $this->DateCreated, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}