<!-- 资产负债表 -->
<?php

//Yii::app()->clientScript->registerCoreScript('jquery');
Yii::import('ext.select2.Select2');
$cs = Yii::app()->clientScript;

$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/balance.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/excel_export.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/pages/scripts/components-pickers.js', CClientScript::POS_END);

$cs->registerScript('ComponentsPickersInit','ComponentsPickers.init();', CClientScript::POS_READY);
?>

<?php
function echoData($key, $data, $name="default")
{

  if($key==="empty"){
      echo "<th>".$name."</th>";
      echo "<td>&nbsp;</td>";
      echo "<td>&nbsp;</td>";
  }elseif(empty($data[$key])){
      echo "<th>".$name."</th>";
      echo "<td>0.00</td>";
      echo "<td>0.00</td>";
    }
  else
    {
      $arr=$data[$key];
      if($name ==="default")
        {
          echo "<th>".$arr["name"]."</th>";
        }
      else
        {
          echo "<th>".$name."</th>";
        }
      echo "<td>".number_format($arr["start"],2,".",",")." </td>";
      echo "<td>" .number_format($arr["end"],2,".",",")."</td>";
    }
}
?>
<div class="alert alert-info">
        <?php echo CHtml::beginForm('','post',array('class'=>'form-inline')); ?>
        <h3><?= Yii::t('report', '资产负债表') ?></h3>
        <div class="form-group">
            <label class="control-label" for="date"><?= Yii::t('report', '请选择报表日期') ?>:</label>
			<input type="text" data-date-format="yyyymmdd" name="date" class="form-control form-control-inline input-small date-picker" value="<?php echo isset($date)?$date:'' ?>" id="date" readonly="">
            <input type="submit" class="btn btn-primary" value="<?= Yii::t('report', '查看报表') ?>" />
        </div>
        <p>&nbsp;</p>
        <?php echo CHtml::endForm(); ?>
