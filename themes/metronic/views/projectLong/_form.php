<?php
/* @var $this ProjectLongController */
/* @var $model ProjectLong */
/* @var $form CActiveForm */
require_once(dirname(__FILE__) . '/../viewfunctions.php');
?>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'project-long-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'form-horizontal',),
)); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 512, 'class' => 'form-control', 'readonly' => !$model->isNewRecord)); ?>
    </div>
    <div class="col-sm-2"></div>
    <?php echo $form->error($model, 'name', array('class' => 'col-sm-10')); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'memo', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->textArea($model, 'memo', array('class' => 'form-control')); ?>
    </div>
    <div class="col-sm-2"></div>
    <?php echo $form->error($model, 'memo', array('class' => 'col-sm-10')); ?>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10 text-center">
        <?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存', array('class' => 'btn btn-circle btn-primary',)); ?>
        <?php echo BtnBack(); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
