<?php
/* @var $this SiteController */
/* @var $operation string */
Yii::import('ext.select2.Select2');

$this->pageTitle = Yii::app()->name;

$date = Transition::model()->getCondomDate();
$date = substr($date,0,6);
$arr = Transition::model()->listDate();
?>

<div class="panel panel-default voucher form">

    <!-- Default panel contents -->
    <div class="panel-heading"><h2>
            结账情况
        </h2></div>
    <div class="panel-body v-title list-month">
        <?
        foreach ($arr as $year => $months) {
            echo "<ol><ul>$year</ul>";
            foreach ($months as $month) {
                $li = "<li>$month 月&nbsp;&nbsp;&nbsp;&nbsp;";
                if ($year . $month <= $date)
                    $li .= '已结账';
                else
                    $li .= '未结账';
                $li .= '</li>';
                echo $li;
            }
            echo '</ol>';
        }
        ?>

    </div>
