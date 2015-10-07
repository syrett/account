<?php
$this->pageTitle=Yii::app()->name . ' - 期初明细';
$this->breadcrumbs=array(
	'期初明细',
);

$columns = [];
switch($type){
    case '1601':
        $columns = [
            'name',
            'model',
            'in_price',
            'value_month',
            'value_rate',
            [
                'name' => 'entry_subject',
                'value' => 'Subjects::getName($data->entry_subject)'
            ],
        ];
        break;
    case '1405':
        $columns = [
            'name',
            'model',
            'in_price',
        ];
        break;
}

$balance = Subjects::get_balance($type);
$cdb = clone $dataProvider->getCriteria();
$cdb->select = 'sum(in_price) AS total';
$total =  Stock::model()->find($cdb);
?>
<div class="panel panel-default voucher form">
    <!-- Default panel contents -->
    <div class="panel-heading">
        <h2><?= Subjects::getName($type) ?>期初明细</h2>
        <span class="caption-helper">期初余额:<?= round2($balance)?>&nbsp;&nbsp;&nbsp;明细合计:<?= round2($total->total) ?></span>
    </div>
    <div class="panel-body">
        <?php
        array_push($columns ,
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
                'template' => '<div class="btn-group">{update}</div>',
                'deleteConfirmation' => '确定要删除该条记录？',
            ));
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'vendor-grid',
            'dataProvider' => $dataProvider,
            'itemsCssClass' => 'table table-striped table-hover',
            'filter' => $model,
            'columns' => $columns
            )
        ); ?>
    </div>
</div>
