<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = Yii::t('main', 'Security');
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
                                <?= $form->field($model, 'current_password')->passwordInput(['required' => 'required']) ?>
                                <?= $form->field($model, 'new_password')->passwordInput(['required' => 'required']) ?>
                                <?= $form->field($model, 'repeat_password')->passwordInput(['required' => 'required']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
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
