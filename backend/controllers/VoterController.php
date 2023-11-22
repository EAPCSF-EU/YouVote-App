<?php

namespace backend\controllers;

use common\components\App;
use common\models\Votes;
use Mailgun\Mailgun;
use Yii;
use common\models\Voter;
use common\models\VoterSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * VoterController implements the CRUD actions for Voter model.
 */
class VoterController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access'=>[
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Voter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VoterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Voter model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Voter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionCreate()
    {
        $model = new Voter();

        if ($post = Yii::$app->request->post()) {
            $model->load($post);
            $model->username = $model->email;

            if ($model->save()) {
                try {

                    $msg = Mailgun::create(Yii::$app->params['mailgun']['key']);
                    $body = $this->renderPartial('/../../common/mail/confirm-html', ['voter'=>$model]);
                    $msg->messages()->send(Yii::$app->params['mailgun']['domain'], [
                        'from'    => Yii::$app->params['mailgun']['from'],
                        'to'      => $model->email,
                        'subject' => 'Welcome to EaP Civil Society Hackathon! Please verify your account!',
                        'html'    => $body
                    ]);

                    Yii::$app->session->setFlash('success', Yii::t('main', 'Voter was created. The email has been successfully sent to the new voter.'));
                }
                catch (\Mailgun\Exception $e){
                    $model->delete();
                    Yii::$app->session->setFlash('success', Yii::t('main', 'Voter is not created. email is not correct!'));
                }
                return $this->redirect(['create']);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Voter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if ($model->projects)
            $model->project_id = $model->projects[0];

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Voter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('success', Yii::t('main', 'Voter has been deleted.'));
        return $this->redirect(['index']);
    }

    /**
     * Finds the Voter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Voter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Voter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('main', 'The requested page does not exist.'));
    }
}
