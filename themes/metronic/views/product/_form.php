<?php
/* @var $this ProductController */
/* @var $model Product */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'no'); ?>
		<?php echo $form->textField($model,'no',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_no'); ?>
		<?php echo $form->textField($model,'order_no',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'order_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>512)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vendor_id'); ?>
		<?php echo $form->textField($model,'vendor_id'); ?>
		<?php echo $form->error($model,'vendor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'in_date'); ?>
		<?php echo $form->textField($model,'in_date'); ?>
		<?php echo $form->error($model,'in_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'in_price'); ?>
		<?php echo $form->textField($model,'in_price'); ?>
		<?php echo $form->error($model,'in_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'out_date'); ?>
		<?php echo $form->textField($model,'out_date'); ?>
		<?php echo $form->error($model,'out_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'out_price'); ?>
		<?php echo $form->textField($model,'out_price'); ?>
		<?php echo $form->error($model,'out_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_time'); ?>
		<?php echo $form->textField($model,'create_time'); ?>
		<?php echo $form->error($model,'create_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->