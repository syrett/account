<?php
/* @var $this SiteController */
/* @var $operation string */
Yii::import('ext.select2.Select2');

$this->pageTitle = Yii::app()->name;
?>

<div class="panel panel-default voucher form">

    <!-- Default panel contents -->
    <div class="panel-heading"><h2>
            <?php
            $title = '';
                switch($operation){
                    case 'listReview' : $title = '审核凭证';break;
                    case 'listTransition' : $title = '查询凭证';break;
                    case 'listPost' : $title = '凭证过账';break;
                    case 'listSettlement' : $title = '期末结账';break;
                    case 'listAntiSettlement' : $title = '反结账';break;
                    case 'listReorganise' : $title = '整理凭证';break;
                }
            echo $title;
            ?>
    </h2></div>
    <div class="panel-body v-title">
    <!-- search-form -->
    <?php
    $list = $this->listMonth($operation);

    if(empty($list))
    {
        ?>

        <div class="unit-group">
            没有数据需要处理
        </div>
    <?php }
    foreach($list as $year => $months){

        echo CHtml::beginForm($this->createUrl('/Transition/'.$operation), 'post');
        ?>
		<?=$year?>年
        <?php
        $data =  array();
        foreach($months as $month){
            $data[$year.$month] = $month;
        }
        $this->widget('Select2', array(
            'name' => 'date',
            'data' => $data,
            'htmlOptions' => array('class'=>'action')
        ));
        ?>
            <input type="submit" class="btn btn-primary" value="<?=$title?>" />
        <?php

        echo CHtml::endForm();
    }

    ?>
</div>