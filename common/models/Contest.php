<?php

namespace common\models;

use common\components\ActiveRecord;
use common\components\App;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "contest".
 *
 * @property int $id
 * @property string $title_en
 * @property string $description_en
 * @property string $title_ru
 * @property string $description_ru
 * @property string $start_date
 * @property string $end_date
 * @property int $public
 * @property int $result_panel
 * @property int $voters_limit
 * @property int $range range for example [1-10]
 * @property string $permalink
 * @property string $image
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 * @property Category[] $categories
 * @property Project[] $projects
 * @property Votes[] $votes
 * @property string $title
 * @property string $description
 * @property string $imagePath
 * @property string $imageLink
 * @property boolean $hasImage
 * @property string $imageUrl
 * @property integer $dateStatus
 * @property array $dateStatusData
 * @property array $publicStatusData
 */
class Contest extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $timezone_diff = 0;

    const DATE_STATUS_UPCOMING = 1;
    const DATE_STATUS_LIVE = 2;
    const DATE_STATUS_CLOSED = 3;

    const PUBLIC_STATUS_NO = 0;
    const PUBLIC_STATUS_YES = 1;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return 'contest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_en', 'title_ru', 'start_date', 'end_date', 'result_panel', 'range'], 'required'],
            [['description_en', 'description_ru',], 'string', 'max' => '1000'],
            [['public', 'status', 'timezone_diff', 'result_panel', 'voters_limit', 'lower_threshold', 'upper_threshold'], 'integer'],
            ['range', 'integer', 'integerOnly' => true, 'min' => 2, 'max' => 100],
            [['start_date', 'end_date', 'created_at', 'updated_at', 'is_new_algo'], 'safe'],
            [['title_en', 'title_ru'], 'string', 'max' => 80],
            [['image'], 'string', 'max' => 255],
            [['permalink'], 'string', 'max' => 50],
            ['start_date', 'checkDate', 'on' => 'check_date']
        ];
    }

    public function checkDate()
    {
        $current_time = date("Y-m-d H:i");

        $this->start_date = date("Y-m-d H:i", (strtotime($this->start_date) - $this->timezone_diff * 60));
        $this->end_date = date("Y-m-d H:i", (strtotime($this->end_date) - $this->timezone_diff * 60));

        if ($current_time >= $this->end_date) {
            $this->addError("end_date", Yii::t('main', 'End Date must be greater than current date'));
        } elseif ($this->start_date >= $this->end_date) {
            $this->addError("end_date", Yii::t('main', 'End date must be greater than start date'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'title_en' => Yii::t('main', 'Contest Title (Eng)'),
            'title_ru' => Yii::t('main', 'Contest Title (Rus)'),
            'description_en' => Yii::t('main', 'Description(Eng)'),
            'description_ru' => Yii::t('main', 'Description(Rus)'),
            'is_new_algo' => Yii::t('main', 'Use new algorithm to calculate the score'),
            'lower_threshold' => Yii::t('main', 'Lower threshold for calculating aggregate score (%)'),
            'upper_threshold' => Yii::t('main', 'Upper threshold for calculating aggregate score (%)'),
            'start_date' => Yii::t('main', 'Start Date'),
            'end_date' => Yii::t('main', 'End Date'),
            'public' => Yii::t('main', 'Public'),
            'result_panel' => Yii::t('main', 'Result Panel'),
            'voters_limit' => Yii::t('main', 'Voters Limit'),
            'range' => Yii::t('main', 'Range'),
            'permalink' => Yii::t('main', 'Permalink'),
            'image' => Yii::t('main', 'Image'),
            'created_at' => Yii::t('main', 'Created At'),
            'updated_at' => Yii::t('main', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['contest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['contest_id' => 'id'])->orderBy(['id' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotes()
    {
        return $this->hasMany(Votes::className(), ['contest_id' => 'id']);
    }


    public function beforeSave($insert)
    {
        if ($this->public === NULL)
            $this->public = 0;

        if ($this->status === NULL)
            $this->status = self::STATUS_ACTIVE;

        #$this->start_date = date('Y-m-d H:i:s', (strtotime($this->start_date) - ($this->timezone_diff * 60)));
        #$this->end_date = date('Y-m-d H:i:s', (strtotime($this->end_date) - ($this->timezone_diff * 60)));
        $this->image = basename($this->image);
        return parent::beforeSave($insert);
    }

    public function getTitle()
    {
        return $this->getTranslateAttribute('title');
    }

    public function getDescription()
    {
        return $this->getTranslateAttribute('description');
    }

    public static function getAllModelsAsArray()
    {
        $title = 'title_' . Yii::$app->language;
        return ArrayHelper::map(self::find()->select(['id', $title])->orderBy(['id' => SORT_DESC])->all(), 'id', $title);
    }

    public function getImagePath()
    {
        $path = Yii::getAlias('@webroot');

        if (strpos($path, 'admin')) {
            return $path . "/.." . Yii::$app->params['image_path_system'] . $this->image;
        } else {
            return $path . Yii::$app->params['image_path_system'] . $this->image;
        }
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

    public function afterSave($insert, $changedAttributes)
    {
        if (array_key_exists('image', $changedAttributes) && $changedAttributes['image'] != $this->oldAttributes['image']) {
            $this->deleteOldImage($changedAttributes['image']);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function getDateTimeByFormat2($attr)
    {
        return empty($this->$attr) ? false : date('M d, Y, g:i A', strtotime($this->$attr));
    }

    public function getDateStatus()
    {
        if (time() < strtotime($this->start_date))
            return self::DATE_STATUS_UPCOMING;
        if (time() > strtotime($this->end_date))
            return self::DATE_STATUS_CLOSED;
        return self::DATE_STATUS_LIVE;
    }

    public function getDateStatusData()
    {
        $data = $this->getDateStatusesData();
        return $data[$this->dateStatus];
    }

    private function getDateStatusesData()
    {
        return [
            self::DATE_STATUS_UPCOMING => [
                'label' => Yii::t('main', 'Upcoming'),
                'class' => 'warning',
            ],
            self::DATE_STATUS_LIVE => [
                'label' => Yii::t('main', 'open'),
                'class' => 'success'
            ],
            self::DATE_STATUS_CLOSED => [
                'label' => Yii::t('main', 'closed'),
                'class' => 'primary'
            ],
        ];
    }

    public function getPublicStatusData()
    {
        $data = $this->getPublicStatusesData();
        return $data[$this->public];
    }

    private function getPublicStatusesData()
    {
        return [
            self::PUBLIC_STATUS_NO => [
                'label' => Yii::t('main', 'Draft'),
                'class' => 'default'
            ],
            self::PUBLIC_STATUS_YES => [
                'label' => Yii::t('main', 'Published'),
                'class' => 'primary'
            ]
        ];
    }

    public function delete()
    {
        // $this->username = "deleted_".$this->id."_".$this->username;
        // $this->email = "deleted_".$this->id."_".$this->email;
        $this->status = self::STATUS_DELETED;

        echo "<pre>";
        foreach ($this->projects as $row) {
            #$row->projectToUsers->delete();
            #print_r($row->projectToUsers);
            #echo "=======";
            ProjectToUser::deleteAll(['project_id' => $row->id]);
        }
        // exit;
        // ProjectToUser::find()->where(['->delete();
        $this->save();
    }

    public static function find()
    {
        return parent::find()->where(['status' => self::STATUS_ACTIVE]);
    }

}
