<?php
/* @var $this User2Controller */
/* @var $model User2 */

$this->breadcrumbs=array(
	'User2s'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List User2', 'url'=>array('index')),
	array('label'=>'Create User2', 'url'=>array('create')),
	array('label'=>'View User2', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage User2', 'url'=>array('admin')),
);
?>

<h1>Update User2 <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>