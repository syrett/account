<?php
/* @var $this SubjectsController */
/* @var $model Subjects */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="col-md-3">
		<?php echo $form->label($model,'sbj_number'); ?>
		<?php echo $form->textField($model,'sbj_number'); ?>
	</div>

    <div class="col-md-3">
		<?php echo $form->label($model,'sbj_name'); ?>
		<?php echo $form->textField($model,'sbj_name',array('size'=>20,'maxlength'=>20)); ?>
	</div>

    <div class="col-md-3">
		<?php echo $form->label($model,'sbj_cat'); ?>
		<?php echo $form->textField($model,'sbj_cat',array('size'=>10,'maxlength'=>100)); ?>
	</div>

    <div class="col-md-3">
		<?php echo $form->label($model,'sbj_table'); ?>
		<?php echo $form->textField($model,'sbj_table',array('size'=>20,'maxlength'=>200)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->