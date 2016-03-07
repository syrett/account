<?php
/* @var $this ProjectBController */
/* @var $model ProjectB */

$departmentArray = Department::model()->getDepartmentArray();
$sbjArray = Transition::getSubjectArray([1601]);
$this->pageTitle = Yii::app()->name . Yii::t('import', ' - 在建工程');
$this->breadcrumbs = array(
    Yii::t('import', '在建工程'),
);
$total = Stock::getTotal('1604', 'worth');
$where = "(entry_subject like '1604%')";
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
            <span class="font-green-sharp"><?= Yii::t('import', '在建工程') ?></span>
            <span class="caption-helper"><?= Yii::t('import', '总计:') ?><?= $total ?></span>
        </div>
        <div class="actions">
            <?php
            echo CHtml::link('<i class="fa fa-plus"></i> '.Yii::t('import', '新建在建工程'), array('create'), array('class' => 'btn btn-circle btn-primary btn-sm'));
            ?>
            <a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title=""
               data-original-title title="<?= Yii::t('import', '全屏') ?>"></a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="caption">
            <span class="">
                    <?php
                    $pros = ProjectB::model()->findAll();
                    $none = true;
                    $str = '<h4><strong>'.Yii::t('import', '未开工项目').' :</strong>';
                    foreach ($pros as $pro) {
                        $sbj = Subjects::model()->findByAttributes(['sbj_name' => $pro->name], 'sbj_number like "1604%"');
                        if ($sbj) {
                            if (!Stock::model()->findByAttributes(['entry_subject' => $sbj->sbj_number])) {
                                $str .= "<span class='caption-helper'> $pro->name</span>";
                                $none = false;
                            }
                        }
                    }
                    $str .= '</h4>';
                    echo $none?'':$str;
                    ?>
            </span>
        </div>
        <p>
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'project-b-grid',
                'dataProvider' => $dataProvider,
                'itemsCssClass' => 'table table-striped table-hover',
                'columns' => array(
                    [
                        'name' => 'id',
                        'value' => 'addZero(ProjectB::getIdBySubject($data->entry_subject),4)'
                    ],
                    [
                        'header' => Yii::t('models/model', '项目名称'),
                        'name' => 'project',
                        'value' => 'Subjects::getName($data->entry_subject)'
                    ],
                    [
                        'header' => Yii::t('models/model', '明细'),
                        'name' => 'name'
                    ],
                    'in_price',
                    array(
                        'name' => 'status',
                        'filter' => array('1' => Yii::t('import', '在建'), '2' => Yii::t('import', '转固')),
                        'value' => '($data->getPStatus()=="1") ? ('.Yii::t('import', "在建").') : ('.Yii::t('import', "转固").')'
                    ),
                    ['name' => 'in_date', 'value' => 'convertDate($data->in_date,"Y-m-d")'],
                    array(
                        'class' => 'CButtonColumn',
                        'buttons' => array(
                            'view' => array(
                                'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => Yii::t('import', '查看')),
                                'label' => '<span class="glyphicon glyphicon-eye-open"></span>',
                                'imageUrl' => false,
                            ),
                            'update' => array(
                                'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => Yii::t('import', '编辑')),
                                'label' => '<span class="glyphicon ">'.Yii::t('import', '编辑').'</span>',
                                'imageUrl' => false,
                            ),
                            'transform' => array(
                                'options' => array(
                                    'class' => 'btn btn-default tip btn-xs',
                                    'data-toggle' => "modal",
                                    'role' => 'button',
                                    'title' => Yii::t('import', '转固'),
                                    'onClick' => 'rowClick(this)'
                                ),
                                'url' => '"#transform"',
                                'label' => "<span class='glyphicon'>".Yii::t('import', '转固')."</span>",
                                'imageUrl' => false,
//                            'visible' => '$data->status==1&&trim($data->assets)!=""',
                                'visible' => '$data->checkTransform()',
                            )
                        ),
                        'template' => '<div class="btn-group">{transform}</div>',
                        'deleteConfirmation' => Yii::t('import', '确定要删除该条记录？'),
                    ),
                ),
            ));
            ?></p>
    </div>
</div>

<div id="transform" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="<?= Yii::t('import', '在建工程转固') ?>" aria-hidden="true"
     style="display: none">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?= Yii::t('import', '在建工程转固') ?></h4>
            </div>
            <div class="modal-body row">
                <div class="panel-heading col-md-12">
                    <strong>
                        <?= Yii::t('import', '在建工程转固后，无法撤消！！！') ?>
                    </strong>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3"><?= Yii::t('import', '固定资产名称') ?></div>
                        <div class="col-md-3"><?= Yii::t('import', '型号') ?></div>
                        <div class="col-md-3"><?= Yii::t('import', '使用部门') ?></div>
                        <div class="col-md-3"><?= Yii::t('import', '资产类别') ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="asset_name" id="asset_name" value="">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="model" id="model" value="">
                        </div>
                        <div class="col-md-3">
                            <?
                            $this->widget('ext.select2.ESelect2', array(
                                'id' => 'department_id',
                                'name' => 'department_id',
                                'data' => $departmentArray,
                                'htmlOptions' => array('class' => 'select-full')
                            ));
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?
                            $this->widget('ext.select2.ESelect2', array(
                                'id' => 'subject_id',
                                'name' => 'subject_id',
                                'data' => $sbjArray,
                                'htmlOptions' => array('class' => 'select-full')
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn default" data-dismiss="modal" aria-hidden="true"><?= Yii::t('import', '取消') ?></button>
                <button class="btn yellow" data-dismiss="modal" onclick="transform()"><?= Yii::t('import', '确定') ?></button>
            </div>
        </div>
    </div>
    <input type="hidden" value="0" id="row_id">
    <input type="hidden" value="<?= Yii::app()->createUrl("/projectB/transform") ?>" id="transform_url">
</div>
<script>
    function transform() {
        $.ajax({
            url: $("#transform_url").val(),
            data: {
                'id': $("#row_id").val(),
                'action': 'active',
                'did': $("#department_id").val(),
                'sbj': $("#subject_id").val(),
                'name': $("#asset_name").val(),
                'type': $("#model").val()
            },
            success: function (msg) {
                $.fn.yiiGridView.update("project-b-grid")
            }
        });
    }

    function rowClick(row) {
        var ptr = $(row).closest("tr")
        $("#row_id").val($(ptr).find("td:first").html());
    }
</script>