<?php

namespace backend\controllers;

use backend\models\ResultCalculator;
use common\components\App;
use common\models\Category;
use common\models\Project;
use common\models\Votes;
use Yii;
use common\models\Contest;
use common\models\ContestSearch;
use backend\components\Controller;
use yii\db\Query;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * ContestController implements the CRUD actions for Contest model.
 */
class ContestController extends Controller
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

    public function actions()
    {
        return [
            'uploadphoto' => [
                'class' => 'budyaga\cropper\actions\UploadAction',
                'url' => App::getImagePath(),
                'path' => '@webroot/..' . Yii::$app->params['image_path'],
                'maxSize' => 6291456,
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionUpload()
    {
        $fileName = 'file';
        $uploadPath = Yii::getAlias('@webroot') . '/..' . Yii::$app->params['image_path'];

        if (isset($_FILES[$fileName])) {
            $file = UploadedFile::getInstanceByName($fileName);
            if ($file->saveAs($uploadPath . '/' . $file->name)) {
                echo Json::encode($file);
            }
        }

        return false;
    }

    /**
     * Lists all Contest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);
        $dataProvider->pagination->pageSize = Yii::$app->params['contest_page_size'];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contest model.
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
     * Creates a new Contest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contest();

        if ($post = Yii::$app->request->post()) {

            $model->load($post);
            $model->timezone_diff = $post['timezone_diff'];
            $model->scenario = 'check_date';

            $model->result_panel = 1;

            if ($model->save())
                return $this->redirect(['projects', 'id' => $model->id, 'new' => true]);
            else
                Yii::$app->session->addFlash('danger', App::mergeErrors($model->errors));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionProjects($id, $new = false)
    {
        return $this->render('projects', ['model' => $this->findModel($id), 'new' => $new]);
    }

    public function actionCategories($id, $new = false)
    {
        return $this->render('categories', ['model' => $this->findModel($id), 'new' => $new]);
    }

    public function actionSaveProject($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Project();
        if ($model->load(Yii::$app->request->post())) {
            $model->contest_id = $this->findModel($id)->id;
            return [
                'success' => $model->save(),
                'id' => $model->id,
                'title' => $model->title
            ];
        }
        return [
            'success' => false,
            'id' => null,
            'title' => null
        ];
    }

    public function actionSaveCategory($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Category();
        if ($model->load(Yii::$app->request->post())) {
            $model->contest_id = $this->findModel($id)->id;
            return [
                'success' => $model->save(),
                'id' => $model->id,
                'title' => $model->title
            ];
        }
        return [
            'success' => false,
            'id' => null,
            'title' => null
        ];
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionResults($id, $download = false)
    {

        $contest = Contest::findOne(['id' => $id]);

        if ($contest == null)
            throw new NotFoundHttpException("Contest not found!");

//        $results_by_category = (new Query())
//            ->select("SUM(score) as total, category_id, project_id, count(id) as votes_count")
//            ->from(Votes::tableName())
//            ->where(['contest_id' => $id])
//            ->groupBy("category_id, project_id")->all();
//        echo "<pre>";
//        print_r($results_by_category);
//        exit();

        $calculator = new ResultCalculator();
        $results_by_category = $calculator->calculate($id);
        if ($download) {
            return $this->renderPartial('summary_table',
                [
                    'results_by_category' => $results_by_category,
                    'contest' => $contest,
                    'is_download_button_visible' => false,
                    'download_to_excel' => true
                ]);
        }

        return $this->render('results',
            [
                'results_by_category' => $results_by_category,
                'contest' => $contest
            ]);
    }

    public function actionDownload($id): string
    {
        $project = Project::findOne($id);
        $votes = Votes::find()->where(['project_id' => $id])->orderBy(['user_id' => SORT_ASC])->all();
        $voters = Votes::find()->select(['user_id'])->where(['project_id' => $id])->groupBy(['user_id'])->asArray()->all();
        return $this->renderPartial('download', ['votes' => $votes, 'project' => $project, 'voters' => $voters]);
    }

    public function actionDeleteProject($id): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Project::findOne($id);
        return [
            'success' => $model && $model->delete()
        ];
    }

    public function actionDeleteCategory($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Category::findOne($id);
        return [
            'success' => $model && $model->delete()
        ];
    }

    /**
     * Updates an existing Contest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $new = false)
    {
        $model = $this->findModel($id);

        if ($post = Yii::$app->request->post()) {
            $model->load($post);
            $model->timezone_diff = $post['timezone_diff'];

            if ($model->save()) {
                if (Yii::$app->request->post('new') == 1)
                    return $this->redirect(['projects', 'id' => $model->id, 'new' => true]);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'new' => $new
        ]);
    }

    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        if ($post = Yii::$app->request->post()) {
            $model->load($post);

            $model->timezone_diff = $post['timezone_diff'];
            $model->scenario = 'check_date';

            if ($model->save()) {
                if (Yii::$app->request->post('new') == 1)
                    return $this->redirect(['projects', 'id' => $model->id, 'new' => true]);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    public function actionPublish($id, $public)
    {
        $model = $this->findModel($id);
        $model->public = (int)!$public;

        if (count($model->categories) < 2 || count($model->projects) < 2) {
            Yii::$app->session->addFlash('warning', Yii::t('main', 'You cannot publish the contest. Enter at least one criteria and project.'));
        } elseif ($model->save()) {
            if ($model->public)
                Yii::$app->session->addFlash('success', Yii::t('main', 'Contest is published'));
            else
                Yii::$app->session->addFlash('success', Yii::t('main', 'Contest is unpublished'));
        }

        return $this->redirect(['view', 'id' => $model->id]);

    }

    /**
     * Deletes an existing Contest model.
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

        Yii::$app->session->setFlash('success', Yii::t('main', 'Contest has been deleted.'));
        return $this->redirect(['index']);
    }

    /**
     * Finds the Contest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contest::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('main', 'The requested page does not exist.'));
    }
}
