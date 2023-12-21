<?php

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = Yii::t('main', 'Account details');
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
                <div class="row">
                    <div class="col-3">
                        <?= $this->render("menu"); ?>
                    </div>
                    <div class="col-8">

                        <?php $form = ActiveForm::begin([
                            'id' => 'contest-form',
                            'layout' => 'horizontal'
                        ]); ?>
                        <div class="card card-default">
                            <div class="card-header">
                                <span style="font-weight: bold; font-size: 1.2em"><?= Html::encode($this->title) ?></span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <?= Html::submitButton('<i class="fa fa-check"></i> ' . Yii::t('main', 'Save'), [
                                    'id' => 'contest-form-submit',
                                    'class' => 'btn btn-primary pull-right']) ?>

                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
