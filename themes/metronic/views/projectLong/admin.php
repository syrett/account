<?php
/* @var $this ProjectLongController */
/* @var $model ProjectLong */

$this->pageTitle = Yii::app()->name . ' - 长期待摊';
$this->breadcrumbs = array(
    '长期待摊',
);
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="font-green-sharp">长期待摊</span>
        </div>
        <div class="actions">
            <?php
            echo CHtml::link('<i class="fa fa-plus"></i> 新建长期待摊', array('create'), array('class' => 'btn btn-circle btn-primary btn-sm'));
            ?>
            <a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title=""
               data-original-title title="全屏"></a>
        </div>
    </div>
    <div class="portlet-body">

        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'project-long-grid',
            'dataProvider' => $model->search(),
//            'filter' => $model,
            'itemsCssClass' => 'table table-striped table-hover',
            'columns' => array(
                'id',
                'name',
                [
                    'header'=>'采购内容',
                    'value'=>'$data->detail()'
                ],
                'memo',
                array(
                    'name'=>'status',
                    'filter'=>array('1'=>'正常','2'=>'完工'),
                    'value'=>'($data->status=="1")?("正常"):("完工")'
                ),
                ['name'=>'create_at','value'=>'date("Y-m-d H:m",$data->create_at)'],
                array(
                    'class' => 'CButtonColumn',
                    'buttons' => array(
                        'finish' => array(
                            'options' => array(
                                'class' => 'btn btn-default tip btn-xs',
                                'title' => '完工',
                                'confirm' => '确定项目已完工？',
                                'ajax' => [
                                    'dataType' => 'json',
                                    'url' => 'js:$(this).attr("href")',
                                    'success' => 'js:function(data) {

                                                $.fn.yiiGridView.update("project-long-grid")}'
                                ]
                            ),
                            'label' => "<span class='glyphicon'>完工</span>",
                            'imageUrl' => false,
                            'url' => 'Yii::app()->createUrl("/projectLong/active", ["id"=>$data->id,"action"=>$data->status!=1?"unactive":"active"])',
                            'visible' => '$data->status==1&&trim($data->assets)!=""',
                        ),
                        'view' => array(
                            'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => '查看'),
                            'label' => '<span class="glyphicon ">查看</span>',
                            'imageUrl' => false,
                        ),
                        'update' => array(
                            'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => '编辑'),
                            'label' => '<span class="glyphicon ">编辑</span>',
                            'imageUrl' => false,
                        ),
                        'delete' => array(
                            'options' => array('class' => 'btn btn-default tip delete btn-xs', 'title' => '删除'),
                            'label' => '<span class="glyphicon ">删除</span>',
                            'imageUrl' => false,
                        ),
                    ),
                    'template' => '<div class="btn-group">{update}{delete}{finish}</div>',
                    'deleteConfirmation' => '确定要删除该项目？',
                ),
            ),
        ));
        ?>
    </div>
</div>
