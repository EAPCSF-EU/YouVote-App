<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

use \yii\bootstrap\ActiveForm;

$this->title = Yii::t('main', 'Voting');
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Projects'), 'url' => ['view', 'id' => $contest->id]];
$this->params['breadcrumbs'][] = $this->title;
$time_left = strtotime($contest->end_date) - time();
?>
<style>
.wrap > .container{
    padding-top: 0 !important;
}
</style>
<script type="text/javascript">
    var time_left=<?=$time_left?>;
</script>

    <div class="contest">
        <div class="row">
            <div class="col-sm-12">
                <p class="">
                    <?=Html::a(Yii::t('main', 'Go to list of projects'),['contest/view','id'=>$contest->id],['class'=>'btn btn-info'])?>
                    <?php
                    echo "<span class='pull-right label label-custom label-custom-primary label-custom-lg'>"
                        . Yii::t('main', 'The voting ends in')
                        . "<span style='font-size:1.3em;padding:5px 0;'> " . gmdate("H:i:s", strtotime($contest->end_date) - time()) . "</span></span>";
                    ?>
                </p>
                
                <p class="text-center">
                    
                </p>
                <h2 class="text-center">
                    <?= $currentProject->id."-".$currentProject->title; ?>
                </h2>

                <br>
                <?php
                $form = ActiveForm::begin([
                    'id' => 'voting-form',
                    'options' => ['class' => 'form-horizontal'],
                ]) ?>
                <div class="row" style=" margin: 0 auto">

                    <?php
                    foreach ($contest->categories as $category) {
                        ?>

                        <div class='col-sm-12'>
                            <div class='box box-green box-example-pill'>
                                <div class='box-header'><?= $category->title ?></div>

                                <div class='box-body'>
                                    <span class="poor"><?= Yii::t('main', 'Poor') ?></span>

                                    <select class='rating-pill' name='rating[<?= $category->id ?>]' autocomplete='off'>
                                        <option value=""></option>
                                        <?php
                                        for ($i = 1; $i <= $contest->range; $i++) {
                                            echo "<option value='$i'>$i</option>";
                                        }
                                        ?>
                                    </select>

                                    <span class="good"><?= Yii::t('main', 'Really Good') ?></span>

                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <br>
                <p class="text-center">
                    <?php
                    if (!empty($votes)) {
                        echo "<a class='disabled btn btn-custom btn-custom-secondary'>" . Yii::t('main', 'Already voted') . "</a>";
                    } else {
                        echo "<a id='submitVote'
                            class='btn btn-custom btn-custom-secondary'>" . Yii::t('main', 'Cast to vote') . "</a>";
                    }
                    ?>

                </p>
                <?php ActiveForm::end() ?>
                <div class="text-center">
                    <div class="pagination pagination-centered">
                        <?php
                        for ($i = 1; $i <= $pageSize; $i++) {
                            $elClass = "";

                            if ($currentPage == $i) {
                                $elClass .= "active";
                            }

                            if ($votedProjects[$i - 1]) {
                                $elClass .= " voted";
                            }

                            echo "<li><a href='?p=$i' class='$elClass'></a></li>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
?>
    <script>
        var votes = <?php echo json_encode($votes); ?>;
    </script>
<?php
$script = <<<JS
    $(function() {
    

        $("#submitVote").on('click', function(e) {
            
            var arr = $('select.rating-pill').map(function(){
                return this.value
            }).get();
            
            for(x in arr){
                if(!arr[x]){
                    alert("Please, vote for all criteria!");       
                    return false;
                }
                else if(arr[x]<1 || arr[x]>$contest->range){
                    alert("Vote score is not correct!");
                    return false;
                }
            }
            
            $("#voting-form").submit();
        })
        
        $('.rating-pill').barrating('show', {
            theme: 'bars-pill',
            initialRating: null,
            showValues: true,
            showSelectedRating: false,
            allowEmpty: true,
            emptyValue: '-- no rating selected --',
            onSelect: function(value, text) {
                // alert('Selected rating: ' + value);
            }
        });
        
        for(x in votes){
            $("select[name='rating["+votes[x].category_id+"]'").barrating('set', votes[x].score);
            $("select[name='rating["+votes[x].category_id+"]'").barrating('readonly', true);
        }

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