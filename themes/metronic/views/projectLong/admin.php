<?php
/* @var $this ProjectLongController */
/* @var $model ProjectLong */

$this->pageTitle = Yii::app()->name . Yii::t('import', ' - 长期待摊');
$this->breadcrumbs = array(
    Yii::t('import', '长期待摊'),
);
$total = Stock::getTotal('1801', 'worth');
$where = "(entry_subject like '1801%')";
$sort = new CSort();
$sort->defaultOrder = ['in_date' => CSort::SORT_DESC, 'project' => CSort::SORT_ASC];
$sort->attributes = [
    'project' => ['asc' => 'entry_subject', 'desc' => 'entry_subject desc']
];
$dataProvider = new CActiveDataProvider('Stock', ['criteria' => ['condition' => $where], 'sort' => $sort]);
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="font-green-sharp"><?= Yii::t('import', '长期待摊') ?></span>
            <span class="caption-helper"><?= Yii::t('import', '总计') ?>:<?= $total ?></span>
        </div>
        <div class="actions">
            <?php
            echo CHtml::link('<i class="fa fa-plus"></i> '.Yii::t('import', '新建长期待摊'), array('create'), array('class' => 'btn btn-circle btn-primary btn-sm'));
            ?>
            <a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title=""
               data-original-title title="<?= Yii::t('import', '全屏') ?>"></a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="caption">
            <span class="">
                    <?php
                    $pros = ProjectLong::model()->findAll();
                    $none = true;
                    $str = '<h4><strong>'.Yii::t('import', '未开工项目 :').'</strong>';
                    foreach ($pros as $pro) {
                        $sbj = Subjects::model()->findByAttributes(['sbj_name' => $pro->name], 'sbj_number like "1801%"');
                        if ($sbj) {
                            if (!Stock::model()->findByAttributes(['entry_subject' => $sbj->sbj_number])) {
                                $str .= "<span class='caption-helper'> $pro->name</span>";
                                $none = false;
                            }
                        }
                    }
                    $str .= '</h4>';
                    echo $none ? '' : $str;
                    ?>
            </span>
        </div>
        <p>
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'project-long-grid',
                'dataProvider' => $dataProvider,
                'itemsCssClass' => 'table table-striped table-hover',
                'columns' => array(
                    'id',
                    [
                        'header' => Yii::t('import', '项目'),
                        'name' => 'project',
                        'value' => 'Subjects::getName($data->entry_subject)'
                    ],
                    'name',
                    'in_price',
                    array(
                        'name' => 'status',
                        'filter' => array('1' => Yii::t('import', '正常'), '2' => Yii::t('import', '完工')),
                        'value' => '($data->getPStatus()=="1") ? ("'.Yii::t('import', "正常").'") : ("'.Yii::t('import', "完工").'")'
                    ),
                    ['name' => 'in_date', 'value' => 'convertDate($data->in_date, "'.Yii::t('import', "Y年m月d日").'")'],
                    array(
                        'class' => 'CButtonColumn',
                        'buttons' => array(
                            'finish' => array(
                                'options' => array(
                                    'class' => 'btn btn-default tip btn-xs',
                                    'title' => Yii::t('import', '完工'),
                                    'confirm' => Yii::t('import', '确定项目已完工？'),
                                    'ajax' => [
                                        'dataType' => 'json',
                                        'url' => 'js:$(this).attr("href")',
                                        'success' => 'js:function(data) {

                                                $.fn.yiiGridView.update("project-long-grid")}'
                                    ]
                                ),
                                'label' => "<span class='glyphicon'>".Yii::t('import', '完工')."</span>",
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("/projectLong/active", ["id"=>$data->id,"action"=>$data->status!=1?"unactive":"active"])',
//                            'visible' => '$data->status==1&&trim($data->assets)!=""',
                                'visible' => '$data->checkFinish()',
                            ),
                            'view' => array(
                                'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => Yii::t('import', '查看')),
                                'label' => '<span class="glyphicon ">'.Yii::t('import', '查看').'</span>',
                                'imageUrl' => false,
                            ),
                            'update' => array(
                                'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => Yii::t('import', '编辑')),
                                'label' => '<span class="glyphicon ">'.Yii::t('import', '编辑').'</span>',
                                'imageUrl' => false,
                            )
                        ),
                        'template' => '<div class="btn-group">{update}{finish}</div>',
                        'deleteConfirmation' => Yii::t('import', '确定要删除该项目？'),
                    ),
                ),
            ));
            ?>
        </p>
    </div>
</div>
