<?php
$this->pageTitle = Yii::app()->name . ' - 参数配置';
$this->breadcrumbs = array(
    '参数配置',
);
/* @var $this OptionsController */
/* @var $model Options */

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h2>参数配置</h2>
    </div>
    <div class="panel-body">
        <?php echo CHtml::beginForm(); ?>
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <div class="portlet green-meadow box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>折旧或摊销年限(年)：
                        </div>
                    </div>
                    <div class="portlet-body">
                            <?
                            $arr = ['1601', '1701', '1801'];

                            foreach ($arr as $item) {
                                $sbj = Subjects::model()->findByAttributes(['sbj_number' => $item]);
                                if ($sbj->has_sub == 1) {
                                    $lists = Subjects::model()->list_sub($item);
                                } else
                                    $lists = [$sbj->attributes];
                                foreach ($lists as $list) {
                                    $option = Options::model()->findByAttributes(['entry_subject' => $list['sbj_number']]);
                                    $value = $option == null ? 0 : $option->year;
                                    ?>
                                    <div class="form-group form-horizontal">

                                        <label class="col-md-6 control-label"><?= $list['sbj_name'] ?></label>

                                        <div class="input-group col-md-4">
                                            <input type="text" class="form-control"
                                                   name="Options[<?= $list['sbj_number'] ?>][year]"
                                                   value="<?= $value ?>">
                                        </div>
                                    </div>
                                <?

                                }
                            }
                            ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="portlet blue-hoki box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>残值率(%)：
                        </div>
                    </div>
                    <div class="portlet-body">
                            <?
                            $arr = ['1601'];

                            foreach ($arr as $item) {
                                $sbj = Subjects::model()->findByAttributes(['sbj_number' => $item]);
                                if ($sbj->has_sub == 1) {
                                    $lists = Subjects::model()->list_sub($item);
                                } else
                                    $lists = [$sbj->attributes];
                                foreach ($lists as $list) {
                                    $option = Options::model()->findByAttributes(['entry_subject' => $list['sbj_number']]);
                                    $value = $option == null ? 0 : $option->value;
                                    ?>
                                    <div class="form-group form-horizontal">
                                        <label class="col-md-6 control-label"><?= $list['sbj_name'] ?></label>
                                        <div class="input-group col-md-4">
                                            <input type="text" class="form-control"
                                                   name="Options[<?= $list['sbj_number'] ?>][value]"
                                                   value="<?= $value ?>">
                                        </div>
                                    </div>
                                <?

                                }
                            }
                            ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="portlet purple box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>附加税税率(%)：
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?
                        $arr = [];
                        //应交税费/城建税，教育费附加，地方教育费附加；其他应付款/河道管理费
                        $list = ['2221'=>'城建税,教育费附加,地方教育费附加','2241'=>'河道管理费'];
                        foreach($list as $key => $item){
                            $keys = explode(',', $item);
                            foreach($keys as $name){
                                $sbj = Subjects::matchSubject($name, $key);
                                if($sbj)
                                    $arr[] = $sbj;
                            }
                        }

                        foreach ($arr as $item) {
                            $sbj = Subjects::model()->findByAttributes(['sbj_number' => $item]);
                            if ($sbj->has_sub == 1) {
                                $lists = Subjects::model()->list_sub($item);
                            } else
                                $lists = [$sbj->attributes];
                            foreach ($lists as $list) {
                                $option = Options::model()->findByAttributes(['entry_subject' => $list['sbj_number']]);
                                $value = $option == null ? 0 : $option->value;
                                ?>
                                <div class="form-group form-horizontal">
                                    <label class="col-md-6 control-label"><?= $list['sbj_name'] ?></label>
                                    <div class="input-group col-md-4">
                                        <input type="text" class="form-control"
                                               name="Options[<?= $list['sbj_number'] ?>][value]"
                                               value="<?= $value ?>">
                                    </div>
                                </div>
                            <?

                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <?php
            echo CHtml::tag('button', array('encode' => false, 'class' => 'btn btn-primary',), '<span class="glyphicon glyphicon-floppy-disk"></span> 保存');
            ?>
        </div>
        <!-- search-form -->

        <?php echo CHtml::endForm(); ?>
    </div>
</div>

