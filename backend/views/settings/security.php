<?php

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = Yii::t('main', 'Security');
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-6">
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
                        <div class="card">
                            <div class="card-header">
                                <span style="font-weight: bold; font-size: 1.2em"><?= Html::encode($this->title) ?></span>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <?= $form->field($model, 'current_password')->passwordInput(['required' => 'required']) ?>
                                        <?= $form->field($model, 'new_password')->passwordInput(['required' => 'required']) ?>
                                        <?= $form->field($model, 'repeat_password')->passwordInput(['required' => 'required']) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <?= Html::submitButton('<i class="fa fa-check"></i> ' . Yii::t('main', 'Change password'), [
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
