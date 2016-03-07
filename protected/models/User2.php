<?php

/**
 * This is the model class for table "tbl_user2".
 *
 * The followings are the available columns in table 'tbl_user2':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 */
class User2 extends CActiveRecord
{
	public function getDbConnection() {

		return Yii::app()->dbadmin;
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'yii2_start_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, email', 'required'),
			array('username, password, email', 'length', 'max'=>128),
			// The following rule is used by search().
			array('id, username, password, email', 'safe', 'on'=>'search'),
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
            'profiles' => array(self::HAS_ONE, 'Profiles', 'user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('models/model','编号'),
			'username' => Yii::t('models/model','用户名'),
			'password' => Yii::t('models/model','密码'),
			'email' => Yii::t('models/model','邮箱'),
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User2 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function checkVIP($uid=0){
        if($uid==0)
            $uid = Yii::app()->user->id;
        $user = User2::model()->findByPk($uid);
        if(empty($user) || $user->vip==0){
            return false;
        }else{
            return true;
        }
    }

    public static function getBank(){
        $uid = Yii::app()->user->id;
        $user = User2::model()->findByPk($uid);
        if($user!=null){
            if(Subjects::model()->findByAttributes(['sbj_number'=>$user->bank]))
                return $user->bank;
            else{
                $banks = Subjects::model()->findAllByAttributes([],'sbj_number like "1002%"');
                if(count($banks)>1){
                    $bank = end($banks);
                    return $bank->sbj_number;
                }
            }
        }
        return 1002;
    }
}
