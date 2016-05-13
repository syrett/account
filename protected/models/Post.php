<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 * @property integer $id
 * @property integer $subject_id
 * @property string $month
 * @property double $balance
 * @property string $subject
 */
class Post extends CActiveRecord
{

    public $select;

    public function listunposted()
    {
        $year = $this->year;
        $month = $this->month;

        $subjects = new CDbCriteria;
        $subjects->select = "subjects.sbj_number, subjects.sbj_name";
        $subjects->condition = "post.id is null or post.posted=0 and post.year=" . $year . " and post.month=" . $month;
        $data = Subjects::model()->with('post')->findAll($subjects);
        return new CArrayDataProvider($data);

        //      $sql="select * from subjects left join(post) on (subjects.sbj_number=post.subject_id) where  post.id is null or post.posted=0 and post.year=2013 and post.month=12";
    }


    public function listposted()
    {
        $year = $this->year;
        $month = $this->month;

        $subjects = new CDbCriteria();
        $subjects->select = "subjects.sbj_number, subjects.sbj_name";
        $subjects->condition = "post.posted=1 and post.year=" . $year . " and post.month=" . $month;
        $data = Subjects::model()->with('post')->findAll($subjects);
        return new CArrayDataProvider($data);

        //      $sql = "select subjects.sbj_number, subjects.sbj_name from subjects,post where post.subject_id=subjects.sbj_number and post.posted=1;";
    }

    //得到最后一次post的年月
    public function getLastBalance($year, $month)
    {
        $lastPost = new Post;
        $sql = "SELECT year,month FROM post WHERE post_date < '$year-$month-1'order by post_date desc";
        $data = Post::model()->findBySql($sql, array());
        if (count($data) < 1) {
            $lastDate = date("Ym", strtotime("last month", mktime(0, 0, 0, $month, 01, $year)));
            $lastPost->year = substr($lastDate, 0, 4);
            $lastPost->month = substr($lastDate, 4, 2);
        } else {
            $lastPost->year = $data["year"];
            $lastPost->month = $data["month"];
        }
        return $lastPost->getBalance();
    }

    public function getBalance()
    {
        $sql = "select subject_id,debit,credit,balance from post where year=:year and month=:month";
        $dataArray = $this->findAllBySql($sql, array(
            ":year" => $this->year,
            ":month" => $this->month,
        ));

        $arr = array();

//      if (count($dataArray) <=0 ) {
//              //如果没有过账记录，需要检查期初余额
//          $data = Subjects::model()->findAllByAttributes([], 'start_balance <> 0');
//          if (count($data) > 0){
//              foreach ($data as $item) {
//                  $dataArray[] = [
//                      'subject_id'=>$item['sbj_number'],
//                      'debit' => 0,
//                      'credit' => 0,
//                      'balance' => $item['start_balance']
//                  ];
//
//              }
//          }
//      }

        if (count($dataArray) <= 0) {
            $post = new Post;
            $post->year = 0;
            $post->month = 0;
            $dataArray = $post->search()->getData();
        }
        foreach ($dataArray as $data) {
            $arr[$data['subject_id']] = array('debit' => $data['debit'],
                'credit' => $data['credit'],
                'balance' => $data['balance']);
        }
        return $arr;
    }

