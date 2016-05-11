<?php

/**
 * This is the model class for table "transition".
 *
 * The followings are the available columns in table 'transition':
 * @property integer $id
 * @property string $entry_num_prefix
 * @property integer $entry_num
 * @property string $entry_time
 * @property string $entry_date
 * @property string $entry_memo
 * @property string $realorder
 * @property integer $entry_transaction
 * @property integer $entry_subject
 * @property float $entry_amount
 * @property string $entry_appendix
 * @property integer $entry_appendix_type
 * @property integer $entry_appendix_id
 * @property integer $entry_creater
 * @property integer $entry_editor
 * @property integer $entry_reviewer
 * @property integer $entry_deleted
 * @property integer $entry_reviewed
 * @property integer $entry_forward
 * @property integer $entry_posting
 * @property integer $entry_settlement
 * @property integer $entry_closing
 */
class Transition extends CActiveRecord
{
    /*
     * custom params
     */
    public $query_s_day;
    public $query_e_day;
    public $query_memo;

    public $query_multi_str;

    public $check_entry_amount = 0; //是否验证过借贷相等 优化处理 待改进
    public $entry_number; //  entry_num_prefix. entry_num     完整凭证编号，供凭证管理、排序搜索使用
    public $entry_time;
    public $select; // search的时候，定义返回字段
    public static $input_arr = [
        "entry_name" => "",
        "model" => "",
        "entry_date" => "",
        "entry_memo" => "",
        "realorder" => "",
        "entry_amount" => "",
        "entry_transaction" => "",
        "d_id" => "",
        "entry_subject" => "",
        "subject_2" => "",
        "entry_appendix_id" => "",
        "hs_no" => "",
        "order_no" => "",
        "vendor_id" => "",
        "client_id" => "",
        "department_id" => "",
        "price" => "",
        "count" => "1",
        "unit" => "",
        "paid" => "",
        "preorder" => [],
        "preOrder" => [],
        "invoice" => "0",
        "tax" => "0",
        "overworth" => 0,
        "parent" => "",
        'stocks' => '',
        'stocks_count' => '',
        'stocks_price' => '',
        'employee_name' => '',
        'department_name' => '',
        'salary_amount' => '',
        'bonus_amount' => '',
        'benefit_amount' => '',
        'social_personal' => '',
        'provident_personal' => '',
        'before_tax' => '',
        'personal_tax' => '',
        'after_tax' => '',
        'social_company' => '',
        'provident_company' => '',
        'base_amount' => '',
        'base_2_amount' => '',
        'travel_amount' => '',
        'traffic_amount' => '',
        'phone_amount' => '',
        'entertainment_amount' => '',
        'office_amount' => '',
        'rent_amount' => '',
        'watere_amount' => '',
        'train_amount' => '',
        'service_amount' => '',
        'stamping_amount' => '',
        "additional" => [
            "0" => [
                "subject" => "",
                "amount" => "",
            ],
            "1" => [
                "subject" => "",
                "amount" => "",
            ],

        ],
        'path' => '',
        "entry_reviewed" => "0",
        "status_id" => "1",

    ];

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Transition the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('entry_num, entry_subject, entry_amount,entry_creater, entry_editor', 'required'),
            array('entry_num, entry_transaction, entry_subject,entry_creater, entry_editor, entry_reviewer, entry_deleted, entry_reviewed, entry_posting, entry_closing', 'numerical', 'integerOnly' => true),
            array('entry_amount', 'type', 'type' => 'float'),
            array('entry_num_prefix', 'length', 'max' => 10),
            array('entry_memo, entry_appendix', 'length', 'max' => 100),
            array('entry_appendix_id, entry_appendix_type, entry_name, data_type, data_id, entry_date, entry_time', 'safe'),
            // The following rule is used by search().

