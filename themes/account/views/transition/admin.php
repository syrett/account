<?php
/* @var $this TransitionController */
/* @var $model Transition */


$this->menu = array(
    array('label' => 'List Transition', 'url' => array('index')),
    array('label' => 'Create Transition', 'url' => array('create')),
);

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
    <div class="panel-heading">凭证管理</div>
    <div class="panel-body v-title">
        <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button'));?>
        <div class="search-form" style="display:none">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <!-- search-form -->

        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'transition-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                array(
                    'header'=>'凭证号',
                    'type'=>'raw',
                    'value'=>'$data->entry_num_prefix. $data->addZero($data->entry_num)'),
                'entry_memo',
                'entry_transaction',
                'entry_subject',
                'entry_amount',
                'entry_appendix',
                'entry_date',
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
                ),
            ),
        )); ?>


    </div>

</div>