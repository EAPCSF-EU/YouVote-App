<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "votes".
 *
 * @property int $id
 * @property int $user_id
 * @property int $contest_id
 * @property int $category_id
 * @property int $score
 *
 * @property Category $category
 * @property Contest $contest
 * @property Voter $user
 * @property string $created_at
 */
class Votes extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'votes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'contest_id', 'category_id', 'score'], 'required'],
            [['user_id', 'contest_id', 'category_id', 'score'], 'integer'],
            [['created_at'], 'safe'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['contest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contest::className(), 'targetAttribute' => ['contest_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Voter::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'user_id' => Yii::t('main', 'User ID'),
            'contest_id' => Yii::t('main', 'Contest ID'),
            'category_id' => Yii::t('main', 'Category ID'),
            'score' => Yii::t('main', 'Score'),
            'created_at' => Yii::t('main', 'Created At'),
        ];
    }

    public function beforeSave($insert)
    {
        $this->created_at = date('Y-m-d H:i:s');
        return parent::beforeSave($insert);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
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
    public function getUser()
    {
        return $this->hasOne(Voter::className(), ['id' => 'user_id']);
    }
}
