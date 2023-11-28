<?php

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