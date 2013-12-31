<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>

<div class="panel panel-default voucher form">

    <!-- Default panel contents -->
    <div class="panel-heading">&nbsp;</div>
    <div class="panel-body v-title">
    </div>
<?
foreach(Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
}?>
    </div>