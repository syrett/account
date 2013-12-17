<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 * @property integer $id
 * @property integer $subject_id
 * @property string $month
 * @property double $balance
 */
class Post extends CActiveRecord
{
  
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
		$criteria->compare('month',$this->month,true);
		$criteria->compare('balance',$this->balance);

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
