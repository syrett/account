<?php

/**
 * This is the model class for table "preparation".
 *
 * The followings are the available columns in table 'preparation':
 * @property integer $id
 * @property string $order_no
 * @property string $real_order
 * @property string $pid
 * @property string $type
 * @property string $entry_amount
 * @property string $memo
 * @property string $create_time
 * @property integer $status
 */
class Preparation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'preparation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_no', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('order_no', 'length', 'max'=>64),
            array('entry_amount', 'type', 'type'=>'float'),
			array('memo, real_order', 'safe'),
			// The following rule is used by search().
			array('id, order_no, memo, create_time, status', 'safe', 'on'=>'search'),
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
			'order_no' => 'Order No',
            'real_order' => '订单',
            'pid' => 'PID',
            'type' => '类型',
            'entry_amount' => '金额',
			'memo' => 'Memo',
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
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
        $criteria->compare('order_no',$this->order_no,true);
        $criteria->compare('real_order',$this->real_order,true);
        $criteria->compare('pid',$this->pid,true);
        $criteria->compare('type',$this->type,true);
        $criteria->compare('entry_amount',$this->entry_amount,true);
		$criteria->compare('memo',$this->memo,true);
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
	 * @return Preparation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function initOrder($type){
        $table = $this->tableName();
        switch($type){
            case 'bank': $prefix = 'PBA';break;
            case 'cash': $prefix = 'PCA';break;
            case 'purchase': $prefix = 'PPO';break;
            case 'product': $prefix = 'PSO';break;
            case 'cost': $prefix = 'PCO';break;
            case 'salary': $prefix = 'PSA';break;
            case 'reimburse': $prefix = 'PRE';break;
            default :
                $prefix = '';break;
        }
        $prefix .= date('Ym');
        $sql = "select max(order_no) order_no from $table where order_no like '$prefix%' ";
        $model = $this->findBySql($sql);
        if($model!=null){
            $orderno = substr($model->order_no,9);
            $orderno = (int) $orderno + 1;
            $orderno = addZero($orderno);
            return "$prefix$orderno";
        }else
            return "$prefix"."0001";
    }

    /*
     * 返回可用预支付的订单
     */
    public static function getOrderArray($type, $id=''){
        if($id!=''){
            if($type == 'product')
                $pro = Product::model()->findByPk($id);
            elseif($type == 'purchase')
                $pro = Purchase::model()->findByPk($id);
            elseif($type == 'reimburse')
                $pro = Reimburse::model()->findByPk($id);

            if($pro){
                $orders = self::model()->findAllByAttributes([],"real_order like '%$pro->order_no%' ");
                foreach ($orders as $key => $order) {
                    $real_order = json_decode($order->real_order, true);
                    if($real_order[$pro->order_no] <= 0)
                        unset($orders[$key]);
                }

            }

        }else
            $orders = self::model()->getOrder($type);
        $result = [];
        if(!empty($orders)){
            foreach ($orders as $item) {
                if($item['type'] == 'bank')
                    $order = Bank::model()->findByPk($item['pid']);
                elseif($item['type'] == 'cash')
                    $order = Cash::model()->findByPk($item['pid']);
                $left = $item->entry_amount - $item->amount_used;
                if($order)
                $result[$item['order_no']] = "{\"date\":\"". convertDate($order->date, "Y年m月d日")
                    . "\",\"amount\":\"". $left
                    . "\",\"memo\":\"". $order->memo. "\"}";

            }
        }
        return $result;
    }

    public static function getPreOrder($type, $id){

        $result = [];
        switch($type){
            case 'vendor':
                $model = Vendor::model()->findByPk($id);
                $name = $model?$model->company:'';
                break;
            case 'client':
                $model = Client::model()->findByPk($id);
                $name = $model?$model->company:'';
                break;
            case 'employee':
                $model = Employee::model()->findByPk($id);
                $name = $model?$model->name:'';
                break;
        }
        $bank = Bank::model()->findAllByAttributes([],"path like '%=>$name=>%' and (path like '%预收款%' or path like '%预付款%' or path like '%预支款%')");
        $cash = Cash::model()->findAllByAttributes([],"path like '%=>$name=>%' and (path like '%预收款%' or path like '%预付款%' or path like '%预支款%')");
        foreach ($bank as $item) {
            $porder = Preparation::model()->findByAttributes(['type'=>'bank','pid'=>$item->id]);
            if($porder){
                $left = $porder->entry_amount - $porder->amount_used;
                if($left > 0)
                    $result[$porder['order_no']] = "{\"date\":\"". convertDate($item->date, "Y年m月d日")
                        . "\",\"amount\":\"". $left
                        . "\",\"memo\":\"". $item->memo. "\"}";

            }
        }
        foreach ($cash as $item) {
            $porder = Preparation::model()->findByAttributes(['type'=>'bank','pid'=>$item->id]);
            if($porder){
                $left = $porder->entry_amount - $porder->amount_used;
                if($left > 0)
                    $result[$porder['order_no']] = "{\"date\":\"". convertDate($item->date, "Y年m月d日")
                        . "\",\"amount\":\"". $left
                        . "\",\"memo\":\"". $item->memo. "\"}";

            }
        }
        return $result;
    }

    public function getOrder($type){
        switch($type){
            case 'bank': $prefix = 'PBA';break;
            case 'cash': $prefix = 'PCA';break;
            case 'purchase': $prefix = 'PPO';break;
            case 'product': $prefix = 'PSO';break;
            case 'cost': $prefix = 'PCO';break;
            case 'salary': $prefix = 'PSA';break;
            case 'reimburse': $prefix = 'PRE';break;
            default :
                $prefix = '';break;
        }
        $model = self::findAllByAttributes([], "order_no like '$prefix%' and amount_used < entry_amount ");
        return !empty($model)?$model:[];
    }

    /*
     * 去除$order_no对应的金额
     */
    public function removeAmount($order_no){
        $orders = $this->findAllByAttributes([], "real_order like '%$order_no%'");
        if(!empty($orders))
            foreach ($orders as $item) {
                $real_order = json_decode($item['real_order']);
                unset($real_order[$order_no]);
                $item['real_order'] = json_encode($real_order);
                $item->save();
            }
    }

    /*
     * 根据$order_no，获得对应的金额
     */
    public function getAmount($order_no){
        $real_order = json_decode($this->real_order, true );
        return isset($real_order[$order_no])?$real_order[$order_no]:0;
    }
}
