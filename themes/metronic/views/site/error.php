<div class="panel panel-default voucher">
    <!-- Default panel contents -->
    <div class="panel-heading">
        <h2>操作失败</h2>
    </div>
    <div class="panel-body v-title">
        <div class="error">
            <?php
            if(isset($message))
                echo CHtml::encode($message). '<br />';
            ?>
            <?
            if(isset($code) && $code == 500){
                echo $file;
                echo " $line";
            }
            ?>
            <?
            foreach(Yii::app()->user->getFlashes() as $key => $message) {
                echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
            }?>
        </div>
        <!-- form -->
    </div>
</div>