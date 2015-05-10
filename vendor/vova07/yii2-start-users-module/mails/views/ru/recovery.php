<?php

/**
 * Recovery email view.
 *
 * @var \yii\web\View $this View
 * @var \vova07\users\models\frontend\User $model Model
 */

use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::toRoute(['/users/guest/recovery-confirmation', 'token' => $model['token']], true); ?>
<p>Здравствуйте <?= Html::encode($model['username']) ?>!</p>
<p>Перейдите по ссылке ниже чтобы восстановить пароль:</p>
<p><?= Html::a(Html::encode($url), $url) ?></p>