<?php

namespace common\models;

use common\components\App;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property int $contest_id
 * @property string $title_en
 * @property string $title_ru
 * @property string $content_en
 * @property string $content_ru
 * @property string $image
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Contest $contest
 * @property Votes[] $votes
 * @property ProjectToUser[] $projectToUsers
 * @property Voter[] $voters
 *
 * @property string $title
 * @property string $content
 * @property string $imagePath
 * @property string $imageLink
 * @property boolean $hasImage
 * @property string $imageUrl
 */
class Project extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contest_id', 'title_en', 'title_ru'], 'required'],
            [['contest_id'], 'integer'],
            [['content_en', 'content_ru'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title_en', 'title_ru'], 'string', 'length' => [4, 50]],
            [['image'], 'string', 'max' => 1024],
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
            'title_en' => Yii::t('main', 'Project title (Eng)'),
            'title_ru' => Yii::t('main', 'Project title (Rus)'),
            'content_en' => Yii::t('main', 'Content En'),
            'content_ru' => Yii::t('main', 'Content Ru'),
            'image' => Yii::t('main', 'Image'),
            'created_at' => Yii::t('main', 'Created At'),
            'updated_at' => Yii::t('main', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContest()
    {
        return $this->hasOne(Contest::class, ['id' => 'contest_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotes()
    {
        return $this->hasMany(Votes::class, ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVoters()
    {
        return $this->hasMany(Voter::class, ['id' => 'voter_id'])->viaTable('project_to_user', ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectToUsers()
    {
        return $this->hasMany(ProjectToUser::class, ['project_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        $this->image = basename($this->image);
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (array_key_exists('image', $changedAttributes) && $changedAttributes['image'] != $this->oldAttributes['image']) {
            $this->deleteOldImage($changedAttributes['image']);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function getTitle()
    {
        return $this->getTranslateAttribute('title');
    }

    public function getContent()
    {
        return $this->getTranslateAttribute('content');
    }

    public function getImagePath()
    {
        return realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'web' . Yii::$app->params['image_path_system'] . $this->image;
    }

    public function getImageUrl()
    {
        return App::getFrontend() . Yii::$app->params['image_path'] . $this->image;
    }

    public function getHasImage()
    {
        return !is_dir($this->imagePath) && file_exists($this->imagePath);
    }

    public function getImageLink()
    {
        return $this->hasImage ? $this->imageUrl : App::getDefaultImage();
    }

    public function deleteOldImage($image)
    {
        $file = realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'web' . Yii::$app->params['image_path_system'] . $image;
        if (!is_dir($file) && file_exists($file))
            unlink($file);
    }

    public function deleteImage()
    {
        if ($this->hasImage)
            unlink($this->imagePath);
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete();
    }

    public static function getAllModelsAsArray()
    {
        $title = 'title_' . Yii::$app->language;
        return ArrayHelper::map(self::find()->select(['id', $title])->orderBy(['id' => SORT_DESC])->all(), 'id', $title);
    }


}
