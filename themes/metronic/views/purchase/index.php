<?php
/* @var $this PurchaseController */
/* @var $model Purchase */

$this->breadcrumbs = array(
    Yii::t('import', 'PURCHASE') => array('index')
);

$this->menu = array(
    array('label' => '导入采购信息', 'url' => array('transition/index')),
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
        <h2>采购原始数据管理</h2>
    </div>
    <div class="panel-body">
        <?php
        foreach (Yii::app()->user->getFlashes() as $key => $message) {
            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
        }
        ?>
        <div class="well well-sm head-button">
            <?php
            require_once(dirname(__FILE__) . '/../layouts/action_navigation.php');
            ?>
        </div>
        <div class="alert alert-info">
            提示：可以通过比较符号 (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>或者 <b>=</b>) 来进行搜索
        </div>
        <!-- search-form -->

        <input type="hidden" id="delall" value="<?= CHtml::normalizeUrl(array('/purchase/delall/'))?>" >
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'subjects-grid',
            'dataProvider' => $model->search(),
            'itemsCssClass' => 'table table-bordered',
            'rowCssClass' => array('row-odd', 'row-even'),
            'filter' => $model,
            'pager' => array('class' => 'CLinkPager', 'header' => '', 'firstPageLabel' => '首页', 'lastPageLabel' => '末页', 'nextPageLabel' => '下一页', 'prevPageLabel' => '上一页'),
            'columns' => array(
                array(
                    'selectableRows' => 2,
                    'footer' => '<span class="glyphicon glyphicon-trash" onclick="GetCheckbox();" ></span>',
                    'class' => 'CCheckBoxColumn',
                    'headerHtmlOptions' => array('width' => '33px'),
                    'checkBoxHtmlOptions' => array('name' => 'selectdel[]'),
                ),
                array(
                    'name' => 'order_no',
                    'type' => 'shortText',
                    'filter'=>CHtml::activeTextField($model, 'entry_name',array("class"=>"input_mid")),
                ),
                array(
                    'name' => 'entry_date',
                    'value' => 'date("Y年m月d日",strtotime($data->entry_date))',
                    'filter'=>CHtml::activeTextField($model, 'entry_name',array("class"=>"input_mid")),
                ),
                array(
                    'name' => 'entry_name',
                    'type' => 'shortText',
                    'filter'=>CHtml::activeTextField($model, 'entry_name',array("class"=>"input_mid")),
                ),
                array(
                    'name' => 'price',
                    'filter'=>CHtml::activeTextField($model, 'entry_name',array("class"=>"input_mid")),
                ),
                array(
                    'name' => 'count',
                    'filter'=>CHtml::activeTextField($model, 'entry_name',array("class"=>"input-xsmall")),
                ),
                array(
                    'name' => 'paied',
                    'type' => 'shortText',
                    'value' => '$data->getPaid()',
                    'filter'=>CHtml::activeTextField($model, 'entry_name',array("class"=>"input-xsmall")),
                ),
                array(
                    'name' => 'create_time',
                    'value' => 'date("Y年m月d日",strtotime($data->create_time))',
                    'filter'=>CHtml::activeTextField($model, 'entry_name',array("class"=>"input_mid")),
                ),
                array(
                    'class' => 'CButtonColumn',
                    'buttons' => array(
                        'update' => array(
                            'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => '编辑'),
                            'label' => '<span class="glyphicon glyphicon-pencil"></span>',
                            'imageUrl' => false,
                        ),
                        'delete' => array(
                            'options' => array('class' => 'btn btn-default tip delete btn-xs', 'title' => '删除'),
                            'label' => '<span class="glyphicon glyphicon-trash"></span>',
                            'imageUrl' => false,
                        ),
                    ),
                    'template' => '<div class="btn-group">{update}{delete}</div>',
                    'deleteConfirmation' => '确定要删除该条记录？',
                    'afterDelete' => 'function(link, success, data){
                        if(success){
                            var data = JSON.parse(data);
                            alert(data.message);
                        }
                    }'
                ),

            ),
            'pager' => array('class' => 'CLinkPager', 'header' => '', 'firstPageLabel' => '首页', 'lastPageLabel' => '末页', 'nextPageLabel' => '下一页', 'prevPageLabel' => '上一页'),

        ));
        ?>
    </div>
</div>