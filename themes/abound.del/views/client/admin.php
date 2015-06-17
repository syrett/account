<?php
/* @var $this ClientController */
/* @var $model Client */

$this->pageTitle=Yii::app()->name . ' - 客户管理';
$this->breadcrumbs=array(
	'客户管理',
);

?>
<div class="panel panel-success voucher form">
    <!-- Default panel contents -->
    <div class="panel-heading">
		<h2>客户管理</h2>
	</div>
	<div class="well well-sm">
	<?php
	echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> 添加',array('create'),array('class' => 'btn btn-default'));
	?>
	</div>
    <div class="panel-body">
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
</div>
