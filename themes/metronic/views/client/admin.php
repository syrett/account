<?php
/* @var $this ClientController */
/* @var $model Client */

$this->pageTitle = Yii::app()->name . ' - 客户管理';
$this->breadcrumbs = array(
    '客户管理',
);

$balance = 0;
$unreceived = 0;
$unreceived2 = 0;
$received = 0;
$received2 = 0;
$clients = Client::model()->findAll();
foreach($clients as $client) {
    $sbj1 = Subjects::model()->findByAttributes(['sbj_name'=>$client->company], 'sbj_number like "1122%"');
    $sbj2 = Subjects::model()->findByAttributes(['sbj_name'=>$client->company], 'sbj_number like "2203%"');
    $sbj1 = $sbj1?$sbj1->sbj_number:'';
    $sbj2 = $sbj2?$sbj2->sbj_number:'';
    $balance += Subjects::get_balance($sbj1) + Subjects::get_balance($sbj2);
    $unreceived += Transition::getAllMount($sbj1,1) + Transition::getAllMount($sbj2,1);
    $unreceived2 += Transition::getAllMount($sbj1,2,'before') + Transition::getAllMount($sbj2,2,'before');
    $received += Transition::getAllMount($sbj1,2) + Transition::getAllMount($sbj2,2);
    $received2 += Transition::getAllMount($sbj1,1,'before') + Transition::getAllMount($sbj2,1,'before');
}
$before = $balance + $unreceived2 - $received2;
$left = $before + $unreceived - $received;
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="font-green-sharp">客户管理</span>
        </div>
        <div class="actions">
            <?php
            echo CHtml::link('<i class="fa fa-plus"></i> 添加客户', array('create'), array('class' => 'btn btn-circle btn-primary btn-sm'));
            ?>
            <a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title=""
               data-original-title title="全屏"></a>
        </div>
    </div>
    <div class="well well-sm">
        <div class="banner">
            <div class="banner-balance col-sm-9">年初: ￥<?= $before ?>
                <div class="banner-paid col-sm-4 banner-hover">本年已收: ￥<?= $received ?></div>
                <div class="banner-in col-sm-4 banner-hover">本年增加: ￥<?= $unreceived ?></div>
            </div>
            <div class="banner-unpaid col-sm-3 banner-hover">未收: ￥<?= $left ?></div>
        </div>
    </div>
    <div class="portlet-body">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'client-grid',
            'dataProvider' => $model->search(),
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
                    'value' => '$data->getAllMount(["type"=>"before","date"=>date("Y")."-01-01 00:00:00"]);'
                ],
                [
                    'header' => '本年增加',
                    'value' => '$data->getAllMount(["entry_transaction"=>1]);',
                ],
                [
                    'header' => '本年已收',
                    'value' => '$data->getAllMount(["entry_transaction"=>2]);',
                ],
                [
                    'header' => '未收',
                    'value' => '$GLOBALS["d"] = $data->getUnreceived()',
                ],
                array(
                    'class' => 'CButtonColumn',
                    'buttons' => array(
                        'update' => array(
                            'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => '编辑'),
                            'label' => '编辑',
                            'imageUrl' => false,
                        ),
                        'delete' => array(
                            'options' => array('class' => 'btn btn-default tip btn-xs delete', 'title' => '删除'),
                            'label' => '删除',
                            'imageUrl' => false,
                        ),
                        'bad' => array(
                            'options' => array(
                                'class' => 'btn btn-default tip btn-xs',
                                'title' => '坏账',
                                'confirm' => '确定要执行此操作？',
                                'ajax' => [
                                    'dataType' => 'json',
                                    'url' => 'js:$(this).attr("href")',
                                    'success' => 'js:function(data) {
                                                        alert(data.msg);
                                                $.fn.yiiGridView.update("client-grid")}'
                                ]
                            ),
                            'label' => "坏账",
                            'imageUrl' => false,
                            'url' => 'Yii::app()->createUrl("/client/bad", ["client_id"=>$data->id,"amount"=>$GLOBALS["d"],"action"=>$data->hasDad()?"unbad":"bad"])'
                        ),
                    ),
                    'template' => '<div class="btn-group">{update}{bad}</div>',
                    'deleteConfirmation' => '确定要删除该条记录？',
                    'afterDelete' => 'function(link,success,data){if(success) alert(data);}'
                ),
            ),
            'pager' => array('class' => 'CLinkPager', 'header' => '', 'firstPageLabel' => '首页', 'lastPageLabel' => '末页', 'nextPageLabel' => '下一页', 'prevPageLabel' => '上一页'),

        ));
        ?>
    </div>
</div>
