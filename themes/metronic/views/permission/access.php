<?php
/* @var $this PermissionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Permissions',
);

$type = User2::checkVIP();
//if($type)
    $cats = AuthCategory::model()->findAll();

$list1 = [];
foreach ($cats as $cat) {
    if($type)
        $permissions = AuthPermission::model()->findAllByAttributes(['category' => $cat->name], ['order' => 'sort_num']);
    else
        $permissions = AuthPermission::model()->findAllByAttributes(['category' => $cat->name, 'form'=>0], ['order' => 'sort_num']);

    if(count($permissions) != 0){
        $list1[$cat->description] = [];
        foreach ($permissions as $item) {
            array_push($list1[$cat->description], $item);
        }

    }
}
//$checkStatus = false;
$checkStatus = AuthRelation::model()->findByAttributes(['user_id'=>$user_id])==null?true:false;
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="font-green-sharp"><?= Yii::t('import', '权限设置') ?></span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel-body">

            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'permission-form',
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => false,
                'htmlOptions' => ['class' => 'form-horizontal form-row-seperated']
            )); ?>
            <div class="row">
                <label class="col-md-2 control-label">
                </label>

                <div class="col-md-10">
                    <div class="check-title">
                        <span class="help-block">
                            <label><input class="check-all" type="checkbox"
                                          value="1"><?= Yii::t('import', '全选') ?></label>
                        </span>
                    </div>
                </div>
            </div>
            <?
            foreach ($list1 as $cat => $list) {

                ?>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?= Yii::t('models/permission', $cat) ?>:
                    </label>

                    <div class="col-md-10">
                        <div class="form-control height-auto">
                            <div class="slimScrollDiv"
                                 style="position: relative; overflow: hidden; width: auto; ">
                                <div class="scroller" style=" overflow: hidden; width: auto;"
                                     data-always-visible="1" data-initialized="1">
                                    <ul class="list-unstyled">
                                        <?
                                        foreach ($list as $item) {
                                            ?>
                                            <li>
                                                <label>
                                                    <?php echo $form->checkBox($item, $item->id, array('checked' => AuthRelation::checkRelation($user_id, $item['id'])?true:$checkStatus)); ?>
                                                    <?= Yii::t('models/permission', $item->name) ?></label>
                                            </li>
                                            <?
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
            <div class="row">
                <label class="col-md-2 control-label">
                </label>

                <div class="col-md-10">
                    <div class="form-control height-auto">
                        <input type="submit" class="btn btn-primary" value="<?= Yii::t('import', '保存') ?>"/>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<script>
    $('.check-all').on('click', function (event) {
        if ($(this).is(":checked"))
            $('input[type="checkbox"]:not(:checked)').click();
        else
            $('input[type="checkbox"]:checked').click();
    });
</script>