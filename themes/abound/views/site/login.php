<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 登录';
$this->breadcrumbs=array(
	'登录',
);
?>

<div class="panel panel-success">
	<div class="panel-heading"><div class="logo">老法师 sorcerer</div></div>
	<div class="panel-body">
	  <div class="col-xs-8 col-sm-6">
		<h5>新闻和操作指南</h5>
	  </div>
	  <div class="col-xs-4 col-sm-6">
			<h2>登 录</h2>
			<div class="form">
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'login-form',
				'enableClientValidation'=>true,
				'htmlOptions'=>array('class'=>'form-horizontal','role'=>'form'),
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
			)); ?>
			<?php echo $form->errorSummary($model); ?>
				<div class="form-group form-group-lg">		
					<?php echo $form->labelEx($model,'username',array('label'=>'用户名','class'=>'col-sm-3 control-label')); ?>
					<div class="col-sm-9">
						<?php echo $form->textField($model,'username',array('class'=>'form-control','placeholder'=>'请在此输入用户名')); ?>
						<?php echo $form->error($model,'username'); ?>
					</div>
				</div>
				<div class="form-group form-group-lg">
					<?php echo $form->labelEx($model,'password',array('label'=>'密码','class'=>'col-sm-3 control-label')); ?>
					<div class="col-sm-9">
						<?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>'请在此输入用户名')); ?>
						<?php echo $form->error($model,'password'); ?>
						<span class="help-block">Can't access your account?</span>
					</div>
				</div>
			
				<div class="checkbox rememberMe">
					<div class="col-sm-offset-3 col-sm-10">
					<?php echo '<label>'.$form->checkBox($model,'rememberMe').' 记住密码</label>'; ?>
					<?php echo $form->error($model,'rememberMe'); ?>
					</div>
				</div>
				<div class="col-sm-offset-3 col-sm-10">
				<br />
				<?php echo CHtml::submitButton('登录',array('class'=>'btn btn-primary btn-lg')); ?>
				</div>
				</div>
			
			<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	  </div>
</div>