<?php
/* @var $this ClientController */
/* @var $model Client */

$this->pageTitle = Yii::app()->name . Yii::t('import', ' - 客户管理');
$this->breadcrumbs = array(
    Yii::t('import', '客户管理'),
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
            <span class="font-green-sharp"><?= Yii::t('import', '客户管理') ?></span>
        </div>
        <div class="actions">
            <?php
            echo CHtml::link('<i class="fa fa-plus"></i>'.Yii::t('import', '添加客户'), array('create'), array('class' => 'btn btn-circle btn-primary btn-sm'));
            ?>
            <a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title=""
               data-original-title title="<?= Yii::t('import', '全屏') ?>"></a>
        </div>
    </div>
    <div class="well well-sm">
        <div class="banner">
            <div class="banner-balance col-sm-9"><?= Yii::t('import', '年初') ?>: ￥<?= $before ?>
                <div class="banner-paid col-sm-4 banner-hover"><?= Yii::t('import', '本年已收') ?>: ￥<?= $received ?></div>
                <div class="banner-in col-sm-4 banner-hover"><?= Yii::t('import', '本年增加') ?>: ￥<?= $unreceived ?></div>
            </div>
            <div class="banner-unpaid col-sm-3 banner-hover"><?= Yii::t('import', '未收') ?>: ￥<?= $left ?></div>
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
                    'filter' => CHtml::activeTextField($model, 'company', ['placeholder' => Yii::t('import', '查询')])
                ],
                [
                    'name' => 'vat',
                    'filter' => CHtml::activeTextField($model, 'vat', ['placeholder' => Yii::t('import', '查询')])
                ],
                [
                    'name' => 'phone',
                    'filter' => CHtml::activeTextField($model, 'phone', ['placeholder' => Yii::t('import', '查询')])
                ],
                [
                    'header' => Yii::t('import', '年初余额'),
                    'value' => '$data->getAllMount(["type"=>"before","date"=>date("Y")."-01-01 00:00:00"]);'
                ],
                [
                    'header' => Yii::t('import', '本年增加'),
                    'value' => '$data->getAllMount(["entry_transaction"=>1]);',
                ],
                [
                    'header' => Yii::t('import', '本年已收'),
                    'value' => '$data->getAllMount(["entry_transaction"=>2]);',
                ],
                [
                    'header' => Yii::t('import', '未收'),
                    'value' => '$GLOBALS["d"] = $data->getUnreceived()',
                ],
                [
                    'header' => Yii::t('import', '账期 / 账龄'),
                    'value' => '$data->getAge()',
                ],
                array(
                    'class' => 'CButtonColumn',
                    'buttons' => array(
                        'update' => array(
                            'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => Yii::t('import', '编辑')),
                            'label' => Yii::t('import', '编辑'),
                            'imageUrl' => false,
                        ),
                        'delete' => array(
                            'options' => array('class' => 'btn btn-default tip btn-xs delete', 'title' => Yii::t('import', '删除')),
                            'label' => Yii::t('import', '删除'),
                            'imageUrl' => false,
                        ),
                        'view' => array(
                            'options' => array('class' => 'btn btn-default tip btn-xs view', 'title' => Yii::t('import', '查看')),
                            'label' => Yii::t('import', '查看'),
                            'imageUrl' => false,
                        ),
                        'bad' => array(
                            'options' => array(
                                'class' => 'btn btn-default tip btn-xs',
                                'title' => Yii::t('import', '坏账'),
                                'confirm' => Yii::t('import', '确定要执行此操作？'),
                                'ajax' => [
                                    'dataType' => 'json',
                                    'url' => 'js:$(this).attr("href")',
                                    'success' => 'js:function(data) {
                                                        alert(data.msg);
                                                $.fn.yiiGridView.update("client-grid")}'
                                ]
                            ),
                            'label' => Yii::t('import', '坏账'),
                            'imageUrl' => false,
                            'url' => 'Yii::app()->createUrl("/client/bad", ["client_id"=>$data->id,"amount"=>$GLOBALS["d"],"action"=>$data->hasDad()?"unbad":"bad"])'
                        ),
                    ),
                    'template' => '<div class="btn-group">{update}{view}</div>',
                    'deleteConfirmation' => Yii::t('import', '确定要删除该条记录？'),
                    'afterDelete' => 'function(link,success,data){if(success) alert(data);}'
                ),
            ),
            'pager' => array('class' => 'CLinkPager', 'header' => '', 'firstPageLabel' => Yii::t('import', '首页'), 'lastPageLabel' => Yii::t('import', '末页'), 'nextPageLabel' => Yii::t('import', '下一页'), 'prevPageLabel' => Yii::t('import', '上一页')),

        ));
        ?>
    </div>
</div>
