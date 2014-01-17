<div class="panel panel-default voucher">
    <!-- Default panel contents -->
    <div class="panel-heading">&nbsp;</div>
    <div class="panel-body v-title">
        <?php
        /* @var $this SiteController */
        /* @var $error array */
        ?>

        <div class="form">

            <h2>Success </h2>

            <div class="error">
                <?
                    foreach(Yii::app()->user->getFlashes() as $key => $message) {
                    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
                }?>
            </div>
        </div>
        <!-- form -->
    </div>
</div></div>