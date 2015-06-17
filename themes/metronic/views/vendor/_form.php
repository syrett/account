<?php
require_once(dirname(__FILE__).'/../viewfunctions.php');

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'vendor-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>'form-horizontal',),
));

?>
	<div class="well well-sm">
	<?php
	echo CHtml::link('<span class="glyphicon glyphicon-search"></span> 供应商列表',array('admin'),array('class' => 'btn btn-default'));
	if (!($model->isNewRecord)) {
	echo "\n";
	echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> 添加供应商',array('create'),array('class' => 'btn btn-default'));
	}
	?>
	</div>
	
	<div class="panel-body">
		<div class="form-group">
			<?php echo $form->labelEx($model,'company',array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
				<?php echo $form->textField($model,'company',array('class'=>'form-control')); ?>
			</div>
			<?php echo $form->error($model,'company'); ?>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model,'vat',array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
				<?php echo $form->textField($model,'vat',array('class'=>'form-control')); ?>
			</div>
			<?php echo $form->error($model,'vat'); ?>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model,'phone',array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
				<?php echo $form->textField($model,'phone',array('class'=>'form-control')); ?>
			</div>
			<?php echo $form->error($model,'phone'); ?>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model,'add',array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
				<?php echo $form->textField($model,'add',array('class'=>'form-control')); ?>
			</div>
			<?php echo $form->error($model,'add'); ?>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model,'memo',array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
				<?php echo $form->textArea($model,'memo',array('class'=>'form-control')); ?>
			</div>
			<?php echo $form->error($model,'memo'); ?>
		</div>
		<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10 text-center">
			<?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存', array('class'=>'btn btn-primary',)); ?>
			<?php echo BtnBack(); ?>
		</div>
		</div>
	</div>
<?php $this->endWidget(); ?>
