<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<style>
.wrap > .container{
    padding-top: 0px !important;
}
</style>

<div class="site-index">
    <div class="row">
        <div class="col-sm-12">
            <br>
            <?php


            foreach ($this->context->voter->projects as $project) {
                /** @var $project \common\models\Project */
                $contest = $project->contest;
                if(!$contest) 
                    continue;
                ?>
                <div class="panel panel-custom">
                    <div class="panel-heading">
                        <div class="col-sm-8">
                        <div class="pull-left">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            <b><?= $contest->title; ?></b>
                        </div>
                        </div>
                        <div class="col-sm-4">
                        <div class="pull-right">
                            <?php
                            if (time() < strtotime($contest->start_date))
                                echo "<span class='label label-info'>" . Yii::t('main', 'upcoming') . "</span>";
                            elseif (time() >= strtotime($contest->start_date) && time() <= strtotime($contest->end_date)) {
                                echo "<span class='label label-custom label-custom-info'>" . Yii::t('main', 'voting is started') . "</span>";
//                                echo "<span class='label label-custom label-custom-primary'>" . Yii::t('main', 'The voting ends in ')
//                                    . "<span style='font-size:1.3em;padding:5px 0;'>" . gmdate("H:i:s", strtotime($contest->end_date) - time()) . "</span></span>";
                            } else
                                echo "<span class='label label-warning'>" . Yii::t('main', 'closed') . "</span>";
                            ?>
                        </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <p class="text-center">
                            <?php

                            ?>
                        </p>
                        <?//= Yii::t('main', 'About the contest'); ?><!--</b></p>-->
                        <div class="col-sm-12">
                        <?php
                        if ($contest->image)
                            echo "<img src='/files/images/$contest->image' alt='$contest->title' title='$contest->title' align='left' class='img-responsive' style='margin: 0 10px 10px 0; width: 25%;' />";

                        echo $contest->description
                        ?>
                        </div>

                        <hr>
                        <p>
                        <div class="col-sm-2">
                            <b style=""><?= Yii::t('main', 'Start Date'); ?></b>:
                        </div>
                        <div class="col-sm-10">
                            <?#= Date("l, F j Y g:i A", strtotime($contest->start_date)) ?>
                            <span class="date_<?= $contest->id ?>"><?= $contest->start_date ?></span>
                        </div>
                        <div class="col-sm-2">
                            <b style=""><?= Yii::t('main', 'End Date'); ?></b>:
                        </div>
                        <div class="col-sm-10">
                            <span class="date_<?= $contest->id ?>"><?= $contest->end_date ?></span>
                            <?#= Date("l, F j Y g:i A", strtotime($contest->end_date)) ?>
                        </div>
                        <div class="clearfix"></div>
                        </p>
                        <hr>

                        <?php
                        if (time() <= strtotime($contest->end_date))
                            echo "<p class='alert alert-danger'>" . Yii::t('main', 'Remember that you can vote for each project only once and the voting cannot be undone') . "</p>";
                        else
                            echo "<p class='alert alert-danger'>" . Yii::t('main', 'Voting is closed') . "</p>";
                        ?>

                        <br>
                        <p class="text-center">
                            <?php
                            if (time() < strtotime($contest->start_date))
                                echo "<button class='btn btn-custom btn-custom-secondary disabled'>" .
                                    Yii::t('main', 'Voting is not started yet') . "</button>";
                            elseif (time() >= strtotime($contest->start_date) && time() <= strtotime($contest->end_date))
                                echo "<a href='/contest/view/$contest->id' class='btn btn-custom btn-custom-secondary'>" .
                                    Yii::t('main', 'Go To Voting') . "</a>";
                            else
                                echo "<a href='/contest/result/$contest->id' class='btn btn-custom btn-custom-secondary'>" .
                                    Yii::t('main', 'Voting results') . "</a>";
                            ?>
                        </p>

                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php
$js = <<<JS

    $('span[class^="date_"]').each(function(i,e) {
        this.innerHTML = convertToWMDYHMA(changeToCurrentTimeZone(this.innerHTML));
    })
JS;
$this->registerJs($js, \yii\web\View::POS_READY);
?>