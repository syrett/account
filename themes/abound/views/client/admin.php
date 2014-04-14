<?php
/* @var $this ClientController */
/* @var $model Client */

$this->pageTitle=Yii::app()->name . ' - 客户管理';
$this->breadcrumbs=array(
	'客户管理',
);

$this->menu=array(
	array('label'=>'<i class="icon-plus-sign icon-white"></i> 添加客户',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-success')
		  ),
);

?>
<div class="row-fluid">
	<h2>科目表管理</h2>
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
                            'template' => '{update} {delete}', 
                            ),
                ),
));
?>
</div>
