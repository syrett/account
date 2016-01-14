<?php
/* @var $this AuthCategoryController */
/* @var $model AuthCategory */

$this->breadcrumbs=array(
	'Auth Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AuthCategory', 'url'=>array('index')),
	array('label'=>'Create AuthCategory', 'url'=>array('create')),
	array('label'=>'View AuthCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AuthCategory', 'url'=>array('admin')),
);
?>

<h1>Update AuthCategory <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>