</div>
<div <?php if(!$data) echo 'style="display:none"'; ?> class="panel panel-default">
        <div class="panel-heading">
                <h2><?= Yii::t('report', '资 产 负 债 表') ?></h2>
        </div>
        <div class="panel-body">
                <p class="text-center"><span class="pull-left"><?= Yii::t('report', '日期') ?>: <?php echo date('Y-m-d',strtotime($date)); ?></span> <?= Yii::t('report', '编制单位') ?>: <?php echo $company ?> <span class="pull-right"><?= Yii::t('report', '金额单位：元') ?></span></p>
        </div>

        <table class="table table-bordered table-hover" id="balance">
                <thead>
                 <tr>
                 <th><?= Yii::t('report', '资产') ?></th>
                 <th class="text-right"><?= Yii::t('report', '年初数') ?></th>
                 <th class="text-right"><?= Yii::t('report', '期末数') ?></th>
                 <th><?= Yii::t('report', '负债及股东权益(所有者权益)') ?></th>
                 <th class="text-right"><?= Yii::t('report', '年初数') ?></th>
                 <th class="text-right"><?= Yii::t('report', '期末数') ?></th>
                 </tr>
                </thead>
                 <tr>
                 <?php echoData(0, $data, Yii::t('report', "流动资产")) ?>:
                 <?php echoData(0, $data,  Yii::t('report', "流动负债")) ?>:
                 </tr>
                 <tr>
                 <?php echoData(1, $data, Yii::t('report', "货币资金" )) ?>
                 <?php echoData(31, $data,  Yii::t('report', "短期借款")) ?>
                 </tr>
                 <tr>
                 <?php echoData(2, $data,  Yii::t('report', "交易性金融资产")) ?>
                 <?php echoData(32, $data,  Yii::t('report', "交易性金融负债")) ?>
                 </tr>
                 <tr>
                 <?php echoData(3, $data,  Yii::t('report', "应收票据")) ?>
                 <?php echoData(33, $data,  Yii::t('report', "应付票据")) ?>
                 </tr>
                 <tr>
                 <?php echoData(4, $data,  Yii::t('report', "应收账款")) ?>
                 <?php echoData(34, $data) ?>
                 </tr>
                 <tr>
                 <?php echoData(9, $data,  Yii::t('report', "减:坏账准备")) ?>
                 <?php echoData(35, $data) ?>
                 </tr>
                 <tr>
                 <?php echoData(5, $data,  Yii::t('report', "预付账款")) ?>
                 <?php echoData(36, $data ) ?>
                 </tr>
                 <tr>
                 <?php echoData(8, $data,  Yii::t('report', "其他应收款")) ?>
                 <?php echoData(37, $data) ?>
                 </tr>
                 <tr>
                 <?php echoData(11, $data,  Yii::t('report', "存货")) ?>
                 <?php echoData(39, $data) ?>
                 </tr>
                 <tr>
                 <?php echoData(12, $data,  Yii::t('report', "减:存货跌价准备")) ?>
                 <?php echoData(40, $data) ?>
                 </tr>
                 <tr>
                 <?php echoData(0, $data,  Yii::t('report', "一年内到期的非流动资产")) ?>
                 <?php echoData(0, $data,  Yii::t('report', "一年内到期的非流动负债 ")) ?>
                 </tr>
                 <tr>
                 <?php echoData(10, $data,  Yii::t('report', "其他流动资产")) ?>
                 <?php echoData(41, $data) ?>
                 </tr>
                 <tr>
                 <?php echoData("flow_property", $data,  Yii::t('report', "流动资产合计")) ?>
                 <?php echoData("flow_debt", $data,  Yii::t('report', "流动负债合计")) ?>
                 </tr>
                 <tr>
                 <?php echoData("empty", $data,  Yii::t('report', "非流动资产:")) ?>
                 <?php echoData("empty", $data,  "") ?>
                 </tr>
                 <tr>
                 <?php echoData(15, $data,  Yii::t('report', "可供出售金融资产")) ?>
                 <?php echoData(0, $data,  Yii::t('report', "非流动负债")) ?>:
                 </tr>
                 <tr>
                 <?php echoData(0, $data,  Yii::t('report', "减:可供出售金融资产减值准备")) ?>
                 <?php echoData(42, $data) ?>
                 </tr>
                 <tr>
                 <?php echoData(13, $data,  Yii::t('report', "持有至到期投资")) ?>
                 <?php echoData(43, $data) ?>
                 </tr>
                 <tr>
                 <?php echoData(14, $data,  Yii::t('report', "减:持有至到期投资减值准备")) ?>
                 <?php echoData(45, $data) ?>
                 </tr>
                 <tr>
                 <?php echoData(19, $data,  Yii::t('report', "长期应收款")) ?>
                 <?php echoData(46, $data) ?>
                 </tr>
                 <tr>
                 <?php echoData(16, $data,  Yii::t('report', "长期股权投资")) ?>
                 <?php echoData(47, $data) ?>
                 </tr>
                 <tr>
                 <?php echoData(17, $data,  Yii::t('report', "减:长期股权投资减值准备")) ?>
                 <?php echoData(48, $data) ?>
                 </tr>
                 <tr>
                 <?php echoData(18, $data,  Yii::t('report', "投资性房地产")) ?>
                 <?php echoData(44, $data) ?>
                 </tr>
                 <tr>
                 <?php echoData(0, $data, Yii::t('report', "减:投资性房地产减值准备")) ?>
                 <?php echoData("unflow_debt",$data, Yii::t('report', "非流动负债合计")) ?>
                 </tr>
                 <tr>
                 <?php echoData(21, $data, Yii::t('report', "固定资产")) ?>
                 <?php echoData("debt", $data, Yii::t('report', "负债合计")) ?>
                 </tr>
                 <tr>
                 <?php echoData(22, $data, Yii::t('report', "减:累计折旧")) ?>
                 <?php echoData(0, $data, Yii::t('report', "上级拨入")) ?>
                 </tr>
                 <tr>
                 <?php echoData(23, $data,  Yii::t('report', "减:固定资产减值准备")) ?>
                 <?php echoData(0, $data,  Yii::t('report', "股东权益(所有者权益)")) ?>:
                 </tr>
                 <tr>
                 <?php echoData(24, $data,  Yii::t('report', "在建工程")) ?>
                 <?php echoData(50, $data) ?>
                 </tr>
                 <tr>
                 <?php echoData(0, $data,  Yii::t('report', "固定资产清理")) ?>
                 <?php echoData(51, $data) ?>
                 </tr>
                 <tr>
                 <?php echoData(26,  $data, Yii::t('report', "无形资产")) ?>
                 <?php echoData(52, $data) ?>
                 </tr>
                 <tr>
                 <?php echoData(28, $data,  Yii::t('report', "商誉")) ?>
                 <?php echoData("undistributed_profit", $data, Yii::t('report', "未分配利润")) ?>
                 </tr>
                 <tr>
                 <?php echoData(29, $data,  Yii::t('report', "长期待摊费用")) ?>
                 <?php echoData("parent_owner", $data,  Yii::t('report', "归属于母公司股东权益(所有者权益)合计")) ?>
                 </tr>
                 <tr>
                 <?php echoData(30, $data,  Yii::t('report', "递延所得税资产")) ?>
                 <?php echoData(0, $data,  Yii::t('report', "少数股东权益")) ?>
                 </tr>
                 <tr>
                 <?php echoData(20, $data,  Yii::t('report', "其他非流动资产")) ?>
                 <?php echoData("empty", $data,  "") ?>
                 </tr>
                 <tr>
                 <?php echoData("unflow_property", $data,  Yii::t('report', "非流动资产合计")) ?>
                 <?php echoData("owner", $data,  Yii::t('report', "股东权益(所有者权益)合计")) ?>
                 </tr>
                 <tr>
                 <?php echoData(0, $data,  Yii::t('report', "拨付所属资金")) ?>
                 <?php echoData("empty", $data,  "") ?>
                 </tr>
                 <tr>
                 <?php echoData("property", $data,  Yii::t('report', "资产合计")) ?>
                 <?php echoData("debt_owner", $data,  Yii::t('report', "负债及股东权益(所有者权益)合计")) ?>
                 </tr>
        </table>
</div>
<div class="alert">
        <a id="dlink"  style="display:none;"></a>
        <?php
        echo CHtml::beginForm($this->createUrl('/Report/createexcel'), 'post');
        if ($date != ""){
                $d = date('Y-m',strtotime($date));
                $excel_name = Yii::t('report', "资产负债表")."-$d.xls";
                ?>
                <input type="hidden" name="data" id="data" value="" />
                <input type="hidden" name="name" id="name" value="<?=$excel_name?>" />
                <p class="text-right">
                <?php
                echo '<button type="button" onclick="tableToExcel()" class="btn btn-primary"><span class="glyphicon glyphicon-export"></span>'.Yii::t('import', '导出').'</button>';
        }
        echo CHtml::endForm();
        ?>
        </p>
</div>