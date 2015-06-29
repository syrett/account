<?php
/* @var $this StockController */
/* @var $model Stock */
$this->pageTitle=Yii::app()->name . ' - 库存商品管理';
$this->breadcrumbs=array(
    '库存商品管理',
);
?>
<div class="panel panel-success voucher form">
    <!-- Default panel contents -->
    <div class="panel-heading">
        <h2>库存商品管理</h2>
    </div>
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>