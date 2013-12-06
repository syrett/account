<?php
/* @var $this SubjectsController */
/* @var $model Subjects */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerCoreScript('jquery');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/checkinput.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/subjects.js', CClientScript::POS_HEAD);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'subjects-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<div class="form-group modal-open">
		<?php echo $form->label($model,'科目编号', array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
		<?php echo $form->textField($model,'sbj_number',array('class'=>'form-control input-size','maxlength'=>12,'onkeyup'=>'checkInputNum(this)',)); ?>
		<?php echo $form->error($model,'sbj_number'); ?>
	</div>
    </div>

	<div class="form-group modal-open">
		<?php echo $form->labelEx($model,'科目名称',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10" id="sbj_name_div">
		<?php echo $form->textField($model,'sbj_name',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'sbj_name'); ?>
            <div id="sbj_name_msg" class="error"></div>
            </div>
	</div>

	<div class="form-group modal-open">
		<?php echo $form->labelEx($model,'科目类别',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
		<?php echo $form->textField($model,'sbj_cat',array('class'=>'form-control','size'=>60,'maxlength'=>2,'onkeyup'=>'checkInputNum(this)',)); ?>
		<?php echo $form->error($model,'sbj_cat'); ?>
	</div>
    </div>

	<div class="form-group modal-open">
		<?php echo $form->labelEx($model,'报表名称',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
		<?php echo $form->textField($model,'sub_table',array('class'=>'form-control','size'=>60,'maxlength'=>200,'onkeyup'=>"if(this.value.replace(/^ +| +$/g,'')=='')alert('不能为空!')")); ?>
		<?php echo $form->error($model,'sub_table'); ?>
        </div>
	</div>

	<div class="form-group buttons text-center">
		<?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存', array('class'=>'btn btn-primary',)); ?>
        <?php
        echo CHtml::button('返回', array(
        'name' => 'btnBack',
        'class' => 'btn btn-warning',
        'onclick' => "history.go(-1)",
        )
        );
        ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->