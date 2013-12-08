<?php
/* @var $this SubjectsController */
/* @var $data Subjects */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sbj_number')); ?>:</b>
	<?php echo CHtml::encode($data->sbj_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sbj_name')); ?>:</b>
	<?php echo CHtml::encode($data->sbj_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sbj_cat')); ?>:</b>
	<?php echo CHtml::encode($data->sbj_cat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sbj_table')); ?>:</b>
	<?php echo CHtml::encode($data->sbj_table); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('has_sub')); ?>:</b>
	<?php echo CHtml::encode($data->has_sub); ?>
	<br />


</div>