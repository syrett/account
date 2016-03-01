<?php
/* @var $this CostController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    Yii::t('import', 'Costs') => array('index')
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
        <h2><?= Yii::t('import', '成本结转原始数据管理') ?></h2>
    </div>
    <div class="panel-body">
        <?php
        foreach (Yii::app()->user->getFlashes() as $key => $message) {
            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
        }
        ?>
        <!-- search-form -->

        <input type="hidden" id="delall" value="<?= CHtml::normalizeUrl(array('/cost/delall/'))?>"
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'subjects-grid',
            'dataProvider' => $model->search(),
            'itemsCssClass' => 'table table-bordered',
            'rowCssClass' => array('row-odd', 'row-even'),
            'filter' => $model,
            'pager' => array('class' => 'CLinkPager', 'header' => '', 'firstPageLabel' => Yii::t('import', '首页'), 'lastPageLabel' => Yii::t('import', '末页'), 'nextPageLabel' => Yii::t('import', '下一页'), 'prevPageLabel' => Yii::t('import', '上一页')),
            'columns' => array(
                array(
                    'selectableRows' => 2,
//                    'footer' => '<span class="glyphicon glyphicon-trash" onclick="GetCheckbox();" ></span>',
                    'class' => 'CCheckBoxColumn',
                    'headerHtmlOptions' => array('width' => '33px'),
                    'checkBoxHtmlOptions' => array('name' => 'selectdel[]'),
                ),
                array(
                    'name' => 'order_no',
                    'type' => 'shortText',
                    'filter'=>CHtml::activeTextField($model, 'order_no',array("class"=>"input_mid")),
                ),
                array(
                    'name' => 'entry_date',
                    'value' => 'date("Y年m月",strtotime($data->entry_date))',
                    'filter'=>CHtml::activeTextField($model, 'entry_date',array("class"=>"input_mid")),
                ),
                'entry_name',
                'model',
                'count',
                array(
                    'class' => 'CButtonColumn',
                    'buttons' => array(
                        'update' => array(
                            'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => Yii::t('import', '编辑')),
                            'label' => '<span class="glyphicon glyphicon-pencil"></span>',
                            'imageUrl' => false,
                        ),
                        'delete' => array(
                            'options' => array('class' => 'btn btn-default tip delete btn-xs', 'title' => Yii::t('import', '删除')),
                            'label' => '<span class="glyphicon glyphicon-trash"></span>',
                            'imageUrl' => false,
                        ),
                    ),
                    'template' => '<div class="btn-group">{update}{delete}</div>',
                    'deleteConfirmation' => Yii::t('import', '确定要删除该条记录？'),
                    'afterDelete' => 'function(link, success, data){
						if(success){
							var data = JSON.parse(data);
							alert(data.message);
						};
                    	setTimeout(function(){ Metronic.initUniform("input:checkbox") }, 500);
					}'
                ),

            ),
            'pager' => array('class' => 'CLinkPager', 'header' => '', 'firstPageLabel' => Yii::t('import', '首页'), 'lastPageLabel' => Yii::t('import', '末页'), 'nextPageLabel' => Yii::t('import', '下一页'), 'prevPageLabel' => Yii::t('import', '上一页')),

        ));
        ?>
    </div>
</div>