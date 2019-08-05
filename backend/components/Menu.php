<?php
/**
 * Created by PhpStorm.
 * User: Davron
 * Date: 2018/02/20
 * Time: 23:51
 */

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
                    'icon' => 'user-o',
                    'url' => ['/voter/index'],
                    'active' => Yii::$app->controller->id == 'voter'
                ],
                [
                    'label' => Yii::t('main', 'Contest'),
                    'icon' => 'check-square-o',
                    'url' => ['/contest/index'],
                    'active' => Yii::$app->controller->id == 'contest'
                ],
                ['label' => '', 'options' => ['class' => 'header']],
                [
                    'label' => Yii::t('main', 'Settings'),
                    'icon' => 'cog',
                    'url' => ['/settings/account'],
                    'template'=>'<a href="{url}">{icon} {label}</a>'
                ],
            ];
    }
}
