<?php
Yii::import('ext.select2.Select2');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/checkinput.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/subjects.js', CClientScript::POS_HEAD);
/* @var $this SubjectsController */
/* @var $model Subjects */
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#subjects-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-default voucher">
    <!-- Default panel contents -->
    <div class="panel-heading">科目表管理
        <div class="actions"><?

            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'',
            ));
            $this->widget('zii.widgets.CMenu', array(
                'items'=>array(
                    array('label' => '添加科目', 'url' => array('create'),),
                ),
                'htmlOptions'=>array('class'=>'operations', 'style'=>'list-style: none',),
            ));
            $this->endWidget();

            ?></div></div>
    <div class="panel-body v-title">
        <div class="row">
            <p>
                你可以通过比较符号 (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
                或者 <b>=</b>) 来进行搜索
            </p>

            <!-- search-form -->

            <?php

            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'subjects-grid',
                'dataProvider' => $dataProvider,
                'filter' => $model,
                'filterCssClass'=>'filter',
//                'filterSelector'=>'{filter}, #sbj_cat',
                'columns' => array(
                    'sbj_number',
                    'sbj_name',
//                    array(
//                        'name'=>'sbj_cat',
//                            'filter'=>Select2::dropDownList('Subjects[sbj_cat]',$model->sbj_cat,CHtml::listData(Subjects::model()->findall(), 'sbj_cat', 'sbj_cat')),
//                    ),
//                    array('name'=>'sbj_cat','header'=>'Active','filter'=>array('1'=>'a','2'=>'b'),'value'=>'$data->sbj_cat'),
//                    'sbj_table',
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update}',
                    ),
                ),
                'itemsCssClass' => 'table',
            ));
//            echo Select2::dropDownList('Subjects[sbj_cat]',$model->sbj_cat,array('1'=>'资产类','2'=>'负债类','3'=>'权益类','4'=>'收入类','5'=>'费用类',));
//            echo Select2::dropDownList('sbj_cat',$model->attribute,CHtml::listData(Subjects::model()->findall(), 'sbj_cat', 'sbj_cat'),'');
?>
        </div>
    </div>
</div>
