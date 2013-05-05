<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SystemEventLog
 *
 * @author wichura
 */
class SystemEventLog extends CApplicationComponent {

    public function record($event, $value = null) {

        $ipAddress = null;
        if (isset($_SERVER["REMOTE_ADDR"])) {
            $ipAddress = $_SERVER["REMOTE_ADDR"];
        } else if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ipAddress = $_SERVER["HTTP_CLIENT_IP"];
        };

        $model = new SystemEventLogModel();
        $model->attributes = array(
            "Event" => $event,
            "Value" => $value,
            "IPAddress" => $ipAddress,
            "ProjectId" => Yii::app()->user->project->Id,
            "UserId" => Yii::app()->user->getId()
        );

        $model->save();
    }

    public function getModel() {
        return SystemEventLogModel::model();
    }

}

class SystemEventLogModel extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SystemEventLog the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'systemeventlog';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Event, ProjectId,UserId', 'required'),
            array('Event', 'length', 'max' => 255),
            array('IPAddress', 'length', 'max' => 15),
            array('Value, IPAddress, Event, DateCreated', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, DateCreated, Event, Value, IPAddress', 'safe', 'on' => 'search'),
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
            'Id' => 'ID',
            'DateCreated' => 'Date Created',
            'Event' => 'Event',
            'Value' => 'Value',
            'IPAddress' => 'Ipaddress',
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
        $criteria->compare('Event', $this->Event, true);
        $criteria->compare('Value', $this->Value, true);
        $criteria->compare('IPAddress', $this->IPAddress, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => "DateCreated DESC"
            )
        ));
    }

}

?>
