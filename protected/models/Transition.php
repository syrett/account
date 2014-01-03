<?php

/**
 * This is the model class for table "transition".
 *
 * The followings are the available columns in table 'transition':
 * @property integer $id
 * @property string $entry_num_prefix
 * @property integer $entry_num
 * @property string $entry_day
 * @property string $entry_date
 * @property string $entry_memo
 * @property integer $entry_transaction
 * @property integer $entry_subject
 * @property integer $entry_amount
 * @property string $entry_appendix
 * @property integer $entry_appendix_type
 * @property integer $entry_appendix_id
 * @property integer $entry_editor
 * @property integer $entry_reviewer
 * @property integer $entry_deleted
 * @property integer $entry_reviewed
 * @property integer $entry_posting
 * @property integer $entry_settlement
 * @property integer $entry_closing
 */
class Transition extends MyActiveRecord
{
    /*
     * custom params
     */
    public $check_entry_amount = 0; //是否验证过借贷相等 优化处理 待改进
    public $entry_number; //  entry_num_prefix. entry_num     完整凭证编号，供凭证管理、排序搜索使用
    public $select; // search的时候，定义返回字段
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'transition';
    }


    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('entry_num, entry_transaction, entry_subject, entry_amount, entry_editor, entry_reviewer', 'required'),
            array('entry_num, entry_transaction, entry_subject, entry_amount, entry_editor, entry_reviewer, entry_deleted, entry_reviewed, entry_posting, entry_closing', 'numerical', 'integerOnly' => true),
            array('entry_num_prefix', 'length', 'max' => 10),
            array('entry_memo, entry_appendix', 'length', 'max' => 100),
            array('entry_appendix_id, entry_appendix_type, entry_date, entry_day', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, entry_number, entry_num_prefix, entry_num, entry_date, entry_day, entry_memo, entry_transaction, entry_subject, entry_amount, entry_appendix, entry_appendix_id, entry_appendix_type, entry_editor, entry_reviewer, entry_deleted, entry_reviewed, entry_posting, entry_closing, entry_settlement', 'safe', 'on' => 'search'),
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
            'entry_day' => '日',
            'entry_date' => '录入日期',
            'entry_memo' => '凭证摘要',
            'entry_transaction' => '借贷',
            'entry_subject' => '借贷科目',
            'entry_amount' => '交易金额',
            'entry_appendix' => '附加信息',
            'entry_appendix_id' => '客户、供应商、员工、项目',
            'entry_editor' => '录入人员',
            'entry_reviewer' => '审核人员',
            'entry_deleted' => '凭证删除',
            'entry_reviewed' => '凭证审核',
            'entry_posting' => '凭证过账',
            'entry_closing' => '结转',
            'entry_settlement' => '结转凭证',
            'entry_number' => '凭证编号'
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('entry_num_prefix', $this->entry_num_prefix, true);
        $criteria->compare('entry_num', $this->entry_num, true);
        $criteria->compare('entry_date', $this->entry_date, true);
        $criteria->compare('entry_day', $this->entry_day, true);
        $criteria->compare('entry_memo', $this->entry_memo, true);
        $criteria->compare('entry_transaction', $this->entry_transaction, true);
        $criteria->compare('entry_subject', $this->entry_subject, true);
        $criteria->compare('entry_amount', $this->entry_amount);
        $criteria->compare('entry_appendix', $this->entry_appendix, true);
        $criteria->compare('entry_editor', $this->entry_editor);
        $criteria->compare('entry_reviewer', $this->entry_reviewer);
        $criteria->compare('entry_deleted', $this->entry_deleted);
        $criteria->compare('entry_reviewed', $this->entry_reviewed);
        $criteria->compare('entry_posting', $this->entry_posting);
        $criteria->compare('entry_settlement', $this->entry_settlement);
        $criteria->compare('entry_closing', $this->entry_closing);

        if ($this->select != null)
          $criteria->select=$this->select;
//        $criteria->compare('entry_number',$this->entry_num_prefix, true);

        $sort = new CSort();
        $sort->attributes = array(
            'entry_number' => array(
                'asc' => 'entry_num_prefix,entry_num ASC',
                'desc' => 'entry_num_prefix, entry_num desc'
            ),
            '*', // this adds all of the other columns as sortable
        );

        /* Default Sort Order*/
        $sort->defaultOrder = array(
            'entry_number' => CSort::SORT_DESC,
        );

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>array(
                'pageVar'=>'p',
                'pageSize'=>'20',
            ),
            'sort' => $sort,
        ));
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

    /*
     * 补全4位
     */
    public function addZero($num)
    {
        return substr(strval($num + 10000), 1, 4);
    }

    /*
     * transaction 借贷
     */
    public function transaction($action)
    {
        return $action == 1 ? "借" : "贷";
    }

    /*
     * 科目表名称
     */
    public function getSbjName($id)
    {
        $model = Subjects::model()->findByAttributes(array('sbj_number' => $id));
        return $model->sbj_name;
    }

    /*
     * 科目表名称
     */
    public function getTrandate($prefix, $day)
    {
        return substr($prefix,0,4). '年'. substr($prefix,4,6). '月'. $day. '日';
    }


    /*
     * admin页面不同状态不同颜色
     * $var row
     * $var reviewed
     * $var deleted
     * @return css class name
     */
    public function getClass($row, $reviewed, $deleted){
        $class = $row%2==1 ? "row-odd" : 'row-even';
        if($deleted==1)
            $class = "row-deleted";
        elseif($reviewed==1)
            $class = "row-reviewed";
        return $class;
    }

    /*
     * 验证凭证借贷相等
     */
    public function check_entry_amount($attribute, $params)
    {
//        $this->
        $sum = 0;
//        Yii::app()->user->setFlash('sucess', 'asdf;ljasdl');
        foreach ($_POST['Transition'] as $item) {
            if (isset($item['entry_memo']) && trim($item['entry_memo']) != "")
                if ($item['entry_transaction'] == "1")
                    $sum += $item['entry_amount'];
                else
                    $sum -= $item['entry_amount'];
        }
        if ($sum != 0)
            $this->addError($attribute, '借贷必须相等');
    }

    /*
     * 验证凭证借贷相等
     */
    public function check_entry_memo($attribute, $params)
    {
        foreach ($_POST['Transition'] as $item) {
            if (isset($item['entry_memo']))
                if (trim($item['entry_memo']) == "结转凭证")
                {
                    $this->addError($attribute, '摘要不能为 “结转凭证”');
                    break;
                }
        }
    }

    /*
     * 返回凭证是否都已经被审核, attributes由实例传入 
     */
    public function isAllReviewed($date)
    {
      $this->unsetAttributes();
      $this->entry_reviewed=0;
      $this->entry_num_prefix=$date;
      $this->select="entry_num_prefix,entry_num,entry_reviewer";
      $dataProvider = $this->search();
      $transtion = $dataProvider->getData();
      return empty($transtion);
    }
    
    public function setPosted($bool=1)
    {
      Transition::model()->updateAll(array('entry_posting'=>$bool),
                                     'entry_num_prefix=:prefix',
                                     array(':prefix'=>$this->entry_num_prefix));
    }

    /*
     * 返回凭证是否都已经过账, attributes由实例传入
     */
    public function isAllPosted($date)
    {
        $this->unsetAttributes();
        $this->entry_posting=0;
        $this->entry_num_prefix=$date;
        $this->select="entry_num_prefix,entry_num,entry_posting";
        $dataProvider = $this->search();
        $transtion = $dataProvider->getData();
        return empty($transtion);
    }

    /*
     *
     */
    public static function confirmPosted($date){
        $a = Transition::model()->isAllReviewed($date);
        $b = Transition::model()->isAllPosted($date);
        if($a && $b)
            return true;
        else
            throw new CHttpException(400, $date. "还有凭证未过账或未审核");

    }

    /*
     * 结账日期
     * return $date
     */
    public static function checkSettlement($date = "")
    {
//        $jzpz = convert("结转凭证", )
        $Tran = new Transition();
        if ($date == Yii::app()->params['startDate'])
            return date('Ym', strtotime('+1 months', strtotime(Yii::app()->params['startDate'] . '01')));
        if ($date == "")
            $date = date('Ym', time());
        if (!$Tran->isAllPosted($date)) {
            Transition::model()->unsetAttributes();
            $data = Transition::model()->findByAttributes(array('entry_memo' => "结转凭证", 'entry_num_prefix' => $date));
            if ($data) {
//            if($date!=date('Ym', time()))   // strtotime format 07/28/2010
                $date = date('Ym', strtotime('+1 months', strtotime($date . '01'))); //当前月如果已经有结转凭证，那么当月无需结账，所以+1
                return $date;
            } else {
                $date = date('Ym', strtotime('-1 months', strtotime($date . '01'))); //当前月如果没有结转凭证，那么需要检查上一个月，所以-1
                return $Tran->checkSettlement($date);
            }
        }
        else
            return $date;
    }

    /*
     * 检查是否已经有结转凭证
     * return 1:有 0:无
     */
    public static function confirmSettlement($date)
    {        
        $Tran = new Transition();
        $Tran->unsetAttributes();
        $Tran->entry_memo='结转凭证';
        $Tran->entry_num_prefix=$date;
        $Tran->select="entry_num_prefix,entry_memo";
        $dataProvider = $Tran->search();
        $transtion = $dataProvider->getData();
        return empty($transtion);
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
            $arr += array($row['sbj_number'] => $row['sbj_number'] . $row['sbj_name']);
        };
        return $arr;
    }
}
