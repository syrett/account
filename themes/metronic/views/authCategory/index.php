<?php
/* @var $this AuthCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Auth Categories',
);

$this->menu=array(
	array('label'=>'Create AuthCategory', 'url'=>array('create')),
	array('label'=>'Manage AuthCategory', 'url'=>array('admin')),
);
?>

<h1>Auth Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
