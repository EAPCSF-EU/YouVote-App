<?php

namespace frontend\controllers;

use common\models\Voter;
use frontend\models\VoterLoginForm;
use Mailgun\Mailgun;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use frontend\components\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'index'],
                'rules' => [
                    [
                        'actions' => ['confirm', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new VoterLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

//    /**
//     * Signs user up.
//     *
//     * @return mixed
//     */
//    public function actionSignup()
//    {
//        $model = new SignupForm();
//        if ($model->load(Yii::$app->request->post())) {
//            if ($user = $model->signup()) {
//                if (Yii::$app->getUser()->login($user)) {
//                    return $this->goHome();
//                }
//            }
//        }
//
//        return $this->render('signup', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //$model->sendEmail();
            $user = $model->generateResetPassword();
            $msg = Mailgun::create(Yii::$app->params['mailgun']['key']);
            $body = $this->renderPartial('/../../common/mail/passwordResetToken-html', ['user' => $user]);
            $msg->messages()->send(Yii::$app->params['mailgun']['domain'], [
                'from' => Yii::$app->params['mailgun']['from'],
                'to' => $model->email,
                'subject' => 'Rest your password - ' . Yii::$app->name,
                'html' => $body
            ]);

            Yii::$app->session->setFlash('success', Yii::t('main','Check your email for further instructions'));

            return $this->goHome();
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('main','New password saved'));
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionConfirm($id)
    {
        $model = $this->findVoter($id);
        $model->generatePassword();
        $model->confirm_token = null;

        if ($model->save()) {
//            send email
            $msg = Mailgun::create(Yii::$app->params['mailgun']['key']);
            $body = $this->renderPartial('/../../common/mail/success-registered-html', ['voter' => $model]);
            $msg->messages()->send(Yii::$app->params['mailgun']['domain'], [
                'from' => Yii::$app->params['mailgun']['from'],
                'to' => $model->email,
                'subject' => 'You have successfully registered for Voting application of ' . Yii::$app->name,
                'html' => $body
            ]);

            Yii::$app->session->addFlash('success', Yii::t('main', 'You successfully verified your account. Your login and password was sent to your email. Please, check your email.'));
        } else
            Yii::$app->session->setFlash('danger', Yii::t('main', 'System error'));
        return $this->render('confirm');
    }

    protected function findVoter($confirmKey)
    {
        if (($model = Voter::findOne(['confirm_token' => $confirmKey])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('main', 'Voter by this confirm link not found.'));
    }
}
