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

        <script type="text/javascript">
            /*<![CDATA[*/
            var GetCheckbox = function () {
                var data = new Array();
                $("input:checkbox[name='selectdel[]']").each(function () {
                    if ($(this).attr("checked") == "checked") {
                        data.push($(this).val());
                    }
                });
                if (data.length > 0) {
                    $.post('<?php echo CHtml::normalizeUrl(array('/purchase/delall/'));?>', {'selectdel[]': data}, function (data) {
                        var ret = $.parseJSON(data);
                        if (ret != null && ret.success != null && ret.success) {
                            $.fn.yiiGridView.update("subjects-grid");
                        }
                    });
                } else {
                    alert("请选择要删除的行!");
                }
            }
            /*]]>*/
        </script>
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'transition-grid',
            'dataProvider' => $model->search(),
            'itemsCssClass' => 'table table-bordered',
            'rowCssClass' => array('row-odd', 'row-even'),
            'filter' => $model,
            'pager' => array('class' => 'CLinkPager', 'header' => '', 'firstPageLabel' => '首页', 'lastPageLabel' => '末页', 'nextPageLabel' => '下一页', 'prevPageLabel' => '上一页'),
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
                    'htmlOptions' => array('class' => 'input-small'),
                    'headerHtmlOptions' => array('class' => 'input-small'),
                ),
                array(
                    'name' => 'purchase_date',
                    'value' => 'date("Y年m月d日",strtotime($data->purchase_date))',
                    'htmlOptions' => array('class' => 'input-small'),
                    'headerHtmlOptions' => array('class' => 'input-small'),
                ),
                array(
                    'name' => 'commodity',
                    'type' => 'shortText'
                ),
                array(
                    'name' => 'price',
                    'htmlOptions' => array('class' => 'input_mid'),
                    'headerHtmlOptions' => array('class' => 'input_mid'),
                ),
                array(
                    'name' => 'count',
                    'htmlOptions' => array('class' => 'input_mid'),
                    'headerHtmlOptions' => array('class' => 'input_mid'),
                ),
                array(
                    'name' => 'paied',
                    'type' => 'shortText',
                    'htmlOptions' => array('class' => 'input_mid'),
                    'headerHtmlOptions' => array('class' => 'input_mid'),
                ),
                array(
                    'name' => 'create_time',
                    'value' => 'date("Y年m月d日",strtotime($data->create_time))',
                    'htmlOptions' => array('class' => 'input-small'),
                    'headerHtmlOptions' => array('class' => 'input-small'),
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
                ),

            ),
            'pager' => array('class' => 'CLinkPager', 'header' => '', 'firstPageLabel' => '首页', 'lastPageLabel' => '末页', 'nextPageLabel' => '下一页', 'prevPageLabel' => '上一页'),

        ));
        ?>
    </div>
</div>