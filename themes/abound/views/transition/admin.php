<?php
/* @var $this TransitionController */
/* @var $model Transition */
$this->pageTitle=Yii::app()->name . ' - 会计凭证管理';
$this->breadcrumbs=array(
	'查询凭证'
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#transition-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
$this->menu=array(
	array('label'=>'<span class="glyphicon glyphicon-plus-sign"></span> 凭证录入',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-primary')
		  ),
);

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/bootstrap-datepicker.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/datepicker.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/_search.js', CClientScript::POS_HEAD);
?>
<div class="row">
	<?php $this->widget('zii.widgets.CMenu', array(
		/*'type'=>'list',*/
		'encodeLabel'=>false,
		'items'=>$this->menu,
		'htmlOptions'=>array('class'=>'nav nav-pills navbar-right'),
		));
	?>
</div>
<p>&nbsp;</p>
<div class="panel panel-default voucher form">
    <!-- Default panel contents -->
    <div class="panel-heading">
	<h2>查询凭证</h2>
    </div>
    <div class="panel-body">
	<?php echo CHtml::beginForm(); ?>
		<div class="col-md-7">
		  <div class="input-group">
			<span class="input-group-addon">开始日期：</span>
			<?php echo CHtml::textField('s_day', isset($_REQUEST['s_day'])?$_REQUEST['s_day']:"",array('class' => 'form-control',)); ?>
			<span class="input-group-addon">结束日期：</span>
			<?php echo CHtml::textField('e_day', isset($_REQUEST['e_day'])?$_REQUEST['e_day']:"",array('class' => 'form-control',)); ?>
			<span class="input-group-btn">
			<?php  echo CHtml::submitButton('查找',array('class' => 'btn btn-primary',)); ?>
			</span>
		  </div><!-- /input-group -->
		</div>
		<div class="col-md-4">背景颜色说明：
			<span class="reviewed">已审核</span>&nbsp;&nbsp;
			<span class="deleted">已删除</span>
		</div>
		<?php
			echo CHtml::endForm();
		?>
	<!-- search-form -->
    </div>
        <?php

        $this->widget('zii.widgets.grid.CGridView', array(
//            'id' => 'transition-grid',
            'dataProvider' => $model->search(),
            'rowCssClass'=>array('row-odd','row-even'),
            'filter' => $model,
            'rowCssClassExpression' =>'$data->getClass($row,$data->entry_reviewed,$data->entry_deleted)',
            'pager' => array('class'=>'CLinkPager', 'header' => '','firstPageLabel'=>'首页','lastPageLabel'=>'末页','nextPageLabel'=>'下一页','prevPageLabel'=>'上一页'),
            'columns' => array(
                array(
                    'name'=>'entry_number',
                    'value'=>'$data->entry_num_prefix. $data->addZero($data->entry_num)'),
                array('name'=>'entry_memo','type'=>'shortText'),
                array(
                    'name'=>'entry_transaction',
                    'type'=>'shortText',
                    'value'=>'$data->transaction($data->entry_transaction)',
                    'htmlOptions'=>array('style'=>'width:30px','width'=>'30px'),
                    'headerHtmlOptions'=>array('width'=>'30px'),
                ),
                array('name'=>'entry_subject','value'=>'$data->getSbjName($data->entry_subject)'),
                array('name'=>'entry_amount','htmlOptions'=>array('class'=>'amount')),
                array('name'=>'entry_appendix','value'=>'$data->getAppendix($data->entry_appendix_type,$data->entry_appendix_id)'),
                array('name'=>'entry_posting','value'=>'$data->getPosting($data->entry_posting)'),
                array('name'=>'entry_date','value'=>'date("Y年m月d日",strtotime($data->entry_date))'),

                array(
                    'class'=>'CButtonColumn',
                    'buttons'=>array(
                        'update'=>array(
                            'options'=>array('class'=>'btn btn-default tip btn-xs','title'=>'编辑'),
                            'label'=>'<span class="glyphicon glyphicon-pencil"></span>',
                            'imageUrl'=>false,
                        )
                    ),
                    'header' => '操作',
                    'htmlOptions' => array('style'=>'min-width: 68px;'),
                    'template' => '<div class="btn-group">{update}</div>',
                ),
            ),
            'itemsCssClass' => 'table table-bordered',
        )); ?>
</div>
