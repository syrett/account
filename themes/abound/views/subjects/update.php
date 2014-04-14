
<?php
/* @var $this SubjectController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 会计科目管理';
$this->breadcrumbs=array(
	'会计科目管理',
);

$this->menu=array(
		array('label'=>'<i class="icon-plus-sign icon-white"></i> 添加科目',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-success')
		  ),
	array('label'=>'<i class="icon-list-alt icon-white"></i> 会计科目列表',
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn btn-primary')
		  ),	
);
?>
<div class="row-fluid">
	<h2>会计科目管理</h2>
		  <?php $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'nav nav-tabs'),
			));
			?>
</div>

<div class="row-fluid">
            <?php
            /* @var $this SubjectsController */
            /* @var $model Subjects */

            ?>

            <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>

