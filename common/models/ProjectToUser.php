<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_to_user".
 *
 * @property int $project_id
 * @property int $voter_id
 *
 * @property Project $project
 * @property Voter $voter
 */
class ProjectToUser extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_to_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'voter_id'], 'required'],
            [['project_id', 'voter_id'], 'integer'],
            [['project_id', 'voter_id'], 'unique', 'targetAttribute' => ['project_id', 'voter_id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['voter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Voter::className(), 'targetAttribute' => ['voter_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'project_id' => Yii::t('main', 'Project ID'),
            'voter_id' => Yii::t('main', 'Voter ID'),
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
    public function getVoter()
    {
        return $this->hasOne(Voter::className(), ['id' => 'voter_id']);
    }
}
