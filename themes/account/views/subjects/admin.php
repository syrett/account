<div class="panel panel-default voucher">
    <!-- Default panel contents -->
    <div class="panel-heading">科目表管理</div>
    <div class="panel-body v-title">
        <div class="row">
            <?php
            /* @var $this SubjectsController */
            /* @var $model Subjects */
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
            <p>
                你可以通过比较符号 (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
                或者 <b>=</b>) 来进行搜索
            </p>

            <!-- search-form -->

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'subjects-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'columns' => array(
                    'sbj_number',
                    'sbj_name',
                    'sbj_cat',
                    'sbj_table',
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update} {delete}',
                    ),
                ),
                'itemsCssClass' => 'table',
            )); ?>

        </div>
    </div>
</div>
