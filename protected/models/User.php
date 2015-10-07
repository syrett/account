<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $userid
 * @property string $password
 * @property string $fullname
 * @property string $mobile
 * @property string $email
 * @property string $title
 * @property integer $sys_role
 * @property string $roles
 */
class User extends UserActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'yii2_start_users';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array('profile' => array(self::HAS_ONE, 'profiles', 'user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
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
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('sys_role',$this->sys_role);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function saveBank($bank){
        $user = User::model()->find(Yii::app()->user->id);
        $user->bank = $bank;
        $user->save();
    }

    public function superAdmin(){
        $me = $this->findByPk(Yii::app()->user->id);
        if($me!=null && $me->role=='superadmin')
            return true;
        else
            return false;
    }
}
