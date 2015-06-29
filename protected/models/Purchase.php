<?php

/**
 * This is the model class for table "purchase".
 *
 * The followings are the available columns in table 'purchase':
 * @property integer $id
 * @property integer $order_no
 * @property integer $purchase_date
 * @property integer $vendor_id
 * @property string $commodity
 * @property double $price
 * @property string $unit
 * @property integer $tax
 * @property double $paied
 * @property string $create_time
 * @property integer $update_time
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Vendor $vendor
 */
class Purchase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'purchase';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_no, purchase_date, vendor_id, commodity, price, tax', 'required'),
			array('vendor_id, tax, count', 'numerical', 'integerOnly'=>true),
			array('price, paied', 'numerical'),
			array('commodity', 'length', 'max'=>512),
			// The following rule is used by search().
			array('id, order_no, purchase_date, vendor_id, commodity, price, tax, create_time, update_time, status_id', 'safe', 'on'=>'search'),
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
			'vendor' => array(self::BELONGS_TO, 'Vendor', 'vendor_id'),
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
			'purchase_date' => '采购日期',
			'vendor_id' => '供应商ID',
			'commodity' => '商品名称',
            'price' => '价格',
            'count' => '数量',
			'unit' => '单位',
			'tax' => '税率',
			'paied' => '已付金额',
			'create_time' => '创建日期',
			'update_time' => '更新日期',
			'status_id' => '状态',
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
		$criteria->compare('order_no',$this->order_no);
		$criteria->compare('purchase_date',$this->purchase_date);
		$criteria->compare('vendor_id',$this->vendor_id);
		$criteria->compare('commodity',$this->commodity,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('unit',$this->unit,true);
		$criteria->compare('tax',$this->tax);
		$criteria->compare('paied',$this->paied);
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
	 * @return Purchase the static model class
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
        $this->setAttribute('commodity', $item['entry_name']);
        $this->setAttribute('entry_memo', $item['entry_memo']);
        $this->setAttribute('purchase_date', $item['entry_date']);
        $this->setAttribute('subject', $item['entry_subject']);
        $this->setAttribute('subject_2', $item['subject_2']);
        $this->setAttribute('tax',  isset($item['tax'])?$item['tax']:'');
//        $this->setAttribute('updated_at', isset($item['updated_at'])?$item['updated_at']:'');
    }

    /*
     * init order no
     */
    public function initOrderno(){
        $table = $this->tableName();
        $prefix = date('Ym');
        $sql = "select max(order_no) order_no from $table where order_no like 'PO$prefix%' ";
        $model = $this->findBySql($sql);
        if($model!=null){
            $orderno = substr($model->order_no,8);
            $orderno = (int) $orderno + 1;
            $orderno = addZero($orderno);
            return "PO$prefix$orderno";
        }else
            return "PO$prefix"."0001";
    }
}
