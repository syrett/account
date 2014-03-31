<?php

Yii::import('ext.select2.Select2');
?>
<div>
    <?php echo CHtml::beginForm(); ?>
    <h5>日期:
        <?php
        if(isset($_REQUEST['year']))
        {
            $year = $_REQUEST['year'];
            $fm = $_REQUEST['fm'];
            $tm = $_REQUEST['tm'];
            if($fm > $tm)
            {
                $temp = $fm;
                $fm = $tm;
                $tm = $temp;
            }
            $subject_id = $_REQUEST['subject_id'];
        }
        else
        {
            $year = '';
            $fm = '';
            $tm = '';
            $subject_id = '';
        }

        $years = array(2013=>'2013',2014=>'2014');
        $months = array(1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12');
//        $subjects =

        $this->widget('Select2', array(
            'name' => 'year',
            'value' => $year,
            'data' => $years,
        ));
        ?>
        年</h5>
    <h5>
        <?php
        $this->widget('Select2', array(
            'name' => 'fm',
            'value' => $fm,
            'data' => $months,
        ));
        ?>
        月 至
        <?php
        $this->widget('Select2', array(
            'name' => 'tm',
            'value' => $tm,
            'data' => $months,
        ));
        ?>月
    </h5>
    <h5>
        选择科目
        <?php
        $this->widget('Select2', array(
            'name' => 'subject_id',
            'value' => $subject_id,
            'data' => Transition::model()->listSubjects(),
        ));
        ?>
    </h5>

    <input type="submit" value="查看报表" />
    <?php echo CHtml::endForm(); ?>
</div>