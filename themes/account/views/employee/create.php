<div class="panel panel-default voucher">
    <!-- Default panel contents -->
    <div class="panel-heading">添加员工
        <div class="actions">
        <?
        $this->beginWidget('zii.widgets.CPortlet', array(
        'title'=>'',
        ));
        $this->widget('zii.widgets.CMenu', array(
        'items'=>array(
        array('label' => '员工管理', 'url' => array('admin'),),
        ),
        'htmlOptions'=>array('class'=>'operations', 'style'=>'list-style: none',),
        ));
        $this->endWidget();
        ?>
        </div>
    </div>
    <div class="panel-body v-title">
        <div class="row">
            <?php
            /* @var $this SubjectsController */
            /* @var $model Subjects */

            ?>

            <h4>&nbsp;</h4>

        <?php $this->renderPartial('_form', array('model' => $model,
                                                  'department_array' => $department_array)); ?>
        </div>
    </div>
</div>
