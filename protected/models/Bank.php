<?php

/**
 * This is the model class for table "lfs_bank".
 *
 * The followings are the available columns in table 'lfs_bank':
 * @property integer $id
 * @property string $order_no
 * @property string $target
 * @property string $date
 * @property string $memo
 * @property double $amount
 * @property integer $parent
 * @property string $subject
 * @property integer $invoice
 * @property integer $tax
 * @property string $path
 * @property integer $status_id
 * @property string $created_at
 * @property integer $updated_at
 */
class Bank extends LFSModel
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
			array('memo, type, pid, order_no, created_at, tax, path, relation', 'safe'),
            array('amount', 'checkAmount'),
			// The following rule is used by search().
			array('id, target, date, memo, amount, parent, order_no, invoice, tax, status_id, created_at, updated_at', 'safe', 'on'=>'search'),
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
            'order_no' => '订单号',
			'target' => '交易对象',
			'date' => '日期',
			'memo' => '说明',
			'amount' => '金额',
			'parent' => '父ID',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('target',$this->target,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('memo',$this->memo,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('parent',$this->parent);
		$criteria->compare('order_no',$this->order_no,true);
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
//		$class = $row%2==1 ? "row-odd" : 'row-even';
//		if($saved==1)
			$class = "row-odd";
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
        $this->setAttribute('order_no', $item['order_no']);
		$this->setAttribute('date', $item['entry_date']);
		$this->setAttribute('memo', $item['entry_memo']);
		$this->setAttribute('amount', $item['entry_amount']);
        $this->setAttribute('subject', $item['entry_subject']);
        $this->setAttribute('subject_2', $item['subject_2']);
		$this->setAttribute('parent', isset($item['parent'])?$item['parent']:'');
		$this->setAttribute('invoice', isset($item['invoice'])?$item['invoice']:'');
        $this->setAttribute('tax',  isset($item['tax'])?$item['tax']:'');
        $this->setAttribute('path',  isset($item['path'])?$item['path']:'');
        $this->setAttribute('relation',  isset($item['relation'])?$item['relation']:'');
		$this->setAttribute('updated_at', isset($item['updated_at'])?$item['updated_at']:'');
	}
	public function loadOld($item){
		$this->setAttribute('target', $item['entry_name']);
		$this->setAttribute('memo', $item['entry_memo']);
	}
    private static function getPay()
    {
        return [
            '工资社保' => '工资社保',     // 1
            '支付押金' => '支付押金',   //  2
            '借出款项' => '借出款项',
            '归还借款' => '归还借款',
            '供应商采购' => '供应商采购',        //  3
            '员工报销' => '员工报销',         //  4
            '投资支出' => '投资支出',         //  5
            '利息手续费' => '利息手续费',          //  6
            '材料销售' => '材料销售',           //  7
            '技术转让' => '技术转让',
            '资产租赁' => '资产租赁',
            '支付股利' => '支付股利',         //  8
            '支付税金' => '支付税金',
            '现金提取' => '现金提取',
            '银行转账' => '银行转账',
            '其他支出' => '其他支出',     //  9
        ];
    }

    private static function getIncome()
    {
        return [
            '股东投入' => '股东投入',         // 1
            '收到押金' => '收到押金',       //  2
            '收到借款' => '收到借款',        //  3
            '收到还款' => '收到还款',         //  4
            '销售收入' => '销售收入',        //  3
            '投资收益' => '投资收益',         //  4
            '利息收入' => '利息收入',         //  5
            '材料销售' => '材料销售',           //  6
            '技术转让' => '技术转让',
            '资产租赁' => '资产租赁',
            '银行转账' => '银行转账',
            '存入现金' => '存入现金',
            '其他收入' => '其他收入',           //  7
        ];
    }

    private static function getSalary()
    {
        return [
            'data' => [
                '工资与奖金' => '工资与奖金',
                '社保公积金' => '社保公积金'
            ]
        ];
    }

    private static function getPremium()
    {
        return [
            'data' => [
                1 => '无溢价',
                2 => '有溢价'
            ]
        ];
    }

    private static function getInvoice()
    {
        return [
            'data' => [
                1 => '无发票',
                2 => '有发票',
            ]
        ];
    }

    /*
     * 增值税专用发票税票：3%、6%、13%、17%
     */
    private static function getTax()
    {
//        return ['_3' => '3%', '_6' => '6%', '_13' => '13%', '_17' => '17%'];
        return ['_3' => '3%'];
    }

    /*
     * 312银行收支模块提示该投资预计期限是否大于一年，
     * 若大于一年，将长期股权投资作为一级科目，被投资方作为二级科目，形成会计分录，并返回步骤302；
     * 若小于一年，则将短期投资作为一级科目，投资种类作为二级科目，形成会计分录，并返回步骤302
     * 最后一位参数为数值则结束，所以这里数组的key不能为int
     */
    private static function getLength()
    {
        return [
            'data' => [
                1 => '小于一年',
                2 => '大于一年'
            ]
        ];
    }

    /*
     * 股东投入
     */
    private static function shareholderIncome()
    {
        return [
            'data' => [],
            'option' => [['text', '本金']],
        ];
    }

    /*
     * 含税或不含税
     */
    private static function withVat()
    {
        return [
            'data' => [],
            'option' => [['checkbox', 'withtax', '是否含税', '3%', '1']],
        ];
    }

    /*
     * $list Array 根据数组生成返回数据
     */
    private static function genData($list){
        $data = [];
        foreach($list as $item){
            $sbj2 = explode(',', $item['subject_2']);
            array_push($data, ['_' . $sbj2[0] => $item['order_no']]);
        }
        return ['data' => $data];
    }
    /*
     * 投资种类
     * 选择项的值不能为0
     * 1101子科目
     */
    private static function getInvestType($key = '')
    {
        $model = new Subjects();
        $sbj_arr = $model->list_sub(1101, $key);
        foreach ($sbj_arr as $item) {
            $list['_' . $item['sbj_number']] = $item['sbj_name'];
        }
        return [
            'data' => $list,
            'new' => 'allow',
            'newsbj' => 1101,
            'newsbjname' => Subjects::getName(1101)
        ];
    }

    /*
     * 投资收益6111
     */
    private static function getInvest($key)
    {
        $subject = new Subjects();
        $arr = [6111, 1511, 1101];
        $result = $subject->getitem($arr, $key, ['type' => 0]);
        return [
            'data' => array_flip(array_flip($result)),
            'new' => 'no',
//            'newsbj' => 6111,
            'newsbjname' => Subjects::getName(6111),
            'target' => true,
        ];
    }

    /*
     * 匹配交易方名称
     * 支付股利2232
     */
    private static function getDividend($key)
    {
        $subject = new Subjects();
        $arr = [2232];
        $result = $subject->getitem($arr, $key);
        return [
            'data' => $result,
            'new' => 'allow',
            'newsbj' => 2232,
            'newsbjname' => Subjects::getName(2232),
            'target' => true,
        ];
    }

    //汇兑损益、利息费用或手续费
    //财务费用6603子科目
    private static function getInterest($key = '')
    {
        $model = new Subjects();
        $arr_subj = $model->list_sub(6603, $key);
        if(empty($arr_subj))
            $arr_subj = $model->list_sub(6603);
        $list = [];
        foreach ($arr_subj as $subj) {
            $list['_' . $subj['sbj_number']] = $subj['sbj_name'];
        }
        return [
            'data' => $list,
            'new' => 'no',
        ];
    }

    //将其他业务支出6402作为一级科目，材料销售、技术转让或固定资产出租作为二级科目，形成会计分录
    private static function getMarket($key = '')
    {
        $model = new Subjects();
        $arr_subj = $model->list_sub(6402, $key);
        foreach ($arr_subj as $subj) {
            $list['_' . $subj['sbj_number']] = $subj['sbj_name'];
        }
        return [
            'data' => $list,
            'new' => 'allow',
            'newsbj' => 6402,
            'newsbjname' => Subjects::getName(6402)
        ];
//        return [
//            'data' => [
//                1 => '材料销售',
//                2 => '技术转让',
//                3 => '固定资产出租',
//            ]
//        ];
    }

    //材料销售、技术转让、固定资产出租收款，
    //银行收支模块将其他业务收入6051作为一级科目，材料销售、技术转让或固定资产出租作为二级科目，形成会计分录，并返回步骤302
    private static function getBorrow($key = '')
    {
        $model = new Subjects();
        $arr_subj = $model->list_sub(6051, $key);
        foreach ($arr_subj as $subj) {
            $list['_' . $subj['sbj_number']] = $subj['sbj_name'];
        }
        return [
            'data' => $list,
            'new' => 'allow',
            'newsbj' => 6051,
            'newsbjname' => Subjects::getName(6051)
        ];
//        return [
//            'data' => [
//                1 => '材料销售',
//                2 => '技术转让',
//                3 => '固定资产出租',
//            ]
//        ];
    }

    /*
     * 列出应付账款2202、预付账款1123、其他应付款2241、其他应收款1221、短期借款2001、长期借款2501的二级科目
     * 如果不存在，则提示用户录入收款方名称，银行收支模块将新录入的收款方名称作为新的其他应收款1221 二级科目，形成会计分录
     */
    private static function getDeposit($type, $key = '')
    {
        $subject = new Subjects();
        if ($type == 1) {   //支付押金
            $arr = [2202, 1123, 2241, 1221];
            $new = 'allow';
            $result = $subject->getitem($arr, $key);
            $target = true;
        } elseif ($type == 2) { //借出款项，跟员工有关的去除，
            $arr = [2202, 2241, 1221];
            $new = 'allow';
            $options['reject'] = [];
            $employees = Employee::model()->findAll();
            if(!empty($employees)){
                foreach ($employees as $item) {
                    $options['reject'][] = $item['name'];
                }
            }
            $result = $subject->getitem($arr, $key, $options);
            $target = true;
        } elseif ($type == 3) { //归还借款
//            $arr = [2001, 2501];
            $result = ['金融机构', '非金融机构'];
            $new = 'no';
            $target = false;
        }

        return [
//            'data' => array_flip(array_flip($result)),  //去除重复
            'data' => $result,
            'new' => $new,
            'newsbj' => 1221,
            'newsbjname' => Subjects::getName(1221),
            'target' => $target,
        ];
    }

    /*
     * 应付账款2202及其他应付款2241 子科目以展示
     * 如果未收到发票，货币收支模块将收款方名称作为预付账款1123二级科目，形成会计分录，并返回步骤302；
     * 如果已经收到发票，则提示用户选择本次采购的种类，
     * 具体包括固定资产（借固定资产1601，二级科目电子设备、办公设备、运输设备、生产设备）、原材料1403、库存货商品1405（借）、无形资产1701
     * 或服务（管理费用6602、市场6601、生产6401），各类下的商品或服务名称，以及收到发票是否为增值税专用发票（应交税费2221二级科目 进项（采购默认），
     * 金额为原金额x%，3%、6%、13%、17%），形成会计分录
     * 税费=总金额/(1+*%)**%
     * 金额=总金额-税费
     * @type Integer 没有凭证就不显示
     * @version Integer version为2，为1表示普通用户版，表示vip版
     */
    private static function getSupplier($key, $type=1, $version=1)
    {
        $subject = new Subjects();
        $arr = [2202, 2241];
        $list = [];
        if($version == 1)
            $list = $subject->getitem($arr, $key, ['type' => 0]);
        else{
            $list = Vendor::model()->list_vendors();
//            foreach($vendors as $vendor){
//                $list += $subject->getitem($arr, $vendor['company'], ['type' => 0]);
//            }
        }
//        $arr = [1601, 1403, 1405, 6602, 6601, 6401, 1701];
//        $result = $subject->getitem($arr,$key,['工资','社保','公积金','折旧费','研发费']);
//        $tax = self::getTax();
        $result = [];
        if($type==2)
            foreach ($list as $key => $item) {
                $model = Transition::model()->findByAttributes(['entry_subject' => substr($key,1)]);
                if($model)
                    $result[$item] = $item;
            }
        else
            $result = $list;

        return [
            'data' => $result,
            'target' => true,
//            'new' => 'allow',
//            'list' => [1 => '无发票', 2 => '有发票'],
//            'select' => [1 => ['_1123' => Subjects::getSbjPath(1123)], 2 => $list, 3 => $tax]
//            'select' => [1 => $result]
        ];
    }

    /*
     * 供应商采购 选择供应商名字后
     */
    private static function afterSupplier($key = '')
    {
        $subject = new Subjects();
        $arr = [1601, 1403, 1405, 6602, 6601, 6401, 1701];
        $result = $subject->getitem($arr, $key, ['type'=>1, 'reject' => ['工资', '社保', '公积金', '折旧费', '研发费']]);
        return [
            'data' => $result,
        ];
    }

    /*
     *  列出所有员工
     */
    private static function getEmployee($key = '')

    {
        $model = new Employee();
        $result = [];
//        $list = $model->find()->where(Employee::tableName() . '.name like "%' . $key . '%"')->joinWith('department')->asArray()->all();
        $etable = Employee::model()->tableSchema->name;
        $dtable = Department::model()->tableSchema->name;
        $sql = <<<eof
select * from (select e.*,d.name as dname, case when e.name like '$key' then 1
            when e.name like '$key%' then 2
            when e.name like '%$key%' then 3
            when e.name like '%$key' then 4
            end as rn
            from $etable as e, $dtable as d
            where e.name like '%$key%' and department_id= d.id ) as k
            order by rn;
eof;
        $list = Employee::model()->findAllBySql($sql);

        foreach ($list as $item) {
            $result['_' . $item['id']] = $item['department']['name'] . '/' . $item['name'];
        }
        $list = Yii::app()->db->createCommand('select id,name from '.Department::model()->tableSchema->name )->queryAll();
        return [
            'data' => $result,
            'new' => 'employee',
            'list' => $list,
            'target' => true,
        ];
    }

    /*
     * 员工报销 选择员工名字后
     */
    private static function afterEmployee($key = '')
    {
        $subject = new Subjects();
        $arr = [1601, 1403, 1405, 6602, 6601, 6401, 1701];
        $result = $subject->getitem($arr, $key, ['reject' => ['工资', '社保', '公积金', '折旧费', '研发费']]);
        return [
            'data' => $result,
        ];
    }

    /*
     *  应收账款1122、其他应收款1221、预收账款2203、预付账款1123、短期借款2001、长期借款2501
     *  如果为借款，则根据期限以短期借款或长期借款为贷方科目形成分录
     *  如果不是借款，银行收支模块将新录入的付款方名称作为新的其他应付款2241二级科目
     */
    private static function getIncomeItem($type, $key = '')
    {
        $subject = new Subjects();
        if ($type == 1) {//押金
            $arr = [1122, 1221, 2203, 1123, 2241];
            $new = 'allow';
            $result = $subject->getitem($arr, $key);
            $target = true;
        } elseif ($type == 2) {//借款
//            $arr = [1122, 1221, 2203, 1123, 2001, 2501];
            $new = 'no';
            $result = ['银行借款', '其他借款'];
            $target = false;
        } elseif ($type == 3) {//还款
            $arr = [1122, 1221, 2203, 1123, 2501];
            $new = 'no';
            $result = $subject->getitem($arr, $key);
            $target = true;
        }
//        $arr = [1122, 1221, 2203, 1123, 2001, 2501];
        $list = ['_2001' => '短期借款', '_2501' => '长期借款'];

        return [
            'data' => $result,
            'new' => $new,
            'newsbj' => 2241,
            'target' => $target,
//            'list' => [1 => '不是借款', 2 => '是借款'],
//            'select' => [1 => ['_2241' => Subjects::getSbjPath(2241)], 2 => $list]
//            'option' => [['text','手动填写'],['select',['是借款','不是借款']],['select',[2001=>'短期借款',2501=>'长期借款']]],

        ];
    }

    /*
     * 销售款，银行收支模块将现有应收账款1122及其他应收款1221的主营业务收入6001二级科目予以列示，
     * 如果本次收款方在列表中存在，则用户可直接选择，并形成会计分录，返回步骤302；
     * 如果不存在，则执行步骤320
     * 如果未开具发票，货币收支模块将收款方名称作为预收账款2203二级科目，形成会计分录，并返回步骤302；
     * 如果已经开具发票，则提示用户选择项目名称 以及开具的发票是否为增值税专用发票，形成会计分录
     */
    private static function getSale($key = '')
    {
        $subject = new Subjects();
        $arr = [ 6001];
        $result = $subject->getitem($arr, '', ['type' => 0, 'sbj_number' => 6001]);
        return [
            'data' => array_flip(array_flip($result)),
            'new' => 'no',
            'newsbj' => 6001,
            'newsbjname' => Subjects::getName(6001),
            'target' => true,
        ];
    }

    private static function getTaxFee($key = ''){
        $subject = new Subjects();
        $arr = [2221];
        $result['个人所得税费用'] = '个人所得税费用';
        $result['营业税金及附加'] = '营业税金及附加';
        $result += $subject->getitem($arr, $key);
        $sbj = $subject->getitem([6801,660207], $key, ['level'=>0, 'type'=>2]); //印花税
        if(!empty($sbj))
            $result += $sbj;
        return [
            'data' => $result,
        ];
    }
    private static function getTaxFee2($key = ''){
        $subject = new Subjects();
        $arr = [6403];
        $result = $subject->getitem($arr, $key);
        return [
            'data' => $result,
        ];
    }
    private static function getBank($key = ''){
        $subject = new Subjects();
        $arr = [1002];
        $result = $subject->getitem($arr, $key);
        return [
            'data' => $result,
        ];
    }
    /*
     * 选项
     * 1支出 2收入
     */
    public static function chooseType($type)
    {
        if ($type == 1) {   //选择支出
            return self::getPay();
        } elseif ($type == 2) {   //选择收入
            return self::getIncome();
        }
    }

    /*
     * 选择
     * @type Integer 支出或收入
     * @options String 选项参数
     * @data string 表格数据 0checkbox|1name|2date|3description|4amount
     */
    public static function chooseOption($type, $options, $data)
    {
        $version = User2::model()->checkVIP()?2:1;
        $result = [];
        $options = explode(",", $options);
        $data = explode("|", $data);
//        $option = end($options);
//        if ((int)$option === 0) {   //字符串转换为int，如果不是数值，最后就为0，代表最后一位 没有 选择最终值
        $a = new Bank();
        if ($type == 1) { //支出
            switch ($options[2]) {
                case '工资社保'  :
                    if($version==1){
                        if (isset($options[3])) {
                            if (isset($options[4])) {
                                $department = Employee::getDepart($options[4]);
                                $result = Department::matchSubject($department, $options[3]);
                                return self::endOption($result);
                            }
                            //304 若付款金额小于上期预提的金额，则将应付职工薪酬2211或其他应付款2241作为一级科目形成分录
                            /*if ($data[4] < $a->prospect()) {   //$data[3] 为金额  假设为30000
                                if ($options[3] == '工资与资金')
                                    return self::endOption(2211);
                                else
                                    return self::endOption(2241);
                            } else {*/
                            $result = self::getEmployee($data[1]);//员工列表
//                        }
                        } else
                            $result = self::getSalary();
                    } else{
                        $result = Subjects::matchSubject($options[3], 2211);
                        return self::endOption($result);
                    }
                    break;
                case '支付押金'  :
                case '借出款项'  :
                case '归还借款'  :
                    if ($options[2] == '支付押金')
                        $type = 1;
                    elseif ($options[2] == '借出款项')
                        $type = 2;
                    elseif ($options[2] == '归还借款')
                        $type = 3;
                    if (isset($options[3])) {
                        $subject = new Subjects();
                        if (strlen($options[3]) >= 4) {
                            return self::endOption($options[3]);
                        } elseif ($options[3] == 0) { //银行借款
                            if (isset($options[4])) {
                                return self::endOption($options[4]);
                            } else {
                                $result['data'] = $subject->getitem([2001], $data[1]);
                            }
                        } else {  //其他借款
                            if (isset($options[4])) {
                                return self::endOption($options[4]);
                            } else
                                $result['data'] = $subject->getitem([2241], $data[1]);
                        }
                    } else
                        $result = self::getDeposit($type, $data[1]);
                    break;
                case '供应商采购'  :
                    if($version==1){
                        if (isset($options[3]))
                            return self::endOption($options[3]);
                        $result = self::afterSupplier($data[1]);
                        $result['type'] = 'droplist';
                    }
                    else{
                        if (isset($options[3])) {
                            if (isset($options[4])) {
                                return self::endOption($options[4]);
                            }else{
                                $order = Vendor::listOrders($options[3]);
                                if(!empty($order))
                                    $result = self::genData($order);
                            }
                        }else{
                            $vendors = Vendor::getVendors($data[1], 1, 2);
                            $result = ['data' => $vendors];
                        }
                    }
                    break;
                case '员工报销'  :
                    //若付款金额小于上期预提的金额，则将其他应付款2241作为一级科目，该员工名称作为二级科目形成分录；
                    if($version==1){
                        if (isset($options[3]))
                            return self::endOption($options[3]);
                        $result = self::afterEmployee($data[1]);
                        $result['type'] = 'droplist';
                    }else{
                        if (isset($options[3])) {
                            if (isset($options[4])) {
                                if($options[4]=='预支款'){
                                    $sbj = Subjects::matchSubject($options[3],['1221']);
                                    return self::endOption($sbj);
                                }else {
                                    //员工报销需要把报销的项目列出来供选择 多选
                                    $rem = Reimburse::model()->findByAttributes(['order_no' => $options[4]]);
                                    $sbj = 0;
                                    if ($rem) {
                                        $tmp3 = explode(',', $rem['subject_2']);
                                        if(count($tmp3) > 1){   //报销的贷方科目只有其他应付和其他应收这2项
                                            $sbj = $tmp3[0];
                                        }else
                                            $sbj = $rem['subject_2'];
                                        $pro_arr = ['travel', 'benefit', 'traffic', 'phone', 'entertainment', 'office', 'rent', 'watere', 'train', 'service', 'stamping'];
                                        foreach ($pro_arr as $item) {
                                            $real_orders = json_decode($rem['paid'], true);
                                            $paid = '';
                                            $checked = 0;
                                            if($real_orders){
                                                foreach ($real_orders as $a) {
                                                    $paid .= ','. $a;
                                                }

                                                if($options[0]!='0' && isset($real_orders[$options[0]])){
                                                    if(strpos($real_orders[$options[0]], $item) !== false)
                                                        $checkbox[] = ['checkbox', $item . '_amount', Reimburse::model()->getAttributeLabel($item . '_amount'), $rem[$item . '_amount'], "1"];
                                                }

                                            }else
                                                $checked = 1;
                                            $paid = array_filter(explode(',', $paid));
                                            if ($rem[$item . '_amount'] > 0 && !in_array($item . '_amount', $paid))
                                                $checkbox[] = ['checkbox', $item . '_amount', Reimburse::model()->getAttributeLabel($item . '_amount'), $rem[$item . '_amount'], "$checked"];
                                        }

                                        $option = ['option' => $checkbox];
                                    }
                                    return self::endOption($sbj, $option);
                                }
                            }else{
                                //todo 报销订单支付完成判断
                                $orders = Reimburse::listOrders($options[3]);
                                if(!empty($orders)){
                                    foreach($orders as $item){
                                        $tmp[$item['order_no']] = $item['order_no'];
                                    }
                                }
                                $tmp[] = ['预支款' =>'预支款'];
                                $result =  ['data' => $tmp];
                            }
                        }else{
                            $order = Reimburse::getEmployee($data[1]);
                            $result = ['data' => $order];
                        }
                    }

                    break;
                case '投资支出'  :
                    if (isset($options[3])) {
                        if (isset($options[4]))
                            return self::endOption($options[4]);

                        //若大于一年，列出长期股权投资1511作为二级科目，形成会计分录，并返回步骤302；
                        //若小于一年，则将交易性金融资产1101作为一级科目，投资种类（股票，债券，基金，其他）作为二级科目，形成会计分录
                        if ($options[3] == 1) { //  1:小于，2:大于
                            $result = self::getInvestType();
                            $result['new'] = 'no';
                        } else {
                            $model = new Subjects();
                            $sbj_arr = $model->list_sub(1511, $data[1]);
                            $list = [];
                            foreach ($sbj_arr as $item) {
                                $list['_' . $item['sbj_number']] = $item['sbj_name'];
                            }
                            $result = ['data' => $list, 'new' => 'allow', 'newsbj' => 1511, 'newsbjname' => Subjects::getName(1511)];
//                            $result['target'] = true;
                        }

                    } else
                        $result = self::getLength();
                    break;
                case '利息手续费'  :
                    if (isset($options[3])) {
                        return self::endOption($options[3]);
                    } else
                        $result = self::getInterest($data[1]);
                    break;
                case '材料销售'  :
                    return self::endOption(640201);
                    break;
                case '技术转让'  :
                    return self::endOption(640202);
                    break;
                case '资产租赁'  :
                    return self::endOption(640203);
                    break;
//                    if (isset($options[3])) {
//                        return self::endOption($options[3]);
//                    } else
//                        $result = self::getMarket($data[1]);
//                    break;
                case '支付股利'  :  //将应付股利2232作为一级科目，收款方为二级科目
                    if (isset($options[3])) {
                        return self::endOption($options[3]);
                    } else
                        $result = self::getDividend($data[1]);
                    break;
                case '支付税金'  :  //将应交税费2221子科目列出
                    if (isset($options[3])) {
                        if($options[3]=='个人所得税费用')
                        {
                            if(isset($options[4])) {
                                $department = Employee::getDepartType($options[4]);
                                switch ($department) {
                                    case 1:
                                        $result = Subjects::matchSubject('工资与奖金', array(6401));
                                        break;
                                    case 2:
                                        $result = Subjects::matchSubject('工资与奖金', array(6602), 1);
                                        break;
                                    case 3:
                                        $result = Subjects::matchSubject('工资与奖金', array(6601));
                                        break;
                                    case 4:
                                        $result = Subjects::matchSubject('工资与奖金', array(660202));
                                        break;
                                }
                                return self::endOption($result);
                            }
                            else
                            $result = self::getEmployee($data[1]);
                        }elseif($options[3]=='营业税金及附加'){
                            if(isset($options[4]))
                                return self::endOption($options[4]);
                            else
                                $result = self::getTaxFee2($data[1]);
                        }
                        else
                            return self::endOption($options[3]);
                    } else
                        $result = self::getTaxFee($data[1]);
                    break;
                case '银行转账'  :  //银行资金互转
                    if (isset($options[3])) {
                        return self::endOption($options[3]);
                    } else
                        $result = self::getBank($data[1]);
                    break;
                case '现金提取'  :  //将营业外支出6711作为借方科目，形成会计分录
                    return self::endOption(1001);
                    break;
                case '其他支出'  :
                    return self::endOption(6711);
                    break;
                default:
                    $result = [];
            }
        } elseif ($type == 2) { //收入
            switch ($options[2]) {
                case '股东投入'  :
                    if (isset($options[3])) {
                        //如果否，则将实收资本4001作为贷方科目，形成会计分录，并返回步骤302
                        //如果是，则将本金作为实收资本贷方，溢价金额作为资本公积4002贷方，形成会计分录，并返回步骤302
                        $result = [];
                        if ($options[3] == 2) {
                            $result = self::shareholderIncome($data[1]);
                        }
                        return self::endOption(4001, $result);

                    } else
                        $result = self::getPremium($data[1]);
                    break;
                case '收到押金'  :
                case '收到借款'  :
                case '收到还款'  :
                    if ($options[2] == '收到押金')
                        $type = 1;
                    elseif ($options[2] == '收到借款')
                        $type = 2;
                    elseif ($options[2] == '收到还款')
                        $type = 3;
                    if (isset($options[3])) {
                        if (strlen($options[3]) >= 4)
                            return self::endOption($options[3]);
                        $subject = new Subjects();
                        if ($options[3] == 0) { //银行借款
                            if (isset($options[4])) {
                                return self::endOption($options[4]);
                            } else {
                                $result['new'] = 'allow';
                                $result['newsbj'] = 2001;
                                $result['data'] = $subject->getitem([2001], $data[1]);
                                $result['target'] = true;
                            }
                        } else {  //其他借款
                            if (isset($options[4])) {
                                return self::endOption($options[4]);
                            } else {
                                $result['new'] = 'allow';
                                $result['newsbj'] = 2241;
                                $result['data'] = $subject->getitem([2241], $data[1]);
                                $result['target'] = true;
                            }
                        }
                    } else
                        $result = self::getIncomeItem($type, $data[1]);
                    break;
                case '销售收入'  :
                    if($version==1){
                        if (isset($options[3])) {
                            //如果选择的科目，其一级科目是6001，可以是接返回，否则根据名字，在6001下新建子科目再返回
                            $result = self::withVat();//是否含税
                            if (substr($options[3], 0, 4) != '6001') {
                                $options[3] = Subjects::createSubject(Subjects::getName($options[3]), 6001);
                            }
                            return self::endOption($options[3], $result);
                        } else
                            $result = self::getSale($data[1]);
                    }else{
                        if (isset($options[3])) {
                            if (isset($options[4])) {
//                                if($options[4] == '2203'){  //预收款，生成一个订单号
//                                    $order = new Preparation();
//                                    $order->order_no = $order->initOrder('product');
//                                    $order->save();
//                                }
                                return self::endOption($options[4]);
                            }else{
                                $order = Client::listOrders($options[3]);
                                if($order)
                                    $result = self::genData($order);
                            }
                        }else{
                            $clients = Client::getClient($data[1]);
                            $result = ['data' => $clients];
                        }
                    }
                    break;
                case '投资收益'  :
                    if (isset($options[3])) {//如果选择的科目，其一级科目是6001，可以是接返回，否则根据名字，在6001下新建子科目再返回
                        if (substr($options[3], 0, 4) != '6111') {
                            $options[3] = Subjects::createSubject(Subjects::getName($options[3]), 6111);
                        }
                        return self::endOption($options[3]);
                    } else
                        $result = self::getInvest($data[1]);
                    break;
                case '利息收入'  :
                    if (isset($options[3])) {
                        return self::endOption($options[3]);
                    } else
                        $result = self::getInterest();
                    break;
                case '材料销售'  :
                    return self::endOption(605101);
                    break;
                case '技术转让'  :
                    return self::endOption(605102);
                    break;
                case '资产租赁'  :
                    return self::endOption(605103);
                    break;
                case '银行转账'  :  //银行资金互转
                    if (isset($options[3])) {
                        return self::endOption($options[3]);
                    } else
                        $result = self::getBank($data[1]);
                    break;
                case '存入现金'  :
                    return self::endOption(1001);
                    break;
                case '其他收入'  :
                    return self::endOption(6301);
                    break;
            }
        }
//        } else {
//            return self::setSubject($options, $data);
//        }
        return [
            'target' => isset($result['target']) ? $result['target'] : false,
            'rule' => 'goon',
            'type' => isset($result['type']) ? $result['type'] : 0,
            'data' => $result['data'],
            'new' => isset($result['new']) ? $result['new'] : 0,
            'list' => isset($result['list']) ? $result['list'] : 0,
            'newsbj' => isset($result['newsbj']) ? $result['newsbj'] : 0,
            'newsbjname' => isset($result['newsbj']) ? Subjects::getName($result['newsbj']) : '',
            'select' => isset($result['select']) ? $result['select'] : 0,
            'option' => isset($result['option']) ? $result['option'] : 0,
        ];   //go on，表示还有子选项，否则设置科目表，准备生成凭证
    }

    public static function endOption($sbj, $result = [])
    {
        return [
            'rule' => 'end',
            'subject' => $sbj,
            'sbj_name' => Subjects::getSbjPath($sbj),
            'option' => isset($result['option']) ? $result['option'] : 0,
        ];
    }

    /*
     * 预提金额
     * 要判断不同的预提金额
     */
    public function prospect()
    {
        return 3000;
    }

    /*
     * 修改科目凭证科目为父科目
     */
    public static function updateSubject($sbj){
        $criteria = new CDbCriteria();
        $criteria->compare('subject', $sbj, true);
        $rows = Bank::model()->updateAll(['subject' => substr($sbj,0,-2)], $criteria);
        $criteria = new CDbCriteria();
        $criteria->compare('subject_2', $sbj, true);
        $rows = Bank::model()->updateAll(['subject_2' => substr($sbj,0,-2)], $criteria);
    }

    /*
     * 如果是采购或销售或报销，金额不能大于未支付部分
     */
    public function checkAmount($attribute, $params){
        $type = $this->type;
        if($type=='purchase' || $type=='product'){
            if($type=='purchase')
                $order = Purchase::model()->findByPk($this->pid);
            else
                $order = Product::model()->findByPk($this->pid);
            $unpaid = floatval($order->price)*$order->count - $order->getPaid();
            $unpaid = round($unpaid, 2);
            if($unpaid > 0){
                $old = $this->findByPk($this->id);
                $unpaid += $this->isNewRecord?0:$old->amount;
                if($this->amount > $unpaid)
                    $this->addError($attribute, "金额不能大于$unpaid");
            }
        }
    }

    /*
     * 有关联的数据
     */
    public function getRelation($type,$id){
        $relation = Purchase::model()->findAllByAttributes([],"relation like '%\"bank\":\"$id\"%'");
        $relation += Product::model()->findAllByAttributes([],"relation like '%\"bank\":\"$id\"%'");
        $relation += Reimburse::model()->findAllByAttributes([],"relation like '%\"bank\":\"$id\"%'");
        return $relation;
    }
}
