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
            array('entry_num, entry_transaction, entry_subject, entry_amount,entry_creater, entry_editor, entry_reviewer', 'required'),
            array('entry_num, entry_transaction, entry_subject,entry_creater, entry_editor, entry_reviewer, entry_deleted, entry_reviewed, entry_posting, entry_closing', 'numerical', 'integerOnly' => true),
            array('entry_amount', 'type', 'type' => 'float'),
            array('entry_num_prefix', 'length', 'max' => 10),
            array('entry_memo, entry_appendix', 'length', 'max' => 100),
            array('entry_appendix_id, entry_appendix_type, entry_date, entry_time', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
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
            'entry_time' => '日',
            'entry_date' => '凭证日期',
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
            'entry_time' => '录入时间',
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
        if(isset($_REQUEST['s_day']) && $_REQUEST['s_day']!="")
        {
            $a = date('Y-m-d H:i:s', strtotime($_REQUEST['s_day']));
            $criteria->addCondition('t.entry_date>="'.$a. '"' , 'AND');
        }
        if(isset($_REQUEST['e_day']) && $_REQUEST['e_day']!="")
        {
            $a = date('Y-m-d 23:59:59', strtotime($_REQUEST['e_day']));
            $criteria->addCondition('t.entry_date<="'.$a. '"' , 'AND');
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
          $criteria->select=$this->select;
//        $criteria->compare('entry_number',$this->entry_num_prefix, true);

        $sort = new CSort();
        $sort->attributes = array(
            'entry_number' => array(
                'asc' => 'entry_num , entry_num_prefix ASC',
                'desc' => 'entry_num ,entry_num_prefix DESC'
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
     * 科目表路径
     */
    public function getSbjPath($id)
    {
        $path = "";
        $path .= $this->getSbjName(substr($id,0,4));
        $length = strlen($id);
        $i = 6;
        while($i <= $length){
            $path .= '/'.$this->getSbjName(substr($id,0,$i));
            $i = $i + 2;
        }
        return $path;
    }
    /*
     * 年月日
     */
    public function getTrandate($prefix, $day)
    {
        return substr($prefix,0,4). '年'. substr($prefix,4,6). '月'. $day. '日';
    }

    /*
     * 过账
     */
    public function getPosting($posting)
    {
        return $posting==1?'已过账':'未过账';
    }
    /*
     * 附加信息名称
     */
    public function getAppendix($type, $id)
    {
        $str = "";
        switch($type){
            case 1 :    //vendor
                $model = Vendor::model()->findByPk($id);
                $str = $model?$model->company:"";
                break;
            case 2 :    //client
                $model = Client::model()->findByPk($id);
                $str = $model?$model->company:"";
                break;
            case 3 :    //employee
                $model = Employee::model()->findByPk($id);
                $str = $model?$model->name:"";
                break;
            case 4 :    //project
                $model = Project::model()->findByPk($id);
                $str = $model?$model->name:"";
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
    public function getClass($row, $reviewed, $deleted){
        $class = $row%2==1 ? "row-odd" : 'row-even';
        if($deleted==1)
            $class = "row-deleted";
        elseif($reviewed==1)
            $class = "row-reviewed";
        return $class;
    }

    /*
     * 验证凭证借贷相等  金额不能为0
     */
    public function check_entry_amount($attribute, $params)
    {
//        $this->
        $sum = 0;
//        Yii::app()->user->setFlash('sucess', 'asdf;ljasdl');
        if(isset($_POST['Transition']))
        foreach ($_POST['Transition'] as $item) {
            if (isset($item['entry_memo']) && trim($item['entry_memo']) != "")
                if ($item['entry_transaction'] == "1")
                    $sum += $item['entry_amount'];
                else
                    $sum -= $item['entry_amount'];
        }
        if ($sum != 0)
            $this->addError($attribute, '借贷必须相等');
        if(isset($_POST['Transition']))
            if($this->$attribute==0)
                $this->addError($attribute, '金额不能为0.00');
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
      return Transition::model()->updateAll(array('entry_posting'=>$bool),
                                     'entry_num_prefix=:prefix',
                                     array(':prefix'=>$this->entry_num_prefix));
    }

    public function setClosing($bool=1)
    {
        return Transition::model()->updateAll(array('entry_closing'=>$bool),
            'entry_num_prefix=:prefix',
            array(':prefix'=>$this->entry_num_prefix));
    }

    /**
     * 检测是否需要整理凭证
     * 1: 已经整理, 0:有凭证未整理
     **/
    public function isReorganised($date)
    {
      $this->unsetAttributes();
      $this->entry_deleted=1;
      $this->entry_num_prefix=$date;
      $this->select="entry_num_prefix,entry_num";
      $dataProvider = $this->search();
      $transtion = $dataProvider->getData();
      return empty($transtion);
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
        $transition = $dataProvider->getData();
        return empty($transition);
    }

    /*
     * 返回凭证是否都已经过账, attributes由实例传入
     */
    public function isPosted($date)
    {
        $this->unsetAttributes();
        $this->entry_posting=1;
        $this->entry_num_prefix=$date;
        $this->select="entry_num_prefix,entry_num,entry_posting";
        $dataProvider = $this->search();
        $transition = $dataProvider->getData();
        return empty($transition);
    }

    /*
     * 是否可以结账
     * return bool
     */
    public static function checkSettlement($date)
    {
        $Tran = new Transition();
        if ($date == "")
            $date = date('Ym', time());
        if(isset($_REQUEST['date']))
            $date = $_REQUEST['date'];
        if ($Tran->isAllPosted($date))
            return true;
        else
            throw new CHttpException(400, $date. " 还有凭证未审核或未过账");
    }

    //当前日期是否已经结账
    public function tranSettlement($date){
        $list1 = Transition::model()->findByAttributes(array('entry_num_prefix'=>$date, 'entry_closing'=>1));
        if(!empty($list1))
            return true;
        else
            return false;
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
    /*
     * 所有操作按年月为时间段
     */
    public static  function listReview(){
        $tran = new Transition();
        return $tran->listDate(array('entry_reviewed'=> 0));
    }
    public static  function listTransition(){
        $tran = new Transition();
        return $tran->listDate(array());
    }
    public static  function listPost(){
        $tran = new Transition();
        return $tran->listDate(array('entry_posting'=> 0));
    }
    public static  function listReorganise(){
        $tran = new Transition();
        return $tran->listDate(array());
    }
    public static  function listSettlement(){
        $tran = new Transition();
        return $tran->listDate(array('entry_closing'=> 0));
    }
    public static  function listDate($arr){
        $criteria = new CDbCriteria(array('group'=>'entry_num_prefix'));
        $list = Transition::model()->findAllByAttributes(
            $arr,
            $criteria
        );
        $arr = array();
        if($list){
            foreach($list as $model){
                $year = substr($model->entry_num_prefix, 0, 4);
                $month = substr($model->entry_num_prefix, 4, 6);
                if(empty($arr[$year])){
                    $arr += array($year=>array($month));
                }
                else
                    array_push($arr[$year], $month);
            }
        }
        return $arr;
    }

    //是否有过结账操作
    public function hasSettlement($date){
        $list1 = Transition::model()->findByAttributes(array('entry_num_prefix' => $date, 'entry_closing'=>1));
        $list2 = Transition::model()->findByAttributes(array('entry_num_prefix' => $date, 'entry_settlement'=>1));
        if($list1||$list2)
            return true;
        else
            return false;
    }

    public function hasData(){
        $sql = 'select distinct  extract(YEAR from `entry_date`) as `entry_date` from transition';
        $years = Transition::model()->findAllBySql($sql);
        $arr = array();
        foreach ($years as $year){
            $arr[] = $year['entry_date'];
        }
        return $arr;
    }

    public static function hasTransition($date){
        $sql = 'select `entry_num_prefix` from transition where `entry_num_prefix` = '. $date;
        $result = Transition::model()->findBySql($sql);
        if($result)
            return true;
        else
            return false;

    }

    //有凭证的年份
    //return array()
    public function hasTransitionYears(){
        $sql = 'select year(`entry_date`) as year from `transition` group by year(`entry_date`)';
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $array = array();
        foreach($result as $item){
            $array[$item['year']] = $item['year'];
        }
        return $array;
    }

}
