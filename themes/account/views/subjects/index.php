<?php
/* @var $this SubjectsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Subjects',
);

$this->menu=array(
	array('label'=>'Create Subjects', 'url'=>array('create')),
	array('label'=>'Manage Subjects', 'url'=>array('admin')),
);
?>

<h1>Subjects</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
