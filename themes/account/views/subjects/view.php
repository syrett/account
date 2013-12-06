<div class="panel panel-default voucher">
    <!-- Default panel contents -->
    <div class="panel-heading">科目编号 #<?php echo $model->sbj_number; ?></div>
    <div class="panel-body v-title">
        <div class="row">
            <?php
            /* @var $this SubjectsController */
            /* @var $model Subjects */

            $this->beginWidget('zii.widgets.CPortlet', array(
                'title' => '',
            ));
            $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => '科目管理', 'url' => array('admin')),
                    array('label' => '添加科目', 'url' => array('create')),
                    array('label' => '修改科目', 'url' => array('update', 'id'=>$model->id)),
                    array('label' => '删除科目', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => '确定删除科目?')),
                ),
                'htmlOptions' => array('class' => 'operations', 'style' => 'list-style: none',),
            ));
            $this->endWidget();
            ?>
            <?php $this->widget('zii.widgets.CDetailView', array(
                'data' => $model,
                'attributes' => array(
                    '科目编号'=>'sbj_number',
                    '科目名称'=>'sbj_name',
                    '科目分类'=>'sbj_cat',
                    '科目报表'=>'sub_table',
                ),
            )); ?>
