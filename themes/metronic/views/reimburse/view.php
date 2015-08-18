<?php
/* @var $this ReimburseController */
/* @var $model Reimburse */

$this->breadcrumbs=array(
	'Reimburses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Reimburse', 'url'=>array('index')),
	array('label'=>'Create Reimburse', 'url'=>array('create')),
	array('label'=>'Update Reimburse', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Reimburse', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Reimburse', 'url'=>array('admin')),
);
?>

<h1>View Reimburse #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'order_no',
		'entry_date',
		'entry_memo',
		'employee_id',
		'travel_amount',
		'benefit_amount',
		'traffic_amount',
		'phone_amount',
		'entertainment_amount',
		'office_amount',
		'rent_amount',
		'train_amount',
		'services_amount',
		'stamping_amount',
		'subject',
		'subject_2',
		'create_time',
		'update_time',
		'status_id',
	),
)); ?>
