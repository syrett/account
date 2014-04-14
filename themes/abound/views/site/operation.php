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
        <?php
            $list = $this->listMonth($operation);
        $list = array(2014=>array(1=>'01',2=>'055'));
        var_dump($list);
        if(empty($list))
        {
            ?>

    <div class="unit-group">
        没有数据需要处理
        </div>
        <?php}
        else
        {
}>
</div>