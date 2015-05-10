<?php

/**
 * Frontend main page view.
 *
 * @var yii\web\View $this View
 */

$this->title = Yii::$app->name;
$this->params['noTitle'] = true; ?>

<section id="main-slider" class="no-margin center">
    <div class="well">
        <p><img src="<?= $this->assetManager->publish('@vova07/themes/site/images/slider/bg2.png')[1] ?>" alt="Yii 2" /></p>
        <p>A fast and easy way to start an Yii 2 project, with flexible functionality and structure.</p>
        <a href="https://github.com/vova07/yii2-start" class="btn btn-primary btn-lg" target="_blank">Github</a>
    </div>
</section>

<section id="services" class="emerald">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="media">
                    <div class="pull-left">
                        <i class="icon-user icon-md"></i>
                    </div>
                    <div class="media-body">
                        <h3 class="media-heading">User management</h3>
                        <p>Backend and Frontend user management. Full CRUD functionality, filtering, searching, and user's avatar uploading.</p>
                    </div>
                </div>
            </div><!--/.col-md-4-->
            <div class="col-md-4 col-sm-6">
                <div class="media">
                    <div class="pull-left">
                        <i class="icon-book icon-md"></i>
                    </div>
                    <div class="media-body">
                        <h3 class="media-heading">Post management</h3>
                        <p>Backend and Frontend post management. Full CRUD functionality, filtering, searching, and files uploading.</p>
                    </div>
                </div>
            </div><!--/.col-md-4-->
            <div class="col-md-4 col-sm-6">
                <div class="media">
                    <div class="pull-left">
                        <i class="icon-leaf icon-md"></i>
                    </div>
                    <div class="media-body">
                        <h3 class="media-heading">Free nice themes</h3>
                        <p>On backend it's used functional "AdminLTE" template, and on frontend the beautiful "Flat Theme". Both are free to use.</p>
                    </div>
                </div>
            </div><!--/.col-md-4-->
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
        </div><!--/.row-->
    </div>
</section>