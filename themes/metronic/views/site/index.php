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
    $bank_amount = $item['entry_transaction'] == 1 ? $bank_amount + $item['entry_amount'] : $bank_amount - $item['entry_amount'];
}
$cash = Transition::model()->findAllByAttributes([], 'entry_subject like "1001%"');
foreach ($cash as $item) {
    $cash_amount = $item['entry_transaction'] == 1 ? $cash_amount + $item['entry_amount'] : $cash_amount - $item['entry_amount'];
}
$amount_should = Transition::model()->findAllByAttributes([], "entry_subject like '1122%'");
foreach ($amount_should as $item) {
    $should_amount = $item['entry_transaction'] == 1 ? $should_amount + $item['entry_amount'] : $should_amount - $item['entry_amount'];
}
$amount_0 = $should_amount;
$amount_out = Transition::model()->findAllByAttributes(['entry_transaction' => 2], "entry_subject like '1001%' or entry_subject like '1002%'");
foreach ($amount_out as $item) {
    $amount_3 += $item['entry_amount'];
}


//饼图
//运营支出
$data_out = [];
$pie_out_total = 0;
//运营收入
$data_in = [];
$pie_in_total = 0;
//管理费用
$data_manage = [];
$pie_manage_total = 0;


//--支出
//银行
$bank_out = Bank::model()->findAllByAttributes([], "path like '%>支出=%'");
foreach ($bank_out as $item) {
    $path = explode('=>', $item['path']);
    if (count($path) > 1) {
        if ($path[2] == '行政支出') {
            //管理费用
            $tmp_key = isset($path[3]) ? $path[3] : '';
            $data_manage[$tmp_key] = isset( $data_manage[$tmp_key]) ?  $data_manage[$tmp_key] + $item['amount'] : $item['amount'];
            $pie_manage_total += $item['amount'];
        }
        if ($path[2] == '供应商采购') {
            if (end($path) != '预付款') {
                $purchase = Purchase::model()->findByAttributes(['order_no' => end($path)]);
                if ($purchase) {
                    switch (substr($purchase['subject'], 0, 4)) {
                        case 1601:
                            $data_out[Yii::t('home', '固定资产')] = isset($data_out[Yii::t('home', '固定资产')]) ? $data_out[Yii::t('home', '固定资产')] + $item['amount'] : $item['amount'];
                            break;
                        case 1701:
                            $data_out[Yii::t('home', '无形资产')] = isset($data_out[Yii::t('home', '无形资产')]) ? $data_out[Yii::t('home', '无形资产')] + $item['amount'] : $item['amount'];
                            break;
                        case 1801:
                            $data_out[Yii::t('home', '长期待摊')] = isset($data_out[Yii::t('home', '长期待摊')]) ? $data_out[Yii::t('home', '长期待摊')] + $item['amount'] : $item['amount'];
                            break;
                        case 1403:
                        case 1405:
                            $data_out[Yii::t('home', '存货采购')] = isset($data_out[Yii::t('home', '存货采购')]) ? $data_out[Yii::t('home', '存货采购')] + $item['amount'] : $item['amount'];
                            break;
                        default :
                            $data_out[Yii::t('home', '其他采购')] = isset($data_out[Yii::t('home', '其他采购')]) ? $data_out[Yii::t('home', '其他采购')] + $item['amount'] : $item['amount'];
                    }
                }
            } else {
                $preorder = Preparation::model()->findByAttributes(['type' => 'bank', 'pid' => $item->id]);
                if (isset($preorder['real_order'])) {
                    $real_order = json_decode($preorder['real_order'], true);
                    if ($real_order)
                        foreach ($real_order as $order => $amount) {
                            $purchase = Purchase::model()->findByAttributes(['order_no' => $order]);
                            if ($purchase) {
                                switch (substr($purchase['subject'], 0, 4)) {
                                    case 1601:
                                        $data_out[Yii::t('home', '固定资产')] = isset($data_out[Yii::t('home', '固定资产')]) ? $data_out[Yii::t('home', '固定资产')] + $amount : $amount;
                                        break;
                                    case 1701:
                                        $data_out[Yii::t('home', '无形资产')] = isset($data_out[Yii::t('home', '无形资产')]) ? $data_out[Yii::t('home', '无形资产')] + $amount : $amount;
                                        break;
                                    case 1801:
                                        $data_out[Yii::t('home', '长期待摊')] = isset($data_out[Yii::t('home', '长期待摊')]) ? $data_out[Yii::t('home', '长期待摊')] + $amount : $amount;
                                        break;
                                    case 1403:
                                    case 1405:
                                        $data_out[Yii::t('home', '存货采购')] = isset($data_out[Yii::t('home', '存货采购')]) ? $data_out[Yii::t('home', '存货采购')] + $amount : $amount;
                                        break;
                                    default :
                                        $data_out[Yii::t('home', '其他采购')] = isset($data_out[Yii::t('home', '其他采购')]) ? $data_out[Yii::t('home', '其他采购')] + $amount : $amount;
                                }
                            }
                        }

                }
            }
        } else
            $data_out[Yii::t('home', $path[2])] = isset($data_out[Yii::t('home', $path[2])]) ? $data_out[Yii::t('home', $path[2])] + $item['amount'] : $item['amount'];

        $pie_out_total += $item['amount'];
    }
}
//现金
$cash_out = Cash::model()->findAllByAttributes([], "path like '%>支出=%'");
foreach ($cash_out as $item) {
    $path = explode('=>', $item['path']);
    if (count($path) > 1) {
        if ($path[2] == '行政支出') {
            //管理费用
            $tmp_key = isset($path[3]) ? $path[3] : '';
            $data_manage[$tmp_key] = isset( $data_manage[$tmp_key]) ?  $data_manage[$tmp_key] + $item['amount'] : $item['amount'];
            $pie_manage_total += $item['amount'];
        }
        if ($path[2] == '供应商采购') {
            if (end($path) != '预付款') {
                $purchase = Purchase::model()->findByAttributes(['order_no' => end($path)]);
                if ($purchase) {
                    switch (substr($purchase['subject'], 0, 4)) {
                        case 1601:
                            $data_out[Yii::t('home', '固定资产')] = isset($data_out[Yii::t('home', '固定资产')]) ? $data_out[Yii::t('home', '固定资产')] + $item['amount'] : $item['amount'];
                            break;
                        case 1701:
                            $data_out[Yii::t('home', '无形资产')] = isset($data_out[Yii::t('home', '无形资产')]) ? $data_out[Yii::t('home', '无形资产')] + $item['amount'] : $item['amount'];
                            break;
                        case 1801:
                            $data_out[Yii::t('home', '长期待摊')] = isset($data_out[Yii::t('home', '长期待摊')]) ? $data_out[Yii::t('home', '长期待摊')] + $item['amount'] : $item['amount'];
                            break;
                        case 1403:
                        case 1405:
                            $data_out[Yii::t('home', '存货采购')] = isset($data_out[Yii::t('home', '存货采购')]) ? $data_out[Yii::t('home', '存货采购')] + $item['amount'] : $item['amount'];
                            break;
                        default :
                            $data_out[Yii::t('home', '其他采购')] = isset($data_out[Yii::t('home', '其他采购')]) ? $data_out[Yii::t('home', '其他采购')] + $item['amount'] : $item['amount'];
                    }
                }
            } else {
                $preorder = Preparation::model()->findByAttributes(['type' => 'cash', 'pid' => $item->id]);
                if ($preorder) {
                    if ($preorder['real_order'] != '') {
                        $real_order = json_decode($preorder['real_order'], true);
                        foreach ($real_order as $order => $amount) {
                            $purchase = Purchase::model()->findByAttributes(['order_no' => $order]);
                            if ($purchase) {
                                switch (substr($purchase['subject'], 0, 4)) {
                                    case 1601:
                                        $data_out[Yii::t('home', '固定资产')] = isset($data_out[Yii::t('home', '固定资产')]) ? $data_out[Yii::t('home', '固定资产')] + $amount : $amount;
                                        break;
                                    case 1701:
                                        $data_out[Yii::t('home', '无形资产')] = isset($data_out[Yii::t('home', '无形资产')]) ? $data_out[Yii::t('home', '无形资产')] + $amount : $amount;
                                        break;
                                    case 1801:
                                        $data_out[Yii::t('home', '长期待摊')] = isset($data_out[Yii::t('home', '长期待摊')]) ? $data_out[Yii::t('home', '长期待摊')] + $amount : $amount;
                                        break;
                                    case 1403:
                                    case 1405:
                                        $data_out[Yii::t('home', '存货采购')] = isset($data_out[Yii::t('home', '存货采购')]) ? $data_out[Yii::t('home', '存货采购')] + $amount : $amount;
                                        break;
                                    default :
                                        $data_out[Yii::t('home', '其他采购')] = isset($data_out[Yii::t('home', '其他采购')]) ? $data_out[Yii::t('home', '其他采购')] + $amount : $amount;
                                }
                            }
                        }

                    }

                }
            }
        } else
            $data_out[Yii::t('home', $path[2])] = isset($data_out[Yii::t('home', $path[2])]) ? $data_out[Yii::t('home', $path[2])] + $item['amount'] : $item['amount'];

        $pie_out_total += $item['amount'];
    }
}

