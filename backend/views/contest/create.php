<?php

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Contest */

$this->title = Yii::t('main', 'Create Contest');
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="content">
    <div class="container-fluid bg-white p-4 border">
        <div class="row">

            <div class="card card-light">
                <div class="card-header">
                    <div class="d-flex justify-content-between bd-highlight pt-1">
                        <div class="bd-highlight">
                            <h3 class="box-title">
                                <?= Yii::t('main', 'Contest details') ?></h3>

                        </div>
                        <div class="bd-highlight">
                            <h3 class="box-title"><?= Yii::t('main', 'Step 1 of 3') ?></h3>
                        </div>
                        <div class="bd-highlight">
                            <button class="btn btn-primary" id="contest-form-submit">
                                <?= Yii::t('main', 'Save & Continue') ?>&ensp;<i
                                        class="glyphicon glyphicon-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    <!--                    <div class="wizard-item">-->
                    <!--                        <div class="pull-left wi-1">-->
                    <!--                        </div>-->
                    <!--                        <div class="pull-left wi-2">-->
                    <!--                            <h3 class="box-title" style="color: #333">-->

                    <!--                        </div>-->
                    <!--                        <div class="pull-right wi-3">-->

                    <!--                        </div>-->
                    <!--                        <div class="clearfix"></div>-->
                    <!--                    </div>-->
                </div>
                <div class="card-body">
                    <?= $this->render('_form', [
                        'model' => $model,
                        'new' => 1
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
