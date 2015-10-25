<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
date_default_timezone_set('Asia/Shanghai');
$weekarray = array("日", "一", "二", "三", "四", "五", "六");
$dayoftoday = "星期" . $weekarray[date("w")];

$cs = Yii::app()->clientScript;

$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/amcharts/amcharts/amcharts.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/amcharts/amcharts/pie.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/amcharts/amcharts/themes/light.js', CClientScript::POS_END);

$bank_amount = Subjects::get_balance('1002');
$cash_amount = Subjects::get_balance('1001');
$should_amount = Subjects::get_balance('1122');
$amount_1 = 0;
$amount_2 = 0;
$amount_3 = 0;

$bank = Transition::model()->findAllByAttributes([], 'entry_subject like "1002%"');
foreach ($bank as $item) {
    $bank_amount = $item['entry_transaction']==1?$bank_amount+$item['entry_amount']:$bank_amount-$item['entry_amount'];
}
$cash = Transition::model()->findAllByAttributes([], 'entry_subject like "1001%"');
foreach ($cash as $item) {
    $cash_amount = $item['entry_transaction']==1?$cash_amount+$item['entry_amount']:$cash_amount-$item['entry_amount'];
}
$amount_should = Transition::model()->findAllByAttributes([], "entry_subject like '1122%'");
foreach($amount_should as $item){
    $should_amount = $item['entry_transaction']==1?$should_amount+$item['entry_amount']:$should_amount-$item['entry_amount'];
}
$amount_0 = $should_amount;
$amount_out = Transition::model()->findAllByAttributes(['entry_transaction'=>2], "entry_subject like '1001%' or entry_subject like '1002%'");
foreach ($amount_out as $item) {
    $amount_3 += $item['entry_amount'];
}
//饼图
$data = [];
//银行
$bank_out = Bank::model()->findAllByAttributes([], "path like '%>支出=%'");
foreach ($bank_out as $item) {
    $path = explode('=>', $item['path']);
    if(count($path)>1){
        if($path[2] == '供应商采购'){
            if(end($path)!='预付款'){
                $purchase = Purchase::model()->findByAttributes(['order_no'=>end($path)]);
                if($purchase){
                    switch(substr($purchase['subject'],0,4)){
                        case 1601:
                            $data['固定资产'] = isset($data['固定资产'])?$data['固定资产']+$item['amount']:$item['amount'];
                            break;
                        case 1701:
                            $data['无形资产'] = isset($data['无形资产'])?$data['无形资产']+$item['amount']:$item['amount'];
                            break;
                        case 1801:
                            $data['长期待摊'] = isset($data['长期待摊'])?$data['长期待摊']+$item['amount']:$item['amount'];
                            break;
                        case 1403:
                        case 1405:
                            $data['存货采购'] = isset($data['存货采购'])?$data['存货采购']+$item['amount']:$item['amount'];
                            break;
                        default :
                            $data['其他采购'] = isset($data['其他采购'])?$data['其他采购']+$item['amount']:$item['amount'];
                    }
                }
            }else{
                $preorder = Preparation::model()->findByAttributes(['type'=>'bank', 'pid'=>$item->id]);
                if(isset($preorder['real_order'])){
                    $real_order = json_decode($preorder['real_order'], true);
                    if($real_order)
                        foreach ($real_order as $order => $amount) {
                            $purchase = Purchase::model()->findByAttributes(['order_no'=>$order]);
                            if($purchase){
                                switch(substr($purchase['subject'],0,4)){
                                    case 1601:
                                        $data['固定资产'] = isset($data['固定资产'])?$data['固定资产']+$amount:$amount;
                                        break;
                                    case 1701:
                                        $data['无形资产'] = isset($data['无形资产'])?$data['无形资产']+$amount:$amount;
                                        break;
                                    case 1801:
                                        $data['长期待摊'] = isset($data['长期待摊'])?$data['长期待摊']+$amount:$amount;
                                        break;
                                    case 1403:
                                    case 1405:
                                        $data['存货采购'] = isset($data['存货采购'])?$data['存货采购']+$amount:$amount;
                                        break;
                                    default :
                                        $data['其他采购'] = isset($data['其他采购'])?$data['其他采购']+$amount:$amount;
                                }
                            }
                    }

                }
            }
        }else
            $data[$path[2]] = isset($data[$path[2]])?$data[$path[2]]+$item['amount']:$item['amount'];
    }
}
//现金
$cash_out = Cash::model()->findAllByAttributes([], "path like '%>支出=%'");
foreach ($cash_out as $item) {
    $path = explode('=>', $item['path']);
    if(count($path)>1){
        if($path[2] == '供应商采购'){
            if(end($path)!='预付款'){
                $purchase = Purchase::model()->findByAttributes(['order_no'=>end($path)]);
                if($purchase){
                    switch(substr($purchase['subject'],0,4)){
                        case 1601:
                            $data['固定资产'] = isset($data['固定资产'])?$data['固定资产']+$item['amount']:$item['amount'];
                            break;
                        case 1701:
                            $data['无形资产'] = isset($data['无形资产'])?$data['无形资产']+$item['amount']:$item['amount'];
                            break;
                        case 1801:
                            $data['长期待摊'] = isset($data['长期待摊'])?$data['长期待摊']+$item['amount']:$item['amount'];
                            break;
                        case 1403:
                        case 1405:
                            $data['存货采购'] = isset($data['存货采购'])?$data['存货采购']+$item['amount']:$item['amount'];
                            break;
                        default :
                            $data['其他采购'] = isset($data['其他采购'])?$data['其他采购']+$item['amount']:$item['amount'];
                    }
                }
            }else{
                $preorder = Preparation::model()->findByAttributes(['type'=>'cash', 'pid'=>$item->id]);
                if($preorder){
                    $real_order = json_decode($preorder['real_order'], true);
                    foreach ($real_order as $order => $amount) {
                        $purchase = Purchase::model()->findByAttributes(['order_no'=>$order]);
                        if($purchase){
                            switch(substr($purchase['subject'],0,4)){
                                case 1601:
                                    $data['固定资产'] = isset($data['固定资产'])?$data['固定资产']+$amount:$amount;
                                    break;
                                case 1701:
                                    $data['无形资产'] = isset($data['无形资产'])?$data['无形资产']+$amount:$amount;
                                    break;
                                case 1801:
                                    $data['长期待摊'] = isset($data['长期待摊'])?$data['长期待摊']+$amount:$amount;
                                    break;
                                case 1403:
                                case 1405:
                                    $data['存货采购'] = isset($data['存货采购'])?$data['存货采购']+$amount:$amount;
                                    break;
                                default :
                                    $data['其他采购'] = isset($data['其他采购'])?$data['其他采购']+$amount:$amount;
                            }
                        }
                    }

                }
            }
        }else
            $data[$path[2]] = isset($data[$path[2]])?$data[$path[2]]+$item['amount']:$item['amount'];
    }
}
$data_chart = [];
foreach($data as $cat => $value){
    $data_chart[] = ['category'=>$cat,'value'=>$value];
}
$data_str = json_encode($data_chart);
$js_str = 'var chart = AmCharts.makeChart( "chartdiv-homepage-3d-pie", {
  "type": "pie",
  "theme": "light",
  "dataProvider": '. $data_str. ',
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

