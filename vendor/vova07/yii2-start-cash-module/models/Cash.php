<?php

namespace vova07\cash\models;

use vova07\base\behaviors\PurifierBehavior;
use vova07\cash\Module;
use vova07\cash\traits\ModuleTrait;
use vova07\fileapi\behaviors\UploadBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class cash
 * @package vova07\cash\models
 * cash model.
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
class Cash extends ActiveRecord
{
    use ModuleTrait;

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new cashQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('cash', 'ATTR_ID'),
            'title' => Module::t('cash', 'ATTR_TITLE'),
            'alias' => Module::t('cash', 'ATTR_ALIAS'),
            'snippet' => Module::t('cash', 'ATTR_SNIPPET'),
            'content' => Module::t('cash', 'ATTR_CONTENT'),
            'views' => Module::t('cash', 'ATTR_VIEWS'),
            'status_id' => Module::t('cash', 'ATTR_STATUS'),
            'created_at' => Module::t('cash', 'ATTR_CREATED'),
            'updated_at' => Module::t('cash', 'ATTR_UPDATED'),
            'preview_url' => Module::t('cash', 'ATTR_PREVIEW_URL'),
            'image_url' => Module::t('cash', 'ATTR_IMAGE_URL'),
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
