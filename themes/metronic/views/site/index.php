<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
date_default_timezone_set('Asia/Shanghai');
$weekarray = array("日","一","二","三","四","五","六");  
$dayoftoday = "星期".$weekarray[date("w")]; 

$cs = Yii::app()->clientScript;
$cs->registerScript('ChartsFlotchartsInit','ChartsFlotcharts.init();', CClientScript::POS_READY);
$cs->registerScript('ChartsFlotchartsInitPie','ChartsFlotcharts.initPieCharts();', CClientScript::POS_READY);

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
				<div id="donut" class="chart" style="padding: 0px; position: relative;">
					<canvas class="flot-base" width="468" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 468px; height: 300px;"></canvas><canvas class="flot-overlay" width="468" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 468px; height: 300px;"></canvas>
					<div class="legend">
					<div style="position: absolute; width: 55px; height: 153px; top: 5px; right: 5px; opacity: 0.85; background-color: rgb(255, 255, 255);"> </div>
					</div>
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
