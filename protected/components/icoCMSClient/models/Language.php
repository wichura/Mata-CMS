<?php

/**
 * This is the model class for table "language".
 *
 * The followings are the available columns in table 'language':
 * @property string $LanguageCode
 * @property string $LanguageISO6391Code
 * @property string $Name
 * @property integer $Id
 *
 * The followings are the available model relations:
 * @property Countrylanguage[] $countrylanguages
 */
class Language extends BaseIcoCMSClientModel {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Language the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'language';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('LanguageCode, LanguageISO6391Code', 'required'),
            array('Id', 'numerical', 'integerOnly' => true),
            array('LanguageCode', 'length', 'max' => 2),
            array('LanguageISO6391Code', 'length', 'max' => 3),
            array('Name', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('LanguageCode, LanguageISO6391Code, Name, Id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'countrylanguages' => array(self::HAS_MANY, 'CountryLanguage', 'LanguageCode'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'LanguageCode' => 'Language Code',
            'LanguageISO6391Code' => 'Language Iso6391 Code',
            'Name' => 'Name',
            'Id' => 'ID',
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

        $criteria->compare('LanguageCode', $this->LanguageCode, true);
        $criteria->compare('LanguageISO6391Code', $this->LanguageISO6391Code, true);
        $criteria->compare('Name', $this->Name, true);
        $criteria->compare('Id', $this->Id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
                ));
    }

}