<?php
/* @var $this AuthCategoryController */
/* @var $model AuthCategory */

$this->breadcrumbs=array(
	'Auth Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AuthCategory', 'url'=>array('index')),
	array('label'=>'Manage AuthCategory', 'url'=>array('admin')),
);
?>

<h1>Create AuthCategory</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>