//--收入
//银行
$bank_in = Bank::model()->findAllByAttributes([], "path like '%>收入=%'");
foreach ($bank_in as $item) {
    $path = explode('=>', $item['path']);
    if (count($path) > 1) {
        $data_in[Yii::t('home', $path[2])] = isset($data_in[Yii::t('home', $path[2])]) ? $data_in[Yii::t('home', $path[2])] + $item['amount'] : $item['amount'];
        $pie_in_total += $item['amount'];
    }
}
//现金
$cash_in = Cash::model()->findAllByAttributes([], "path like '%>收入=%'");
foreach ($cash_in as $item) {
    $path = explode('=>', $item['path']);
    if (count($path) > 1) {
        $data_in[Yii::t('home', $path[2])] = isset($data_in[Yii::t('home', $path[2])]) ? $data_in[Yii::t('home', $path[2])] + $item['amount'] : $item['amount'];
        $pie_in_total += $item['amount'];
    }
}

//支出
$data_out_chart = [];
if (!empty($data_out))
    foreach ($data_out as $cat => $value) {
        $data_out_chart[] = ['category' => $cat, 'value' => $value];
    }
else
    $data_out_chart[] = ['category' => Yii::t('home', '无数据'), 'value' => '1'];
$data_out_str = json_encode($data_out_chart);

