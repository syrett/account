<?php
/* @var $this TransitionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transitions',
);

$this->menu=array(
	array('label'=>'Create Transition', 'url'=>array('create')),
	array('label'=>'Manage Transition', 'url'=>array('admin')),
);
?>

<h1>Transitions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
