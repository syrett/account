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
        <table class="table table-striped table-hover table-bordered table-middle" id="sample_editable_1">
            <thead>
            <tr>
                <th>
                    <?= $th->getAttributeLabel('name') ?>
                </th>
                <th>
                    <?= $th->getAttributeLabel('year_award') ?>
                </th>
                <?php
                foreach ($locale->monthNames as $item) {
                    echo "<th>$item</th>";
                }
                ?>
                <th>
                    <?= Yii::t('import', '应缴税款') ?>
                </th>
                <th>
                    <?= Yii::t('import', '税后收入') ?>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($employees as $employee) {
                ?>
                <tr>
                    <td>
                        <label class="" ><?= $employee->name; ?></label>
                        <input type="hidden" name="employee_id" value="<?= $employee->id ?>"/>
                    </td>
                    <td>
                        <input type="text" name="employee_year" class="input-small" value="" />
                    </td>
                    <?php
                    foreach ($locale->monthNames as $item) {
                        echo "<th>$item</th>";
                    }
                    ?>
                    <td>
                        <a class="edit" href="javascript:;">
                            <label id="tax" >0</label></a>
                    </td>
                    <td>
                        <a class="delete" href="javascript:;">
                            <label id="tax" >0</label></a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>

    </div>
</div>