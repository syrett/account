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
 * @property integer $entry_posting
 * @property integer $entry_settlement
 * @property integer $entry_closing
 */
class Transition extends CActiveRecord
{
    /*
     * custom params
     */
    public $check_entry_amount = 0; //是否验证过借贷相等 优化处理 待改进
    public $entry_number; //  entry_num_prefix. entry_num     完整凭证编号，供凭证管理、排序搜索使用
    public $entry_time;
    public $select; // search的时候，定义返回字段

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

        $criteria = new CDbCriteria;
        if (isset($_REQUEST['s_day']) && $_REQUEST['s_day'] != "") {
            $a = date('Y-m-d 00:00:01', strtotime($_REQUEST['s_day']));
            $criteria->addCondition('t.entry_date>="' . $a . '"', 'AND');
        }
        if (isset($_REQUEST['e_day']) && $_REQUEST['e_day'] != "") {
            $a = date('Y-m-d 23:59:59', strtotime($_REQUEST['e_day']));
            $criteria->addCondition('t.entry_date<="' . $a . '"', 'AND');
        }
        $criteria->compare('id', $this->id);
        $criteria->compare('entry_num_prefix', $this->entry_num_prefix, true);
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
        $criteria->compare('entry_closing', $this->entry_closing);

        if ($this->select != null)
            $criteria->select = $this->select;
//        $criteria->compare('entry_number',$this->entry_num_prefix, true);

