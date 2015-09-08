<?php
/* @var $this PreparationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Preparations',
);

$this->menu=array(
	array('label'=>'Create Preparation', 'url'=>array('create')),
	array('label'=>'Manage Preparation', 'url'=>array('admin')),
);
?>

<h1>Preparations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
