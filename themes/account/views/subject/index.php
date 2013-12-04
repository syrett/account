<?php
/* @var $this SubjectController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = Yii::app()->name;
?>
<div class="panel panel-default voucher">
    <!-- Default panel contents -->
    <div class="panel-heading">科目管理</div>
    <div class="panel-body v-title">
        <div class="row">
            <?php
            $this->menu=array(
                array('label'=>'添加科目', 'url'=>array('create')),
                array('label'=>'管理科目', 'url'=>array('admin')),
            );
            ?>

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'subject-grid',
                'dataProvider'=>$dataProvider,
                'columns'=>array(
                    'id',
                    'no',
                    'name',
                    'category',
                    array(
                        'class'=>'CButtonColumn',
                    ),
                ),
            )); ?>

        </div>
    </div>

</div>