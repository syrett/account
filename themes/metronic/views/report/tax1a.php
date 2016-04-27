<!-- 增值税纳税申报表 -->
<?php

Yii::import('ext.select2.Select2');
$cs = Yii::app()->clientScript;

$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/checkinput.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/tax1a.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/excel_export.js', CClientScript::POS_HEAD);

$data = Product::getTax1_a();
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
        <h2><?= Yii::t('report', '增值税纳税申报表') ?></h2><h4>（<?= Yii::t('import', '适用于一般纳税人') ?>）</h4>
    </div>
    <div class="panel-body">
        <p class="text-center">
            <label class="float-left left" style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                根据《中华人民共和国增值税暂行条例》第二十二条和第二十三条和《交通运输业和部分现代服务业营业税改征增值税试点实施办法(试行)》第五十条和第五十一条的规定制定本表。
                纳税人不论有无销售额，均应按主管税务机关核定的纳税期限按期填报本表，并于次月一日起十五日内，向当地税务机关申报。
            </label>
            <br style="clear: both;"/>
            <br />
            <label class="float-left left"><?= Yii::t('report', '税款申报时间') ?>
                ：<?= date('Y-m-d', strtotime($date)); ?></label> <label
                class="float-right right"><?= Yii::t('report', '填表日期') ?>： <?= date('Y-m-d', time()) ?></label>

        </p>
        <table class="table table-bordered table-hover tax-table tax-table-head" id="tax1">
            <tbody>
            <tr>
                <td style="width: 15%">纳税人识别号</td>
                <td colspan="2"></td>
                <td colspan="3">所属行业</td>
            </tr>
            <tr>
                <td>纳税人名称（公章）</td>
                <td><?= Condom::model()->getName() ?></td>
                <td>法定代表人姓名</td>
                <td>注册地址</td>
                <td>营业地址</td>
                <td style="width: 15%"></td>
            </tr>
            </tbody>
        </table>
        <table class="table table-bordered tax-table tax-table-1a" id="tax1_footer">
            <tbody>
            <tr>
                <th rowspan="2" colspan="2">项目</th>
                <th rowspan="2" class="tax-mid">栏次</th>
                <th colspan="2">一般货物及劳务</th>
                <th colspan="2">即征即退货物及劳务
                </th>
            </tr>
            <tr>
                <th>本期数</th>
                <th>本年累计</th>
                <th>本期数</th>
                <th>本年累计</th>
            </tr>
            <tr item="1">
                <th class="tax-min" rowspan="10">销<br/>售<br/>额</th>
                <td>(一)按适用税率征税货物及劳务销售额</td>
                <td class="center">1</td>
                <td class="right"><?= $data[1]['A'] ?></td>
                <td class="right"><?= $data[1]['C'] ?></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="2">
                <td>&nbsp;&nbsp;其中：应税货物销售额</td>
                <td class="center">2</td>
                <td class="right"><?= $data[2]['A'] ?></td>
                <td class="right"><?= $data[2]['C'] ?></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="3">
                <td>&nbsp;&nbsp;&nbsp;&nbsp;应税劳务销售额</td>
                <td class="center">3</td>
                <td class="right"><?= $data[3]['A'] ?></td>
                <td class="right"><?= $data[3]['C'] ?></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="4">
                <td>&nbsp;&nbsp;&nbsp;&nbsp;纳税检查调整的销售额</td>
                <td class="center">4</td>
                <td class="right"><input type="text" class="input-small" id="input_4_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_4_C"/></td>
                <td style="text-align: center">----</td>
                <td style="text-align: center">----</td>
            </tr>
            <tr  item="5">
                <td>(二)按简易征收办法征税货物销售额</td>
                <td class="center">5</td>
                <td class="right">0</td>
                <td class="right">0</td>
                <td style="text-align: center">----</td>
                <td style="text-align: center">----</td>
            </tr>
            <tr  item="6">
                <td>&nbsp;&nbsp;其中:纳税检查调整的销售额</td>
                <td class="center">6</td>
                <td class="right">0</td>
                <td class="right">0</td>
                <td style="text-align: center">----</td>
                <td style="text-align: center">----</td>
            </tr>
            <tr  item="7">
                <td>（三）免、抵、退办法出口货物及服务销售额</td>
                <td class="center">7</td>
                <td class="right">0</td>
                <td class="right">0</td>
                <td style="text-align: center">----</td>
                <td style="text-align: center">----</td>
            </tr>
            <tr  item="8">
                <td>(四)免税货物及劳务销售额</td>
                <td class="center">8</td>
                <td class="right"><?= $data[8]['A'] ?></td>
                <td class="right"><?= $data[8]['C'] ?></td>
                <td style="text-align: center">----</td>
                <td style="text-align: center">----</td>
            </tr>
            <tr  item="9">
                <td>&nbsp;&nbsp;其中:免税货物销售额</td>
                <td class="center">9</td>
                <td class="right"><?= $data[9]['A'] ?></td>
                <td class="right"><?= $data[9]['C'] ?></td>
                <td style="text-align: center">----</td>
                <td style="text-align: center">----</td>
            </tr>
            <tr  item="10">
                <td>&nbsp;&nbsp;&nbsp;&nbsp;免税劳务销售额</td>
                <td class="center">10</td>
                <td class="right"><?= $data[10]['A'] ?></td>
                <td class="right"><?= $data[10]['C'] ?></td>
                <td style="text-align: center">----</td>
                <td style="text-align: center">----</td>
            </tr>
            <tr  item="11">
                <th class="tax-min" rowspan="14">税<br/>款<br/>计<br/>算</th>
                <td>销项税额</td>
                <td class="center">11</td>
                <td class="right"><?= $data[11]['A'] ?></td>
                <td class="right"><?= $data[11]['C'] ?></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="12">
                <td>进项税额</td>
                <td class="center">12</td>
                <td class="right"><?= $data[12]['A'] ?></td>
                <td class="right"><?= $data[12]['C'] ?></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="13">
                <td>上期留抵税额</td>
                <td class="center">13</td>
                <td class="right"><input type="text" class="input-small" id="input_13_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_13_C"/></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="14">
                <td>进项税额转出</td>
                <td class="center">14</td>
                <td class="right"><input type="text" class="input-small" id="input_14_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_14_C"/></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="15">
                <td>免抵退货物应退税额 </td>
                <td class="center">15</td>
                <td class="right"><input type="text" class="input-small" id="input_15_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_15_C"/></td>
                <td style="text-align: center">----</td>
                <td style="text-align: center">----</td>
            </tr>
            <tr  item="16">
                <td>按适用税率计算的纳税检查应补缴税额 </td>
                <td class="center">16</td>
                <td class="right"><input type="text" class="input-small" id="input_16_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_16_C"/></td>
                <td style="text-align: center">----</td>
                <td style="text-align: center">----</td>
            </tr>
            <tr  item="17">
                <td>应抵扣税额合计</td>
                <td class="center">17=12+13-14-15+16</td>
                <td class="right"><?= $data[17]['A'] ?></td>
                <td style="text-align: center">----</td>
                <td class="right">0</td>
                <td style="text-align: center">----</td>
            </tr>
            <tr  item="18">
                <td>实际抵扣税额</td>
                <td class="center">18(如17<11,则为17, 否则为11)</td>
                <td class="right"><?= $data[18]['A'] ?></td>
                <td class="right"><?= $data[18]['C'] ?></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="19">
                <td>应纳税额 </td>
                <td class="center">19=11-18</td>
                <td class="right"><?= $data[19]['A'] ?></td>
                <td class="right"><?= $data[19]['C'] ?></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="20">
                <td>期末留抵税额 </td>
                <td class="center">20=17-18</td>
                <td class="right"><?= $data[20]['A'] ?></td>
                <td class="center">----</td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="21">
                <td>简易征收办法计算的应纳税额 </td>
                <td class="center">21</td>
                <td class="right"><input type="text" class="input-small" id="input_21_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_21_C"/></td>
                <td style="text-align: center">----</td>
                <td style="text-align: center">----</td>
            </tr>
            <tr  item="22">
                <td>按简易征收办法计算的纳税检查应补缴税额 </td>
                <td class="center">22</td>
                <td class="right"><input type="text" class="input-small" id="input_22_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_22_C"/></td>
                <td style="text-align: center">----</td>
                <td style="text-align: center">----</td>
            </tr>
            <tr  item="23">
                <td>应纳税额减征额 </td>
                <td class="center">23</td>
                <td class="right"><input type="text" class="input-small" id="input_23_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_23_C"/></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="24">
                <td>应纳税额合计 </td>
                <td class="center">24=19+21-23</td>
                <td class="right"><?= $data[24]['A'] ?></td>
                <td class="right"><?= $data[24]['C'] ?></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="25">
                <th rowspan="14" >税<br/>款<br/>缴<br/>纳</th>
                <td>期初未缴税额（多缴为负数）  </td>
                <td class="center">25</td>
                <td class="right"><input type="text" class="input-small" id="input_25_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_25_C"/></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="26">
                <td>实收出口开具专用缴款书退税额  </td>
                <td class="center">26</td>
                <td class="right"><input type="text" class="input-small" id="input_26_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_26_C"/></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="27">
                <td>本期已缴税额  </td>
                <td class="center">27=28+29+30+31</td>
                <td class="right"><?= $data[27]['A'] ?></td>
                <td class="right"><?= $data[27]['C'] ?></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="28">
                <td>1 分次预缴税额  </td>
                <td class="center">28</td>
                <td class="right"><input type="text" class="input-small" id="input_28_A"/></td>
                <td style="text-align: center">----</td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="29">
                <td>2 出口开具专用缴款书预缴税额  </td>
                <td class="center">29</td>
                <td style="text-align: center">----</td>
                <td style="text-align: center">----</td>
                <td style="text-align: center">----</td>
                <td style="text-align: center">----</td>
            </tr>
            <tr  item="30">
                <td>3 本期缴纳上期应纳税额  </td>
                <td class="center">30</td>
                <td class="right"><?= $data[30]['A'] ?></td>
                <td class="right"><?= $data[30]['C'] ?></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="31">
                <td>4 本期缴纳欠缴税额  </td>
                <td class="center">31</td>
                <td class="right"><input type="text" class="input-small" id="input_23_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_23_C"/></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="32">
                <td>期末未缴税额（多缴为负数）  </td>
                <td class="center">32=24+25+26-27</td>
                <td class="right"><?= $data[32]['A'] ?></td>
                <td class="right"><?= $data[32]['C'] ?></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="33">
                <td>其中：欠缴税额（≥0）  </td>
                <td class="center">33=25+26-27</td>
                <td class="right"><?= $data[33]['A'] ?></td>
                <td class="right"><?= $data[33]['C'] ?></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="34">
                <td>本期应补(退)税额  </td>
                <td class="center">34=24-28-29</td>
                <td class="right"><?= $data[34]['A'] ?></td>
                <td class="right"><?= $data[34]['C'] ?></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="35">
                <td>即征即退实际退税额  </td>
                <td class="center">35</td>
                <td class="right"><input type="text" class="input-small" id="input_23_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_23_C"/></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="36">
                <td>期初未缴查补税额  </td>
                <td class="center">36</td>
                <td class="right"><input type="text" class="input-small" id="input_23_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_23_C"/></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="37">
                <td>本期入库查补税额  </td>
                <td class="center">37</td>
                <td class="right"><input type="text" class="input-small" id="input_23_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_23_C"/></td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr  item="38">
                <td>期末未缴查补税额  </td>
                <td class="center">38=16+22+36-37</td>
                <td class="right"><?= $data[38]['A'] ?></td>
                <td class="right"><?= $data[38]['C'] ?></td>
                <td class="right">0</td>
                <td class="right">0</td>
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