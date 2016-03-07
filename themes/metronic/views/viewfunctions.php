<?php
function BtnBack($label = '', $class = "btn btn-inverse")
{
    if ($label == '')
        $label = '<span class="glyphicon glyphicon-circle-arrow-left"></span> ' . Yii::t('import', '返回前页');
    return "<button type=\"button\" onclick=\"history.back(-1);\" class=\"$class\" style=\"margin-left:60px;\">$label</button>";
}

?>
