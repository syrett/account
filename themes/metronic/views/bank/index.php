<?php
/* @var $this BankController */
/* @var $model Bank */

$this->breadcrumbs=array(
	Yii::t('import', 'BANK')=>array('index')
);

$this->menu=array(
	array('label'=>'导入银行交易', 'url'=>array('transition/index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#subjects-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
		<span class="font-green-sharp">银行原始数据管理</span>
		</div>
		<div class="actions">
		    <a href="<?= $this->createUrl('transition/bank') ?>"  class="btn btn-circle btn-info btn-sm"><i class="fa fa-bank"></i> 导入银行交易</a>
		    <a href="<?= $this->createUrl('transition/cash') ?>"  class="btn btn-circle btn-info btn-sm"><i class="fa fa-money"></i> 导入现金交易</a>
		    <a href="<?= $this->createUrl('transition/create') ?>"  class="btn btn-circle btn-default btn-sm"><i class="fa fa-edit"></i> 手动录入凭证</a>
			<a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" data-original-title title="全屏"></a>
		</div>
	</div>
	<div class="portlet-body">
        <?
        foreach(Yii::app()->user->getFlashes() as $key => $message) {
            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
        }
        ?>
		<!-- search-form -->
        <input type="hidden" id="delall" value="<?= CHtml::normalizeUrl(array('/bank/delall/'))?>" >

		<?php
		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'subjects-grid',
			'dataProvider' => $dataProvider,
			'summaryText' => '',
			'filter' => $model,
			'filterCssClass'=>'filter',
			'rowCssClassExpression' =>'$data->getClass($row,$data->status_id)',
			'itemsCssClass' => 'table table-bordered',
            'htmlOptions' => array('role'=>'grid'),
			'columns' => array(
                array(
                    'selectableRows' => 2,
                    'footer' => '<span class="glyphicon glyphicon-trash" onclick="GetCheckbox();" ></span>',
                    'class' => 'CCheckBoxColumn',
                    'headerHtmlOptions' => array('width'=>'33px',),
                    'checkBoxHtmlOptions' => array('name' => 'selectdel[]'),
                ),
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
                    'afterDelete' => 'function(link, success, data){
						if(success && data != ""){
							var data = JSON.parse(data);
							alert(data.message);
						}
                    	setTimeout(function(){ Metronic.initUniform("input:checkbox") }, 500);;
                    }'
				),
			),
			'pager' => array('class'=>'CLinkPager', 'header' => '','firstPageLabel'=>'首页','lastPageLabel'=>'末页','nextPageLabel'=>'下一页','prevPageLabel'=>'上一页'),
		));
		?>
	</div>
</div>