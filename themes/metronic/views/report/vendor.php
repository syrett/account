<!-- 供应商报表 -->
<?php

Yii::app()->clientScript->registerCoreScript('jquery');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/profit.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/excel_export.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/pages/scripts/components-pickers.js', CClientScript::POS_END);

$cs->registerScript('ComponentsPickersInit', 'ComponentsPickers.init();', CClientScript::POS_READY);
?>
<style>
    .ui-datepicker table {
        display: none;
    }
</style>

<?php
function echoData($data)
{
    foreach ($data as $company => $ti) {
        echo "<tr>";
        echo "<td>". $company. "</td>";
        echo "<td>". $ti['before']. "</td>";
        echo "<td>". $ti['unreceived']. "</td>";
        echo "<td>". $ti['received']. "</td>";
        echo "<td>". $ti['left']. "</td>";
        echo "</tr>";
    }
}

?>
<div class="alert alert-info">
    <?php echo CHtml::beginForm('', 'post', array('class' => 'form-inline')); ?>
    <h3>供应商表</h3>
    <div class="form-group">
        <label class="control-label" for="date">请选择报表日期：</label>
        <input type="text" data-date="201210" data-date-format="yyyymm" data-date-viewmode="years"
               data-date-minviewmode="months" name="date"
               class="form-control form-control-inline input-small date-picker"
               value="<?php echo isset($date) ? $date : '' ?>" id="date" readonly="">
        <input type="submit" class="btn btn-primary" value="查看报表"/>
    </div>
    <p>&nbsp;</p>
    <?php echo CHtml::endForm(); ?>
</div>
<div <?php if (!$data) echo 'style="display:none"'; ?>" class="panel panel-default">
<div class="panel-heading">
    <h2>供 应 商 表</h2>
</div>
<div class="panel-body">
    <p class="text-center"><span class="pull-left">日期：<?php echo $date; ?></span> 编制单位：<?php echo $company ?> <span
            class="pull-right">金额单位：元</span></p>
</div>

<table id="vendor" class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>供应商</th>
        <th>期初</th>
        <th>本期增加</th>
        <th>本期已付</th>
        <th>未付</th>
    </tr>
    </thead>
    <?php echoData($data) ?>
</table>
</div>
<div class="alert">
    <a id="dlink" style="display:none;"></a>
    <?php
    echo CHtml::beginForm($this->createUrl('/Report/createexcel'), 'post');
    if ($date != ""){
    $d = date('Y-m', strtotime($date));
    $excel_name = "供应商表 " . $d . ".xls";
    ?>

    <input type="hidden" name="data" id="data" value=""/>
    <input type="hidden" name="name" id="name" value="<?= $excel_name ?>"/>
    <p class="text-right">
        <?php
        echo '<button type="button" onclick="tableToExcel()" class="btn btn-primary"><span class="glyphicon glyphicon-export"></span> 导出</button>';
        }
        echo CHtml::endForm();
        ?>
    </p>

</div>
