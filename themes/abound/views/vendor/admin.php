<?php

$this->pageTitle=Yii::app()->name . ' - 供应商管理';
$this->breadcrumbs=array(
	'供应商管理',
);

$this->menu=array(
	array('label'=>'<i class="icon-plus-sign icon-white"></i> 添加供应商',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-success')
		  ),
);
?>
<div class="row-fluid">
	<h2>供应商管理</h2>
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
        'id'=>'vendor-grid',
        'dataProvider'=>$dataProvider,
        'itemsCssClass' => 'table table-striped table-bordered table-hover',
        'filter' => $model,
        'columns'=>array(
            'company',
            'vat',
            'phone',
            'add',
            'memo',
             array(
                'class'=>'CButtonColumn',
                'header'=>'操作',
                'template' => '{update} {delete}', 
                'deleteConfirmation' => "js:'删除该条记录后不可恢复。确定删除？'",
             ),
        ),
   )); ?>
</div>
