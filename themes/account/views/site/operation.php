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
    <div class="unit-group">
        <div>
            <span class="unit-title">
            </span>
        </div>
        <?
            $month = $this->listMonth($operation);
//        foreach($month as $item){
//            echo $item;
//        }
        ?>
        <div class="unit-operate">
            <a href="<?= $this->createUrl('/post/post&date='.date('Y').date('m')) ?>">
                3月
            </a>
        </div>
    </div>
</div>