<?php
/* @var $this TransitionController */
/* @var $model Transition */
/* @var $operation Transition action */
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
	array('label'=>'<span class="glyphicon glyphicon-plus"></span> 添加',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-default')
		  ),
//	array('label'=>'<span class="glyphicon glyphicon-print"></span> 打印',
//		  'url'=>array('#'),
//		  'linkOptions'=>array('class'=>'btn btn-default')
//		  ),
	array('label'=>'<span class="glyphicon glyphicon-export"></span> 导出',
		  'url'=>'#',
		  'linkOptions'=>array('class'=>'btn btn-default', 'onclick'=>'tranToExcel()')
		  ),
);
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/bootstrap-datepicker.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/datepicker.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/_search.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/excel_export.js', CClientScript::POS_HEAD);

?>

<div class="panel panel-default voucher form">
    <!-- Default panel contents -->
    <div class="panel-heading">
	<h2><?php
        $title = '';
        if(!isset($operation))
            $operation = 'listTransition';
        switch($operation){
            case 'listReview' : $title = '审核凭证';break;
            case 'listTransition' : $title = '查询凭证';break;
            case 'listReview' : $title = '凭证过账';break;
            case 'listReview' : $title = '期末结账';break;
        }
        echo $title;
        ?></h2>
    </div>
    <div class="panel-body">
        <?php

        echo CHtml::beginForm($this->createUrl('/Transition/createexcel'), 'post',array('id'=>'export'));
        echo CHtml::endForm();
        ?>
     <div class="row">
		<div class="col-md-4 pull-right">
			<?php
			$this->widget('zii.widgets.CMenu', array(
				/*'type'=>'list',*/
				'encodeLabel'=>false,
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'nav nav-pills'),
				));
			?>
			<br />
            <?php
            if($operation!='listReview'){
            ?>
            <div class="well">
            背景颜色说明：
			<span class="reviewed">已审核</span>&nbsp;&nbsp;
			<span class="deleted">已删除</span>
			</div>
            <?php
            }
            ?>			
		</div>
		<div class="col-md-4">
		<?php echo CHtml::beginForm(); ?>
		  <div class="input-group">
              <p class="tip">开始日期：20140101 &nbsp;&nbsp;&nbsp;&nbsp;结束日期：20140131</p>
			<span class="input-group-addon">开始日期：</span>
			<?php echo CHtml::textField('s_day', isset($_REQUEST['s_day'])?$_REQUEST['s_day']:"",array('class' => 'form-control',)); ?>

          </div>
		  <br />
		  <div class="input-group">
			<span class="input-group-addon">结束日期：</span>
			<?php echo CHtml::textField('e_day', isset($_REQUEST['e_day'])?$_REQUEST['e_day']:"",array('class' => 'form-control',)); ?>
		  </div>
		  <br />
			<?php
			  echo CHtml::htmlButton('<span class="glyphicon glyphicon-search"></span> 查找',array('class' => 'btn btn-primary', 'type' => 'submit'));
			  echo CHtml::endForm();
			?>
			<!-- search-form -->
		</div>
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
</div><!-- .panel-body -->
