<?php

/**
 * This is the model class for table "yii2_start_condom".
 *
 * The followings are the available columns in table 'yii2_start_condom':
 * @property integer $id
 * @property string $dbname
 * @property string $company
 * @property integer $starttime
 * @property string $address
 * @property string $cuser
 * @property string $cphone
 * @property string $note
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Condom extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'yii2_start_condom';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dbname, company, starttime, address, cuser, cphone, note, created_at, status', 'required'),
			array('starttime, created_at, updated_at, status', 'numerical', 'integerOnly'=>true),
			array('dbname', 'length', 'max'=>32),
			array('company, cuser', 'length', 'max'=>256),
			array('cphone', 'length', 'max'=>16),
			// The following rule is used by search().
			array('id, dbname, company, starttime, address, cuser, cphone, note, created_at, updated_at, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array('access' => array(self::HAS_MANY, 'access', 'condom_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'dbname' => 'Dbname',
			'company' => '公司',
            'currency_t' => '本位币',
            'business_t' => '企业类型',
            'industry_t' => '行业性质',
            'taxpayer_t' => '纳税性质',
            'accounting_t' => '会计制度',
            'companysize_t' => '企业规模',
			'starttime' => '账套起始时间',
			'address' => '地址',
			'cuser' => '联系人姓名',
			'cphone' => '联系人电话',
			'note' => '备注',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'status' => '状态',
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
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('dbname',$this->dbname,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('starttime',$this->starttime);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('cuser',$this->cuser,true);
		$criteria->compare('cphone',$this->cphone,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);
		$criteria->compare('status',$this->status);

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
	 * @return Condom the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getStartTime(){
        $cri = new CDbCriteria();
        $cri->addCondition('dbname=:SYSDB');
        $cri->params['SYSDB'] = substr(SYSDB,8);
        $condom = Condom::model()->find($cri);
        if(!empty($condom)){
            $time = $condom->starttime;
            return date("Ym", $time);
        }
    }

    public function getName($dbname=''){
        if($dbname==''){
            $dbname = substr(SYSDB, 8);
        }
        $model = $this->findByAttributes(["dbname"=>$dbname]);
        if($model!=null)
            return $model->company;
        else
            return '未找到此公司名字';
    }

    /*
     * 获取当前账套的condom
     */
    public static function getCondom(){
        $cri = new CDbCriteria();
        $cri->addCondition('dbname=:SYSDB');
        $cri->params['SYSDB'] = substr(SYSDB,8);
        $condom = Condom::model()->find($cri);
        return $condom;
    }
}
