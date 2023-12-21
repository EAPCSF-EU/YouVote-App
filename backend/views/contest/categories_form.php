<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>

<p style="font-weight: bold">
    <?=Yii::t('main','What criteria do you want your participants to vote on? You must setup at least one. Voters will be rating all criteria for every project using a 1-10 rating system. Then results will be aggregated to produce points and rankings.')?>
</p>
<hr>
<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12">
        <?php $form = ActiveForm::begin([
            'id' => 'project-form',
            'action' => Url::to(['save-category','id' => $model->id])
        ]) ?>
        <div id="project-inputs">
            <div class="row">
                <div class="col-sm-4">
                    <p class="text-right"><?=$categoryModel->attributeLabels()['title_en']?></p>
                </div>
                <div class="col-sm-8">
                    <?=$form->field($categoryModel, 'title_en')->textInput(['maxlength' => true])->label(false)?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <p class="text-right"><?=$categoryModel->attributeLabels()['title_ru']?></p>
                </div>
                <div class="col-sm-8">
                    <?=$form->field($categoryModel, 'title_ru')->textInput(['maxlength' => true])->label(false)?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6"></div>
            <div class="col-lg-6 col-md-6">
                <div class="loading-2">
<!--                    <img src="/default/loading.svg" alt="loading">-->
                    <?=Html::img('/admin/default/loading.svg');?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6">
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('main', 'Add criteria'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>

    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="contest-projects-list">
            <?php foreach ($model->categories as $category) { ?>
                <div class="contest-project-item">
                    <div class="pull-left">
                        <p><?=$category->title?></p>
                    </div>
                    <div class="pull-right">
                        <a href="javascript:void(0);" onclick="return deleteProject($(this));" class="delete" data-id="<?=$category->id?>"><i class="glyphicon glyphicon-trash"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
