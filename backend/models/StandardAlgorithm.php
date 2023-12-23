<?php

namespace backend\models;

use common\models\Project;
use common\models\Votes;
use yii\db\Query;

class StandardAlgorithm
{
    public function calculate($contest): array
    {
        // Define your lower and upper thresholds
        $query2 = new Query();
        $results_by_category = $query2
            ->select("SUM(score) as total, category_id, project_id, count(id) as votes_count")
            ->from(Votes::tableName())
            ->where(['contest_id' => $contest->id])
            ->groupBy("category_id, project_id")->all();
        return $results_by_category;
    }
}