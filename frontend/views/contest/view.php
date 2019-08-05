<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::t('main', 'Projects');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$time_left = strtotime($contest->end_date) - time();
?>
<style>
.wrap > .container{
    padding-top: 0px !important;
}
</style>
<script type="text/javascript">
    var time_left=<?=$time_left?>;
</script>
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
                echo "<span class='label label-custom label-custom-primary label-custom-lg'>" . Yii::t('main', 'The voting ends in')
                    . " <span style='font-size:1.3em;padding:5px 0;'>" . gmdate("H:i:s", strtotime($contest->end_date) - time()) . "</span></span>";
                ?>
            </p>
            <br>
            <h2 class="text-center"><?= Yii::t('main', "List of projects"); ?></h2>
            <p class="text-center">
                <?= Yii::t('main', 'Remember that you can vote for each project only once and the voting cannot be undone'); ?>
            </p>
            <br>
            <div style="margin: 0 auto">
                <table class="table table-hover projects">
                    <?php

                    foreach ($projects as $key=>$project) {
                        echo "<tr>";
                        echo "<td>".Html::a($project->title, ['voting', 'id'=>$contest->id, 'p'=>($key+1)])."</td>";

                        $isVoted = array_search($project->id, array_column($votes,'project_id'));

                        if(isset($isVoted) && $isVoted>-1)
                            echo "<td><i class='fa fa-check-circle voted' aria-hidden='true'></i></td>";
                        else
                            echo "<td><i class='fa fa-ellipsis-h unvoted' aria-hidden='true'></i></td>";


                        echo "</tr>";
                        ?>
                        <?php
                    }
                    ?>
                    <tr><td colspan="2"></td></tr>
                </table>
            </div>
            <p class="text-center">
                <?php
                if(count($projects) == count($votes)){
                    echo "<a href='/contest/voting/$contest->id' class='btn btn-custom btn-custom-secondary'>".Yii::t('main','See your votes')."</a>";
                }
                else
                    echo "<a href='/contest/voting/$contest->id' class='btn btn-custom btn-custom-secondary'>".Yii::t('main','Start voting')."</a>";
                ?>
            </p>
        </div>
    </div>
</div>
<?php 

$script = <<<JS
        $(function ($) {
            setInterval(function() {
            time_left --;
            if(time_left<=0) {
                clearInterval(this);
            }
            if(time_left/60 < 15){
                console.log(time_left);
                if(time_left % 60 == 0){
                    $.notify({
                        title: '',
                        message: 'Voting will finish in ' + (time_left/60) +' minutes',
                        offset: {
                            x: 50,
                            y: 200
                        }
                    },
                    {
                        delay: 30000,
                    }
                    );
                }
            }
        }, 1000);

     }); 
JS;

$this->registerJs($script);
?>