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

                echo CHtml::beginForm($this->createUrl('/Transition/' . $operation), 'get');
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
        ?>
    </div>
</div>