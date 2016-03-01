<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . Yii::t('import', ' - 项目管理');
$this->breadcrumbs=array(
	Yii::t('import', '项目管理'),
);
?>
<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
		<span class="font-green-sharp"><?= Yii::t('import', '项目管理') ?></span>
		</div>
		<div class="actions">
		    <?php
				echo CHtml::link('<i class="fa fa-plus"></i>'.Yii::t('import', '添加项目'), array('create'), array('class' => 'btn btn-circle btn-primary btn-sm'));
    		?>
			<a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" data-original-title title="<?= Yii::t('import', '全屏') ?>"></a>
		</div>
	</div>
	<div class="portlet-body">

<?php
$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'project-grid',
        'dataProvider'=>$dataProvider,
        'itemsCssClass' => 'table table-striped table-hover',
        'columns'=>array(
            'name',
            'memo',
             array(
                'class'=>'CButtonColumn',
                            'buttons'=>array(
                            		'update'=>array(
                            			'options'=>array('class'=>'btn btn-default tip btn-xs','title'=>Yii::t('import', '编辑')),
                            			'label'=>'<span class="glyphicon glyphicon-pencil"></span>',
                            			'imageUrl'=>false,
                            			),
                            		'delete'=>array(
                            			'options'=>array('class'=>'btn btn-default tip delete btn-xs','title'=>Yii::t('import', '删除')),
                            			'label'=>'<span class="glyphicon glyphicon-trash"></span>',
                            			'imageUrl'=>false,
                            			),
                            		),
                            'template' => '<div class="btn-group">{update} {delete}</div>', 
                            'deleteConfirmation' => Yii::t('import', '确定要删除该条记录？'),
             ),
        ),
   )); ?>
	</div>
</div>