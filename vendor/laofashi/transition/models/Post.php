<?php

namespace laofashi\transition\models;

use laofashi\transition\components\AccountRecord;
use yii\data\ActiveDataProvider;
use yii;

/**
 * Class Department
 * 公司部门
 *
 */
class Post extends AccountRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'subject_id' => '科目',
            'year' => '年',
            'month' => '月',
            'balance' => '余额',
            'debit' => '借',
            'credit' => '贷',
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
     * 第一次新建子科目后，将已经过账的科目编号修改为新的科目编号
     */
    public static function tranPost($sbj_id){
        $par_id = substr($sbj_id, 0, -2);

        $query = new yii\db\Query();
        $query
            ->createCommand(yii::$app->dbaccount)
            ->update('post',['subject_id'=>$sbj_id], 'subject_id = '.$par_id)
            ->execute();
    }
}
