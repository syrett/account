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
      $year=$this->year;
      $month=$this->month;

      $subjects= new CDbCriteria;
      $subjects->select="subjects.sbj_number, subjects.sbj_name";
      $subjects->condition="post.id is null or post.posted=0 and post.year=".$year." and post.month=".$month;
      $data=Subjects::model()->with('post')->findAll($subjects);
      return new CArrayDataProvider($data);

      //      $sql="select * from subjects left join(post) on (subjects.sbj_number=post.subject_id) where  post.id is null or post.posted=0 and post.year=2013 and post.month=12";
    }
    

    public function listposted()
    {
      $year=$this->year;
      $month=$this->month;

      $subjects= new CDbCriteria();
      $subjects->select="subjects.sbj_number, subjects.sbj_name";
      $subjects->condition="post.posted=1 and post.year=".$year." and post.month=".$month;
      $data=Subjects::model()->with('post')->findAll($subjects);
      return new CArrayDataProvider($data);

      //      $sql = "select subjects.sbj_number, subjects.sbj_name from subjects,post where post.subject_id=subjects.sbj_number and post.posted=1;";
    }

    public function getLastBalance($year, $month)
    {
      $lastPost = new Post;
      $lastDate=date("Ym",strtotime("last month",mktime(0,0,0,$month,01,$year)));
      $lastPost->year = substr($lastDate,0,4);
      $lastPost->month = substr($lastDate,4,2);
      return $lastPost->getBalance();
    }

    public function getBalance()
    {
      $this->select="subject_id, debit, credit, balance";
      $dataArray=$this->search()->getData();
      $arr=array();
      foreach ($dataArray as $data) {
        $arr[$data['subject_id']]=array('debit'=>$data['debit'],
                                        'credit'=>$data['credit'],
                                        'balance'=>$data['balance']);
      }
      return $arr;
    }

    public function postAll()
    {
      $lastBalanceArr = self::getLastBalance($this->year,$this->month);

      $transition = new Transition();
      $transition->unsetAttributes();
      $transition->select="entry_subject,entry_transaction,entry_amount";
      $transition->entry_num_prefix=beTranPrefix($this->year,$this->month);
      $tranDataArray = $transition->search()->getData();

      $balance=array();
      
      foreach($tranDataArray as $t){
        if(isset($balance[$t['entry_subject']])) {
          $tmp_debit = $balance[$t['entry_subject']]['debit'];
          $tmp_credit = $balance[$t['entry_subject']]['credit'];
        }
        else{
          $tmp_debit = 0;
          $tmp_credit = 0;
          $tmp_balance = 0;
        }

        if ($t['entry_transaction']=="1") { //1为借
          $tmp_debit = $tmp_debit + floatval($t['entry_amount']);
        }
        elseif($t['entry_transaction']=="2") { //2为贷
          $tmp_credit = $tmp_credit + floatval($t['entry_amount']);
        }
        
        $balance[$t['entry_subject']]['debit']= $tmp_debit;
        $balance[$t['entry_subject']]['credit']= $tmp_credit;
      }

      // 算出余额
      foreach($balance as $subject_id=>$arr){
        if(isset($lastBalanceArr[$subject_id])){
          $tmp_balance = $lastBalanceArr[$subject_id]['balance'];
        }else{
          $tmp_balance = 0;
        }
        $sbj_cat = Subjects::model()->getCat($subject_id);
        $balance[$subject_id]['balance']= balance($tmp_balance, $arr['debit'], $arr['credit'], $sbj_cat);
      }

      // 本月没有发生额的科目借贷都为0
      foreach($lastBalanceArr as $subject_id=>$arr){
        if(!isset($balance[$subject_id])){
          $balance[$subject_id]['balance'] = $arr['balance'];
          $balance[$subject_id]['debit'] = 0;
          $balance[$subject_id]['credit'] = 0;
        }
      }

      return self::savePost($balance, $this->year,$this->month);
    }

    private function savePost($balance_arr,$year,$month)
    {
      foreach($balance_arr as $sub=>$arr){      
        $post=Post::model()->find('subject_id=:subject and year=:year and month=:month', array(':subject'=>$sub,':year'=>$year,':month'=>$month));
        if($post==null)
          {
            $post = new Post;
          }

        $post->subject_id=$sub;
        $post->debit=$arr['debit'];
        $post->credit=$arr['credit'];
        $post->balance=$arr['balance'];
        $post->posted=1;
        $post->year=$year;
        $post->month=$month;
        $post->post_date = date('Y-m-d H:i:s',mktime(0,0,0,$month,1,$year ));
        if(!$post->save())
          {
            return false;
          }
        $post=null;

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
			array('subject_id', 'numerical', 'integerOnly'=>true),
			array('balance', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, subject_id, month, balance', 'safe', 'on'=>'search'),
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
                     'subjects'=>array(self::BELONGS_TO, 'Subjects', 'subject_id')
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('subject_id',$this->subject_id);
		$criteria->compare('year',$this->year);
		$criteria->compare('month',$this->month);

        if (isset($this->select))
          $criteria->select=$this->select;
 		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Post the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /*
     *
     */
    public static function tranPost($sbj_id){
        $par_id = substr($sbj_id, 0, -2);
        $sql = "update post set subject_id = '$sbj_id' where subject_id = '$par_id'";
        Yii::app()->db->createCommand($sql)->execute();
    }

    // 得到某个一级科目的及其子科目的余额和
    public function getBalanceNum($subject_id, $date)
    {

      $year = getYear($date);
      $month = getMon($date);
      $sql = "SELECT balance FROM post WHERE year(post_date)=:year AND month(post_date)=:month AND subject_id REGEXP :sbj_id";
      $dataArray = Post::model()->findAllBySql($sql, array(':year'=>$year,
                                          ':month'=>$month,
                                          ':sbj_id'=>$subject_id));
      $balance = 0;
      foreach($dataArray as $post){
        $balance += $post['balance'];
      }
      return $balance;

    }

    // 得到离$date最近的某个一级科目的及其子科目的余额和,若$date没有会寻找上个月的数据,若一条数据都没有则为0
    public function getLastBalanceNum($subject_id, $date) {
      $year = getYear($date);
      $month = getMon($date);
      $sql = "SELECT year, month FROM (select year,month FROM post  WHERE year <=:year AND subject_id REGEXP :sbj_id) AS p WHERE month <=:month order by year desc, month desc";
      $data = Post::model()->findBySql($sql, array(':year'=>$year,
                                          ':month'=>$month,
                                          ':sbj_id'=>$subject_id));      
      if ($data == null){
        return 0;
      }else{
        $lastdate=$data["year"].$data["month"];
        return self::getBalanceNum($subject_id, $lastdate);
      }
    }
    /*
     * 得到收入类/费用类的科目及其子科目的贷和(收入类)/借和(费用类)
     */
    public function getDebitCredit($subject_id, $date, $num=1)
    {
      $year = getYear($date);
      $month = getMon($date);
      $sbj_cat = Subjects::model()->getCat($subject_id);
      if ($num==1){ //得到某个月的发生额
        $sql = "SELECT debit,credit FROM post WHERE year=:year AND month=:month AND subject_id REGEXP :sbj_id";
      }else{ //得到这年到某个月的发生额
        $sql = "SELECT debit, credit FROM post WHERE year(post_date)=:year AND month(post_date)<=:month AND subject_id REGEXP :sbj_id";
      }
      $dataArray = Post::model()->findAllBySql($sql, array(':year'=>$year,
                                          ':month'=>$month,
                                          ':sbj_id'=>$subject_id));

      $balance = 0;

      switch($sbj_cat){
      case 4://收入类
        foreach($dataArray as $post){
          $balance = balance2($balance, $post["debit"], $post["credit"], $sbj_cat);
          $balance += $post['credit'];
        };
        break;
      case 5://费用类
        foreach($dataArray as $post){
          $balance += $post['debit'];
        };
        break;
      case 3://
        foreach($dataArray as $post){
          $balance = balance2($balance,$post['debit'], $post['credit'], $sbj_cat);
        };
        break;        
      default:
        break;
      };

      return $balance;
    }

}
