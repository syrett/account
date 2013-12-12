<div class="panel panel-default voucher form">

    <!-- Default panel contents -->
    <div class="panel-heading">凭证录入</div>
    <div class="panel-body v-title">
        <?php
        /* @var $this TransitionController */
        /* @var $model Transition */


        $this->menu = array(
            array('label' => 'List Transition', 'url' => array('index')),
            array('label' => 'Manage Transition', 'url' => array('admin')),
        );
        ?>

        <?php $this->renderPartial('_form', array('model' => $model)); ?>

    </div>

</div>