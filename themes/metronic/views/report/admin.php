<!-- 资产负债表 -->
<?php

$cs = Yii::app()->clientScript;

$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/amcharts/amcharts/amcharts.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/amcharts/amcharts/serial.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/amcharts/amcharts/themes/light.js', CClientScript::POS_END);

$expense_income_data = '
var chart = AmCharts.makeChart("chartdiv-report", {
  "type": "serial",
  "addClassNames": true,
  "theme": "light",
  "autoMargins": false,
  "marginLeft": 30,
  "marginRight": 8,
  "marginTop": 10,
  "marginBottom": 26,
  "balloon": {
    "adjustBorderColor": false,
    "horizontalPadding": 10,
    "verticalPadding": 8,
    "color": "#ffffff"
  },

  "dataProvider": [{
    "month": "'.Yii::t('report', '一月').'",
    "income": 23.5,
    "expenses": 21.1
  }, {
    "month": "'.Yii::t('report', '二月').'",
    "income": 26.2,
    "expenses": 30.5
  }, {
    "month": "'.Yii::t('report', '三月').'",
    "income": 30.1,
    "expenses": 28.9
  }, {
    "month": "'.Yii::t('report', '四月').'",
    "income": 29.5,
    "expenses": 28.1
  }, {
    "month": "'.Yii::t('report', '五月').'",
    "income": 30.6,
    "expenses": 28.2,
  }, {
    "month": "'.Yii::t('report', '六月').'",
    "income": 30.6,
    "expenses": 28.2,
  }, {
    "month": "'.Yii::t('report', '七月').'",
    "income": 30.6,
    "expenses": 28.2,
  }, {
    "month": "'.Yii::t('report', '八月').'",
    "income": 30.6,
    "expenses": 28.2,
  }, {
    "month": "'.Yii::t('report', '九月').'",
    "income": 30.6,
    "expenses": 28.2,
  }, {
    "month": "'.Yii::t('report', '十月').'",
    "income": 30.6,
    "expenses": 28.2,
  }, {
    "month": "'.Yii::t('report', '十一月').'",
    "income": 30.6,
    "expenses": 28.2,
  }, {
    "month": "'.Yii::t('report', '十二月').'",
    "income": 34.1,
    "expenses": 30.9,
    "dashLengthColumn": 5,
    "alpha": 0.2,
    "additional": "(预估)"
  }],
  "valueAxes": [{
    "axisAlpha": 0,
    "position": "left"
  }],
  "startDuration": 1,
  "graphs": [{
    "alphaField": "alpha",
    "balloonText": "<span style='."font-size:12px;".'>[[category]][[title]]:<br><span style='."font-size:20px;".'>[[value]]</span> [[additional]]</span>",
    "fillAlphas": 1,
    "title": "'.Yii::t('report', ' 收入').'",
    "type": "column",
    "valueField": "income",
    "dashLengthField": "dashLengthColumn"
  }, {
    "id": "graph2",
    "balloonText": "<span style='."font-size:12px;".'>[[category]][[title]]:<br><span style='.'font-size:20px;'.'>[[value]]</span> [[additional]]</span>",
    "bullet": "round",
    "lineThickness": 3,
    "bulletSize": 7,
    "bulletBorderAlpha": 1,
    "bulletColor": "#FFFFFF",
    "useLineColorForBulletBorder": true,
    "bulletBorderThickness": 3,
    "fillAlphas": 0,
    "lineAlpha": 1,
    "title": "'.Yii::t('report', ' 支出').'",
    "valueField": "expenses"
  }],
  "categoryField": "month",
  "categoryAxis": {
    "gridPosition": "start",
    "axisAlpha": 0,
    "tickLength": 0
  },
  "export": {
    "enabled": true
  }
});

';
$cs->registerScript('ChartsFlotchartsInitPie',$expense_income_data, CClientScript::POS_READY);

?>

