<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property string $Id
 * @property string $RegionId
 * @property string $DateCreated
 * @property string $Comment
 * @property string $Name
 * @property string $EmailAddress
 * @property string $ClientIPAddress
 * @property string $ProjectKey
 *
 * The followings are the available model relations:
 * @property Project $projectKey
 */
class Comment extends BaseIcoCMSClientModel {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Comment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'comment';
    }

    public function defaultScope() {
        return array_merge(parent::defaultScope(), array(
                    "order" => "DateCreated DESC"
                ));
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Comment', 'required'),
            array('Name, EmailAddress', 'length', 'max' => 128),
            array('ClientIPAddress', 'length', 'max' => 15),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, RegionId, DateCreated, Comment, Name, EmailAddress, ClientIPAddress, ProjectKey', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'projectKey' => array(self::BELONGS_TO, 'Project', 'ProjectKey'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'RegionId' => 'Region',
            'DateCreated' => 'Date Created',
            'Comment' => 'Comment',
            'Name' => 'Name',
            'EmailAddress' => 'Email Address',
            'ClientIPAddress' => 'Client Ipaddress',
            'ProjectKey' => 'Project Key',
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
        $criteria->compare('RegionId', $this->RegionId, true);
        $criteria->compare('DateCreated', $this->DateCreated, true);
        $criteria->compare('Comment', $this->Comment, true);
        $criteria->compare('Name', $this->Name, true);
        $criteria->compare('EmailAddress', $this->EmailAddress, true);
        $criteria->compare('ClientIPAddress', $this->ClientIPAddress, true);
        $criteria->compare('ProjectKey', $this->ProjectKey, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function beforeSave() {
        if (isset($_SERVER["REMOTE_ADDR"]))
            $this->ClientIPAddress = $_SERVER["REMOTE_ADDR"];

        return true;
    }

}

?>
