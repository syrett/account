<?php
/* @var $this PostController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Posts',
);

$this->menu=array(
	array('label'=>'Create Post', 'url'=>array('create')),
	array('label'=>'Manage Post', 'url'=>array('admin')),
);
?>

<h1>Posts</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
                                                        'dataProvider'=>$dataProvider,
                                                        //                                                        'dataProvider'=>$model->listunposted(),
                                                  'columns'=>array(
                                                                   'sbj_number',
                                                                   'sbj_name')
                                                   ));?>


