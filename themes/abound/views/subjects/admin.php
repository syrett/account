<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/checkinput.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/subjects.js', CClientScript::POS_HEAD);

/* @var $this SubjectsController */
/* @var $model Subjects */
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

$this->pageTitle=Yii::app()->name . ' - 科目表管理';
$this->breadcrumbs=array(
	'科目表管理',
);

$this->menu=array(
	array('label'=>'<span class="glyphicon glyphicon-plus-sign"></span> 添加科目',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-default btn-sm')
		  ),
);

?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h2>科目表管理</h2>
	</div>
	<div class="panel-body">
		<div class="alert alert-info">提示：可以通过比较符号 (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>或者 <b>=</b>) 来进行搜索</div>
		<div class="operations">
			<?php $this->widget('zii.widgets.CMenu', array(
				/*'type'=>'list',*/
				'encodeLabel'=>false,
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'nav nav-pills navbar-right'),
				));
				?>
		</div>
		<!-- search-form -->
	<?php
			$this->widget('zii.widgets.grid.CGridView', array(
					'id' => 'subjects-grid',
					'dataProvider' => $dataProvider,
					'filter' => $model,
					'filterCssClass'=>'filter',
					'itemsCssClass' => 'table table-striped table-hover',
	//                'filterSelector'=>'{filter}, #sbj_cat',
					'columns' => array(
						array(
							'name'=>'sbj_number',
							'filter'=>CHtml::tag('div',array('class'=>'select2-search'),CHtml::textField('sbj_number','',array('class'=>'select2-input'))),
							),
						'sbj_name',
	//                    array(
	//                        'name'=>'sbj_cat',
	//                            'filter'=>Select2::dropDownList('Subjects[sbj_cat]',$model->sbj_cat,CHtml::listData(Subjects::model()->findall(), 'sbj_cat', 'sbj_cat')),
	//                    ),
	//                    array('name'=>'sbj_cat','header'=>'Active','filter'=>array('1'=>'a','2'=>'b'),'value'=>'$data->sbj_cat'),
	//                    'sbj_table',
						array(
							'class' => 'CButtonColumn',
								'buttons'=>array(
										'update'=>array(
											'options'=>array('class'=>'btn btn-default tip btn-xs','title'=>'编辑'),
											'label'=>'<span class="glyphicon glyphicon-pencil"></span>',
											'imageUrl'=>false,
											),
										),
								'template' => '<div class="btn-group">{update}</div>', 
								'deleteConfirmation' => '确定要删除该条记录？',
						),
					),
					'pager' => array('class'=>'CLinkPager', 'header' => '','firstPageLabel'=>'首页','lastPageLabel'=>'末页','nextPageLabel'=>'下一页','prevPageLabel'=>'上一页'),
				));
	//            echo Select2::dropDownList('Subjects[sbj_cat]',$model->sbj_cat,array('1'=>'资产类','2'=>'负债类','3'=>'权益类','4'=>'收入类','5'=>'费用类',));
	//            echo Select2::dropDownList('sbj_cat',$model->attribute,CHtml::listData(Subjects::model()->findall(), 'sbj_cat', 'sbj_cat'),'');
	?>
	</div>
</div>

