<?php

namespace dinhtrung\blog;

class BlogModule extends \yii\base\Module
{
    public $controllerNamespace = 'dinhtrung\blog\controllers';

    public function init()
    {
        parent::init();

        \Yii::$app->getI18n()->translations['*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => __DIR__ . '/messages',
        ];
    }
}
