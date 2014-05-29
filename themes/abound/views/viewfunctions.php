<?php
function BtnBack($label='<span class="glyphicon glyphicon-circle-arrow-left"></span> 返回',$class="btn btn-inverse")
{
	return "<button type=\"button\" onclick=\"history.back(-1);\" class=\"$class\">$label</button>";
}
?>
