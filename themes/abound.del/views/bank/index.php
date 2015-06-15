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
	$('#bank-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>银行原始数据管理</h2>
	</div>
	<div class="panel-body">
        <?php
        foreach(Yii::app()->user->getFlashes() as $key => $message) {
            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
        }
        ?>
        <div class="well well-sm head-button">
            <?php
            echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> 银行交易', array('transition/bank'), array('class' => 'btn btn-default'));
            echo "\n";
            echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> 现金交易', array('transition/cash'), array('class' => 'btn btn-default'));
            echo "\n";
            echo CHtml::link('<span class="glyphicon glyphicon-pencil"></span> 手动录入', array('transition/create'), array('class' => 'btn btn-default'));
            echo "\n";
            ?>
        </div>
		<div class="alert alert-info">
			提示：可以通过比较符号 (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>或者 <b>=</b>) 来进行搜索
		</div>
		<!-- search-form -->

        <script type="text/javascript">
            /*<![CDATA[*/
            var GetCheckbox = function (){
                var data=new Array();
                $("input:checkbox[name='selectdel[]']").each(function (){
                    if($(this).attr("checked")=="checked"){
                        data.push($(this).val());
                    }
                });
                if(data.length > 0){
                    $.post('<?php echo CHtml::normalizeUrl(array('/bank/delall/'));?>',{'selectdel[]':data}, function (data) {
                        var ret = $.parseJSON(data);
                        if (ret != null && ret.success != null && ret.success) {
                            $.fn.yiiGridView.update("subjects-grid");
                        }
                    });
                }else{
                    alert("请选择要删除的行!");
                }
            }
            /*]]>*/
        </script>
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
                array(
                    'selectableRows' => 2,
                    'footer' => '<span class="glyphicon glyphicon-trash" onclick="GetCheckbox();" ></span>',
                    'class' => 'CCheckBoxColumn',
                    'headerHtmlOptions' => array('width'=>'33px'),
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
				),
			),
			'pager' => array('class'=>'CLinkPager', 'header' => '','firstPageLabel'=>'首页','lastPageLabel'=>'末页','nextPageLabel'=>'下一页','prevPageLabel'=>'上一页'),
		));
		?>
	</div>
</div>