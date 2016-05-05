<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property string $order_no
 * @property string $entry_date
 * @property integer $client_id
 * @property string $entry_name
 * @property string $entry_memo
 * @property double $price
 * @property string $unit
 * @property integer $tax
 * @property double $paid
 * @property integer $subject
 * @property sting $subject_2
 * @property string $create_time
 * @property integer $update_time
 * @property integer $status_id
 */
class Product extends LFSModel
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
            array('order_no, entry_date, client_id, entry_name, price, tax', 'required'),
            array('client_id', 'numerical', 'integerOnly' => true),
            array('client_id, tax, count', 'numerical', 'integerOnly' => true),
            array('price, paied', 'numerical'),
            array('entry_name', 'length', 'max' => 512),
            array('realorder', 'length', 'max' => 64),
            // The following rule is used by search().
            array('id, order_no, realorder, entry_date, client_id, entry_name, price, tax, create_time, update_time, status_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
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
            'realorder' => '销售单号',
            'entry_date' => '交易日期',
            'vendor_id' => '客户',
            'entry_name' => '商品名称',
            'price' => '价格',
            'count' => '数量',
            'unit' => '单位',
            'tax' => '税率',
            'paied' => '已收金额',
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
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('order_no', $this->order_no);
        $criteria->compare('realorder', $this->realorder);
        $criteria->compare('entry_date', $this->entry_date);
        $criteria->compare('client_id', $this->client_id);
        $criteria->compare('entry_name', $this->entry_name, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('unit', $this->unit, true);
        $criteria->compare('tax', $this->tax);
        $criteria->compare('paied', $this->paied);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time);
        $criteria->compare('status_id', $this->status_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Product the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /*
     * load 加载数据
     */
    public function load($item)
    {
        $this->setAttributes($item);
        $this->setAttribute('entry_name', $item['entry_name']);
        $this->setAttribute('entry_memo', $item['entry_memo']);
        $this->setAttribute('entry_date', $item['entry_date']);
        $this->setAttribute('realorder', $item['realorder']);
        $this->setAttribute('subject', $item['entry_subject']);
        $this->setAttribute('subject_2', $item['subject_2']);
        $this->setAttribute('tax', isset($item['tax']) ? $item['tax'] : '');
        $this->setAttribute('status_id', $item['status_id']);
//        $this->setAttribute('updated_at', isset($item['updated_at'])?$item['updated_at']:'');
    }

    public function listOrder($order_no = '', $date = '', $name = '', $status = 1)
    {
        $con = ['status_id' => $status];
        $where = ' 1=1 ';
        if (!empty($order_no))
            $con += ['order_no' => $order_no];
        if (!empty($name))
            $con += ['entry_name' => $name];
        if (empty($date))
            $date = date('Y0101');
        $where .= " and entry_date >= $date and subject='600101'";   //成本核算，只列出销售产品的订单
        $models = $this->findAllByAttributes($con, $where);
        return $models;
    }

    /*
     * 订单已收入金额; 检查预收 银行和现金
     */
    public function checkPaid()
    {
        $total = floatval($this->price) * intval($this->count);
        $amount = $this->getPaid();
        if ($amount >= $total)
            return true;
        else
            return false;

    }

    public function getPaid()
    {
        $amount = 0;
        //预收
        $porder = Preparation::model()->findAllByAttributes(['real_order' => $this->order_no, 'status' => 2]);
        if ($porder)
            foreach ($porder as $item) {
                $real_order = json_decode($item->real_order, true);
                $amount += $real_order[$this->order_no];
            }

        //银行
        $porder = Bank::model()->findAllByAttributes(['type' => 'product', 'pid' => $this->id]);
        if ($porder)
            foreach ($porder as $item) {
                $amount += floatval($item->amount);
            }
        //现金
        $porder = Cash::model()->findAllByAttributes(['type' => 'product', 'pid' => $this->id]);
        if ($porder)
            foreach ($porder as $item) {
                $amount += floatval($item->amount);
            }
        return round($amount, 2);
    }

    /*
     * 小规模纳税人 纳税申报表数据
     */
    public static function getTax1_1()
    {
        $data = [];
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'month';
        $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date('Ymt', strtotime("-1 months"));
        //增值税 不包含营业税5%
        $where = ' and sbj_tax <> 5';
        //（一）应征增值税货物及劳务、试点服务不含税销售额      栏次1
        //材料销售，申报时，填在第一行

        // A:货物 包含出口货物
        $sbj = Subjects::model()->findAllByAttributes(['sbj_type' => 0], 'sbj_name like "%材料销售%" and sbj_number like "6051%" and sbj_tax > 0' . $where);
        $sbj2 = Subjects::model()->findAllByAttributes(['sbj_type' => 0], 'sbj_number like "6001%" and sbj_tax > 0 ' . $where);

        $sbj3 = Subjects::model()->findAllByAttributes(['sbj_type' => 2], 'sbj_name like "%材料销售%" and sbj_number like "6051%" and sbj_tax > 0' . $where);
        $sbj4 = Subjects::model()->findAllByAttributes(['sbj_type' => 2], 'sbj_number like "6001%" and sbj_tax > 0 ' . $where);


        $tmp_1 = Product::model()->getTax(array_merge($sbj, $sbj2, $sbj3, $sbj4), $type, $date, 'A');

        // B:服务
        $sbj = Subjects::model()->findAllByAttributes(['sbj_type' => 1], 'sbj_number like "6001%" and sbj_tax > 0 ' . $where);
        $sbj2 = Subjects::model()->findAllByAttributes(['sbj_type' => 3], 'sbj_number like "6001%" and sbj_tax > 0 ' . $where);

        $tmp_2 = Product::model()->getTax(array_merge($sbj, $sbj2), $type, $date, 'B');
        $data[1] = array_merge($tmp_1, $tmp_2);

        //（二）销售使用过的应税固定资产不含税销售额     栏次 4
        $sbj = Subjects::model()->findAllByAttributes([], 'sbj_name like "%固定资产%" and sbj_number like "6051%" and sbj_tax > 0' . $where);
        if (count($sbj) > 0)
            $tmp_1 = Product::model()->getTax($sbj, $type, $date, 'A');
        else {
            $tmp_1['A'] = 0;
            $tmp_1['C'] = 0;
        }
        $data[4] = $tmp_1;

        //（三）免税货物及劳务销售额     栏次6

        // A:货物
        $sbj = Subjects::model()->findAllByAttributes(['sbj_type' => 0, 'sbj_tax' => 0], 'sbj_name like "%材料销售%" and sbj_number like "6051%" ');
        $sbj2 = Subjects::model()->findAllByAttributes(['sbj_type' => 0, 'sbj_tax' => 0], 'sbj_number like "6001%" ');

        $tmp_1 = Product::model()->getTax(array_merge($sbj, $sbj2), $type, $date, 'A');

        // B:服务
        $sbj = Subjects::model()->findAllByAttributes(['sbj_type' => 1, 'sbj_tax' => 0], 'sbj_number like "6001%" ');

        $tmp_2 = Product::model()->getTax($sbj, $type, $date, 'B');
        $data[6] = array_merge($tmp_1, $tmp_2);

        //（四）出口免税货物销售额      栏次8
        // A:货物
        $sbj = Subjects::model()->findAllByAttributes(['sbj_type' => 2, 'sbj_tax' => 0], 'sbj_name like "%材料销售%" and sbj_number like "6051%" ');
        $sbj2 = Subjects::model()->findAllByAttributes(['sbj_type' => 2, 'sbj_tax' => 0], 'sbj_number like "6001%" ');

        $tmp_1 = Product::model()->getTax(array_merge($sbj, $sbj2), $type, $date, 'A');

        // B:服务
        $sbj = Subjects::model()->findAllByAttributes(['sbj_type' => 3, 'sbj_tax' => 0], 'sbj_number like "6001%" ');

        $tmp_2 = Product::model()->getTax($sbj, $type, $date, 'B');
        $data[8] = array_merge($tmp_1, $tmp_2);

        //本期应纳税额    栏次 10
        $data[10]['A'] = ($data[1]['A'] + $data[4]['A']) * 0.03; //小规模纳税人
        $data[10]['B'] = ($data[1]['B']) * 0.03;
        $data[10]['C'] = ($data[1]['C'] + $data[4]['C']) * 0.03;
        $data[10]['D'] = ($data[1]['D']) * 0.03;

        $data[12]['A'] = $data[10]['A'];
        $data[12]['B'] = $data[10]['B'];
        $data[12]['C'] = $data[10]['C'];
        $data[12]['D'] = $data[10]['D'];


        $data[14]['A'] = $data[10]['A'];
        $data[14]['B'] = $data[10]['B'];
        $data[14]['C'] = $data[10]['C'];
        $data[14]['D'] = $data[10]['D'];

        return $data;
    }

    protected function getTax($sbj, $type, $date='', $option = 'A', $model = 'Product', $ext = '')
    {
        $amount = 0;
        if ($option == 'A' || $option == '') {
            $data['A'] = 0;
            $data['C'] = 0;
        } else {
            $data['B'] = 0;
            $data['D'] = 0;
        }
        if (!is_array($sbj))
            $sbj = [$sbj];
        $where = '1=1';
        $date = $date!=='' ? $date : Transition::getCondomDate();
        $format = $model == 'Product' ? 'Ymd' : 'Y-m-d';
        if (count($sbj) > 0) {
            foreach ($sbj as $item) {
                $subject = $model == 'Product' ? 'subject' : 'entry_subject';     //表字段不一样
                if($item->has_sub == 1)
                    $where .= $where == '1=1' ? " and ($subject regexp '^$item->sbj_number.+'" : " or $subject regexp '^$item->sbj_number.+'";
                else
                    $where .= $where == '1=1' ? " and ($subject = '$item->sbj_number'" : " or $subject = '$item->sbj_number'";
            }
            $where .= ')';
            $where .= $ext;
            $where_year = $where . " and entry_date >= '" . date($format, strtotime(substr($date, 0, 4) . "0101")) . "' and entry_date <= '" . date($format, strtotime(substr($date, 0, 4) . "1231")) . "'";
            if (!isset($type) || $type == 'month')    //按月查看
            {
                $where .= " and entry_date >= '" . date($format, strtotime(substr($date, 0, 6) . "01")) . "' and entry_date <= '" . date($format, strtotime(substr($date, 0, 6) . "31")) . "'";
            } elseif ($type == 'quarter')     //按季度查看
            {
                $quarter = getQuarter($date);
                $where .= " and entry_date >= '" . $quarter['start'] . "' and entry_date <= '" . $quarter['end'] . "'";
            }

            if ($model == 'Product')
                $model2 = new Product();
            elseif ($model == 'Transition'){
                $model2 = new Transition();
            }
            $products = $model2->findAllByAttributes([], $where);
            if (count($products)) {
                foreach ($products as $product) {
                    if ($model == 'Product')
                        $amount += $product->price * $product->count;
                    else
                        $amount += $product->entry_amount;
                }
            }
            if ($option == 'A')
                $data['A'] =  sprintf("%.2f", $amount);
            else
                $data['B'] = sprintf("%.2f", $amount);
            //本年累计 货物
            $amount = 0;

            $products = $model2->findAllByAttributes([], $where_year);
            if (count($products)) {
                foreach ($products as $product) {
                    if ($model == 'Product')
                        $amount += $product->price * $product->count;
                    else
                        $amount += $product->entry_amount;
                }
            }

            if ($option == 'A')
                $data['C'] = sprintf("%.2f", $amount);
            else
                $data['D'] = sprintf("%.2f", $amount);
        }
        return $data;
    }

    /*
     * 一般纳税人    纳税申报表数据
     */
    public static function getTax1_a()
    {

        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'month';
        $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date('Ymt', strtotime("-1 months"));
        $data = [];
        //(一)按适用税率征税货物及劳务销售额
        $sbj = Subjects::model()->findAllByAttributes([], '(sbj_number like "6001%" or sbj_number like "6051%" or sbj_number like "6301%") and sbj_tax > 0 and sbj_tax <> 5');
        $data[1] = Product::model()->getTax($sbj, $type, $date);

        //应税货物销售额
        $sbj = Subjects::model()->findAllByAttributes([], '(sbj_number like "6001%" or sbj_number like "6051%" or sbj_number like "6301%") and sbj_tax > 0 and sbj_tax <> 5 and (sbj_type = 0 or sbj_type = 2)');
        $data[2] = Product::model()->getTax($sbj, $type, $date);
        //应税劳务销售额
        $sbj = Subjects::model()->findAllByAttributes([], '(sbj_number like "6001%" or sbj_number like "6051%" or sbj_number like "6301%") and sbj_tax > 0 and sbj_tax <> 5 and (sbj_type = 1 or sbj_type = 3)');
        $data[3] = Product::model()->getTax($sbj, $type, $date);

        //(四)免税货物及劳务销售额     栏次  8
        $sbj = Subjects::model()->findAllByAttributes(['sbj_tax' => 0], '(sbj_number like "6001%" or sbj_number like "6051%" or sbj_number like "6301%")');
        $data[8] = Product::model()->getTax($sbj, $type, $date);

        //免税货物销售额
        $sbj = Subjects::model()->findAllByAttributes(['sbj_tax' => 0], '(sbj_number like "6001%" or sbj_number like "6051%" or sbj_number like "6301%") and (sbj_type = 0 or sbj_type = 2)');
        $data[9] = Product::model()->getTax($sbj, $type, $date);
        //免税劳务销售额
        $sbj = Subjects::model()->findAllByAttributes(['sbj_tax' => 0], '(sbj_number like "6001%" or sbj_number like "6051%" or sbj_number like "6301%") and (sbj_type = 1 or sbj_type = 3)');
        $data[10] = Product::model()->getTax($sbj, $type, $date);

        //销项税额      栏次      11
        $sbjz = Subjects::model()->findByAttributes([], "sbj_name like'%增值税%' and sbj_number regexp '^2221'");
        if ($sbj == null) {
            $data[11] = ['A' => 0, 'C' => 0];
            $data[12] = ['A' => 0, 'C' => 0];

        } else {
            //销项税额      栏次      11
            $sbj = Subjects::model()->findByAttributes([], "sbj_name like '%销%' and sbj_number regexp '^$sbjz->sbj_number'");
            if ($sbj != null)
                $data[11] = Product::model()->getTax([$sbj], $type, $date, 'A', 'Transition', ' and entry_transaction = 1');
            else {
                $data[11] = ['A' => 0, 'C' => 0];
                $data[12] = ['A' => 0, 'C' => 0];
            }
            //进项税额      栏次      12
            $sbj = Subjects::model()->findByAttributes([], "sbj_name like '%进%' and sbj_number regexp '^$sbjz->sbj_number'");
            if ($sbj != null)
                $data[12] = Product::model()->getTax([$sbj], $type, $date, 'A', 'Transition', ' and entry_transaction = 1');
            else {
                $data[11] = ['A' => 0, 'C' => 0];
                $data[12] = ['A' => 0, 'C' => 0];
            }
        }

        //应抵扣税额合计       栏次      17=12+13-14-15+16
        $data[17]['A'] = $data[12]['A'];

        //实际抵扣税额        栏次      18(如17<11,则为17, 否则为11)
        $data[18]['A'] = $data[17]['A']< $data[11]['A']?$data[17]['A']:$data[11]['A'];
        $data[18]['C'] = $data[12]['C'];

        //应纳税额      栏次      19=11-18
        $data[19]['A'] = $data[11]['A'] - $data[18]['A'];
        $data[19]['C'] = $data[11]['C'] - $data[18]['C'];

        //期末留抵税额      栏次      20=17-18
        $data[20]['A'] = $data[17]['A'] - $data[18]['A'];
//        $data[20]['C'] = - $data[18]['C'];

        //应纳税额合计      栏次      24=19+21-23
        $data[24]['A'] = $data[19]['A'];
        $data[24]['C'] = $data[19]['C'];

        //本期缴纳上期应纳税额       栏次       30
        //222101增值税子科目，未交增值税 或
        $sbj = Subjects::model()->findByAttributes(['sbj_name'=>'未交增值税'], 'sbj_number regexp "^222101"');
        if($sbj != null)
            $data[30] = Product::model()->getTax($sbj, $type, $date, 'A', 'Transition', ' and entry_transaction = 1');
        else
            $data[30] = ['A'=>0, 'C'=>0];
        //本期已缴税额    栏次      27=28+29+30+31
        $data[27] = $data[30];

        //期末未缴税额（多缴为负数      栏次      32=24+25+26-27
        $data[32]['A'] = $data[24]['A'] - $data[27]['A'];
        $data[32]['C'] = $data[24]['C'] - $data[27]['C'];

        //其中：欠缴税额（≥0    栏次      33=25+26-27
        $data[33]['A'] = - $data[27]['A'];
        $data[33]['C'] = - $data[27]['C'];

        //本期应补(退)税额     栏次      34=24-28-29
        $data[34]['A'] = $data[24]['A'];
        $data[34]['C'] = $data[24]['C'];

        //期末未缴查补税    栏次       38=16+22+36-37
        $data[38] = ['A'=> 0, 'C'=> 0];

        return $data;
    }

    /*
     * 企业所得税A类
     */
    public function getTax4_a(){
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'month';
        $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date('Ymt', strtotime("-1 months"));
        $data = [];

        //营业收入      2
        $sbj = Subjects::model()->findAllByAttributes([], 'sbj_number regexp "^6001" or sbj_number regexp "^6051"');
        $data[2] = Product::getTax($sbj, $type, $date);

        //营业成本      3
        $sbj = Subjects::model()->findAllByAttributes([], 'sbj_number regexp "^6401" or sbj_number regexp "^6402"');
        $data[3] = Product::getTax($sbj, $type, $date);

        //利润总额，利润总额=利润表中的利润总额。（营业收入-营业成本）不一定等于利润总额      4
        $model = new Profit();
        $model->date = $date;
        $profit = $model->genProfitData();
        $data[4]['A'] = sprintf("%.2f", $profit['net_profit']['sum_month']);
        $data[4]['C'] = sprintf("%.2f", $profit['net_profit']['sum_year']);

        //实际利润额     4行+5行-6行-7行-8行      9
        $data[9] = $data[4];

        //税率        10
        $option = Options::model()->findByAttributes(['entry_subject'=>'6801']);
        if($option != null){
            $data[10]['tax'] = $option['value'];
        }else
            $data[10]['tax'] = '25';

        //应纳所得税额（9行×10行）        11
        $data[11]['A'] = $data[9]['A'] * $data[10]['tax'] / 100;
        $data[11]['C'] = $data[9]['C'] * $data[10]['tax'] / 100;

        // 实际已预缴所得税额        13
        $sbj = Subjects::model()->findByAttributes([], 'sbj_number regexp "^2221" and sbj_name like "%企业所得税%"');
        if($sbj)
            $data[13] = Product::getTax($sbj, $type, $date, '','Transition');
        else
            $data[13] = ['A'=>0, 'C'=>0];

        //应补（退）所得税额（11行-12行-13行-14行）        15
        $data[15]['C'] = $data[11]['C'] - $data[13]['C'];

        //第17行“本月（季）实际应补（退）所得税额”：根据相关行次计算填报。第17行“累计金额”列=15行-16行，且第17行≤0时，填0，“本期金额”列不填       17
        $data[17]['C'] = $data[15]['C'];
        if($data[17]['C'] <= 0)
            $data[17]['C'] = 0;

        //本月（季）应纳税所得额（19行×1/4或1/12）         20
        $data[20]['A'] = 0;
        $data[20]['C'] = 0;

        //税率        21
        if($option != null){
            $data[21]['tax'] = $option['value'];
        }else
            $data[21]['tax'] = '25';

        //本月（季）应纳所得税额（20行×21行）      22
        $data[22]['A'] = 0;
        $data[22]['C'] = 0;

        //本月（季）实际应纳所得税税额 （22行-23行）       24
        $data[24]['A'] = 0;
        $data[24]['C'] = 0;


        return $data;
    }
    /*
     * 企业所得税B类
     */
    public function getTax4_b(){

        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'month';
        $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date('Ymt', strtotime("-1 months"));
        $data = [];
        //收入总额      1

        $bank = new Bank();
        $cash = new Cash();
        $data[1]['A'] = $bank->getAmount('收入', $type, $date, ['利息收入', '材料销售', '技术转让', '资产租赁'], false);
        $data[1]['A'] += $cash->getAmount('收入', $type, $date, ['利息收入', '材料销售', '技术转让', '资产租赁'], false);

        $sbj = Subjects::model()->findAllByAttributes([], 'sbj_number regexp "^6001" or sbj_number regexp "^6051" or sbj_number regexp "^6301"');
        $temp = Product::getTax($sbj, $type, $date);
        $data[1]['A'] += $temp['A'];


        //第8行“其他免税收入”:填报国家税务总局发布的最新减免项目名称及减免性质代码。       8
        $data[8] = Product::getTax($sbj, $type, $date, 'A', 'Product', ' and tax=0');
        //第3行“免税收入”：填报纳税人计入利润总额但属于税收规定免税的收入或收益。第3行填报4行+5行+6行+7行+8行的合计数。     3
        $data[3] = $data[8];

        //应税收入额（1行-2行-3行）       9
        $data[9]['A'] = $data[1]['A'] - $data[3]['A'];

        //税务机关核定的应税所得率（%）      10
        $option = Options::model()->findByAttributes(['entry_subject'=>'6801']);
        $data[10]['tax'] = $option['year'];

        //应纳税所得额（9行×10行）        11
        $data[11]['A'] = $data[9]['A'] * $option['year'] / 100;

        //成本费用总额 成本费用总额=营业成本+营业税金及附加+营业费用+管理费用+财务费用        12
        $sbj = [];
        $sbj[] = Subjects::model()->findByAttributes(['sbj_number' => 6401]);
        $sbj[] = Subjects::model()->findByAttributes(['sbj_number' => 6403]);
        $sbj[] = Subjects::model()->findByAttributes(['sbj_number' => 6602]);
        $sbj[] = Subjects::model()->findByAttributes(['sbj_number' => 6603]);

        $data[12] = Product::getTax($sbj, $type, $date, 'A', 'Transition', ' and entry_transaction = 1');

        //税务机关核定的应税所得率（%）       13
        $data[13]['tax'] = $option['year'];

        //应纳税所得额[12行÷(100%－13行)×13行]        14
        $data[14]['A'] = sprintf("%.2f", $data[12]['A']/(100-$option['year']) * $option['year']);

        //税率（25%）       15
        $data[15]['tax'] = $option['value'];

        //应纳所得税额（11行×15行或14行×15行）       16
        $data[16]['A'] = $data[11]['A'] * $option['value'] / 100;
        $data[16]['C'] = $data[14]['A'] * $option['value'] / 100;

        //应补（退）所得税额（16行-17行-19行）    20
        $data[20] = $data[16];


        $option = Options::model()->findByAttributes(['entry_subject'=>'6801']);
        if($option != null){
            $data[15]['tax'] = $option['value'];
        }else
            $data[15]['tax'] = '25';

        return $data;
    }
}
