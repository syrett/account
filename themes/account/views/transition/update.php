<?php
/* @var $this TransitionController */
/* @var $model Transition */
?>
<div class="panel panel-default voucher form">

    <!-- Default panel contents -->
    <div class="panel-heading">凭证修改
        <div class="actions">
            <?
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title' => '',
            ));
            $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => '凭证管理', 'url' => array('admin'),),
                ),
                'htmlOptions' => array('class' => 'operations', 'style' => 'list-style: none',),
            ));
            $this->endWidget();
            ?>
        </div>
    </div>
    <div class="panel-body v-title">

        <?php
        if($model[0]->entry_settlement==1)
            $this->renderPartial('_form_settle', array('model' => $model, 'action' => 'update'));
        else
            $this->renderPartial('_form', array('model' => $model, 'action' => 'update'));
        ?>

    </div>

</div>