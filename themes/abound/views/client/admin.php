<?php
/* @var $this ClientController */
/* @var $model Client */

$this->pageTitle=Yii::app()->name . ' - 客户管理';
$this->breadcrumbs=array(
	'客户管理',
);

$this->menu=array(
	array('label'=>'<span class="glyphicon glyphicon-plus-sign"></span> 添加客户',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-primary')
		  ),
);

?>
<div class="row-fluid">
	<h2>客户管理</h2>
	<?php $this->widget('zii.widgets.CMenu', array(
		/*'type'=>'list',*/
		'encodeLabel'=>false,
		'items'=>$this->menu,
		'htmlOptions'=>array('class'=>'nav nav-tabs'),
		));
	?>
</div>
<div class="row-fluid">
<?php $this->widget('zii.widgets.grid.CGridView', array(
     'id'=>'client-grid',
     'dataProvider'=>$model->search(),
     'itemsCssClass' => 'table table-striped table-hover',
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
                            			'options'=>array('class'=>'btn btn-default tip btn-xs delete','title'=>'删除'),
                            			'label'=>'<span class="glyphicon glyphicon-trash"></span>',
                            			'imageUrl'=>false,
                            			),
                            		),
                            'template' => '<div class="btn-group">{update} {delete}</div>', 
                            'deleteConfirmation' => '确定要删除该条记录？',
                            ),
    ),
    'pager' => array('class'=>'CLinkPager', 'header' => '','firstPageLabel'=>'首页','lastPageLabel'=>'末页','nextPageLabel'=>'下一页','prevPageLabel'=>'上一页'),

));
?>
</div>
