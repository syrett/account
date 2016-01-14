<?php

/**
 * This is the model class for table "project_b".
 *
 * The followings are the available columns in table 'project_b':
 * @property integer $id
 * @property string $name
 * @property string $memo
 * @property integer $status
 * @property integer $create_at
 */
class ProjectB extends CActiveRecord
{
    public $assets;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'project_b';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, memo', 'required'),
            array('name', 'filter', 'filter'=>'trim'),
			array('status, create_at', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>512),
            array('name', 'unique', 'message'=>'在建工程名称不能重复'),
			array('memo', 'length', 'max'=>1024),
			// The following rule is used by search().
			array('id, name, memo, status, create_at', 'safe', 'on'=>'search'),
            array('create_at', 'default', 'value'=>time('now'), 'setOnEmpty'=>false,'on'=>'insert'),
            array('status', 'default', 'value'=>1, 'on'=>'insert')
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
			'id' => '编号',
			'name' => '项目名称',
			'memo' => '项目描述',
			'status' => '状态',
			'create_at' => '创建时间',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('memo',$this->memo,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_at',$this->create_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProjectB the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /*
     * 项目明细，包含物品
     */
    public function detail($id = '')
    {
        $result = [];
        if ($id != '')
            $model = $this->findByPk($id);
        $model = isset($model) ? $model : $this;
        $sbj = Subjects::model()->findByAttributes(['sbj_name' => $model->name]);
        if ($sbj!==null) {
            if (User2::model()->checkVIP()) { //如果不是VIP，以bank cash 为原始数据，否则以purchase为原始数据
                $purchases = Purchase::model()->findAllByAttributes(['subject'=>$sbj->sbj_number]);
                if($purchases){
                    foreach ($purchases as $purchase) {
                        $result[] = $purchase->entry_name;
                    }
                }
            }else{
                $banks = Bank::model()->findAllByAttributes(['subject'=>$sbj->sbj_number]);
                if($banks){
                    foreach ($banks as $bank) {
                        $result[] = $bank->name;
                    }
                }
                $cashes = Cash::model()->findAllByAttributes(['subject'=>$sbj->sbj_number]);
                if($cashes){
                    foreach ($cashes as $cash) {
                        $result[] = $cash->name;
                    }
                }
            }
        }
        $this->assets = implode(',', $result);
        echo $this->assets;
    }

    /*
     * 在建工程可选项
     */
    public function getProject($key=''){
        $result = [];
        $project = $this::model()->findAllByAttributes(['status'=>1]);
        if($project != null){
            foreach ($project as $item) {
                $sbj = Subjects::model()->findByAttributes(['sbj_name'=>$item->name], "sbj_number like '1604%'");
                if($sbj!=null)
                    $result += Subjects::model()->getitem([$sbj->sbj_number], $key, ['type'=>1]);
            }
        }
        return $result;
    }

    /*
     *  在建工程返回ID
     */
    public function getIdBySubject($sbj){
        $name = Subjects::getName($sbj);
        if($name!='' && $name != '不存在的科目编号'){
            $prob = self::model()->findByAttributes(['name'=>$name]);
            if(!empty($prob))
                return $prob->id;
        }
        return '';

    }
}
