<?php

/**
 * Bank form view.
 *
 * @var \yii\base\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \vova07\bank\models\backend\Bank $model Model
 * @var \vova07\themes\admin\widgets\Box $box Box widget instance
 * @var array $statusArray Statuses array
 */

use vova07\bank\Module;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

$this->registerJsFile('/backend/web/js/bank.js', ['depends' => [
    'yii\web\JqueryAsset',
    'yii\web\JqueryUIAsset',
    'yii\bootstrap\BootstrapAsset',
    'yii\bootstrap\BootstrapPluginAsset',
]]);
$select = '<option value=1 >日期</option><option value=2 >交易说明</option><option value=3 >金额</option>';
?>
<?php
$key = $model->id;
$form = ActiveForm::begin(); ?>

<table class="table table-bordered list-hover dataTable">
    <tr>
        <th style="width: 2%"><input type="checkbox"></th>
        <th style="width: 155px">交易方名称</th>
        <th><select id="selectItem1" name="selectItem1"><?= $select ?></select></th>
        <th><select id="selectItem2" name="selectItem2"><?= $select ?></select></th>
        <th><select id="selectItem3" name="selectItem3"><?= $select ?></select></th>
        <th style="width: 150px">操作</th>
        <th style="width: 10%">&nbsp;</th>
    </tr>
    <tr line="<?= $key?>" <?= $key%2==1 ? 'class="table-tr"' : '' ?>>
        <td><input type="checkbox" id="item_<?= $key ?>" name="lists[<?= $key ?>]" value="<?=isset($model['id'])?$model['id']:''?>"></td>
        <td><input type="text" id="tran_name_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_name]" value="<?=$model['target']?>" placeholder="对方名称"></td>
        <td><input type="text" id="tran_date_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_date]" value="<?= isset($model['date'])?$model['date']:$model['A'] ?>"></td>
        <td><input type="text" id="tran_memo_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_memo]" value="<?= isset($model['memo'])?$model['memo']:$model['B'] ?>"></td>
        <td><input type="text" id="tran_amount_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_amount]" value="<?= isset($model['amount'])?$model['amount']:$model['C'] ?>">
                        <span  class="tip">
                            总金额：<label id="amount_<?= $key ?>" ><?= isset($model['amount'])?$model['amount']:$model['C'] ?></label>
                        </span> </td>
        <td class="action">
            <input type="hidden" id="id_<?= $key ?>" name="lists[<?= $key ?>][Transition][id]" value="<?= $key ?>">
            <input type="hidden" id="data_id_<?= $key ?>" name="lists[<?= $key ?>][Transition][data_id]" value="<?= $model->id ?>">
            <input type="hidden" id="subject_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_subject]" value="<?= $model['subject']?>">
            <input type="hidden" id="invoice_<?= $key ?>" name="lists[<?= $key ?>][Transition][invoice]" value="<?= $model['invoice']?>">
            <input type="hidden" id="tax_<?= $key ?>" name="lists[<?= $key ?>][Transition][tax]" value="<?= $model['tax']?>">
            <input type="hidden" id="parent_<?= $key ?>" name="lists[<?= $key ?>][Transition][parent]" value="<?= $model['parent']?>">
            <input type="hidden" id="transaction_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_transaction]" value="<?= $model['entry_transaction']?>">
            <input type="hidden" id="additional_sbj0_<?= $key ?>" name="lists[<?= $key ?>][Transition][additional][0][subject]" value="">
            <input type="hidden" id="additional_amount0_<?= $key ?>" name="lists[<?= $key ?>][Transition][additional][0][amount]" value="">
            <input type="hidden" id="additional_sbj1_<?= $key ?>" name="lists[<?= $key ?>][Transition][additional][1][subject]" value="">
            <input type="hidden" id="additional_amount1_<?= $key ?>" name="lists[<?= $key ?>][Transition][additional][1][amount]" value="">
            <input type="button" class="btn btn-primary" onclick="itemsetting(this)" value="设置" >
            <li class="fa fa-fw fa-plus-square" onclick="itemsplit(this)"></li>
            <li class="fa fa-fw fa-minus-square" onclick="itemclose(this)"></li>
        </td>
        <td>
                            <span id="info_<?= $key ?>" class="">

                            </span>
        </td>
    </tr>
    <tr>
        <td><hr></td>
    </tr>
<?php if (!empty($models)) {
    foreach ($models as $item) {
        $key = $item['id'];
        ?>
        <tr line="<?= $key?>" <?= $key%2==1 ? 'class="table-tr"' : '' ?>>
            <td><input type="checkbox" id="item_<?= $key ?>" name="lists[<?= $key ?>]" value="<?=isset($item['id'])?$item['id']:''?>"></td>
            <td><input type="text" id="tran_name_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_name]" value="<?= $model['target']?>" placeholder="对方名称"></td>
            <td><input type="text" id="tran_date_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_date]" value="<?= isset($item['date'])?$item['date']:$item['A'] ?>"></td>
            <td><input type="text" id="tran_memo_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_memo]" value="<?= isset($item['memo'])?$item['memo']:$item['B'] ?>"></td>
            <td><input type="text" id="tran_amount_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_amount]" value="<?= isset($item['amount'])?$item['amount']:$item['C'] ?>">
                        <span  class="tip">
                            总金额：<label id="amount_<?= $key ?>" ><?= isset($item['amount'])?$item['amount']:$item['C'] ?></label>
                        </span> </td>
            <td class="action">
                <input type="hidden" id="id_<?= $key ?>" name="lists[<?= $key ?>][Transition][id]" value="<?= $key ?>">
                <input type="hidden" id="data_id_<?= $key ?>" name="lists[<?= $key ?>][Transition][data_id]" value="<?= $key ?>">
                <input type="hidden" id="subject_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_subject]" value="<?= $model['subject']?>">
                <input type="hidden" id="invoice_<?= $key ?>" name="lists[<?= $key ?>][Transition][invoice]" value="<?= $model['invoice']?>">
                <input type="hidden" id="tax_<?= $key ?>" name="lists[<?= $key ?>][Transition][tax]" value="<?= $model['tax']?>">
                <input type="hidden" id="parent_<?= $key ?>" name="lists[<?= $key ?>][Transition][parent]" value="<?= $model['parent']?>">
                <input type="hidden" id="transaction_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_transaction]" value="<?= $model['entry_transaction']?>">
                <input type="hidden" id="additional_sbj0_<?= $key ?>" name="lists[<?= $key ?>][Transition][additional][0][subject]" value="">
                <input type="hidden" id="additional_amount0_<?= $key ?>" name="lists[<?= $key ?>][Transition][additional][0][amount]" value="">
                <input type="hidden" id="additional_sbj1_<?= $key ?>" name="lists[<?= $key ?>][Transition][additional][1][subject]" value="">
                <input type="hidden" id="additional_amount1_<?= $key ?>" name="lists[<?= $key ?>][Transition][additional][1][amount]" value="">
                <input type="button" class="btn btn-primary" onclick="itemsetting(this)" value="设置" >
                <li class="fa fa-fw fa-plus-square" onclick="itemsplit(this)"></li>
                <li class="fa fa-fw fa-minus-square" onclick="itemclose(this)"></li>
            </td>
            <td>
                            <span id="info_<?= $key ?>" class="">

                            </span>
            </td>
        </tr>
    <?php
    }
} ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
    $model->isNewRecord ? Module::t('bank', 'BACKEND_CREATE_SUBMIT') : Module::t(
        'bank',
        'BACKEND_UPDATE_SUBMIT'
    ),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>