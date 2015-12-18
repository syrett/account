<?php
/* @var $this TransitionController */
/* @var $model Transition */
/* @var $operation Transition action */
$this->pageTitle = Yii::app()->name . ' - 会计凭证管理';
$this->breadcrumbs = array(
    '查询凭证'
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
$this->menu = array(
    array('label' => '<span class="glyphicon glyphicon-plus"></span> 添加',
        'url' => $this->createUrl('transition/create'),
        'linkOptions' => array('class' => 'btn btn-circle btn-default')
    ),
//	array('label'=>'<span class="glyphicon glyphicon-print"></span> 打印',
//		  'url'=>array('#'),
//		  'linkOptions'=>array('class'=>'btn btn-default')
//		  ),
    array('label' => '<span class="glyphicon glyphicon-export"></span> 导出',
        'url' => '#',
        'linkOptions' => array('class' => 'btn btn-circle btn-default', 'onclick' => 'tranToExcel()')
    ),
);
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/_search.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/excel_export.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/pages/scripts/components-pickers.js', CClientScript::POS_END);

$cs->registerScript('ComponentsPickersInit', 'ComponentsPickers.init();', CClientScript::POS_READY);
?>

<div class="portlet light">
    <!-- Default panel contents -->
    <div class="portlet-title">
        <div class="caption"><?php
            $title = '';
            if (!isset($operation))
                $operation = 'listTransition';
            switch ($operation) {
                case 'listReview' :
                    $title = '审核凭证';
                    break;
                case 'listTransition' :
                    $title = '查询凭证';
                    break;
                case 'listReview' :
                    $title = '凭证过账';
                    break;
                case 'listReview' :
                    $title = '期末结账';
                    break;
            }
            echo $title;
            ?>
        </div>
        <div class="actions">
            <?php
            echo CHtml::beginForm($this->createUrl('/Transition/createexcel'), 'post', array('id' => 'export'));
            ?>
            <a href="<?= $this->createUrl('transition/create') ?>" class="btn btn-circle btn-sm btn-default"><i
                    class="glyphicon glyphicon-plus"></i> 添加</a>
            <a href="javascript:;" onclick="tranToExcel()" class="btn btn-circle btn-sm btn-default"><i
                    class="glyphicon glyphicon-export"></i> 导出</a>
            <a href="javascript:;" class="btn btn-circle btn-default btn-sm btn-icon-only fullscreen"
               data-original-title="" data-original-title title="全屏"></a>
        </div>
        <?php
        echo CHtml::endForm();
        ?>
    </div>
    <div class="portlet-body voucher form">
        <div class="row">
            <div class="col-md-4 pull-right">
                <?php
                if ($operation != 'listReview') {
                    ?>
                    背景颜色说明：
                    <span class="reviewed">已审核</span>&nbsp;&nbsp;
                    <span class="deleted">已删除</span>
                    <?php
                }
                ?>
            </div>
            <div class="col-md-6">
                <?php echo CHtml::beginForm(); ?>
                <div class="input-group input-large " >
                    <div class="input-group date-picker input-daterange" data-date-format="yyyy/mm/dd">
                        <span class="input-group-addon">日期范围：</span>
                        <input type="text" class="form-control input-small" name="s_day" id="s_day" value="<?=isset($_POST['s_day'])?$_POST['s_day']:''?>">
                        <span class="input-group-addon"> 至 </span>
                        <input type="text" class="form-control input-small" name="e_day" id="e_day" value="<?=isset($_POST['e_day'])?$_POST['e_day']:''?>">
                    </div>
                    <span class="input-group-addon"> 摘要 </span>
                    <input type="text" class="form-control input-small" name="memo" id="memo" value="<?=isset($_POST['memo'])?$_POST['memo']:''?>">
				<span class="input-group-btn">
				<?php
                echo CHtml::htmlButton('<span class="glyphicon glyphicon-search"></span> 查找', array('class' => 'btn btn-default', 'type' => 'submit'));
                ?>
				</span>
                    <!-- search-form -->
                </div>
                <?php echo CHtml::endForm(); ?>
            </div>
        </div>
        <?php

        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'subjects-grid',
            'emptyText' => '暂无相关数据',
            'dataProvider' => $model->search(),
            'rowCssClass' => array('row-odd', 'row-even'),
//            'filter' => $model,
            'rowCssClassExpression' => '$data->getClass($row,$data->entry_reviewed,$data->entry_deleted)',
            'pager' => array('class' => 'CLinkPager', 'header' => '', 'firstPageLabel' => '首页', 'lastPageLabel' => '末页', 'nextPageLabel' => '下一页', 'prevPageLabel' => '上一页'),
            'itemsCssClass' => 'table table-striped table-bordered dataTable table-hover no-footer',
            'htmlOptions' => array('role' => 'grid'),
            'columns' => array(
                array(
                    'selectableRows' => 2,
                    'class' => 'CCheckBoxColumn',
//                    'headerHtmlOptions' => array('width'=>'33px', 'class'=>'table-checkbox sorting_disabled'),
                    'checkBoxHtmlOptions' => array('name' => 'selectall[]'),
                ),
                array(
                    'name' => 'entry_number',
                    'value' => '$data->entry_num_prefix. $data->addZero($data->entry_num)',
                    'headerHtmlOptions' => array('class' => 'sorting_asc', 'aria-sort' => 'ascending'),
                ),
                array(
                    'name' => 'entry_memo',
//					'type'=>'shortText',
                    'headerHtmlOptions' => array('class' => 'sorting_disabled'),
                    'sortable' => false,
                ),
                array(
                    'name' => 'entry_transaction',
                    'type' => 'shortText',
                    'value' => '$data->transaction($data->entry_transaction)',
                    'filterHtmlOptions' => array('class' => 'input-xsmall'),
                    'htmlOptions' => array('class' => 'input-xsmall'),
                ),
                array('name' => 'entry_subject', 'value' => '$data->getSbjPath($data->entry_subject)'),
                array('name' => 'entry_amount', 'htmlOptions' => array('class' => 'amount')),
                array(
                    'name' => 'entry_appendix',
                    'value' => '$data->getAppendix($data->entry_appendix_type,$data->entry_appendix_id)',
                    'sortable' => false,
                ),
                array('name' => 'entry_posting', 'value' => '$data->getPosting($data->entry_posting)'),
                array('name' => 'entry_date', 'value' => 'date("Y年m月d日",strtotime($data->entry_date))'),

                array(
                    'class' => 'CButtonColumn',
                    'buttons' => array(
                        'update' => array(
                            'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => '编辑'),
                            'label' => '<span class="glyphicon glyphicon-pencil"></span>',
                            'imageUrl' => false,
                        )
                    ),
                    'header' => '操作',
                    'htmlOptions' => array('style' => 'min-width: 68px;'),
                    'template' => '<div class="btn-group">{update}</div>',
                ),
            ),
        ));
        echo '<div class="transition_action" ><p>';
        echo CHtml::htmlbutton('<span class="glyphicon glyphicon-ok"></span> 审核通过', array(
                'onclick' => 'setreviewed()',
                'name' => 'btnSetReview',
                'class' => 'btn btn-default btn-sm',
                'confirm' => '确认通过审核？',
            )
        );
        echo CHtml::htmlbutton('<span class="glyphicon glyphicon-repeat"></span> 取消审核', array(
                'onclick' => 'unreviewed()',
                'name' => 'btnUnReview',
                'class' => 'btn btn-default btn-sm',
                'confirm' => '确认取消审核？',
            )
        );
        echo '</p></div>';
        ?>
    </div>
