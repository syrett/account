<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 登录';
$this->breadcrumbs=array(
	'登录',
);
?>
<style>
body{
	background-color:#193048;
}
</style>
<div class="logo">老法师 sorcerer</div>
<br />
<div class="panel panel-default">
	<div class="panel-body">
	<div class="row">
	  <div class="col-md-6 hidden-sm hidden-xs">
		<?php echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/financial-planning.jpg'); ?>
	  </div>
	  <div class="col-xs-12 col-sm-9 col-md-5">
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
					</div>
				</div>
			
				<div class="checkbox rememberMe">
					<div class="col-sm-offset-3 col-sm-10">
					<?php echo '<label>'.$form->checkBox($model,'rememberMe').' 记住密码</label>'; ?>
					<?php echo $form->error($model,'rememberMe'); ?>
					</div>
				</div>
				<br />
				<div class="col-sm-offset-3 col-sm-10">
					<?php echo CHtml::submitButton('登录',array('class'=>'btn btn-primary btn-lg','style'=>'float:left;')); ?>
					<div style="margin-left:10px;float:left;margin-top:13px;font-size:13px"><a href="#">账号无法登录？</a></div>
				</div>
				</div>
			
			<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>