<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "team".
 *
 * @property int $id
 * @property string $title_en
 * @property string $title_ru
 * @property int $project_id
 *
 * @property Project $project
 * @property Voter[] $voters
 * @property string $title
 */
class Team extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_en', 'title_ru', 'project_id'], 'required'],
            [['project_id'], 'integer'],
            [['title_en', 'title_ru'], 'string', 'max' => 250],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'title_en' => Yii::t('main', 'Title En'),
            'title_ru' => Yii::t('main', 'Title Ru'),
            'project_id' => Yii::t('main', 'Project'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVoters()
    {
        return $this->hasMany(Voter::className(), ['team_id' => 'id']);
    }

    public function getTitle() {
        return $this->getTranslateAttribute('title');
    }

    public static function getAllModelsAsArray() {
        $title = 'title_' . Yii::$app->language;
        return ArrayHelper::map(self::find()->select(['id',$title])->orderBy(['id'=>SORT_DESC])->all(),'id',$title);
    }
}
