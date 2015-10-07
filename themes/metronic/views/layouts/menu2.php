<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2015/10/7
 * Time: 12:58
 */
?>

<div class="btn-group">
    <?
    echo CHtml::link('<i class="fa fa-bank"><i></i></i><div>导入银行交易</div>', array('transition/bank'), array('class' => 'icon-btn'));
    echo "\n";
    echo CHtml::link('<i class="fa fa-money"><i></i></i><div>导入现金交易</div>', array('transition/cash'), array('class' => 'icon-btn'));
    echo "\n";
    echo CHtml::link('<i class="fa fa-shopping-cart"><i></i></i><div>采购交易</div>', array('transition/purchase'), array('class' => 'icon-btn'));
    echo "\n";
    echo CHtml::link('<i class="fa fa-truck"><i></i></i><div>销售交易</div>', array('transition/sale'), array('class' => 'icon-btn'));
    echo "\n";
    echo CHtml::link('<i class="fa fa-edit"><i></i></i><div>手动录入</div>', array('create'), array('class' => 'icon-btn'));
    echo "\n";
    ?>
</div>