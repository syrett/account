<?php
/* @var $this StockController */
/* @var $model Stock */
//显示期初多少，入库多少，领用多少，还剩多少

$this->pageTitle = Yii::app()->name . ' - 库存商品查看';
$this->breadcrumbs = array(
    '库存商品查看',
);
if ($action == 'order') {

} elseif ($action == '') {
    $before = $model->getAmount(['id' => $model->id, 'type' => 'before', 'status' => 1]);
    $in = $model->getAmount(['id' => $model->id,]);   //入库
    $out = $model->getAmount(['id' => $model->id, 'status' => 2]);   //出库
    $return = $model->getAmount(['id' => $model->id, 'status' => 3]);    //退货
    $total = $before + $in;
    $left = $before + $in - $out - $return;
    $left2 = $model->getAmount(['id' => $model->id, 'status' => 1]);
    $out += $return;

}
?>
<div class="panel panel-default voucher form">
    <!-- Default panel contents -->
    <div class="panel-heading">
        <h2>库存商品查看</h2>
    </div>

    <div class="well well-sm">
        <div class="banner">
            <?php

            if ($action == 'order') {

            } elseif ($action == '') {
                ?>
                <div class="banner-balance col-sm-9">期初: <?= $before ?>
                    <div class="banner-out col-sm-2">年内出库: <?= $out ?></div>
                    <div class="banner-in col-sm-2">本年采购: <?= $in ?></div>
                </div>
                <div class="banner-paid col-sm-3">剩余: <?= $left ?></div>
            <?php
            }
            ?>
        </div>
        <?php
        //        echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> 添加', array('create'), array('class' => 'btn btn-default'));
        ?>
    </div>
    <div class="panel-body">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'stock-grid',
            'dataProvider' => $model->search2(['id' => $model->id, 'name' => 'name', 'action' => $action]),
            'itemsCssClass' => 'table table-striped table-hover',
            'columns' => array(
                array(
                    'name' => 'id',
                ),
                array(
                    'header' => '订单号',
                    'name' => 'order_no',
                ),
                array(
                    'header' => '名称',
                    'name' => 'name',
                ),
                array(
                    'header' => '供应商',
                    'name' => 'vendor_id',
                    'value' => 'Vendor::model()->getName($data["vendor_id"])',
                ),
                array(
                    'header' => '日期',
                    'name' => 'in_date',
                ),
                array(
                    'header' => '单价',
                    'name' => 'in_price',
                ),
//                array(
//                    'header' => '状态',
//                    'name' => 'status',
////                    'value'=>''
//                ),
//                array(
//                    'class' => 'CButtonColumn',
//                    'buttons' => array(
//                        'update' => array(
//                            'url' => 'Yii::app()->createUrl("/stock/update", ["id"=>$data["id"]])',
//                            'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => '编辑'),
//                            'label' => '<span class="glyphicon glyphicon-pencil"></span>',
//                            'imageUrl' => false,
//                        ),
//                    ),
//                    'template' => '<div class="btn-group">{update}</div>',
//                ),
            ),
        )); ?>
    </div>
