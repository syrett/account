<?php
/* @var $this SiteController */
/* @var $operation string */


$this->pageTitle = Yii::app()->name;
?>

<div class="panel panel-default voucher form">

    <!-- Default panel contents -->
    <div class="panel-heading"><h2>
            <?php
            $title = '';
                switch($operation){
                    case 'listReview' : $title = '凭证审核';break;
                    case 'listTransition' : $title = '凭证查询';break;
                    case 'listPost' : $title = '凭证过账';break;
                    case 'listSettlement' : $title = '凭证结账';break;
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
        ?>
        <dl>
        <dt><?=$year?></dt>
        <?php
        foreach($months as $month){
            ?>
            <dd>
                <a href="<?= $this->createUrl('/Transition/'.$operation.'&date='.$year.$month) ?>">
                    <?=$month?>月
                </a>
            </dd>
        <?}?>
        </dl><?php } ?>
</div>