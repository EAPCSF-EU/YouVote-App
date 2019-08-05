<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $contest_id
 * @property string $title_ru
 * @property string $title_en
 *
 * @property Contest $contest
 * @property Votes[] $votes
 * @property string $title
 */
class Category extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contest_id', 'title_ru', 'title_en'], 'required'],
            [['contest_id'], 'integer'],
            [['title_ru', 'title_en'], 'string', 'length' => [4, 50]],
            [['contest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contest::className(), 'targetAttribute' => ['contest_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'contest_id' => Yii::t('main', 'Contest'),
            'title_ru' => Yii::t('main', 'Criteria title (Rus)'),
            'title_en' => Yii::t('main', 'Criteria title (Eng)'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContest()
    {
        return $this->hasOne(Contest::className(), ['id' => 'contest_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotes()
    {
        return $this->hasMany(Votes::className(), ['category_id' => 'id']);
    }

    public function getTitle() {
        return $this->getTranslateAttribute('title');
    }
}
