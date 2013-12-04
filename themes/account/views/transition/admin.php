<?php
/* @var $this TransitionController */
/* @var $model Transition */

$this->breadcrumbs=array(
	'Transitions'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Transition', 'url'=>array('index')),
	array('label'=>'Create Transition', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#transition-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Transitions</h1>

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
	'id'=>'transition-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'entry_num_prefix',
		'entry_num',
		'entry_date',
		'entry_memo',
		'entry_transaction',
		/*
		'entry_subject',
		'entry_amount',
		'entry_appendix',
		'entry_editor',
		'entry_reviewer',
		'entry_deleted',
		'entry_reviewed',
		'entry_posting',
		'entry_closing',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
