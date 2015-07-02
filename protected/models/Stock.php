<?php

/**
 * This is the model class for table "stock".
 *
 * The followings are the available columns in table 'stock':
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
 *
 * The followings are the available model relations:
 * @property Vendor $vendor
 */
class Stock extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Stock the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'stock';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('no, order_no, name, in_date, in_price, create_time, status', 'required'),
            array('vendor_id, status', 'numerical', 'integerOnly' => true),
            array('in_price, out_price', 'numerical'),
            array('no', 'length', 'max' => 64),
            array('order_no', 'length', 'max' => 16),
            array('name', 'length', 'max' => 512),
            array('out_date', 'safe'),
            // The following rule is used by search().
            array('id, no, order_no, name, vendor_id, in_date, in_price, out_date, out_price, create_time, status', 'safe', 'on' => 'search'),
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
            'no' => '编号',
            'order_no' => '订单号',
            'name' => '名字',
            'vendor_id' => '供应商',
            'in_date' => '入库日期',
            'in_price' => '价格',
            'out_date' => '出库日期',
            'out_price' => '出库价格',
            'create_time' => '添加时间',
            'status' => '状态',
        );
    }

    /*
     * search by name
     */
    public function search2($options = [])
    {
        $sql = $this->buildSql($options);
        $rawData = Yii::app()->db->createCommand($sql);
        $count = Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $sql . ') as count_alias')->queryScalar();
//the count
        $model = new CSqlDataProvider($rawData, array(
            'totalItemCount' => $count,
            'sort' => array(),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
        return $model;
    }

    /*
     * $options Array id,name,action
     *
     * @return String sql语句
     */
    protected function buildSql($options)
    {
        $where = " where 1=1 ";
        $tablename = $this->tableName();
        $action = isset($options['action'])?$options['action']:'';
        if (isset($options['id']) && isset($options['name'])) {
            $stock = $this->findByPk($options['id']);
            if($action == 'order')
                $where .= " and order_no = '$stock->order_no'";
            else
                $where .= " and name = '$stock->name'";
            $sql = "select * from $tablename" . $where;
        } elseif (isset($options['action'])) {
            if($options['action']=='order'){
                $groupby = " group by order_no";
                $sql = "select `id`,`order_no`,group_concat(distinct name) name, count(`id`) amount, sum(`in_price`) summary from $tablename $groupby";
            }
        } else {
            $groupby = " group by name";
            $sql = "select `id`,`no`, name, count(`name`) as mount ,sum(if(`status`=1,1,0)) `left` from $tablename" . $where . $groupby;
        }
        return $sql;
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
        //select `no`, name, count(`name`) as mount ,sum(if(`status`=1,1,0)) `left` from stock group by name
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('no', $this->no, true);
        $criteria->compare('order_no', $this->order_no, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('vendor_id', $this->vendor_id);
        $criteria->compare('in_date', $this->in_date, true);
        $criteria->compare('in_price', $this->in_price);
        $criteria->compare('out_date', $this->out_date, true);
        $criteria->compare('out_price', $this->out_price);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /*
     * get number of stock
     *
     */
    public function getAmount($options){
        if(isset($options['id'])&&$options['id']!='')
            $model = $this->findByPk($options['id']);
        else
            return 0;
        if($model != null){
            $date = strtotime(date("Y"). '-01-01 00:00:01');
            $time = date("Y-m-d H:i:s", $date);
            $where = '1=1 and name="'. $model->name. '"';
            if(isset($options['status']))
                $where .= " and status=".$options['status'];
            if(isset($options['type'])&&$options['type']=='before'){
                $models = $this->findAll($where. " and in_date < '$time'");
            }
            else
                $models = $this->findAll($where. " and in_date > '$time'");
            return count($models);
        }else
            return 0;
    }

    public function getStockArray(){
        $data = self::model()->findAll(' 1=1 group by name');
        $arr = [];
        foreach($data as $row){
            $arr[$row['name']] = $row["name"];
        }
        return $arr;
    }

    public function load($item){
//        $this->setAttribute('no', $item['no']);
        $this->setAttribute('order_no', $item['order_no']);
        $this->setAttribute('name', $item['entry_name']);
        $this->setAttribute('vendor_id', $item['vendor_id']);
        $this->setAttribute('in_date', $item['entry_date']);
        $this->setAttribute('in_price', $item['price']);
    }

    public function delStock(){
        $this->deleteAll('order_no=:order_no', [':order_no' => $this->order_no]);
    }

    public function saveMultiple($count){
        $stock = [
            'order_no'=>$this->order_no,
            'name'  =>  $this->name,
            'vendor_id'  =>  $this->vendor_id,
            'in_date'  =>  $this->in_date,
            'in_price'  =>  $this->in_price,
        ];
        $data = [];
        while($count-->0)
            array_push($data, $stock);
        $builder=Yii::app()->db->schema->commandBuilder;
        $command=$builder->createMultipleInsertCommand($this->tableName(), $data);
        $command->execute();
    }

    public function matchName($name){
        $stock = $this->findByAttributes([],['condition'=>'name like "%'.$name.'%"']);
        if($stock!=null)
            return $stock->name;
        else
            return $name;
    }
}
