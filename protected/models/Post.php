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
      $this->select="subject_id,balance";
      $dataArray=$this->search()->getData();
      $arr=array();

      foreach ($dataArray as $data) {
        $arr[string($data['subject_id'])]=$data['balance'];
      }
      return $arr;
    }

    public function postAll()
    {
      $lastBalanceArr = $this->getLastBalance($this->year,$this->month);

      $transition = new Transition();
      $transition->unsetAttributes();
      $transition->select="entry_subject,entry_transaction,entry_amount";
      $transition->entry_num_prefix=beTranPrefix($this->year,$this->month);
      $tranDataArray = $transition->search()->getData();

      $balance=$lastBalanceArr;
      
      foreach($tranDataArray as $t){
        if(in_array($t['entry_subject'], $balance)) {
          $tmp_balance=$balance[$t['entry_subject']];
        }
        else
          $tmp_balance=0;
        if ($t['entry_transaction']=="1") {
          $tmp_balance=$tmp_balance + floatval($t['entry_amount']);
        }
        elseif($t['entry_transaction']=="2") {
          $tmp_balance=$tmp_balance - floatval($t['entry_amount']);
        }
        $balance[$t['entry_subject']]=$tmp_balance;
      }
      
      return self::savePost($balance, $this->year,$this->month);
    }

    private function savePost($balance,$year,$month)
    {
      foreach($balance as $sub=>$bal){      
        $post=Post::model()->find('subject_id=:subject and year=:year and month=:month', array(':subject'=>$sub,':year'=>$year,':month'=>$month));
        if($post==null)
          {
            $post = new Post;
          }

        $post->subject_id=$sub;
        $post->balance=$bal;
        $post->posted=1;
        $post->year=$this->year;
        $post->month=$this->month;
        if(!$post->save())
          {
            return false;
          }
        $post=null;

      }
      return true;

    }
    /*    public function posting($subject_id)
    {

      echo "subjects:".$subject_id;
      //todo 得到上个月的余额
      $lastPost = new Post;
      $lastDate=date("Ym",strtotime("last month",mktime(0,0,0,$this->month,01,$this->year)));
      $lastPost->year = substr($lastDate,0,4);
      $lastPost->month = substr($lastDate,4,2);
      $lastPost->subject_id = $subject_id;
      $lastBalance=$lastPost->getBalance();

      $transition = new Transition();
      $transition->unsetAttributes();
      $transition->select="entry_transaction,entry_amount,entry_reviewed";
      $transition->entry_num_prefix=beTranPrefix($this->year,$this->month);
      $transition->entry_subject=$subject_id;
      
      $dataArray = $transition->search()->getData();
      
      $balance=$lastBalance;
      foreach($dataArray as $data){
        echo "balance:".gettype($balance);
      echo $balance;
        if ($data['entry_transaction']=="1")
          {
            $balance=$balance + floatval($data['entry_amount']);
          }
        elseif($data['entry_transaction']=="2")
          {echo "2";
            $balance=$balance - floatval($data['entry_amount']);
          }

      }

      $this->subject_id=$subject_id;
      $this->balance=$balance;
      $this->save();

    }
    */
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
			'subject_id' => 'Subject',
			'month' => 'Month',
			'balance' => 'Balance',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('subject_id',$this->subject_id);
		$criteria->compare('year',$this->year,true);
		$criteria->compare('month',$this->month,true);
		$criteria->compare('balance',$this->balance);
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
}
