<?php

namespace vova07\cash;

use yii\base\BootstrapInterface;

/**
 * cash module bootstrap class.
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
                'POST <_m:cash>' => '<_m>/user/create',
                '<_m:cash>' => '<_m>/default/index',
                '<_m:cash>/<id:\d+>-<alias:[a-zA-Z0-9_-]{1,100}+>' => '<_m>/default/view',
            ]
        );

        // Add module I18N category.
        if (!isset($app->i18n->translations['vova07/cash']) && !isset($app->i18n->translations['vova07/*'])) {
            $app->i18n->translations['vova07/cash'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@vova07/cash/messages',
                'forceTranslation' => true,
                'fileMap' => [
                    'vova07/cash' => 'cash.php',
                ]
            ];
        }
    }
}
