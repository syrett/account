<?php
/* @var $this TransitionController */
/* @var $model Transition */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'entry_num_prefix'); ?>
		<?php echo $form->textField($model,'entry_num_prefix',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'entry_num'); ?>
		<?php echo $form->textField($model,'entry_num'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'entry_date'); ?>
		<?php echo $form->textField($model,'entry_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'entry_memo'); ?>
		<?php echo $form->textField($model,'entry_memo',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'entry_transaction'); ?>
		<?php echo $form->textField($model,'entry_transaction'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'entry_subject'); ?>
		<?php echo $form->textField($model,'entry_subject'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'entry_amount'); ?>
		<?php echo $form->textField($model,'entry_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'entry_appendix'); ?>
		<?php echo $form->textField($model,'entry_appendix',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'entry_editor'); ?>
		<?php echo $form->textField($model,'entry_editor'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'entry_reviewer'); ?>
		<?php echo $form->textField($model,'entry_reviewer'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'entry_deleted'); ?>
		<?php echo $form->textField($model,'entry_deleted'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'entry_reviewed'); ?>
		<?php echo $form->textField($model,'entry_reviewed'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'entry_posting'); ?>
		<?php echo $form->textField($model,'entry_posting'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'entry_closing'); ?>
		<?php echo $form->textField($model,'entry_closing'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->