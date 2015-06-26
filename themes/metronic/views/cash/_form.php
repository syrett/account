<?php
/* @var $this CashController */
/* @var $model Cash */
/* @var $form CActiveForm */

/*
Yii::app()->clientScript->registerCoreScript('jquery');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/select2/select2.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/js/select2/select2.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/jquery-ui.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/jquery-ui.min.css');
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/theme.css');
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/custom.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/import.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/import_datepicker.js', CClientScript::POS_HEAD);
*/

?>

    <div class="row" id="abc">
        <div class="box">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('class' => 'form-horizontal',),
//                'action'=>Laofashi. $this->createUrl('/cash/default/update', array('id'=>$_GET['id'])),
            ));
            ?>
            <table class="table table-striped table-bordered dataTable table-hover no-footer" id="cash_list">
            	<thead>
                <tr role="row">
                    <th class="table-checkbox" style="width:24px;">&nbsp;</th>
                    <th><?= $form->labelEx($model, 'target') ?></th>
                    <th><?= $form->labelEx($model, 'date') ?></th>
                    <th><?= $form->labelEx($model, 'memo') ?></th>
                    <th><?= $form->labelEx($model, 'amount') ?></th>
                    <th style="width: 75px">操作</th>
                    <th style="width: 10%">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($model)) {
                    $item = $sheetData[0]['data'];
                    $key = 1;
                    ?>
                    <tr line="<?= $key ?>" <?= $key % 2 == 1 ? 'class="table-tr"' : '' ?>>
                        <td><input type="checkbox" class="checkboxes" value="1"></td>
                        <td><input type="text" id="tran_name_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][entry_name]" placeholder="对方名称"
                                   value="<?=$item['entry_name'] ?>"></td>
                        <td><input class="input_mid" type="text" id="tran_date_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][entry_date]"
                                   value="<?=$item['entry_date'] ?>"></td>
                        <td><input class="input_full" type="text" id="tran_memo_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][entry_memo]"
                                   value="<?=$item['entry_memo'] ?>"></td>
                        <td><input class="input_mid" type="text" id="tran_amount_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][entry_amount]"
                                   value="<?=$item['entry_amount'] ?>">
                        <span class="tip2">总金额：<label
                                id="amount_<?= $key ?>"><?=$item['entry_amount'] ?></label>
                        </span></td>
                        <td class="action">
                            <input type="hidden" id="id_<?= $key ?>" value="<?= $key ?>">
                            <input id="subject_2" name="subject_2" type="hidden" value="<?=$model['subject_2']?>">
                            <input type="hidden" id="subject_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][entry_subject]"
                                   value="<?= $item['entry_subject'] ?>">
                            <input type="hidden" id="transaction_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][entry_transaction]"
                                   value="<?= $item['entry_transaction'] ?>">
                            <input type="hidden" id="invoice_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][invoice]" value="">
                            <input type="hidden" id="tax_<?= $key ?>" name="lists[<?= $key ?>][Transition][tax]"
                                   value="<?= $item['tax']?>">
                            <input type="hidden" id="withtax_<?= $key ?>"
                                   value="<?= $item['tax'] > 0 ? 1 : 0 ?>">
                            <input type="hidden" id="parent_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][parent]" value="">
                            <input type="hidden" id="additional_sbj0_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][additional][0][subject]" value="<?=$item['additional'][0]['subject']?>">
                            <input type="hidden" id="additional_amount0_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][additional][0][amount]" value="<?=$item['additional'][0]['amount']?>">
                            <input type="hidden" id="additional_sbj1_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][additional][1][subject]" value="<?=$item['additional'][1]['subject']?>">
                            <input type="hidden" id="additional_amount1_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][additional][1][amount]" value="<?=$item['additional'][1]['amount']?>">

                                <div class="btn-group-vertical" role="group">
                                    <div class="btn-group">
                                    <a class="btn btn-xs blue dropdown-toggle" data-toggle="modal" href="#category-box"><i class="fa fa-file-o"></i> 记账
                                    </a>
									</div>
                                    <button type="button" class="btn btn-xs" onclick="itemsplit(this)"><i class="fa fa-unlink"></i> 拆分</button>
                                    <button type="button" id="btn_del_<?= $key ?>" class="btn btn-xs" onclick="itemclose(this)" disabled><i class="fa fa-times"></i>删分</button>
                                </div>

                           </td>
                        <td>
                            <span id="info_<?= $key ?>" class="<?
                            if (isset($sheetData[0]['status']) && $sheetData[0]['status'] != 1)
                                echo "info_warning";
                            ?>">
                            <?
                            if (!empty($item['entry_subject'])) {
                                echo Subjects::getSbjPath($item['entry_subject']). "<br />";
                            }
                            if (isset($sheetData[0]['status']) && $sheetData[0]['status'] != 1) {
                                foreach ($item['error'] as $err) {
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
                <tr id="trSetting" style="display: none">
                    <td colspan="100">
                        <div id="itemSetting" title="记账设置" class="box">
                            <!--    <div class="modal-header bg-light-blue-active" >设置</div>-->
                            <div>
                                <input id="type" type="hidden" value="<?= $this->createUrl(
                                    '/cash/type'
                                ) ?>">

                                <input id="option" type="hidden" value="<?= $this->createUrl(
                                    '/cash/option'
                                ) ?>">
                                <input id="employee" type="hidden" value="<?= $this->createUrl(
                                    '/cash/createemployee'
                                ) ?>">
                                <input id="new-url" type="hidden" value="<?= $this->createUrl(
                                    '/cash/createsubject'
                                ) ?>">

                                <input id="data" type="hidden" value="">
                                <input id="subject" type="hidden" value="">
                                <input id="item_id" type="hidden" value="">
                            </div>
                            <div id="setting">
                                <div class="options btn-group-xs">
                                    <button class="btn btn-default" type="button" onclick="chooseType(this,1)"
                                            value="支出">支出
                                    </button>
                                    <br/>
                                    <button class="btn btn-default" type="button" onclick="chooseType(this,2)"
                                            value="收入">收入
                                    </button>
                                </div>
                            </div>
                            <div class="actionSetting" style="margin-top: 20px;text-align: center;">
                                <button class="btn btn-success " type="button" onclick="itemSet()">确定</button>
                                <button class="btn btn-default" type="button" onclick="dialogClose()">取消</button>
                            </div>
                        </div>

                    </td>
                </tr>
                </tbody>
            </table>
            <?
            if ($model->status_id == 1 && $item['entry_reviewed'] == 1) {
                ?>
                <span class="info-">该数据生成凭证已经审核，无法修改</span>
            <?
            } else {
                ?>
                <div class="text-center"><input class="btn btn-circle btn-success" type="button" onclick="save()" value="保存凭证"></div>
            <?php
            }
            $this->endWidget(); ?>

        </div>
    </div>
