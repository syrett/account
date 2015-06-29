<?php
/* @var $this StockController */
/* @var $model Stock */

$this->pageTitle = Yii::app()->name . ' - 库存商品查看';
$this->breadcrumbs = array(
    '库存商品查看',
);
?>
<div class="panel panel-success voucher form">
    <!-- Default panel contents -->
    <div class="panel-heading">
        <h2>库存商品查看</h2>
    </div>

    <div class="well well-sm">
        <?php
        //        echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> 添加', array('create'), array('class' => 'btn btn-default'));
        ?>
    </div>
    <div class="panel-body">
        <?php
        if($action=='')
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'stock-grid',
            'dataProvider' => $model->search2(),
            'itemsCssClass' => 'table table-striped table-hover',
            'columns' => array(
                array(
                    'name'=>'id',
                ),
                array(
                    'header'=>'名称',
                    'name'=>'name',
                ),
                array(
                    'header'=>'总数',
                    'name'=>'mount',
                ),
                array(
                    'header'=>'库存余量',
                    'name'=>'left',
                ),
                array(
                    'header' => '查看',
                    'class' => 'CButtonColumn',
                    'buttons' => array(
                        'update' => array(
                            'url' => 'Yii::app()->createUrl("/stock/view", ["id"=>$data["id"]])',
                            'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => '编辑'),
                            'label' => '<span class="glyphicon glyphicon-pencil"></span>',
                            'imageUrl' => false,
                        ),
                    ),
                    'template' => '<div class="btn-group">{update}</div>',
                ),
            ),
        ));
        elseif($action=='order')    //按订单显示
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'stock-grid',
                'dataProvider' => $model->search2(['action'=>$action]),
                'itemsCssClass' => 'table table-striped table-hover',
                'columns' => array(
                    array(
                        'name'=>'id',
                    ),
                    array(
                        'header'=>'订单号',
                        'name'=>'order_no',
                    ),
                    array(
                        'header'=>'商品名',
                        'name'=>'name',
                    ),
                    array(
                        'header'=>'商品总数',
                        'name'=>'amount',
                    ),
                    array(
                        'header'=>'商品总价',
                        'name'=>'summary',
                    ),
                    array(
                        'header'=>'已付',
                        'value'=>''
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'buttons' => array(
                            'update' => array(
                                'url' => 'Yii::app()->createUrl("/stock/view", ["id"=>$data["id"],"action"=>"order"])',
                                'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => '编辑'),
                                'label' => '<span class="glyphicon glyphicon-pencil"></span>',
                                'imageUrl' => false,
                            ),
                        ),
                        'template' => '<div class="btn-group">{update}</div>',
                    ),
                ),
            ));
        ?>
    </div>
