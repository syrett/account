<?php
$this->pageTitle=Yii::app()->name . ' - 供应商管理';
$this->breadcrumbs=array(
	'供应商管理',
);
$total = Subjects::get_balance(2202) + Transition::getAllMount(2202,2);
$paid = Transition::getAllMount(2202,1);

$unpaid = $total - $paid;
$unpaid2 = Transition::getAllMount(2202,2);
?>
<div class="panel panel-success voucher form">
    <!-- Default panel contents -->
    <div class="panel-heading">
        <h2>供应商管理</h2>
    </div>
    <div class="well well-sm">
        <div class="banner" >
            <div class="banner-balance col-sm-6">应付: ￥<?=$total?>
                <div class="banner-unpaid col-sm-5">未付: ￥<?=$unpaid?></div>
            </div>
            <div class="banner-paid col-sm-6">已付: ￥<?=$paid?></div>
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
                'add',
                'memo',
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
