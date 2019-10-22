<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('main','Login');

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#">Voting system<b> Admin</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?=Yii::t('main','Sign in to start your session')?></p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => Yii::t('main',$model->getAttributeLabel('username'))]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => Yii::t('main',$model->getAttributeLabel('password'))]) ?>

        <div class="row">
            <div class="col-xs-8">
                <?php echo $form->field($model, 'rememberMe')->checkbox()->label(Yii::t('main',$model->getAttributeLabel('rememberMe'))) ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton(Yii::t('main','Sign in'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

        <a href="#"><?=Yii::t('main','I forgot my password')?></a><br>
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
