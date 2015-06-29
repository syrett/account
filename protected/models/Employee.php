<?php

/**
 * This is the model class for table "employee".
 *
 * The followings are the available columns in table 'employee':
 * @property integer $id
 * @property string $name
 * @property string $memo
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
            array('name', 'required'),
            array('department_id', 'required'),
            array('id, department_id', 'numerical', 'integerOnly' => true),
            array('name, position', 'length', 'max' => 100),
            array('memo', 'length', 'max' => 200),
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
            'memo' => '备注',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('department_id', $this->department_id);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('memo', $this->memo, true);

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

    public function getDepart($employee_id)
    {
        $sql = "SELECT department_id FROM employee WHERE id=:em_id";
        $data = Employee::model()->findBySql($sql, array(':em_id' => $employee_id));
        foreach ($data as $s) {
            return $s;
        }
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
}