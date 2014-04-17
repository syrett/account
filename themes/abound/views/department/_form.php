<?php
require_once(dirname(__FILE__).'/../viewfunctions.php');
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'department-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>'form-horizontal',),
)); ?>
	<div class="alert alert-info">带 <span class="required">*</span> 的必填。</div>
		<div class="form-group">	
			<?php echo $form->labelEx($model,'name',array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
				<?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
			</div>
			<?php echo $form->error($model,'name'); ?>
		</div>

		<div class="form-group">	
			<?php echo $form->labelEx($model,'memo',array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
				<?php echo $form->textArea($model,'memo',array('class'=>'form-control')); ?>
			</div>
			<?php echo $form->error($model,'memo'); ?>
		</div>
		<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存', array('class'=>'btn btn-primary',)); ?>
			<?php echo BtnBack(); ?>
		</div>
		</div>

<?php $this->endWidget(); ?>
