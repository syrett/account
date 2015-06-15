<?php
/* @var $this TransitionController */
/* @var $model Transition */

$this->breadcrumbs=array(
	'Transitions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Transition', 'url'=>array('index')),
	array('label'=>'Create Transition', 'url'=>array('create')),
	array('label'=>'Update Transition', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Transition', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Transition', 'url'=>array('admin')),
);
?>

<h1>View Transition #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'entry_num_prefix',
		'entry_num',
		'entry_date',
		'entry_memo',
		'entry_transaction',
		'entry_subject',
		'entry_amount',
		'entry_appendix',
		'entry_editor',
		'entry_reviewer',
		'entry_deleted',
		'entry_reviewed',
		'entry_posting',
		'entry_closing',
	),
)); ?>
