<?php
/**
 * Created by PhpStorm.
 * User: Davron
 * Date: 3/21/2019
 * Time: 16:07
 */

namespace common\components;


use Yii;

class App
{
    public static function getBackend() {
        return Yii::$app->params['back_protocol'].'://'.Yii::$app->params['backend'];
    }

    public static function getFrontend() {
        return Yii::$app->params['front_protocol'].'://'.Yii::$app->params['frontend'];
    }

    public static function getNotSelectedLanguage() {
        return Yii::$app->language == 'uz' ? 'ru' : 'uz';
    }

    public static function mergeErrors($errors) {
        $er = '';
        foreach ($errors as $error) {
            $er .= $error[0];
        }
        return $er;
    }

    public static function getImagePath() {
        return self::getFrontend().Yii::$app->params['image_path'];
    }

    public static function getDefaultImage() {
       return self::getFrontend() . '/files/default/no_image.png';
    }
}