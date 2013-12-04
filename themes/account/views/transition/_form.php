<?php
/* @var $this TransitionController */
/* @var $model Transition */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transition-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'entry_num_prefix'); ?>
		<?php echo $form->textField($model,'entry_num_prefix',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'entry_num_prefix'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'entry_num'); ?>
		<?php echo $form->textField($model,'entry_num'); ?>
		<?php echo $form->error($model,'entry_num'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'entry_date'); ?>
		<?php echo $form->textField($model,'entry_date'); ?>
		<?php echo $form->error($model,'entry_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'entry_memo'); ?>
		<?php echo $form->textField($model,'entry_memo',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'entry_memo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'entry_transaction'); ?>
		<?php echo $form->textField($model,'entry_transaction'); ?>
		<?php echo $form->error($model,'entry_transaction'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'entry_subject'); ?>
		<?php echo $form->textField($model,'entry_subject'); ?>
		<?php echo $form->error($model,'entry_subject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'entry_amount'); ?>
		<?php echo $form->textField($model,'entry_amount'); ?>
		<?php echo $form->error($model,'entry_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'entry_appendix'); ?>
		<?php echo $form->textField($model,'entry_appendix',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'entry_appendix'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'entry_editor'); ?>
		<?php echo $form->textField($model,'entry_editor'); ?>
		<?php echo $form->error($model,'entry_editor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'entry_reviewer'); ?>
		<?php echo $form->textField($model,'entry_reviewer'); ?>
		<?php echo $form->error($model,'entry_reviewer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'entry_deleted'); ?>
		<?php echo $form->textField($model,'entry_deleted'); ?>
		<?php echo $form->error($model,'entry_deleted'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'entry_reviewed'); ?>
		<?php echo $form->textField($model,'entry_reviewed'); ?>
		<?php echo $form->error($model,'entry_reviewed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'entry_posting'); ?>
		<?php echo $form->textField($model,'entry_posting'); ?>
		<?php echo $form->error($model,'entry_posting'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'entry_closing'); ?>
		<?php echo $form->textField($model,'entry_closing'); ?>
		<?php echo $form->error($model,'entry_closing'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->