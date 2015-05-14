<?php

/**
 * Set all application aliases.
 */

Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('statics', dirname(dirname(__DIR__)) . '/statics');
Yii::setAlias('root', dirname(dirname(__DIR__)));
Yii::setAlias('temp', dirname(dirname(__DIR__)) . '/test');
Yii::setAlias('theme', dirname(dirname(__DIR__)). '/vendor/vova07/yii2-start-themes');