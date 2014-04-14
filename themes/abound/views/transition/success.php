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
                <?php
                /**
                 * Created by PhpStorm.
                 * User: jason.wang
                 * Date: 13-12-11
                 * Time: 下午8:17
                 */
                foreach(Yii::app()->user->getFlashes() as $key => $message) {
                    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
                }
                ?>
            </div>
        </div>
        <!-- form -->
    </div>
</div></div>