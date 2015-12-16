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
class Stock extends LFSModel
{
    public $total;
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
            array('name, in_date, in_price', 'required'),
            array('vendor_id, department_id, client_id', 'numerical', 'integerOnly' => true),
            array('in_price, out_price, value_month, value_rate', 'numerical'),
            array('order_no', 'length', 'max' => 16),
            array('name', 'length', 'max' => 512),
            array('out_date, model, entry_subject, value_month, value_rate, cost_date, worth', 'safe'),
            // The following rule is used by search().
            array('id, hs_no, order_no, name, vendor_id, in_date, in_price, out_date, out_price, create_time, status', 'safe', 'on' => 'search'),
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
            'id' => '编号',
            'hs_no' => '资产编号',
            'order_no' => '订单号',
            'name' => '名称',
            'model' => '型号',
            'entry_subject' => '种类',
            'vendor_id' => '供应商',
            'client_id' => '客户',
            'department_id' => '部门',
            'in_date' => '采购日期',
            'in_price' => '单价',
            'out_date' => '出库日期',
            'out_price' => '出库价格',
            'worth' => '净值',
            'create_time' => '添加时间',
            'value_month' => '折旧月份',
            'value_rate' => '残值率(%)',
            'status' => '状态',
        );
    }

    /*
     * search by options
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
        if(isset($options['entry_subject']))
            $sbj = $options['entry_subject'];
        else
            $sbj = '1405';
        $where .= " and entry_subject like '$sbj%'";
        if (isset($options['id']) && isset($options['name'])) {
            $stock = $this->findByPk($options['id']);
            if($action == 'order')
                $where .= " and order_no = '$stock->order_no'";
            else
                $where .= " and name = '$stock->name'";
            $groupby = " group by order_no";
            $year = date('Y').'0101';
            $sql = "select *, count(if(status=1 and in_date<'$year',1,NULL)) `before`, count(if(in_date>='$year',1,NULL)) `count`,count(if(status=2,1,NULL)) `out`,count(if(status=1,1,NULL)) `left` from $tablename $where $groupby";
        } elseif (isset($options['action'])) {
            if($options['action']=='order'){
                $groupby = " group by order_no";
                $sql = "select `id`,`order_no`,group_concat(distinct name) name, count(`id`) amount, sum(`in_price`) summary from $tablename $groupby";
            }
        } else {
            $time = date("Ym").'01';
            $groupby = " group by name";
            $month_in = " sum(if(`in_date`>='$time',1,0)) `month_in`";
            $month_out = "sum(if(`status`=2 and `out_date` >= '$time',1,0)) `month_out`";
            $left = "sum(if(`status`=1,1,0)) `left`";
            $year = date('Y').'0101';
            $year_before = "sum(if(`status`=1 and `in_date` < '$year',1,0)) `year_before`";
            $sql = "select `id`,`hs_no`, name, $year_before, $month_in, $month_out, $left from $tablename $where $groupby";
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
    public function search($type='')
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('hs_no', $this->hs_no, true);
        $criteria->compare('order_no', $this->order_no, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('model', $this->model, true);
        $criteria->compare('vendor_id', $this->vendor_id);
        $criteria->compare('in_date', $this->in_date, true);
        $criteria->compare('in_price', $this->in_price);
        $criteria->compare('out_date', $this->out_date, true);
        $criteria->compare('out_price', $this->out_price);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function search3($type='')
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('hs_no', $this->hs_no, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('model', $this->model, true);
        $criteria->compare('vendor_id', $this->vendor_id);
        $criteria->compare('in_date', $this->in_date, true);
        $criteria->compare('in_price', $this->in_price);
        $criteria->compare('out_date', $this->out_date, true);
        $criteria->compare('out_price', $this->out_price);
        switch($type){
            case '1601' :
                $criteria->addCondition("entry_subject like '1601%' or entry_subject like '1701%' or entry_subject like '1801%'");
                break;
            case '1405' :
                $criteria->addCondition("entry_subject like '1403%' or entry_subject like '1405%' ");
                break;
            default:
                break;
        }
        $criteria->addCondition("order_no is NULL");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /*
     * get number of stock
     *
     */
    public function getNumber($options){
        if(!isset($options['entry_subject']))
            $sbj = '1405';
        else
            $sbj = $options['entry_subject'];
        if(isset($options['id'])&&$options['id']!='')
            $model = $this->findByPk($options['id']);
        else
            return 0;
        if($model != null){
            $where = "1=1 and name='$model->name' and entry_subject like '$sbj%'";
            if(isset($options['status']))
                $where .= " and status=".$options['status'];
            if(isset($options['date']) && $options['date']=='year'){
                $date = strtotime(date("Y"). '-01-01 00:00:01');
            }
            else{
                $date = strtotime(date("Y-m"). '-01 00:00:01');
            }
            $action = isset($options['type']) && $options['type'] == 'before'?'<':'>';
            $time = date("Y-m-d H:i:s", $date);
            $models = $this->findAll($where. " and in_date $action '$time'");
            return count($models);
        }else
            return 0;
    }

    public function getStockArray($sbj = ''){
        $where = $sbj!=''?"and entry_subject like '$sbj%'":"";
        $data = self::model()->findAll(" 1=1 $where group by name");
        $arr = [];
        foreach($data as $row){
            $arr[$row['name']] = $row["name"];
        }
        return $arr;
    }

    /*
     * 成本结转
     */
    public function getStockArray2($sbj=''){
        if(is_array($sbj)){
            foreach ($sbj as $item) {
                if(isset($where))
                    $where .= " or entry_subject like '$item%'";
                else
                    $where = " entry_subject like '$item%'";
            }

        }elseif($sbj!=''){
            $where = " 1=1 and entry_subject like '$sbj%'";
        }
        $data = self::model()->findAll(" ($where) and cost_date = '' group by concat(name, model)");
        return $data;
    }

    public function load($item, $type='purchase'){
        if($type=='purchase'){
            $this->setAttribute('order_no', $item['order_no']);
            $this->setAttribute('name', $item['entry_name']);
            if(isset($item['model'])&&$item['model']!='')
                $this->setAttribute('model', $item['model']);
            if(isset($item['vendor_id'])&&$item['vendor_id']!='')
                $this->setAttribute('vendor_id', $item['vendor_id']);
            if(isset($item['department_id'])&&$item['department_id']!='')
                $this->setAttribute('department_id', $item['department_id']);
            $this->setAttribute('entry_subject', $item['entry_subject']);
            $this->setAttribute('in_date', $item['entry_date']);
            $this->setAttribute('in_price', $item['price']);
            $this->setAttribute('status', $item['status_id']);
            //采购固定资产，无形资产，长期待摊费用，需要保存残值率和摊销年限
            $sbj = $item['entry_subject'];
            while(strlen($sbj)>=4){
                $option = Options::model()->findByAttributes(['entry_subject'=>$sbj]);
                if($option){
                    $this->value_month = $option['year']*12;
                    $this->value_rate = $option['value'];
                    break;
                }

                $sbj = substr($sbj,0,-2);
            }
        }elseif($type=='product'){
            $this->setAttribute('order_no', $item['order_no']);
            $this->setAttribute('order_no_sale', $item['order_no']);
            $this->setAttribute('name', $item['entry_name']);
            if(isset($item['client_id'])&&$item['client_id']!='')
                $this->setAttribute('client_id', $item['client_id']);
            $this->setAttribute('out_date', $item['entry_date']);
            $this->setAttribute('subject', $item['entry_subject']);
            $this->setAttribute('status', $item['status_id']);
        }
    }

    public function delStock($count=0){
        $this->delMultiple(['order_no' => $this->order_no, 'status' => 1, 'name' => $this->name], $count);
    }

    public function setStock($count, $status, $options=[]){
        $c = new CDbCriteria;
        $c->condition="status<>$status and name='$this->name'";
        if(!empty($options)){
            foreach($options as $key => $item){
                $c->condition .= " and $key='$item'";
            }
        }
        $c->limit = $count;
        $c->order = $status==1?'id desc':'id asc';
        $a = $this->entry_subject?['entry_subject'=>$this->entry_subject]:[];
        $a += [
            'client_id'=>$this->client_id,
            'out_price'=>$this->out_price,
            'out_date'=>$this->out_date,
            'order_no_sale'=>$this->order_no_sale,
            'status'=>$status,
        ];
        return $this->updateAll($a,$c);
    }
    public function saveMultiple($count){
        $result = false;
        $stock = [
            'entry_subject'=>$this->entry_subject,
            'order_no'=>$this->order_no,
            'name'  =>  $this->name,
            'model'  =>  $this->model,
            'vendor_id'  =>  $this->vendor_id,
            'client_id'  =>  $this->client_id,
            'department_id'  =>  $this->department_id,
            'in_date'  =>  $this->in_date?$this->in_date:Condom::model()->getStartTime().'01',
            'in_price'  =>  str_replace(',','',$this->in_price),
            'worth' => str_replace(',','',$this->worth),
            'value_month'  =>  $this->value_month,
            'value_rate'  =>  $this->value_rate,
        ];
        while($count-->0){
            $model = new Stock();
            $model->attributes = $stock;
            $model->hs_no = $this->initHSno($this->entry_subject);
            if($model->save())
                $result = true;
            else
                $result = false;
        }
        return $result;
//            array_push($data, $stock);
//        $builder=Yii::app()->db->schema->commandBuilder;
//        $command=$builder->createMultipleInsertCommand($this->tableName(), $data);
//        $command->execute();
    }

    public function matchName($name){
        $stock = $this->findByAttributes([],['condition'=>'name like "%'.$name.'%"']);
        if($stock!=null)
            return $stock->name;
        else
            return $name;
    }

    public function getCount($params){
        $models = $this->findAllByAttributes($params);
        return $models!=null?count($models):0;
    }

    public function form($type){
        if($type=='purchase')
        $result = [
//            'hs_no'=>$this->hs_no,
            'order_no'=>$this->order_no,
            'vendor_id'=>$this->vendor_id,
            'entry_subject'=>$this->entry_subject,
            'name'=>$this->name,
            'model'=>$this->model,
            'in_price'=>$this->in_price,
            'in_date'=>$this->in_date,
            'status'=>$this->status
        ];
        if($type=='product')
            $result = [
                'order_no_sale'=>$this->order_no,
                'client_id'=>$this->client_id,
                'out_price'=>$this->out_price,
                'out_date'=>$this->out_date,
                'status'=>$this->status
            ];
        return $result;
    }

    /*
     * 会计 成本核算方法
     * 加权平均单价＝（期初结存商品金额＋本期收入商品金额－本期非销售付出商品金额）／（期初结存商品数量＋本期收入商品数量－本期非销售付出商品数量）
     * 商品销售成本＝本期商品销售数量×加权平均单价
     */
    public function getPrice($name){
        $amount1 = $this->getAmount([
            'name'=>$name,
            'status'=>1,
//            'type'=>'between',
            'sdate'=> date("Ym01",strtotime("-1 month")),
            'edate'=> date("Ym01")]);
//        $amount2 = $this->getAmount([
//            'name'=>$name,
//            'status'=>1,
//            'type'=>'after',
//            'sdate'=> date("Ym01",strtotime("-1 month")),
//            'edate'=> date("Ym01")]);
        return sprintf("%.2f", $amount1);

    }


    protected function getAmount($options){
        $sql = 'select sum(in_price) amount, count(*) `count` from '. $this->tableName();
        $where = ' where 1=1';
        if(!empty($options['status']))
            $where .= " and status=". $options['status'];
        if(!empty($options['type'])){
            if($options['type']=='between'){
                $where .= " and in_date >= ".$options['sdate'];
                $where .= " and in_date < ".$options['edate'];
            }
        }
        $where .= " and name = '". $options['name']. "'";
        $sql .= $where;
        $amount = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($amount[0]['amount']))
            return (int)$amount[0]['amount']/(int)$amount[0]['count'];
        else
            return 0;
    }

    public function matchStock($name, $sbj=''){
        $where = "";
        if($sbj!=''){
            $where .= " entry_subject like '$sbj%'";
        }
        $model = $this->findByAttributes(['name'=>$name], ['condition' => $where]);
        if($model!=null)
            return $model;
    }

    /*
     * 商品净值，返回净值，一般是固定资产
     * @id Integer
     */
    public function getWorth($id=''){
        if(!empty($id))
            $model = $this->findByPk($id);
        else
            $model = $this;

        if($model->overPeriod())
            return 0;
        if($model){
            if($model->worth!=''){
                $arr = explode(',', $model['worth']);
                return end($arr);
            }
            else
                return $model->in_price;
        }else
            return false;
    }

    /*
     * 超过折旧年限
     */
    public function overPeriod($date2=''){
        if($date2==''){
            $date2 = Transition::getTransitionDate();
            $date2 = strtotime('+1 month', strtotime($date2));
        }else
            $date2 .= strlen($date2)==6?'01':'';
        $date = $this->in_date;
        $sbj = $this->entry_subject;
        if(substr($sbj,0,4) == '1801'){
            if($this->date_a!='')
                $date = $this->date_a;
            else
                return false;
        }
        $year = 0;
        $option = Options::model()->findByAttributes(['entry_subject'=>$sbj]);
        if($option)
            $year = $option->year;
        $date = strtotime('+'.$year.' year', strtotime($date));
        $now = strtotime($date2);
        if($date<=$now)
            return true;
        else
            return false;
    }

    /*
     * 检查是否需要折旧或摊销
     */
    public function checkDeprec($date){

        if(substr($this->entry_subject,0,4)=='1801')
            $this['in_date'] = $this->date_a;
        if(substr($date,0,6)>substr($this['in_date'],0,6))
            return true;
        return false;
    }
    /*
     * 结账时，保存净值。如果反结账，删除计提折旧
     */
    public function saveWorth($entry_prefix=''){
        $arr = ['1601', '1701', '1801'];
        foreach ($arr as $sbj) {
            $list = Subjects::model()->list_sub($sbj);
            foreach ($list as $item) {
                $subject = $item['sbj_number'];
                $cdb = new CDbCriteria();
                $cdb->condition = "entry_subject like '$subject%'"; //固定资产等
                $stocks = Stock::model()->findAllByAttributes([], $cdb);
                $option = Options::model()->findByAttributes([], "entry_subject like '$subject%'");
                if($option==null)
                    $option = Options::model()->findByAttributes([], "entry_subject like '".substr($subject,0,4)."%'");
                foreach ($stocks as $item) {
                    //1601 1701 当月采购不计提，长期待摊1801，如果设置了data_a日期才开始摊销
                    $year = getYear($entry_prefix);
                    $month = getMon($entry_prefix);
                    $date = mktime(0,0,0,$month+1,1,$year);
                    $date = date('Ymd', $date);
                    //
                    if($item->checkDeprec($date)){
                        $price = $item->getWorth();
                        $worth = $price - $price * (100 - $option->value) / 100 / ($option->year * 12);
                        $arr = explode(',', $item->worth);
                        $arr[] = round2($worth);
                        $item->worth = implode(',', $arr);
                        $item->save();
                    }
                }
            }
        }
    }

    /*
     * 物品起始使用日期
     */
    public function getEnableDate(){

    }

    public static function getSheetData($type, $items){
        $model = new Stock();
        $count = 0 ;
        switch($type){
            case '固定资产':    //1601 1701 1801
                if(!empty($items['B'])!=''&&$items['D']!=''&&$items['E']!=''){
                    $model->name = $items['B'];
                    $model->model = $items['C'];
                    $count = intval($items['D']);
                    $model->in_price = $items['E'];
                    $model->worth = $items['E'] - $items['F'];
                    $model->value_month = $items['G'];
                    $model->value_rate = $items['H'];
                    $sbj = Subjects::findSubject(preg_replace('/.*\//','',$items['I']), ['1601','1701','1801']);
                    $model->entry_subject = $sbj?$sbj[0]['sbj_number']:'';
                    $model->department_id = Department::model()->findByAttributes(['name'=>$items['J']]);
                }elseif(isset($items['name'])){
                    $model->attributes = $items;
                    $count = $items['count'];
                }
                break;
            case '库存商品':    //1405 1403
                if(!empty($items['B'])!=''&&$items['D']!=''&&$items['E']!=''){
                    $model->name = $items['B'];
                    $model->model = $items['C'];
                    $count = intval($items['D']);
                    $model->in_price = $items['E'];
                    $sbj = Subjects::findSubject(preg_replace('/.*\//','',$items['F']), ['1403','1405']);
                    $model->entry_subject = $sbj?$sbj[0]['sbj_number']:'';
                }elseif(isset($items['name'])){
                    $model->attributes = $items;
                    $count = $items['count'];
                }
                break;
            default:
                break;

        }
        return ['count'=>$count, $model];
    }

    /*
     * 科目的期初净值
     */
    public function get_balance($sbj){
        $stocks = $this->findAllByAttributes([],"order_no is null and entry_subject like '$sbj%'");
        $balance = 0;
        if(!empty($stocks)){
            foreach ($stocks as $item) {
                $worth = explode(',', $item['worth']);
                $balance += $worth[0]>0?$worth[0]:$item['in_price'];
            }
        }
        return $balance;
    }

    /*
     * 科目期初余额是否相等
     */
    public function check_balance($sbj){
        $sbalance = $this->get_balance($sbj);
        $tbalance = Subjects::get_balance($sbj);
        if((string)$sbalance==(string)$tbalance)
            return true;
        else
            return false;
    }

    /*
     * 某科目下的金额
     */
    public static function getTotal($sbj, $type='worth'){
        $total = 0;
        $stocks = Stock::model()->findAllByAttributes([], "entry_subject like '$sbj%'");
        if($stocks!=null){
            foreach($stocks as $item){
                $total += $type=='worth'?$item->getWorth():$item[$type];
            }
        }
        return $total;
    }

    /*
     * 在建工程是否可以转固
     */
    public function checkTransform(){
        $name = Subjects::getName($this->entry_subject);
        $project = ProjectB::model()->findByAttributes(['name'=>$name]);
        if($project!=null){
            return $project->status==1?true:false;
        }else   //项目已被删除
            return false;
    }
    /*
     * 在长期待摊是否可以完工
     */
    public function checkFinish(){
        $name = Subjects::getName($this->entry_subject);
        $project = ProjectLong::model()->findByAttributes(['name'=>$name]);
        if($project!=null){
            return $project->status==1?true:false;
        }else   //项目已被删除
            return false;
    }

    /*
     * 获取项目状态 ,在建 转固 完工
     */
    public function getPStatus(){
        $sbj = substr($this->entry_subject,0,4);
        $name = Subjects::getName($this->entry_subject);
        if($sbj=='1604')   //在建工程
            $project = ProjectB::model()->findByAttributes(['name'=>$name]);
        elseif($sbj=='1801')    //长期待摊
            $project = ProjectLong::model()->findByAttributes(['name'=>$name]);
        return $project!=null?$project->status:0;

    }
}
