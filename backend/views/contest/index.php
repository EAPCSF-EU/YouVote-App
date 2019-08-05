<?php

use common\models\Contest;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ContestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('main', 'Contests');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="contest-index">
        <br>
        <div class="row">
            <div class="col-sm-10">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <span style="font-weight: bold; font-size: 1.2em"><?= Html::encode($this->title) ?></span>

                        <!-- <div class="pull-right"> -->
                        <?= Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]) ?>
                        <!-- </div> -->

                    </div>
                    <div class="panel-body" style="overflow: visible">
                        <div class="col-sm-12">
                            <?= Html::a(Yii::t('main', '<i class="fa fa-plus fa-lg"></i> &ensp;' . Yii::t('main', 'Create contest')), ['create'], ['class' => 'btn btn-success']) ?>
                            <div class="pull-right form-group" style="margin-bottom: 0">
                                <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']) ?>
                                <?= $form->field($searchModel, 'title_en')->textInput(['placeholder' => Yii::t('main', 'Search contest')])->label(false) ?>
                                <?php ActiveForm::end() ?>
                            </div>
                        </div>

                        <div class="col-sm-12">

                            <hr>
                        </div>
                        <div class="col-sm-12">
                            <?php
                            if (count($dataProvider->getModels()) < 1) {
                                echo "<div class='alert alert-warning'>" . Yii::t('main', 'No contest is found!') . "</div>";
                            }
                            ?>
                            <?php foreach ($dataProvider->getModels() as $model) {
                                /** @var $model Contest */
                                ?>
                                <div class="contest-item">
                                    <div class="pull-left c-image">
                                        <img src="<?= $model->imageLink ?>" alt="" class="img-responsive">
                                    </div>
                                    <div class="pull-left c-title">
                                        <?php
                                        if (count($model->categories) < 2 || count($model->projects) < 2) {
                                            echo '<span class="label label-warning label-incompleted">' . Yii::t('main', 'Incompleted') . '</span>';
                                        }
                                        echo " ";
                                        if (!$model->public) {
                                            echo '<span class="label label-warning label-incompleted">' . Yii::t('main', 'Unpublished') . '</span>';
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
                                    <div class="pull-right c-status">
                                        <?php
                                        if (count($model->categories) >= 2 && count($model->projects) >= 2)
                                            echo '<h4 style="margin: 0 0 8px 0; padding: 0"><span class="label label-' . $model->dateStatusData['class'] . '">' . $model->dateStatusData['label'] . '</span></h4>';
                                        ?>
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr>
                                </div>
                            <?php } ?>
                        </div>
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
<?php
$js = <<<JS

    $('span[class^="date_"]').each(function(i,e) {
        this.innerHTML = convertToMDYHMA(changeToCurrentTimeZone(this.innerHTML));
    })
JS;
$this->registerJs($js, View::POS_READY);
?>