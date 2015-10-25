<!-- 现金流量表 -->
<?php

//Yii::app()->clientScript->registerCoreScript('jquery');
Yii::import('ext.select2.Select2');
$cs = Yii::app()->clientScript;

$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/balance.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/excel_export.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/pages/scripts/components-pickers.js', CClientScript::POS_END);

$cs->registerScript('ComponentsPickersInit', 'ComponentsPickers.init();', CClientScript::POS_READY);
?>

<?php
function echoData($key, $data, $name = "default")
{
    $strong = [9,20,21,29,36,37,44,53,54,55,56,75, 83];
    if ($key === "empty" || $key === 0) {
        echo "<th>". $name . "</th>";
        echo "<td>&nbsp;</td>";
    } elseif (empty($data[$key])) {
        echo "<td class='left'>". $name . "</td>";
        echo "<td>0.00</td>";
    } else {
        $arr = $data[$key];
        if ($name === "default") {
            echo "<td class='left'>". $arr["name"] . "</td>";
        } else {
            echo in_array($key, $strong)?"<th>". $name . "</th>":"<td class='left'>". $name . "</td>";
        }
        echo "<td>". number_format($arr["end"], 2, ".", ",") . "</td>";
    }
}

?>
<div class="alert alert-info">
    <?php echo CHtml::beginForm('', 'post', array('class' => 'form-inline', 'id' => 'report')); ?>
    <h3>现金流量表</h3>

    <div class="form-group">
        <label class="control-label"for="date">请选择报表日期：</label>
        <input type="text"data-date-format="yyyymmdd"name="date"
               class="form-control form-control-inline input-small date-picker"
               value="<?php echo isset($date) ? $date : '' ?>"id="date"readonly="">
        <input type="button"onclick="javascript:$('#type').val('month');$('#report').submit();"class="btn btn-primary"
               value="月份报表查看"/>
        <input type="button"onclick="javascript:$('#type').val('year');;$('#report').submit();"class="btn btn-primary"
               value="年度报表查看"/>
        <input type="hidden"name="type"id="type">
    </div>
    <p>&nbsp;</p>
    <?php echo CHtml::endForm(); ?>
