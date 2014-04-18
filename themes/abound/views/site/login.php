<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 登录';
$this->breadcrumbs=array(
	'登录',
);
?>
<div class="page-header">
	<h1>登录</h1>
</div>
<div class="row-fluid">
	<div class="alert alert-info">
	请填写您的用户名和密码信息。带有 <span class="required">*</span> 标记的字段为必填项目
	</div>
    
    <div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableClientValidation'=>true,
		'htmlOptions'=>array('class'=>'form-horizontal',),
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>
    <?php echo $form->errorSummary($model); ?>
		<div class="form-group">		
			<?php echo $form->labelEx($model,'username',array('label'=>'用户名','class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
				<?php echo $form->textField($model,'username',array('class'=>'form-control','placeholder'=>'请在此输入用户名')); ?>
			</div>
		<?php echo $form->error($model,'username'); ?>
		</div>
    
        <div class="form-group">
 			<?php echo $form->labelEx($model,'password',array('label'=>'密码','class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
            	<?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>'请在此输入用户名')); ?>
            	<span class="help-block">Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>.</span>
			</div>
            <?php echo $form->error($model,'password'); ?>
        </div>
    
        <div class="form-group rememberMe">
        	<div class="col-sm-offset-2 col-sm-10">
            <?php echo '<label>'.$form->checkBox($model,'rememberMe').'记住密码</label>'; ?>
            <?php echo $form->error($model,'rememberMe'); ?>
            </div>
        </div>
    
        <div class="form-group">
        	<div class="col-sm-offset-2 col-sm-10">
           	 <?php echo CHtml::submitButton('登录',array('class'=>'btn btn btn-primary')); ?>
            </div>
        </div>
    
    <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>