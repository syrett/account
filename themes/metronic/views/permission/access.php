<?php
/* @var $this PermissionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Permissions',
);

//$type = User2::checkVIP();
//
$isVip = $user_info->vip == 0 ? false : true;

    if ($isVip) {
        $cats = AuthCategory::model()->findAll();
    } else {
        $cats = AuthCategory::model()->findAllByAttributes(['type' => 0]);
    }

$list1 = [];
foreach ($cats as $cat) {
    if($isVip)
        $permissions = AuthPermission::model()->findAllByAttributes(['category' => $cat->name], ['order' => 'sort_num']);
    else
        $permissions = AuthPermission::model()->findAllByAttributes(['category' => $cat->name, 'type'=>0], ['order' => 'sort_num']);

    if(count($permissions) != 0){
        $list1[$cat->description] = [];
        foreach ($permissions as $item) {
            //var_dump($item);
            if (!$isVip && $item->id == 'Transition/listClosing') {
                $item->id = 'Transition/listSettlementcloseing';
            }
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
            <div class="row" style="margin-bottom: 1.2em;">
                <label class="col-md-2 control-label">
                    <span style="font-size: 1.2em; color: #ff8000;">被编辑用户：</span>
                </label>
                <div class="col-md-10">
                    <div class="">
                        <div style="margin-bottom: .2em;">用户名：&nbsp;<?= $user_info->username ?></div>
                        <div>邮&nbsp;&nbsp;&nbsp;箱：&nbsp;<?= $user_info->email ?></div>
                    </div>
                </div>
            </div>
            <?php if ($is_owner) { ?>
            <div class="row" style="margin-bottom: .8em;">
                <div class="col-md-2"></div>
                <div class="col-md-10"><div class="flash-error">不能修改账套所有者的权限！</div></div>
            </div>
            <?php } elseif ($is_self) { ?>
            <div class="row" style="margin-bottom: .8em;">
                <div class="col-md-2"></div>
                <div class="col-md-10"><div class="flash-error">不能编辑自身权限！</div></div>
            </div>
            <?php } ?>
            <div class="row">
                <label class="col-md-2 control-label">
                </label>

                <div class="col-md-10">
                    <div class="check-title">
                        <span class="help-block">
                            <label><input <?php if($is_owner || $is_self){echo 'disabled="disabled"';} ?> class="check-all" type="checkbox"
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
                                    <ul class="list-unstyled" style="clear: both;">
                                        <?
                                        foreach ($list as $item) {
                                        ?>
                                        <li style="float: left;">
                                            <label>

                                                <?php
                                                if ($is_owner || $is_self) {
                                                    echo $form->checkBox($item, $item->id, array('disabled' => 'disabled', 'checked' => AuthRelation::checkRelation($user_id, $item['id']) ? true : $checkStatus));
                                                } else {
                                                    echo $form->checkBox($item, $item->id, array('checked' => AuthRelation::checkRelation($user_id, $item['id']) ? true : $checkStatus));
                                                }
                                                ?>
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
                        <input <?php if($is_owner || $is_self){echo 'disabled="disabled"';} ?> type="submit" class="btn btn-primary" value="<?= Yii::t('import', '保存') ?>"/>
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