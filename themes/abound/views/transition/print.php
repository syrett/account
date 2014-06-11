<?php
/**
 * Created by PhpStorm.
 * User: -
 * Date: 06/06/14
 * Time: 00:26
 */
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/print.css');

?>
<style>
</style>
<div class="print">
    <div>
        <h1 class="h1" style="line-height: 0px;">记账凭证</h1>
        <HR class="hr" >
        <HR class="hr" >
        <h2 class="h2" style="line-height: 1px;"><?php echo date('Y年m月d日',strtotime($model[1]['entry_date'])); ?></h2>
    </div>
    <div>
        <table class="header" >
            <tr><td style="text-align: left">核算单位：[009]上海享合信息技术有限公司</td><td style="text-align: right">第0001号 - 0001/0001</td></tr>
        </table>
        <table class="table">
            <tr class="headerTH">
                <th>摘&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;要</th>
                <th>会&nbsp;&nbsp;&nbsp;计&nbsp;&nbsp;&nbsp;科&nbsp;&nbsp;&nbsp;目</th>
                <th>借&nbsp;方&nbsp;金&nbsp;额</th>
                <th>贷&nbsp;方&nbsp;金额&nbsp;</th>
            </tr>
            <?php
            $i == 0;
            foreach($model as $item){
                echo "<tr><td>$item[entry_memo]</td><td>$item[entry_subject]</td><td style='text-align: right;'></td><td style='text-align: right;'></td></tr>";
                if($i==4)
                    $str = "<tr><td></td><td></td><td style='text-align: right;'>";
                else
                    $str = "<tr class='rowBottom'><td></td><td></td><td style='text-align: right;'>";if($item[entry_transaction]=='1')
                $str .= number_format(floatval($item[entry_amount]),2);
                $str .= "</td><td style='text-align: right;'>";
                if($item[entry_transaction]=='2')
                    $str .= number_format(floatval($item[entry_amount]),2);
                $str .= "</td></tr>";
                echo $str;
                $i++;
            }
            while($i<=5){
                echo '<tr><td colspan="4">&nbsp;</td></tr>';
                $i++;
            }
            ?>
            <tr class="rowTop">
                <td>附单据数&nbsp;&nbsp;&nbsp;&nbsp;张</td><td>合计：柒柒</td><td style='text-align: right;'><?php echo number_format(1111,2); ?></td><td style='text-align: right;'><?php echo number_format(1111,2); ?></td>
            </tr>
        </table>

    </div>
</div>