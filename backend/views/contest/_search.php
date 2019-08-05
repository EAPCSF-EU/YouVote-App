<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ContestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contest-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title_en') ?>

    <?= $form->field($model, 'description_en') ?>

    <?= $form->field($model, 'title_ru') ?>

    <?= $form->field($model, 'description_ru') ?>

    <?php // echo $form->field($model, 'start_date') ?>

    <?php // echo $form->field($model, 'end_date') ?>

    <?php // echo $form->field($model, 'public') ?>

    <?php // echo $form->field($model, 'result_panel') ?>

    <?php // echo $form->field($model, 'voters_limit') ?>

    <?php // echo $form->field($model, 'range') ?>

    <?php // echo $form->field($model, 'permalink') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('main', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('main', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
