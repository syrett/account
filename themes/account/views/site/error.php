<div class="panel panel-default voucher">
    <!-- Default panel contents -->
    <div class="panel-heading">错误</div>
    <div class="panel-body v-title">
        <?php
        /* @var $this SiteController */
        /* @var $error array */
        ?>

        <div class="form">

            <h2>Error <?php echo $code; ?></h2>

            <div class="error">
                <?php echo CHtml::encode($message); ?>
            </div>
        </div>
        <!-- form -->
    </div>
</div></div>