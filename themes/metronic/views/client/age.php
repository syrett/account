<?php
/* @var $this ClientController */
/* @var $model Client */
/* @var $dataProvider0 */

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

        <?
        foreach (Yii::app()->user->getFlashes() as $key => $message) {
            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
        }
        ?>
        <div class="tabbable tabbable-tabdrop">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab0" data-toggle="tab">应收账款</a>
                </li>
                <li class="">
                    <a href="#tab1" data-toggle="tab">其他应收款</a>
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
                                    'header' => Yii::t('models/model', '客户')
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
                                ],
                                [
                                    'class' => 'CButtonColumn',
                                    'buttons' => array(
                                        'bad' => array(
                                            'options' => array(
                                                'class' => 'btn btn-default tip btn-xs bad',
                                                'title' => Yii::t('import', '计提坏账'),
                                                'data-target' => '#bad-modal',
                                                'data-toggle' => 'modal'
                                            ),
                                            'client' => '$data->id',
                                            'label' => Yii::t('import', '计提坏账'),
                                            //'imageUrl' => false,
                                            'url' => '"#".$data->id',

                                            'click' => "function(){
                                $('#bad-label').html('" . Yii::t('import', '计提坏账金额') . "');
                                $('#bad-client').val($(this).attr('href').substr(1));
                                $('#bad-action').val('bad');
                                return false;

                            }"
                                        ),
                                        's-bad' => array(
                                            'options' => array(
                                                'class' => 'btn btn-default tip btn-xs s-bad',
                                                'title' => Yii::t('import', '确认坏账'),
                                                'data-target' => '#bad-modal',
                                                'data-toggle' => 'modal'
                                            ),
                                            'label' => Yii::t('import', '确认坏账'),
                                            //'imageUrl' => false,
                                            'url' => '"#".$data->id',

                                            'click' => "function(){
                                $('#bad-label').html('" . Yii::t('import', '确认坏账金额') . "');
                                $('#bad-client').val($(this).attr('href').substr(1));
                                $('#bad-action').val('s-bad');
                                return false;

                            }"
                                        ),
                                    ),
                                    'template' => '<div class="btn-group">{bad}{s-bad}</div>',
                                    'deleteConfirmation' => Yii::t('import', '确定要删除该条记录？'),
                                    'afterDelete' => 'function(link,success,data){if(success) alert(data);}'
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
    <div class="modal fade" id="bad-modal" tabindex="-1" data-backdrop="bad-modal" data-keyboard="false">
        <div class="modal-dialog">
            <?= CHtml::beginForm(['client/bad']) ?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><?= Yii::t('import', '设置金额') ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group form-horizontal">

                        <label id="bad-label" class="col-sm-2 control-label"></label>

                        <div class="input-group col-sm-4">
                            <input type="hidden" name="action" value="" id="bad-action"/>
                            <input type="hidden" name="client_id" value="" id="bad-client"/>
                            <input type="text" name="bad-amount" class="form-control"
                                   placeholder="<?= Yii::t('import', '输入金额') ?>"/>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <?php
                    echo CHtml::tag('button', array('encode' => false, 'class' => 'btn btn-primary',), '<span class="glyphicon glyphicon-floppy-disk"></span> ' . Yii::t('import', '保存'));
                    ?>
                </div>
            </div>
            <?= CHtml::endForm() ?>
        </div>
    </div>