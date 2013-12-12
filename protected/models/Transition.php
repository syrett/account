<?php

/**
 * This is the model class for table "transition".
 *
 * The followings are the available columns in table 'transition':
 * @property integer $id
 * @property string $entry_num_prefix
 * @property integer $entry_num
 * @property string $entry_date
 * @property string $entry_memo
 * @property integer $entry_transaction
 * @property integer $entry_subject
 * @property integer $entry_amount
 * @property string $entry_appendix
 * @property integer $entry_appendix_id
 * @property integer $entry_editor
 * @property integer $entry_reviewer
 * @property integer $entry_deleted
 * @property integer $entry_reviewed
 * @property integer $entry_posting
 * @property integer $entry_closing
 */
class Transition extends MyActiveRecord
{
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
			array('entry_num, entry_date, entry_transaction, entry_subject, entry_amount, entry_editor, entry_reviewer', 'required'),
			array('entry_num, entry_transaction, entry_subject, entry_amount, entry_editor, entry_reviewer, entry_deleted, entry_reviewed, entry_posting, entry_closing', 'numerical', 'integerOnly'=>true),
			array('entry_num_prefix', 'length', 'max'=>10),
			array('entry_memo, entry_appendix', 'length', 'max'=>100),
            array('entry_appendix_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, entry_num_prefix, entry_num, entry_date, entry_memo, entry_transaction, entry_subject, entry_amount, entry_appendix, entry_appendix_id, entry_editor, entry_reviewer, entry_deleted, entry_reviewed, entry_posting, entry_closing', 'safe', 'on'=>'search'),
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
			'entry_num_prefix' => '凭证前缀',
			'entry_num' => '凭证号',
			'entry_date' => '凭证日期',
			'entry_memo' => '凭证摘要',
			'entry_transaction' => '借贷类别',
			'entry_subject' => '借贷科目',
			'entry_amount' => '交易金额',
            'entry_appendix' => '附加信息',
            'entry_appendix_id' => '客户、供应商、员工、项目',
			'entry_editor' => '录入人员',
			'entry_reviewer' => '审核人员',
			'entry_deleted' => '凭证删除',
			'entry_reviewed' => '凭证审核',
			'entry_posting' => '凭证过账',
			'entry_closing' => '结转凭证',
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
		$criteria->compare('entry_num_prefix',$this->entry_num_prefix,true);
		$criteria->compare('entry_num',$this->entry_num,true);
		$criteria->compare('entry_date',$this->entry_date,true);
		$criteria->compare('entry_memo',$this->entry_memo,true);
		$criteria->compare('entry_transaction',$this->entry_transaction,true);
		$criteria->compare('entry_subject',$this->entry_subject,true);
		$criteria->compare('entry_amount',$this->entry_amount);
		$criteria->compare('entry_appendix',$this->entry_appendix,true);
		$criteria->compare('entry_editor',$this->entry_editor);
		$criteria->compare('entry_reviewer',$this->entry_reviewer);
		$criteria->compare('entry_deleted',$this->entry_deleted);
		$criteria->compare('entry_reviewed',$this->entry_reviewed);
		$criteria->compare('entry_posting',$this->entry_posting);
		$criteria->compare('entry_closing',$this->entry_closing);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    /*    public function save()
    {
      
    }*/
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Transition the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}