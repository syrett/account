<?php

namespace laofashi\transition\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * Class Subj
 * @package laofashi\transition\models
 * sub_sub model.
 *
 * @property integer $id ID
 * @property integer $sub subject
 * @property integer $subsub subject
 */
class Subj extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subj}}';
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'sub' => '科目编号',
            'sub_sub' => '凭证对应科目编号',
        );
    }
}
