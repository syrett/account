<?php
/* @var $this User2Controller */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'User2s',
);

$this->menu=array(
	array('label'=>'Create User2', 'url'=>array('create')),
	array('label'=>'Manage User2', 'url'=>array('admin')),
);
?>

<h1>User2s</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
