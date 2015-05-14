<?php

/**
 * This is the model class for table "lfs_bank".
 *
 * The followings are the available columns in table 'lfs_bank':
 * @property integer $id
 * @property string $target
 * @property string $date
 * @property string $memo
 * @property double $amount
 * @property integer $parent
 * @property string $order
 * @property string $subject
 * @property integer $invoice
 * @property integer $tax
 * @property integer $status_id
 * @property string $created_at
 * @property integer $updated_at
 */
class Bank extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bank';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('amount, updated_at', 'required'),
			array('parent, invoice, tax, status_id, updated_at', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('target', 'length', 'max'=>512),
			array('date', 'length', 'max'=>64),
			array('subject', 'length', 'max'=>16),
			array('memo, order, created_at, tax', 'safe'),
			// The following rule is used by search().
			array('id, target, date, memo, amount, parent, order, invoice, tax, status_id, created_at, updated_at', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'target' => '交易对象',
			'date' => '日期',
			'memo' => '说明',
			'amount' => '金额',
			'parent' => '父ID',
			'order' => '订单号',
			'subject' => '科目',
			'invoice' => '有无发票',
			'tax' => '税率',
			'status_id' => 'Status',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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
		$criteria->compare('target',$this->target,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('memo',$this->memo,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('parent',$this->parent);
		$criteria->compare('order',$this->order,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('invoice',$this->invoice);
		$criteria->compare('tax',$this->tax);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at);

		$criteria->order = 'id desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Bank the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/*
     * admin页面不同状态不同颜色
     * $var row
     * $var $saved
     * @return css class name
     */
	public function getClass($row, $saved){
		$class = $row%2==1 ? "row-odd" : 'row-even';
		if($saved==1)
			$class = "row-saved";
		return $class;
	}

	/*
	 * 科目名称
	 * @sbj_id Integer
	 */
	public function getSbjName($id){
		if($id!='')
			return Subjects::model()->getSbjPath($id);
		else
			return '';
	}

	/*
	 * load 加载数据
	 */
	public function load($item){
		$this->setAttribute('target', $item['entry_name']);
		$this->setAttribute('date', $item['entry_date']);
		$this->setAttribute('memo', $item['entry_memo']);
		$this->setAttribute('amount', $item['entry_amount']);
		$this->setAttribute('subject', $item['entry_subject']);
		$this->setAttribute('parent', isset($item['parent'])?$item['parent']:'');
		$this->setAttribute('invoice', isset($item['invoice'])?$item['invoice']:'');
		$this->setAttribute('tax',  isset($item['tax'])?$item['tax']:'');
		$this->setAttribute('updated_at', isset($item['updated_at'])?$item['updated_at']:'');
	}
	public function loadOld($item){
		$this->setAttribute('target', $item['entry_name']);
		$this->setAttribute('memo', $item['entry_memo']);
	}
}
