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