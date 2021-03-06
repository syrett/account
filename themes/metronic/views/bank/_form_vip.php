<?php
/* @var $this BankController */
/* @var $model Data Array */
/* @var $form CActiveForm */

Yii::import('ext.select2.ESelect2', true);
//Yii::app()->clientScript->registerCoreScript('jquery');
$cs = Yii::app()->clientScript;
$baseUrl = Yii::app()->theme->baseUrl;
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_common.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_vip.js');

$type = 'bank';
$this->pageTitle = Yii::app()->name;
$tranDate = $this->getTransitionDate('post');
$relation = Bank::model()->getRelation('bank',$model->id);

?>
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
        <table class="table table-bordered dataTable">
            <tr>
                <th></th>
                <th style="width: 155px"><?= $form->labelEx($model, 'target') ?></th>
                <th class="input_mid"><?= $form->labelEx($model, 'name') ?></th>
                <th class="input_mid"><?= $form->labelEx($model, 'date') ?></th>
                <th class="input_full"><?= $form->labelEx($model, 'memo') ?></th>
                <th class="input-large"><?= $form->labelEx($model, 'amount') ?></th>
                <th style="width: 200px">&nbsp;</th>
                <th style="width: 10%">&nbsp;</th>
            </tr>
            <?php
            if (!empty($model)) {
                $item = $sheetData[0]['data'];
                $key = 1;
                ?>
                <tr line="<?= $key ?>" <?= $key % 2 == 1 ? 'class="table-tr"' : '' ?>>
                    <td><input type="checkbox"/></td>
                    <td><input type="text" id="tran_name_<?= $key ?>"
                               name="lists[<?= $key ?>][Transition][target]" placeholder="<?= Yii::t('import', '对方名称') ?>"
                               value="<?= $item['target'] ?>"></td>
                    <td><input type="text" id="tran_name_<?= $key ?>"
                               name="lists[<?= $key ?>][Transition][entry_name]" placeholder="<?= Yii::t('import', '名称') ?>"
                               value="<?= $item['entry_name'] ?>"></td>
                    <td><input class="input_mid" type="text" id="tran_date_<?= $key ?>"
                               name="lists[<?= $key ?>][Transition][entry_date]"
                               value="<?= $item['entry_date'] ?>"></td>
                    <td><input class="input_full" type="text" id="tran_memo_<?= $key ?>"
                               name="lists[<?= $key ?>][Transition][entry_memo]"
                               value="<?= $item['entry_memo'] ?>"></td>
                    <td><input class="input_mid" type="text" id="tran_amount_<?= $key ?>"
                               name="lists[<?= $key ?>][Transition][entry_amount]"
                               value="<?= $item['entry_amount'] ?>">
                        <span class="tip2"><?= Yii::t('import', '总金额') ?>：<label
                                id="amount_<?= $key ?>"><?= $item['entry_amount'] ?></label>
                        </span></td>
                    <td class="action">
                        <input type="hidden" id="id_<?= $key ?>" value="<?= $key ?>">
                        <input id="subject_b" name="subject_b" type="hidden" readonly
                               value="<?= $model['type'] != 'reimburse'?$model['subject_2']:$model['subject'] ?>">
                        <input type="hidden" id="order_no_<?= $key ?>"
                               name="lists[<?= $key ?>][Transition][order_no]"
                               value="<?= $item['order_no'] ?>">
                        <data>
                            <input type="hidden" id="status_id_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][status_id]"
                                   value="<?= $item['status_id'] ?>">
                            <input type="hidden" id="subject_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][entry_subject]"
                                   value="<?= $item['entry_subject'] ?>">
                            <input type="hidden" id="transaction_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][entry_transaction]"
                                   value="<?= $item['entry_transaction'] ?>">
                            <input type="hidden" id="invoice_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][invoice]" value="">
                            <input type="hidden" id="tax_<?= $key ?>" name="lists[<?= $key ?>][Transition][tax]"
                                   value="<?= $item['tax'] ?>">
                            <input type="hidden" id="overworth_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][overworth]"
                                   value="<?= $item['overworth'] ?>">
                            <input type="hidden" id="withtax_<?= $key ?>"
                                   value="<?= $item['tax'] > 0 ? 1 : 0 ?>">
                            <input type="hidden" id="parent_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][parent]" value="">
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
                            <input type="hidden" id="last_<?= $key ?>" name="lists[<?= $key ?>][Transition][last]"
                                   value = "<?isset($item['last'])?$item['last']:''?>">
                            <input type="hidden" id="path_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][path]"
                                   value="<?= $item['path'] ?>">

                        </data>

                        <div class="btn-group">
                            <a class="btn btn-xs blue dropdown-toggle" data-toggle="modal" onclick="itemsetting(this)"
                               href="#category-box">
                                <button type="button" class="btn btn-xs blue"><?= Yii::t('import', '记账') ?>
                                </button>
                            </a>
                            <!-- button type="button" class="btn btn-xs blue" onclick="itemsetting(this)"><i class="fa fa-file-o"></i> 记账
                            </button -->
                            <button type="button" data-type="double" class="btn btn-xs"
                                    onclick="itemsplit(this)"><?= Yii::t('import', '拆分') ?>
                            </button>
                            <button type="button" data-type="delete" id="btn_del_<?= $key ?>" class="btn btn-xs"
                                    onclick="itemclose(this)" disabled><?= Yii::t('import', '删分') ?>
                            </button>
                        </div>

                    </td>
                    <td>
                            <span id="info_<?= $key ?>" class="<?
                            if (isset($sheetData[0]['status']) && $sheetData[0]['status'] != 1)
                                echo "info_warning";
                            ?>">
                            <?
                            if (!empty($item['entry_subject'])) {
                                echo Subjects::getSbjPath($item['entry_subject']) . "<br />";
                            }
                            if (isset($sheetData[0]['status']) && $sheetData[0]['status'] != 1) {
                                foreach ($item['error'] as $err) {
                                    echo is_array($err)?$err[0]:$err;
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
        if (($model->status_id == 1 && $item['entry_reviewed'] == 1 )|| $relation != null) {
            ?>
            <span class="info-"><?= Yii::t('import', '该数据生成凭证已经审核，或和其他数据有关联，无法修改') ?></span>
        <?
        } else {
            ?>
            <div class="text-center">
                <button class="btn btn-primary" onclick="save()"><span class="glyphicon glyphicon-floppy-disk"></span><?= Yii::t('import', '保存凭证') ?> </button>
            </div>
        <?php
        }
        $this->endWidget(); ?>

    </div>
</div>
<div id="category-box" class="modal fade" tabindex="-1" aria-hidden="true" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="dropdown-menu-header">
            </div>
            <div class="modal-body">
                <div class="simScrollDiv">
                    <div class="scroller" data-always-visible="1" data-rail-visible1="1" data-initialized="1">
                        <div class="row">
                            <div class="col-xs-12">
                                <input id="type" type="hidden" value="<?= $this->createUrl(
                                    '/bank/type'
                                ) ?>">
                                <input id="user-bank" type="hidden" value="<?= $this->createUrl(
                                    '/user/savebank'
                                ) ?>">
                                <input id="option" type="hidden" value="<?= $this->createUrl(
                                    '/bank/option'
                                ) ?>">
                                <input id="employee" type="hidden" value="<?= $this->createUrl(
                                    '/employee/createemployee'
                                ) ?>">
                                <input id="new-url" type="hidden" value="<?= $this->createUrl(
                                    '/subjects/createsubject'
                                ) ?>">
                                <input id="data" type="hidden" value="">
                                <input id="subject" type="hidden" value="">
                                <input id="item_id" type="hidden" value="">

                                <div id="setting" class="itemsetting">
                                    <div class="options ">
                                        <button class="btn " type="button" onclick="chooseType(this,1)"
                                                value="<?= Yii::t('import', '支出') ?>"><?= Yii::t('import', '支出') ?>
                                        </button>
                                        <button class="btn " type="button" onclick="chooseType(this,2)"
                                                value="<?= Yii::t('import', '收入') ?>"><?= Yii::t('import', '收入') ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- .row -->
                    </div>
                    <!-- .scroller -->
                </div>
                <!-- .simScrollDiv -->
            </div>
            <!-- .modal-body -->
            <div class="modal-footer">
                <button class="btn btn-circle green" data-dismiss="modal" type="button" onclick="itemSet()"><?= Yii::t('import', '确定') ?></button>
                <button class="btn btn-circle default" data-dismiss="modal" type="button""><?= Yii::t('import', '取消') ?>
                </button>
            </div>
        </div>
        <!-- .modal-content -->
    </div>
    <!-- modal-dialog -->
</div><!-- #category-box -->