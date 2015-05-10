<?php

namespace laofashi\transition\models;

use laofashi\transition\components\AccountRecord;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use laofashi\transition\models\Department;

/**
 * Class Bank
 * @package vova07\bank\models
 * bank model.
 *
 * @property integer $id ID
 * @property string $title Title
 * @property string $alias Alias
 * @property string $snippet Intro text
 * @property string $content Content
 * @property integer $views Views
 * @property integer $status_id Status
 * @property integer $created_at Created time
 * @property integer $updated_at Updated time
 */
class Employee extends AccountRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%employee}}';
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => '员工姓名',
            'memo' => '备注',
            'department_id' => '部门',
        );
    }
    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'id' => $this->id,
                'status_id' => $this->status_id,
                'FROM_UNIXTIME(created_at, "%d.%m.%Y")' => $this->created_at,
                'FROM_UNIXTIME(updated_at, "%d.%m.%Y")' => $this->updated_at
            ]
        );


        return $dataProvider;
    }

    /*
     * 科目表名称
     */
    public static function getName($id){
        $model = self::findOne($id);
        return $model->name;
    }

    /*
     * 所属部门类别
     */
    public static function getDepartType($id){
        $model = self::findOne($id);
        $model = Department::findOne($model->department_id);
        return $model->type;
    }

    /*
     *
     */
    public function getdepartment(){
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }
}
