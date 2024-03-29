<?php

namespace backend\components;

use Yii;

class Menu
{
    public static function getAdminMenu()
    {
        return [
            [
                'label' => Yii::t('main', 'Dashboard'),
                'icon' => 'home',
                'url' => ['/site/index'],
                'active' => Yii::$app->controller->id == 'site'
            ],
            [
                'label' => Yii::t('main', 'Voter'),
                'icon' => 'user',
                'url' => ['/voter/index'],
                'active' => Yii::$app->controller->id == 'voter'
            ],
            [
                'label' => Yii::t('main', 'Contest'),
                'icon' => 'check-square',
                'url' => ['/contest/index'],
                'active' => Yii::$app->controller->id == 'contest'
            ],
            ['label' => '', 'options' => ['class' => 'header']],
            [
                'label' => Yii::t('main', 'Settings'),
                'icon' => 'cog',
                'url' => ['/settings/account'],
                'active' => Yii::$app->controller->id == 'settings'
//                    'template'=>'<a href="{url}">{icon} {label}</a>'
            ],
        ];
    }
}
