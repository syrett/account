<?php
/* @var $this SalaryController */
/* @var $dataProvider CActiveDataProvider */
/* @var $model SalaryModel */

$this->breadcrumbs = array(
    Yii::t('import', 'Salary') => array('index')
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#bank-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
$th = new Employee();
$locale = Yii::app()->getLocale(Yii::app()->language);
$cs = Yii::app()->getClientScript();
$baseUrl = Yii::app()->theme->baseUrl;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/checkinput.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/function_common.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/year.js');
?>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2><?= Yii::t('import', '员工年终奖') ?></h2>
    </div>
    <div class="panel-body">
        <?php
        foreach (Yii::app()->user->getFlashes() as $key => $message) {
            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
        }
        ?>
        <!-- search-form -->

        <?php echo CHtml::beginForm('', 'post', ['enctype' => "multipart/form-data", 'id' => 'form']); ?>
        <table class="table table-striped table-hover table-bordered table-middle table-center " id="sample_editable_1">
            <thead>
            <tr>
                <th rowspan="2">
                    <?= $th->getAttributeLabel('name') ?></th>
                <th rowspan="2">
                    <?= substr(Transition::getCondomDate(), 0, 4) . $th->getAttributeLabel('year_award') ?></th>
                <th colspan="12">
                    <?= Yii::t('import', '全年工资') ?></th>
                <th rowspan="2">
                    <?= Yii::t('import', '应缴税款') ?></th>
                <th rowspan="2">
                    <?= Yii::t('import', '税后收入') ?></th>
            </tr>
            <tr>
                <?php
                foreach ($locale->monthNames as $item) {
                    echo "<th class='th-right'>$item</th>";
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($employees as $employee) {
                ?>
                <tr>
                    <td class='text-center'>
                        <label class=""><?= $employee->name; ?></label>
                        <input type="hidden" id="employee_id_<?= $employee->id ?>" name="employee_id[]"
                               value="<?= $employee->id ?>"/>
                    </td>
                    <td class='text-center'>
                        <input type="text" id="employee_year_<?= $employee->id ?>"
                               name="employee_year[<?= $employee->id ?>][year]"
                               class="input_full" value=""/>
                    </td>
                    <?php
                    foreach ($locale->monthNames as $key => $item) {
                        echo "<td class='text-right'><label id=\"salary_$employee->id" . "_" . $key . "\" >" . $salary[$employee->id][$key]['before_tax'] . "</label>
                        <input type='hidden' id='paidTax_$employee->id" . "_" . $key . "' value='" . $salary[$employee->id][$key]['tax'] . "' /></td>";
                    }
                    ?>
                    <td class='text-right'>
                        <input type="text" id="tax_<?= $employee->id ?>" name="employee_year[<?= $employee->id ?>][tax]" class="input_full" value="0"/>
                    </td>
                    <td class='text-right'>
                        <input id="afterTax_<?= $employee->id ?>" name="employee_year[<?= $employee->id ?>][afterTax]" class="input_full" value="0"/>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>

        <div class="panel-footer">
            <div class="text-center">
                <button class="btn btn-primary" onclick="save()"><span
                        class="glyphicon glyphicon-floppy-disk"></span> <?= Yii::t('import', '保存凭证') ?></button>
            </div>
        </div>
        <?php echo CHtml::endForm(); ?>
    </div>
</div>