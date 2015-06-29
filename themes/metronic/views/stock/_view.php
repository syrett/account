<?php
/* @var $this StockController */
/* @var $data Stock */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no')); ?>:</b>
	<?php echo CHtml::encode($data->no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_no')); ?>:</b>
	<?php echo CHtml::encode($data->order_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vendor_id')); ?>:</b>
	<?php echo CHtml::encode($data->vendor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('in_date')); ?>:</b>
	<?php echo CHtml::encode($data->in_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('in_price')); ?>:</b>
	<?php echo CHtml::encode($data->in_price); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('out_date')); ?>:</b>
	<?php echo CHtml::encode($data->out_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('out_price')); ?>:</b>
	<?php echo CHtml::encode($data->out_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>