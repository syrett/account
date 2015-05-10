<?php

/**
 * bank update view.
 *
 * @var yii\base\View $this View
 * @var vova07\bank\models\backend\Bank $model Model
 * @var \vova07\themes\admin\widgets\Box $box Box widget instance
 * @var array $statusArray Statuses array
 */

use vova07\themes\admin\widgets\Box;
use vova07\bank\Module;
use yii\helpers\Url;

$this->title = Module::t('bank', 'BACKEND_UPDATE_TITLE');
$this->params['subtitle'] = Module::t('bank', 'BACKEND_UPDATE_SUBTITLE');
$this->params['breadcrumbs'] = [
    [
        'label' => $this->title,
        'url' => ['index'],
    ],
    $this->params['subtitle']
];
$boxButtons = ['{cancel}'];
$boxButtons = !empty($boxButtons) ? implode(' ', $boxButtons) : null; ?>
<div class="row">
    <div class="col-sm-12">
        <?php $box = Box::begin(
            [
                'title' => $this->params['subtitle'],
                'renderBody' => false,
                'options' => [
                    'class' => 'box-success'
                ],
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'buttonsTemplate' => $boxButtons
            ]
        );
        echo $this->render(
            '_form',
            [
                'model' => $model,
                'models' => $models,
                'box' => $box
            ]
        );
        Box::end(); ?>
    </div>
</div>
<div id="itemSetting" title="设置" class="box" style="display: none">
    <!--    <div class="modal-header bg-light-blue-active" >设置</div>-->
    <div>
        <input id="type" type="hidden" value="<?= Url::to([
            '/bank/default/type',
        ]) ?>">

        <input id="option" type="hidden" value="<?= Url::to([
            '/bank/default/option',
        ]) ?>">
        <input id="employee" type="hidden" value="<?= Url::to([
            '/bank/default/createemployee',
        ]) ?>">
        <input id="new-url" type="hidden" value="<?= Url::to([
            '/bank/default/createsubject',
        ]) ?>">

        <input id="data" type="hidden" value="">
        <input id="subject" type="hidden" value="">
        <input id="item_id" type="hidden" value="">
    </div>
    <div id="setting">
        <div class="options">
            <button class="btn btn-primary" type="button" onclick="chooseType(this,1)" value="支出">支出</button>
            <br/>
            <button class="btn btn-primary" type="button" onclick="chooseType(this,2)" value="收入">收入</button>
        </div>
    </div>
    <div style="margin-top: 20px;text-align: center;">
        <button class="btn btn-success " type="button" onclick="itemSet()">确定</button>
        <button class="btn btn-default" type="button" onclick="dialogClose()">取消</button>
    </div>
</div>