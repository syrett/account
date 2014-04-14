<?php
require_once(dirname(__FILE__).'/../viewfunctions.php');
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'department-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<div class="row-fluid">
	<div class="span12 well">
	<p class="note"><small>带 <span class="required">*</span> 的必填.</small></p>
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>58,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>

		<?php echo $form->labelEx($model,'memo'); ?>
		<?php echo $form->textArea($model,'memo',array('rows'=>5,'cols'=>60)); ?>
		<?php echo $form->error($model,'memo'); ?>
	</div>
	<?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存', array('class'=>'btn btn-primary',)); ?>
	<?php echo BtnBack(); ?>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->