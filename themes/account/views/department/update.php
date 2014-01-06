<div class="panel panel-default voucher">
    <!-- Default panel contents -->
    <div class="panel-heading">
        <div class="actions-left">
        <?php
   echo CHtml::link('添加部门', array('create'))
        ?>

        </div>

        <div class="actions">
        <?php
   echo CHtml::link('部门管理', array('admin'))
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

            <?php $this->renderPartial('_form', array('model' => $model)); ?>
        </div>
    </div>
</div>