</div>
<div <?php if (!$data) echo 'style="display:none"'; ?> class="panel panel-default">
    <div class="panel-heading">
        <h2>现 金 流 量 表</h2>
    </div>
    <div class="panel-body">
        <p class="text-center"><span class="pull-left">日期：<?php echo date('Y-m-d', strtotime($date)); ?></span>
            编制单位：<?= Condom::model()->getName() ?> <span class="pull-right">金额单位：元</span></p>
    </div>

    <table class="table table-bordered table-hover" id="money">
        <thead>
        <tr>
            <th>项目</th>
            <th class="text-right">金额</th>
            <th class="text-right">补充资料</th>
            <th class="text-right">金额</th>
        </tr>
        </thead>
        <tr>
            <?php echoData("empty", $data, "一、经营活动产生的现金流量：") ?>
            <?php echoData("empty", $data, "1、将净利润调节为经营活动现金流量：") ?>
        </tr>
        <tr>
            <?php echoData(1, $data, "销售商品、提供劳务收到的现金") ?>
            <?php echoData(57, $data, "净利润") ?>
        </tr>
        <tr>
            <?php echoData(3, $data, "收到的税费返还") ?>
            <?php echoData(58, $data, "加：计提的资产减值准备") ?>
        </tr>
        <tr>
            <?php echoData(8, $data, "收到的其他与经营活动有关的现金") ?>
            <?php echoData(59, $data, "固定资产折旧") ?>
        </tr>
        <tr>
            <?php echoData(9, $data, "现金流入小计") ?>
            <?php echoData(60, $data, "无形资产摊销") ?>
        </tr>
        <tr>
            <?php echoData(10, $data, "购买商品、接受劳务支付的现金") ?>
            <?php echoData(61, $data, "长期待摊费用摊销") ?>
        </tr>
        <tr>
            <?php echoData(12, $data, "支付给职工以及为职工支付的现金") ?>
            <?php echoData(64, $data, "待摊费用减少 （减：增加）") ?>
        </tr>
        <tr>
            <?php echoData(13, $data, "支付的各项税费") ?>
            <?php echoData(65, $data, "预提费用增加  (减：减少）") ?>
        </tr>
        <tr>
            <?php echoData(18, $data, "支付的其他与经营活动有关的现金") ?>
            <?php echoData(66, $data, "处置固定资产、无形资产和其他长期资产的损失（减：收益）") ?>
        </tr>
        <tr>
            <?php echoData(20, $data, "现金流出小计") ?>
            <?php echoData(67, $data, "固定资产报废损失") ?>
        </tr>
        <tr>
            <?php echoData(21, $data, "经营活动产生的现金流量净额") ?>
            <?php echoData(68, $data, "财务费用") ?>
        </tr>
        <tr>
            <?php echoData(0, $data, "二、投资活动产生的现金流量：") ?>
            <?php echoData(69, $data, "投资损失（减：收益）") ?>
        </tr>
        <tr>
            <?php echoData(22, $data, "收回投资所收到的现金") ?>
            <?php echoData(70, $data, "递延税款贷项（减：借项）") ?>
        </tr>
        <tr>
            <?php echoData(23, $data, "取得投资收益所收到的现金") ?>
            <?php echoData(71, $data, "存货的减少（减：增加）") ?>
        </tr>
        <tr>
            <?php echoData(25, $data, "处置固定资产、无形资产和其他长期资产所收回的现金净额") ?>
            <?php echoData(72, $data, "经营性应收项目的减少（减：增加）") ?>
        </tr>
        <tr>
            <?php echoData(28, $data, "收到的其他与投资活动有关的现金") ?>
            <?php echoData(73, $data, "经营性应付项目的增加（减：减少）") ?>
        </tr>
        <tr>
            <?php echoData(29, $data, "现金流入小计") ?>
            <?php echoData(74, $data, "其他") ?>
        </tr>
        <tr>
            <?php echoData(30, $data, "购建固定资产、无形资产和其他长期资产所支付的现金") ?>
            <?php echoData(75, $data, "经营活动产生的现金流量净额") ?>
        </tr>
        <tr>
            <?php echoData(31, $data, "投资所支付的现金") ?>
            <?php echoData("empty", $data,'') ?>
        </tr>
        <tr>
            <?php echoData(35, $data, "支付的其他与投资活动有关的现金") ?>
            <?php echoData("empty", $data,'') ?>
        </tr>
        <tr>
            <?php echoData(36, $data, "现金流出小计") ?>
            <?php echoData("empty", $data,'') ?>
        </tr>
        <tr>
            <?php echoData(37, $data, "投资活动产生的现金流量净额") ?>
            <?php echoData(0, $data, "2、不涉及现金收支的投资和筹资活动：") ?>
        </tr>
        <tr>
            <?php echoData(0, $data, "三、筹资活动产生的现金流量：") ?>
            <?php echoData(76, $data, "债务转为资本") ?>
        </tr>
        <tr>
            <?php echoData(38, $data, "吸收投资所收到的现金") ?>
            <?php echoData(77, $data, "一年内到期的可转换公司债券") ?>
        </tr>
        <tr>
            <?php echoData(40, $data, "借款所收到的现金") ?>
            <?php echoData(78, $data, "融资租入固定资产") ?>
        </tr>
        <tr>
            <?php echoData(43, $data, "收到的其他与筹资活动有关的现金") ?>
            <?php echoData("empty", $data,'') ?>
        </tr>
        <tr>
            <?php echoData(44, $data, "现金流入小计") ?>
            <?php echoData("empty", $data,'') ?>
        </tr>
        <tr>
            <?php echoData(45, $data, "归还债务所支付的现金") ?>
            <?php echoData("empty", $data,'') ?>
        </tr>
        <tr>
            <?php echoData(46, $data, "分配股利、利润或偿付利息所支付的现金") ?>
            <?php echoData(0, $data, "3、现金及现金等价物净增加情况：") ?>
        </tr>
        <tr>
            <?php echoData(52, $data, "支付的其他与筹资活动有关的现金") ?>
            <?php echoData(79, $data, "现金的期末余额") ?>
        </tr>
        <tr>
            <?php echoData(53, $data, "现金流出小计") ?>
            <?php echoData(80, $data, "减：现金的期初余额") ?>
        </tr>
        <tr>
            <?php echoData(54, $data, "筹资活动产生的现金流量净额") ?>
            <?php echoData(81, $data, "加：现金等价物的期末余额") ?>
        </tr>
        <tr>
            <?php echoData(55, $data, "四、汇率变动对现金的影响") ?>
            <?php echoData(82, $data, "减：现金等价物的期初余额") ?>
        </tr>
        <tr>
            <?php echoData(56, $data, "五、现金及现金等价物净增加额") ?>
            <?php echoData(83, $data, "现金及现金等价物净增加额") ?>
        </tr>


    </table>
</div>
<div class="alert">
    <a id="dlink"style="display:none;"></a>
    <?php
    echo CHtml::beginForm($this->createUrl('/Report/createexcel'), 'post');
    if ($date != ""){
    $d = date('Y-m', strtotime($date));
    $excel_name = "现金流量表-". $d . ".xls";
    ?>
    <input type="hidden"name="data"id="data"value=""/>
    <input type="hidden"name="name"id="name"value="<?= $excel_name ?>"/>

    <p class="text-right">
        <?php
        echo '<button type="button"onclick="tableToExcel()"class="btn btn-primary"><span class="glyphicon glyphicon-export"></span> 导出</button>';
        }
        echo CHtml::endForm();
        ?>
    </p>
</div>