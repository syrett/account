<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
date_default_timezone_set('Asia/Shanghai');
$weekarray = array("日","一","二","三","四","五","六");  
$dayoftoday = "星期".$weekarray[date("w")]; 

$cs = Yii::app()->clientScript;

$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/amcharts/amcharts/amcharts.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/amcharts/amcharts/pie.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/amcharts/amcharts/themes/light.js', CClientScript::POS_END);

$js_str = 'var chart = AmCharts.makeChart( "chartdiv-homepage-3d-pie", {
  "type": "pie",
  "theme": "light",
  "dataProvider": [ {
    "category": "人员工资",
    "value": 17000
  }, {
    "category": "固定资产",
    "value": 800
  }, {
    "category": "原材料采购",
    "value": 3000
  }, {
    "category": "租金",
    "value": 5000
  }, {
    "category": "差旅费",
    "value": 2000
  } ],
  "valueField": "value",
  "titleField": "category",
  "startEffect": "elastic",
  "startDuration": 2,
  "labelRadius": 15,
  "innerRadius": "50%",
  "depth3D": 10,
  "balloonText": "[[title]]<br><span style=font-size:14px><b>[[value]]</b> ([[percents]]%)</span>",
  "angle": 15,
  "export": {
    "enabled": true
  }
} );
jQuery( ".chart-input" ).off().on( "input change", function() {
  var property = jQuery( this ).data( "property" );
  var target = chart;
  var value = Number( this.value );
  chart.startDuration = 0;

  if ( property == "innerRadius" ) {
    value += "%";
  }

  target[ property ] = value;
  chart.validateNow();
} );';

$cs->registerScript('ChartsFlotchartsInitPie',$js_str, CClientScript::POS_READY);

?>
<!-- BEGIN PAGE HEADER-->
<h3 class="page-title">
公司名称 <br /><small><?php echo $dayoftoday."，".date("Y年n月j日")?></small>
</h3>
<!-- END PAGE HEADER-->
<div class="clearfix">
</div>
<!-- BEGIN DASHBOARD STATS -->
<div class="row">
	<div class="col-md-12">
	<div class="portlet light">
		<div class="portlet-title">
			<div class="caption">
			<span class="caption-subject font-green-sharp bold uppercase">营业收入</span>
			</div>
			<div class="actions">统计周期：过去365天</div>
		</div>
		<div class="portlet-body">
			<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<a class="dashboard-stat dashboard-stat-light blue-soft" href="javascript:;">
				<div class="visual">
					<i class="fa fa-money fa-icon-medium"></i>
				</div>
				<div class="details">
					<div class="number">
						 549.30
					</div>
					<div class="desc">
						 现金
					</div>
				</div>
				</a>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<a class="dashboard-stat dashboard-stat-light red-soft" href="javascript:;">
				<div class="visual">
					<i class="fa fa-bank fa-icon-medium"></i>
				</div>
				<div class="details">
					<div class="number">
						 150,603.04
					</div>
					<div class="desc">
						 银行存款
					</div>
				</div>
				</a>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<a class="dashboard-stat dashboard-stat-light green-soft" href="javascript:;">
				<div class="visual">
					<i class="fa fa-hand-o-right fa-icon-medium"></i>
				</div>
				<div class="details">
					<div class="number">
						 13,490.00
					</div>
					<div class="desc">
						 应收账款
					</div>
				</div>
				</a>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
	<div class="portlet light">
		<div class="portlet-title">
			<div class="caption">
			<span class="caption-subject font-green-sharp bold uppercase">运营支出</span>
			</div>
			<div class="actions">
				<div class="btn-group">
					<a class="btn btn-sm green dropdown-toggle" href="javascript:;" data-toggle="dropdown" aria-expanded="false"><span class="md-click-circle md-click-animate" style="height: 95px; width: 95px; top: -38.5px; left: 23px;"></span>
										本月 <i class="fa fa-angle-down"></i>
										</a>
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="javascript:;">
							过去30天</a>
						</li>
						<li>
							<a href="javascript:;">
							本月</a>
						</li>
						<li>
							<a href="javascript:;">
							本季度</a>
						</li>
						<li>
							<a href="javascript:;">
							今年</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="javascript:;">
							上月</a>
						</li>
						<li>
							<a href="javascript:;">
							上季度</a>
						</li>
						<li>
							<a href="javascript:;">
							去年</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="portlet-body">
			<div class="col-md-3">
				<h1>27,800.00</h1>本月
			</div>
			<div class="col-md-9">
				<div id="chartdiv-homepage-3d-pie">
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	</div>
</div>

<!-- END DASHBOARD STATS -->
<div class="clearfix">
</div>
