<?php
$this->pageTitle = Yii::app()->name . ' - 期初明细';
$this->breadcrumbs = array(
    '期初明细',
);

$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->clientScript;
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/balance_cost.js');
$columns = [];
switch ($type) {
    case '1601':
        $columns = [
            'name',
            'model',
            'in_price',
            [
                'name' => 'worth',
                'value' => '$data->getWorth()'
            ],
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
$total = 0;
$balance = Subjects::get_balance($type);
$cdb = clone $dataProvider->getCriteria();
$stocks = Stock::model()->findAll($cdb);
if ($stocks)
    foreach ($stocks as $item) {
        $temp = explode(',', $item['worth']);
        $total += $temp[0] != '' ? $temp[0] : $item['in_price'];
    }

?>
<div class="portlet light">
    <!-- Default panel contents -->
    <?php
    foreach (Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>
    <div class="portlet-title">
        <div class="caption">
            <span class="font-green-sharp"><?= $type == '1405' ? '库存商品' : '长期资产' ?>期初明细</span>
            <span class="caption-helper">总账期初余额:<?= round2($balance) ?>
                &nbsp;&nbsp;&nbsp;明细合计:<?= round2($total) ?></span>
        </div>

        <div class="actions">
            <div class="actions">
                <?php echo CHtml::link('清空期初余额', "#truncate", array('class' => 'btn btn-circle btn-default', 'data-toggle' => 'modal')); ?>

                <input id="url_truncate" type="hidden" value="<?= $this->createUrl('stock/truncate') ?>">
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <div id="truncate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="truncatelabel"
             aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">确认要清空期初明细？</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            以下科目期初余额明细将清空！！！
                        </p>
                        <?
                        if ($type == '1601') {
                            $msg = Subjects::getName('1601') . ',' . Subjects::getName('1701') . ',' . Subjects::getName('1801');
                        } elseif ($type == '1405')
                            $msg = Subjects::getName('1403') . ',' . Subjects::getName('1405');
                        echo "包含 $msg ";
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn default" data-dismiss="modal" aria-hidden="true">取消</button>
                        <a onclick="javascript:truncate('<?= $type ?>');">
                            <button data-dismiss="modal" class="btn blue">确认</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        array_push($columns,
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
