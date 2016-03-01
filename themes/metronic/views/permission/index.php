<?php
/* @var $this PermissionController */
/* @var $dataProvider CActiveDataProvider */

?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="font-green-sharp"><?= Yii::t('import', '权限设置') ?></span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel-body">
            <?
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'users-grid',
                'dataProvider' => $dataProvider,
                'itemsCssClass' => 'table table-striped table-hover',
                'columns' => array(
                    'id',
                    'username',
                    'email',
                    'profiles.name',
                    'profiles.phone',

                    array(
                        'class' => 'CButtonColumn',
                        'buttons' => array(
                            'access' => array(
                                'options' => array('class' => 'btn btn-default tip btn-xs', 'title' => Yii::t('import', '配置权限')),
                                'label' => '<span class="glyphicon glyphicon-pencil"></span>',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("Permission/access", ["id"=>$data->id])'
                            ),
                        ),
                        'template' => '<div class="btn-group">{access}</div>',
                        'deleteConfirmation' => Yii::t('import', '确定要删除该条记录？'),
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>