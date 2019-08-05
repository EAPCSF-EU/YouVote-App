<?php
/**
 * Created by PhpStorm.
 * User: Davron
 * Date: 3/19/2019
 * Time: 22:47
 */

namespace backend\components;


use common\models\User;
use Yii;

class Controller extends \common\components\Controller
{
    public function beforeAction($action)
    {
        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->role != User::ROLE_ADMIN)
            Yii::$app->user->logout();
        return parent::beforeAction($action);
    }
}