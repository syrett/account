<?php
$this->pageTitle=Yii::app()->name . ' - 供应商管理';
$this->breadcrumbs=array(
	'供应商管理',
);

?>
<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
		<span class="font-green-sharp">供应商管理</span>
		</div>
		<div class="actions">
		    <?php
				echo CHtml::link('<i class="fa fa-edit"></i> 添加供应商', array('create'), array('class' => 'btn btn-circle btn-primary btn-sm'));
    		?>
			<a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" data-original-title title="全屏"></a>
		</div>
	</div>
	<div class="portlet-body">
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
</div>
