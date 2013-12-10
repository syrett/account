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
                    <div class="col-md-3">
                        <?php echo $form->labelEx($model, 'entry_memo'); ?></div>
                    <div class="col-md-1">借/贷</div>
                    <div class="col-md-3">科目</div>
                    <div class="col-md-1">金额</div>
                    <div class="col-md-4">附加</div>
                </div>
                <div class="row v-detail">
                    <div class="col-md-3">
                        <?php echo $form->textField($model, 'entry_memo', array('size' => 60, 'maxlength' => 100)); ?>
                        <?php echo $form->error($model, 'entry_memo'); ?>
                    </div>
                    <div class="col-md-1">
                        <?php
                        $this->widget('Select2', array(
                            'name' => '',
                            'id' => 's1',
                            'value' => 1,
                            'data' => array(1 => '借', 2 => '贷'),
                        ));
                        ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        $data = array();
                        for ($i = 1; $i < 200; $i++) {
                            $data += array($i => $i . '提取未到期责任准备金 ' . $i);
                        }
                        $this->widget('Select2', array(
                            'name' => 'subject',
                            'id' => 'subject',
                            'value' => 2,
                            'data' => $data,
                            'htmlOptions' => array('title' => $i . '存放中央银行款项', 'class' => 'v-subject'),
                        ));
                        ?>
                    </div>
                    <div class="col-md-1">.col-md-1

                    </div>
                    <div class="col-md-4">
                        <span id="appendix"></span>
                        <input type="hidden" value="<? echo Yii::app()->createAbsoluteUrl("site/Appendix") ?>"
                               id="entry_appendix"/>

                        <button type="button" class="close" aria-hidden="true">&times;</button>
                    </div>
                </div>

                <div>



                    <?php echo $form->errorSummary($model); ?>



                    <div class="row">
                        <?php echo $form->labelEx($model, 'entry_transaction'); ?>
                        <?php echo $form->textField($model, 'entry_transaction'); ?>
                        <?php echo $form->error($model, 'entry_transaction'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->labelEx($model, 'entry_subject'); ?>
                        <?php echo $form->textField($model, 'entry_subject'); ?>
                        <?php echo $form->error($model, 'entry_subject'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->labelEx($model, 'entry_amount'); ?>
                        <?php echo $form->textField($model, 'entry_amount'); ?>
                        <?php echo $form->error($model, 'entry_amount'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->labelEx($model, 'entry_appendix'); ?>
                        <?php echo $form->textField($model, 'entry_appendix', array('size' => 60, 'maxlength' => 100)); ?>
                        <?php echo $form->error($model, 'entry_appendix'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->labelEx($model, 'entry_editor'); ?>
                        <?php echo $form->textField($model, 'entry_editor'); ?>
                        <?php echo $form->error($model, 'entry_editor'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->labelEx($model, 'entry_reviewer'); ?>
                        <?php echo $form->textField($model, 'entry_reviewer'); ?>
                        <?php echo $form->error($model, 'entry_reviewer'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->labelEx($model, 'entry_deleted'); ?>
                        <?php echo $form->textField($model, 'entry_deleted'); ?>
                        <?php echo $form->error($model, 'entry_deleted'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->labelEx($model, 'entry_reviewed'); ?>
                        <?php echo $form->textField($model, 'entry_reviewed'); ?>
                        <?php echo $form->error($model, 'entry_reviewed'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->labelEx($model, 'entry_posting'); ?>
                        <?php echo $form->textField($model, 'entry_posting'); ?>
                        <?php echo $form->error($model, 'entry_posting'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->labelEx($model, 'entry_closing'); ?>
                        <?php echo $form->textField($model, 'entry_closing'); ?>
                        <?php echo $form->error($model, 'entry_closing'); ?>
                    </div>

                    <div class="row buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
                    </div>


                </div>
                <!-- form -->
            </td>
        </tr>
    </table>

    <?php $this->endWidget(); ?>
</div>
<?php echo $form->textField($model, 'entry_num_prefix', array('hidden' => 'true', 'value' => date('Ym', time()))); ?>
<?php echo $form->textField($model, 'entry_num', array('hidden' => 'true', 'value' => $this->tranSuffix(""))); ?>
<?php echo $form->textField($model, 'entry_date', array('hidden' => 'true', 'value' => time())); ?>
<div></div>
