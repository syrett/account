<?php

namespace vova07\bank;

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
                'POST <_m:bank>' => '<_m>/user/create',
                '<_m:bank>' => '<_m>/default/index',
                '<_m:bank>/<id:\d+>-<alias:[a-zA-Z0-9_-]{1,100}+>' => '<_m>/default/view',
            ]
        );

        // Add module I18N category.
        if (!isset($app->i18n->translations['vova07/bank']) && !isset($app->i18n->translations['vova07/*'])) {
            $app->i18n->translations['vova07/bank'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@vova07/bank/messages',
                'forceTranslation' => true,
                'fileMap' => [
                    'vova07/bank' => 'bank.php',
                ]
            ];
        }
    }
}
