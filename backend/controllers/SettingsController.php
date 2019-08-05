<?php

namespace backend\controllers;

use common\components\App;
use common\models\User;
use common\models\Votes;
use Mailgun\Mailgun;
use Yii;
use common\models\Voter;
use common\models\VoterSearch;
use backend\components\Controller;
use yii\base\Exception;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * VoterController implements the CRUD actions for Voter model.
 */
class SettingsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionAccount()
    {
        $user = Yii::$app->user->identity;
        $model = $this->findModel($user->getId());
        $model->setScenario('accountUpdate');

        if ($post = Yii::$app->request->post()) {
            $model->username = $post['User']['username'];
            $model->name = $post['User']['name'];
            $model->email = $post['User']['email'];

            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Your account is updated.");
                return $this->redirect(['account']);
            }
        }

        return $this->render('account', [
            'model' => $model
        ]);
    }

    public function actionSecurity()
    {
        $user = Yii::$app->user->identity;
        $model = $this->findModel($user->getId());
        $model->setScenario('changePassword');

        if ($post = Yii::$app->request->post()) {
            $model->current_password = $post['User']['current_password'];
            $model->new_password = $post['User']['new_password'];
            $model->repeat_password = $post['User']['repeat_password'];

            if ($model->validate()) {
                $model->setPassword($model->new_password);

                if ($model->save(false)) {
                    $msg = Mailgun::create(Yii::$app->params['mailgun']['key']);
                    $body = $this->renderPartial('/../../common/mail/password-changed-html', ['user' => $model]);
                    $msg->messages()->send(Yii::$app->params['mailgun']['domain'], [
                        'from' => Yii::$app->params['mailgun']['from'],
                        'to' => $model->email,
                        'subject' => 'Your password has been changed ',
                        'html' => $body
                    ]);

                    Yii::$app->user->logout();
                    return $this->goHome();
                }
            }
        }

        return $this->render('security', [
            'model' => $model
        ]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('main', 'The requested page does not exist.'));
    }
}
