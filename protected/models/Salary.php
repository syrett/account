<?php

/**
 * This is the model class for table "salary".
 *
 * The followings are the available columns in table 'salary':
 * @property integer $id
 * @property string $order_no
 * @property string $entry_date
 * @property integer $employee_id
 * @property string $salary_amount
 * @property string $bonus_amount
 * @property string $benefit_amount
 * @property integer $subject
 * @property string $subject_2
 * @property string $create_time
 * @property integer $update_time
 * @property integer $status_id
 *
 * The followings are the available model relations:
 * @property Subjects $subject0
 * @property Employee $employee
 */
class Salary extends LFSModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'salary';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_no, entry_date, employee_id, salary_amount, bonus_amount, benefit_amount, status_id', 'required'),
			array('employee_id, subject, update_time, status_id', 'numerical', 'integerOnly'=>true),
			array('order_no, entry_date', 'length', 'max'=>16),
			array('salary_amount, bonus_amount, benefit_amount', 'length', 'max'=>12),
			array('subject_2', 'length', 'max'=>512),
            array('social_personal,provident_personal,personal_tax,social_company,provident_company,base_amount', 'safe'),
			// The following rule is used by search().
			array('id, order_no, entry_date, employee_id, salary_amount, bonus_amount, benefit_amount, subject, subject_2, create_time, update_time, status_id', 'safe', 'on'=>'search'),
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
			'subject0' => array(self::BELONGS_TO, 'Subjects', 'subject'),
			'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_no' => '工资单号',
			'entry_date' => '工资日期',
			'employee_id' => '员工姓名',
			'salary_amount' => '工资',
			'bonus_amount' => '奖金',
			'benefit_amount' => '其他福利',
            'social_personal' => '社保个人',
            'provident_personal' => '公积金个人',
            'personal_tax' => '个税',
            'social_company' => '社保公司',
            'provident_company' => '公积金公司',
            'base_amount' => '社保基数',
			'subject' => 'Subject',
			'subject_2' => 'Subject 2',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'status_id' => 'Status',
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
        $criteria->with = 'employee';
		$criteria->compare('id',$this->id);
		$criteria->compare('order_no',$this->order_no,true);
		$criteria->compare('entry_date',$this->entry_date,true);
		$criteria->compare('employee.name',$this->employee_id, true);
		$criteria->compare('salary_amount',$this->salary_amount,true);
		$criteria->compare('bonus_amount',$this->bonus_amount,true);
		$criteria->compare('benefit_amount',$this->benefit_amount,true);
		$criteria->compare('subject',$this->subject);
		$criteria->compare('subject_2',$this->subject_2,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('status_id',$this->status_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Salary the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /*
     * load 加载数据
     */
    public function load($item){
        if($this->order_no!='')
            $item['order_no'] = $this->order_no;
        $this->setAttributes($item);
        $this->setAttribute('order_no', $item['order_no']);
        $this->setAttribute('entry_date', $item['entry_date']);
        $this->setAttribute('subject', $item['entry_subject']);
        $this->setAttribute('status_id', $item['status_id']);

        $employee = Employee::model()->findByAttributes(['name'=>$item['employee_name']]);
        if($employee==null){
            $arr['error'] = ["无法找到员工"];
            $result[] = ['status' => 0, 'data' => $arr];
        }
        $this->setAttribute('employee_id', $employee->id);
    }
}
