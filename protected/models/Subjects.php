<?php

/**
 * This is the model class for table "subjects".
 *
 * The followings are the available columns in table 'subjects':
 * @property integer $id
 * @property integer $sbj_number
 * @property string $sbj_name
 * @property string $sbj_cat
 * @property string $sbj_table
 * @property string $has_sub
 */
class Subjects extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subjects';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('sbj_number, sbj_name, sbj_cat', 'required', 'message'=>'{attribute}不能为空'),
            array('sbj_number,sbj_name','unique','message'=>'{attribute}:{value} 已经存在!'),
			array('sbj_number', 'numerical', 'integerOnly'=>true),
			array('sbj_name', 'length', 'max'=>20),
			array('sbj_cat', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sbj_number, sbj_name, sbj_cat, sbj_table, has_sub', 'safe', 'on'=>'search'),
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
			'sbj_number' => '科目编号',
			'sbj_name' => '科目名称',
			'sbj_cat' => '科目类别',
			'sbj_table' => '报表名称',
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
		$criteria->compare('sbj_number',$this->sbj_number, true);
		$criteria->compare('sbj_name',$this->sbj_name,true);
		$criteria->compare('sbj_cat',$this->sbj_cat,true);
		$criteria->compare('sbj_table',$this->sbj_table,true);
		$criteria->compare('has_sub',$this->has_sub,true);
//        $criteria->order = 'convert(sbj_name using gbk)';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array('attributes'=>array(  //设置中文拼音排序
                'sbj_number'=>array('asc'=>'convert(t.sbj_number using gbk)','desc'=>'convert(t.sbj_number using gbk) desc'),
                'sbj_name'=>array('asc'=>'convert(t.sbj_name using gbk)','desc'=>'convert(t.sbj_name using gbk) desc'),
                'sbj_cat'=>array('asc'=>'convert(t.sbj_cat using gbk)','desc'=>'convert(t.sbj_cat using gbk) desc'),
                'sbj_table'=>array('asc'=>'convert(t.sbj_table using gbk)','desc'=>'convert(t.sbj_table using gbk) desc'),
            )),
            'pagination' => array(
                'pageSize' => 30,
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Subjects the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}