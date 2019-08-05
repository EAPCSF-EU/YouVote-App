<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerJsFile("@web/js/jquery.disableAutoFill.min.js",[
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
$(function() {
    $('#login-form').disableAutoFill({
        passwordField: '#voterloginform-password'
    });
});

JS;
$this->registerJs($js, \yii\web\View::POS_READY);


?>
<div class="site-login">
    <h2 class="text-center"><?= Yii::t('main', 'Hi!') ?></h2>
    <p class="text-center"><?= Yii::t('main', 'Please enter your login and password here') ?></p>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'login-form','options'=>['autocomplete'=>'off'],
                'fieldConfig' => ['template' => "{beginWrapper}\n{input}\n{hint}\n{endWrapper}"]
            ]); ?>
            <?= $form->errorSummary($model,['header'=>'']); ?>


            <?= $form->field($model, 'email')->input('email', ['placeholder' => Yii::t('main','Email')]) ?>
            <br>
            <?= $form->field($model, 'password')->input('text', ['placeholder' => Yii::t('main','Password')]) ?>

            <!--                --><? //= $form->field($model, 'rememberMe')->checkbox() ?>
            <div class="text-center" style="color:#999;margin:1em 0">
                <?= Html::a(Yii::t('main', 'Forgot your password?'), ['site/request-password-reset']) ?>
            </div>
            <br>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('main', 'Login'), ['class' => 'btn btn-custom btn-custom-primary btn-block', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
