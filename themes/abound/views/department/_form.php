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
));
$dapartType = array(1=>'生产部门',2=>'管理部门',3=>'销售部门',4=>'研发部门');
?>
	<div class="well well-sm">
	<?php
	echo CHtml::link('<span class="glyphicon glyphicon-search"></span> 部门列表',array('admin'),array('class' => 'btn btn-default'));
	if (!($model->isNewRecord)) {
	echo "\n";
	echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> 添加部门',array('create'),array('class' => 'btn btn-default'));
	}
	?>
	</div>
	<div class="panel-body">
		<div class="form-group">	
			<?php echo $form->labelEx($model,'name',array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
				<?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
			</div>
			<?php echo $form->error($model,'name'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model,'type',array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
				<?php echo $form->dropDownList($model,'type', $dapartType,array('class'=>'form-control')); ?>
			</div>
			<?php echo $form->error($model,'type'); ?>
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
			<?php echo CHtml::submitButton('保存', array('class'=>'btn btn-primary',)); ?>
			<?php echo BtnBack(); ?>
		</div>
		</div>
	</div>
<?php $this->endWidget(); ?>
