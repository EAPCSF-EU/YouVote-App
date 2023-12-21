<?php

use common\models\Contest;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ContestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('main', 'Contests');
$this->params['breadcrumbs'][] = $this->title;
?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="col-sm-6">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                </div>
            </div>
        </div>
    </section>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-light">
                        <div class="card-body" style="overflow: visible">
                            <div class="row">
                                <div class="col-8">
                                    <?= Html::a(Yii::t('main', '<i class="fa fa-plus fa-lg"></i> &ensp;' . Yii::t('main', 'Create contest')), ['create'], ['class' => 'btn btn-success']) ?>
                                </div>
                                <div class="col-4">
                                    <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']) ?>
                                    <?= $form->field($searchModel, 'title_en')->textInput(['placeholder' => Yii::t('main', 'Search contest')])->label(false) ?>
                                    <?php ActiveForm::end() ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <hr>
                            </div>
                        </div>

                        <?php
                        if (count($dataProvider->getModels()) < 1) {
                            echo "<div class='alert alert-warning'>" . Yii::t('main', 'No contest is found!') . "</div>";
                        }
                        ?>
                        <?php foreach ($dataProvider->getModels() as $model) {
                            /** @var $model Contest */
                            ?>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-3">
                                        <img src="<?= $model->imageLink ?>" alt="" class="img-responsive">
                                    </div>
                                    <div class="col-7">
                                        <div class="pull-left c-title">
                                            <?php
                                            if (count($model->categories) < 2 || count($model->projects) < 2) {
                                                echo '<span class="mb-2 badge badge-warning">' . Yii::t('main', 'Incompleted') . '</span>';
                                            }
                                            echo " ";
                                            if (!$model->public) {
                                                echo '<span class="mb-2 badge badge-warning">' . Yii::t('main', 'Unpublished') . '</span>';
                                            }
                                            ?>
                                            <h4>
                                                <?= Html::a($model->title, ["/contest/view/", 'id' => $model->id]) ?>
                                            </h4>
                                            <span class="" style="color:#555; font-weight: normal">
                                                <span class="date_<?= $model->id ?>"><?= $model->start_date ?></span>
                                                <span style='color:#777;'>to</span>
                                                <span class="date_<?= $model->id ?>"><?= $model->end_date ?></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-2 text-right">
                                        <?php
                                        if (count($model->categories) >= 2 && count($model->projects) >= 2)
                                            echo '<h4 class="mr-4"><span class="badge badge-' . $model->dateStatusData['class'] . '">' . $model->dateStatusData['label'] . '</span></h4>';
                                        ?>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        <?php } ?>

                        <div class="col-sm-12">
                            <?= LinkPager::widget([
                                'pagination' => $dataProvider->pagination
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

<?php
$js = <<<JS

    $('span[class^="date_"]').each(function(i,e) {
        this.innerHTML = convertToMDYHMA(changeToCurrentTimeZone(this.innerHTML));
    })
JS;
$this->registerJs($js, View::POS_READY);
?>