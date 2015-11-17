<?php
/* @var $this StockController */
/* @var $model Stock */

$this->pageTitle = Yii::app()->name . ' - 固定资产查看';
$this->breadcrumbs = array(
    '固定资产查看',
);
$total_in = Stock::getTotal('1601','in_price');
$total_worth = Stock::getTotal('1601','worth');
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="font-green-sharp">固定资产查看</span>
            <span class="caption-helper">固定资产原值总计:<?= $total_in?></span>
            <span class="caption-helper">固定资产净值总计:<?= $total_worth?></span>
        </div>
    </div>

    <div class="panel-body">
        <?php

        $where = "(entry_subject like '1601%')";
        $stocks = Stock::model()->findByAttributes([], $where);
        $dataProvider = new CActiveDataProvider('Stock', ['criteria' => ['condition' => $where]]);
        $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'assets-grid',
                'dataProvider' => $dataProvider,
                'itemsCssClass' => 'table table-striped table-hover',
                'columns' => array(
                    'id',
                    'hs_no',
                    'in_date',
                    [
                        'name' => 'entry_subject',
                        'value' => 'Subjects::getSbjPath($data->entry_subject)'
                    ],
                    'name',
                    'model',
                    'in_price',
                    'value_month',
                    'value_rate',
                    [
                        'header' => '折旧',
                        'value' => '$data->in_price - $data->getWorth()'
                    ],
                    [
                        'header' => '净值',
                        'value' => '$data->getWorth()'
                    ],
                    [
                        'header' => '部门',
                        'value' => 'Department::model()->getNameByOrderNo($data->order_no,$data->department_id)'
                    ],
                    [
                        'class' => 'CButtonColumn',
                        'buttons' => array(
                            'scrap' => array(   //报废
                                'options' => array(
                                    'class' => 'btn btn-default tip btn-xs',
                                    'title' => '操作',
                                    'confirm' => '确定要执行此操作？',
                                    'ajax' => [
                                        'dataType' => 'json',
                                        'url' => 'js:$(this).attr("href")',
                                        'success' => 'js:function(data) {
                                                        alert(data.msg);
                                                $.fn.yiiGridView.update("assets-grid")}'
                                    ]
                                ),
                                'label' => "<span class='glyphicon'>报废</span>",
                                'imageUrl' => false,
//                                        'url' => 'Yii::app()->createUrl("/Stock/scrap", ["id"=>$data->id,"action"=>$data->status==4?"unscrap":"scrap"])'
                            ),
//                                    'unscrap' => array(
//                                        'options' => array(
//                                            'class' => 'btn btn-default tip btn-xs',
//                                            'title' => '编辑',
//                                            'confirm' => '确定要报废？',
//                                            'ajax' => [
//                                                'dataType' => 'json',
//                                                'url' => 'js:$(this).attr("href")',
//                                                'success' => 'js:function(data) {
//                                                    alert(data.msg);
//                                                $.fn.yiiGridView.update("assets-grid")}'
//                                            ]
//                                        ),
//                                        'label' => "<span class='glyphicon glyphicon-ok-circle'></span>",
//                                        'imageUrl' => false,
//                                    ),
                        ),
                        'template' => '<div class="btn-group">{scrap}</div>',
                    ]

                ))
        );
        ?>
    </div>
