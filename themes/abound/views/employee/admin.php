<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 员工管理';
$this->breadcrumbs=array(
	'员工管理',
);

$this->menu=array(
	array('label'=>'<i class="icon-plus-sign"></i> 添加员工',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn')
		  ),
);
?>
<div class="row-fluid">
	<h2>员工管理</h2>
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
        'id'=>'employee-grid',
        'dataProvider'=>$dataProvider,
        'itemsCssClass' => 'table table-striped table-bordered table-hover',
        'columns'=>array(
            'name',
            'department.name',
            'memo',
             array(
                'class'=>'CButtonColumn',
                'template' => '{update} {delete}', 
             ),
        ),
   )); ?>
</div>
