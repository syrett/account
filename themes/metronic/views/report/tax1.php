<!-- 增值税纳税申报表 -->
<?php

Yii::import('ext.select2.Select2');
$cs = Yii::app()->clientScript;

$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/checkinput.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/tax1.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/excel_export.js', CClientScript::POS_HEAD);

$data = Product::getTax1_1();
?>

<div class="alert alert-info">
    <?php echo CHtml::beginForm('', 'post', array('class' => 'form-inline', 'id' => 'report')); ?>
    <h3><?= Yii::t('report', '增值税纳税申报表') ?></h3>

    <div class="form-group">
        <label class="control-label" for="date"><?= Yii::t('report', '请选择报表日期') ?>：</label>
        <input type="text" data-date-format="yyyymmdd" name="date"
               class="form-control form-control-inline input-small date-picker"
               value="<?php echo isset($date) ? $date : '' ?>" id="date" readonly="">
        <input type="button" onclick="javascript:$('#type').val('month');$('#report').submit();" class="btn btn-primary"
               value="<?= Yii::t('report', '按月份查看') ?>"/>
        <input type="button" onclick="javascript:$('#type').val('quarter');$('#report').submit();"
               class="btn btn-primary"
               value="<?= Yii::t('report', '按季度查看') ?>"/>
        <input type="hidden" name="type" id="type">
    </div>
    <p>&nbsp;</p>
    <?php echo CHtml::endForm(); ?>
