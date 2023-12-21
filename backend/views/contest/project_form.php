<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<p style="font-weight: bold">
    <?= Yii::t('main', 'Now you need to add projects for your participants to rate!') ?>
</p>
<hr>

<div class="col-12">
    <?php $form = ActiveForm::begin([
        'id' => 'project-form',
        'action' => Url::to(['save-project', 'id' => $model->id])
    ]) ?>
    <div id="project-inputs">
        <div class="row">
            <div class="col-4">
                <p class="text-right"><?= $projectModel->attributeLabels()['title_en'] ?></p>
            </div>
            <div class="col-8">
                <?= $form->field($projectModel, 'title_en')->textInput(['maxlength' => true])->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <p class="text-right"><?= $projectModel->attributeLabels()['title_ru'] ?></p>
            </div>
            <div class="col-8">
                <?= $form->field($projectModel, 'title_ru')->textInput(['maxlength' => true])->label(false) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="loading-2">
                <?= Html::img('/admin/default/loading.svg'); ?>
                <!--                    <img src="/default/loading.svg" alt="loading">-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('main', 'Add project'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>

<div class="col-12">
    <div class="contest-projects-list">
        <?php foreach ($model->projects as $project) { ?>
            <div class="contest-project-item">
                <div class="pull-left">
                    <p><?= $project->title ?></p>
                </div>
                <div class="pull-right">
                    <a href="javascript:void(0);" onclick="return deleteProject($(this));"
                       class="delete" data-id="<?= $project->id ?>"><i
                                class="glyphicon glyphicon-trash"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
        <?php } ?>
    </div>
</div>
