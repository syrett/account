<?php

namespace laofashi\transition\models;

use laofashi\transition\components\AccountRecord;
use yii\data\ActiveDataProvider;
use yii;
use yii\db;

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
class Transition extends AccountRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transition}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Required
            [['entry_subject', 'entry_date', 'entry_memo', 'entry_amount'], 'required'],
            // Trim
            [['entry_date', 'entry_memo', 'entry_amount'], 'trim'],
//            [['entry_amount'], 'getUser'],
            [['entry_creater', 'entry_editor'], 'default', 'value' => yii::$app->user->id]
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
            'entry_num_prefix' => '凭证前缀',
            'entry_num' => '凭证号',
            'entry_time' => '日',
            'entry_date' => '凭证日期',
            'entry_memo' => '凭证摘要',
            'entry_transaction' => '借贷',
            'entry_subject' => '借贷科目',
            'entry_amount' => '交易金额',
            'entry_appendix' => '附加信息',
            'entry_appendix_id' => '客户、供应商、员工、项目',
            'entry_creater' => '制单人员',
            'entry_editor' => '录入人员',
            'entry_reviewer' => '审核人员',
            'entry_deleted' => '凭证删除',
            'entry_reviewed' => '凭证审核',
            'entry_posting' => '过账',
            'entry_closing' => '结转',
            'entry_settlement' => '结转凭证',
            'entry_number' => '凭证编号',
            'entry_time' => '录入时间',
        );
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = [
            'entry_num_prefix',
            'entry_num',
            'entry_time',
            'entry_date',
            'entry_name',
            'data_type',
            'data_id',
            'entry_memo',
            'entry_transaction',
            'entry_subject',
            'entry_amount',
            'entry_appendix',
            'entry_appendix_id',
            'entry_creater',
            'entry_editor',
            'entry_reviewer',
            'entry_deleted',
            'entry_reviewed',
            'entry_posting',
            'entry_closing',
            'entry_settlement',
            'entry_number',
            'entry_time',
        ];

        return $scenarios;
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

        return $dataProvider;
    }

    /*
     * return transition number entry_num suffix
     */
    public function tranSuffix($prefix)
    {
        $query = new yii\db\Query();
        $query
            ->select('max(a.entry_num) b')
            ->from('transition as a')
            ->where('entry_num_prefix="' . $prefix . '"');
        $command = $query->createCommand(yii::$app->dbaccount);
        $data = $command->queryOne();

        if ($data['b'] == '')
            $data['b'] = 0;
        $num = $data['b'] + 1;
        return $num;
    }
}
