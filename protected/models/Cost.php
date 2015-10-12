<?php

/**
 * This is the model class for table "cost".
 *
 * The followings are the available columns in table 'cost':
 * @property integer $id
 * @property string $order_no
 * @property string $entry_date
 * @property string $entry_name
 * @property string $stocks
 * @property string $stocks_count
 * @property string $stocks_price
 * @property double $entry_amount
 * @property integer $subject
 * @property integer $subject_2
 * @property string $create_time
 * @property integer $update_time
 * @property integer $status_id
 *
 * The followings are the available model relations:
 * @property Client $client
 * @property Subjects $subject0
 * @property Subjects $subject2
 */
class Cost extends LFSModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cost';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entry_date, entry_amount, ', 'required'),
			array('subject, update_time, status_id', 'numerical', 'integerOnly'=>true),
			array('entry_amount', 'numerical'),
			array('order_no, entry_date', 'length', 'max'=>16),
			array('entry_name, stocks, stocks_count, stocks_price', 'length', 'max'=>512),
            array('model, count', 'safe'),
			// The following rule is used by search().
			array('id, order_no, entry_date, entry_name, stocks, stocks_count, stocks_price, entry_amount, subject, subject_2, create_time, update_time, status_id', 'safe', 'on'=>'search'),
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
			'subject2' => array(self::BELONGS_TO, 'Subjects', 'subject_2'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_no' => '成本结转单号',
			'entry_date' => '成本结转日期',
			'entry_name' => '商品名称',
            'model' => '型号',
            'count' => '盘点数量',
            'stocks' => '商品清单',
			'stocks_count' => '对应数量',
			'stocks_price' => '对应当时计算价格',
			'entry_amount' => '成本',
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
		$criteria->compare('entry_name',$this->entry_name,true);
		$criteria->compare('stocks',$this->stocks,true);
		$criteria->compare('stocks_count',$this->stocks_count,true);
		$criteria->compare('stocks_price',$this->stocks_price,true);
		$criteria->compare('entry_amount',$this->entry_amount,true);
		$criteria->compare('subject',$this->subject);
		$criteria->compare('subject_2',$this->subject_2);
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
	 * @return Cost the static model class
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
//        $this->setAttribute('updated_at', isset($item['updated_at'])?$item['updated_at']:'');
    }
}