//收入
$data_in_chart = [];
if (!empty($data_in))
    foreach ($data_in as $cat => $value) {
        $data_in_chart[] = ['category' => $cat, 'value' => $value];
    }
else
    $data_in_chart[] = ['category' => Yii::t('home', '无数据'), 'value' => '1'];
$data_in_str = json_encode($data_in_chart);

//管理费用
$data_manage_chart = [];
if (!empty($data_manage))
    foreach ($data_manage as $cat => $value) {
        $data_manage_chart[] = ['category' => $cat, 'value' => $value];
    }
else
    $data_manage_chart[] = ['category' => Yii::t('home', '无数据'), 'value' => '1'];
$data_manage_str = json_encode($data_manage_chart);

$js_in_str = 'AmCharts.makeChart( "pie-in-div", {
  "type": "pie",
  "theme": "light",
  "dataProvider": ' . $data_in_str . ',
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
} );';

$js_out_str = ' AmCharts.makeChart( "pie-out-div", {
  "type": "pie",
  "theme": "light",
  "dataProvider": ' . $data_out_str . ',
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
} );';


$js_manage_str = ' AmCharts.makeChart( "pie-manage-div", {
  "type": "pie",
  "theme": "light",
  "dataProvider": ' . $data_manage_str . ',
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
} );';


