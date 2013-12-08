<?php
/* @var $this SubjectsController */
/* @var $model Subjects */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="col-md-3">
		<?php echo $form->label($model,'sbj_number'); ?>
		<?php echo $form->textField($model,'sbj_number'); ?>
	</div>

    <div class="col-md-3">
		<?php echo $form->label($model,'sbj_name'); ?>
		<?php echo $form->textField($model,'sbj_name',array('size'=>20,'maxlength'=>20)); ?>
	</div>

    <div class="col-md-3">
		<?php echo $form->label($model,'sbj_cat'); ?>
        <?php
        $data = Yii::app()->params['sbj_cat'];
        $this->widget('Select2', array(
            'model' => $model,
            'attribute' => 'sbj_cat',
            'value' => 1,
            'data' => $data,
        ));
        ?>
	</div>

    <div class="col-md-3">
		<?php echo $form->label($model,'sub_table'); ?>
		<?php echo $form->textField($model,'sub_table',array('size'=>20,'maxlength'=>200)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->