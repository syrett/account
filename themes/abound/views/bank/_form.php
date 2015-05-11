<?php
/* @var $this BankController */
/* @var $model Data Array */
/* @var $form CActiveForm */

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
?>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
<div class="well-sm">
    <?php
    echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> 银行交易', array('/transition/bank'), array('class' => 'btn btn-default'));
    echo "\n";
    echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> 现金交易', array('/transition/cash'), array('class' => 'btn btn-default'));
    echo "\n";
    echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> 手动录入', array('/transition/create'), array('class' => 'btn btn-default'));
    /*
     $this->widget('zii.widgets.CMenu', array(
        'encodeLabel'=>false,
        'items'=>$this->menu,
        'htmlOptions'=>array('class'=>'nav nav-pills'),
        ));
    */
    echo "\n";
    ?>
    <div class="right">
        <? echo CHtml::link('<span class="glyphicon glyphicon-asterisk"></span> 历史数据', array('/bank'), array('class' => 'btn btn-default')); ?>

        <input type="hidden" id="dp_startdate" value="<?= Transition::getTransitionDate() ?>" >
    </div>
</div>
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
            <table class="table table-bordered list-hover dataTable">
                <tr>
                    <th style="width: 155px"><?= $form->labelEx($model, 'target') ?></th>
                    <th><?= $form->labelEx($model, 'date') ?></th>
                    <th><?= $form->labelEx($model, 'memo') ?></th>
                    <th><?= $form->labelEx($model, 'amount') ?></th>
                    <th style="width: 150px">操作</th>
                    <th style="width: 10%">&nbsp;</th>
                </tr>
                <?php
                if (!empty($model)) {
                    $item = $model;
                    if (!empty($sheetData[0]['data'])) {
                        $data = $sheetData[0]['data'];
                        $item->loadOld($data);
                    }
                    $key = 1;
                    ?>
                    <tr line="<?= $key ?>" <?= $key % 2 == 1 ? 'class="table-tr"' : '' ?>>
                        <td><input type="text" id="tran_name_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][entry_name]" placeholder="对方名称"
                                   value="<?= isset($item['target']) ? $item['target'] : $data['entry_name'] ?>"></td>
                        <td><input class="input_mid" type="text" id="tran_date_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][entry_date]"
                                   value="<?= isset($item['date']) ? $item['date'] : $data['entry_date'] ?>"></td>
                        <td><input type="text" id="tran_memo_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][entry_memo]"
                                   value="<?= isset($item['memo']) ? $item['memo'] : $data['entry_memo'] ?>"></td>
                        <td><input class="input_mid" type="text" id="tran_amount_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][entry_amount]"
                                   value="<?= isset($item['amount']) ? $item['amount'] : $data['entry_amount'] ?>">
                        <span class="tip2">总金额：<label
                                id="amount_<?= $key ?>"><?= isset($item['amount']) ? $item['amount'] : $data['entry_amount'] ?></label>
                        </span></td>
                        <td class="action">
                            <input type="hidden" id="id_<?= $key ?>" value="<?= $key ?>">
                            <input type="hidden" id="subject_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][entry_subject]"
                                   value="<?= !empty($item->subject) ? $item->subject : $data['entry_subject'] ?>">
                            <input type="hidden" id="transaction_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][entry_transaction]"
                                   value="<?= !empty($sheetData['tran']['entry_transaction']) ? $sheetData['tran']['entry_transaction'] : $data['entry_transaction'] ?>">
                            <input type="hidden" id="invoice_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][invoice]" value="">
                            <input type="hidden" id="tax_<?= $key ?>" name="lists[<?= $key ?>][Transition][tax]"
                                   value="<?
                                   $tax = 0;
                                   if(!empty($item->tax))
                                    $tax = $item->tax;
                                   if(!empty($data['tax']))
                                    $tax = $data['tax'];
                                   echo $tax;
                                   ?>">
                            <input type="hidden" id="withtax_<?= $key ?>"
                                   value="<?= $tax > 1 ? 1 : 0 ?>">
                            <input type="hidden" id="parent_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][parent]" value="">
                            <input type="hidden" id="additional_sbj0_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][additional][0][subject]" value="">
                            <input type="hidden" id="additional_amount0_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][additional][0][amount]" value="">
                            <input type="hidden" id="additional_sbj1_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][additional][1][subject]" value="">
                            <input type="hidden" id="additional_amount1_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][additional][1][amount]" value="">
                            <input type="button" class="btn btn-primary" onclick="itemsetting(this)" value="设置">
                            <span class="glyphicon glyphicon-plus" onclick="itemsplit(this)"></span>
                            <span class="glyphicon glyphicon-minus" onclick="itemclose(this)"></span>
                        </td>
                        <td>
                            <span id="info_<?= $key ?>" class="<?
                            if(isset($sheetData[0]['status']) && $sheetData[0]['status']!=1)
                                echo "info_warning";
                            ?>">
                            <?
                            if (!empty($item->subject)) {
                                echo Subjects::getSbjPath($item->subject);
                            }
                            if (isset($sheetData[0]['status'])&&$sheetData[0]['status']!=1) {
                                foreach ($data['error'] as $err) {
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
            <input class="btn btn-block btn-success" type="button" onclick="save()" value="保存凭证">
            <?php $this->endWidget(); ?>

        </div>
    </div>
    <div id="itemSetting" title="设置" class="box" style="display: none">
        <!--    <div class="modal-header bg-light-blue-active" >设置</div>-->
        <div>
            <input id="type" type="hidden" value="<?= Laofashi . $this->createUrl(
                '/bank/default/type'
            ) ?>">

            <input id="option" type="hidden" value="<?= Laofashi . $this->createUrl(
                '/bank/default/option'
            ) ?>">
            <input id="employee" type="hidden" value="<?= Laofashi . $this->createUrl(
                '/bank/default/createemployee'
            ) ?>">
            <input id="new-url" type="hidden" value="<?= Laofashi . $this->createUrl(
                '/bank/default/createsubject'
            ) ?>">

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
</div>