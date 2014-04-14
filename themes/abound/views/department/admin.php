<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 部门管理';
$this->breadcrumbs=array(
	'部门管理',
);

$this->menu=array(
	array('label'=>'<i class="icon-plus-sign"></i> 添加部门',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn')
		  ),
);
?>
<div class="row-fluid">
	<h2>部门管理</h2>
		  <?php $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'nav nav-tabs'),
			));
			?>
</div>

<div class="panel panel-default voucher">

<?php
$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'department-grid',
        'dataProvider'=>$model->search(),
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
