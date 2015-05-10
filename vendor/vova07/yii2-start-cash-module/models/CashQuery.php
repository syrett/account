<?php

namespace vova07\cash\models;

use vova07\users\traits\ModuleTrait;
use yii\db\ActiveQuery;

/**
 * Class BankQuery
 * @package vova07\bank\models
 */
class CashQuery extends ActiveQuery
{
    use ModuleTrait;

}
