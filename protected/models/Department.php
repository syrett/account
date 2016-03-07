<?php

/**
 * This is the model class for table "department".
 *
 * The followings are the available columns in table 'department':
 * @property integer $id
 * @property string $name
 * @property string $memo
 */
class Department extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'department';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'numerical', 'integerOnly'=>true),
			array('name, type', 'required'),
            array('name', 'filter', 'filter'=>'trim'),
			array('name', 'length', 'max'=>100),
			array('memo', 'length', 'max'=>200),
			// The following rule is used by search().
			array('name, memo', 'safe', 'on'=>'search'),
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
                     'employee' => array(self::HAS_MANY, 'Employee', 'id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => Yii::t('models/model','部门名称'),
			'type' => Yii::t('models/model','部门属性'),
			'memo' => Yii::t('models/model','部门描述'),
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('memo',$this->memo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Department the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /*
     * 得到名字
     */
    public function getName($depart_id)
    {
        $model = $this->model()->findByPk($depart_id);
        if($model)
            return $model->name;
        else
            return '无法查询部门';
    }
    /*
     * 得到名字
     */
    public function getNameByOrderNo($order_no, $depart_id=0)
    {
        $order = Purchase::model()->findByAttributes(["order_no" => $order_no]);
        if ($order){
            $model = $this->model()->findByPk($order['department_id']);
            if ($model)
                return $model->name;
        }elseif($depart_id!=0){
            $depart = Department::model()->findByPk($depart_id);
            if($depart)
                return $depart->name;
            else
                return '部门信息有误';
        }

        return '无法查询部门';
    }

    /**
     * 列出部门
     */
    public function list_departments()
    {
      $sql = "SELECT id,name FROM department where 1";
      $data = self::model()->findAllBySql($sql);
      foreach($data as $row){
        $arr[] = array("id"=>$row["id"],
                       "name"=>$row["name"]);
      }
      return $arr;
    }

    public function getDepartmentArray(){
        $data = $this->findAll();
        $arr = [];
        foreach($data as $row){
            $arr[$row['id']] = $row["name"];
        }
        return $arr;
    }

    public function matchName($name){
        $model = $this->findByAttributes([],['condition'=>'name like "%'.$name.'%"']);
        if($model!=null)
            return $model->id;
        else
            return 0;
    }

    /*
     * 根据部门判断，工资或资金应该返回什么科目
     */
    public static function matchSubject($department_id, $sbj_name){
        if($department_id==''||$department_id==0)
            return 0;
        $exception = ['办公费','印花税']; //此数组里的项目，都是管理费用的子科目
        if(in_array($sbj_name, $exception))
            $result = Subjects::matchSubject($sbj_name, 6602);
        else{
            $depart = Department::model()->findByPk($department_id);
            switch ($depart->type) {
                case 1:
                    $result = Subjects::matchSubject($sbj_name, array(6401));
                    break;
                case 2:
                    $result = Subjects::matchSubject($sbj_name, array(6602), 1);
                    break;
                case 3:
                    $result = Subjects::matchSubject($sbj_name, array(6601));
                    break;
                case 4:
                    $result = Subjects::matchSubject($sbj_name, array(660202));
                    break;
            }
        }
        return $result;
    }
}
