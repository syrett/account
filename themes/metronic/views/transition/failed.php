<div class="panel panel-danger">
    <!-- Default panel contents -->
    <div class="panel-heading">
    	<h3 class="panel-title"><span class="glyphicon glyphicon-exclamation-sign"></span> 操作失败</h3>
    </div>
    <div class="panel-body">
		<?php
		foreach(Yii::app()->user->getFlashes() as $key => $message) {
			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		}
		?>
    </div>
</div>
