<?php
$this->pageTitle=Yii::app()->name . ' - 供应商管理';
$this->breadcrumbs=array(
	'供应商管理',
);
$balance = Subjects::get_balance(2202);
$unpaid = Transition::getAllMount(2202,2);
$unpaid2 = Transition::getAllMount(2202,2,'before');

$paid = Transition::getAllMount(2202,1);
$paid2 = Transition::getAllMount(2202,1,'before');

$before = $balance + $unpaid2 - $paid2;
$left = $before + $unpaid - $paid;
?>
<div class="panel panel-default voucher form">
    <!-- Default panel contents -->
    <div class="panel-heading">
        <h2>供应商管理</h2>
    </div>
    <div class="well well-sm">
        <div class="banner" >
            <div class="banner-balance col-sm-8">年初: ￥<?=$before?>
                <div class="banner-paid col-sm-3">本年减少: ￥<?=$paid?></div>
                <div class="banner-in col-sm-3">本年增加: ￥<?=$unpaid?></div>
            </div>
            <div class="banner-unpaid col-sm-4">未付: ￥<?=$left?></div>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'vendor-grid',
            'dataProvider' => $dataProvider,
            'itemsCssClass' => 'table table-striped table-hover',
            'filter' => $model,
            'columns' => array(
                'company',
                'vat',
                'phone',
                [
                    'header' => '年初余额',
                    'value' => '$GLOBALS["a"] = $data->getAllMount(["type"=>"before","date"=>date("Y")."-01-01 00:00:00"])'
                ],
                [
                    'header' => '本年增加',
                    'value' => '$GLOBALS["b"] = $data->getAllMount(["entry_transaction"=>2]);',
                ],
                [
                    'header' => '本年减少',
                    'value' => '$GLOBALS["c"] = $data->getAllMount(["entry_transaction"=>1]);',
                ],
                [
                    'header' => '未付',
                    'value' => '$GLOBALS["a"]+$GLOBALS["b"]-$GLOBALS["c"]',
                ],
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
                    'header' => '操作',
                    'htmlOptions' => array('style' => 'min-width: 68px;'),
                    'template' => '<div class="btn-group">{update} {delete}</div>',
                    'deleteConfirmation' => '确定要删除该条记录？',
                ),
            ),
        )); ?>
    </div>
</div>
