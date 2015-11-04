<?php
/* @var $this SiteController */
/* @var $operation string */
Yii::import('ext.select2.ESelect2');

$this->pageTitle = Yii::app()->name;
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
		<span class="font-green-sharp">
            <?php
            $title = '';
            switch ($operation) {
                case 'listReview' :
                    $title = '审核凭证';
                    break;
                case 'listTransition' :
                    $title = '查询凭证';
                    break;
                case 'listPost' :
                    $title = '凭证过账';
                    break;
                case 'listSettlement' :
                    $title = '期末结账';
                    break;
                case 'listAntiSettlement' :
                    $title = '反结账';
                    break;
                case 'listReorganise' :
                    $title = '整理凭证';
                    break;
                case 'listAssets' :
                    $title = '固定资产';
                    break;
            }
            echo $title;
            ?>		
		</span>
        </div>
    </div>
    <div class="portlet-body">
        <!-- search-form -->
        <?php
        $status = $this->getTransitionDate('end');
        echo "已结账至日期：" . $status['date'];
        $list = $this->listMonth($operation);

        if (empty($list) && $operation != 'listAssets') {
            ?>

            <div class="unit-group">
                没有数据需要处理
            </div>
            <?php
        } elseif ($operation != 'listAssets')
            foreach ($list as $year => $months) {

                echo CHtml::beginForm($this->createUrl('/Transition/' . $operation), 'post');
                ?>
                <?= $year ?>年
                <?php
                $data = array();
                foreach ($months as $month) {
                    $data[$year . $month] = $month;
                }
                $this->widget('ESelect2', array(
                    'name' => 'date',
                    'data' => $data,
                    'htmlOptions' => array('class' => 'action')
                ));
                ?>
                <input type="submit" class="btn btn-primary" value="<?= $title ?>"/>
                <?php

                echo CHtml::endForm();
            }

        if ($operation == 'listAssets') {
            $where = "(entry_subject like '1601%' or entry_subject like '1701%' or entry_subject like '1801%')";
            $stocks = Stock::model()->findByAttributes([], $where);
            $dataProvider = new CActiveDataProvider('Stock', ['criteria' => ['condition' => $where]]);
            if ($stocks != null) {
                $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'assets-grid',
                        'dataProvider' => $dataProvider,
                        'itemsCssClass' => 'table table-striped table-hover',
                        'columns' => array(
                            'id',
                            'hs_no',
                            'in_date',
                            [
                                'name' => 'entry_subject',
                                'value' => 'Subjects::getSbjPath($data->entry_subject)'
                            ],
                            'name',
                            'in_price',
                            'value_month',
                            'value_rate',
                            [
                                'header' => '折旧',
                                'value' => '$data->in_price - $data->getWorth()'
                            ],
                            [
                                'header' => '净值',
                                'value' => '$data->getWorth()'
                            ],
                            [
                                'header' => '部门',
                                'value' => 'Department::model()->getNameByOrderNo($data->order_no,$data->department_id)'
                            ],
                            [
                                'class' => 'CButtonColumn',
                                'buttons' => array(
                                    'scrap' => array(
                                        'options' => array(
                                            'class' => 'btn btn-default tip btn-xs',
                                            'title' => '操作',
                                            'confirm' => '确定要执行此操作？',
                                            'ajax' => [
                                                'dataType' => 'json',
                                                'url' => 'js:$(this).attr("href")',
                                                'success' => 'js:function(data) {
                                                        alert(data.msg);
                                                $.fn.yiiGridView.update("assets-grid")}'
                                            ]
                                        ),
                                        'label' => "<span class='glyphicon glyphicon-ban-circle'></span>",
                                        'imageUrl' => false,
                                        'url' => 'Yii::app()->createUrl("/Stock/scrap", ["id"=>$data->id,"action"=>$data->status==4?"unscrap":"scrap"])'
                                    ),
//                                    'unscrap' => array(
//                                        'options' => array(
//                                            'class' => 'btn btn-default tip btn-xs',
//                                            'title' => '编辑',
//                                            'confirm' => '确定要报废？',
//                                            'ajax' => [
//                                                'dataType' => 'json',
//                                                'url' => 'js:$(this).attr("href")',
//                                                'success' => 'js:function(data) {
//                                                    if(data.status=="success")
//                                                        alert("取消报废成功")
//                                                    else
//                                                        alert(data.msg);
//                                                $.fn.yiiGridView.update("assets-grid")}'
//                                            ]
//                                        ),
//                                        'label' => "<span class='glyphicon glyphicon-ok-circle'></span>",
//                                        'imageUrl' => false,
//                                        'url' => 'Yii::app()->createUrl("/Stock/scrap", ["id"=>$data->id,"action"=>"unscrap"])'
//                                    ),
                                ),
                                'template' => '<div class="btn-group">{scrap}</div>',
                            ]

                        ))
                );
            }
        }

        ?>
    </div>
</div>