<?php
use yii\helpers\Html;

if(isset($download_to_excel) && $download_to_excel==true){
    $filename = $contest->title.".xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Pragma: no-cache"); 
    header("Expires: 0");
}
echo "<table class='table table-bordered'>";
echo "<tr>";
echo "<th></th>";
foreach($contest->categories as $category){
    echo "<th>".$category->title."</th>";
}

echo "<th>".Yii::t('main','Total')."</th>";
echo "<th>".Yii::t('main','Average Score')."</th>";
echo "<th>".Yii::t('main','Number of votes')."</th>";

if($is_download_button_visible)
    echo "<th>".Yii::t('main','Download')."</th>";

echo "</tr>";
foreach($contest->projects as $project){
    echo "<tr>";

    echo "<td>".$project->title."</td>";
    $total_sum = 0; 
    $votes_count = 0;

    foreach($contest->categories as $category){
        $not_null = false;
        foreach($results_by_category as $category_result){
            if($category->id == $category_result['category_id'] && $project->id == $category_result['project_id']){
                echo "<td>".$category_result['total']."</td>";
                $total_sum += $category_result['total'];
                $votes_count = $category_result['votes_count'];
                $not_null = true;
            }
        }
        if(!$not_null) 
            echo "<td>0</td>";
    }
    echo "<td>" . $total_sum . "</td>";
    $avg_score = ($votes_count!=0)?round ($total_sum / $votes_count, 2):0;
    echo "<td>" . $avg_score . "</td>";
    echo "<td>" . $votes_count . "</td>";
    
    if($is_download_button_visible) 
        echo "<th style='min-width: 140px'>".Html::a('<i class="fa fa-file-excel"></i> '.Yii::t('main', 'Download'), ['download','id'=>$project->id], ['class' => 'btn btn-success'])."</th>";
    echo "</tr>";
    
}
echo "</table>";
?>