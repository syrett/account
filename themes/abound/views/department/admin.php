<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 部门管理';
$this->breadcrumbs=array(
	'部门管理',
);

$this->menu=array(
	array('label'=>'<span class="glyphicon glyphicon-plus-sign"></span> 添加部门',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-primary')
		  ),
);
?>
<div class="row">
	<h2>部门管理</h2>
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
        'id'=>'department-grid',
        'dataProvider'=>$model->search(),
        'itemsCssClass' => 'table table-striped table-hover',
        'columns'=>array(
            'name',
            'memo',
             array(
                'class'=>'CButtonColumn',
                            'buttons'=>array(
                            		'update'=>array(
                            			'options'=>array('class'=>'btn btn-default btn-xs tip','title'=>'编辑'),
                            			'label'=>'<span class="glyphicon glyphicon-pencil"></span>',
                            			'imageUrl'=>false,
                            			),
                            		'delete'=>array(
                            			'options'=>array('class'=>'btn btn-default tip btn-xs delete','title'=>'删除'),
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
