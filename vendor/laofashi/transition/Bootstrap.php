<?php

namespace laofashi\transition;

use yii\base\BootstrapInterface;

/**
 * Bank module bootstrap class.
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // Add module URL rules.
        $app->getUrlManager()->addRules(
            [
                'POST <_m:transition>' => '<_m>/user/create',
                '<_m:transition>' => '<_m>/default/index',
                '<_m:transition>/<id:\d+>-<alias:[a-zA-Z0-9_-]{1,100}+>' => '<_m>/default/view',
            ]
        );

        // Add module I18N category.
        if (!isset($app->i18n->translations['laofashi/transition']) && !isset($app->i18n->translations['laofashi/*'])) {
            $app->i18n->translations['laofashi/transition'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@laofashi/transition/messages',
                'forceTranslation' => true,
                'fileMap' => [
                    'laofashi/transition' => 'transition.php',
                ]
            ];
        }
    }
}
