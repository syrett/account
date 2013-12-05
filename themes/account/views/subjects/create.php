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
                    array('label' => '管理科目', 'url' => array('admin'),),
                ),
                'htmlOptions'=>array('class'=>'operations', 'style'=>'list-style: none',),
            ));
            $this->endWidget();
            ?>

            <h1>Create Subjects</h1>

            <?php $this->renderPartial('_form', array('model' => $model)); ?>
        </div>
    </div>
</div>