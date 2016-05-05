<div <?php if (!$data) echo 'style="display:none"'; ?> class="panel panel-default">
    <div class="panel-heading">
        <h2><?= Yii::t('report', '企业所得税纳税申报表') ?>（A类）</h2>
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
        <table class="table table-bordered table-hover tax-table tax-table-4" id="tax1">
            <thead>
            <tr>
                <th rowspan="2" class="center" style="vertical-align: middle">行次</th>
                <th rowspan="2" class="center" colspan="2" style="vertical-align: middle">项目</th>
                <th class="center" >本期金额</th>
                <th class="center" >累计金额</th>
            </tr>
            <tr>
                <th class="center" >1</th>
                <th class="center" >2</th>
            </tr>
            </thead>
            <tbody>
            <tr item="1">
                <td class="center">1</td>
                <td class="left" colspan="4"><strong>一、按照实际利润额预缴</strong></td>
            </tr>
            <tr item="2">
                <td class="center">2</td>
                <td class="left" colspan="2">营业收入</td>
                <td class="right"><?= $data[2]['A'] ?></td>
                <td class="right"><?= $data[2]['C'] ?></td>
            </tr>
            <tr item="3">
                <td class="center">3</td>
                <td class="left" colspan="2">营业成本</td>
                <td class="right"><?= $data[3]['A'] ?></td>
                <td class="right"><?= $data[3]['C'] ?></td>
            </tr>
            <tr item="4">
                <td class="center">4</td>
                <td class="left" colspan="2">利润总额</td>
                <td class="right"><?= $data[4]['A'] ?></td>
                <td class="right"><?= $data[4]['C'] ?></td>
            </tr>
            <tr item="5">
                <td class="center">5</td>
                <td class="left" colspan="2">
                    加：特定业务计算的应纳税所得额
                </td>
                <td class="right"><input type="text" class="input-small" id="input_5_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_5_C"/></td>
            </tr>
            <tr item="6">
                <td class="center">6</td>
                <td class="left" colspan="2">
                    减：不征税收入和税基减免应纳税所得额
                </td>
                <td class="right"><input type="text" class="input-small" id="input_6_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_6_C"/></td>
            </tr>
            <tr item="7">
                <td class="center">7</td>
                <td class="left" colspan="2">&nbsp;&nbsp;&nbsp;固定资产加速折旧（扣除）调减额</td>
                <td class="right"><input type="text" class="input-small" id="input_7_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_7_C"/></td>
            </tr>
            <tr item="8">
                <td class="center">8</td>
                <td class="left" colspan="2">&nbsp;&nbsp;&nbsp;弥补以前年度亏损</td>
                <td class="right"><input type="text" class="input-small" id="input_8_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_8_C"/></td>
            </tr>
            <tr item="9">
                <td class="center">9</td>
                <td class="left" colspan="2">实际利润额（4行+5行-6行-7行-8行）</td>
                <td class="right"><?= $data[9]['A'] ?></td>
                <td class="right"><?= $data[9]['C'] ?></td>
            </tr>
            <tr item="10">
                <td class="center">10</td>
                <td class="left" colspan="2">税率（<?= $data[10]['tax'] ?>%）</td>
                <td class="right"><input type="hidden" value="<?= $data[10]['tax'] ?>" /></td>
                <td class="right"><input type="hidden" value="<?= $data[10]['tax'] ?>" /></td>
            </tr>
            <tr item="11">
                <td class="center">11</td>
                <td class="left" colspan="2">应纳所得税额（9行×10行）</td>
                <td class="right"><?= $data[11]['A'] ?></td>
                <td class="right"><?= $data[11]['C'] ?></td>
            </tr>
            <tr item="12">
                <td class="center">12</td>
                <td class="left" colspan="2">减：减免所得税额</td>
                <td class="right"><input type="text" class="input-small" id="input_12_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_12_C"/></td>
            </tr>
            <tr item="13">
                <td class="center">13</td>
                <td class="left" colspan="2">实际已预缴所得税额</td>
                <td class="center">----</td>
                <td class="right"><?= $data[13]['C'] ?></td>
            </tr>
            <tr item="14">
                <td class="center">14</td>
                <td class="left" colspan="2">特定业务预缴（征）所得税额
                </td>
                <td class="right"><input type="text" class="input-small" id="input_14_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_14_C"/></td>
            </tr>
            <tr item="15">
                <td class="center">15</td>
                <td class="left" colspan="2">应补（退）所得税额（11行-12行-13行-14行）
                </td>
                <td class="center">----</td>
                <td class="right"><?= $data[15]['C'] ?></td>
            </tr>
            <tr item="16">
                <td class="center">16</td>
                <td class="left" colspan="2">减：以前年度多缴在本期抵缴所得税额</td>
                <td class="right"><input type="text" class="input-small" id="input_16_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_16_C"/></td>
            </tr>
            <tr item="17">
                <td class="center">17</td>
                <td class="left" colspan="2">本月（季）实际应补（退）所得税额</td>
                <td class="center">----</td>
                <td class="right"><?= $data[17]['C'] ?></td>
            </tr>
            <tr item="18">
                <td class="center">18</td>
                <td class="left" colspan="4" ><strong>二、按上一纳税年度应纳税所得额平均额预缴</strong></td>
            </tr>
            <tr item="19">
                <td class="center">19</td>
                <td class="left" colspan="2">上一纳税年度应纳税所得额</td>
                <td class="center">----</td>
                <td class="right"><input type="text" class="input-small" id="input_19_C"/></td>
            </tr>
            <tr item="20">
                <td class="center">20</td>
                <td class="left" colspan="2">本月（季）应纳税所得额（19行×1/4或1/12）</td>
                <td class="right"><?= $data[20]['A'] ?></td>
                <td class="right"><?= $data[20]['C'] ?></td>
            </tr>
            <tr item="21">
                <td class="center">21</td>
                <td class="left" colspan="2">税率（<?= $data[10]['tax'] ?>%）</td>
                <td class="right"><input type="hidden" value="<?= $data[10]['tax'] ?>" /></td>
                <td class="right"><input type="hidden" value="<?= $data[10]['tax'] ?>" /></td>
            </tr>
            <tr item="22">
                <td class="center">22</td>
                <td class="left" colspan="2">本月（季）应纳所得税额（20行×21行）</td>
                <td class="right"><?= $data[22]['A'] ?></td>
                <td class="right"><?= $data[22]['C'] ?></td>
            </tr>
            <tr item="23">
                <td class="center">23</td>
                <td class="left" colspan="2">减：减免所得税额
                </td>
                <td class="right"><input type="text" class="input-small" id="input_23_A"/></td>
                <td class="right"><input type="text" class="input-small" id="input_23_C"/></td>
            </tr>
            <tr item="24">
                <td class="center">24</td>
                <td class="left" colspan="2">本月（季）实际应纳所得税税额（22行-23行）</td>
                <td class="right"><?= $data[24]['A'] ?></td>
                <td class="right"><?= $data[24]['C'] ?></td>
            </tr>
            <tr item="25">
                <td class="center">25</td>
                <td class="left" colspan="4"><strong>三、按照税务机关确定的其他方法预缴</strong></td>
            </tr>
            <tr item="26">
                <td class="center">26</td>
                <td class="left" colspan="2">本月（季）税务机关确定的预缴所得税额</td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr item="27">
                <td class="center">27</td>
                <td class="left" colspan="4"><strong>总分机构纳税人</strong>
                </td>
            </tr>
            <tr item="28">
                <td class="center">28</td>
                <td class="center" rowspan="4" style="vertical-align: middle">总机构</td>
                <td class="left">总机构分摊所得税额(15行或24行或26行×总机构分摊预缴比例)
                </td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr item="29">
                <td class="center">29</td>
                <td class="left">财政集中分配所得税额</td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr item="30">
                <td class="center">30</td>
                <td class="left">分支机构分摊所得税额(15行或24行或26行×分支机构分摊比例)
                </td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr item="31">
                <td class="center">31</td>
                <td class="left">其中：总机构独立生产经营部门应分摊所得税额</td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr item="32">
                <td class="center">32</td>
                <td class="center" rowspan="2" style="vertical-align: middle">分支机构</td>
                <td class="left">分配比例(%)
                </td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr item="33">
                <td class="center">33</td>
                <td class="left">分配的所得税额</td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            </tbody>
        </table>
        <table class="table table-bordered tax-table tax1_footer" id="tax1_footer">
            <tbody>
            <tr>
                <td colspan="3" class="tax-table-m">谨声明：此纳税申报表是根据《中华人民共和国企业所得税法》、《中华人民共和国企业所得税法实施条例》和国家有关税收规定填报
                    的，是真实的、可靠的、完整的。
                    <br/>
                    <br/>
                    <br/>
                    <div style="width: 45%" class="float-right">年&nbsp;&nbsp;&nbsp;&nbsp;月&nbsp;&nbsp;&nbsp;&nbsp;日</div>
                    <div style="width: 45%" class="float-right">法定代表人（签字）：</div>
                </td>
            </tr>
            <tr>
                <td>
                    <br />
                    纳税人公章：
                    <br />
                    <br />
                    会计主管：
                    <br />
                    <br />
                    填表日期：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;年&nbsp;&nbsp;&nbsp;月&nbsp;&nbsp;&nbsp;日
                </td>
                <td>
                    代理申报中介机构公章：
                    <br />
                    <br />
                    经办人：
                    <br />
                    <br />
                    经办人执业证件号码：
                    <br />
                    <br />
                    代理申报日期：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;年&nbsp;&nbsp;&nbsp;月&nbsp;&nbsp;&nbsp;日
                </td>
                <td>
                    <br />
                    主管税务机关受理专用章：
                    <br />
                    <br />
                    受理人：
                    <br />
                    <br />
                    受理日期：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;年&nbsp;&nbsp;&nbsp;月&nbsp;&nbsp;&nbsp;日
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>