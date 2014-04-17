<?php
/* @var $this VendorController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 供应商管理';
$this->breadcrumbs=array(
	'供应商管理',
);

$this->menu=array(
		array('label'=>'<span class="glyphicon glyphicon-plus-sign"></span> 添加供应商',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-primary')
		  ),
	array('label'=>'<span class="glyphicon glyphicon-th-list"></span> 供应商列表',
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn btn-success')
		  ),	
);
?>
<div class="row">
	<h2>供应商管理</h2>
		  <?php $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'nav nav-tabs'),
			));
			?>
</div>

<div class="row">
            <?php
            /* @var $this SubjectsController */
            /* @var $model Subjects */

            ?>

            <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>