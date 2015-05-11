<?php
/* @var $this CashController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('import', 'CASH')=>array('index')
);

?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h2>现金原始数据管理</h2>
	</div>
	<div class="panel-body">
		<div class="well-sm">
			<? echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> 导入数据', array('/transition/cash', 'type'=>'cash'), array('class' => 'btn btn-default')); ?>
		</div>
		<div class="alert alert-info">提示：可以通过比较符号 (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>或者 <b>=</b>) 来进行搜索</div>
		<div class="operations">
			<?php $this->widget('zii.widgets.CMenu', array(
				/*'type'=>'list',*/
				'encodeLabel'=>false,
				'htmlOptions'=>array('class'=>'nav nav-pills navbar-right'),
			));
			?>
		</div>
		<!-- search-form -->
		<?php
		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'subjects-grid',
			'dataProvider' => $dataProvider,
			'summaryText' => '',
			'filter' => $model,
			'filterCssClass'=>'filter',
			'rowCssClassExpression' =>'$data->getClass($row,$data->status_id)',
			'itemsCssClass' => 'table table-bordered',
			'columns' => array(
				'target',
				'date',
				'memo',
				'amount',
				[
					'name'=>'subject',
					'value'=>'$data->getSbjName($data->subject)',
					'filter'=>false,
				],
				array(
					'class' => 'CButtonColumn',
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
					'template' => '<div class="btn-group">{update}{delete}</div>',
					'deleteConfirmation' => '确定要删除该条记录？',
				),
			),
			'pager' => array('class'=>'CLinkPager', 'header' => '','firstPageLabel'=>'首页','lastPageLabel'=>'末页','nextPageLabel'=>'下一页','prevPageLabel'=>'上一页'),
		));
		?>
	</div>
</div>