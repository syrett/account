<?
echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> 商品采购', array('/transition/purchase'), array('class' => 'btn btn-default'));
echo "\n";
echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> 产品销售', array('/transition/sale'), array('class' => 'btn btn-default'));
echo "\n";
echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> 银行交易', array('/transition/bank'), array('class' => 'btn btn-default'));
echo "\n";
echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> 现金交易', array('/transition/cash'), array('class' => 'btn btn-default'));
echo "\n";
echo CHtml::link('<span class="glyphicon glyphicon-pencil"></span> 手动录入', array('/transition/create'), array('class' => 'btn btn-default'));
