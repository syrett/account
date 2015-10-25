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
    "month": "一月",
    "income": 23.5,
    "expenses": 21.1
  }, {
    "month": "二月",
    "income": 26.2,
    "expenses": 30.5
  }, {
    "month": "三月",
    "income": 30.1,
    "expenses": 28.9
  }, {
    "month": "四月",
    "income": 29.5,
    "expenses": 28.1
  }, {
    "month": "五月",
    "income": 30.6,
    "expenses": 28.2,
  }, {
    "month": "五月",
    "income": 30.6,
    "expenses": 28.2,
  }, {
    "month": "五月",
    "income": 30.6,
    "expenses": 28.2,
  }, {
    "month": "五月",
    "income": 30.6,
    "expenses": 28.2,
  }, {
    "month": "五月",
    "income": 30.6,
    "expenses": 28.2,
  }, {
    "month": "五月",
    "income": 30.6,
    "expenses": 28.2,
  }, {
    "month": "六月",
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
    "title": "收入",
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
    "title": "支出",
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
				<span class="caption-subject font-red-sunglo bold uppercase">经营收支报表</span>
				<span class="caption-helper">单位：百万元</span>
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
				<i class="fa fa-gift"></i>全部报表
			</div>
			<div class="tools">
				<a href="javascript:;" class="collapse" data-original-title="" title="折叠"></a>
				<a href="javascript:;" class="fullscreen" data-original-title="" title="全屏"></a>
			</div>
		</div>
		<div class="portlet-body">
			<div class="tabbable-line">
				<ul class="nav nav-tabs ">
					<li class="active">
						<a href="#tab_15_1" data-toggle="tab" aria-expanded="true">
						财务类 </a>
					</li>
					<li class="">
						<a href="#tab_15_2" data-toggle="tab" aria-expanded="false">
						行政类</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_15_1">
						<h3>财务报表</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/balance') ?>">
                                        <img src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/balance_report.jpg'; ?>" class="img-responsive img-thumbnail" />
                                    </a>
								</div>
								<div class="col-md-9">
									<h4 class="media-heading"><a href="<?= $this->createUrl('report/balance') ?>">资产负债表</a></h4>
									<p>利用会计平衡原则，将资产、负债、股东权益”交易科目分为“资产”和“负债及股东权益”两大区块，在经过分录、转帐、分类帐、试算、调整等等会计程序后，以特定日期的静态企业情况为基准，浓缩成一张报表。</p>
							 	</div>
							</div>
							<div class="col-md-6">
								<div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/profit') ?>">
                                        <img src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/profit_report.jpg'; ?>" class="img-thumbnail" />
                                    </a>
								</div>
								<div class="col-md-9">
									<h4 class="media-heading"><a href="<?= $this->createUrl('report/profit') ?>">损益表</a></h4>
									<p>反映企业在一定会计期的经营成果及其分配情况的会计报表，是一段时间内公司经营业绩的财务记录，反映了这段时间的销售收入、销售成本、经营费用及税收状况，报表结果为公司实现的利润或亏损。</p>
							 	</div>
							</div>
						</div>
                        <p>&nbsp;</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/subjects') ?>">
                                        <img src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/subjects_report.jpg'; ?>" class="img-thumbnail" />
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <h4 class="media-heading"><a href="<?= $this->createUrl('report/subjects') ?>">科目余额表</a></h4>
                                    <p>按照总账科目余额编制的。<br />资产类科目：期末借方余额=期初借方余额+本期借方发生额-本期贷方发生额；<br />负债及所有者权益类科目：期末贷方余额=期初贷方余额+本期贷方发生额-本期借方发生额。</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/detail') ?>">
                                        <img src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/detail_report.jpg'; ?>" class="img-thumbnail" />
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <h4 class="media-heading"><a href="<?= $this->createUrl('report/detail') ?>">明细表</a></h4>
                                    <p>损益表反映企业在一定会计期的经营成果及其分配情况的会计报表，是一段时间内公司经营业绩的财务记录，反映了这段时间的销售收入、销售成本、经营费用及税收状况，报表结果为公司实现的利润或亏损。</p>
                                </div>
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/money') ?>">
                                        <img src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/money_report.jpg'; ?>" class="img-thumbnail" />
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <h4 class="media-heading"><a href="<?= $this->createUrl('report/money') ?>">现金流量表</a></h4>
                                    <p></p>
                                </div>
                            </div>
                        </div>
					</div>
					<div class="tab-pane" id="tab_15_2">
						<h3>行政报表</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/vendor') ?>">
                                        <img src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/balance_report.jpg'; ?>" class="img-responsive img-thumbnail" />
                                    </a>
								</div>
								<div class="col-md-9">
									<h4 class="media-heading"><a href="<?= $this->createUrl('report/vendor') ?>">供应商表</a></h4>
									<p>&nbsp;</p>
							 	</div>
							</div>
							<div class="col-md-6">
								<div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/client') ?>">
                                        <img src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/profit_report.jpg'; ?>" class="img-thumbnail" />
                                    </a>
								</div>
								<div class="col-md-9">
									<h4 class="media-heading"><a href="<?= $this->createUrl('report/client') ?>">客户表</a></h4>
									<p>&nbsp;</p>
							 	</div>
							</div>
						</div>
						<p>&nbsp;</p>
						<div class="row">
							<div class="col-md-6">
								<div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/project') ?>">
                                        <img src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/subjects_report.jpg'; ?>" class="img-thumbnail" />
                                    </a>
								</div>
								<div class="col-md-8">
									<h4 class="media-heading"><a href="<?= $this->createUrl('report/project') ?>">项目表</a></h4>
									<p>&nbsp;</p>
							 	</div>
							</div>
							<div class="col-md-6">
								<div class="col-md-3 col-xs-3">
                                    <a href="<?= $this->createUrl('report/department') ?>">
                                        <img src="<?php echo Yii::app()->theme->baseUrl . '/assets/custom/detail_report.jpg'; ?>" class="img-thumbnail" />
                                    </a>
								</div>
								<div class="col-md-8">
									<h4 class="media-heading"><a href="<?= $this->createUrl('report/department') ?>">部门表</a></h4>
									<p>&nbsp;</p>
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