    /*
     * 过账操作，
     */
    public function postAll()
    {
        $lastBalanceArr = self::getLastBalance($this->year, $this->month);
        $transition = new Transition();

        $prefix = beTranPrefix($this->year, $this->month);
        $select = "entry_subject,entry_transaction,entry_amount,entry_settlement";
        $tranDataArray = $transition->listByPrefix($prefix, $select);
        $balance = array();

        foreach ($tranDataArray as $t) {
            if (isset($balance[$t['entry_subject']])) {
                $tmp_debit = $balance[$t['entry_subject']]['debit'];
                $tmp_credit = $balance[$t['entry_subject']]['credit'];
                $tmp_credit_2 = $tmp_credit;
                $tmp_debit_2 = $tmp_debit;
            } else {
                $tmp_debit = 0;
                $tmp_credit = 0;
                $tmp_credit_2 = 0;
                $tmp_debit_2 = 0;
            }

            //过账时，这里是重点，很容易出错
            if ($t['entry_settlement'] == 0) {
                if ($t['entry_transaction'] == "1") { //1为借
                    //利息费用要特殊处理
                    $sbj = Subjects::findSubject('利息费用', '6603', true);

                    if ($sbj != null && $t['entry_subject'] == $sbj[0]->sbj_number) {
                        $tmp_debit = $tmp_debit + floatval($t['entry_amount']);
                    } else {
                        if ($t['entry_amount'] > 0)
                            $tmp_debit = $tmp_debit + floatval($t['entry_amount']);
                        else
                            $tmp_credit = $tmp_credit - floatval($t['entry_amount']);
                    }

                } elseif ($t['entry_transaction'] == "2") { //2为贷
                    if ($t['entry_amount'] > 0)
                        $tmp_credit = $tmp_credit + floatval($t['entry_amount']);
                    else
                        $tmp_debit = $tmp_debit - floatval($t['entry_amount']);
                }
//                if ($tmp_debit != 0 && $tmp_credit != 0) {
//                    if ($tmp_debit > $tmp_credit) {
//                        $tmp_debit = $tmp_debit - $tmp_credit;
//                        $tmp_credit = 0;
//                    } else {
//                        $tmp_credit = $tmp_credit - $tmp_debit;
//                        $tmp_debit = 0;
//                    }
//                }
                $tmp_credit_2 = $tmp_credit;
                $tmp_debit_2 = $tmp_debit;
                if ($tmp_debit_2 != 0 && $tmp_credit_2 != 0) {
                    if ($tmp_debit_2 > $tmp_credit_2) {
                        $tmp_debit_2 = $tmp_debit_2 - $tmp_credit_2;
                        $tmp_credit_2 = 0;
                    } else {
                        $tmp_credit_2 = $tmp_credit_2 - $tmp_debit_2;
                        $tmp_debit_2 = 0;
                    }
                }
            } else {
                //结转凭证，只有未分配利润才把金额过到post表
                if (substr($t['entry_subject'], 0, 4)== '4103'){
                    if ($t['entry_transaction'] == "1") { //1为借
                        $tmp_debit = $tmp_debit + floatval($t['entry_amount']);
                    } elseif ($t['entry_transaction'] == "2") { //2为贷
                        $tmp_credit = $tmp_credit + floatval($t['entry_amount']);
                    }

                }
            }


            $balance[$t['entry_subject']]['debit'] = $tmp_debit;
            $balance[$t['entry_subject']]['credit'] = $tmp_credit;
            $balance[$t['entry_subject']]['debit_2'] = $tmp_debit_2;
            $balance[$t['entry_subject']]['credit_2'] = $tmp_credit_2;
        }

        // 算出余额
        foreach ($balance as $subject_id => $arr) {
            if (isset($lastBalanceArr[$subject_id])) {
                $tmp_balance = $lastBalanceArr[$subject_id]['balance'];
            } else {
                $tmp_balance = 0;
            }
            $sbj_cat = Subjects::model()->getCat($subject_id);
            $balance[$subject_id]['balance'] = str_replace(",", "", balance($tmp_balance, $arr['debit'], $arr['credit'], $sbj_cat));
        }

        // 本月没有发生额的科目借贷都为0
        foreach ($lastBalanceArr as $subject_id => $arr) {
            if (!isset($balance[$subject_id])) {
                $balance[$subject_id]['balance'] = $arr['balance'];
                $balance[$subject_id]['debit'] = 0;
                $balance[$subject_id]['credit'] = 0;
                $balance[$subject_id]['debit_2'] = 0;
                $balance[$subject_id]['credit_2'] = 0;
            }
        }

        return self::savePost($balance, $this->year, $this->month);
    }

    private function savePost($balance_arr, $year, $month)
    {
        foreach ($balance_arr as $sub => $arr) {
            $post = Post::model()->find('subject_id=:subject and year=:year and month=:month', array(':subject' => $sub, ':year' => $year, ':month' => $month));
            if ($post == null) {
                $post = new Post;
            }

            $post->subject_id = $sub;
            $post->debit = $arr['debit'];
            $post->credit = $arr['credit'];
            $post->debit_2 = isset($arr['debit_2'])?$arr['debit_2']:0;
            $post->credit_2 = isset($arr['credit_2'])?$arr['credit_2']:0;
            $post->balance = $arr['balance'];
            $post->posted = 1;
            $post->year = $year;
            $post->month = $month;
            $post->post_date = date('Y-m-d H:i:s', mktime(0, 0, 0, $month, 1, $year));
            if (!$post->save()) {
                return false;
            }
            $post = null;

        }
        return true;

    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'post';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('subject_id, month, balance', 'required'),
            array('subject_id', 'numerical', 'integerOnly' => true),
            array('balance', 'numerical'),
            // The following rule is used by search().
            array('id, subject_id, month, balance', 'safe', 'on' => 'search'),
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
            'subjects' => array(self::BELONGS_TO, 'Subjects', 'subject_id')
        );
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'subject_id' => '科目',
            'year' => '年',
            'month' => '月',
            'balance' => '余额',
            'debit' => '借',
            'credit' => '贷',
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
        $criteria->compare('subject_id', $this->subject_id);
        $criteria->compare('year', $this->year);
        $criteria->compare('month', $this->month);

        if (isset($this->select))
            $criteria->select = $this->select;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Post the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /*
     *
     */
    public static function tranPost($sbj_id)
    {
        $par_id = substr($sbj_id, 0, -2);
        $sql = "update post set subject_id = :sbj_id where subject_id = :par_id";
        Yii::app()->db->createCommand($sql)->bindValues(array(':sbj_id' => $sbj_id, ':par_id' => $par_id))->execute();
    }