</div><!-- .portlet -->
<script type="text/javascript">
    /*<![CDATA[*/
    var setreviewed = function () {
        var data = new Array();
        var sbj_number = '';
        $("input:checkbox[name='selectall[]']").each(function () {
            if ($(this).attr("checked") == "checked" && sbj_number != $(this).closest('td').next().html()) {
                data.push($(this).closest('td').next().html());
                sbj_number = $(this).closest('td').next().html();
            }
        });
        if (data.length > 0) {
            $.post('<?php echo CHtml::normalizeUrl(array('/transition/setreviewedall/'));?>', {'selectall[]': data}, function (data) {
                var ret = $.parseJSON(data);
                if (ret != null && ret.success != null) {
                    if (!ret.success)
                        alert('部分凭证必须由他人审核');
                    $.fn.yiiGridView.update("subjects-grid", {async: false});
                    Metronic.initUniform('input:checkbox')
                }
            });
        } else {
            alert("请选择要操作的行!");
        }
    }

    var unreviewed = function () {
        var data = new Array();
        var sbj_number = '';
        $("input:checkbox[name='selectall[]']").each(function () {
            if ($(this).attr("checked") == "checked" && sbj_number != $(this).closest('td').next().html()) {
                data.push($(this).closest('td').next().html());
                sbj_number = $(this).closest('td').next().html();
            }
        });
        if (data.length > 0) {
            $.post('<?php echo CHtml::normalizeUrl(array('/transition/unreviewedall/'));?>', {'selectall[]': data}, function (data) {
                var ret = $.parseJSON(data);
                if (ret != null && ret.success != null && ret.success) {
                    $.fn.yiiGridView.update("subjects-grid", {async: false});
                    Metronic.initUniform('input:checkbox')
                }
            });
        } else {
            alert("请选择要操作的行!");
        }

    }
    /*]]>*/
</script>