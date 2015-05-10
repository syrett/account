<?php

/**
 * bank list view.
 *
 * @var \yii\base\View $this View
 * @var \yii\data\ActiveDataProvider $dataProvider Data provider
 * @var \vova07\bank\models\backend\BankSearch $searchModel Search model
 * @var array $statusArray Statuses array
 */

use vova07\bank\Module;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$model = new \laofashi\transition\models\Transition();
$this->title = Module::t('bank', 'BACKEND_INDEX_TITLE');
$this->registerJsFile('/backend/web/js/bank.js', ['depends' => [
    'yii\web\JqueryAsset',
    'yii\web\JqueryUIAsset',
    'yii\bootstrap\BootstrapAsset',
    'yii\bootstrap\BootstrapPluginAsset',
]]);
$this->params['breadcrumbs'] = [
    $this->title
];
$gridId = 'bank-grid';
$select = '<option value=1 >日期</option><option value=2 >交易说明</option><option value=3 >金额</option>';
?>
<div class="row">
    <div class="col-xs-9">
        <?php ActiveForm::begin(['options' => ['enctype' => "multipart/form-data"]]); ?>
        <div class="btn btn-primary btn-file">
            <i class="fa fa-paperclip"></i> 上传Excel
            <input type="file" name="attachment">
        </div>
        <input type="submit" class="btn btn-primary" value="查看"/>
        <?php ActiveForm::end(); ?>
        </div>
    <div class="col-xs-3" >
         <a href="<?=Url::to(['/bank/default/admin',])?>" >
             <input type="button" class="btn btn-primary btn-history" value="历史数据" />
         </a>
    </div>
</div>
<div class="row" id="abc">
    <div class="box">

        <?php ActiveForm::begin(); ?>
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
            <?php
            if (!empty($sheetData)) {
                array_shift($sheetData);    //删除第一行表头，可优化为是否选择删除
                foreach ($sheetData as $key => $item) {
                    ?>
                    <tr line="<?= $key?>" <?= $key%2==1 ? 'class="table-tr"' : '' ?>>
                        <td><input type="checkbox" id="item_<?= $key ?>" name="lists[<?= $key ?>]" value="<?=isset($item['id'])?$item['id']:''?>"></td>
                        <td><input type="text" id="tran_name_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_name]" placeholder="对方名称"></td>
                        <td><input type="text" id="tran_date_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_date]" value="<?= isset($item['date'])?$item['date']:$item['A'] ?>"></td>
                        <td><input type="text" id="tran_memo_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_memo]" value="<?= isset($item['memo'])?$item['memo']:$item['B'] ?>"></td>
                        <td><input type="text" id="tran_amount_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_amount]" value="<?= isset($item['amount'])?$item['amount']:$item['C'] ?>">
                        <span  class="tip">
                            总金额：<label id="amount_<?= $key ?>" ><?= isset($item['amount'])?$item['amount']:$item['C'] ?></label>
                        </span> </td>
                        <td class="action">
                            <input type="hidden" id="id_<?= $key ?>" value="<?= $key ?>">
                            <input type="hidden" id="subject_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_subject]" value="">
                            <input type="hidden" id="transaction_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_transaction]" value="">
                            <input type="hidden" id="invoice_<?= $key ?>" name="lists[<?= $key ?>][Transition][invoice]" value="">
                            <input type="hidden" id="tax_<?= $key ?>" name="lists[<?= $key ?>][Transition][tax]" value="">
                            <input type="hidden" id="parent_<?= $key ?>" name="lists[<?= $key ?>][Transition][parent]" value="">
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
                    $lines = $key;
                }
                ?>
            <input type="hidden" id="rows" value="<?= $lines ?>" >
            <?
            }
            ?>

        </table>
        <input class="btn btn-block btn-success" type="submit" value="保存凭证">
        <?php ActiveForm::end(); ?>

    </div>
</div>
</head>

<body>
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