    /*
     * 修改科目为父科目
     */
    public static function updateSubject($sbj)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('subject_id', $sbj, true);
        $rows = Post::model()->updateAll(['subject_id' => substr($sbj, 0, -2)], $criteria);
    }

    // 得到某个一级科目的及其子科目的余额和
    public function getBalanceNum($subject_id, $date)
    {

        $year = getYear($date);
        $month = getMon($date);
        $sql = "SELECT balance FROM post WHERE year(post_date)=:year AND month(post_date)=:month AND subject_id REGEXP '^" . $subject_id . "'";
        $dataArray = Post::model()->findAllBySql($sql, array(':year' => $year,
            ':month' => $month));

        $balance = 0;
        foreach ($dataArray as $post) {
            $balance += $post['balance'];
        }
        return $balance;

    }

    // 得到离$date最近的某个一级科目的及其子科目的余额和,若$date没有会寻找上个月的数据,若一条数据都没有则为期初余额
    public function getLastBalanceNum($subject_id, $date)
    {
        $year = getYear($date);
        $month = getMon($date);
        $sql = "select year,month from post where  ((year < $year) or( year = $year and month <= $month)) and subject_id regexp '^" . $subject_id . "' order by year desc, month desc";
        $data = Post::model()->findBySql($sql, array(':year' => $year,
            ':month' => $month));
        if ($data == null) {
            $result = 0;
            $balance = Subjects::model()->findAllByAttributes([], "sbj_number regexp '^" . $subject_id . "'");
            if ($balance) {
                foreach ($balance as $item) {
                    $result += $item->start_balance;
                }
            }
            return $result;
        } else {
            $lastdate = $data["year"] . $data["month"];
            return self::getBalanceNum($subject_id, $lastdate);
        }
    }

    /*
     * 得到收入类/费用类的科目及其子科目的贷和(收入类)/借和(费用类)
     */
    public function getDebitCredit($subject_id, $date, $num = 1)
    {
        //日期在账套起始之前，则提取总账期初余额
//        $condom =  Condom::getCondom();
//        if($condom->getStartTime()>$date)
//            $date = $condom->getStartTime();
        $year = getYear($date);
        $month = getMon($date);
        $sbj_cat = Subjects::model()->getCat($subject_id);
        if ($num == 1) { //得到某个月的发生额
            $sql = "SELECT * FROM post WHERE year=:year AND month=:month AND subject_id REGEXP '^" . $subject_id . "'";
        } else { //得到这年到某个月的发生额
            $sql = "SELECT * FROM post WHERE year(post_date)=:year AND month(post_date)<=:month AND subject_id REGEXP  '^" . $subject_id . "'";
        }
        $dataArray = Post::model()->findAllBySql($sql, array(':year' => $year,
            ':month' => $month));
        $balance = 0;

        switch ($sbj_cat) {
            case 4://收入类
                foreach ($dataArray as $post) {
                    if($post['debit_2'] == 0 && $post['credit_2'] == 0){
                        $post['debit_2'] = $post['debit'];
                        $post['credit_2'] = $post['credit'];
                    }

                    $balance = balance2($balance, $post["debit_2"], $post["credit_2"], $sbj_cat);
//          $balance += $post['credit_2'];    //好像重复计算了金额
                };
                break;
            case 5://费用类
                foreach ($dataArray as $post) {
                    if($post['debit_2'] == 0 && $post['credit_2'] == 0){
                        $post['debit_2'] = $post['debit'];
                        $post['credit_2'] = $post['credit'];
                    }
                    if ($post['credit_2'] == $post['debit_2'])
                        $balance += $post['debit_2'];
                    else
                        $balance += $post['debit_2'] - $post['credit_2'];
//                    $balance += $post['debit_2'];
                };
                break;
            case 3://
                foreach ($dataArray as $post) {
                    if($post['debit_2'] == 0 && $post['credit_2'] == 0){
                        $post['debit_2'] = $post['debit'];
                        $post['credit_2'] = $post['credit'];
                    }
                    $balance = balance2($balance, $post['debit_2'], $post['credit_2'], $sbj_cat);
                };
                break;
            default:
                break;
        };

        return $balance;
    }

    //设置期初余额的时候，删除原来的期初余额
    public function balance_delete($year, $month)
    {
        $delete_sql = "delete from post where year=$year and month=$month";
        Yii::app()->db->createCommand($delete_sql)->execute();
    }

    /*
     * 设置期初余额,值为0则不设置
     */
    public function balance_set($sbj_id, $balance, $year, $month)
    {
        if ($balance == 0) {
            $update_sql = "update post set balance=0 where subject_id='$sbj_id' AND year='$year' AND month='$month'";
            Yii::app()->db->createCommand($update_sql)->execute();
            return true;
        } else {
            $arr = array(
                "balance" => $balance,
                "credit" => 0,
                "debit" => 0,
            );
            $data[$sbj_id] = $arr;
            return self::savePost($data, $year, $month);
        }
    }

    /*
     * 凭证过账
     */
    public function postTransition($date)
    {
        $transition = new Transition;
        $transition->entry_num_prefix = $date;
        $this->year = substr($date, 0, 4);
        $this->month = substr($date, 4, 2);
        if ($this->postAll()) {
            $transition->setPosted(1);
//            if($transition->hasSettlement($date))     //
//                $transition->setClosing(1);
        }
    }
}
