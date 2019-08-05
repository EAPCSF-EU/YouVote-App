<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = Yii::t('main', 'Account details');
?>

<div class="contest-view">
    <br>
    <div class="row">
        <div class="col-sm-12">
            <div style="width: 230px; float: left;">
                <?= $this->render("menu"); ?>
            </div>
            <div class="col-sm-8">

                <?php $form = ActiveForm::begin([
                    'id' => 'contest-form',
                    'layout' => 'horizontal'
                ]); ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span style="font-weight: bold; font-size: 1.2em"><?= Html::encode($this->title) ?></span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
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
