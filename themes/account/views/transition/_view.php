<?php
/* @var $this TransitionController */
/* @var $data Transition */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_num_prefix')); ?>:</b>
	<?php echo CHtml::encode($data->entry_num_prefix); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_num')); ?>:</b>
	<?php echo CHtml::encode($data->entry_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_date')); ?>:</b>
	<?php echo CHtml::encode($data->entry_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_memo')); ?>:</b>
	<?php echo CHtml::encode($data->entry_memo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_transaction')); ?>:</b>
	<?php echo CHtml::encode($data->entry_transaction); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_subject')); ?>:</b>
	<?php echo CHtml::encode($data->entry_subject); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_amount')); ?>:</b>
	<?php echo CHtml::encode($data->entry_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_appendix')); ?>:</b>
	<?php echo CHtml::encode($data->entry_appendix); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_editor')); ?>:</b>
	<?php echo CHtml::encode($data->entry_editor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_reviewer')); ?>:</b>
	<?php echo CHtml::encode($data->entry_reviewer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_deleted')); ?>:</b>
	<?php echo CHtml::encode($data->entry_deleted); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_reviewed')); ?>:</b>
	<?php echo CHtml::encode($data->entry_reviewed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_posting')); ?>:</b>
	<?php echo CHtml::encode($data->entry_posting); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_closing')); ?>:</b>
	<?php echo CHtml::encode($data->entry_closing); ?>
	<br />

	*/ ?>

</div>