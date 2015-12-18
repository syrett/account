<?php
$this->pageTitle=Yii::app()->name . ' - 供应商管理';
$this->breadcrumbs=array(
	'供应商管理',
);

$balance = 0;
$unpaid = 0;
$unpaid2 = 0;
$paid = 0;
$paid2 = 0;
$vendors = Vendor::model()->findAll();
foreach($vendors as $vendor){
    $sbj1 = Subjects::model()->findByAttributes(['sbj_name'=>$vendor->company], 'sbj_number like "2202%"');
    $sbj2 = Subjects::model()->findByAttributes(['sbj_name'=>$vendor->company], 'sbj_number like "1123%"');
    $sbj1 = $sbj1?$sbj1->sbj_number:'';
    $sbj2 = $sbj2?$sbj2->sbj_number:'';
    $balance += Subjects::get_balance($sbj1) + Subjects::get_balance($sbj2);
    $unpaid += Transition::getAllMount($sbj1,2) + Transition::getAllMount($sbj2,2);
    $unpaid2 += Transition::getAllMount($sbj1,2,'before') + Transition::getAllMount($sbj2,2,'before');
    $paid += Transition::getAllMount($sbj1,1) + Transition::getAllMount($sbj2,1);
    $paid2 += Transition::getAllMount($sbj1,1,'before') + Transition::getAllMount($sbj2,1,'before');
}

$before = $balance + $unpaid2 - $paid2;
$left = $before + $unpaid - $paid;
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="font-green-sharp">供应商管理</span>
        </div>
        <div class="actions">
            <?php
            echo CHtml::link('<i class="fa fa-plus"></i> 添加供应商', array('create'), array('class' => 'btn btn-circle btn-primary btn-sm'));
            ?>
            <a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title=""
               data-original-title title="全屏"></a>
        </div>
    </div>
    <div class="well well-sm">
        <div class="banner" >
            <div class="banner-balance col-sm-9">年初: ￥<?=$before?>
                <div class="banner-paid col-sm-4 banner-hover">本年已付: ￥<?=$paid?></div>
                <div class="banner-in col-sm-4 banner-hover">本年增加: ￥<?=$unpaid?></div>
            </div>
            <div class="banner-unpaid col-sm-3 banner-hover">未付: ￥<?=$left?></div>
        </div>
    </div>
    <div class="portlet-body">
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'vendor-grid',
            'dataProvider' => $dataProvider,
            'itemsCssClass' => 'table table-striped table-hover',
            'filter' => $model,
            'columns' => array(
                [
                    'name' => 'company',
                    'filter' => CHtml::activeTextField($model, 'company', ['placeholder' => '查询'])
                ],
                [
                    'name' => 'vat',
                    'filter' => CHtml::activeTextField($model, 'vat', ['placeholder' => '查询'])
                ],
                [
                    'name' => 'phone',
                    'filter' => CHtml::activeTextField($model, 'phone', ['placeholder' => '查询'])
                ],
                [
                    'header' => '年初余额',
                    'value' => '$GLOBALS["a"] = $data->getAllMount(["type"=>"before","date"=>date("Y")."-01-01 00:00:00"])'
                ],
                [
                    'header' => '本年增加',
                    'value' => '$GLOBALS["b"] = $data->getAllMount(["entry_transaction"=>2]);',
                ],
                [
                    'header' => '本年已付',
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
                    'template' => '<div class="btn-group">{update}</div>',
                    'deleteConfirmation' => '确定要删除该条记录？',
                ),
            ),
        )); ?>
    </div>
</div>
