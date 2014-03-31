<?php
//明细表
class SubjectBalance extends CModel
{

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subject_id' => '科目编码',
			'sbj_name' => '科目名称',
			'sbj_cat' => '科目类别',
			'start_debit' => '期初借方',
			'start_credit' => '期初贷方',
			'sum_debit' => '本期发生借方',
			'sum_credit' => '本期发生贷方',
			'end_debit' => '期末借方',
			'end_credit' => '期末贷方',

		);
	}

  public function attributeNames()
  {
  }


}