            array('id, entry_number, entry_num_prefix, entry_num, entry_date, entry_time, entry_memo, entry_transaction,
            entry_subject, entry_amount, entry_appendix, entry_appendix_id, entry_appendix_type,entry_creater, entry_editor, entry_reviewer,
            entry_deleted, entry_reviewed, entry_posting, entry_closing, entry_forward, entry_settlement', 'safe', 'on' => 'search'),
            //自定义验证规则
            array('entry_amount', 'check_entry_amount', 'on' => 'create,update'), //借贷相等
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
            'entry_num_prefix' => Yii::t('transition', '凭证前缀'),
            'entry_num' => Yii::t('transition', '凭证号'),
            'entry_time' => Yii::t('transition', '录入时间'),
            'entry_date' => Yii::t('transition', '凭证日期'),
            'entry_name' => Yii::t('transition', '交易对象名称'),
            'data_type' => Yii::t('transition', '交易类型'),
            'data_id' => Yii::t('transition', '原数据ID'),
            'entry_memo' => Yii::t('transition', '凭证摘要'),
            'entry_transaction' => Yii::t('transition', '借贷'),
            'entry_subject' => Yii::t('transition', '借贷科目'),
            'entry_amount' => Yii::t('transition', '交易金额'),
            'entry_appendix' => Yii::t('transition', '附加信息'),
            'entry_appendix_id' => Yii::t('transition', '客户、供应商、员工、项目'),
            'entry_creater' => Yii::t('transition', '制单人员'),
            'entry_editor' => Yii::t('transition', '录入人员'),
            'entry_reviewer' => Yii::t('transition', '审核人员'),
            'entry_deleted' => Yii::t('transition', '凭证删除'),
            'entry_reviewed' => Yii::t('transition', '凭证审核'),
            'entry_posting' => Yii::t('transition', '过账'),
            'entry_forward' => Yii::t('transition', '结转'),
            'entry_closing' => Yii::t('transition', '结账'),
            'entry_settlement' => Yii::t('transition', '结转凭证'),
            'entry_number' => Yii::t('transition', '凭证编号'),
        );
    }

    public static function getSbjPath($id)
    {
        return Subjects::getSbjPath($id);
    }

    public static function checkSettlement($date)
    {
        $Tran = new Transition();
        if ($date == "")
            $date = date('Ym', time());
        if (isset($_REQUEST['date']))
            $date = $_REQUEST['date'];
        if ($Tran->isAllPosted($date))
            return true;
        else
            throw new CHttpException(400, $date . " 还有凭证未审核或未过账");
    }

    /*
     * 返回凭证是否都已经过账, attributes由实例传入
     */
    public function isAllPosted($date)
    {
        $this->unsetAttributes();
        $this->entry_posting = 0;
        $this->entry_num_prefix = $date;
        $this->select = "entry_num_prefix,entry_num,entry_posting";
        $dataProvider = $this->search();
        $transition = $dataProvider->getData();
        return empty($transition);
    }

    public function isAllForward($date)
    {
        $this->unsetAttributes();
        $this->entry_forward = 0;
        $this->entry_num_prefix = substr($date, 0, 6);
        $this->select = "entry_num_prefix,entry_num,entry_forward";
        $dataProvider = $this->search();
        $transition = $dataProvider->getData();
        return empty($transition);
    }

    public function isAllClosing($date)
    {
        $this->unsetAttributes();
        $this->entry_closing = 1;
        $this->entry_num_prefix = substr($date, 0, 6);
        $this->select = "entry_num_prefix,entry_num,entry_forward";
        $dataProvider = $this->search();
        $transition = $dataProvider->getData();
        return empty($transition);
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
        //$month = true;

        $criteria->compare('id', $this->id);
        if ($this->entry_num_prefix === null) {
            if ($this->query_s_day != null) {
                $criteria->addCondition('t.entry_date>="' . $this->query_s_day . '"', 'AND');
                //$month = false;
            }
            if ($this->query_e_day != null) {
                $criteria->addCondition('t.entry_date<="' . $this->query_e_day . '"', 'AND');
                //$month = false;
            }
            if ($this->query_memo != null) {
                //$criteria->addCondition('t.entry_memo like "%' . $this->query_memo . '%"');
                //$month = false;
                $this->entry_memo = $this->query_memo;
            }
        } else {
            $criteria->compare('entry_num_prefix', $this->entry_num_prefix, true);
        }

        if ($this->query_multi_str !== null) {
            if (is_numeric($this->query_multi_str) && mb_strlen($this->query_multi_str) == 10) {
                $a = substr($this->query_multi_str, 0, 6);
                $b = intval(substr($this->query_multi_str, 6));
                $criteria->addCondition('t.entry_num_prefix = "' . $a . '"');
                $criteria->addCondition('t.entry_num = "' . $b . '"');
            }

            $tmp_timestamp = strtotime($this->query_multi_str);
            if ($tmp_timestamp !== false) {
                $criteria->addCondition('t.entry_date = "' . date('Y-m-d', $tmp_timestamp) . '"', 'OR');
            }
            if ($this->query_multi_str != '')
                $criteria->addCondition('t.entry_memo like "%' . $this->query_multi_str . '%"', 'OR');
        }


        $criteria->compare('entry_num', $this->entry_num, true);
        $criteria->compare('entry_num_prefix', $this->entry_number, true);
        $criteria->compare('entry_date', $this->entry_date, true);
        $criteria->compare('entry_time', $this->entry_time, true);
        $criteria->compare('entry_memo', $this->entry_memo, true);
        $criteria->compare('entry_transaction', $this->entry_transaction, true);
        $criteria->compare('entry_subject', $this->entry_subject, true);
        $criteria->compare('entry_amount', $this->entry_amount);
        $criteria->compare('entry_appendix', $this->entry_appendix, true);
        $criteria->compare('entry_creater', $this->entry_creater);
        $criteria->compare('entry_editor', $this->entry_editor);
        $criteria->compare('entry_reviewer', $this->entry_reviewer);
        $criteria->compare('entry_deleted', $this->entry_deleted);
        $criteria->compare('entry_reviewed', $this->entry_reviewed);
        $criteria->compare('entry_posting', $this->entry_posting);
        $criteria->compare('entry_settlement', $this->entry_settlement);
        $criteria->compare('entry_forward', $this->entry_forward);
        $criteria->compare('entry_closing', $this->entry_closing);


        if ($this->select != null)
            $criteria->select = $this->select;
//        $criteria->compare('entry_number',$this->entry_num_prefix, true);

        $sort = new CSort();
        $sort->attributes = array(
            'entry_number' => array(
                'asc' => ' entry_num_prefix asc ,entry_num  ASC, entry_transaction asc',
                'desc' => 'entry_num_prefix desc , entry_num  DESC,  entry_transaction asc'
            ),
            '*', // this adds all of the other columns as sortable
        );

        /* Default Sort Order*/
        $sort->defaultOrder = array(
            'entry_number' => CSort::SORT_DESC,
        );

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageVar' => 'p',
                'pageSize' => '20',
            ),
            'sort' => $sort,
        ));
    }


    public function multiSearch()
    {
        $criteria = new CDbCriteria;
        $month = true;

        if (isset($_REQUEST['multi_search'])) {

            if (is_numeric($_REQUEST['multi_search']) && mb_strlen($_REQUEST['multi_search']) == 10) {
                $a = substr($_REQUEST['multi_search'], 0, 6);
                $b = substr($_REQUEST['multi_search'], 6) + 0;
                $criteria->addCondition('t.entry_num_prefix = "' . $a . '"');
                $criteria->addCondition('t.entry_num = "' . $b . '"');
            }

            $tmp_timestamp = strtotime($_REQUEST['multi_search']);
            if ($tmp_timestamp !== false) {
                $criteria->addCondition('t.entry_date = "' . date('Y-m-d', $tmp_timestamp) . '"', 'OR');
                $month = false;
            }
            if ($_REQUEST['multi_search'] != '')
                $criteria->addCondition('t.entry_memo like "%' . $_REQUEST['multi_search'] . '%"', 'OR');

        }


        $criteria->compare('id', $this->id);
        $month ? $criteria->compare('entry_num_prefix', $this->entry_num_prefix, true) : '';
        $criteria->compare('entry_num', $this->entry_num, true);
        $criteria->compare('entry_num_prefix', $this->entry_number, true);
        $criteria->compare('entry_date', $this->entry_date, true);
        $criteria->compare('entry_time', $this->entry_time, true);
        $criteria->compare('entry_memo', $this->entry_memo, true);
        $criteria->compare('entry_transaction', $this->entry_transaction, true);
        $criteria->compare('entry_subject', $this->entry_subject, true);
        $criteria->compare('entry_amount', $this->entry_amount);
        $criteria->compare('entry_appendix', $this->entry_appendix, true);
        $criteria->compare('entry_creater', $this->entry_creater);
        $criteria->compare('entry_editor', $this->entry_editor);
        $criteria->compare('entry_reviewer', $this->entry_reviewer);
        $criteria->compare('entry_deleted', $this->entry_deleted);
        $criteria->compare('entry_reviewed', $this->entry_reviewed);
        $criteria->compare('entry_posting', $this->entry_posting);
        $criteria->compare('entry_settlement', $this->entry_settlement);
        $criteria->compare('entry_forward', $this->entry_forward);
        $criteria->compare('entry_closing', $this->entry_closing);

        if ($this->select != null)
            $criteria->select = $this->select;
//        $criteria->compare('entry_number',$this->entry_num_prefix, true);

        $sort = new CSort();
        $sort->attributes = array(
            'entry_number' => array(
                'asc' => ' entry_num_prefix asc ,entry_num  ASC, entry_transaction asc',
                'desc' => 'entry_num_prefix desc , entry_num  DESC,  entry_transaction asc'
            ),
            '*', // this adds all of the other columns as sortable
        );

        /* Default Sort Order*/
        $sort->defaultOrder = array(
            'entry_number' => CSort::SORT_DESC,
        );

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageVar' => 'p',
                'pageSize' => '20',
            ),
            'sort' => $sort,
        ));
    }

    public static function listReview()
    {
        $tran = new Transition();
        return $tran->listDate(array('entry_reviewed' => 0));
    }

    /*
     * 有凭证的日期
     */
    public static function listDate($arr = array(), $options = [])
    {
        $options['group'] = 'entry_num_prefix';
        $criteria = new CDbCriteria($options);
        $list = Transition::model()->findAllByAttributes(
            $arr,
            $criteria
        );
        $arr = array();
        if ($list) {
            foreach ($list as $model) {
                $year = substr($model->entry_num_prefix, 0, 4);
                $month = substr($model->entry_num_prefix, 4, 6);
                if (empty($arr[$year])) {
                    $arr += array($year => array($month));
                } else
                    array_push($arr[$year], $month);
            }
        }
        return $arr;
    }

    public static function listDate2($arr = array(), $sbj_arr = [])
    {
        $criteria = new CDbCriteria(array('group' => 'entry_num_prefix'));
        if (!empty($sbj_arr)) {
            foreach ($sbj_arr as $key => $item) {
                $sbj_arr[$key] = "entry_subject like '$item%'";
            }
            $sbj = implode(' OR ', $sbj_arr);
            $criteria->condition .= "($sbj)";
        }
        $arr['entry_transaction'] = 1;
        $list = Transition::model()->findAllByAttributes(
            $arr,
            $criteria
        );
        $arr = array();
        if ($list) {
            foreach ($list as $model) {
                $year = substr($model->entry_num_prefix, 0, 4);
                $month = substr($model->entry_num_prefix, 4, 6);
                if (empty($arr[$year])) {
                    $arr += array($year => array($month));
                } else
                    array_push($arr[$year], $month);
            }
        }
//        return $arr;
    }

    public static function listTransition()
    {
        $tran = new Transition();
        return $tran->listDate(array());
    }

    public static function listPost()
    {
        $tran = new Transition();
        return $tran->listDate(array('entry_posting' => 0));
    }

    /*
     * 可整理日期
     */
    public static function listReorganise()
    {
        $tran = new Transition();
        return $tran->listDate(array());
    }

    /*
     * 可结账日期
     */
    public static function listSettlement()
    {
        $tran = new Transition();
        return $tran->listDate(array('entry_forward' => 0));
    }

    /*
     * 可结转日期
     */
    public static function listClosing()
    {
        $tran = new Transition();
        return $tran->listDate(array('entry_closing' => 0));
    }

    /*
     * 普通版结账，生成结转凭证直接过账结账
     */
    public static function listSettlementcloseing()
    {
        $tran = new Transition();
        return $tran->listDate(array('entry_closing' => 0));
    }

    /*
     * 可反结账日期
     */
    public static function listAntiSettlement()
    {
        $tran = new Transition();
        return $tran->listDate(['entry_posting' => 1], ['order' => 'entry_num_prefix desc']);
    }

    /*
     * 列出固定资产
     */
    public static function listAssets()
    {
//        $tran = new Transition();
//        return $tran->listDate2([],['1601']);
    }

    /*
     * 列出无形资产
     */
    public static function listAssets2()
    {
//        $tran = new Transition();
//        return $tran->listDate2([],['1601']);
    }

    /*
     * 列出在建工程
     */
    public static function listAssets3()
    {
//        $tran = new Transition();
//        return $tran->listDate2([],['1601']);
    }

    /*
     * 列出长期待摊
     */
    public static function listAssets4()
    {
//        $tran = new Transition();
//        return $tran->listDate2([],['1601']);
    }

    /*
     * 是否有凭证
     */
    public static function hasTransition($date)
    {
        $sql = 'select `entry_num_prefix` from transition where `entry_num_prefix` = :date';
        $result = Yii::app()->db->createCommand($sql)->bindParam('date', $date)->queryAll();
        if ($result)
            return true;
        else
            return false;

    }

    public static function getTransitionDate()
    {
        $sql = 'select date from `transitiondate` ';
        $date = Yii::app()->db->createCommand($sql)->queryRow();
        if ($date['date'] != null)
            return $date['date'] . '01';
        else {
            $date = Condom::model()->getStartTime();
            $date = new DateTime($date . '01');
            $date->modify('last month');
            return $date->format('Ymd');
        }
    }

    /*
     * 账套日期
     */
    public static function getCondomDate()
    {
        $sql = 'select date from `condomdate` ';
        $date = Yii::app()->db->createCommand($sql)->queryRow();
        if (!empty($date['date']))
            return $date['date'] . '01';
        else {
            $date = Condom::model()->getStartTime();
            $date = new DateTime($date . '01');
//            $date->modify('last month');
            return $date->format('Ymd');
        }
    }

    /*
     * 添加凭证时，检查日期是否已经过账
     */
    public static function createCheckDate($date)
    {
        $tdate = self::transitionDate();
        if ($tdate != null) {
            $tdate = new DateTime($tdate . '01');
            $tdate->modify('+1 month');
        } else
            $tdate = new DateTime(Condom::model()->getStartTime() . '01');
        $date = new DateTime($date);
        if ($date >= $tdate)
            return true;
        else
            return false;
    }

    /*
     * 已经过账的日期，根据凭证表视图判断
     */
    public static function transitionDate()
    {
        $sql = 'select date from `transitiondate` ';
        $date = Yii::app()->db->createCommand($sql)->queryRow();
        return $date['date'];
    }

    public static function setReviewedMul($date, $type = 1)
    {
        $command = Yii::app()->db->createCommand();
        $tran = new Transition();
        if ($type == 1)
            $command->update($tran->tableName(), ['entry_reviewed' => 1, 'entry_reviewer' => Yii::app()->user->id],
                'entry_num_prefix=:date and ' .
                'entry_reviewed!=:reviewed and ' .
                'entry_creater!=:creator'
                ,
                [
                    ':date' => $date,
                    ':reviewed' => 0,
                    ':creator' => Yii::app()->user->id,
                ]);
        elseif ($type == 2)    //生成的结账凭证，审核人可以是创建人
            $command->update($tran->tableName(), ['entry_reviewed' => 1, 'entry_reviewer' => Yii::app()->user->id],
                'entry_num_prefix=:date',
                [
                    ':date' => $date,
                ]);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'transition';
    }

    /*
     * 是否已经审核
     */
    public static function checkReviewed($id, $type)
    {
        if ($id == "" || $id == "0")
            return false;
        $tran = Transition::model()->findByAttributes(['data_id' => $id, 'data_type' => $type]);
        if (!empty($tran) && $tran->entry_reviewed == 1)
            return true;
        else
            return false;
    }

    /*
     * 初始数据
     */
    public static function getSheetData($items = [], $type)
    {
        $starttime = Condom::model()->getStartTime();
        $arr = Transition::$input_arr;
        $arr['entry_date'] = $starttime;
        if (is_array($items)) {
            $arr = array_merge($arr, $items);
            if (isset($items['A']) || isset($items['B'])) { //未严格限制必须某一列必须有数据才可
                $excel = range('A', 'I');
                foreach ($excel as $item) {
                    if (!isset($items[$item]))
                        $items[$item] = '';
                }

                switch ($type) {
                    case 'bank':
                    case 'cash':
                        $arr['target'] = trim($items['A']);
                        if (User2::checkVIP()) {
                            $arr['entry_date'] = convertDate($items['B']);
                            $arr['entry_memo'] = trim($items['C']);
                            $amount = trim($items['D']) != '' ? $items['D'] : $items['E'];
                        } else {
                            $arr['entry_name'] = trim($items['B']);
                            $arr['entry_date'] = convertDate($items['C']);
                            $arr['entry_memo'] = trim($items['D']);
                            $amount = trim($items['E']) != '' ? $items['E'] : $items['F'];
                        }
                        break;
                    case 'purchase':
                        $arr['entry_date'] = convertDate($items['A']);
                        $arr['entry_memo'] = trim($items['B']);
                        $arr['entry_appendix_id'] = Vendor::model()->matchName(trim($items['C']));
                        $arr['entry_name'] = Stock::model()->matchName(trim($items['D']));
                        $arr['model'] = trim(isset($items['E']) ? $items['E'] : '');
                        $amount = trim(isset($items['F']) ? $items['F'] : '');
                        $arr['count'] = trim(isset($items['G']) ? $items['G'] : '');
                        $arr['department_id'] = Department::model()->matchName(trim(isset($items['H']) ? $items['H'] : ''));
                        break;
                    case 'product':
                        $arr['entry_date'] = convertDate($items['A']);
                        $arr['realorder'] = trim($items['B']);
                        $arr['entry_memo'] = trim($items['C']);
                        $arr['entry_appendix_id'] = Client::model()->matchName(trim($items['D']));
                        $arr['entry_name'] = Stock::model()->matchName(trim($items['E']));
                        $amount = trim($items['F']);
                        $arr['count'] = trim($items['G']);
                        break;
                    case 'cost':    //成本结转
                        $arr['entry_date'] = convertDate($items['A'], 'Ymd');
                        $arr['entry_name'] = trim($items['B']);
                        $arr['model'] = trim($items['C']);
                        $arr['count'] = trim($items['D']);
                        $stock = Stock::model()->findAllByAttributes(['name' => $arr['entry_name'], 'model' => $arr['model']],
                            ['condition' => 'cost_date = "" or cost_date like "' . $arr['entry_date'] . '%"', 'order' => 'in_date']);
                        $amount = 0;
                        if (empty($stock))
                            return;
                        $count = $arr['count'] >= count($stock) ? count($stock) : count($stock) - $arr['count'];
                        foreach ($stock as $sto) {
                            if ($count > 0)
                                $amount += $sto['in_price'];
                            $count--;
                        }
                        $sbjname = Subjects::getName($sto['entry_subject']);
                        $arr['entry_subject'] = Subjects::model()->matchSubject($sbjname, [6401]);
                        $arr['entry_transaction'] = 1;
                        $arr['subject_2'] = $sto['entry_subject'];
//                        $arr['order_no'] = trim($items['A']);
//                        $arr['entry_date'] = convertDate($items['B']);
//                        $arr['entry_name'] = trim($items['C']);
//                        $order = Product::model()->findByAttributes(['order_no'=>$arr['order_no']]);
//                        if($order!=null){
//                            $arr['entry_subject'] = Subjects::model()->matchSubject('材料',[6401]);
//                            $arr['client_id'] = $order->client_id;
//                        }
//                        $arr['entry_transaction'] = 1;
//                        $arr['stocks'] = '';
//                        $arr['stocks_count'] = '';
//                        $arr['stocks_price'] = '';
//                        $amount = 0;
//                        $stocks = [];
//                        $subject_2 = [];
//                        $stocks_count = [];
//                        $stocks_price = [];
//                        foreach(range('D', 'Z', 2) as $key){
//                            if($items[$key]==null)
//                                break;
//                            $item = $items[$key];
//                            $stocks[] = $item;
//                            $price = Stock::model()->getPrice($item);
//                            $stocks_price[] = $price;
//                            //根据商品，判断购买时的采购用途，库存商品/材料、库存商品/耐用等，对subject_2和金额进行赋值
//                            $stock = Stock::model()->matchStock($item, 1405);
//                            $sbj = $stock->entry_subject;
//                            $item = $items[++$key];
//                            $stocks_count[] = $item;
//                            $amount += $price*$item;
//                            $subject_2[$sbj] = isset($subject_2[$sbj])?$subject_2[$sbj]+$price*$item:$price*$item;
//                        }
//                        $arr['subject_2'] = implode(',', array_keys($subject_2));
//                        $arr['subject_2_price'] = implode(',',$subject_2);
//                        $arr['stocks'] = implode("\r\n",$stocks);
//                        $arr['stocks_count'] = implode("\r\n",$stocks_count);
//                        $arr['stocks_price'] = implode("\r\n",$stocks_price);
                        break;
                    case 'salary':
                        $date = convertDate($items['D'], 'Ymd');
                        $arr['entry_date'] = strlen($date) > 6 ? $date : $date . '01';
                        $arr['employee_name'] = trim($items['B']);
                        $employee = Employee::model()->findByAttributes(['name' => $arr['employee_name']]);
                        $employee_id = $employee ? $employee->id : 0;
                        $arr['department_name'] = Department::model()->getName(Employee::model()->getDepart($employee_id));
                        $arr['salary_amount'] = round2(str_replace(",", "", trim($items['E'])));
                        $arr['bonus_amount'] = round2(str_replace(",", "", trim($items['F'])));
                        $arr['benefit_amount'] = round2(str_replace(",", "", trim($items['G'])));
                        $payment = $arr['salary_amount'] + $arr['bonus_amount'] + $arr['benefit_amount'];
                        $arr['base_amount'] = round2($employee->base);
                        $arr['base_2_amount'] = round2($employee->base_2);
                        $arr['social_personal'] = round2(ceil($employee->base * 10.5 / 10) / 10); //有分，直接进角
                        $arr['provident_personal'] = round2(ceil($employee->base_2 * 7 / 100));   //有角，直接进分
                        $arr['before_tax'] = round2($payment - $arr['social_personal'] - $arr['provident_personal']);
                        $arr['personal_tax'] = round2(Employee::getPersonalTax($arr['before_tax']));
                        $arr['after_tax'] = round2($arr['before_tax'] - $arr['personal_tax']);
                        $arr['social_company'] = round2(ceil($employee->base * 35 / 10) / 10);
                        $arr['provident_company'] = round2(ceil($employee->base_2 * 7 / 100));
                        //根据员工部门判断属于什么费用
                        $arr['entry_subject'] = Department::matchSubject($employee->department_id, '工资');
                        //查看是否已经导入过该月工资
                        $salary = Salary::model()->findByAttributes(['employee_id' => $employee->id, 'entry_date' => $arr['entry_date']]);
                        if ($salary)
                            $arr['error'][] = '已经导入过该月工资';
                        $amount = $payment;
                        break;
                    case 'reimburse':
                        $date = convertDate($items['B'], 'Ymd');
                        $arr['entry_date'] = strlen($date) > 6 ? $date : $date . '01';
                        $arr['entry_memo'] = trim($items['C']);
                        $arr['employee_name'] = trim($items['A']);
                        $employee = Employee::model()->findByAttributes(['name' => $arr['employee_name']]);
                        $employee_id = $employee ? $employee->id : 0;
                        $arr['department_name'] = Department::model()->getName(Employee::model()->getDepart($employee_id));
                        $arr['travel_amount'] = str_replace(",", "", trim($items['D']));
                        $arr['benefit_amount'] = str_replace(",", "", trim($items['E']));
                        $arr['traffic_amount'] = str_replace(",", "", trim($items['F']));
                        $arr['phone_amount'] = str_replace(",", "", trim($items['G']));
                        $arr['entertainment_amount'] = str_replace(",", "", trim($items['H']));
                        $arr['office_amount'] = str_replace(",", "", trim($items['I']));
                        $arr['rent_amount'] = str_replace(",", "", trim($items['J']));
                        $arr['watere_amount'] = str_replace(",", "", trim($items['K']));
                        $arr['train_amount'] = str_replace(",", "", trim($items['L']));
                        $arr['service_amount'] = str_replace(",", "", trim($items['M']));
                        $arr['stamping_amount'] = str_replace(",", "", trim($items['N']));
                        $total = 0;
                        foreach ($arr as $key => $item) {
                            if (substr($key, -7) == '_amount')
                                $total += $item;
                        }
                        //根据员工部门判断属于什么费用
                        $arr['entry_subject'] = Department::matchSubject($employee->department_id, '工资');
                        $amount = $total;
                        break;

                }
                $amount = str_replace(" ", '', $amount);  //英文空格
                $amount = str_replace(" ", '', $amount);  //可能是中文或英文全角空格
                $arr['entry_amount'] = str_replace(",", "", trim($amount));
                $arr['price'] = str_replace(",", "", trim($amount));
            } else {
                foreach ($items as $key => $item) {
                    if (!is_array($item)) {
                        $arr[$key] = trim($item);
                        if ($key == 'entry_amount')
                            $arr[$key] = str_replace(",", "", trim($item));
                        if ($key == 'entry_date')
                            $arr[$key] = convertDate($item);
                    }
                }
                $arr['entry_name'] = isset($items['name']) ? $items['name'] : (isset($items['entry_name']) ? $items['entry_name'] : '');
                $arr['target'] = isset($items['target']) ? $items['target'] : $arr['entry_name'];
                $arr['entry_date'] = isset($items['date']) ? $items['date'] : (isset($items['entry_date']) ? $items['entry_date'] : $arr['entry_date']);
                $arr['entry_memo'] = isset($items['memo']) ? $items['memo'] : $arr['entry_memo'];
                $arr['realorder'] = isset($items['realorder']) ? $items['realorder'] : '';
                $arr['entry_amount'] = str_replace(",", "", trim(isset($items['amount']) ? $items['amount'] : $arr['entry_amount']));
                $arr['entry_subject'] = isset($items['subject']) ? $items['subject'] : $arr['entry_subject'];
                if (!empty($items['client_id']))
                    $arr['entry_appendix_id'] = $items['client_id'];
                if (!empty($items['vendor_id']))
                    $arr['entry_appendix_id'] = $items['vendor_id'];
                if (!empty($items['employee_id'])) {
                    $employee = Employee::model()->findByPk($items['employee_id']);
                    $arr['employee_name'] = Employee::getName($items['employee_id']);
                    $arr['department_name'] = Employee::model()->getDepart($items['employee_id'], 'name');
                    $arr['base_amount'] = $employee->base;
                    $arr['base_2_amount'] = $employee->base_2;
                    $arr['entry_subject'] = Department::matchSubject($employee->department_id, '工资');
                }
            }
        }
        return $arr;
    }

    public static function getSheetDataFromImage($data, $conf)
    {
        $arr = [];
        foreach ($data as $key => $item) {
            $rowsData = json_decode($item);
            if ($rowsData->errNum == '0') {   //匹配成功
                $rows = $rowsData->retData;
                if ($conf[0] == true)      //第一行不需要，直接跳过
                    array_shift($rows);
                foreach ($rows as $row => $api) {
                    if (empty($arr[$row]))
                        $arr[$row] = Transition::$input_arr;
                    switch ($conf[1][$key]) {
                        case 'target_name':
                            $arr[$row]['target'] = $api->word;
                            break;
                        case 'memo':
                            $arr[$row]['entry_memo'] = $api->word;
                            break;
                        case 'name':
                            $arr[$row]['entry_name'] = $api->word;
                            break;
                        case 'date':
                            $arr[$row]['entry_date'] = $api->word;
                            break;
                        case 'amount':
                            $arr[$row]['entry_amount'] = $api->word;
                            break;
                        default:
                            break;
                    }

                }

            } else {

            }
        }
        return $arr;
    }

    public function listByPrefix($prefix, $select)
    {
        $sql = "select id," . $select . " from transition where entry_num_prefix=" . $prefix;
        $data = $this->findAllBySql($sql, array());
        return $data;
    }

    public function transaction($action)
    {
        return $action == 1 ? "借" : "贷";
    }

    public function getTrandate($prefix, $day)
    {
        return substr($prefix, 0, 4) . '年' . substr($prefix, 4, 6) . '月' . $day . '日';
    }

    public function getPosting($posting)
    {
        return $posting == 1 ? '已过账' : '未过账';
    }

    /*
     * 附加信息
     */
    public function getAppendix($type, $id)
    {
        $str = "";
        switch ($type) {
            case 1 :    //vendor
                $model = Vendor::model()->findByPk($id);
                $str = $model ? $model->company : "";
                break;
            case 2 :    //client
                $model = Client::model()->findByPk($id);
                $str = $model ? $model->company : "";
                break;
            case 3 :    //employee
                $model = Employee::model()->findByPk($id);
                $str = $model ? $model->name : "";
                break;
            case 4 :    //project
                $model = Project::model()->findByPk($id);
                $str = $model ? $model->name : "";
                break;
            default:
                break;
        }
        return $str;
    }

    /*
     * admin页面不同状态不同颜色
     * $var row
     * $var reviewed
     * $var deleted
     * @return css class name
     */
    public function getClass($row, $reviewed, $deleted)
    {
        $class = $row % 2 == 1 ? "row-odd" : 'row-even';
        if ($deleted == 1)
            $class = "row-deleted";
        elseif ($reviewed == 1)
            $class = "row-reviewed";
        return $class;
    }

    /*
     * transaction 借贷
     */
    public function check_entry_amount($attribute, $params)
    {
//        $this->
        $sum = 0;
//        Yii::app()->user->setFlash('sucess', 'asdf;ljasdl');
        if (isset($_POST['Transition']))
            foreach ($_POST['Transition'] as $item) {
                if (isset($item['entry_memo']) && trim($item['entry_memo']) != "") {
                    if ($item['entry_transaction'] == "1")
                        $sum += $item['entry_amount'];
                    else {
                        $a = doubleval($item['entry_amount']);
                        $sum = $sum - $a;
                    }
                }
            }
        if (abs($sum) > 0.00001)
            $this->addError($attribute, '借贷必须相等');
        if (isset($_POST['Transition']))
            if ($this->$attribute == 0)
                $this->addError($attribute, '金额不能为0.00');
    }

    public function check_entry_memo($attribute, $params)
    {
        foreach ($_POST['Transition'] as $item) {
            if (isset($item['entry_memo']))
                if (trim($item['entry_memo']) == "结转凭证") {
                    $this->addError($attribute, '摘要不能为 “结转凭证”');
                    break;
                }
        }
    }

    /*
     * 检查凭证是否已经审核过
     * @id Integer Bank表 或 Cash表 的ID，不是transition表
     */
    public function isAllReviewed($date)
    {
        $this->unsetAttributes();
        $this->entry_reviewed = 0;
        $this->entry_num_prefix = $date;
        $this->select = "entry_num_prefix,entry_num,entry_reviewer";
        $dataProvider = $this->search();
        $transtion = $dataProvider->getData();
        return empty($transtion);
    }

    public function setPosted($bool = 1)
    {
        return Transition::model()->updateAll(array('entry_posting' => $bool),
            'entry_num_prefix=:prefix',
            array(':prefix' => $this->entry_num_prefix));
    }

    /**
     * 检测是否需要整理凭证
     * 1: 已经整理, 0:有凭证未整理
     **/
    public function isReorganised($date)
    {
        $this->unsetAttributes();
        $this->entry_deleted = 1;
        $this->entry_num_prefix = $date;
        $this->select = "entry_num_prefix,entry_num";
        $dataProvider = $this->search();
        $transtion = $dataProvider->getData();
        return empty($transtion);
    }

    //是否有过结账操作
    public function isPosted($date)
    {
        $this->unsetAttributes();
        $this->entry_posting = 1;
        $this->entry_num_prefix = $date;
        $this->select = "entry_num_prefix,entry_num,entry_posting";
        $dataProvider = $this->search();
        $transition = $dataProvider->getData();
        return empty($transition);
    }

    public function tranSettlement($date)
    {
        $list1 = Transition::model()->findByAttributes(array('entry_num_prefix' => $date, 'entry_closing' => 1));
        if (!empty($list1))
            return true;
        else
            return false;
    }

    /*
     * 结转操作凭证
     * 结转时，如果是当年12月，多生成一条凭证，借本年利润，贷利润分配/未分配利润；
     */
    public function settlement($entry_prefix)
    {

        $this->reorganise($entry_prefix); //结账前先整理
        $entry_num = $this->tranSuffix($entry_prefix);
        $entry_memo = '结转凭证';
        $entry_creater = Yii::app()->user->id;
        $entry_editor = Yii::app()->user->id;
        $entry_reviewer = 0;
        $entry_settlement = 1;
        $arr = Subjects::model()->actionListFirst();
        $sum = 0;
        $amount = 0;
        $hasData = false;
        $year = getYear($entry_prefix);
        $month = getMon($entry_prefix);
        $day = date('t', strtotime("01.$month.$year"));
        $date = "$year-$month-$day 23:59:59";
        $date = date('Y-m-d H:i:s', strtotime($date));
        //企业所得税按季度计提
        //还需要生成企业所得税凭证
        if ($month == '03' || $month == '06' || $month == '09' || $month == '12') {
            //根据损益表，3个月的本期净利润，
            $profit = new Profit();
            if ($month == '03') {
                $profit->date = $entry_prefix;  //日期有可能需要多少号
                $data = $profit->genProfitData();
                $amount = $data['net_profit']['sum_year'];
            } else {
                $profit->date = $entry_prefix;
                $data = $profit->genProfitData();

                $lastdate = '0' . (intval($month) - 3);    //上一个季度的利润
                $profit->date = $lastdate;
                $data1 = $profit->genProfitData();
                $amount = $data['net_profit']['sum_year'] - $data1['net_profit']['sum_year'];
            }

            if ($amount > 0) {    //利润大于0才需要交企业所得税
                $option = Options::model()->findByAttributes([], 'entry_subject regexp "^6801"');
                if ($option != null)
                    $amount = $amount * $option->value / 100;
                else
                    $amount = $amount * 0.25;   //企业所得税税率默认25%；
                $tran = new Transition();
                $tran->entry_num_prefix = $entry_prefix;
                $tran->entry_num = $entry_num;
                $tran->entry_memo = '企业所得税';
                $tran->entry_date = $date;
                $tran->entry_transaction = 1;
                $tran->entry_creater = $entry_creater;
                $tran->entry_editor = $entry_editor;
                $tran->entry_settlement = $entry_settlement;
                $tran->entry_reviewer = $entry_reviewer;
                $tran->entry_subject = '6801';              //本年利润
                $tran->entry_amount = $amount;

                $tran2 = clone $tran;
                $tran->save();

                $tran2->entry_num = $entry_num;

                $tran2->entry_transaction = 2;
                $tran2->entry_subject = Subjects::matchSubject('企业所得税', '2221');
                $tran2->save();
            }
        }
        $profit = new Profit();
        if ($month == '01') {
            $profit->date = $entry_prefix;  //日期有可能需要多少号
            $data = $profit->genProfitData();
            $amount = $data['net_profit']['sum_year'];
        } else {
            $profit->date = $entry_prefix;
            $data = $profit->genProfitData();

            $lastdate = '0' . intval($month) - 1;    //上一个季度的利润
            $profit->date = $lastdate;
            $data1 = $profit->genProfitData();
            $amount = $data['net_profit']['sum_year'] - $data1['net_profit']['sum_year'];
        }

        //结转凭证

        $amount = 0;
        $entry_num++;
        foreach ($arr as $sub) {
            $tran = new Transition();
            $tran->entry_num_prefix = $entry_prefix;
            $tran->entry_num = $entry_num;
            $tran->entry_date = $date;
            $tran->entry_settlement = $entry_settlement;
            $tran->entry_memo = $entry_memo;
            $tran->entry_transaction = $sub['sbj_cat'] == '4' ? 1 : 2;    //4：收入类 借 5费用类 贷
            $tran->entry_creater = $entry_creater;
            $tran->entry_editor = $entry_editor;
            $tran->entry_reviewer = $entry_reviewer;
            $tran->entry_subject = $sub['id'];
            $amount = $this->getEntry_amount($entry_prefix, $sub['id']);
            $amount = $sub['sbj_cat'] == '4' ? -$amount : $amount;
            $tran->entry_amount = $amount;
            $sum = $sub['sbj_cat'] == '4' ? $sum + $amount : $sum - $amount;     //该科目合计多少
//          $trans[] = $tran;
            if ($amount != 0) {
                $tran->save();
                $hasData = true;
            }
        }
        if ($hasData > 0) {
            $tran = new Transition();
            $tran->entry_num_prefix = $entry_prefix;
            $tran->entry_num = $entry_num;
            $tran->entry_memo = $entry_memo;
            $tran->entry_date = $date;
            $tran->entry_transaction = 2;    //本年利润 为贷
            $tran->entry_creater = $entry_creater;
            $tran->entry_editor = $entry_editor;
            $tran->entry_settlement = $entry_settlement;
            $tran->entry_reviewer = $entry_reviewer;
            $tran->entry_subject = '4103';              //本年利润
            $tran->entry_amount = $sum;
            $tran->save();
            //如果是12月，将本年利润过到，未分配利润下
            if (substr($entry_prefix, 4, 6) == '12')
                $tran->passProfit();
        }


//        if ($sum == 0)
        $tran->setForward(1);
    }

    /*
     * 整理凭证
     */
    public function reorganise($date)
    {
        $prefix = $date;
        Transition::model()->delData($prefix);
        $del_condition = 'entry_num_prefix=:prefix and entry_deleted=:bool';
        Transition::model()->deleteAll($del_condition, array(':prefix' => $prefix, ':bool' => 1));
        $sql = "select id,entry_num from transition where entry_num_prefix=:prefix order by entry_num ASC"; //从小到大排序
        $data = Transition::model()->findAllBySql($sql, array(':prefix' => $prefix));

        $num = 1;
        $i = 1;
        $last = 0;
        foreach ($data as $row) {
            if ($num == 1)
                $last = $row['entry_num'];

            if ($last != $row['entry_num']) {
                $i++;
            }
            $pk = $row['id'];
            Transition::model()->updateByPk($pk, array('entry_num' => $i));
            $last = $row['entry_num'];
            $num++;
        }
        OperatingRecords::insertLog(['msg' => '整理凭证：' . $prefix]);
    }

    public static function delData($prefix)
    {
        $arr = Transition::model()->findAllByAttributes(['entry_num_prefix' => $prefix, 'entry_deleted' => 1]);
        if (!empty($arr)) {
            foreach ($arr as $item) {
                if (isset($item['data_type']) && $item['data_type'] == 1)    //bank
                    Bank::model()->deleteAll('id=:id', [':id' => $item['data_id']]);
                if (isset($item['data_type']) && $item['data_type'] == 2)    //cash
                    Cash::model()->deleteAll('id=:id', [':id' => $item['data_id']]);
            }
        }
    }

    /*
     * 生成科目编号后缀编号
     */
    public function tranSuffix($prefix = "")
    {
        if ($prefix == "")
            $prefix = date("Ym", time());
        $data = Yii::app()->db->createCommand()
            ->select('max(a.entry_num) b')
            ->from('transition as a')
            ->where('entry_num_prefix="' . $prefix . '"')
            ->queryRow();
        if ($data['b'] == '')
            $data['b'] = 0;
        $num = $data['b'] + 1;
        $num = $this->AddZero($num); //数字补0
        return $num;
    }

    /*
     * 本年利润过度到未分配利润
     * 借本年利润，贷利润分配/未分配利润；
     */
    public function passProfit()
    {
        $entry_prefix = $this->entry_num_prefix;
        $entry_num = $this->tranSuffix($entry_prefix);
        $tran = $this;
        $tran->entry_num = $entry_num;
        $tran->entry_memo = '结转本年利润到未分配利润';
        $tran1 = new Transition();
        $tran2 = new Transition();
        $tran1->attributes = $tran->attributes;
        $tran2->attributes = $tran->attributes;
        $tran1->entry_transaction = 1;
        $tran2->entry_transaction = 2;
        $tran1->entry_subject = '4103';
        $tran2->entry_subject = Subjects::matchSubject('未分配利润', '4104');
        if ($tran1->save() and $tran2->save()) {

        }

    }

    /*
     * 补全4位
     */
    public function addZero($num)
    {
        return substr(strval($num + 10000), 1, 4);
    }

    public function getEntry_amount($prefix, $sub_id)
    {
        $sql = "SELECT sum( case when entry_transaction = 1 then entry_amount else -entry_amount end) amount FROM `transition` WHERE entry_num_prefix='$prefix' and entry_subject='$sub_id'";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        if (isset($data[0]['amount']))
            return $data[0]['amount'];
        else
            return 0;
    }

    public function setForward($bool = 1)
    {
        return Transition::model()->updateAll(array('entry_forward' => $bool),
            'entry_num_prefix=:prefix',
            array(':prefix' => $this->entry_num_prefix));
    }

    public function setClosing($bool = 1)
    {
        return Transition::model()->updateAll(array('entry_closing' => $bool),
            'entry_num_prefix=:prefix',
            array(':prefix' => $this->entry_num_prefix));
    }

    /**
     * 列出科目
     */
    public function listSubjects($type = '')
    {
        if ($type == '')
            $sql = "select * from subjects where has_sub=0 order by concat(`sbj_number`) asc"; //
        elseif ($type == 'all')
            $sql = "select * from subjects order by concat(`sbj_number`) asc"; //
        $First = Subjects::model()->findAllBySql($sql);
        $arr = array();
        foreach ($First as $row) {
            $arr += array($row['sbj_number'] => $row['sbj_number'] . Subjects::getSbjPath($row['sbj_number']));
        };
        return $arr;
    }

    /*
     * 列出科目，以分组的形式
     * 默认 def 去除了银行部分？
     */
    public function listSubjectsGrouped($def = 'def')
    {
        if ($def == 'def') {
            $sel = "select * from subjects where has_sub=0 and sbj_number not like '1001%' and sbj_number not like '1002%' ";
        } else {
            $sel = "select * from subjects where has_sub=0 ";
        }

        $order = " order by concat(`sbj_number`) asc"; //
        $sbj_cat = 1;
        $arr = array();
        while ($sbj_cat < 6) {
            $sql = $sel . "and sbj_cat=" . $sbj_cat . $order;
            $subjects = Subjects::model()->findAllBySql($sql);
            $arr[Subjects::getCatName($sbj_cat)] = [];
            foreach ($subjects as $row) {
                $arr[Subjects::getCatName($sbj_cat)] += [$row['sbj_number'] => $row['sbj_number'] . Subjects::getSbjPath($row['sbj_number'])];
            };
            $sbj_cat++;
        }
        return $arr;
    }


    public function hasSettlement($date)
    {
        $list1 = Transition::model()->findByAttributes(array('entry_num_prefix' => $date, 'entry_closing' => 1));
        $list2 = Transition::model()->findByAttributes(array('entry_num_prefix' => $date, 'entry_settlement' => 1));
        if ($list1 || $list2)
            return true;
        else
            return false;
    }

    public function hasData()
    {
        $sql = 'select distinct  extract(YEAR from `entry_date`) as `entry_date` from transition';
        $years = Transition::model()->findAllBySql($sql);
        $arr = array();
        foreach ($years as $year) {
            $arr[] = $year['entry_date'];
        }
        return $arr;
    }

    /*
     * 有凭证数据的年份
     */
    public function hasTransitionYears()
    {
        $sql = 'select year(`entry_date`) as year from `transition` group by year(`entry_date`)';
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $array = array();
        foreach ($result as $item) {
            $array[$item['year']] = $item['year'];
        }
        return $array;
    }

    /*
     * 设置通过审核
     */
    public function setReviewed()
    {
        if ($this->reviewAccess()) {
            $this->entry_reviewed = 1;
            $this->entry_reviewer = Yii::app()->user->id;
            if ($this->save())
                return true;
        } else
            return false;
    }

    /*
     * 检查是否可以审核
     */
    public function reviewAccess()
    {
        if ($this->entry_creater == Yii::app()->user->id)  //录入人和审核人不能为同一人
            return false;
        if ($this->entry_posting == 1) //已经过账不能审核
            return false;
        if ($this->entry_closing == 1) //已经结账不能审核
            return false;
        return true;
    }

    /*
     * 设置取消审核
     */
    public function unReviewed()
    {
        if ($this->unreviewAccess()) {
            $this->entry_reviewed = 0;
            $this->entry_reviewer = 0;
            $this->save();
        }
    }


    /*
     * 检查是否可以取消审核
     */
    public function unreviewAccess()
    {
        if ($this->entry_posting == 1) //已经过账不能取消审核
            return false;
        if ($this->entry_closing == 1) //已经结账不能取消审核
            return false;
        return true;
    }

    public function transitions()
    {
        $sql = 'select * from ';
    }

    /*
     * 修改科目凭证科目为父科目
     */
    public static function updateSubject($sbj, $sbj2)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('entry_subject=' . $sbj);
        $rows = Transition::model()->updateAll(['entry_subject' => $sbj2], $criteria);
    }

    /*
     * 税率
     */
    public static function getTaxArray($type = 'sale')
    {
        $dbname = substr(SYSDB, 8);
        $condom = Condom::model()->findByAttributes(["dbname" => $dbname]);
        if ($condom->taxpayer_t == 2) {//小规模纳税人
            if ($type == 'sale') {
                return [
                    '3' => '3%' . Yii::t('import', '增值税发票'),
                    '5' => '5%' . Yii::t('import', '营业税发票'),
                ];
            } elseif ($type == 'purchase') {
                return [
                    '0' => Yii::t('import', '其他发票'),
                ];
            }

        } else {  //一般纳税人
            if ($type == 'sale') {
                return [
//                    '3'=>'3%'.Yii::t('import', '增值税发票'),
                    '5' => '5%' . Yii::t('import', '营业税发票'),
                    '6' => '6%' . Yii::t('import', '增值税发票'),
                    '13' => '13%' . Yii::t('import', '增值税发票'),
                    '17' => '17%' . Yii::t('import', '增值税发票'),
                ];
            } elseif ($type == 'purchase') {
                return [
                    '3' => '3%' . Yii::t('import', '增值税专用发票'),
                    '6' => '6%' . Yii::t('import', '增值税专用发票'),
                    '13' => '13%' . Yii::t('import', '增值税专用发票'),
                    '17' => '17%' . Yii::t('import', '增值税专用发票'),
                    '0' => Yii::t('import', '其他发票'),
                ];
            }
        }

    }

    /*
     * 科目数组
     */
    public static function getSubjectArray($arr, $options = [])
    {
        $subject = new Subjects();
//        ['reject' => ['工资', '社保', '公积金', '折旧费', '研发费'],'prefix'=>'_'
        if (empty($options))
            $options = ['reject' => [
                Yii::t('import', '工资'),
                Yii::t('import', '社保'),
                Yii::t('import', '公积金'),
                Yii::t('import', '折旧费'),
                Yii::t('import', '研发费')], 'prefix' => '_'];
        $result = $subject->getitem($arr, '', $options);
        return $result;
    }

    /*
     *
     */
    public static function getAllMount($sbj, $transaction, $type = '', $date = '')
    {
        $arr = Subjects::model()->get_sub($sbj, 2);
        $result = 0;
        foreach ($arr as $item) {
            $result += self::getMount($item['sbj_number'], $transaction, $type, $date);
        }
        return $result;
    }

    /*
     *
     */
    public static function getMount($sbj, $transaction, $type = '', $date = '')
    {
        $attributes = ['entry_subject' => $sbj, 'entry_transaction' => $transaction];
        $where = '1=1';
        if ($date == '')
            $date = date('Y') . '-01-01 00:00:00';
        if ($type == 'before')
            $where .= " and entry_date < '$date'";
        else
            $where .= " and entry_date >= '$date'";
        $models = Transition::model()->findAllByAttributes($attributes, $where);
        $mount = 0;
        if (!empty($models)) {
            foreach ($models as $item) {
                $mount += $item->entry_amount;
            }
            return $mount;
        } else
            return 0;
    }

    /*
     * 快速生成model，
     */
    public function copyModel($sbj, $amount = [])
    {
        foreach ($sbj as $key => $item) {
            $model = new Transition();
            $model->attributes = $this->attributes;
            $model->entry_subject = $item;
            if (isset($amount[$key]))
                $model->entry_amount = $amount[$key];
            $temp[] = $model;
        }
        return $temp;
    }

    /*
     * 生成附加税凭证
     */
    public static function createSurtax($date)
    {
        $tran1 = new Transition();
        $tran1->entry_num_prefix = $date;
        $tran1->entry_num = Transition::model()->tranSuffix($date);
        $tran1->entry_date = date('Y-m-d 00:00:00', strtotime($date . '01'));
        $date2 = substr($date, 0, 4) . '-' . substr($date, 4);
        $memo = "附加税-$date";
        $tran1->entry_name = $memo;
        $tran1->entry_memo = $memo;
        $tran1->entry_transaction = 1;
        $tran1->entry_subject = 6403;
        //根据企业类型，小规模纳税人或一般纳税人
        $old = Transition::model()->findByAttributes(['entry_memo' => $memo, 'entry_name' => $memo, 'entry_transaction' => 1]);
        $con = Condom::model()->findByAttributes(['dbname' => substr(SYSDB, 8)]);
        if ($con == null)
            throw new CException(404, '当前账套已不存在');
        $sbj2221 = Subjects::matchSubject('营业税', '2221');
        $command = Yii::app()->db->createCommand();
        $command->select('SUM(entry_amount) AS amount');
        $command->from($tran1->tableName());
        $command->where("entry_subject like '$sbj2221%' and entry_transaction = 2 and entry_date like '$date2%'");
        $amount2221 = $command->queryRow();
        $amount2221 = isset($amount2221['amount']) ? $amount2221['amount'] : 0;

        if ($con->taxpayer_t == 1) {  //一般纳税人
            //应交税费/营业税 贷方 + a(应交税费/增值税/销项-进项)，a<=0不计算，
            $sbjVat = Subjects::matchSubject('增值税', 2221);
            $sbjSal = Subjects::matchSubject('销项', $sbjVat);
            $sbjPur = Subjects::matchSubject('进项', $sbjVat);
            $command = Yii::app()->db->createCommand();
            $command->select('SUM(entry_amount) AS amount');
            $command->from($tran1->tableName());
            $command->where("entry_subject like '$sbjSal%' and entry_transaction = 2 and entry_date like '$date2%'");
            $amountSal = $command->queryRow();
            $amountSal = isset($amountSal['amount']) ? $amountSal['amount'] : 0;

            $command = Yii::app()->db->createCommand();
            $command->select('SUM(entry_amount) AS amount');
            $command->from($tran1->tableName());
            $command->where("entry_subject like '$sbjPur%' and entry_transaction = 1 and entry_date like '$date2%'");
            $amountPur = $command->queryRow();
            $amountPur = isset($amountPur['amount']) ? $amountPur['amount'] : 0;

            $amountVat = $amountSal - $amountPur;
            $base = $amountVat > 0 ? round2($amount2221 + $amountVat) : round2($amount2221);
        } elseif ($con->taxpayer_t == 2) { //小规模纳税人
            //应交税费/营业税 贷方 + a(应交税费/增值税 贷方)
            $sbjVat = Subjects::matchSubject('增值税', $sbj2221);
            $command = Yii::app()->db->createCommand();
            $command->select('SUM(entry_amount) AS amount');
            $command->from($tran1->tableName());
            $command->where("entry_subject like '$sbjVat%' and entry_transaction = 2 and entry_date like '$date2%'");
            $amountVat = $command->queryRow();
            $amountVat = isset($amountVat['amount']) ? $amountVat['amount'] : 0;

            $base = round2($amount2221 + $amountVat);
        }
        $sbjs[] = Subjects::matchSubject('城建税', 2221);
        $sbjs[] = Subjects::matchSubject('教育费附加', 2221);
        $sbjs[] = Subjects::matchSubject('地方教育费附加', 2221);
        $sbjs[] = Subjects::matchSubject('河道管理费', 2241);
        $taxAll = 0;
        foreach ($sbjs as $item) {
            $option = Options::model()->findByAttributes([], "entry_subject like '$item%'");
            $tax[] = $option;
            $taxAll += $option['value'];
        }
        $amount = round2($base * $taxAll / 100);
        //如果之前有附加税，且借方金额和现在的凭证相等，则不再重新计算附加税
        if ($old == null || $old['entry_amount'] != $amount) {
            Transition::model()->deleteAllByAttributes(['entry_memo' => $memo, 'entry_name' => $memo]);
            if ($amount > 0) {
                $tran1->entry_creater = Yii::app()->user->id;
                $tran1->entry_editor = Yii::app()->user->id;
                $tran1->entry_reviewed = 1;
                $tran1->entry_reviewer = 1;
                $amount = 0;
                foreach ($tax as $item) {
                    $tran = new Transition();
                    $tran->attributes = $tran1->attributes;
                    $tran->entry_transaction = 2;
                    $tran->entry_subject = $item['entry_subject'];
                    $tran->entry_amount = round2($base * $item['value'] / 100);
                    if ($tran->entry_amount > 0) {
                        $tran->save();
                        $amount += $tran->entry_amount;
                    }
                }
                $tran1->entry_amount = $amount;
                $tran1->save();
            }
        }
    }
}
