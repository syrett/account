<div class="panel panel-success">
    <!-- Default panel contents -->
    <div class="panel-heading">
    	<h3 class="panel-title"><span class="glyphicon glyphicon-ok"></span> 操作成功！</h3>
    </div>
    <div class="panel-body">
		<?php
		foreach(Yii::app()->user->getFlashes() as $key => $message) {
			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		}
		?>
    </div>
</div>
