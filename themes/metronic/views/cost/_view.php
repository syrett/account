<?php
/* @var $this CostController */
/* @var $data Cost */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_no')); ?>:</b>
	<?php echo CHtml::encode($data->order_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_date')); ?>:</b>
	<?php echo CHtml::encode($data->entry_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_name')); ?>:</b>
	<?php echo CHtml::encode($data->entry_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stocks')); ?>:</b>
	<?php echo CHtml::encode($data->stocks); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stocks_count')); ?>:</b>
	<?php echo CHtml::encode($data->stocks_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stocks_price')); ?>:</b>
	<?php echo CHtml::encode($data->stocks_price); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_amount')); ?>:</b>
	<?php echo CHtml::encode($data->entry_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject')); ?>:</b>
	<?php echo CHtml::encode($data->subject); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject_2')); ?>:</b>
	<?php echo CHtml::encode($data->subject_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_id')); ?>:</b>
	<?php echo CHtml::encode($data->status_id); ?>
	<br />

	*/ ?>

</div>