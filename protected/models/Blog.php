<?php

/**
 * This is the model class for table "tbl_user2".
 *
 * The followings are the available columns in table 'tbl_user2':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 */
class Blog extends CActiveRecord
{
	public function getDbConnection() {

		return Yii::app()->dbadmin;
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'yii2_start_blogs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return array();
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
			'title' => Yii::t('models/model','标题'),
			'alias' => Yii::t('models/model','别名'),
			'snippet' => Yii::t('models/model','摘要'),
            'content' => Yii::t('models/model', '正文'),
            'created_at' => Yii::t('models/model', '日期'),
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
	public function search($category = '')
	{
		$criteria=new CDbCriteria;

        $criteria->compare('category', $category);
        $criteria->compare('status_id', 1);

        $sort = new CSort();
        $sort->defaultOrder = array(
            'id' => CSort::SORT_DESC,
        );

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination' => array(
                'pageVar' => 'p',
                'pageSize' => '12',
            ),
            'sort' => $sort,
		));
	}


    /**
     * @param string $id
     * @return static
     */
    public function article($id = '')
    {
        $art = Blog::model()->findByPk($id);
        if ($art !== null) {
            //是否发布
            if ($art->status_id == 1) {
                $art->views ++;
                $art->save();
            } else {
                $art = null;
            }
        }
        return $art;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User2 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


}
