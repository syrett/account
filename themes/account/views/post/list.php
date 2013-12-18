<?php
/* @var $this PostController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'过账',
);

$this->menu=array(
	array('label'=>$nextLabel, 'url'=>$nextUrl),
	array('label'=>'Create Post', 'url'=>array('create')),
	array('label'=>'Manage Post', 'url'=>array('admin')),
);
?>

<?php
echo "<h1>";
echo $header;
echo "</h1>"
?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
                                                        'dataProvider'=>$dataProvider,
                                                        //                                                        'dataProvider'=>$model->listunposted(),
                                                  'columns'=>array(
                                                                   'sbj_number',
                                                                   'sbj_name:html')
                                                   ));?>


