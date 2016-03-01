<?php
/* @var $this ProjectLongController */
/* @var $model ProjectLong */

$this->breadcrumbs=array(
	'Project Longs'=>array('index'),
	$model->name,
);

?>

<h1><?= Yii::t('import', '查看长期待摊') ?>:<?php echo $model->name; ?></h1>

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
