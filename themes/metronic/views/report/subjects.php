<!-- 科目余额表 -->
<?php
Yii::import('ext.select2.ESelect2');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/excel_export.js', CClientScript::POS_HEAD);

function echoItmes($items)
{
    foreach ($items as $info) {
        echo "<td>" . $info["subject_id"] . "</td>";
        echo "<td>" . $info["sbj_name"] . "</td>";
        echo "<td>" . $info["start_debit"] . "</td>";
        echo "<td>" . $info["start_credit"] . "</td>";
        echo "<td>" . $info["sum_debit"] . "</td>";
        echo "<td>" . $info["sum_credit"] . "</td>";
        echo "<td>" . $info["end_start"] . "</td>";
        echo "<td>" . $info["end_credit"] . "</td>";

    };
}

if (isset($_REQUEST['year'])) {
    $year = $_REQUEST['year'];
    $fm = $_REQUEST['fm'];
    $tm = $_REQUEST['tm'];
    if ($fm > $tm) {
        $temp = $fm;
        $fm = $tm;
        $tm = $temp;
    }
} else {
    $year = date('Y', time());
    $fm = '01';
    $tm = date('m', strtotime("-1 months"));
    $tm = $tm == 12 ? '01' : $tm;
}
//$years = array(2013=>'2013',2014=>'2014');

$years = Transition::model()->hasTransitionYears();
?>
<style>
    .ui-datepicker table {
        display: none;
    }
</style>
<div class="alert alert-info">
    <?php echo CHtml::beginForm('', 'post', array('class' => 'form-inline', 'role' => 'form')); ?>
    <h3>科目余额表</h3>
    请选择日期：
    <div class="form-group">
        <?php
        $this->widget('ESelect2', array(
            'name' => 'year',
            'value' => $year,
            'data' => $years,
        ));
        ?>
        年
        <?php
        $months = array(1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9', 10 => '10', 11 => '11', 12 => '12');
        $this->widget('ESelect2', array(
            'name' => 'fm',
            'value' => $fm,
            'data' => $months,
        ));
        ?>
        月 至
        <?php

        $this->widget('ESelect2', array(
            'name' => 'tm',
            'value' => $tm,
            'data' => $months,
        ));
        ?>月
        <input type="submit" class="btn btn-primary" value="查看报表"/>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h2>科目余额表</h2>
        <?php echo $fromMonth . "-" . $toMonth ?>
    </div>

    <table id="subjects" class="table table-bordered">
        <thead>
        <tr>
            <th class="text-right">科目编码</th>
            <th class="text-right">科目名称</th>
            <th class="text-right">期初借方</th>
            <th class="text-right">期初贷方</th>
            <th class="text-right">本期发生借方</th>
            <th class="text-right">本期发生贷方</th>
            <th class="text-right">期末借方</th>
            <th class="text-right">期末贷方</th>
        </tr>
        <?php
        foreach ($dataProvider as $sbjCat => $sbjCat_info) {
            switch ($sbjCat) {
                case "1":
                    $sbjCat_name = "资产小计";
                    break;
                case "2":
                    $sbjCat_name = "负债小计";
                    break;
                case "3":
                    $sbjCat_name = "权益小计";
                    break;
                case "4":
                    $sbjCat_name = "收入小计";
                    break;
                case "5":
                    $sbjCat_name = "费用小计";
                    break;

            };
            $items = $sbjCat_info["items"];

            foreach ($items as $info) {
                echo "<tr>";
                echo "<td>" . $info["subject_id"] . "</td>";
                echo "<td>" . $info["subject_name"] . "</td>";
                echo "<td>" . number_format($info["start_debit"], 2) . "</td>";
                echo "<td>" . number_format($info["start_credit"], 2) . "</td>";
                echo "<td>" . number_format($info["sum_debit"], 2) . "</td>";
                echo "<td>" . number_format($info["sum_credit"], 2) . "</td>";
                echo "<td>" . number_format($info["end_debit"], 2) . "</td>";
                echo "<td>" . number_format($info["end_credit"], 2) . "</td>";
                echo "</tr>";

            };

            echo "<tr>";
            echo "<td>&nbsp;</td>";
            echo "<td>" . $sbjCat_name . "</td>";
            echo "<td>" . number_format($sbjCat_info["start_debit"], 2) . "</td>";
            echo "<td>" . number_format($sbjCat_info["start_credit"], 2) . "</td>";
            echo "<td>" . number_format($sbjCat_info["sum_debit"], 2) . "</td>";
            echo "<td>" . number_format($sbjCat_info["sum_credit"], 2) . "</td>";
            echo "<td>" . number_format($sbjCat_info["end_debit"], 2) . "</td>";
            echo "<td>" . number_format($sbjCat_info["end_credit"], 2) . "</td>";
            echo "</tr>";
        }
        ?>
        <tr>
            <th class="text-right">&nbsp;</th>
            <th class="text-right">&nbsp;</th>
            <th class="text-right">&nbsp;</th>
            <th class="text-right">&nbsp;</th>
            <th class="text-right">&nbsp;</th>
            <th class="text-right">&nbsp;</th>
            <th class="text-right">&nbsp;</th>
            <th class="text-right">&nbsp;</th>
        </tr>
    </table>
</div>
<div class="alert">
    <a id="dlink" style="display:none;"></a>
    <?php

    echo CHtml::beginForm($this->createUrl('/Report/createexcel'), 'post', ['id'=>'export']);
    if ($fm != ""){
    $excel_name = "科目余额表 " . $fromMonth . "-" . $toMonth . ".xls";
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