<?php

namespace vendor\dinhtrung\blog;

class BlogModule extends \yii\base\Module
{
    public $controllerNamespace = 'vendor\dinhtrung\blog\controllers';

    public function init()
    {
        parent::init();

        \Yii::$app->getI18n()->translations['*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => __DIR__ . '/messages',
        ];
    }
}
