<?php
/* @var $this StockController */
/* @var $model Stock */

$this->pageTitle = Yii::app()->name . Yii::t('import', ' - 无形资产查看');
$this->breadcrumbs = array(
    Yii::t('import', '无形资产查看'),
);
$total = Stock::getTotal('1701','worth');
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="font-green-sharp"><?= Yii::t('import', '无形资产查看') ?></span>
            <span class="caption-helper"><?= Yii::t('import', '无形资产总计:') ?><?= $total?></span>
        </div>
    </div>


    <div class="panel-body">
        <?php

        $where = "(entry_subject like '1701%')";
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
                    [
                        'header' => Yii::t('models/model','折旧'),
                        'value' => '$data->in_price - $data->getWorth()'
                    ],
                    [
                        'header' => Yii::t('models/model','净值'),
                        'value' => '$data->getWorth()'
                    ],
                    [
                        'header' => Yii::t('models/model','部门'),
                        'value' => 'Department::model()->getNameByOrderNo($data->order_no,$data->department_id)'
                    ],
                    [
                        'class' => 'CButtonColumn',
                        'buttons' => array(
                            'scrap' => array(   //报废
                                'options' => array(
                                    'class' => 'btn btn-default tip btn-xs',
                                    'title' => Yii::t('import','报废'),
                                    'confirm' => Yii::t('import','确定要报废？报废后将无法撤消'),
                                    'ajax' => [
                                        'dataType' => 'json',
                                        'url' => 'js:$(this).attr("href")',
                                        'success' => 'js:function(data) {
                                                        alert(data.msg);
                                                $.fn.yiiGridView.update("assets-grid")}'
                                    ]
                                ),
                                'label' => "<span class='glyphicon'>".Yii::t('import', '报废')."</span>",
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("/Stock/scrap", ["id"=>$data->id,"action"=>"scrap"])'
//                                'url' => 'Yii::app()->createUrl("/Stock/scrap", ["id"=>$data->id,"action"=>$data->status==4?"unscrap":"scrap"])'
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
