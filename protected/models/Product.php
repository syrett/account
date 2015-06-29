<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property string $no
 * @property string $order_no
 * @property string $name
 * @property integer $vendor_id
 * @property string $in_date
 * @property double $in_price
 * @property string $out_date
 * @property double $out_price
 * @property string $create_time
 * @property integer $status
 */
class Product extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('no, order_no, name, vendor_id, in_date, in_price, create_time, status', 'required'),
			array('vendor_id, status', 'numerical', 'integerOnly'=>true),
			array('in_price, out_price', 'numerical'),
			array('no, order_no', 'length', 'max'=>16),
			array('name', 'length', 'max'=>512),
			array('out_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, no, order_no, name, vendor_id, in_date, in_price, out_date, out_price, create_time, status', 'safe', 'on'=>'search'),
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
			'no' => '编号',
			'order_no' => '订单号',
			'name' => '名字',
			'vendor_id' => '供应商',
			'in_date' => '日期',
			'in_price' => '价格',
			'out_date' => 'Out Date',
			'out_price' => 'Out Price',
			'create_time' => 'Create Time',
			'status' => 'Status',
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
		$criteria->compare('no',$this->no,true);
		$criteria->compare('order_no',$this->order_no,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('vendor_id',$this->vendor_id);
		$criteria->compare('in_date',$this->in_date,true);
		$criteria->compare('in_price',$this->in_price);
		$criteria->compare('out_date',$this->out_date,true);
		$criteria->compare('out_price',$this->out_price);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
