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

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/bootstrap-datepicker.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/css/datepicker.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/_search.js', CClientScript::POS_HEAD);
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
</div>
    </div>
    <div class="row">
            <?php echo CHtml::beginForm(); ?>
        <div class="search-form" id="tran_search">
            <div class="col-md-4">
                <h5>
                    开始日期:<? echo CHtml::textField('s_day', isset($_REQUEST['s_day'])?$_REQUEST['s_day']:""); ?>
                </h5>
            </div>
            <div class="col-md-4">
                <h5>
                    结束日期:<? echo CHtml::textField('e_day', isset($_REQUEST['e_day'])?$_REQUEST['e_day']:""); ?>
                </h5>
            </div>
        </div>
        <?
            echo CHtml::submitButton('查找',array('class' => 'btn btn-primary',));
            echo CHtml::endForm();
        ?>
        <!-- search-form -->
    </div>
    <div class="panel-body v-title">

        <?php

        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'transition-grid',
            'dataProvider' => $model->search(),
            'rowCssClass'=>array('row-odd','row-even'),
            'filter' => $model,
            'rowCssClassExpression' =>'$data->getClass($row,$data->entry_reviewed,$data->entry_deleted)',
            'columns' => array(
                array(
                    'name'=>'entry_number',
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
                array('name'=>'entry_amount','htmlOptions'=>array('class'=>'amount')),
                array('name'=>'entry_appendix','value'=>'$data->getAppendix($data->entry_appendix_type,$data->entry_appendix_id)'),
                array('name'=>'entry_posting','value'=>'$data->getPosting($data->entry_posting)'),
                array('name'=>'entry_date','value'=>'date("Y年m月d日",strtotime($data->entry_date))'),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{update}',
                ),
            ),
            'htmlOptions' => array('class'=> 'table-striped')
        )); ?>
        <div class="clear">&nbsp;</div>
        <div class="clear">&nbsp;</div>
        <div class="clear">&nbsp;</div>
        <div class="clear">&nbsp;</div>
        <div class="div-group">
            <div class="div-reviewed"></div>审核通过
        </div>
        <div class="div-group">
            <div class="div-deleted"></div>删除凭证
        </div>
    </div>

</div>