<?php

/**
 * This is the model class for table "yii2_start_profiles".
 *
 * The followings are the available columns in table 'yii2_start_profiles':
 * @property integer $user_id
 * @property string $name
 * @property string $surname
 * @property string $phone
 * @property integer $condom_id
 * @property integer $bank
 * @property string $avatar_url
 *
 * The followings are the available model relations:
 * @property Yii2StartAccess[] $yii2StartAccesses
 * @property Yii2StartUsers $user
 * @property Yii2StartCondom $condom
 */
class Profiles extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'yii2_start_profiles';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, surname, phone, bank, avatar_url', 'required'),
            array('condom_id, bank', 'numerical', 'integerOnly' => true),
            array('name, surname', 'length', 'max' => 50),
            array('phone', 'length', 'max' => 16),
            array('avatar_url', 'length', 'max' => 64),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('user_id, name, surname, phone, condom_id, bank, avatar_url', 'safe', 'on' => 'search'),
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
            'yii2StartAccesses' => array(self::HAS_MANY, 'Yii2StartAccess', 'user_id'),
            'user' => array(self::BELONGS_TO, 'Yii2StartUsers', 'user_id'),
            'condom' => array(self::BELONGS_TO, 'Yii2StartCondom', 'condom_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'User',
            'name' => Yii::t('models/model', '真实姓名'),
            'surname' => 'Surname',
            'phone' => Yii::t('models/model', '电话'),
            'condom_id' => Yii::t('models/model', '账套'),
            'bank' => Yii::t('models/model', '选择银行'),
            'avatar_url' => 'Avatar Url',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('surname', $this->surname, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('condom_id', $this->condom_id);
        $criteria->compare('bank', $this->bank);
        $criteria->compare('avatar_url', $this->avatar_url, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection()
    {
        return Yii::app()->dbadmin;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Profiles the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
