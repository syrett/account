<?php
function BtnBack($label='<span class="glyphicon glyphicon-circle-arrow-left"></span> 返回前页',$class="btn btn-circle btn-inverse")
{
	return "<button type=\"button\" onclick=\"history.back(-1);\" class=\"$class\" style=\"margin-left:60px;\">$label</button>";
}
?>