        $sort = new CSort();
        $sort->attributes = array(
            'entry_number' => array(
                'asc' => ' entry_num_prefix asc ,entry_num  ASC',
                'desc' => 'entry_num_prefix desc , entry_num  DESC'
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
    public static function listDate($arr=array())
    {
        $criteria = new CDbCriteria(array('group' => 'entry_num_prefix'));
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
        return $tran->listDate(array('entry_closing' => 0));
    }

    /*
     * 可反结账日期
     */
    public static function listAntiSettlement()
    {
        $tran = new Transition();
        return $tran->listDate(array('entry_posting' => 1));
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
        if (!empty($date['date']))
            return $date['date'];
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
            return $date['date'];
        else {
            $date = Condom::model()->getStartTime();
            $date = new DateTime($date . '01');
            $date->modify('last month');
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

    public static function setReviewedMul($date,$type=1)
    {
        $command = Yii::app()->db->createCommand();
        $tran = new Transition();
        if($type==1)
        $command->update($tran->tableName(), ['entry_reviewed' => 1, 'entry_reviewer' => Yii::app()->user->id],
                'entry_num_prefix=:date and '.
                'entry_reviewed!=:reviewed and '.
                'entry_creater!=:creator'
            ,
            [
                ':date' => $date,
                ':reviewed' => 0,
                ':creator' => Yii::app()->user->id,
            ]);
        elseif($type==2)    //生成的结账凭证，审核人可以是创建人
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
    public static function checkReviewed($id)
    {
        if ($id == "" || $id == "0")
            return false;
        $tran = Transition::model()->findByAttributes(['data_id' => $id]);
        if (!empty($tran) && $tran->entry_reviewed == 1)
            return true;
        else
            return false;
    }

    /*
     * 初始数据
     */
    public static function getSheetData($items = [])
    {
        $arr = [
            "entry_name" => "",
            "entry_date" => "",
            "entry_memo" => "",
            "entry_amount" => "",
            "d_id" => "",
            "entry_subject" => "",
            "entry_transaction" => "",
            "invoice" => "0",
            "tax" => "0",
            "parent" => "",
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
            "entry_reviewed" => "0",
        ];
        if (is_array($items)) {
            $arr = array_merge($arr, $items);
            if (isset($items['B']) || isset($items['C'])) {
                $arr['entry_name'] = trim($items['A']);
                $arr['entry_date'] = convertDate($items['B']);
                $arr['entry_memo'] = trim($items['C']);

                $amount = trim($items['D']) != '' ? $items['D'] : $items['E'];
                $amount = str_replace(" ", '', $amount);  //英文空格
                $amount = str_replace(" ", '', $amount);  //可能是中文或英文全角空格
                $arr['entry_amount'] = str_replace(",", "", trim($amount));
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
                $arr['entry_name'] = isset($items['target']) ? $items['target'] : $arr['entry_name'];
                $arr['entry_date'] = isset($items['date']) ? $items['date'] : $arr['entry_date'];
                $arr['entry_memo'] = isset($items['memo']) ? $items['memo'] : $arr['entry_memo'];
                $arr['entry_amount'] = str_replace(",", "", trim(isset($items['amount']) ? $items['amount'] : $arr['entry_amount']));
                $arr['entry_subject'] = isset($items['subject']) ? $items['subject'] : $arr['entry_subject'];
            }
        }
        return $arr;


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
            entry_deleted, entry_reviewed, entry_posting, entry_closing, entry_settlement', 'safe', 'on' => 'search'),
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
            'entry_num_prefix' => '凭证前缀',
            'entry_num' => '凭证号',
            'entry_time' => '录入时间',
            'entry_date' => '凭证日期',
            'entry_name' => '交易对象名称',
            'data_type' => '交易类型',
            'data_id' => '原数据ID',
            'entry_memo' => '凭证摘要',
            'entry_transaction' => '借贷',
            'entry_subject' => '借贷科目',
            'entry_amount' => '交易金额',
            'entry_appendix' => '附加信息',
            'entry_appendix_id' => '客户、供应商、员工、项目',
            'entry_creater' => '制单人员',
            'entry_editor' => '录入人员',
            'entry_reviewer' => '审核人员',
            'entry_deleted' => '凭证删除',
            'entry_reviewed' => '凭证审核',
            'entry_posting' => '过账',
            'entry_closing' => '结转',
            'entry_settlement' => '结转凭证',
            'entry_number' => '凭证编号',
        );
    }

    public function listByPrefix($prefix, $select)
    {
        $sql = "select " . $select . " from transition where entry_num_prefix=" . $prefix;
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
        $hasDate = false;
        $year = getYear($entry_prefix);
        $month = getMon($entry_prefix);
        $day = date('t', strtotime("01.$month.$year"));
        $date = "$year-$month-$day 23:59:59";
        $date = date('Y-m-d H:i:s', strtotime($date));
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
            $tran->entry_amount = $this->getEntry_amount($entry_prefix, $sub['id']);
            $sum = $sub['sbj_cat'] == '4' ? $sum + $amount : $sum - $amount;     //该科目合计多少
//          $trans[] = $tran;
            if ($amount != 0) {
                $tran->save();
                $hasDate = true;
            }
        }
        if ($hasDate > 0) {
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
        }
        if ($sum == 0)
            $tran->setClosing(1);
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
     * 补全4位
     */
    public function addZero($num)
    {
        return substr(strval($num + 10000), 1, 4);
    }

    public function getEntry_amount($prefix, $sub_id)
    {
        $sql = "SELECT sum(entry_amount) amount FROM `transition` WHERE entry_num_prefix='$prefix' and entry_subject='$sub_id'";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        if (isset($data[0]['amount']))
            return $data[0]['amount'];
        else
            return 0;
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
    public function listSubjects()
    {
        $sql = "select * from subjects where has_sub=0 order by concat(`sbj_number`) asc"; //
        $First = Subjects::model()->findAllBySql($sql);
        $arr = array();
        foreach ($First as $row) {
            $arr += array($row['sbj_number'] => $row['sbj_number'] . Subjects::getSbjPath($row['sbj_number']));
        };
        return $arr;
    }

    /*
     * 列出科目，以分组的形式
     */
    public function listSubjectsGrouped()
    {
        $sel = "select * from subjects where has_sub=0 ";
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
            if($this->save())
                return true;
        }else
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
    public static function updateSubject($sbj, $sbj2){
        $criteria = new CDbCriteria();
        $criteria->addCondition('entry_subject='. $sbj);
        $rows = Transition::model()->updateAll(['entry_subject' => $sbj2], $criteria);
    }

}
