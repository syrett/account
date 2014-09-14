<?php
require_once(dirname(__FILE__).'/../viewfunctions.php');

/* @var $this SubjectsController */
/* @var $model Subjects */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::import('ext.select2.Select2');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/checkinput.js', CClientScript::POS_HEAD);
CHtml::$afterRequiredLabel = '';   //   remove * from required labelEx();
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'subjects-form',
	'htmlOptions'=>array('class'=>'form-horizontal','role'=>'form'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
    'enableClientValidation'=>true,
    'enableAjaxValidation'=>false,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

	<div class="alert alert-info">注意：所有字段必须填写</div>

	<div class="form-group form-group-lg">
		<?php echo $form->label($model,'sbj_number', array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
		<?php echo $form->textField($model,'sbj_number',array('class'=>'form-control input-size','maxlength'=>12,'onkeyup'=>'checkInputNum(this)',)); ?>
		<?php echo $form->error($model,'sbj_number',array('id'=>'sbj_number_msg')); ?>
		</div>
    </div>

	<div class="form-group form-group-lg">
		<?php echo $form->labelEx($model,'sbj_name',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10" id="sbj_name_div">
		<?php echo $form->textField($model,'sbj_name',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'sbj_name',array('id'=>'sbj_name_msg')); ?>
            </div>
	</div>

	<div class="form-group form-group-lg">
		<?php echo $form->labelEx($model,'sbj_cat',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php
            $data = Yii::app()->params['sbj_cat'];
            $this->widget('Select2', array(
                'model' => $model,
                'attribute' => 'sbj_cat',
                'value' => 1,
                'data' => $data,
            ));
            ?>
		<?php echo $form->error($model,'sbj_cat',array('id'=>'sbj_cat_msg')); ?>
	</div>
    </div>

	<div class="form-group form-group-lg">
		<?php echo $form->labelEx($model,'sbj_table',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
		<?php echo $form->textField($model,'sbj_table',array('class'=>'form-control','size'=>60,'maxlength'=>200,'onkeyup'=>"if(this.value.replace(/^ +| +$/g,'')=='')alert('不能为空!')")); ?>
		<?php echo $form->error($model,'sbj_table'); ?>
        </div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存', array('class'=>'btn btn-primary',)); ?>
			<?php echo BtnBack(); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->
