<?php

/**
 * This is the model class for table "countrylanguage".
 *
 * The followings are the available columns in table 'countrylanguage':
 * @property string $CountryCode
 * @property string $Language
 * @property string $LanguageCode
 * @property integer $Priority
 */
class CountryLanguage extends BaseIcoCMSClientModel {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Countrylanguage the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'countrylanguage';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('LanguageCode, Priority', 'required'),
            array('Priority', 'numerical', 'integerOnly' => true),
            array('CountryCode', 'length', 'max' => 3),
            array('Language', 'length', 'max' => 30),
            array('LanguageCode', 'length', 'max' => 2),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('CountryCode, Language, LanguageCode, Priority', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'languages' => array(self::BELONGS_TO, 'Language', 'LanguageCode'),
            'countries' => array(self::BELONGS_TO, 'Country', 'CountryCode'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'CountryCode' => 'Country Code',
            'Language' => 'Language',
            'LanguageCode' => 'Language Code',
            'Priority' => 'Priority',
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

        $criteria->compare('CountryCode', $this->CountryCode, true);
        $criteria->compare('Language', $this->Language, true);
        $criteria->compare('LanguageCode', $this->LanguageCode, true);
        $criteria->compare('Priority', $this->Priority);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
                ));
    }

}