<?php
/* @var $this ReimburseController */
/* @var $data Reimburse */
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_memo')); ?>:</b>
	<?php echo CHtml::encode($data->entry_memo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_id')); ?>:</b>
	<?php echo CHtml::encode($data->employee_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('travel_amount')); ?>:</b>
	<?php echo CHtml::encode($data->travel_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('benefit_amount')); ?>:</b>
	<?php echo CHtml::encode($data->benefit_amount); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('traffic_amount')); ?>:</b>
	<?php echo CHtml::encode($data->traffic_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone_amount')); ?>:</b>
	<?php echo CHtml::encode($data->phone_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entertainment_amount')); ?>:</b>
	<?php echo CHtml::encode($data->entertainment_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('office_amount')); ?>:</b>
	<?php echo CHtml::encode($data->office_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rent_amount')); ?>:</b>
	<?php echo CHtml::encode($data->rent_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('train_amount')); ?>:</b>
	<?php echo CHtml::encode($data->train_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('services_amount')); ?>:</b>
	<?php echo CHtml::encode($data->services_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stamping_amount')); ?>:</b>
	<?php echo CHtml::encode($data->stamping_amount); ?>
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