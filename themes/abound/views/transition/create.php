<div class="panel panel-default voucher form">

    <!-- Default panel contents -->
    <div class="panel-heading">凭证录入
        <div class="actions">

            <?
            /* @var $this TransitionController */
            /* @var $model Transition */
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'',
            ));
            $this->widget('zii.widgets.CMenu', array(
                'items'=>array(
                    array('label' => '凭证管理', 'url' => array('admin'),),
                ),
                'htmlOptions'=>array('class'=>'operations', 'style'=>'list-style: none',),
            ));
            $this->endWidget();
            ?>
</div>
        </div>
    <div class="panel-body v-title">

        <?php $this->renderPartial('_form', array('model' => $model)); ?>

    </div>

</div>