<?php
$this->pageTitle=Yii::app()->name . ' - 供应商管理';
$this->breadcrumbs=array(
	'供应商管理',
);

$this->menu=array(
	array('label'=>'<span class="glyphicon glyphicon-plus-sign"></span> 添加供应商',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-primary')
		  ),
);
?>
<div class="row">
	<h2>供应商管理</h2>
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
        'id'=>'vendor-grid',
        'dataProvider'=>$dataProvider,
        'itemsCssClass' => 'table table-striped table-hover',
        'filter' => $model,
        'columns'=>array(
            'company',
            'vat',
            'phone',
            'add',
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
                'header' => '操作',
                'htmlOptions' => array('style'=>'min-width: 68px;'),
                'template' => '<div class="btn-group">{update} {delete}</div>', 
                'deleteConfirmation' => '确定要删除该条记录？',
             ),
        ),
   )); ?>
</div>
