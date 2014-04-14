<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 项目管理';
$this->breadcrumbs=array(
	'项目管理',
);

$this->menu=array(
	array('label'=>'<i class="icon-plus-sign"></i> 添加项目',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn')
		  ),
);
?>
<div class="row-fluid">
	<h2>项目管理</h2>
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
$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'project-grid',
        'dataProvider'=>$dataProvider,
        'itemsCssClass' => 'table table-striped table-bordered table-hover',
        'columns'=>array(
            'name',
            'memo',
             array(
                'class'=>'CButtonColumn',
                'template' => '{update} {delete}', 
             ),
        ),
   )); ?>
</div>
