<?php
/* @var $this SiteController */
/* @var $operation string */


$this->pageTitle = Yii::app()->name;
?>

<div class="panel panel-default voucher form">

    <!-- Default panel contents -->
    <div class="panel-heading">&nbsp;</div>
    <div class="panel-body v-title">
    </div>
    <!-- search-form -->
        <?
            $list = $this->listMonth($operation);
        if(empty($list))
        {
            ?>

    <div class="unit-group">
        没有数据需要处理
        </div>
        <?}
        foreach($list as $year => $months){
            ?>
    <div class="unit-group">
        <div>
            <span class="unit-title"><?=$year?>
            </span>
        </div>
        <?

            foreach($months as $month){
        ?>
        <div class="unit-operate">
            <a href="<?= $this->createUrl('/Transition/'.$operation.'&date='.$year.$month) ?>">
                <?=$month?>月
            </a>
        </div>
        <?}?>
            </div><?}?>
</div>