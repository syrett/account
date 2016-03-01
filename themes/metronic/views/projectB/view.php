<?php
/* @var $this ProjectBController */
/* @var $model ProjectB */

$this->breadcrumbs=array(
	'Project B'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ProjectLong', 'url'=>array('index')),
	array('label'=>'Create ProjectLong', 'url'=>array('create')),
	array('label'=>'Update ProjectLong', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProjectLong', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProjectLong', 'url'=>array('admin')),
);
?>

<h1><?= Yii::t('import', '查看在建工程') ?>:<?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'memo',
		'status',
        ['name'=>'create_at','value'=>date("Y-m-d H:m",$model->create_at)],
	),
)); ?>
