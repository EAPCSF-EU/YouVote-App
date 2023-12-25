<?php

namespace backend\models;

use common\models\Project;
use common\models\Votes;
use yii\db\Query;

class NewAlgorithm
{
    public function calculate($contest): array
    {
        // Define your lower and upper thresholds
        $L = ($contest->lower_threshold) ? $contest->lower_threshold / 100 : 0.3; // Lower threshold
        $U = ($contest->upper_threshold) ? $contest->upper_threshold / 100 : 0.8; // upper threshold
        $contestId = $contest->id;

        $result = (new Query())
            ->select("COUNT(DISTINCT(project_id)) AS cnt, user_id")
            ->from(Votes::tableName())
            ->where(['contest_id' => $contestId])
            ->groupBy(['user_id'])
            ->all();

        $totalProjects = Project::find()->where(['contest_id' => $contestId])
            ->count();


        $userWeights = [];
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
        }

        $votes = (new Query())
            ->select('SUM(score) as score_sum, user_id, project_id, category_id')
            ->from(Votes::tableName())
            ->where(['contest_id' => $contestId])
            ->groupBy(['project_id', 'category_id', 'user_id'])
            ->all();

        $projectScores = [];
        foreach ($votes as $row) {
            $projectScores[$row['project_id']][$row['category_id']]['votes_count'] = 1;
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
    }
}