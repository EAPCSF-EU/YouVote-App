<?php

namespace frontend\controllers;

use common\exceptions\ContestForbiddenException;
use common\models\Category;
use common\models\Contest;
use common\models\Project;
use common\models\ProjectToUser;
use common\models\Voter;
use common\models\Votes;
use Yii;
use frontend\components\Controller;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;

/**
 * Site controller
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
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
    public function actionView($id)
    {

        $contest = Contest::findOne(['id' => $id]);


        if (!$this->voterProject || $this->voterProject->contest_id != $id) {
            throw new \yii\web\NotFoundHttpException("Contest not found!");
        }

        $projects = Project::find()
            ->where('id <> ' . $this->voterProject->id)
            ->andWhere(['contest_id' => $contest->id])
//            ->andWhere(['user_id' => $this->user->identity->id])
            ->all();


        if (empty($projects))
            throw new \yii\web\NotFoundHttpException("Contest does not have projects to vote!");

        if ($contest == null)
            throw new \yii\web\NotFoundHttpException("Contest not found!");

        if (time() < strtotime($contest->start_date) || time() > strtotime($contest->end_date))
            throw new ContestForbiddenException(Yii::t('main', "Voting is not started yet"));

        $votes = Votes::find()->select('project_id')
            ->where(['contest_id' => $contest->id, 'user_id' => $this->user->identity->id])
            ->groupBy('project_id')
            ->asArray()->all();

        return $this->render('view',
            [
                'contest' => $contest,
                'projects' => $projects,
                'votes' => $votes
            ]);
    }

    public function actionVoting($id)
    {
        $currentPage = isset($_GET['p']) ? $_GET['p'] : 1;

        $contest = Contest::findOne(['id' => $id]);
        $projects = Project::find()
            ->where('id <> ' . $this->voterProject->id)
            ->andWhere(['contest_id' => $contest->id])->all();

        if (empty($projects)) {
            throw new \yii\web\NotFoundHttpException("Contest does not have projects to vote!");
        }
        if (!$this->voterProject || $this->voterProject->contest_id != $id) {
            throw new \yii\web\NotFoundHttpException("Contest not found!");
        }

        $currentProject = $projects[$currentPage - 1];
        $pageSize = count($projects);

        if ($contest == null)
            throw new \yii\web\NotFoundHttpException("Contest not found!");

        if (time() < strtotime($contest->start_date) || time() > strtotime($contest->end_date))
            throw new ContestForbiddenException(Yii::t('main', "Voting is not started yet"));

        if ($currentProject->id == $this->voterProject->id)
            throw new ContestForbiddenException(Yii::t('main', "You cannot vote on your own project!"));

        $votes = Votes::find()
            ->where(['contest_id' => $contest->id, 'project_id' => $currentProject->id, 'user_id' => $this->user->identity->id])
            ->asArray()->all();

        $votesAll = Votes::find()->select('project_id')
            ->where(['contest_id' => $contest->id, 'user_id' => $this->user->identity->id])
            ->groupBy('project_id')
            ->asArray()->all();

        $votedProjects = [];

        foreach ($projects as $key => $value) {
            $votedProjects[$key] = false;
        }

//        save votes
        if ($post = Yii::$app->request->post()) {
            $data = [];

            $i = 0;
            foreach ($post['rating'] as $catId => $score) {
                if ($score < 1 || $score > $contest->range)
                    break;
                $data[$i] = [Yii::$app->user->id, $contest->id, $currentProject->id, $catId, $score];
                $i++;
            }

            if (!empty($data) && count($data) == count($contest->categories)) {

                $sql = Yii::$app->db->createCommand()->batchInsert(Votes::tableName(),
                    ['user_id', 'contest_id', 'project_id', 'category_id', 'score'], $data);
                $sql->execute();

//        if voted for all projects, then return to projects list page and show notification
                if ((count($votesAll) + 1) == count($projects)) {
                    Yii::$app->session->setFlash('success', Yii::t('main',"You completed voting"));
                    return $this->redirect(['view', 'id' => $contest->id]);
                }

//                if((count($projects)-1) == count($votesAll))


                $nextPage = ($currentPage < $pageSize) ? $currentPage + 1 : 1;
                return $this->redirect(['voting', 'id' => $contest->id, 'p' => $nextPage]);
            }
        }

        return $this->render('voting',
            [
                'contest' => $contest,
                'currentProject' => $currentProject,
                "pageSize" => $pageSize,
                'currentPage' => $currentPage,
                'votes' => $votes,
                'votesAll' => $votesAll,
                'votedProjects' => $votedProjects
            ]
        );
    }


    public function actionResult($id)
    {
        $contest = Contest::findOne(['id' => $id]);

        if (!$this->voterProject || $this->voterProject->contest_id != $id) {
            throw new \yii\web\NotFoundHttpException("Contest not found!");
        }

        if ($contest == null)
            throw new \yii\web\NotFoundHttpException("Contest not found!");

        if (time() < strtotime($contest->end_date))
            throw new ContestForbiddenException(Yii::t('main', "Voting is not finished!"));

        $query = new Query();
        $subQuery = new Query();

        $result = $query->select("SUM(total_score) as total_score, AVG(total_score) as avg_score, project_id")
            ->from(
                $subQuery->select("project_id, sum(score) as total_score")
                    ->from(Votes::tableName())->groupBy('user_id, project_id')
            )->groupBy("project_id")->all();


        $votes = Votes::find()
            ->select('sum(score) as score, project_id')
            ->where(['contest_id' => $contest->id])
            ->groupBy('project_id')->asArray()->all();

        /**
         * select SUM(total_score), AVG(total_score) from
         * (SELECT user_id, project_id, sum(score) as total_score FROM `votes` GROUP by user_id, project_id
         * ORDER BY `votes`.`project_id`, user_id ASC) result
         * GROUP BY project_id
         */

        return $this->render('results',
            [
                'contest' => $contest,
                'votes' => $votes,
                'result' => $result
            ]);
    }

    public function actionProjectResult($id, $cid)
    {
        $data = [];

        $contest = Contest::findOne(['id' => $cid]);

        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException();
        }

        if ($contest == null)
            throw new \yii\web\NotFoundHttpException("Contest not found!");

        if (time() < strtotime($contest->end_date))
            throw new ContestForbiddenException(Yii::t('main', "Voting is not finished!"));

        $votes = Votes::find()->select('category_id, avg(score) as score')
            ->where(['project_id' => $id])->groupBy('category_id')->asArray()->all();

        if (!$votes)
            throw new \yii\web\NotFoundHttpException("No votes!");

        $categories = implode(",", array_column($votes, 'category_id'));
        $criteria = Category::find()->where("id in ($categories)")->all();

        return $this->renderPartial('project_result', ['votes' => $votes, "criteria" => $criteria]);
    }
}
