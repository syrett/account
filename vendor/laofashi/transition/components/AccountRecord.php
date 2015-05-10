<?php

namespace laofashi\transition\components;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class System
 * @package vova07\base\components
 * Base system component
 */
class AccountRecord extends ActiveRecord
{
    public static function getDb(){
        return Yii::$app->dbaccount;
    }

}
