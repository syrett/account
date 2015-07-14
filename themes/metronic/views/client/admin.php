<?php
/* @var $this ClientController */
/* @var $model Client */

$this->pageTitle = Yii::app()->name . ' - 客户管理';
$this->breadcrumbs = array(
    '客户管理',
);

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
    <div class="portlet-body">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'client-grid',
            'dataProvider' => $model->search(),
            'itemsCssClass' => 'table table-striped table-hover',
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
                    'value' => '$GLOBALS["b"] = $data->getAllMount(["entry_transaction"=>1]);',
                ],
                [
                    'header' => '本年已收',
                    'value' => '$GLOBALS["c"] = $data->getAllMount(["entry_transaction"=>2]);',
                ],
                [
                    'header' => '未收',
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
                            'options' => array('class' => 'btn btn-default tip btn-xs delete', 'title' => '删除'),
                            'label' => '<span class="glyphicon glyphicon-trash"></span>',
                            'imageUrl' => false,
                        ),
                    ),
                    'template' => '<div class="btn-group">{update} {delete}</div>',
                    'deleteConfirmation' => '确定要删除该条记录？',
                ),
            ),
            'pager' => array('class' => 'CLinkPager', 'header' => '', 'firstPageLabel' => '首页', 'lastPageLabel' => '末页', 'nextPageLabel' => '下一页', 'prevPageLabel' => '上一页'),

        ));
        ?>
    </div>
</div>
