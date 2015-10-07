<?php
require_once(dirname(__FILE__) . '/../viewfunctions.php');
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'employee-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'form-horizontal',),
));
$statusArray = ['离职','正常','兼职'];
?>
<div class="form-group">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'form-control')); ?>
    </div>
    <?php echo $form->error($model, 'name'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'department_id', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->dropDownList($model, 'department_id', $department_array, array('class' => 'form-control')); ?>
    </div>
    <?php echo $form->error($model, 'department_id'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'base', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model, 'base', array('class' => 'form-control')); ?>
    </div>
    <?php echo $form->error($model, 'base'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'base_2', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model, 'base_2', array('class' => 'form-control')); ?>
    </div>
    <?php echo $form->error($model, 'base_2'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'position', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model, 'position', array('class' => 'form-control')); ?>
    </div>
    <?php echo $form->error($model, 'position'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'memo', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->textArea($model, 'memo', array('class' => 'form-control')); ?>
    </div>
    <?php echo $form->error($model, 'memo'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->dropDownList($model, 'status', $statusArray, array('class' => 'form-control')); ?>
    </div>
    <?php echo $form->error($model, 'status'); ?>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10 text-center">
        <?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存', array('class' => 'btn btn-circle btn-primary',)); ?>
        <?php echo BtnBack(); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
