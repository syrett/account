<?php

/**
 * This is the model class for table "employee".
 *
 * The followings are the available columns in table 'employee':
 * @property integer $id
 * @property string $name
 * @property string $memo
 * @property string $position
 * @property string $base
 * @property string $base_2
 * @property integer $department_id
 */
class Employee extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'employee';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, department_id', 'required'),
            array('id, department_id', 'numerical', 'integerOnly' => true),
            array('name, position', 'length', 'max' => 100),
            array('memo', 'length', 'max' => 200),
            array('name', 'unique', 'message'=>'员工姓名不可重复'),
            array('base, base_2, departure_date, status', 'safe'),
            // The following rule is used by search().
            array('id, name, memo, department_id', 'safe', 'on' => 'search'),
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
            'department' => array(self::BELONGS_TO, 'Department', 'department_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => '员工姓名',
            'department_id' => '部门',
            'position' => '职位',
            'base' => '社保基数',
            'base_2' => '公积金基数',
            'memo' => '备注',
            'departure_date' => '离职日期',
            'status' => '状态'
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('department_id', $this->department_id);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('memo', $this->memo, true);
        $criteria->compare('base', $this->base, true);
        $criteria->compare('base_2', $this->base_2, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Employee the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function listDepartment()
    {
        $sql = "select id,name from department order by id asc"; //
        $First = Department::model()->findAllBySql($sql);
        $arr = array();
        foreach ($First as $row) {
            $arr += array($row['id'] => $row['name']);
        };
        return $arr;
    }

    public static function getName($employee_id){
        $model = Employee::model()->findByPk($employee_id);
        if($model)
            return $model->name;
        else
            return '无法查询的ID';
    }
    public function getDepart($employee_id, $type = '')
    {
        $model = $this->model()->findByPk($employee_id);
        if($model){
            if($type=='name')
                return Department::model()->getName($model->department_id);
            elseif($type=='')
                return $model->department_id;
        }
        else
            return 0;
    }

    /*
     * 所属部门类别
     */
    public static function getDepartType($id)
    {
        $model = self::model()->findByPk($id);
        $model = Department::model()->findByPk($model->department_id);
        return $model->type;
    }

    public static function getPersonalTax($amount){
        $amount -= 3500;
        if($amount<=0)
            return 0;
        switch($amount){
            case $amount <= 1500 : $tax = 3; $base = 0;break;
            case $amount > 1500 && $amount <= 4500 : $tax = 3; $base = 105;break;
            case $amount > 4500 && $amount <= 9000 : $tax = 10; $base = 555;break;
            case $amount > 9000 && $amount <= 35000 : $tax = 20; $base = 1005;break;
            case $amount > 35000 && $amount <= 55000 : $tax = 30; $base = 2755;break;
            case $amount > 55000 && $amount <= 80000 : $tax = 35; $base = 5505;break;
            case $amount > 80000 : $tax = 45; $base = 13505;break;
            default:
                return 0;
        }
        return abs($amount)*$tax/100 - $base;
    }

    public function getStatus(){
        switch($this->status){
            case 0: $status = '离职';break;
            case 1: $status = '正常';break;
            case 2: $status = '兼职';break;   //停职
//            case 3: $status = '兼职';break;
            default:
                $status = '正常';
        }
        return $status;
    }

    public static function getSheetData($items){
        $model = new Employee();
        if(!empty($items['B'])!=''&&$items['C']!=''&&$items['D']!=''){
            $model->name = $items['B'];
            $depart = Department::model()->matchName($items['C']);
            $model->department_id = $depart;
            $model->base = $items['D'];
            $model->base_2 = isset($items['E'])?$items['E']:'';
            $model->position = isset($items['F'])?$items['F']:'';
            $model->memo = isset($items['G'])?$items['G']:'';
            $model->validate();
        }
        return $model;

    }
}