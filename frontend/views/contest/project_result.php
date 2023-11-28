<?php

echo "<div class='row'>";

echo "<div class='col-sm-12'>
    <p class='text-center score'>".array_sum(array_column($votes,'score'))."</p>
</div>";
foreach ($criteria as $key => $value) {
    $index = array_search($value->id, array_column($votes, 'category_id'));

    echo "<div class='col-sm-6'>";
    echo "<p class='title text-center'>" . $value->title . "</p>";
    echo "<p class='score text-center'>" . round($votes[$index]['score'], 2) . "</p>";
    echo "</div>";
}

echo "</div>";