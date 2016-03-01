<?php
/* @var $this SubjectController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle = Yii::app()->name . ' - 客户管理';
$this->breadcrumbs = array(
    '客户账务',
);
$ageDetail = $model->getClientAge();
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="font-green-sharp"><?= Yii::t('import', '客户账务') ?></span>
        </div>
        <div class="actions">
            <?php
            echo CHtml::link('<i class="fa fa-bars"></i>'.Yii::t('import', '客户列表'), array('admin'), array('class' => 'btn btn-circle btn-primary btn-sm'));
            ?>
            <a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title=""
               data-original-title title="<?= Yii::t('import', '全屏') ?>"></a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="tabbable tabbable-tabdrop">
            <ul class="nav nav-tabs">
                <?
                foreach (Client::$ageZone as $tab => $item) {

                    ?>
                    <li class="<?= $tab == 0 ? 'active' : '' ?>">
                        <a href="#tab<?= $tab ?>" data-toggle="tab"><?= $item ?></a>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <div class="tab-content">
                <?
                foreach (Client::$ageZone as $tab => $item) {

                    ?>
                    <div class="tab-pane <?= $tab == 0 ? 'active' : '' ?>" id="tab<?= $tab ?>">
                        <p><?php
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'client-grid',
                                'dataProvider' => $dataProvider[$tab],
                                'itemsCssClass' => 'table table-striped table-hover',
                                'columns' => array(
                                    [
                                        'header' => Yii::t('import', '凭证号'),
                                        'value' => '$data->entry_num_prefix. addZero($data->entry_num)'
                                    ],
                                    [
                                        'header' => Yii::t('import', '日期'),
                                        'value' => 'convertDate($data->entry_date, "Y-m-d")'
                                    ],
                                    [
                                        'header' => Yii::t('import', '说明'),
                                        'name' => 'entry_memo'
                                    ],
                                    [
                                        'header' => Yii::t('import', '金额'),
                                        'name' => 'entry_amount'
                                    ],
                                    [
                                        'class' => 'CButtonColumn',
                                        'buttons' => [
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
                                                'url' => 'Yii::app()->createUrl("/client/bad", ["client_id"=>' . $model->id . ',"amount"=>$data->entry_amount,"action"=>"bad"])'
                                            ),
                                        ],
                                        'template' => '<div class="btn-group">{bad}</div>',

                                    ]
                                )));
                            ?>
                        </p>
                    </div>
                    <?php
                }
                ?>

            </div>
        </div>

    </div>
</div>