/*
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
*/

$cs->registerScript('pieIn', $js_in_str, CClientScript::POS_READY);
$cs->registerScript('pieOut', $js_out_str, CClientScript::POS_READY);
$cs->registerScript('pieManage', $js_manage_str, CClientScript::POS_READY);


?>
<!-- BEGIN PAGE HEADER-->
<h3 class="page-title">
    <?= Condom::model()->getName() ?> <br/>
    <small><?= date("Y-m-d") ?></small>
</h3>
<!-- END PAGE HEADER-->
<div class="clearfix">
</div>
<!-- BEGIN DASHBOARD STATS -->

<?php if (isset($need_chg_tax) && $need_chg_tax) { ?>
<div class="row">
    <div class="col-md-12">
        <div class="flash-error">
            作为一般纳税人，科目表中不能存在3%税率，请修改！
        </div>
    </div>
</div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-green-sharp bold uppercase"><?= Yii::t('home', '流动资产') ?></span>
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
                                <?= Yii::t('home', '库存现金') ?>
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
                                <?= Yii::t('home', '银行存款') ?>
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
                                <?= round2($amount_0 > 0 ? $amount_0 : 0) ?>
                            </div>
                            <div class="desc">
                                <?= Yii::t('home', '应收账款') ?>
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
            <div class="portlet-body">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs ">
                        <li class="active" >
                            <a href="#tab_finan_sum" data-toggle="tab" aria-expanded="true" style="padding: 10px 25px;">
                                <?= Yii::t('report', '财务汇总') ?></a>
                        </li>
                        <li class="" >
                            <a href="#tab_info_cent" data-toggle="tab" aria-expanded="false" style="padding: 10px 25px;">
                                <?= Yii::t('report', '信息中心') ?></a>
                        </li>
                        <li class="">
                            <a href="#tab_tax_cent" data-toggle="tab" aria-expanded="false" style="padding: 10px 25px;">
                                <?= Yii::t('report', '税务中心') ?></a>
                        </li>
                        <li class="">
                            <a href="#tab_law_cent" data-toggle="tab" aria-expanded="false" style="padding: 10px 25px;">
                                <?= Yii::t('report', '法律法规') ?></a>
                        </li>
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane active" id="tab_finan_sum">

                            <div class="row pie-m-height">
                                <div class="pull-left pie-block">
                                    <div class="pie-block-header">
                                        <div><span class="caption-subject font-green-sharp bold uppercase"><?= Yii::t('home', '运营收入') ?></span></div>
                                        <div><?php  if($pie_in_total != 0) {echo $pie_in_total.'元';} ?></div>
                                    </div>
                                    <div class="pie-block-body">
                                        <div id="pie-in-div">
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
                                </div>
                                <div class="pull-left pie-block">
                                    <div class="pie-block-header">
                                        <div><span class="caption-subject font-green-sharp bold uppercase"><?= Yii::t('home', '运营支出') ?></span></div>
                                        <div><?php if($pie_out_total != 0) {echo $pie_out_total.'元';} ?></div>
                                    </div>
                                    <div class="pie-block-body">
                                        <div id="pie-out-div">
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
                                </div>
                                <div class="pull-left pie-block">
                                    <div class="pie-block-header">
                                        <div><span class="caption-subject font-green-sharp bold uppercase"><?= Yii::t('home', '管理费用') ?></span></div>
                                        <div><?php if($pie_manage_total != 0) {echo $pie_manage_total.'元';} ?></div>
                                    </div>
                                    <div class="pie-block-body">
                                        <div id="pie-manage-div">
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" id="tab_info_cent">

                            <?php
                            $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'logs-grid',
                            'emptyText' => Yii::t('transition', '暂无相关数据'),
                            'dataProvider' => $logs->search(),
                            'rowCssClass' => array('row-odd', 'row-even'),
                            'pager' => array(
                                'class' => 'CLinkPager',
                                'header' => '',
                                'firstPageLabel' => Yii::t('transition', '首页'),
                                'lastPageLabel' => Yii::t('transition', '末页'),
                                'nextPageLabel' => Yii::t('transition', '下一页'),
                                'prevPageLabel' => Yii::t('transition', '上一页')
                            ),
                            'itemsCssClass' => 'table table-striped dataTable table-hover no-footer',
                            'htmlOptions' => array('role' => 'grid'),
                            'columns' => array(
                                array('name'=>'created_at', 'value'=>'date("m月d日 H:i", $data->created_at)'),
                                array('name'=>'user_id', 'value'=>'isset($data->user_info->username) ? $data->user_info->username : ""'),
                                array('name'=>'message', 'value'=>'$data->message'),
                            ),
                            ));
                            ?>

                        </div>

                        <div class="tab-pane" id="tab_tax_cent">
                            <?php
                            $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'taxes-grid',
                            'emptyText' => Yii::t('transition', '暂无相关数据'),
                            'dataProvider' => $blog->search(1),
                            'rowCssClass' => array('row-odd', 'row-even'),

                            'pager' => array(
                                'class' => 'CLinkPager',
                                'header' => '',
                                'firstPageLabel' => Yii::t('transition', '首页'),
                                'lastPageLabel' => Yii::t('transition', '末页'),
                                'nextPageLabel' => Yii::t('transition', '下一页'),
                                'prevPageLabel' => Yii::t('transition', '上一页')
                            ),
                            'itemsCssClass' => 'table table-striped  dataTable table-hover no-footer',
                            'htmlOptions' => array('role' => 'grid'),
                            //'hideHeader' => true,
                            'columns' => array(
                                array('name'=>'title', 'value'=>'$data->title'),
                                array('name'=>'created_at', 'value'=>'date("Y/m/d", $data->created_at)'),

                                array(
                                    'class' => 'CLinkColumn',
                                    'label' => '浏览',
                                    'urlExpression'=>'Yii::app()->createUrl("site/blog",array("id"=>$data->id))',//显示URL
                                    //'htmlOptions' => array('style' => 'min-width: 68px;'),
                                ),
                            )

                            ));
                            ?>
                        </div>

                        <div class="tab-pane" id="tab_law_cent">
                            <?php
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'laws-grid',
                                'emptyText' => Yii::t('transition', '暂无相关数据'),
                                'dataProvider' => $blog->search(0),
                                'rowCssClass' => array('row-odd', 'row-even'),
                                'filter' => $blog,
                                'filterCssClass' => 'filter',
                                'pager' => array(
                                    'class' => 'CLinkPager',
                                    'header' => '',
                                    'firstPageLabel' => Yii::t('transition', '首页'),
                                    'lastPageLabel' => Yii::t('transition', '末页'),
                                    'nextPageLabel' => Yii::t('transition', '下一页'),
                                    'prevPageLabel' => Yii::t('transition', '上一页')
                                ),
                                'itemsCssClass' => 'table table-striped  dataTable table-hover no-footer',
                                'htmlOptions' => array('role' => 'grid'),
                                //'hideHeader' => true,
                                'columns' => array(
                                    array('name'=>'title', 'value'=>'$data->title'),
                                    array('name'=>'created_at', 'value'=>'date("Y/m/d", $data->created_at)', 'filter'=>''),

                                    array(
                                        'class' => 'CLinkColumn',
                                        'label' => '浏览',
                                        'urlExpression'=>'Yii::app()->createUrl("site/blog",array("id"=>$data->id))',//显示URL
                                        //'htmlOptions' => array('style' => 'min-width: 68px;'),
                                    ),
                                )

                            ));
                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">

    </div>
</div>

<!-- END DASHBOARD STATS -->
<div class="clearfix">
</div>
