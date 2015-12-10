<?php
/* @var $this PermissionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Permissions',
);

$this->menu = array(
    array('label' => 'Create Permission', 'url' => array('create')),
    array('label' => 'Manage Permission', 'url' => array('admin')),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#subjects-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
$list1 = [
    '总账模块' => ['账套信息', '科目管理', '总账期初余额', '过账', '结账', '反结账'],
    '银行模块' => ['导入', '修改', '删除'],
    '现金模块' => ['导入', '修改', '删除'],
    '报表模块' => ['资产负债表', '损益表', '科目余额表', '明细表', '现金流量表', '行政表'],
    '采购模块' => ['导入', '修改', '删除'],
    '销售模块' => ['导入', '修改', '删除', '成本结转'],
    '凭证管理' => ['整理凭证', '打印凭证', '审核凭证', '取消审核'],
    '长期资产' => ['期初明细导入', '长期待摊管理', '在建工程管理', '无形资产管理'],
    '员工模块' => ['添加', '修改', '删除', '员工报销', '员工工资', '部门管理',],
    '权限设置' => ['修改权限']

]
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="font-green-sharp">权限设置</span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel-body">
            <form class="form-horizontal form-row-seperated">
                <?
                foreach ($list1 as $cat => $list) {

                    ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?= $cat ?>:
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
                                                    <label><input type="checkbox" name="product[categories][]"
                                                                  value="1">
                                                        <?= $item ?></label>
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
                <div class="form-group">
                    <label class="col-md-2 control-label">
                    </label>

                    <div class="col-md-10">
                        <div class="form-control height-auto">
                            <div class="slimScrollDiv"
                                 style="position: relative; overflow: hidden; width: auto; ">
                                <span class="help-block">
                                    <label><input id="check-all" type="checkbox" name="product[categories][]"
                                                  value="1">全选</label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#check-all').on('changed', function (event) {
        $('#check-all').iCheck('uncheck');
    });

    // Make "All" checked if all checkboxes are checked
    $('#check-all').on('ifChecked', function (event) {
        if ($('.check').filter(':checked').length == $('.check').length) {
            $('#check-all').iCheck('check');
        }
    });
</script>