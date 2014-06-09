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
<div class="print">
    <div>
        <h1>记账凭证</h1><h2><?php echo date('Y-m-d',strtotime($model[1]['entry_date'])); ?></h2></div>
    </div>
    <div>
        <h3 class="left">核算单位：</h3><h3 class="right">核算单位：</h3>
    </div>
    <div>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>摘要</th>
                <th>会计科目</th>
                <th>借方金额</th>
                <th>贷方金额</th>
            </tr>
            <?php
            foreach($model as $item){
                echo "<tr><td>$item[entry_memo]</td><td>$item[entry_appendix_id]<td>$item[entry_amount]</td><td></td></tr>";
            }
            ?>
            <tr>
                <td>x&&apos; ;x
                </td>
            </tr>
            </thead>
        </table>

    </div>
</div>