<?php
/* @var $this SubjectsController */
/* @var $model Subjects */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'subjects-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'sbj_number'); ?>
		<?php echo $form->textField($model,'sbj_number'); ?>
		<?php echo $form->error($model,'sbj_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sbj_name'); ?>
		<?php echo $form->textField($model,'sbj_name',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'sbj_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sbj_cat'); ?>
		<?php echo $form->textField($model,'sbj_cat',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'sbj_cat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sub_table'); ?>
		<?php echo $form->textField($model,'sub_table',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'sub_table'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->