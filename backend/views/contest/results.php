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
                        <div class="card card-default">
                            <div class="card-header">
                                <?= Html::a('<i class="fa fa-chevron-left"></i> ' . Yii::t('main', 'Overview'),
                                    ['view', 'id' => $contest->id], ['class' => 'btn btn-info']) ?>
                            </div>
                            <div class="card-body">
                                <h3 class="text-center">
                                    <?= Yii::t('main', 'Results') ?>
                                    <?= Html::a('<i class="fa fa-file-excel-o"></i> ' . Yii::t('main', 'Download summary'), ['', 'id' => $contest->id, 'download' => 'true'], ['class' => 'btn btn-success']) ?>
                                </h3>
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