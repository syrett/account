<?php

/**
 * This is the model class for table "reimburse".
 *
 * The followings are the available columns in table 'reimburse':
 * @property integer $id
 * @property string $order_no
 * @property string $entry_date
 * @property string $entry_memo
 * @property integer $employee_id
 * @property string $travel_amount
 * @property string $benefit_amount
 * @property string $traffic_amount
 * @property string $phone_amount
 * @property string $entertainment_amount
 * @property string $office_amount
 * @property string $rent_amount
 * @property string $train_amount
 * @property string $service_amount
 * @property string $stamping_amount
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
class Reimburse extends LFSModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reimburse';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_no, entry_date, employee_id, status_id', 'required'),
			array('employee_id, subject, update_time, status_id', 'numerical', 'integerOnly'=>true),
			array('order_no, entry_date', 'length', 'max'=>16),
			array('entry_memo, paid', 'length', 'max'=>1024),
			array('travel_amount, benefit_amount, traffic_amount, phone_amount, entertainment_amount, office_amount, rent_amount, watere_amount, train_amount, service_amount, stamping_amount', 'length', 'max'=>12),
			array('subject_2', 'length', 'max'=>512),
			// The following rule is used by search().
			array('id, order_no, entry_date, entry_memo, employee_id, travel_amount, benefit_amount, traffic_amount, phone_amount, entertainment_amount, office_amount, rent_amount, train_amount, service_amount, stamping_amount, subject, subject_2, create_time, update_time, status_id', 'safe', 'on'=>'search'),
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
			'order_no' => '订单号',
			'entry_date' => '销售日期',
			'entry_memo' => '摘要',
			'employee_id' => '员工',
			'travel_amount' => '差旅费',
			'benefit_amount' => '福利费（餐费等）',
			'traffic_amount' => '交通费',
			'phone_amount' => '通讯费',
			'entertainment_amount' => '招待费',
			'office_amount' => '办公费',
			'rent_amount' => '租金',
            'watere_amount' => '水电费',
			'train_amount' => '培训费',
			'service_amount' => '服务费',
			'stamping_amount' => '印花税',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('order_no',$this->order_no,true);
		$criteria->compare('entry_date',$this->entry_date,true);
		$criteria->compare('entry_memo',$this->entry_memo,true);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('travel_amount',$this->travel_amount,true);
		$criteria->compare('benefit_amount',$this->benefit_amount,true);
		$criteria->compare('traffic_amount',$this->traffic_amount,true);
		$criteria->compare('phone_amount',$this->phone_amount,true);
		$criteria->compare('entertainment_amount',$this->entertainment_amount,true);
		$criteria->compare('office_amount',$this->office_amount,true);
		$criteria->compare('rent_amount',$this->rent_amount,true);
		$criteria->compare('train_amount',$this->train_amount,true);
		$criteria->compare('service_amount',$this->service_amount,true);
		$criteria->compare('stamping_amount',$this->stamping_amount,true);
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
	 * @return Reimburse the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /*
     * load 加载数据
     */
    public function load($item){
        $this->setAttributes($item);
        $this->setAttribute('order_no', $item['order_no']);
        $this->setAttribute('entry_date', $item['entry_date']);
        $this->setAttribute('subject', $item['entry_subject']);
        $this->setAttribute('subject_2', $item['subject_2']);
        $this->setAttribute('status_id', $item['status_id']);

        $employee = Employee::model()->findByAttributes(['name'=>$item['employee_name']]);
        if($employee==null){
            $arr['error'] = ["无法找到员工"];
            $result[] = ['status' => 0, 'data' => $arr];
        }
        $this->setAttribute('employee_id', $employee->id);
    }

    /*
     * 报销金额合计
     */
    public function mountTotal(){
        if($this->id==null)
            return 0;
        $arr = $this->attributes;
        $total = 0;
        foreach ($arr as $key => $item) {
            if(substr($key, -7) == '_amount')
                $total += $item;
        }
        return $total;
    }

    /*
     * 已经报销的金额
     */
    public function mountPaid(){
        $arr = json_decode($this->paid, true);
        $total = 0;
        if(count($arr) > 1){
            $paid = '';
            foreach ($arr as $item) {
                $paid .= explode(',', $item);
            }
            $paid = array_filter(implode(',', $paid));
            foreach ($paid as $item) {
                $total += $this[$item];
            }
        }


        return $total;
    }

    /*
     * 获取报销中，所有员工的名字，报销有临时预支借款，所以不论员工是否有报销每个员工都要列出
     */
    public static function getEmployee($name, $type=1, $version=1){
        $employees = Employee::model()->findAllByAttributes(['name'=>$name],'status>=1');
        if(!$employees)
            $employees = Employee::model()->findAll('status>=1');

        $result = [];
        foreach ($employees as $item) {
            $result[$item['name']] = $item['name'];
        }
        return $result;
    }

    public static function listOrders($name){
        $employee = Employee::model()->findByAttributes(['name'=>$name],'status>=1');
        $orders = Reimburse::model()->findAllByAttributes(['employee_id'=>$employee['id']]);
        $result = [];
        if(!empty($orders)) {
            foreach ($orders as $tran) {
                if ($tran) {  //检查已经报销的项目，如果全部都已经报销，则不显示
                    $tmp = '';

                    $real_order = json_decode($tran['paid'], true);
                    if($real_order)
                        foreach ($real_order as $item) {
                            $tmp .= ",$item";
                        }
                    $tmp = array_filter(explode(',', $tmp));

                    $pro_arr = ['travel_amount', 'benefit_amount', 'traffic_amount', 'phone_amount', 'entertainment_amount', 'office_amount', 'rent_amount', 'watere_amount', 'train_amount', 'service_amount', 'stamping_amount'];
                    $tmp2 = [];
                    foreach ($pro_arr as $pro) {
                        if ($tran[$pro] > 0)
                            $tmp2[] = $pro;
                    }
                    sort($tmp2);
                    sort($tmp);
                    if ($tmp2 != $tmp)
                        $result[] = $tran;

                }
            }
        }
        return $result;
    }
}
