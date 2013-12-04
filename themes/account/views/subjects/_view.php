<?php
/* @var $this SubjectsController */
/* @var $data Subjects */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sbj_name')); ?>:</b>
	<?php echo CHtml::encode($data->sbj_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sbj_cat')); ?>:</b>
	<?php echo CHtml::encode($data->sbj_cat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sub_table')); ?>:</b>
	<?php echo CHtml::encode($data->sub_table); ?>
	<br />


</div>