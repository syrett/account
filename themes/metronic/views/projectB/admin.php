<?php
/* @var $this ProjectBController */
/* @var $model ProjectB */

$departmentArray = Department::model()->getDepartmentArray();
$sbjArray = Transition::getSubjectArray([1601]);
$this->pageTitle = Yii::app()->name . ' - 在建工程';
$this->breadcrumbs = array(
    '在建工程',
);
$total = Stock::getTotal('1604','worth');
$where = "(entry_subject like '1604%')";
$sort = new CSort();
$sort->defaultOrder = ['in_date'=>CSort::SORT_DESC,'project' => CSort::SORT_ASC];
$sort->attributes = [
    'project' => ['asc' => 'entry_subject', 'desc' => 'entry_subject desc']
];
$dataProvider = new CActiveDataProvider('Stock', ['criteria' => ['condition' => $where], 'sort' => $sort]);
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="font-green-sharp">在建工程</span>
            <span class="caption-helper">在建工程总计:<?= $total?></span>
        </div>
        <div class="actions">
            <?php
            echo CHtml::link('<i class="fa fa-plus"></i> 新建在建工程', array('create'), array('class' => 'btn btn-circle btn-primary btn-sm'));
            ?>
            <a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title=""
               data-original-title title="全屏"></a>
        </div>
    </div>
    <div class="portlet-body">

        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'project-b-grid',
            'dataProvider' => $dataProvider,
            'itemsCssClass' => 'table table-striped table-hover',
            'columns' => array(
                'id',
                [
                    'header' => '项目',
                    'name' => 'project',
                    'value' => 'Subjects::getName($data->entry_subject)'
                ],
                'name',
//                'memo',
                array(
                    'name' => 'status',
                    'filter' => array('1' => '在建', '2' => '转固'),
                    'value' => '($data->getPStatus()=="1")?("在建"):("转固")'
                ),
                ['name' => 'in_date', 'value' => 'convertDate($data->in_date,"Y-m-d")'],
                array(
                    'class' => 'CButtonColumn',
                    'buttons' => array(
                        'view' => array(
                            'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => '查看'),
                            'label' => '<span class="glyphicon glyphicon-eye-open"></span>',
                            'imageUrl' => false,
                        ),
                        'update' => array(
                            'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => '编辑'),
                            'label' => '<span class="glyphicon ">编辑</span>',
                            'imageUrl' => false,
                        ),
                        'transform' => array(
                            'options' => array(
                                'class' => 'btn btn-default tip btn-xs',
                                'data-toggle' => "modal",
                                'role' => 'button',
                                'title' => '转固',
                                'onClick' => 'rowClick(this)'
                            ),
                            'url' => '"#transform"',
                            'label' => "<span class='glyphicon'>转固</span>",
                            'imageUrl' => false,
//                            'visible' => '$data->status==1&&trim($data->assets)!=""',
                            'visible' => '$data->checkTransform()',
                        ),
                        'delete' => array(
                            'options' => array('class' => 'btn btn-default tip delete btn-xs', 'title' => '删除'),
                            'label' => '<span class="glyphicon ">删除</span>',
                            'imageUrl' => false,
                        ),
                    ),
                    'template' => '<div class="btn-group">{update}{delete}{transform}</div>',
                    'deleteConfirmation' => '确定要删除该条记录？',
                ),
            ),
        ));
        ?>
    </div>
</div>

<div id="transform" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="在建工程转固" aria-hidden="true"
     style="display: none">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">在建工程转固</h4>
            </div>
            <div class="modal-body row">
                <div class="panel-heading col-md-12">
                    <strong>
                        在建工程转固后，无法撤消！！！
                    </strong>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">固定资产名称</div>
                        <div class="col-md-3">型号</div>
                        <div class="col-md-3">使用部门</div>
                        <div class="col-md-3">资产类别</div>
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
                <button class="btn default" data-dismiss="modal" aria-hidden="true">取消</button>
                <button class="btn yellow" data-dismiss="modal" onclick="transform()">确定</button>
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