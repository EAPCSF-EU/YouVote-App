<?php

/**
 * Created by PhpStorm.
 * User: Davron
 * Date: 3/19/2019
 * Time: 22:46
 */

namespace common\components;

use Yii;

class Controller extends \yii\web\Controller
{
    public function referrer()
    {
        if(!empty(Yii::$app->request->referrer))
            return $this->redirect(Yii::$app->request->referrer);
        else
            return $this->goHome();
    }

    public function dump($obj) {
        echo '<pre>';
        print_r($obj);
        echo '</pre>';
        exit;
    }

    public function init() {
        $session = Yii::$app->session;
        if ($session->has('lang')) {
            Yii::$app->language = $session->get('lang');
        }else {
            Yii::$app->language = Yii::$app->params['main_language'];
            $session->set('lang', Yii::$app->params['main_language']);
        }
        parent::init();
    }

    public function actionLang($lang) {
        Yii::$app->language = $lang;
        Yii::$app->session->set('lang', $lang);
        return $this->referrer();
    }
}