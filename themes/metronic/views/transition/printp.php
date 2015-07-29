<!-- 打印凭证 -->
<?php

Yii::import('ext.select2.ESelect2');
Yii::app()->clientScript->registerCoreScript('jquery');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/jquery-ui-1.10.4.custom.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/jquery-ui-1.10.4.custom.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/print.js', CClientScript::POS_HEAD);

?>
<style>
.ui-datepicker table{
    display: none;
}

.print_style {
    float: left;
    text-align: center;
    margin: 30px
}
</style>

<div class="panel panel-default">

    <!-- Default panel contents -->
    <div class="panel-heading"><h3>打印凭证</h3></div>
    <div class="panel-body">
    <!-- search-form -->
	<?php echo CHtml::beginForm($this->createUrl('transition/print'),'POST',array('class'=>'form-inline')); ?>
	<div class="form-group">
        <label class="control-label" for="date">请选择报表日期：</label>
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
            $fm = 1;
            $tm = 12;
            $subject_id = '';
        }

//        $years = array(2013=>'2013',2014=>'2014');
        $years = Transition::model()->hasTransitionYears();
        $months = array(1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12');

        $this->widget('ESelect2', array(
            'name' => 'year',
            'value' => $year,
            'data' => $years,
        ));
        ?>
        年
        <?php
        $this->widget('ESelect2', array(
            'name' => 'fm',
            'value' => $fm,
            'data' => $months,
            'htmlOptions' => array(
                'class' =>'monthSelect',
            )
        ));
        ?>
        月 至
        <?php
        $this->widget('ESelect2', array(
            'name' => 'tm',
            'value' => $tm,
            'data' => $months,
            'htmlOptions' => array(
                'class' =>'monthSelect',
            )
        ));
        ?>
        月
    </div>
    <div class="row row-fluid">
		<div class="col-md-index">
			<div class="thumbnail">
				<img src="<?php echo Yii::app()->theme->baseUrl.'/assets/admin/layout/img/in1.jpg' ?>" alt="横向" /><br />
				<input type="radio" name="style" value="1" checked="true" /> 横向
			</div>
		</div>
		<div class="col-md-index">
			<div class="thumbnail">
				<img src="<?php echo Yii::app()->theme->baseUrl.'/assets/admin/layout/img/in2.jpg' ?>" alt="纵向" /><br />
				<input type="radio" name="style" value="2" /> 纵向
			</div>
		</div>
	</div>
	<input type="submit" name="submit" class="btn btn-default" style="margin-left:25px;" value="打印凭证" />
	<input type="submit" name="submit" class="btn btn-default" style="margin-left:25px;" value="下载凭证" />
	<input type="button" style="display:none" id="preview" onclick="WebBrowser1.ExecWB(7,1)" />
	<?php echo CHtml::endForm(); ?>
	</div><!-- panel-body -->
</div><!-- panel -->