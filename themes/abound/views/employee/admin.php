<?php
/* @var $this EmployeeController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 员工管理';
$this->breadcrumbs=array(
	'员工管理',
);

$this->menu=array(
	array('label'=>'<span class="glyphicon glyphicon-plus-sign"></span> 添加员工',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-primary')
		  ),
);
?>
<div class="row">
	<h2>员工管理</h2>
		  <?php $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'nav nav-pills navbar-right'),
			));
			?>
</div>

<div class="row">

<?php
$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'employee-grid',
        'dataProvider'=>$dataProvider,
        'itemsCssClass' => 'table table-striped table-hover',
        'columns'=>array(
            'name',
            'department.name',
            'memo',
             array(
                'class'=>'CButtonColumn',
                            'buttons'=>array(
                            		'update'=>array(
                            			'options'=>array('class'=>'btn btn-default tip btn-xs','title'=>'编辑'),
                            			'label'=>'<span class="glyphicon glyphicon-pencil"></span>',
                            			'imageUrl'=>false,
                            			),
                            		'delete'=>array(
                            			'options'=>array('class'=>'btn btn-default tip delete btn-xs','title'=>'删除'),
                            			'label'=>'<span class="glyphicon glyphicon-trash"></span>',
                            			'imageUrl'=>false,
                            			),
                            		),
                            'template' => '<div class="btn-group">{update} {delete}</div>', 
                            'deleteConfirmation' => '确定要删除该条记录？',
             ),
        ),
   )); ?>
</div>
