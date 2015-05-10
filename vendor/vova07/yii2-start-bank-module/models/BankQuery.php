<?php

namespace vova07\bank\models;

use vova07\users\traits\ModuleTrait;
use yii\db\ActiveQuery;

/**
 * Class BankQuery
 * @package vova07\bank\models
 */
class BankQuery extends ActiveQuery
{
    use ModuleTrait;
}