<div class="row">
	<!-- BEGIN PORTLET-->
	<div class="portlet light">
		<div class="portlet-title">
			<div class="caption">
				<i class="icon-share font-red-sunglo hide"></i>
				<span class="caption-subject font-red-sunglo bold uppercase"><?= Yii::t('report', '经营收支报表') ?></span>
				<span class="caption-helper"><?= Yii::t('report', '单位：百万元') ?></span>
			</div>
			<div class="tools">
				<a href="javascript:;" class="collapse" data-original-title="" title="">
				</a>
			</div>
		</div>
		<div class="portlet-body">
			<div id="chartdiv-report"></div>
		</div>
	</div>
	<div class="portlet light">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-gift"></i><?= Yii::t('report', '全部报表') ?>
			</div>
			<div class="tools">
				<a href="javascript:;" class="collapse" data-original-title="" title="<?= Yii::t('import', '折叠')?>"></a>
				<a href="javascript:;" class="fullscreen" data-original-title="" title="<?= Yii::t('import', '全屏')?>"></a>
			</div>
		</div>
		<div class="portlet-body">
			<div class="tabbable-line">
				<ul class="nav nav-tabs ">
					<li class="active">
						<a href="#tab_15_finance" data-toggle="tab" aria-expanded="true">
							<?= Yii::t('report', '财务类') ?></a>
					</li>
                    <li class="">
                        <a href="#tab_common" data-toggle="tab" aria-expanded="false">
                            <?= Yii::t('report', '行政类') ?></a>
                    </li>
                    <li class="">
                        <a href="#tab_tax" data-toggle="tab" aria-expanded="false">
                            <?= Yii::t('report', '税务类') ?></a>
                    </li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_15_finance">
						<h3><?= Yii::t('report', '财务报表') ?></h3>
						<div class="row">
							<div class="col-md-6">
								<div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/balance') ?>">
                                        <img
                                            src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/balance_report.jpg'; ?>"
                                            class="img-responsive img-thumbnail"/>
                                    </a>
                                </div>
                                <div class="col-md-9">
                                    <h4 class="media-heading"><a
                                            href="<?= $this->createUrl('report/balance') ?>"><?= Yii::t('report', '资产负债表') ?></a>
                                    </h4>
                                    <p>
                                        <? if (Yii::app()->language == 'zh_cn') {
                                            ?>
                                            利用会计平衡原则，将资产、负债、股东权益”交易科目分为“资产”和“负债及股东权益”两大区块，在经过分录、转帐、分类帐、试算、调整等等会计程序后，以特定日期的静态企业情况为基准，浓缩成一张报表。
                                            <?
                                        } else {
                                            ?>
                                            Using the principle of accounting balance, the assets, liabilities, equity trading subjects are divided into "assets" and "liabilities and equity" in two block, after entry, transfer, ledger, trial, adjustment and so on, to a specific date of the static business conditions as the benchmark, condensed into a report.
                                            <?
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/profit') ?>">
                                        <img
                                            src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/profit_report.jpg'; ?>"
                                            class="img-thumbnail"/>
                                    </a>
                                </div>
                                <div class="col-md-9">
                                    <h4 class="media-heading"><a
                                            href="<?= $this->createUrl('report/profit') ?>"><?= Yii::t('report', '损益表') ?></a>
                                    </h4>
                                    <p>
                                        <? if (Yii::app()->language == 'zh_cn') {
                                            ?>
                                            反映企业在一定会计期的经营成果及其分配情况的会计报表，是一段时间内公司经营业绩的财务记录，反映了这段时间的销售收入、销售成本、经营费用及税收状况，报表结果为公司实现的利润或亏损。
                                            <?
                                        } else {
                                            ?>
                                            Reflect the enterprise in a certain accounting period operating results and the distribution of the accounting statement, is for a period of time within the operating results of the company's financial records and reflects this time sales income, cost of sales, operating expenses and tax status, report the results to achieve the company's profit or loss.
                                            <?
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/subjects') ?>">
                                        <img
                                            src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/subjects_report.jpg'; ?>"
                                            class="img-thumbnail"/>
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <h4 class="media-heading"><a
                                            href="<?= $this->createUrl('report/subjects') ?>"><?= Yii::t('report', '科目余额表') ?></a>
                                    </h4>
                                    <p>
                                        <? if (Yii::app()->language == 'zh_cn') {
                                            ?>
                                            按照总账科目余额编制的。<br/>资产类科目：期末借方余额=期初借方余额+本期借方发生额-本期贷方发生额；
                                            <br/>负债及所有者权益类科目：期末贷方余额=期初贷方余额+本期贷方发生额-本期借方发生额。
                                            <?
                                        } else {
                                            ?>
                                            According to the general ledger balance to draw up the account balance sheet.
                                            <?
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/detail') ?>">
                                        <img
                                            src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/detail_report.jpg'; ?>"
                                            class="img-thumbnail"/>
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <h4 class="media-heading"><a
                                            href="<?= $this->createUrl('report/detail') ?>"><?= Yii::t('report', '明细表') ?></a>
                                    </h4>
                                    <p>
                                        <? if (Yii::app()->language == 'zh_cn') {
                                            ?>
                                            按明细分类账户登记的账簿叫做明细分类账,简称“明细账”。明细账也称明细分类账，是根据总账科目所属的明细科目设置的，用于分类登记某一类经济业务事项，提供有关明细核算资料。
                                            <?
                                        } else {
                                            ?>
                                            According to the subsidiary ledger account registration book called ledger ledger, referred to as " Detailed account". Ledger also known as subsidiary ledger, according to set the general ledger accounts belonging to the details of the subjects for classification of a kind of economic and business transactions registration and provide relevant details of accounting data.
                                            <?
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/money') ?>">
                                        <img
                                            src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/money_report.jpg'; ?>"
                                            class="img-thumbnail"/>
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <h4 class="media-heading"><a
                                            href="<?= $this->createUrl('report/money') ?>"><?= Yii::t('report', '现金流量表') ?></a>
                                    </h4>
                                    <p>
                                        <? if (Yii::app()->language == 'zh_cn') {
                                            ?>
                                            现金流量表的出现，主要是要反映出资产负债表中各个项目对现金流量的影响，并根据其用途划分为经营、投资及融资三个活动分类。<?
                                        } else {
                                            ?>
                                            Cash flow statement, mainly to reflect the impact of the balance sheet of the various items on the cash flow, and based on its use is divided into three activities of business, investment and financing.
                                            <?
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_common">
                        <h3><?= Yii::t('report', '行政报表') ?></h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/vendor') ?>">
                                        <img
                                            src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/balance_report.jpg'; ?>"
                                            class="img-responsive img-thumbnail"/>
                                    </a>
                                </div>
                                <div class="col-md-9">
                                    <h4 class="media-heading"><a
                                            href="<?= $this->createUrl('report/vendor') ?>"><?= Yii::t('report', '供应商表') ?></a>
                                    </h4>
                                    <p>
                                        <? if (Yii::app()->language == 'zh_cn') {
                                            ?>
                                            现金流量表的出现，主要是要反映出资产负债表中各个项目对现金流量的影响，并根据其用途划分为经营、投资及融资三个活动分类。
                                            <?
                                        } else {
                                            ?>
                                            The sub supplier lists the amount of the purchase transaction, the payment term and the unpaid amount.
                                            <?
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/client') ?>">
                                        <img
                                            src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/profit_report.jpg'; ?>"
                                            class="img-thumbnail"/>
                                    </a>
                                </div>
                                <div class="col-md-9">
                                    <h4 class="media-heading"><a
                                            href="<?= $this->createUrl('report/client') ?>"><?= Yii::t('report', '客户表') ?></a>
                                    </h4>
                                    <p>
                                        <? if (Yii::app()->language == 'zh_cn') {
                                            ?>
                                            现金流量表的出现，主要是要反映出资产负债表中各个项目对现金流量的影响，并根据其用途划分为经营、投资及融资三个活动分类。
                                            <?
                                        } else {
                                            ?>
                                            The customer is listed in the current transaction, the amount of the transaction and received payment and unpaid amount.
                                            <?
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="row">
                            <!--							<div class="col-md-6">-->
                            <!--								<div class="col-md-3 col-xs-3">-->
                            <!--                                    <a href="-->
                            <? //= $this->createUrl('report/project') ?><!--">-->
                            <!--                                        <img src="-->
                            <?php //echo Yii::app()->theme->baseUrl . '/assets/custom/subjects_report.jpg'; ?><!--" class="img-thumbnail" />-->
                            <!--                                    </a>-->
                            <!--								</div>-->
                            <!--								<div class="col-md-8">-->
                            <!--									<h4 class="media-heading"><a href="-->
                            <? //= $this->createUrl('report/project') ?><!--">项目表</a></h4>-->
                            <!--									<p>&nbsp;</p>-->
                            <!--							 	</div>-->
                            <!--							</div>-->
                            <div class="col-md-6">
                                <div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/department') ?>">
                                        <img
                                            src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/detail_report.jpg'; ?>"
                                            class="img-thumbnail"/>
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <h4 class="media-heading"><a
                                            href="<?= $this->createUrl('report/department') ?>"><?= Yii::t('report', '部门表') ?></a>
                                    </h4>
                                    <p>
                                        <? if (Yii::app()->language == 'zh_cn') {
                                            ?>
                                            分部门列示本期交易的发生各项费用，让您对部门的收支一目了然。
                                            <?
                                        } else {
                                            ?>
                                            The division of the transaction costs, so that you have a glance at the department of income and expenditure.
                                            <?
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div><div class="tab-pane" id="tab_tax">
                        <h3><?= Yii::t('report', '税务报表') ?></h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/tax1') ?>">
                                        <img
                                            src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/tax1_report.jpg'; ?>"
                                            class="img-responsive img-thumbnail"/>
                                    </a>
                                </div>
                                <div class="col-md-9">
                                    <h4 class="media-heading"><a
                                            href="<?= $this->createUrl('report/tax1') ?>"><?= Yii::t('report', '增值税纳税申报表') ?></a>
                                    </h4>
                                    <p>
                                        <? if (Yii::app()->language == 'zh_cn') {
                                            ?>
                                            现金流量表的出现，主要是要反映出资产负债表中各个项目对现金流量的影响，并根据其用途划分为经营、投资及融资三个活动分类。
                                            <?
                                        } else {
                                            ?>
                                            The sub supplier lists the amount of the purchase transaction, the payment term and the unpaid amount.
                                            <?
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-3 col-xs-3">
                                    <a href="#">
                                        <img
                                            src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/tax2_report.jpg'; ?>"
                                            class="img-thumbnail"/>
                                    </a>
                                </div>
                                <div class="col-md-9">
                                    <h4 class="media-heading"><a
                                            href="#"><?= Yii::t('report', '营业税纳税申报表') ?></a>
                                    </h4>
                                    <p>
                                        <? if (Yii::app()->language == 'zh_cn') {
                                            ?>
                                            现金流量表的出现，主要是要反映出资产负债表中各个项目对现金流量的影响，并根据其用途划分为经营、投资及融资三个活动分类。
                                            <?
                                        } else {
                                            ?>
                                            The customer is listed in the current transaction, the amount of the transaction and received payment and unpaid amount.
                                            <?
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3 col-xs-3">
                                    <a href="#">
                                        <img
                                            src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/tax3_report.jpg'; ?>"
                                            class="img-responsive img-thumbnail"/>
                                    </a>
                                </div>
                                <div class="col-md-9">
                                    <h4 class="media-heading"><a
                                            href="#"><?= Yii::t('report', '个人所得税纳税申报表') ?></a>
                                    </h4>
                                    <p>
                                        <? if (Yii::app()->language == 'zh_cn') {
                                            ?>
                                            现金流量表的出现，主要是要反映出资产负债表中各个项目对现金流量的影响，并根据其用途划分为经营、投资及融资三个活动分类。
                                            <?
                                        } else {
                                            ?>
                                            The sub supplier lists the amount of the purchase transaction, the payment term and the unpaid amount.
                                            <?
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-3 col-xs-3">
                                    <a href="#">
                                        <img
                                            src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/tax4_report.jpg'; ?>"
                                            class="img-thumbnail"/>
                                    </a>
                                </div>
                                <div class="col-md-9">
                                    <h4 class="media-heading"><a
                                            href="#"><?= Yii::t('report', '企业所得税纳税申报表') ?></a>
                                    </h4>
                                    <p>
                                        <? if (Yii::app()->language == 'zh_cn') {
                                            ?>
                                            现金流量表的出现，主要是要反映出资产负债表中各个项目对现金流量的影响，并根据其用途划分为经营、投资及融资三个活动分类。
                                            <?
                                        } else {
                                            ?>
                                            The customer is listed in the current transaction, the amount of the transaction and received payment and unpaid amount.
                                            <?
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PORTLET-->
</div>