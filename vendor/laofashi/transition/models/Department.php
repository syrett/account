<?php

namespace laofashi\transition\models;

use laofashi\transition\components\AccountRecord;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

/**
 * Class Department
 * 公司部门
 *
 */
class Department extends AccountRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%department}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Required
//            array('entry_num, entry_transaction, entry_subject, entry_amount,entry_creater, entry_editor, entry_reviewer', 'required'),
//            array('entry_num, entry_transaction, entry_subject,entry_creater, entry_editor, entry_reviewer, entry_deleted, entry_reviewed, entry_posting, entry_closing', 'numerical', 'integerOnly' => true),
//            array('entry_amount', 'type', 'type' => 'float'),
//            array('entry_num_prefix', 'length', 'max' => 10),
//            array('entry_memo, entry_appendix', 'length', 'max' => 100),
//            array('entry_appendix_id, entry_appendix_type, entry_date, entry_time', 'safe'),
//            // The following rule is used by search().
//            // @todo Please remove those attributes that should not be searched.
//            array('id, entry_number, entry_num_prefix, entry_num, entry_date, entry_time, entry_memo, entry_transaction,
//            entry_subject, entry_amount, entry_appendix, entry_appendix_id, entry_appendix_type,entry_creater, entry_editor, entry_reviewer,
//            entry_deleted, entry_reviewed, entry_posting, entry_closing, entry_settlement', 'safe', 'on' => 'search'),
//            //自定义验证规则
//            array('entry_amount', 'check_entry_amount', 'on' => 'create,update'), //借贷相等
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => '部门',
            'type' => '部门属性',
            'memo' => '部门描述',
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
     * 部门名称
     */
    public static function getName($id){
        $model = self::findOne($id);
        return $model->name;
    }
}
