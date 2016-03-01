<?php
/* @var $this PostController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('import', '过账'),
);

$this->menu=array(
	array('label'=>$nextLabel, 'url'=>$nextUrl),
	array('label'=>'Create Post', 'url'=>array('post')),

);
?>

<?php
echo "<h1>";
echo $header;
echo "</h1>"
?>


<?php 
$this->widget('zii.widgets.grid.CGridView', 
              array(
                    'id'=>'post-grid',
                    'dataProvider'=>$dataProvider,
                    'columns'=>array(
                                     'sbj_number',
                                     'sbj_name'),
                    ));?>


