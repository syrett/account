<?php
/* @var $this ReimburseController */
/* @var $model Reimburse */

$this->breadcrumbs=array(
	'Reimburses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Reimburse', 'url'=>array('index')),
	array('label'=>'Create Reimburse', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#reimburse-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Reimburses</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'reimburse-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'order_no',
		'entry_date',
		'entry_memo',
		'employee_id',
		'travel_amount',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
