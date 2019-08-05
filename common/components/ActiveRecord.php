<?php
/**
 * Created by PhpStorm.
 * User: Davron
 * Date: 3/19/2019
 * Time: 22:48
 */

namespace common\components;


use Yii;

class ActiveRecord extends \yii\db\ActiveRecord
{
    protected function getTranslateAttribute($attr) {
        $attr = $attr . '_' . Yii::$app->language;
        return empty($this->$attr) ? false : $this->$attr;
    }

    public function getBoolValue($attr) {
        return empty($this->$attr) ? Yii::t('main','No') : Yii::t('main','Yes');
    }

    public static function getBoolValuesAsArray() {
        return [
            0 => Yii::t('main','No'),
            1 => Yii::t('main','Yes')
        ];
    }

    public function getDateTimeByFormat($attr) {
        return empty($this->$attr) ? false : substr($this->$attr,0,16);
    }
}