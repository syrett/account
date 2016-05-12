<div <?php if (!$data) echo 'style="display:none"'; ?> class="panel panel-default">
    <div class="panel-heading">
        <h2><?= Yii::t('report', '企业所得税纳税申报表') ?>（B类）</h2>
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
            <tbody>
            <tr>
                <th class="center" colspan="3">项目</th>
                <th class="center" >行次</th>
                <th class="center" >累计金额</th>
            </tr>
            <tr>
                <td class="left" colspan="5"><strong>一、以下由按应税所得率计算应纳所得税额的企业填报</strong></td>
            </tr>
            <tr item="1">
                <td class="center tax-min" rowspan="14" style="vertical-align: middle;">
                    应<br />纳<br />税<br />所<br />得<br />额<br />的<br />计<br />算
                </td>
                <td class="center" rowspan="11" style="vertical-align: middle;">
                    按收入总额核定应纳税所得额
                </td>
                <td >收入总额</td>
                <td class='center'  >1</td>
                <td class="right"><?= $data[1]['A'] ?></td>
            </tr>
            <tr item="2">
                <td>
                    减：不征税收入
                </td>
                <td class='center'  >2</td>
                <td class="right"><input type="text" class="input-small" id="input_8_A"/></td>
            </tr>
            <tr item="3">
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;免税收入
                </td>
                <td class='center'  class='center'  >3</td>
                <td class="right"><?= $data[3]['A'] ?></td>
            </tr>
            <tr item="4">
                <td>
                    其中:国债利息收入
                </td>
                <td class='center'  >4</td>
                <td class="right"><input type="text" class="input-small" id="input_8_A"/></td>
            </tr>
            <tr item="5">
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;地方政府债券利息收入
                </td>
                <td class='center'  >5</td>
                <td class="right"><input type="text" class="input-small" id="input_8_A"/></td>
            </tr>
            <tr item="6">
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;符合条件居民企业之间股息红利等权益性收益
                </td>
                <td class='center'  >6</td>
                <td class="right"><input type="text" class="input-small" id="input_8_A"/></td>
            </tr>
            <tr item="7">
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;符合条件的非营利组织收入
                </td>
                <td class='center'  >7</td>
                <td class="right"><input type="text" class="input-small" id="input_8_A"/></td>
            </tr>
            <tr item="8">
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;其他免税收入
                </td>
                <td class='center'  >8</td>
                <td class="right"><?= $data[8]['A'] ?></td>
            </tr>
            <tr item="9">
                <td>
                    应税收入额（1行-2行-3行）
                </td>
                <td class='center'  >9</td>
                <td class="right"><?= $data[9]['A'] ?></td>
            </tr>
            <tr item="10">
                <td>
                    税务机关核定的应税所得率（%）
                </td>
                <td class='center'  >10</td>
                <td class="right"><?= $data[10]['tax'] ?></td>
            </tr>
            <tr item="11">
                <td>
                    应纳税所得额（9行×10行）
                </td>
                <td class='center'  >11</td>
                <td class="right"><?= $data[11]['A'] ?></td>
            </tr>
            <tr item="12">
                <td class="center" rowspan="3" style="vertical-align: middle;">
                    按成本费用核定应纳税所得额
                </td>
                <td >成本费用总额</td>
                <td class='center'  >12</td>
                <td class="right"><?= $data[12]['A'] ?></td>
            </tr>
            <tr item="13">
                <td>
                    税务机关核定的应税所得率（%）
                </td>
                <td class='center'  >13</td>
                <td class="right"><?= $data[13]['tax'] ?></td>
            </tr>
            <tr item="14">
                <td>
                    应纳税所得额[12行÷(100%－13行)×13行]
                </td>
                <td class='center'  >14</td>
                <td class="right"><?= $data[14]['A'] ?></td>
            </tr>
            <tr item="15">
                <td class="center" rowspan="2" colspan="2" style="vertical-align: middle;" >应纳所得税额的计算 </td>
                <td >税率（<?= $data[15]['tax'] ?>%）</td>
                <td class='center'  >15</td>
                <td class="right"><?= $data[15]['tax'] ?></td>
            </tr>
            <tr item="16">
                <td >应纳所得税额（11行×15行或14行×15行）</td>
                <td class='center'  >16</td>
                <td class="right"><?= $data[16]['A'] ?></td>
            </tr>
            <tr item="17">
                <td class="center" rowspan="5" colspan="2" style="vertical-align: middle;" >应补（退）所得税额的计算 </td>
                <td >减：符合条件的小型微利企业减免所得税额</td>
                <td class='center'  >17</td>
                <td class="right"><input type="text" class="input-small" id="input_17_A"/></td>
            </tr>
            <tr item="18">
                <td >&nbsp;&nbsp;&nbsp;&nbsp;其中：减半征税</td>
                <td class='center'  >18</td>
                <td class="right"><input type="text" class="input-small" id="input_18_A"/></td>
            </tr>
            <tr item="19">
                <td >已预缴所得税额</td>
                <td class='center'  >19</td>
                <td class="right"><input type="text" class="input-small" id="input_19_A"/></td>
            </tr>
            <tr item="20">
                <td >应补（退）所得税额（16行-17行-19行）</td>
                <td class='center'  >20</td>
                <td class="right"><?= $data[20]['A'] ?></td>
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