<?php

/**
 * This is the model class for table "vendor".
 *
 * The followings are the available columns in table 'vendor':
 * @property integer $id
 * @property string $vat
 * @property string $phone
 * @property string $add
 * @property string $memo
 */
class Vendor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vendor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company', 'required'),
//			array('phone', 'required'),
            array('company', 'filter', 'filter'=>'trim'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('vat', 'length', 'max'=>45),
			array('phone', 'length', 'max'=>20),
			array('add', 'length', 'max'=>100),
			array('memo', 'length', 'max'=>200),
			// The following rule is used by search().
			array('id, vat, phone, add, memo', 'safe', 'on'=>'search'),
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
			'company' => '供应商',
			'vat' => '税号',
			'phone' => '联系电话',
			'add' => '联系地址',
			'memo' => '备注',
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
        $criteria->compare('company',$this->company,true);
        $criteria->compare('vat',$this->vat,true);
		$criteria->compare('phone',$this->phone,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Vendor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function list_vendors()
    {
      $sql = "SELECT id,company FROM vendor where 1";
      $data = self::model()->findAllBySql($sql);
      foreach($data as $row){
        $arr[] = array("id"=>$row["id"],
                       "company"=>$row["company"]);
      }
      return $arr;
    }

    public function getVendorArray(){
        $data = self::model()->findAll();
        $arr = [];
        foreach($data as $row){
            $arr[$row['id']] = $row["company"];
        }
        return $arr;
    }

    public static function getVendors($name){
        $models = self::model()->findAllByAttributes([], "company like '%$name%'");
        if(!$models)
            $models = self::model()->findAll();
        foreach ($models as $key => $item) {
//            $tran = Product::model()->findByAttributes(['client_id'=>$item['id']]);
//            if($tran)
            $result[$item['company']] = $item['company'];
        }
        return $result;
    }

    public function getName($id){
        if($id=='' || $id == 0)
            return '无效的id';
        else{
            $model = $this->findByPk($id);
            return $model->company;
        }
    }

    public function matchName($company){
        $vendor = $this->findByAttributes([],['condition'=>'company like "%'.$company.'%"']);
        if($vendor!=null)
            return $vendor->id;
        else
            return 0;
    }

    public function getAllMount($options){
        $result = 0;
        $sbj1 = Subjects::model()->findByAttributes(['sbj_name'=>$this->company], 'sbj_number like "2202%"');
        $sbj2 = Subjects::model()->findByAttributes(['sbj_name'=>$this->company], 'sbj_number like "1123%"');
        foreach ([$sbj1, $sbj2] as $sbj) {
            $sbj = $sbj?$sbj->sbj_number:'';
            if(isset($options['type'])&&$options['type']=='before'){
                $balance = Subjects::get_balance($sbj);
                $in = Transition::model()->getAllMount($sbj, 1, $options['type'], $options['date']);
                $out = Transition::model()->getAllMount($sbj, 2, $options['type'], $options['date']);
                $result += $balance + $in-$out;
            }else
                $result += Transition::model()->getAllMount($sbj, $options['entry_transaction'], 'after', '');

        }
        return $result;
    }

    public static function listOrders($name){
        $sbj = Subjects::matchSubject($name,[2202],3,0);
        $orders = Purchase::model()->findAllByAttributes(['subject_2'=>$sbj]);
        //检查订单是否已经支付完成
        foreach ($orders as $item) {
            if(floatval($item['price'])*$item['count']>$item->getPaid())
                $result[] = $item;
        }
        //添加一个预付的预付订单
        $sbj2 = Subjects::matchSubject($name,['1123']);
        $result[] = ['subject_2' => $sbj2, 'order_no' => '预付款'];
        return $result;
    }
}
