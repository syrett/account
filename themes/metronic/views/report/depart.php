<!-- 部门报表 -->
<?php
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
function echoData($data, $subjects)
{
    $column = array();
    echo "<tr>";
    echo "<th class='text-right'>&nbsp;</th>";
    foreach ($subjects as $sbj_id => $sbj_name) {
        echo "<th class='text-right'>" . $sbj_name . "</th>";
        $column[] = $sbj_id;
    }
    echo "</tr>";

    $column_len = count($column);

    foreach ($data as $k => $depart) {

        echo "<tr>";
        echo "<td>" . $depart["name"] . "</td>";
        for ($i = 0; $i < $column_len; $i++) {
            if (isset($depart[$column[$i]])) {
                $balance = $depart[$column[$i]];
            } else {
                $balance = 0;
            }
            echo "<td>" . number_format($balance, 2) . "</td>";
        }
        echo "</tr>";
    }
}

?>
<div class="alert alert-info">
    <?php echo CHtml::beginForm('', 'post', array('class' => 'form-inline')); ?>
    <h3><?= Yii::t('report', '部 门 表') ?></h3>
    <div class="form-group">
        <label class="control-label" for="date"><?= Yii::t('report', '请选择报表日期：') ?></label>
        <input type="text" data-date="201210" data-date-format="yyyymm" data-date-viewmode="years"
               data-date-minviewmode="months" name="date"
               class="form-control form-control-inline input-small date-picker"
               value="<?php echo isset($date) ? $date : '' ?>" id="date" readonly="">
        <label class="control-label" for="sbj_id"><?= Yii::t('report', '选择科目') ?></label>
        <?php
        $this->widget('ext.select2.ESelect2', array(
            'name' => 'sbj_id',
            'value' => $subject_id,
            'data' => $list,
        ));
        ?>
        <input type="submit" class="btn btn-primary" value="<?= Yii::t('report', '查看报表') ?>"/>
    </div>
    <p>&nbsp;</p>
    <?php echo CHtml::endForm(); ?>
</div>

<div <?php if (!$data) echo 'style="display:none"'; ?> class="panel panel-default">
    <div class="panel-heading">
        <h2><?= Yii::t('report', '部 门 表') ?></h2>
    </div>
    <div class="panel-body">
        <p class="text-center"><span class="pull-left"><?= Yii::t('report', '日期：') ?><?php echo $date; ?></span><?= Yii::t('report', '编制单位：') ?> <?php echo $company ?> <span
                class="pull-right"><?= Yii::t('report', '金额单位：元') ?></span></p>
    </div>
    <table id="depart" class="table table-bordered table-hover">
        <?php echoData($data, $subjects) ?>
    </table>
</div>

<div class="alert">
    <a id="dlink" style="display:none;"></a>
    <?php
    echo CHtml::beginForm($this->createUrl('/Report/createexcel'), 'post');
    if ($date != ""){
    $d = date('Y-m', strtotime($date));
    $excel_name = Yii::t('report', "部门表-") . $d . ".xls";
    ?>
    <input type="hidden" name="data" id="data" value=""/>
    <input type="hidden" name="name" id="name" value="<?= $excel_name ?>"/>
    <p class="text-right">
        <?php
        echo '<button type="button" onclick="tableToExcel()" class="btn btn-primary"><span class="glyphicon glyphicon-export"></span>'.Yii::t('report', '导出').'</button>';
        }
        echo CHtml::endForm();
        ?>
    </p>
</div>