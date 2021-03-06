<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\Contest */

$this->title = Yii::t('main', 'Create Contest');
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contest-create">
    <br>
        <div class="row">
        <div class="center-block" style="width: 60%; min-width: 800px;">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="wizard-item">
                <div class="pull-left wi-1">
                    <h3 class="box-title"><?= Yii::t('main', 'Contest details') ?></h3>
                </div>
                <div class="pull-left wi-2">
                    <h3 class="box-title" style="color: #333"><?= Yii::t('main', 'Step 1 of 3') ?></h3>
                </div>
                <div class="pull-right wi-3">
                    <button class="btn btn-primary" id="contest-form-submit">
                        <?= Yii::t('main', 'Save & Continue') ?>&ensp;<i class="glyphicon glyphicon-chevron-right"></i>
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="panel-body">
            <?= $this->render('_form', [
                'model' => $model,
                'new' => 1
            ]) ?>
        </div>
    </div>
</div>
</div>
</div>
