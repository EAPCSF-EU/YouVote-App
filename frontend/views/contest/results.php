<?php

/* @var $this yii\web\View */

use yii\bootstrap\Modal;

$this->title = Yii::t('main', 'Projects');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$projects = $contest->getProjects()->all();

?>
<style>
.wrap > .container{
    padding-top: 0px !important;
}
</style>

    <div class="contest">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="text-center">
                    <?php 
                        echo $contest->title;
                    ?>
                </h3>
                <br>
                <p class="text-center">
                    <?php
                    echo "<span class='label label-custom label-custom-primary label-custom-lg'>"
                        . Yii::t('main', 'The voting ended') . "</span>";
                    ?>
                </p>
                <br>
                <h2 class="text-center"><?= Yii::t('main', "Voting Results"); ?></h2>

                <br>
                <div style="margin: 0 auto">
                    <table class="table table-hover projects">
                        <?php
                        //print_r($votes);
                        foreach ($projects as $key => $project) {
                            $index = array_search($project->id, array_column($result, 'project_id'));

                            echo "<tr data-id='$project->id'>";
                            echo "<td>$project->title</td>";

                            if (is_numeric($index) && $index >= 0) {
//                                echo $index . "=" . $result[$index]['avg_score'] . "<br>";
                                echo "<td class='vote-result'>" . round($result[$index]['avg_score'], 2) . "</td>";
                            } else
                                echo "<td class='vote-result'>0</td>";

                            echo "</tr>";
                            ?>
                            <?php
                        }
                        ?>
                        <tr>
                            <td colspan="2"></td>
                        </tr>
                    </table>

                </div>
                <p class="text-center">
                    <?php
                    Modal::begin([
                        'header' => '<h4 class="text-center" id="result-modal-header"></h4>',
                        'id' => 'result-modal',
                        'size' => Modal::SIZE_SMALL,
                    ]);
                    echo "<div class='modal-body' id='result-modal-body'></div>";
                    Modal::end()
                    ?>
                </p>
            </div>
        </div>
    </div>
<?php
$script = <<<JS

    $(function(){
        $('.projects tr').click(function(){
            
            var id = $(this).attr('data-id');
            var title = $(this).children(':first').html();
            
            var url = '/contest/project-result/'+id;
             $.ajax({
                type: "GET",
                url: url,
                data: {"cid":$contest->id},
                // dataType: 'json',
                success: function(data) {
                    // get the ajax response data
                    // var data = res.body;
                    // update modal content
                    $('#result-modal-header').text(title);
                    $('#result-modal-body').html(data);
                    // show modal
                    $('#result-modal').modal('show');
                },
                error:function(request, status, error) {
                    $('#result-modal-body').html("<p>No Results Found</p>");
                    $('#result-modal').modal('show');
                    console.log("ajax call went wrong:" + request.responseText);
                    console.log(error)
                }
            });
        });
    });
JS;
$this->registerJs($script);
?>