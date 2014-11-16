<?php
/**
 * Created by PhpStorm.
 * User: -
 * Date: 06/06/14
 * Time: 00:26
 */

?>
<div class="print">
    <div>
        <h1 class="h1" style="line-height: 0px;">记账凭证</h1>
        <HR class="hr" >
        <HR class="hr" >
        <h2 class="h2" style="line-height: 1px;"><?php echo date('Y年m月d日',strtotime($model[0]['entry_date'])); ?></h2>
    </div>
    <div>
        <table class="title" >
            <tr>
                <td style="text-align: left">核算单位：<?php $Options = Options::model()->findAllByPk(1);
                    echo $Options[0]['name'];?></td>
                <td style="text-align: right">第<?php echo $this->addZero($model[0][entry_num]) ?>号 &#45;<?php echo '&nbsp;'.$this->addZero($page).'/'.$this->addZero($count); ?></td>
            </tr>
        </table>
        <table class="table">
            <tr class="headerTH">
                <th style="width: 41mm">摘&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;要</th>
                <th style="width: 69mm">会&nbsp;&nbsp;&nbsp;计&nbsp;&nbsp;&nbsp;科&nbsp;&nbsp;&nbsp;目</th>
                <th style="width: 33mm">借&nbsp;方&nbsp;金&nbsp;额</th>
                <th style="width: 33mm">贷&nbsp;方&nbsp;金&nbsp;额</th>
            </tr>
            <?php
            $i == 0;
            foreach($model as $item){
                echo "<tr class='rowNormal'><td>$item[entry_memo]</td><td>".Transition::model()->getSbjPath($item[entry_subject])."</td><td style='text-align: right;'></td><td style='text-align: right;'></td></tr>";
                if($i==4)
                    $str = "<tr class='row'><td></td><td></td><td style='text-align: right;'>";
                else
                    $str = "<tr class='rowBottom'><td></td><td></td><td style='text-align: right;'>";
                if($item[entry_transaction]=='1')
                {
                    $str .= number_format(floatval($item[entry_amount]),2);
                }
                $str .= "</td><td style='text-align: right;'>";
                if($item[entry_transaction]=='2')
                {
                    $str .= number_format(floatval($item[entry_amount]),2);
                }
                $str .= "</td></tr>";
                echo $str;
                $i++;
            }
            while($i<4){
                echo "<tr class='row'><td>&nbsp;</td><td></td><td></td><td></td></tr>
<tr class='rowBottom'><td>&nbsp;</td><td></td><td></td><td></td></tr>";
                $i++;
            }
            if($i == 4)
                echo "<tr class='row'><td>&nbsp;</td><td></td><td></td><td></td></tr>
<tr class='row5'><td>&nbsp;</td><td></td><td></td><td></td></tr>";
            ?>
            <tr class="rowTop">
                <td>附单据数&nbsp;&nbsp;&nbsp;&nbsp;张</td>
                <td>合计：<?php echo UpAmount($mount); ?></td>
                <td style='text-align: right;'><?php echo number_format($mount,2); ?></td>
                <td style='text-align: right;'><?php echo number_format($mount,2); ?></td>
            </tr>

        </table>
        <table  style="margin-bottom: 15px;" >
            <tr>
                <td width="52mm"  >记账：</td>
                <td width="52mm"  >审核：<?php
                    if($model[0]->entry_reviewed==1)
                    {
                        $user = User::model()->findByPk(array('id'=>$model[0]->entry_reviewer));
                        echo $user->email;
                    } ?></td>
                <td width="52mm"  >出纳：</td>
                <td  width="52mm" >制单：<?php echo User::model()->findByPk(array('id'=>$model[0]->entry_creater))->email; ?></td>
            </tr>
        </table>

        <div class="page_bottom"></div>
    </div>
</div>