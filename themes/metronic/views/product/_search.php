<?php
/* @var $this ProductController */
/* @var $model Product */
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
		<?php echo $form->label($model,'no'); ?>
		<?php echo $form->textField($model,'no',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_no'); ?>
		<?php echo $form->textField($model,'order_no',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>512)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vendor_id'); ?>
		<?php echo $form->textField($model,'vendor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'in_date'); ?>
		<?php echo $form->textField($model,'in_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'in_price'); ?>
		<?php echo $form->textField($model,'in_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'out_date'); ?>
		<?php echo $form->textField($model,'out_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'out_price'); ?>
		<?php echo $form->textField($model,'out_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_time'); ?>
		<?php echo $form->textField($model,'create_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->