</div>
<div <?php if (!$data) echo 'style="display:none"'; ?> class="panel panel-default">
    <div class="panel-heading">
        <h2><?= Yii::t('report', '增值税纳税申报表') ?></h2><h4>（<?= Yii::t('import', '适用于小规模纳税人') ?>）</h4>
    </div>
    <div class="panel-body">
        <p class="text-center">
            <label class="float-left left header"><?= Yii::t('report', '纳税人识别号') ?>：</label>
            <br style="clear: both;"/>
            <label class="float-left left"><?= Yii::t('report', '纳税人名称') ?>：<?= Condom::model()->getName() ?></label>
            <label
                class="float-right right"><?= Yii::t('report', '金额单位：元') ?></label>
            <br style="clear: both;"/>
            <label class="float-left left"><?= Yii::t('report', '税款所属期') ?>
                ：<?= date('Y-m-d', strtotime($date)); ?></label> <label
                class="float-right right"><?= Yii::t('report', '填表日期') ?>： <?= date('Y-m-d', time()) ?></label>

        </p>
        <table class="table table-bordered table-hover tax-table tax-table-1" id="tax1">
            <tbody>
            <tr>
                <th rowspan="11" class="tax-min">计<br/>税<br/>依<br/>据</th>
                <th rowspan="2">项目</th>
                <th rowspan="2" class="tax-mid">栏次</th>
                <th colspan="2">本期数</th>
                <th colspan="2">本年累计</th>
            </tr>
            <tr>
                <th>货物及劳务</th>
                <th>应税服务</th>
                <th>货物及劳务</th>
                <th>应税服务</th>
            </tr>
            <tr item="1">
                <td>（一）应征增值税货物及劳务、试点服务不含税销售额</td>
                <td class="tax-mid">1</td>
                <td><?= $data[1]['A'] ?></td>
                <td><?= $data[1]['B'] ?></td>
                <td><?= $data[1]['C'] ?></td>
                <td><?= $data[1]['D'] ?></td>
            </tr>
            <tr item="2">
                <td>其中：税务机关代开的增值税专用发票不含税销售额</td>
                <td>2</td>
                <td><input type="text" class="input-small" id="input_2_A"/></td>
                <td><input type="text" class="input-small" id="input_2_B"/></td>
                <td><input type="text" class="input-small" id="input_2_C"/></td>
                <td><input type="text" class="input-small" id="input_2_D"/></td>
            </tr>
            <tr item="3">
                <td>税控器具开具的普通发票不含税销售额</td>
                <td>3</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr item="4">
                <td>（二）销售使用过的应税固定资产不含税销售额</td>
                <td>4</td>
                <td><?= $data[4]['A'] ?></td>
                <td style="text-align: center">----</td>
                <td><?= $data[4]['C'] ?></td>
                <td style="text-align: center">----</td>
            </tr>
            <tr item="5">
                <td>其中：税控器具开具的普通发票不含税销售额</td>
                <td>5</td>
                <td><input type="text" class="input-small" id="input_5_A"/></td>
                <td style="text-align: center">----</td>
                <td><input type="text" class="input-small" id="input_5_C"/></td>
                <td style="text-align: center">----</td>
            </tr>
            <tr item="6">
                <td>（三）免税货物及劳务销售额</td>
                <td>6</td>
                <td><?= $data[6]['A'] ?></td>
                <td><?= $data[6]['B'] ?></td>
                <td><?= $data[6]['C'] ?></td>
                <td><?= $data[6]['D'] ?></td>
            </tr>
            <tr item="7">
                <td>其中：税控器具开具的普通发票销售额</td>
                <td>7</td>
                <td><input type="text" class="input-small" id="input_7_A"/></td>
                <td><input type="text" class="input-small" id="input_7_B"/></td>
                <td><input type="text" class="input-small" id="input_7_C"/></td>
                <td><input type="text" class="input-small" id="input_7_D"/></td>
            <tr item="8">
                <td>（四）出口免税货物销售额</td>
                <td>8</td>
                <td><?= $data[8]['A'] ?></td>
                <td><?= $data[8]['B'] ?></td>
                <td><?= $data[8]['C'] ?></td>
                <td><?= $data[8]['D'] ?></td>
            </tr>
            <tr item="9">
                <td>其中：税控器具开具的普通发票销售额</td>
                <td>9</td>
                <td><input type="text" class="input-small" id="input_9_A"/></td>
                <td><input type="text" class="input-small" id="input_9_B"/></td>
                <td><input type="text" class="input-small" id="input_9_C"/></td>
                <td><input type="text" class="input-small" id="input_9_D"/></td>
            </tr>
            <tr item="10">
                <th rowspan="6" class="tax-min">税<br/>款<br/>计<br/>算</th>
                <td style="text-align: left;">本期应纳税额</td>
                <td style="text-align: center">10</td>
                <td><?= $data[10]['A'] ?></td>
                <td><?= $data[10]['B'] ?></td>
                <td><?= $data[10]['C'] ?></td>
                <td><?= $data[10]['D'] ?></td>
            </tr>
            <tr item="11">
                <td>本期应纳税额减征额</td>
                <td>11</td>
                <td><input type="text" class="input-small" id="input_11_A"/></td>
                <td><input type="text" class="input-small" id="input_11_B"/></td>
                <td><input type="text" class="input-small" id="input_11_C"/></td>
                <td><input type="text" class="input-small" id="input_11_D"/></td>
            </tr>
            <tr item="12">
                <td>应纳税额合计</td>
                <td>12=10-11</td>
                <td><?= $data[12]['A'] ?></td>
                <td><?= $data[12]['B'] ?></td>
                <td><?= $data[12]['C'] ?></td>
                <td><?= $data[12]['D'] ?></td>
            </tr>
            <tr item="13">
                <td>本期预缴税额</td>
                <td>13</td>
                <td><input type="text" class="input-small" id="input_13_A"/></td>
                <td><input type="text" class="input-small" id="input_13_B"/></td>
                <td><input type="text" class="input-small" id="input_13_C"/></td>
                <td><input type="text" class="input-small" id="input_13_D"/></td>
            </tr>
            <tr item="14">
                <td>本期应补（退）税额</td>
                <td>14=12-13</td>
                <td><?= $data[14]['A'] ?></td>
                <td><?= $data[14]['B'] ?></td>
                <td><?= $data[14]['C'] ?></td>
                <td><?= $data[14]['D'] ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table>
        <table class="table table-bordered tax-table tax1_footer" id="tax1_footer">
            <tbody>
            <tr>
                <td rowspan="4" class="tax-table-m">纳税人或代理人声明： 此纳税申报表是根据国 家税收法律的规定填报 的，我确定它是真实 的、可靠的、完整的。</td>
                <td>如纳税人填报，由纳税人填写以下各栏：</td>
            </tr>
            <tr>
                <td>
                    <div style="width: 45%" class="float-left">办税人员（签章）：</div>
                    <div style="width: 45%" class="float-left">财务负责人（签章）：</div>
                    <br/>

                    <div style="width: 45%" class="float-left">法定代表人（签章）：</div>
                    <div style="width: 45%" class="float-left">联系电话：</div>
                </td>
            </tr>
            <tr>
                <td>如代理人填报，由纳税人填写以下各栏：</td>
            </tr>
            <tr>
                <td>
                    <div style="width: 45%" class="float-left">代理人名称：</div>
                    <div style="width: 45%" class="float-left">经办人（签章）：</div>
                    <br/>

                    <div style="width: 45%" class="float-left">代理人（公章）：</div>
                    <div style="width: 45%" class="float-left">联系电话：</div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="alert">
    <a id="dlink" style="display:none;"></a>
    <?php
    echo CHtml::beginForm($this->createUrl('/Report/createexcel'), 'post');
    if ($date != ""){
    $d = date('Y-m', strtotime($date));
    $excel_name = Yii::t('report', "增值税纳税申报表") . "-$d.xls";
    ?>
    <input type="hidden" name="data" id="data" value=""/>
    <input type="hidden" name="name" id="name" value="<?= $excel_name ?>"/>

    <p class="text-right">
        <?php
        echo '<button type="button"onclick="tableToExcel()"class="btn btn-primary"><span class="glyphicon glyphicon-export"></span>' . Yii::t('report', '导出') . '</button>';
        }
        echo CHtml::endForm();
        ?>
    </p>
</div>