<?php

namespace vova07\bank\models;

use vova07\base\behaviors\PurifierBehavior;
use vova07\bank\Module;
use vova07\bank\traits\ModuleTrait;
use vova07\fileapi\behaviors\UploadBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class Bank
 * @package vova07\bank\models
 * bank model.
 *
 * @property integer $id ID
 * @property integer $created_at Created time
 * @property integer $updated_at Updated time
 */
class Bank extends ActiveRecord
{
    use ModuleTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bank}}';
    }

    /**
     * @inheritdoc
     */
//    public static function find()
//    {
//        return new BankQuery(get_called_class());
//    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('bank', 'ATTR_ID'),
            'target' => '交易方名称',
            'date' => '日期',
            'memo' => '说明',
            'amount' => '金额',
            'parent' => '父ID',
            'subject' => '科目',
            'invoice' => '发票',
            'tax' => '税率',
            'status_id' => Module::t('bank', 'ATTR_STATUS'),
            'created_at' => Module::t('bank', 'ATTR_CREATED'),
            'updated_at' => Module::t('bank', 'ATTR_UPDATED'),
        ];
    }

    /*
     * @inheritdoc
     */
    public function load($item, $formName = null)
    {
        if(!empty($item) && (isset($item['Transition'])||isset($item['lists']))){
            if(isset($item['Transition']['id']))
                $this->setAttribute('id', $item['Transition']['id']);
            $this->setAttribute('target', $item['Transition']['entry_name']);
            $this->setAttribute('date', $item['Transition']['entry_date']);
            $this->setAttribute('memo', $item['Transition']['entry_memo']);
            $this->setAttribute('amount', $item['Transition']['entry_amount']);
            $this->setAttribute('subject', $item['Transition']['entry_subject']);
            $this->setAttribute('parent', $item['Transition']['parent']);
            $this->setAttribute('invoice', $item['Transition']['invoice']);
            $this->setAttribute('tax', $item['Transition']['tax']);
            return true;
        }else{
            parent::load($item, $formName);
        }
    }

    public function checkPost($data){
        if(!empty($data))
            return true;
        else
            return false;
    }
}
