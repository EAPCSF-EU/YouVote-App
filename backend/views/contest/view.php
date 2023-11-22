<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Contest */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$js = <<<JS

    var start_date = changeToCurrentTimeZone('$model->start_date');
    var end_date = changeToCurrentTimeZone('$model->end_date');

    $("#start_date").text(convertToWMDYHMA(start_date));
    $("#end_date").text(convertToWMDYHMA(end_date));

    $("publish-contest").on("click", function(e){
        e.preventDefault();

        return false;
    })

JS;

$this->registerJs($js, \yii\web\View::POS_READY);
?>
<div class="content">
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-3">

                        <?= $this->render("menu", ['model' => $model]); ?>
                    </div>

                    <div class="col-8">

                        <div class="card caret-default">
                            <div class="card-header">
                                <?= Html::a('<i class="fa fa-chevron-left"></i> ' . Yii::t('main', 'Contests'), ['/contest'], ['class' => 'btn btn-info']) ?>
                            </div>
                            <div class="card-body">
                                <h3><?= $model->title ?></h3>
                                <hr>
                                <div class="col-sm-12">
                                    <?php
                                    if ($model->image) {
                                        echo "<img src='" . $model->imageLink . "' alt='$model->title' title='$model->title'
                                align='left' class='img-responsive' style='margin: 0 10px 10px 0; width: 25%;' />";
                                    }
                                    ?>
                                    <?= $model->description ?>
                                </div>
                                <div class="clearfix"></div>
                                <hr>
                                <div class="col-sm-2">
                                    <b style=""><?= Yii::t('main', 'Start Date'); ?></b>:
                                </div>
                                <div class="col-sm-10">
                                    <span id="start_date"></span><br>
                                    <small class="text-muted"><?= Date("l, F j Y g:i A", strtotime($model->start_date)) ?>
                                        UTC</small>
                                </div>
                                <div class="clearfix"></div>
                                <hr>
                                <div class="col-sm-2">
                                    <b style=""><?= Yii::t('main', 'End Date'); ?></b>:
                                </div>
                                <div class="col-sm-10">
                                    <span id="end_date"></span><br>
                                    <small class="text-muted"><?= Date("l, F j Y g:i A", strtotime($model->end_date)) ?>
                                        UTC</small>
                                </div>
                                <div class="clearfix"></div>
                                <hr>
                                <div class="col-sm-10">
                                    <!-- <i class="fa fa-paper-plane" aria-hidden="true"></i> -->
                                    <?php
                                    if (count($model->categories) < 2 || count($model->projects) < 2) {
                                        echo "<button class='btn btn-primary' disabled='disabled'>" . Yii::t('main', 'PUBLISH') . "</button>";
                                    } elseif ($model->public)
                                        echo Html::a(Yii::t('main', 'UNPUBLISH'), ["/contest/publish/", 'id' => $model->id, 'public' => $model->public], ['class' => 'btn btn-primary']);
                                    else
                                        echo Html::a(Yii::t('main', 'PUBLISH'), ["/contest/publish/", 'id' => $model->id, 'public' => $model->public], ['class' => 'btn btn-primary']);
                                    ?>
                                    <p>
                                        <small>In order to publish the contest, you must enter at least two projects and
                                            criteria!</small>
                                    </p>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

