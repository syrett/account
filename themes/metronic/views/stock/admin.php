<?php
/* @var $this StockController */
/* @var $model Stock */

$this->pageTitle = Yii::app()->name . Yii::t('import',' - 库存商品查看');
$this->breadcrumbs = array(
    Yii::t('import', '库存商品查看'),
);
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="font-green-sharp"><?= Yii::t('import', '库存商品查看') ?></span>
        </div>
    </div>


    <div class="panel-body">
        <?php
        if($action=='')
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'stock-grid',
            'dataProvider' => $model->search2(),
            'itemsCssClass' => 'table table-striped table-hover',
            'columns' => array(
                array(
                    'name'=>'id',
                ),
                array(
                    'header'=>Yii::t('import', '名称'),
                    'name'=>'name',
                ),
                array(
                    'header'=>Yii::t('import', '年初余量'),
                    'name'=>'year_before',
                ),
                array(
                    'header'=>Yii::t('import', '本月采购量'),
                    'name'=>'month_in',
                ),
                array(
                    'header'=>Yii::t('import', '本月出库'),
                    'name'=>'month_out',
                ),
                array(
                    'header'=>Yii::t('import', '库存余量'),
                    'name'=>'left',
                ),
                array(
                    'header' => Yii::t('import', '查看'),
                    'class' => 'CButtonColumn',
                    'buttons' => array(
                        'update' => array(
                            'url' => 'Yii::app()->createUrl("/stock/view", ["id"=>$data["id"]])',
                            'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => Yii::t('import', '编辑')),
                            'label' => '<span class="glyphicon glyphicon-pencil"></span>',
                            'imageUrl' => false,
                        ),
                    ),
                    'template' => '<div class="btn-group">{update}</div>',
                ),
            ),
        ));
        elseif($action=='order')    //按订单显示
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'stock-grid',
                'dataProvider' => $model->search2(['action'=>$action]),
                'itemsCssClass' => 'table table-striped table-hover',
                'columns' => array(
                    array(
                        'name'=>'id',
                    ),
                    array(
                        'header'=>Yii::t('import', '订单号'),
                        'name'=>'order_no',
                    ),
                    array(
                        'header'=>Yii::t('import', '商品名'),
                        'name'=>'name',
                    ),
                    array(
                        'header'=>Yii::t('import', '商品总数'),
                        'name'=>'amount',
                    ),
                    array(
                        'header'=>Yii::t('import', '商品总价'),
                        'name'=>'summary',
                    ),
                    array(
                        'header'=>Yii::t('import', '已付'),
                        'value'=>''
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'buttons' => array(
                            'update' => array(
                                'url' => 'Yii::app()->createUrl("/stock/view", ["id"=>$data["id"],"action"=>"order"])',
                                'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => Yii::t('import', '编辑')),
                                'label' => '<span class="glyphicon glyphicon-pencil"></span>',
                                'imageUrl' => false,
                            ),
                        ),
                        'template' => '<div class="btn-group">{update}</div>',
                    ),
                ),
            ));
        ?>
    </div>
