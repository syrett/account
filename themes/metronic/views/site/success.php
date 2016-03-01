<div class="panel panel-default voucher">
    <!-- Default panel contents -->
    <div class="panel-heading">
		<h2><?= Yii::t('import', '操作成功') ?></h2>
	</div>
    <div class="panel-body v-title">
            <div class="error">
                <?
                    foreach(Yii::app()->user->getFlashes() as $key => $message) {
                    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
                }?>
            </div>
        <!-- form -->
    </div>
</div>