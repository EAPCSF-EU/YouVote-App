<?php

use yii\helpers\Html;

$this->title = $contest->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-3">
                        <?= $this->render("menu", ['model' => $contest]); ?>
                    </div>
                    <div class="col-9">
                        <div class="card card-light">
                            <div class="card-header">
                                <div class="d-flex justify-content-between bd-highlight pt-1">
                                    <div>
                                        <?= Html::a('<i class="fa fa-chevron-left"></i> ' . Yii::t('main', 'Overview'),
                                            ['view', 'id' => $contest->id], ['class' => 'btn btn-info text-white']) ?>
                                    </div>
                                    <h3 class="text-center">
                                        <?= Yii::t('main', 'Results') ?>
                                    </h3>
                                    <div>
                                        <div class="text-center">
                                            <?= Html::a('<i class="fa fa-file-excel"></i> ' . Yii::t('main', 'Download summary'), ['', 'id' => $contest->id, 'download' => 'true'], ['class' => 'btn btn-success text-white']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <hr>
                                <div class="col-sm-12">
                                    <?php
                                    echo Yii::$app->controller->renderPartial('summary_table',
                                        [
                                            'contest' => $contest,
                                            'results_by_category' => $results_by_category,
                                            'is_download_button_visible' => true
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>