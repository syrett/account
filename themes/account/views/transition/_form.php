<?php
/* @var $this TransitionController */
/* @var $model Transition */
/* @var $form CActiveForm */
/* @var $action string */

Yii::app()->clientScript->registerCoreScript('jquery');
//Yii::import('ext.select2.Select2');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/bootstrap-datepicker.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/datepicker.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/transition.js', CClientScript::POS_HEAD);
$this->pageTitle = Yii::app()->name;
?>
<div class="panel panel-default voucher form">

    <?php echo CHtml::beginForm(); ?>
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'transition-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>
    <!-- Default panel contents -->
    <div class="panel-heading">凭证录入</div>
    <div class="panel-body v-title">
        <div class="row">
            <div class="col-md-4">
                <h5>
                    凭证号:<input type="text" id='tranNumber' disabled value="<?
                    echo isset($action)&&$action=='update'?$model[0]->entry_num_prefix. substr(strval($model[0]->entry_num + 10000), 1, 4):$this->tranNumber()
                    ?>">
                </h5>
            </div>
            <div class="col-md-4" id="entry_date"><h5>日期:
                    <input type="text" class="span2" value="<?php echo date("Ym"); ?>" id="dp1" readonly/>
                </h5>
                <input type="hidden" id="entry_num_pre"
                       value="<? echo Yii::app()->createAbsoluteUrl("transition/GetTranSuffix") ?>"/></div>
            <div class="col-md-4"><h5></h5></div>
        </div>
    </div>

    <!-- Table -->
    <table class="table">
        <tr>
            <td>
                <div class="row">
                    <div class="col-md-3">凭证摘要</div>
                    <div class="col-md-1">借/贷</div>
                    <div class="col-md-3">科目</div>
                    <div class="col-md-1">金额</div>
                    <div class="col-md-4">附加</div>
                </div>
                <div id="transitionRows">
                    <?
                    $count = count($model)>5?count($model):5;   //此凭证多于5条记录
                    $number = 0;
                    if(count($model)==1)
                        for($i=0; $i<4; $i++)
                            array_push($model, new Transition());
                    foreach($model as $i => $item){
                        $number++;
                    ?>
                        <div id="row_<?= $i ?>" class="row v-detail">
                            <div class="col-md-3">
                                <?php echo CHtml::activeTextField($item, "[$i]entry_memo", array('class' => 'form-control input-size')); ?>
                                <?php echo $form->error($item, '[$i]_entry_memo'); ?>
                            </div>
                            <div class="col-md-1">
                                <select id="Transition_<?=$i?>_entry_transaction" name="Transition[<?=$i?>][entry_transaction]">
                                    <option value="1">借</option>
                                    <option value="2">贷</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="v-subject" id="Transition_<?=$i?>_entry_subject" name="Transition[<?=$i?>][entry_subject]">
                                <?php
                                $data = $this->actionListFirst();
                                $options = '';
                                foreach($data as $one => $key){
                                    $options .= "<option value=$key[0] >$key[1]</option>";
                                }
                                echo $options;
                                ?>
                                </select>
                                <input type="hidden" value="<?= $i ?>"/>
                            </div>
                            <div class="col-md-1">
                                <?php echo CHtml::activeTextField($item, "[$i]entry_amount", array('class' => 'form-control input-size')); ?>
                            </div>
                            <div class="col-md-4">
                        <span id="appendix_<?= $i; ?>" style="display: none; float: left">
                            <select id="Transition_<?=$i?>_entry_appendix_id" name="Transition[<?=$i?>][entry_appendix_id]"><option></option></select>"
                        </span>

                                <?php echo CHtml::activeTextField($item, "[$i]entry_appendix", array('style' => 'width: 60%', 'class' => 'form-control input-size', 'maxlength' => 100)); ?>

                                <button type="button" class="close" aria-hidden="true" name="<?=$i?>" onclick="rmRow(this)">&times;</button>
                            </div>
                        </div>
                    <? } ?>
                </div>
            </td>
        </tr>

        <tr>
            <td>
                <div>
                    <div class="row">
                        <?php
                        echo CHtml::button('继续添加', array(
                                'style' => 'float: right',
                                'name' => 'btnBack',
                                'class' => 'btn btn-info',
                                'onclick' => "addRow()",
                            )
                        );
                        ?>
                    </div>
                    <div class="row table-buttom">
                        <strong>审核人员</strong>
                        <?
                        $data = $this->getUserlist();
                        $arr = array();
                        foreach($data as $row) {
                            array_push($arr, array($row['id'], $row['fullname']));
                        };
                        $data = $arr;
                        ?>
                        <select id="Transition_entry_reviewer" name="entry_reviewer" >
                            <?
                            foreach($data as $one){
                                echo "<option value=". $one[0]. ">". $one[1]. "</option>";
                            }
                            ?>
                        </select>
                        <?php echo $form->error($item, 'entry_reviewer'); ?>
                    </div>
                    <div class="form-group buttons text-center">

                        <?php echo $form->errorSummary($item); ?>

                        <?php echo CHtml::submitButton($item->isNewRecord ? '添加' : '保存', array('class'=>'btn btn-primary',)); ?>
                        <?php
                        echo CHtml::button('返回', array(
                                'name' => 'btnBack',
                                'class' => 'btn btn-warning',
                                'onclick' => "history.go(-1)",
                            )
                        );
                        ?>
                    </div>
                </div>
                <!-- form -->
            </td>
        </tr>
    </table>

    <input type="hidden" name="entry_num_prefix"  id='entry_num_prefix' value="<?=date('Ym', time())?>" />
    <input type="hidden" name="entry_num" id='entry_num' value="<?=$this->tranSuffix("")?>" />
    <input type="hidden" name="entry_date" id='entry_date' value="<?=time()?>" />
    <input type="hidden" name="entry_editor" id='entry_editor' value="1" />
    <input type="hidden" id="number" value="<?=$number?>" />
    <input type="hidden" value="<? echo Yii::app()->createAbsoluteUrl("transition/Appendix") ?>" id="entry_appendix"/>
    <input type="hidden" value="<? echo Yii::app()->createAbsoluteUrl("transition/ajaxlistfirst") ?>" id="ajax_listfirst"/>
    <?php $this->endWidget(); ?>
    <?php echo CHtml::endForm(); ?>
</div>
<div></div>
