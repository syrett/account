<?php
/* @var $this TransitionController */
/* @var $model Transition */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#transition-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-default voucher form">

    <!-- Default panel contents -->
    <div class="panel-heading">凭证管理
        <div class="actions"><?

            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'',
            ));
            $this->widget('zii.widgets.CMenu', array(
                'items'=>array(
                    array('label' => '凭证录入', 'url' => array('create')),
                ),
                'htmlOptions'=>array('class'=>'operations', 'style'=>'list-style: none',),
            ));
            $this->endWidget();

            ?>
</div>        </div>
    <div class="panel-body v-title">
        <div class="search-form" style="display:none">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <!-- search-form -->

        <?php

        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'transition-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                array(
                    'name'=>'entry_number',
                    'type'=>'raw',
                    'value'=>'$data->entry_num_prefix. $data->addZero($data->entry_num)'),
                array('name'=>'entry_memo','type'=>'shortText'),
                array(
                    'name'=>'entry_transaction',
                    'type'=>'shortText',
                    'value'=>'$data->transaction($data->entry_transaction)',
                    'htmlOptions'=>array('style'=>'width:30px','width'=>'30px'),
                    'headerHtmlOptions'=>array('width'=>'30px'),
                ),
                array('name'=>'entry_subject','value'=>'$data->getSbjName($data->entry_subject)'),
                'entry_amount',
                array('name'=>'entry_appendix','type'=>'shortText'),
                array('name'=>'entry_date',
                    'value'=>'date("y年m月d日",$data->entry_date)'),
                /*
                'entry_subject',
                'entry_amount',
                'entry_appendix',
                'entry_editor',
                'entry_reviewer',
                'entry_deleted',
                'entry_reviewed',
                'entry_posting',
                'entry_closing',
                */
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{update}',
                ),
            ),
        )); ?>

    </div>

</div>