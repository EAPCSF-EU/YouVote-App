<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\Contest */
/* @var $new boolean */

$this->title = Yii::t('main', 'Update Contest: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('main', 'Update');
?>
<div class="contest-update">
<br>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="wizard-item">
                <div class="pull-left wi-1">
                    <h3 class="box-title"><?= Yii::t('main', 'Contest details') ?></h3>
                </div>
                <div class="pull-left wi-2">
                    <h3 class="box-title"><?= Yii::t('main', 'Step 1 of 3') ?></h3>
                </div>
                <div class="pull-right wi-3">
                    <button class="btn btn-primary" id="contest-form-submit">
                        <?= Yii::t('main', 'Save & Continue') ?>&ensp;<i class="glyphicon glyphicon-chevron-right"></i>
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="box box-solid">
            <div class="panel-body">
                <?= $this->render('_form', [
                    'model' => $model,
                    'new' => $new ? 1 : 0
                ]) ?>
            </div>
        </div>
    </div>
</div>
