<?php
/* @var $this TransitionController */
/* @var $model Transition */
/* @var $form CActiveForm */

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::import('ext.select2.Select2');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/bootstrap-datepicker.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/datepicker.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/transition.js', CClientScript::POS_HEAD);
$this->pageTitle = Yii::app()->name;
?>
<div class="panel panel-default voucher form">

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
                    凭证号:<input type="text" id='tranNumber' disabled value="<? echo $this->tranNumber() ?>">
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
                <div>
                    <?
                    $i = 0;
                    for($i; $i<5; $i++){
                    ?>
                        <div id="row_<?= $i ?>" class="row v-detail">
                            <div class="col-md-3">
                                <?php echo $form->textField($model, "entry_memo[$i]", array('class' => 'form-control input-size')); ?>
                                <?php echo $form->error($model, 'entry_memo[$i]'); ?>
                            </div>
                            <div class="col-md-1">
                                <?php
                                $this->widget('Select2', array(
                                    'name' => 'Transition[entry_transaction][$i]',
                                    'id' => "Transition_entry_transaction_$i",
                                    'value' => 1,
                                    'data' => array(1 => '借', 2 => '贷'),
                                ));
                                ?>
                            </div>
                            <div class="col-md-3">
                                <?php
                                $data = $this->actionListFirst();
                                $this->widget('Select2', array(
                                    'name' => 'Transition[entry_subject][$i]',
                                    'id' => "Transition_entry_subject_$i",
                                    'data' => $data,
                                    'htmlOptions' => array('class' => 'v-subject'),
                                ));
                                ?>
                                <input type="hidden" value="<?= $i ?>"/>
                            </div>
                            <div class="col-md-1">
                                <?php echo $form->textField($model, "entry_amount[$i]", array('class' => 'form-control input-size')); ?>
                            </div>
                            <div class="col-md-4">
                        <span id="appendix_<?= $i; ?>" style="display: none; float: left">

                        </span>

                                <?php echo $form->textField($model, 'entry_appendix[$i]', array('style' => 'width: 60%', 'class' => 'form-control input-size', 'maxlength' => 100)); ?>

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
                            $arr += array( $row['id']=> $row['fullname']);
                        };
                        $data = $arr;
                        $this->widget('Select2', array(
                            'name' => 'Transition[entry_reviewer]',
                            'id' => 'Transition_entry_reviewer',
                            'data' => $data,
                            'htmlOptions' => array('class' => 'v-subject'),
                        )); ?>
                        <?php echo $form->error($model, 'entry_reviewer'); ?>
                    </div>
                    <div class="form-group buttons text-center">

                        <?php echo $form->errorSummary($model); ?>

                        <?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存', array('class'=>'btn btn-primary',)); ?>
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

    <?php echo $form->textField($model, 'entry_num_prefix', array('hidden' => 'true', 'value' => date('Ym', time()))); ?>
    <?php echo $form->textField($model, 'entry_num', array('hidden' => 'true', 'value' => $this->tranSuffix(""))); ?>
    <?php echo $form->textField($model, 'entry_date', array('hidden' => 'true', 'value' => time())); ?>
    <?php echo $form->textField($model, 'entry_editor', array('hidden' => 'true', 'value' => 1)); ?>
    <input type="hidden" id="number" value="<?=$i?>" />
    <input type="hidden" value="<? echo Yii::app()->createAbsoluteUrl("transition/Appendix") ?>" id="entry_appendix"/>
    <?php $this->endWidget(); ?>
</div>
<div></div>