$cs->registerScript('ChartsFlotchartsInitPie', $js_str, CClientScript::POS_READY);

?>
<!-- BEGIN PAGE HEADER-->
<h3 class="page-title">
    <?= Condom::model()->getName() ?> <br/>
    <small><?php echo $dayoftoday . "，" . date("Y年n月j日") ?></small>
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
                    <span class="caption-subject font-green-sharp bold uppercase">流动资产</span>
                </div>
                <div class="actions"></div>
            </div>
            <div class="portlet-body">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-light blue-soft" href="javascript:;">
                        <div class="visual">
                            <i class="fa fa-money fa-icon-medium"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <?= round2($cash_amount) ?>
                            </div>
                            <div class="desc">
                                库存现金
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
                                <?= round2($bank_amount) ?>
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
                                <?= round2($amount_0>0?$amount_0:0) ?>
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
<!--                        <a class="btn btn-sm green dropdown-toggle" href="javascript:;" data-toggle="dropdown"-->
<!--                           aria-expanded="false"><span class="md-click-circle md-click-animate"-->
<!--                                                       style="height: 95px; width: 95px; top: -38.5px; left: 23px;"></span>-->
<!--                            本月 <i class="fa fa-angle-down"></i>-->
<!--                        </a>-->
<!--                        <ul class="dropdown-menu pull-right">-->
<!--                            <li>-->
<!--                                <a href="javascript:;">-->
<!--                                    过去30天</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a href="javascript:;">-->
<!--                                    本月</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a href="javascript:;">-->
<!--                                    本季度</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a href="javascript:;">-->
<!--                                    今年</a>-->
<!--                            </li>-->
<!--                            <li class="divider"></li>-->
<!--                            <li>-->
<!--                                <a href="javascript:;">-->
<!--                                    上月</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a href="javascript:;">-->
<!--                                    上季度</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a href="javascript:;">-->
<!--                                    去年</a>-->
<!--                            </li>-->
<!--                        </ul>-->
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="col-md-3">
                    <h1><?= $amount_3 ?></h1>
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
