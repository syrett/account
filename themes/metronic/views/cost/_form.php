<?php
/* @var $this CostController */
/* @var $model Cost */
/* @var $form CActiveForm */
require_once(dirname(__FILE__) . '/../viewfunctions.php');

$cs = Yii::app()->getClientScript();
$baseUrl = Yii::app()->theme->baseUrl;
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_common.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_vip.js');
$this->pageTitle = Yii::app()->name;
$type = 'purchase';
$item = $sheetData[0]['data'];
?>
<div class="panel-body">
    <div class="row" id="abc">
        <div class="box">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('class' => 'form-horizontal',),
//                'action'=>Laofashi. $this->createUrl('/bank/default/update', array('id'=>$_GET['id'])),
            ));
            ?>
            <?= Yii::t('import', '成本结转单号：') ?><?= $item['order_no'] ?>
            <table class="table table-bordered dataTable">
                <tr>
                    <th class="input_min"><input type="checkbox"></th>
                    <th class="input_mid"><?= Yii::t('import', '交易日期') ?></th>
                    <th class="input_mid"><?= Yii::t('import', '名称') ?></th>
                    <th class="input_mid"><?= Yii::t('import', '型号') ?></th>
                    <th class="input_mid"><?= Yii::t('import', '盘点数量') ?></th>
                    <th style="width: 10%"><?= Yii::t('import', '提示') ?></th>
                </tr>
                <?php

                if (!empty($model)) {
                    $key = 1;
                    $clientArray = Client::model()->getClientArray();
                    $stockArray = Stock::model()->getStockArray();
                    $taxArray = Transition::getTaxArray('sale');
                    $arr = [6001];
                    $subjectArray = Transition::getSubjectArray($arr);
                    ?>
                    <tr line="<?= $key ?>" <?= $key % 2 == 1 ? 'class="table-tr"' : '' ?>>
                        <td><input type="checkbox" id="item_<?= $key ?>" name="lists[<?= $key ?>]"
                                   value="<?= isset($item['id']) ? $item['id'] : '' ?>" readonly></td>
                        <td><input class="input_mid no-dp" type="text" name="lists[<?= $key ?>][Transition][entry_date]"
                                   value="<?= $item['entry_date'] ?>" readonly></td>
                        <td><input class="input_mid" type="text" name="lists[<?= $key ?>][Transition][entry_name]"
                                   value="<?= $item['entry_name'] ?>" readonly></td>
                        <td><input class="input_mid" type="text" name="lists[<?= $key ?>][Transition][model]"
                                   value="<?= $item['model'] ?>" readonly></td>
                        <td>
                            <input class="input_mid" type="text" name="lists[<?= $key ?>][Transition][count]"
                                   value="<?= $item['count'] ?>">
                        </td>
                        <td class="action hidden">
                            <input type="hidden" id="did_<?= $key ?>" name="lists[<?= $key ?>][Transition][d_id]"
                                   value="<?= isset($item['d_id']) ? $item['d_id'] : '' ?>">
                            <input type="hidden" id="order_no_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][order_no]"
                                   value="<?= $item['order_no'] ?>">
                            <data class="hidden">
                                <input type="hidden" id="id_<?= $key ?>" value="<?= $key ?>">
                                <input type="hidden" id="status_id_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][status_id]"
                                       value="<?= $item['status_id'] ?>">
                                <input type="hidden" id="subject_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_subject]"
                                       value="<?= $item['entry_subject'] ?>">
                                <input type="hidden" id="entry_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_amount]"
                                       value="<?= $item['entry_amount'] ?>">
                                <input type="hidden" id="subject_2_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][subject_2]"
                                       value="<?= $item['subject_2'] ?>">
                                <input type="hidden" id="client_id_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][client_id]"
                                       value="<?= $item['client_id'] ?>">
                                <input type="hidden" id="transaction_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_transaction]"
                                       value="<?= $item['entry_transaction'] ?>">
                                <input type="hidden" id="invoice_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][invoice]" value="<?= $item['invoice'] ?>">
                                <input type="hidden" id="withtax_<?= $key ?>" value="<?= $item['tax'] > 0 ? 1 : 0 ?>">
                                <input type="hidden" id="parent_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][parent]" value="<?= $item['parent'] ?>">
                                <input type="hidden" id="additional_sbj0_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][additional][0][subject]"
                                       value="<?= $item['additional'][0]['subject'] ?>">
                                <input type="hidden" id="additional_amount0_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][additional][0][amount]"
                                       value="<?= $item['additional'][0]['amount'] ?>">
                                <input type="hidden" id="additional_sbj1_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][additional][1][subject]"
                                       value="<?= $item['additional'][1]['subject'] ?>">
                                <input type="hidden" id="additional_amount1_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][additional][1][amount]"
                                       value="<?= $item['additional'][1]['amount'] ?>">
                            </data>

                            <div>

                                <button type="button" id="btn_confirm_<?= $key ?>" class="hidden btn btn-default"
                                        onclick=""><?= Yii::t('import', '确认') ?>
                                </button>

                                <button type="button" id="btn_del_<?= $key ?>" class="btn btn-xs" disabled
                                        onclick="itemclose(this)"><i class="fa fa-times"></i><?= Yii::t('import', '删除') ?>
                                </button>
                            </div>
                        </td>
                        <td>
                            <span id="info_<?= $key ?>" class="<?= !empty($item['error']) ? 'label-warning' : '' ?>">
                               <?
                               if (!empty($item['error'])) {
                                   foreach ($item['error'] as $err) {
                                       if (is_array($err))
                                           echo $err[0];
                                       else
                                           echo $err;
                                   }
                               }
                               ?>
                            </span>
                        </td>
                    </tr>
                    <?php
                    $lines = $key;

                    ?>
                    <input type="hidden" id="rows" value="<?= $lines ?>">
                <?
                }
                ?>

            </table>
            <?
            if ($model->status_id == 1 && $item['entry_reviewed'] == 1) {
                ?>
                <span class="info-"><?= Yii::t('import', '该数据生成凭证已经审核，无法修改') ?></span>
            <?
            } else {
                ?>
                <div class="panel-footer">
                    <div class="text-center">
                        <button class="btn btn-primary" onclick="save()"><span class="glyphicon glyphicon-floppy-disk"></span> <?= Yii::t('import', '保存凭证') ?></button>
                    </div>
                </div>
            <?php
            }
            $this->endWidget();
            ?>

        </div>
    </div>

</div>
<script>
    $("div").delegate("[name*='stocks_count']", "blur", function () {
        sumAmount2(this);
    });
    $("div").delegate("[name*='stocks_price']", "blur", function () {
        sumAmount2(this);
    });
</script>