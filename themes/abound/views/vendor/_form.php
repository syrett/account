<?php
require_once(dirname(__FILE__).'/../viewfunctions.php');

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'vendor-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
));

?>
<div class="row-fluid">
	<div class="span12 well">
	<div class="span6">
		<p class="note"><small>带 <span class="required">*</span> 的必填.</small></p>
		<?php echo $form->labelEx($model,'company'); ?>
		<?php echo $form->textField($model,'company',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'company'); ?>

		<?php echo $form->labelEx($model,'vat'); ?>
		<?php echo $form->textField($model,'vat',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'vat'); ?>

		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>
	<div class="span6">
		<?php echo $form->labelEx($model,'add'); ?>
		<?php echo $form->textField($model,'add',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'add'); ?>

		<?php echo $form->labelEx($model,'memo'); ?>
		<?php echo $form->textArea($model,'memo',array('rows'=>5,'cols'=>60)); ?>
		<?php echo $form->error($model,'memo'); ?>
	</div>
	</div>
	<?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存', array('class'=>'btn btn-primary',)); ?>
	<?php echo BtnBack(); ?>
</div>

<?php $this->endWidget(); ?>
