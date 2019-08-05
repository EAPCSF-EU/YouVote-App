<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "voter".
 *
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $confirm_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $role
 * @property string $password
 *
 * @property ProjectToUser[] $projectToUsers
 * @property Project[] $projects
 * @property Votes[] $votes
 * @property Team $team
 */
class Voter extends \common\components\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */

    public $password;
    public $project_id;
    public $contest_id;

    public static function tableName()
    {
        return 'voter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'name', 'email'], 'required'],
            [['status', 'created_at', 'updated_at', 'role', 'project_id', 'contest_id'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'confirm_token'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 50],
            [['auth_key'], 'string', 'max' => 32],
//            [['username'], 'unique'],
            ['email', 'trim'],
            ['email', 'email'],
            [['email'], 'unique', 'targetAttribute'=>['email', 'status'], 'message'=>Yii::t('main','Email {value} already exists!')],
            [['password_reset_token'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'username' => Yii::t('main', 'E-mail'),
            'name' => Yii::t('main', 'Name'),
            'password' => Yii::t('main', 'Password'),
            'auth_key' => Yii::t('main', 'Auth Key'),
            'password_hash' => Yii::t('main', 'Password Hash'),
            'password_reset_token' => Yii::t('main', 'Password Reset Token'),
            'confirm_token' => Yii::t('main', 'Confirm Token'),
            'email' => Yii::t('main', 'Email'),
            'status' => Yii::t('main', 'Status'),
            'created_at' => Yii::t('main', 'Created At'),
            'updated_at' => Yii::t('main', 'Updated At'),
            'role' => Yii::t('main', 'Role'),
            'project_id' => Yii::t('main', 'Project'),
            'contest_id' => Yii::t('main', 'Contest'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectToUsers()
    {
        return $this->hasMany(ProjectToUser::className(), ['voter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['id' => 'project_id'])->viaTable('project_to_user', ['voter_id' => 'id']);
    }


    public function afterSave($insert, $changedAttributes)
    {
        $project = Project::findOne($this->project_id);

        if ($project) {
            $existProject = ProjectToUser::findOne(['voter_id' => $this->id]);

            if (isset($existProject)) {
                $existProject->delete();
            }

            $this->link('projects', $project);
        }

        parent::afterSave($insert, $changedAttributes);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotes()
    {
        return $this->hasMany(Votes::className(), ['user_id' => 'id']);
    }

    public function generatePassword()
    {
        $this->password = rand(100000, 999999);
        $this->setPassword($this->password);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->isNewRecord) {
            $this->generatePassword();
            $this->generateAuthKey();
            $this->status = User::STATUS_ACTIVE;
            $this->role = User::ROLE_VOTER;
            $this->created_at = time();
            $this->generateConfirmKey();
        }
        $this->updated_at = time();
        return parent::save($runValidation, $attributeNames);
    }

    public function generateConfirmKey() {
        return $this->confirm_token = md5($this->email.rand(1,1000000)).time().md5($this->name.rand(1,1000000));
    }

    public function sendConfirmEmail() {

    }

    public function sendEmail()
    {
        return Yii::$app->mailer->compose(
            ['html' => 'success-registered-html'],
            ['voter' => $this]
        )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject(Yii::t('main', 'You have successfully registered for {appName}', ['appName' => Yii::$app->name]))
            ->send();
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function delete(){
        $this->username = "deleted_".$this->id."_".$this->username;
        $this->email = "deleted_".$this->id."_".$this->email;
        $this->status = Voter::STATUS_DELETED;
        $this->save();
    }

    public static function find()
    {
        return parent::find()->where(['status' => self::STATUS_ACTIVE]);
    }

}
