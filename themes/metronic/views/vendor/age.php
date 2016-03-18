<?php
/* @var $this ClientController */
/* @var $model Client */

$this->pageTitle = Yii::app()->name . Yii::t('import', ' - 账龄查看');
$this->breadcrumbs = array(
    Yii::t('import', '账龄查看'),
);

?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="font-green-sharp"><?= Yii::t('import', '账龄查看') ?></span>
        </div>
        <div class="actions">
            <a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title=""
               data-original-title title="<?= Yii::t('import', '全屏'); ?>"></a>
        </div>
    </div>
    <div class="portlet-body">

        <div class="tabbable tabbable-tabdrop">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab0" data-toggle="tab">应付账款</a>
                </li>
                <li class="">
                    <a href="#tab1" data-toggle="tab">其他应付款</a>
                </li>
            </ul>
            <div class="tab-content">
                <?
                foreach ([$dataProvider0, $dataProvider1] as $tab => $dataProvider) {

                    ?>
                    <div class="tab-pane <?= $tab == 0 ? 'active' : '' ?>" id="tab<?= $tab ?>">
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'client-grid',
                            'dataProvider' => new CArrayDataProvider($dataProvider),
                            'itemsCssClass' => 'table table-striped table-hover',
                            'columns' => array(
                                [
                                    'name' => 'company',
                                    'header' => Yii::t('models/model', '供应商')
                                ],
                                [
                                    'header' => Yii::t('models/model', '全部'),
                                    'value' => '$data->ageZone["全部"]'
                                ],
                                [
                                    'header' => Yii::t('models/model', '0-30天'),
                                    'value' => '$data->ageZone["0-30天"]'
                                ],
                                [
                                    'header' => Yii::t('models/model', '30-90天'),
                                    'value' => '$data->ageZone["30-90天"]'
                                ],
                                [
                                    'header' => Yii::t('models/model', '90-180天'),
                                    'value' => '$data->ageZone["90-180天"]'
                                ],
                                [
                                    'header' => Yii::t('models/model', '180-365天'),
                                    'value' => '$data->ageZone["180-365天"]'
                                ],
                                [
                                    'header' => Yii::t('models/model', '1-2年'),
                                    'value' => '$data->ageZone["1-2年"]'
                                ],
                                [
                                    'header' => Yii::t('models/model', '2-5年'),
                                    'value' => '$data->ageZone["2-5年"]'
                                ],
                                [
                                    'header' => Yii::t('models/model', '5年以上'),
                                    'value' => '$data->ageZone["5年以上"]'
                                ]

                            ),
                            'pager' => array('class' => 'CLinkPager', 'header' => '', 'firstPageLabel' => Yii::t('import', '首页'), 'lastPageLabel' => Yii::t('import', '末页'), 'nextPageLabel' => Yii::t('import', '下一页'), 'prevPageLabel' => Yii::t('import', '上一页')),

                        ));
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
