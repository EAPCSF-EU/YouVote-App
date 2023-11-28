<?php


/* @var $this yii\web\View */

/* @var $model common\models\Contest */

use yii\bootstrap4\Html;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//\yii\web\YiiAsset::register($this);
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
                        <div class="card card-light">
                            <div class="card-header">
                                <div class="d-flex justify-content-between bd-highlight pt-1">
                                    <?= Html::a('<i class="fa fa-chevron-left"></i> ' .
                                        Yii::t('main', 'Overview'), ['view', 'id' => $model->id], ['class' => 'btn btn-success text-white']) ?>

                                    <?= Html::submitButton('<i class="fa fa-check"></i> ' . Yii::t('main', 'Save'), [
                                        'id' => 'contest-form-submit',
                                        'class' => 'btn btn-primary pull-right']) ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <?= $this->render('_form', ['model' => $model, "new" => false]); ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
