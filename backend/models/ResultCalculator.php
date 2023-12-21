<?php

namespace backend\models;

use common\models\Project;
use common\models\Votes;
use yii\db\Query;

class ResultCalculator
{

    public function calculate($contestId)
    {
        // Define your lower and upper thresholds
        $L = 0.3; // Lower threshold
        $U = 0.8; // Upper threshold

//        SELECT DISTINCT user_id, project_id, score FROM votes
        $result = (new Query())
            ->select("COUNT(DISTINCT(project_id)) AS cnt, user_id")
            ->from(Votes::tableName())
            ->where(['contest_id' => $contestId])
            ->groupBy(['user_id'])
            ->all();

        $totalProjects = Project::find()->where(['contest_id' => $contestId])
            ->count();


        // Initialize arrays to store user ratings and weights
        $userWeights = [];
//        echo "<pre>";
//        echo "L = " . $L . "<br>";
//        echo "U = " . $U . "<br>";
//        echo "<hr>";
        foreach ($result as $row) {
            $user_id = $row['user_id'];

            // Calculate Ru for each user
            $totalProjectsRatedByUser = $row['cnt'];
            $Ru = $totalProjectsRatedByUser / $totalProjects;


            // Calculate user weight (Wu) based on Ru
            if ($Ru < $L) {
                $Wu = 0;
            } elseif ($Ru >= $L && $Ru < $U) {
                $Wu = $Ru / $U;
            } else {
                $Wu = 1;
            }

            $userWeights[$user_id] = $Wu;

//            echo "user = " . $user_id . "<br>";
//            echo "total_projects = " . $totalProjects . "<br>";
//            echo "total_projects_rated_by_user = " . $totalProjectsRatedByUser . "<br>";
//            echo "Ru = " . $Ru . "<br>";
//            echo "weight = " . $Wu . "<br><br>";
        }
//        echo "</pre>";
//        echo "<hr>";

        $votes = (new Query())
            ->select('SUM(score) as score_sum, user_id, project_id, category_id, count(*) as cnt')
            ->from(Votes::tableName())
            ->where(['contest_id' => $contestId])
            ->groupBy(['project_id', 'category_id', 'user_id'])
            ->all();
//        print_r($votes);exit();

        $projectScores = [];
        foreach ($votes as $row) {
            $projectScores[$row['project_id']][$row['category_id']]['votes_count'] = 0;
            $score = $row['score_sum'] * $userWeights[$row['user_id']];

            if (isset($projectScores[$row['project_id']][$row['category_id']]['score'])) {
                $projectScores[$row['project_id']][$row['category_id']]['score'] += $score;
                if ($userWeights[$row['user_id']] > 0) {
                    $projectScores[$row['project_id']][$row['category_id']]['votes_count'] += 1;
                }
            } else {
                $projectScores[$row['project_id']][$row['category_id']]['score'] = $score;
                if ($userWeights[$row['user_id']] > 0) {
                    $projectScores[$row['project_id']][$row['category_id']]['votes_count'] = 1;
                }
            }
        }

        $result = [];
        $i = 0;
        foreach ($projectScores as $projectId => $projectScore) {
            foreach ($projectScore as $catId => $score) {
                $result[$i]['project_id'] = $projectId;
                $result[$i]['category_id'] = $catId;
                $result[$i]['total'] = $score['score'];
                $result[$i]['votes_count'] = $score['votes_count'];
                $i++;
            }
        }

        return $result;
//        print_r($projectScores);
//            $project_id = $row['project_id'];
//            $projectScore = 0;
//            $totalWeight = 0;
//
//            foreach ($userRatings as $user_id => $ratings) {
//                if (array_key_exists($project_id, $ratings)) {
//                    $projectScore += $ratings[$project_id] * $userWeights[$user_id];
//                    $totalWeight += $userWeights[$user_id];
//                }
//            }
//
//            if ($totalWeight > 0) {
//                $finalScore = $projectScore / $totalWeight;
//                echo "Aggregated Score for Project $project_id: $finalScore<br>";
//            } else {
//                echo "No votes for Project $project_id<br>";
//            }
//        }

//        exit();

//        $results_by_category = (new Query())
//            ->select("SUM(score) as total, category_id, project_id, count(id) as votes_count")
//            ->from(Votes::tableName())
//            ->where(['contest_id' => $contestId])
//            ->groupBy("category_id, project_id")->all();
    }
}